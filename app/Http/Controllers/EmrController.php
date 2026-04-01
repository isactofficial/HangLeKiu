<?php

namespace App\Http\Controllers;

use App\Models\Appointment; 
use App\Models\OndotogramTooth;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class EmrController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil input pencarian jika ada
        $search = $request->get('search');

        // 2. Data Pasien HARI INI (Untuk Sidebar Atas)
        $todayPatients = Appointment::with(['patient', 'doctor'])
            ->whereDate('appointment_datetime', Carbon::today())
            ->when($search, function($query) use ($search) {
                $query->whereHas('patient', function($q) use ($search) {
                    $q->where('full_name', 'like', "%{$search}%");
                });
            })
            ->orderBy('appointment_datetime', 'asc')
            ->get();

        // 3. SEMUA Data Pasien (Untuk Sidebar Bawah)
        $allPatients = Appointment::with(['patient', 'doctor'])
            ->when($search, function($query) use ($search) {
                $query->whereHas('patient', function($q) use ($search) {
                    $q->where('full_name', 'like', "%{$search}%")
                      ->orWhere('medical_record_no', 'like', "%{$search}%");
                });
            })
            ->orderBy('appointment_datetime', 'desc')
            ->paginate(15);

        // 4. Kirim ke View
        return view('admin.pages.emr', compact('todayPatients', 'allPatients', 'search'));
    }

    public function show(Request $request, $id)
    {
        // Ambil data pendaftaran beserta relasi pasien dan dokternya
        $appointment = Appointment::with(['patient', 'doctor'])->findOrFail($id);

        // Jika request datang dari AJAX (klik sidebar), kirimkan isi tengah saja
        if ($request->ajax()) {
            return view('admin.components.emr.patient-detail-partial', compact('appointment'))->render();
        }

        return redirect()->route('admin.emr');
    }

    public function indexCashier(Request $request)
    {
        // Mengambil antrean yang statusnya 'succeed' dari EMR
        $appointments = Appointment::with([
            'patient', 
            'doctor', 
            'paymentMethod', 
            'medicalProcedures.items.masterProcedure'
        ])
        ->where('status', 'succeed') 
        ->orderBy('appointment_datetime', 'desc')
        ->get();

        // Mengambil data metode pembayaran (Tunai, QRIS, dll)
        $paymentMethods = DB::table('master_payment_method')
            ->where('is_active', 1)
            ->get();

        return view('admin.pages.cashier', [
            'appointments' => $appointments,
            'paymentMethods' => $paymentMethods
        ]);
    }

public function storePayment(Request $request)
    {
        // 1. Tambahkan validasi untuk 'status'
        $request->validate([
            'registration_id' => 'required',
            'payment_method'  => 'required',
            'amount_paid'     => 'required|numeric',
            'change_amount'   => 'required|numeric',
            'debt_amount'     => 'required|numeric',
            'status'          => 'required|in:paid,partial,unpaid', // Validasi status dari JS
        ]);

        DB::beginTransaction();
        try {
            // Generate Nomor Invoice Otomatis (Format: INV-YYYYMMDD-0001)
            $datePrefix = date('Ymd');
            $lastInvoice = Invoice::where('invoice_number', 'like', 'INV-' . $datePrefix . '-%')
                                  ->orderBy('invoice_number', 'desc')
                                  ->first();
                                  
            $nextSeq = $lastInvoice ? ((int) substr($lastInvoice->invoice_number, -4)) + 1 : 1;
            $invoiceNumber = 'INV-' . $datePrefix . '-' . str_pad($nextSeq, 4, '0', STR_PAD_LEFT);
            $receiptNumber = 'REC-' . $datePrefix . '-' . str_pad($nextSeq, 4, '0', STR_PAD_LEFT);

            // 2. Simpan data transaksi ke tabel invoices, TERMASUK status
            $invoice = Invoice::create([
                'registration_id' => $request->registration_id,
                'admin_id'        => Auth::id() ?? '49f9ad75-bd0b-43ca-8a19-a9adebfd0c5f', // Menggunakan fallback ID admin jika auth kosong
                'invoice_number'  => $invoiceNumber,
                'receipt_number'  => $receiptNumber,
                'payment_type'    => 'Langsung', 
                'payment_method'  => $request->payment_method,
                'amount_paid'     => $request->amount_paid,
                'change_amount'   => $request->change_amount,
                'debt_amount'     => $request->debt_amount,
                'status'          => $request->status, // <--- INI KUNCI AGAR SAAT REFRESH TOMBOLNYA BERUBAH
                'rounding'        => 0,
                'notes'           => $request->notes,
            ]);

            // Update status pendaftaran menjadi 'succeed' atau status selesai lainnya
            Appointment::where('id', $request->registration_id)->update([
                'status' => 'succeed'
            ]);

            DB::commit();

            return response()->json([
                'success'        => true,
                'message'        => 'Pembayaran berhasil disimpan!',
                'invoice_number' => $invoiceNumber
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
            ], 500);
        }
    }
}