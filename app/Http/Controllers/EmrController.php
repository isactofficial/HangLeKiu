<?php

namespace App\Http\Controllers;

use App\Models\Appointment; 
use App\Models\Doctor;
use App\Models\DoctorNote;
use App\Models\MedicalProcedure;
use App\Models\OdontogramTooth;
use App\Models\OdontogramRecord;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Carbon\Carbon;

class EmrController extends Controller
{
    private function resolveDoctorFeeSnapshot(?string $doctorId): float
    {
        if (! $doctorId) {
            return 0.0;
        }

        return (float) (Doctor::where('id', $doctorId)->value('default_fee_percentage') ?? 0);
    }

    public function index(Request $request)
    {
        // 1. Ambil input pencarian jika ada
        $search = $request->get('search');

        // 2. Data Pasien HARI INI (Untuk Sidebar Atas)
        $todayPatients = Appointment::with(['patient', 'doctor', 'paymentMethod', 'guarantorType'])
            ->whereDate('appointment_datetime', Carbon::today())
            ->when($search, function($query) use ($search) {
                $query->whereHas('patient', function($q) use ($search) {
                    $q->where('full_name', 'like', "%{$search}%");
                });
            })
            ->orderBy('appointment_datetime', 'asc')
            ->get();

        // 3. SEMUA Data Pasien (Untuk Sidebar Bawah)
        $allPatients = Appointment::with(['patient', 'doctor', 'paymentMethod', 'guarantorType'])
            ->when($search, function($query) use ($search) {
                $query->whereHas('patient', function($q) use ($search) {
                    $q->where('full_name', 'like', "%{$search}%")
                      ->orWhere('medical_record_no', 'like', "%{$search}%");
                });
            })
            ->orderBy('appointment_datetime', 'desc')
            ->paginate(15);

        // Auto-open pasien "engaged" dari hari ini jika ada
        $autoOpenApptId = $todayPatients->firstWhere('status', 'engaged')?->id;

        // 4. Kirim ke View
        return view('admin.pages.emr', compact('todayPatients', 'allPatients', 'search', 'autoOpenApptId'));
    }

    public function show(Request $request, $id)
    {
        $hasProcedureAssistantTable = Schema::hasTable('procedure_assistant');

        $relations = [
            'patient',
            'doctor',
            'poli',
            'paymentMethod',
            'guarantorType',
            'medicalProcedures.doctor',
            'medicalProcedures.doctorNotes.user',
            'medicalProcedures.bhpUsages.item',
        ];

        if ($hasProcedureAssistantTable) {
            $relations[] = 'medicalProcedures.assistants.doctor';
        }

        // Ambil data pendaftaran beserta relasi pasien dan dokternya
        $appointment = Appointment::with($relations)->findOrFail($id);

        $patientRegistrationRelations = [
            'doctor',
            'poli',
            'medicalProcedures.items.masterProcedure',
            'medicalProcedures.medicines.medicine',
            'medicalProcedures.bhpUsages.item',
            'medicalProcedures.doctor',
            'medicalProcedures.doctorNotes.user',
        ];

        if ($hasProcedureAssistantTable) {
            $patientRegistrationRelations[] = 'medicalProcedures.assistants.doctor';
        }

        $patientRegistrations = Appointment::with($patientRegistrationRelations)
            ->where('patient_id', $appointment->patient_id)
            ->orderByDesc('appointment_datetime')
            ->get();

        $doctorNotes = $patientRegistrations
            ->flatMap(fn($registration) => $registration->medicalProcedures)
            ->flatMap(function ($procedure) use ($hasProcedureAssistantTable) {
                $assistantNames = collect();
                if ($hasProcedureAssistantTable) {
                    $assistantNames = $procedure->assistants
                        ->map(fn($assistant) => optional($assistant->doctor)->full_name)
                        ->filter()
                        ->values();
                }

                return $procedure->doctorNotes->map(function ($note) use ($assistantNames, $procedure) {
                    $noteText = (string) ($note->notes ?? '');

                    $subjective = '';
                    $objective = '';
                    $plan = '';

                    if (preg_match('/Subjective:\s*(.*?)(?=\n\n(?:Objective|Plan):|$)/s', $noteText, $m)) {
                        $subjective = trim($m[1]);
                    }
                    if (preg_match('/Objective:\s*(.*?)(?=\n\n(?:Subjective|Plan):|$)/s', $noteText, $m)) {
                        $objective = trim($m[1]);
                    }
                    if (preg_match('/Plan:\s*(.*?)(?=\n\n(?:Subjective|Objective):|$)/s', $noteText, $m)) {
                        $plan = trim($m[1]);
                    }

                    if ($subjective === '' && $objective === '' && $plan === '') {
                        $plan = trim($noteText);
                    }

                    return [
                        'id' => $note->id,
                        'created_at' => $note->created_at,
                        'created_at_label' => $note->created_at
                            ? Carbon::parse($note->created_at)->translatedFormat('d F Y H:i')
                            : '-',
                        'doctor_name' => optional($procedure->doctor)->full_name ?: (optional($note->user)->name ?: '-'),
                        'assistant_names' => $assistantNames,
                        'subjective' => $subjective,
                        'objective' => $objective,
                        'plan' => $plan,
                    ];
                });
            })
            ->sortByDesc('created_at')
            ->values();

        $odontogramRecords = OdontogramRecord::with('teeth')
            ->where('patient_id', $appointment->patient_id)
            ->orderByDesc('examined_at')
            ->get();

        // Jika request datang dari AJAX (klik sidebar), kirimkan isi tengah saja
        if ($request->ajax()) {
            return view('admin.components.emr.patient-detail-partial', compact('appointment', 'doctorNotes', 'patientRegistrations', 'odontogramRecords'))->render();
        }

        return redirect()->route('admin.emr');
    }

    public function storeDoctorNote(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'subjective' => 'nullable|string',
            'objective' => 'nullable|string',
            'plan' => 'nullable|string',
        ]);

        $subjective = trim((string) ($validated['subjective'] ?? ''));
        $objective = trim((string) ($validated['objective'] ?? ''));
        $plan = trim((string) ($validated['plan'] ?? ''));

        if ($subjective === '' && $objective === '' && $plan === '') {
            return response()->json([
                'success' => false,
                'message' => 'Isi minimal salah satu Subjectives, Objectives, atau Plans.',
            ], 422);
        }

        DB::beginTransaction();

        try {
            $procedure = $appointment->medicalProcedures()
                ->orderByDesc('created_at')
                ->first();

            if (! $procedure) {
                $procedurePayload = [
                    'id' => (string) Str::uuid(),
                    'registration_id' => $appointment->id,
                    'patient_id' => $appointment->patient_id,
                    'doctor_id' => $appointment->doctor_id,
                    'discount_type' => 'none',
                    'discount_value' => 0,
                    'total_amount' => 0,
                    'notes' => 'Auto-created for doctor note entry',
                ];

                if (Schema::hasColumn('medical_procedure', 'doctor_fee_percentage_snapshot')) {
                    $procedurePayload['doctor_fee_percentage_snapshot'] = $this->resolveDoctorFeeSnapshot($appointment->doctor_id);
                }

                $procedure = MedicalProcedure::create($procedurePayload);
            }

            $sections = [];
            if ($subjective !== '') {
                $sections[] = "Subjective:\n{$subjective}";
            }
            if ($objective !== '') {
                $sections[] = "Objective:\n{$objective}";
            }
            if ($plan !== '') {
                $sections[] = "Plan:\n{$plan}";
            }

            $formattedNotes = implode("\n\n", $sections);

            $doctorNote = DoctorNote::create([
                'id' => (string) Str::uuid(),
                'procedure_id' => $procedure->id,
                'user_id' => Auth::id(),
                'notes' => $formattedNotes,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Catatan dokter berhasil disimpan.',
                'data' => [
                    'id' => $doctorNote->id,
                    'subjective' => $subjective,
                    'objective' => $objective,
                    'plan' => $plan,
                    'created_at' => optional($doctorNote->created_at)->format('d M Y H:i') ?? now()->format('d M Y H:i'),
                    'doctor_name' => optional($procedure->doctor)->full_name ?? (optional($appointment->doctor)->full_name ?? '-'),
                ],
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan catatan dokter.',
                'error' => $e->getMessage(),
            ], 500);
        }
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
            'payment_type'    => 'nullable|string|max:100',
            'cash_account'    => 'nullable|string|max:100',
            'amount_paid'     => 'required|numeric',
            'change_amount'   => 'required|numeric',
            'debt_amount'     => 'required|numeric',
            'status'          => 'required|in:paid,partial,unpaid',
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
            $invoicePayload = [
                'registration_id' => $request->registration_id,
                'admin_id'        => Auth::id() ?? '49f9ad75-bd0b-43ca-8a19-a9adebfd0c5f', // Menggunakan fallback ID admin jika auth kosong
                'invoice_number'  => $invoiceNumber,
                'receipt_number'  => $receiptNumber,
                'payment_type'    => $request->payment_type ?? 'Langsung',
                'payment_method'  => $request->payment_method,
                'amount_paid'     => $request->amount_paid,
                'change_amount'   => $request->change_amount,
                'debt_amount'     => $request->debt_amount,
                'status'          => $request->status, // <--- INI KUNCI AGAR SAAT REFRESH TOMBOLNYA BERUBAH
                'rounding'        => 0,
                'notes'           => $request->notes,
            ];

            // Kompatibilitas: beberapa environment belum menjalankan migration cash_account.
            if (Schema::hasColumn('invoices', 'cash_account')) {
                $invoicePayload['cash_account'] = $request->cash_account;
            }

            $invoice = Invoice::create($invoicePayload);

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