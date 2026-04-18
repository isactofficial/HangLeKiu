<?php

namespace App\Http\Controllers;

use App\Models\ConsumableItem;
use App\Models\Invoice;
use App\Models\MasterProcedure;
use App\Models\Medicine;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class CashierController extends Controller
{
    // ─────────────────────────────────────────────────────────────────────────
    // 1. SEARCH PASIEN — GET /admin/cashier/search-patient?q=...
    //    Digunakan oleh modal Pembayaran Manual untuk autocomplete pasien.
    // ─────────────────────────────────────────────────────────────────────────
    public function searchPatient(Request $request)
    {
        $q = trim($request->get('q', ''));

        if (strlen($q) < 2) {
            return response()->json([]);
        }

        $patients = Patient::select('id', 'full_name', 'medical_record_no', 'phone_number', 'date_of_birth')
            ->where(function ($query) use ($q) {
                $query->where('full_name', 'like', "%{$q}%")
                      ->orWhere('medical_record_no', 'like', "%{$q}%")
                      ->orWhere('phone_number', 'like', "%{$q}%");
            })
            ->whereNull('deleted_at')
            ->orderBy('full_name')
            ->limit(10)
            ->get()
            ->map(function ($p) {
                return [
                    'id'               => $p->id,
                    'full_name'        => $p->full_name,
                    'medical_record_no'=> $p->medical_record_no ?? '-',
                    'phone_number'     => $p->phone_number ?? '-',
                    'date_of_birth'    => $p->date_of_birth
                        ? \Carbon\Carbon::parse($p->date_of_birth)->format('d-m-Y')
                        : '-',
                ];
            });

        return response()->json($patients);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // 2. SEARCH ITEM — GET /admin/cashier/search-item?q=...&depot=...
    //    Mencari tindakan (MasterProcedure), obat (Medicine), dan BHP (ConsumableItem).
    //    Depot: 'apotek' → obat+bhp; 'klinik'/'lab' → tindakan+bhp; default → semua
    // ─────────────────────────────────────────────────────────────────────────
    public function searchItem(Request $request)
    {
        $q     = trim($request->get('q', ''));
        $depot = $request->get('depot', 'klinik');

        if (strlen($q) < 2) {
            return response()->json([]);
        }

        $results = collect();

        // ── Tindakan (MasterProcedure) ─────────────────────────
        if (in_array($depot, ['klinik', 'lab', 'all'])) {
            $procedures = MasterProcedure::select('id', 'procedure_name', 'price')
                ->where('procedure_name', 'like', "%{$q}%")
                ->where('is_active', true)
                ->limit(6)
                ->get()
                ->map(fn($p) => [
                    'id'    => $p->id,
                    'name'  => $p->procedure_name,
                    'type'  => 'Tindakan',
                    'price' => (float) $p->price,
                ]);

            $results = $results->merge($procedures);
        }

        // ── Obat (Medicine) ────────────────────────────────────
        if (in_array($depot, ['apotek', 'all'])) {
            $medicines = Medicine::select('id', 'medicine_name', 'selling_price_general')
                ->where('medicine_name', 'like', "%{$q}%")
                ->where('current_stock', '>', 0)
                ->limit(6)
                ->get()
                ->map(fn($m) => [
                    'id'    => $m->id,
                    'name'  => $m->medicine_name,
                    'type'  => 'Obat',
                    'price' => (float) $m->selling_price_general,
                ]);

            $results = $results->merge($medicines);
        }

        return response()->json($results->take(12)->values());
    }

    // ─────────────────────────────────────────────────────────────────────────
    // 3. SIMPAN PEMBAYARAN MANUAL — POST /admin/cashier/store-manual-payment
    //    Menyimpan invoice tanpa registration_id (manual, tidak terikat EMR).
    // ─────────────────────────────────────────────────────────────────────────
    public function storeManualPayment(Request $request)
    {
        $request->validate([
            'patient_id'     => 'required|string',
            'items'          => 'required|array|min:1',
            'items.*.name'   => 'required|string',
            'items.*.qty'    => 'required|integer|min:1',
            'items.*.price'  => 'required|numeric|min:0',
            'total'          => 'required|numeric|min:0',
            'amount_paid'    => 'required|numeric|min:0.01',
            'change_amount'  => 'required|numeric|min:0',
            'debt_amount'    => 'required|numeric|min:0',
            'status'         => 'required|in:paid,partial,unpaid',
            'payment_method' => 'required|string',
            'payment_type'   => 'nullable|string|max:100',
            'cash_account'   => 'nullable|string|max:100',
            'paid_by'        => 'nullable|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            // Generate Nomor Invoice (format sama dengan storePayment)
            $datePrefix  = date('Ymd');
            $lastInvoice = Invoice::where('invoice_number', 'like', 'INV-' . $datePrefix . '-%')
                ->orderBy('invoice_number', 'desc')
                ->first();

            $nextSeq       = $lastInvoice ? ((int) substr($lastInvoice->invoice_number, -4)) + 1 : 1;
            $invoiceNumber = 'INV-' . $datePrefix . '-' . str_pad($nextSeq, 4, '0', STR_PAD_LEFT);
            $receiptNumber = 'REC-' . $datePrefix . '-' . str_pad($nextSeq, 4, '0', STR_PAD_LEFT);

            // Ringkasan item sebagai catatan teks
            $itemSummary = collect($request->items)
                ->map(fn($item) => "{$item['name']} x{$item['qty']}")
                ->implode(', ');

            $notes = ($request->paid_by ? "Dibayar oleh: {$request->paid_by}. " : '')
                   . "Item: {$itemSummary}";

            // ── Buat invoice ───────────────────────────────────
            $invoicePayload = [
                'registration_id' => null,         // Manual: tidak ada registration EMR
                'admin_id'        => Auth::id(),
                'invoice_number'  => $invoiceNumber,
                'receipt_number'  => $receiptNumber,
                'payment_type'    => $request->payment_type ?? 'Langsung',
                'payment_method'  => $request->payment_method,
                'amount_paid'     => $request->amount_paid,
                'change_amount'   => $request->change_amount,
                'debt_amount'     => $request->debt_amount,
                'status'          => $request->status,
                'rounding'        => 0,
                'notes'           => $notes,
            ];

            if (Schema::hasColumn('invoices', 'cash_account')) {
                $invoicePayload['cash_account'] = $request->cash_account;
            }

            // Simpan kolom patient_id jika sudah ada di tabel invoices
            if (Schema::hasColumn('invoices', 'patient_id')) {
                $invoicePayload['patient_id'] = $request->patient_id;
            }

            Invoice::create($invoicePayload);

            DB::commit();

            return response()->json([
                'success'        => true,
                'message'        => 'Pembayaran manual berhasil disimpan!',
                'invoice_number' => $invoiceNumber,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }

    // ─────────────────────────────────────────────────────────────────────────
    // 4. EXPORT CSV — GET /admin/cashier/export-csv
    //    Mengekspor data pembayaran (invoices) berdasarkan filter.
    // ─────────────────────────────────────────────────────────────────────────
    public function exportCsv(Request $request)
    {
        $q = trim($request->get('q', ''));
        $fromDate = $request->get('from_date');
        $toDate = $request->get('to_date');

        // Gunakan tabel invoices sebagai dasar yang valid
        $query = Invoice::query()
            ->with(['registration.patient', 'registration.doctor', 'admin'])
            ->whereIn('status', ['paid', 'partial']);

        // Filter Pendaftaran / Invoice Range Waktu
        if ($fromDate) {
            $query->whereDate('created_at', '>=', $fromDate);
        }
        if ($toDate) {
            $query->whereDate('created_at', '<=', $toDate);
        }

        // Filter Keyword
        if ($q !== '') {
            $query->where(function($subQuery) use ($q) {
                $subQuery->where('invoice_number', 'like', "%{$q}%")
                ->orWhereHas('registration.patient', function($pQuery) use ($q) {
                    $pQuery->where('full_name', 'like', "%{$q}%")
                           ->orWhere('medical_record_no', 'like', "%{$q}%");
                });
            });
        }

        // Tembak Data
        $invoices = $query->orderBy('created_at', 'desc')->get();

        $filename = "Export_Kasir_" . date('Ymd_His') . ".csv";
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = [
            'No Invoice',
            'Tanggal Input',
            'Nama Pasien',
            'No RM',
            'Dokter', 
            'Metode Pembayaran',
            'Status',
            'Total Tagihan (Rp)',
            'Jumlah Dibayar (Rp)',
            'Kembalian (Rp)',
            'Sisa Hutang (Rp)',
            'Catatan'
        ];

        $callback = function() use($invoices, $columns) {
            $file = fopen('php://output', 'w');
            
            // Tambahkan BOM untuk excel
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            fputcsv($file, $columns, ';'); // Gunakan semicolon untuk CSV Indonesia (Excel)

            foreach ($invoices as $inv) {
                $patientName = $inv->registration ? ($inv->registration->patient->full_name ?? '-') : ($inv->patient_name ?? 'Manual/Tidak Dikenal');
                $rmNumber = $inv->registration ? ($inv->registration->patient->medical_record_no ?? '-') : '-';
                $doctorName = $inv->registration ? ($inv->registration->doctor->full_name ?? '-') : '-';
                $statusLabel = $inv->status === 'paid' ? 'Lunas' : ($inv->status === 'partial' ? 'Belum Lunas' : $inv->status);

                fputcsv($file, [
                    $inv->invoice_number,
                    $inv->created_at->format('d-m-Y H:i'),
                    $patientName,
                    $rmNumber,
                    $doctorName,
                    strtoupper($inv->payment_method),
                    $statusLabel,
                    (float) ($inv->amount_paid + $inv->debt_amount - $inv->change_amount), // Approximate Total if no rounding column exists
                    (float) $inv->amount_paid,
                    (float) $inv->change_amount,
                    (float) $inv->debt_amount,
                    $inv->notes ?? '-'
                ], ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
