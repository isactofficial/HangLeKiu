<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\DoctorNote;
use App\Models\MedicalProcedure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\OdontogramRecord;

class DoctorEmrController extends Controller
{
    private function resolveDoctorFeeSnapshot(?string $doctorId): float
    {
        if (! $doctorId) {
            return 0.0;
        }

        return (float) (Doctor::where('id', $doctorId)->value('default_fee_percentage') ?? 0);
    }

    /**
     * Ambil doctor_id dari user yang login via guard 'web' (role DCT).
     * Coba relasi user->doctor dulu, fallback ke user->id.
     */
    private function getLoggedInDoctorId(): ?string
    {
        $user = Auth::user();
        if (! $user) return null;

        // Jika user punya relasi ke tabel doctor
        if (isset($user->doctor) && $user->doctor?->id) {
            return $user->doctor->id;
        }

        // Fallback: user_id = doctor_id (jika tabel doctor pakai user_id sebagai PK atau FK)
        return $user->id;
    }

    // ─────────────────────────────────────────────
    // 1. HALAMAN UTAMA EMR DOKTER
    // ─────────────────────────────────────────────
    public function index(Request $request)
    {
        $doctorId = $this->getLoggedInDoctorId();
        $doctor   = Auth::user()?->doctor ?? Auth::user();
        $search   = $request->get('search');

        // Pasien HARI INI milik dokter ini
        $todayPatients = Appointment::with(['patient', 'paymentMethod', 'guarantorType'])
            ->where('doctor_id', $doctorId)
            ->whereDate('appointment_datetime', Carbon::today())
            ->when($search, fn ($q) => $q->whereHas('patient',
                fn ($s) => $s->where('full_name', 'like', "%{$search}%")))
            ->orderBy('appointment_datetime')
            ->get();

        // SEMUA pasien dokter ini
        $allPatients = Appointment::with(['patient', 'paymentMethod', 'guarantorType'])
            ->where('doctor_id', $doctorId)
            ->when($search, fn ($q) => $q->whereHas('patient',
                fn ($s) => $s->where('full_name', 'like', "%{$search}%")
                             ->orWhere('medical_record_no', 'like', "%{$search}%")))
            ->orderByDesc('appointment_datetime')
            ->paginate(15);

        $autoOpenApptId = $todayPatients->firstWhere('status', 'engaged')?->id;

        return view('doctor.pages.emr', compact(
            'todayPatients', 'allPatients', 'search', 'autoOpenApptId', 'doctor'
        ));
    }

    // ─────────────────────────────────────────────
    // 2. DETAIL PASIEN (AJAX)
    // ─────────────────────────────────────────────
    public function show(Request $request, $id)
    {
        $hasProcedureAssistantTable = Schema::hasTable('procedure_assistant');

        $relations = [
            'patient', 'doctor', 'poli', 'paymentMethod', 'guarantorType',
            'medicalProcedures.doctor',
            'medicalProcedures.doctorNotes.user',
            'medicalProcedures.bhpUsages.item',
        ];
        if ($hasProcedureAssistantTable) {
            $relations[] = 'medicalProcedures.assistants.doctor';
        }

        $appointment = Appointment::with($relations)->findOrFail($id);

        // Proteksi: dokter hanya boleh lihat pasien miliknya
        $doctorId = $this->getLoggedInDoctorId();
        if ($doctorId && $appointment->doctor_id !== $doctorId) {
            abort(403, 'Anda tidak memiliki akses ke data pasien ini.');
        }

        $patientRegistrationRelations = [
            'doctor', 'poli',
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
            ->flatMap(fn ($reg) => $reg->medicalProcedures)
            ->flatMap(function ($procedure) use ($hasProcedureAssistantTable) {
                $assistantNames = collect();
                if ($hasProcedureAssistantTable) {
                    $assistantNames = $procedure->assistants
                        ->map(fn ($a) => optional($a->doctor)->full_name)
                        ->filter()->values();
                }

                return $procedure->doctorNotes->map(function ($note) use ($assistantNames, $procedure) {
                    $text = (string) ($note->notes ?? '');

                    $subjective = $objective = $plan = '';
                    if (preg_match('/Subjective:\s*(.*?)(?=\n\n(?:Objective|Plan):|$)/s', $text, $m))  $subjective = trim($m[1]);
                    if (preg_match('/Objective:\s*(.*?)(?=\n\n(?:Subjective|Plan):|$)/s', $text, $m))  $objective  = trim($m[1]);
                    if (preg_match('/Plan:\s*(.*?)(?=\n\n(?:Subjective|Objective):|$)/s', $text, $m))  $plan       = trim($m[1]);
                    if ($subjective === '' && $objective === '' && $plan === '') $plan = trim($text);

                    return [
                        'id'               => $note->id,
                        'created_at'       => $note->created_at,
                        'created_at_label' => $note->created_at
                            ? Carbon::parse($note->created_at)->translatedFormat('d F Y H:i') : '-',
                        'doctor_name'      => optional($procedure->doctor)->full_name
                            ?: (optional($note->user)->name ?: '-'),
                        'assistant_names'  => $assistantNames,
                        'subjective'       => $subjective,
                        'objective'        => $objective,
                        'plan'             => $plan,
                    ];
                });
            })
            ->sortByDesc('created_at')
            ->values();
            
        $odontogramRecords = OdontogramRecord::with('teeth')
            ->where('patient_id', $appointment->patient_id)
            ->orderByDesc('examined_at')
            ->get();
            
        if ($request->ajax() || $request->hasHeader('X-Requested-With')) {
            return view('doctor.components.emr.patient-detail-partial',        
                compact('appointment', 'doctorNotes', 'patientRegistrations', 'odontogramRecords')
            )->render();
        }

        return redirect()->route('doctor.emr');
    }

    // ─────────────────────────────────────────────
    // 3. SIMPAN CATATAN DOKTER
    // ─────────────────────────────────────────────
    public function storeDoctorNote(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'subjective' => 'nullable|string',
            'objective'  => 'nullable|string',
            'plan'       => 'nullable|string',
        ]);

        $subjective = trim((string) ($validated['subjective'] ?? ''));
        $objective  = trim((string) ($validated['objective'] ?? ''));
        $plan       = trim((string) ($validated['plan'] ?? ''));

        if ($subjective === '' && $objective === '' && $plan === '') {
            return response()->json([
                'success' => false,
                'message' => 'Isi minimal salah satu Subjectives, Objectives, atau Plans.',
            ], 422);
        }

        DB::beginTransaction();
        try {
            $procedure = $appointment->medicalProcedures()->orderByDesc('created_at')->first();

            if (! $procedure) {
                $procedurePayload = [
                    'id'              => (string) Str::uuid(),
                    'registration_id' => $appointment->id,
                    'patient_id'      => $appointment->patient_id,
                    'doctor_id'       => $appointment->doctor_id,
                    'discount_type'   => 'none',
                    'discount_value'  => 0,
                    'total_amount'    => 0,
                    'notes'           => 'Auto-created for doctor note entry',
                ];

                if (Schema::hasColumn('medical_procedure', 'doctor_fee_percentage_snapshot')) {
                    $procedurePayload['doctor_fee_percentage_snapshot'] = $this->resolveDoctorFeeSnapshot($appointment->doctor_id);
                }

                $procedure = MedicalProcedure::create($procedurePayload);
            }

            $sections = [];
            if ($subjective !== '') $sections[] = "Subjective:\n{$subjective}";
            if ($objective  !== '') $sections[] = "Objective:\n{$objective}";
            if ($plan       !== '') $sections[] = "Plan:\n{$plan}";

            $doctorNote = DoctorNote::create([
                'id'           => (string) Str::uuid(),
                'procedure_id' => $procedure->id,
                'user_id'      => Auth::id(),
                'notes'        => implode("\n\n", $sections),
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Catatan dokter berhasil disimpan.',
                'data'    => [
                    'id'          => $doctorNote->id,
                    'subjective'  => $subjective,
                    'objective'   => $objective,
                    'plan'        => $plan,
                    'created_at'  => optional($doctorNote->created_at)->format('d M Y H:i') ?? now()->format('d M Y H:i'),
                    'doctor_name' => optional($procedure->doctor)->full_name
                        ?? (optional($appointment->doctor)->full_name ?? '-'),
                ],
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan catatan dokter.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    // ─────────────────────────────────────────────
    // 4. UPDATE STATUS APPOINTMENT
    // ─────────────────────────────────────────────
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|in:pending,confirmed,waiting,engaged,succeed,failed',
        ]);

        $appointment = Appointment::findOrFail($id);

        $doctorId = $this->getLoggedInDoctorId();
        if ($doctorId && $appointment->doctor_id !== $doctorId) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }

        $updateData = ['status' => $request->status];
        if ($request->status === 'engaged' && !$appointment->engaged_at) {
            $updateData['engaged_at'] = now();
        } elseif ($request->status === 'waiting' && !$appointment->waiting_at) {
            $updateData['waiting_at'] = now();
        }

        $appointment->update($updateData);

        return response()->json(['success' => true, 'message' => 'Status berhasil diubah.']);
    }
}