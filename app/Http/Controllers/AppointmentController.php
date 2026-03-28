<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\DoctorNote;
use App\Models\Doctor;
<<<<<<< HEAD
<<<<<<< Updated upstream
=======
=======
>>>>>>> origin/main
use App\Models\MasterCareType;
use App\Models\MasterGuarantorType;
use App\Models\MasterPaymentMethod;
use App\Models\MasterPoli;
use App\Models\MasterVisitType;
<<<<<<< HEAD
use App\Models\MedicalProcedure;
use App\Models\Patient;
>>>>>>> Stashed changes
=======
use App\Models\Patient;
>>>>>>> origin/main
use App\Models\Treatment;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | 🔵 PUBLIC (USER)
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $doctors    = Doctor::active()->orderBy('full_name')->get();
        $treatments = Treatment::active()->orderBy('procedure_name')->get();

        return view('user.components.create', compact('doctors', 'treatments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_name'     => 'required|string|max:100',
            'patient_phone'    => 'required|string|max:20',
            'doctor_id'        => 'required|exists:doctor,id',
            'treatment_id'     => 'required|exists:master_procedure,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required|date_format:H:i',
            'payment_method'   => 'required|in:tunai',
            'notes'            => 'nullable|string|max:500',
        ]);

        $appointmentDateTime = Carbon::parse($validated['appointment_date'] . ' ' . $validated['appointment_time']);
        $treatment = Treatment::query()->find($validated['treatment_id']);

        Appointment::create([
            'id' => (string) Str::ulid(),
            'doctor_id' => $validated['doctor_id'],
            'registration_date' => $validated['appointment_date'],
            'appointment_datetime' => $appointmentDateTime,
            'status' => 'pending',
            'procedure_plan' => $treatment?->procedure_name,
            'complaint' => trim("Nama: {$validated['patient_name']}\nWhatsApp: {$validated['patient_phone']}\nCatatan: " . ($validated['notes'] ?? '-')),
        ]);

        return redirect()->route('appointments.success')
            ->with('success', 'Pendaftaran berhasil! Kami akan konfirmasi via WhatsApp dalam 1x24 jam.');
    }

    public function success()
    {
        return view('user.components.success');
    }

    /*
    |--------------------------------------------------------------------------
    | 🔴 ADMIN — RAWAT JALAN
    |--------------------------------------------------------------------------
    */

    /**
     * GET /admin/outpatient?date=2026-03-26
     * Halaman jadwal dokter
     */
    public function schedule(Request $request)
    {
        $date   = $request->get('date', today()->toDateString());
        $carbon = Carbon::parse($date);

        $doctors        = Doctor::active()->orderBy('full_name')->get();
        $polis          = MasterPoli::active()->get();
        $guarantorTypes = MasterGuarantorType::active()->get();
        $paymentMethods = MasterPaymentMethod::active()->get();
        $visitTypes     = MasterVisitType::active()->get();
        $careTypes      = MasterCareType::active()->get();

        $appointments = Appointment::with(['doctor', 'patient'])
            ->forDate($date)
            ->get();

        // Susun map: [doctor_id][HH:mm] = Appointment
        $schedule = [];
        foreach ($appointments as $apt) {
            $time = Carbon::parse($apt->appointment_datetime)->format('H:i');
            $schedule[$apt->doctor_id][$time] = $apt;
        }

        // Slot 15 menit: 08:00 – 21:00
        $timeSlots = [];
        $start = Carbon::createFromTime(8, 0);
        $end   = Carbon::createFromTime(21, 0);
        while ($start <= $end) {
            $timeSlots[] = $start->format('H:i');
            $start->addMinutes(15);
        }

        return view('admin.pages.outpatient', compact(
            'doctors', 'schedule', 'timeSlots', 'date', 'carbon',
            'polis', 'guarantorTypes', 'paymentMethods', 'visitTypes', 'careTypes'
        ));
    }

    /**
     * PATCH /admin/appointments/{appointment}/status
     * Update status appointment
     */
    public function updateStatus(Request $request, Appointment $appointment)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,waiting,engaged,succeed',
        ]);

        $appointment->update(['status' => $request->status]);

        return response()->json([
            'success' => true,
            'status'  => $appointment->status,
            'color'   => $appointment->status_color,
        ]);
    }
<<<<<<< HEAD
<<<<<<< Updated upstream
}
=======

    /**
     * GET /admin/appointments/{appointment}/detail
     * Detail kunjungan untuk modal Rawat Jalan.
     */
    public function detail(Appointment $appointment)
    {
        $appointment->load(['patient', 'doctor', 'poli', 'paymentMethod', 'visitType', 'careType', 'guarantorType']);

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $appointment->id,
                'status' => $appointment->status,
                'status_color' => $appointment->status_color,
                'registration_date' => $appointment->registration_date,
                'appointment_datetime' => $appointment->appointment_datetime,
                'complaint' => $appointment->complaint,
                'patient_condition' => $appointment->patient_condition,
                'procedure_plan' => $appointment->procedure_plan,
                'patient_type' => $appointment->patient_type,
                'patient' => [
                    'id' => $appointment->patient?->id,
                    'full_name' => $appointment->patient?->full_name,
                    'medical_record_no' => $appointment->patient?->medical_record_no,
                    'phone_number' => $appointment->patient?->phone_number,
                    'address' => $appointment->patient?->address,
                    'id_card_number' => $appointment->patient?->id_card_number,
                ],
                'doctor' => [
                    'id' => $appointment->doctor?->id,
                    'full_name' => $appointment->doctor?->full_name,
                    'full_title' => $appointment->doctor?->full_title,
                ],
                'poli' => [
                    'id' => $appointment->poli?->id,
                    'name' => $appointment->poli?->name,
                ],
                'payment_method' => [
                    'id' => $appointment->paymentMethod?->id,
                    'name' => $appointment->paymentMethod?->name,
                ],
                'visit_type' => [
                    'id' => $appointment->visitType?->id,
                    'name' => $appointment->visitType?->name,
                ],
                'care_type' => [
                    'id' => $appointment->careType?->id,
                    'name' => $appointment->careType?->name,
                ],
                'guarantor_type' => [
                    'id' => $appointment->guarantorType?->id,
                    'name' => $appointment->guarantorType?->name,
                ],
            ],
        ]);
    }

    /**
     * GET /admin/api/emr/patient-data?patient_id=...&appointment_id=...
     * Detail data EMR per pasien / per registrasi.
     */
    public function emrPatientData(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'nullable|string|exists:patient,id',
            'appointment_id' => 'nullable|string|exists:registration,id',
        ]);

        $patientId = $validated['patient_id'] ?? null;
        $appointmentId = $validated['appointment_id'] ?? null;

        if (!$patientId && !$appointmentId) {
            return response()->json([
                'success' => false,
                'message' => 'patient_id atau appointment_id wajib diisi.',
            ], 422);
        }

        if ($appointmentId && !$patientId) {
            $selectedAppointment = Appointment::query()->find($appointmentId);
            $patientId = $selectedAppointment?->patient_id;
        }

        $history = Appointment::query()
            ->with(['doctor', 'poli', 'paymentMethod', 'visitType', 'careType', 'guarantorType'])
            ->when($patientId, fn($q) => $q->where('patient_id', $patientId))
            ->orderByDesc('appointment_datetime')
            ->limit(25)
            ->get()
            ->map(function (Appointment $item) {
                return [
                    'id' => $item->id,
                    'appointment_datetime' => $item->appointment_datetime,
                    'registration_date' => $item->registration_date,
                    'status' => $item->status,
                    'status_color' => $item->status_color,
                    'complaint' => $item->complaint,
                    'patient_condition' => $item->patient_condition,
                    'procedure_plan' => $item->procedure_plan,
                    'doctor_name' => $item->doctor?->full_name,
                    'poli_name' => $item->poli?->name,
                    'payment_method_name' => $item->paymentMethod?->name,
                    'visit_type_name' => $item->visitType?->name,
                    'care_type_name' => $item->careType?->name,
                    'guarantor_type_name' => $item->guarantorType?->name,
                    'patient_type' => $item->patient_type,
                ];
            })
            ->values();

        $doctorNotes = DoctorNote::query()
            ->select([
                'doctor_note.id',
                'doctor_note.notes',
                'doctor_note.created_at',
                'doctor_note.user_id',
                'medical_procedure.registration_id',
                'doctor.full_name as doctor_name',
                'user.name as author_name',
            ])
            ->leftJoin('medical_procedure', 'medical_procedure.id', '=', 'doctor_note.procedure_id')
            ->leftJoin('doctor', 'doctor.id', '=', 'medical_procedure.doctor_id')
            ->leftJoin('user', 'user.id', '=', 'doctor_note.user_id')
            ->when(
                $appointmentId,
                fn($q) => $q->where('medical_procedure.registration_id', $appointmentId),
                fn($q) => $q->where('medical_procedure.patient_id', $patientId)
            )
            ->orderByDesc('doctor_note.created_at')
            ->limit(50)
            ->get()
            ->map(function ($note) {
                return [
                    'id' => $note->id,
                    'registration_id' => $note->registration_id,
                    'notes' => $note->notes,
                    'doctor_name' => $note->doctor_name,
                    'author_name' => $note->author_name,
                    'created_at' => $note->created_at,
                ];
            })
            ->values();

        return response()->json([
            'success' => true,
            'data' => [
                'history' => $history,
                'doctor_notes' => $doctorNotes,
            ],
        ]);
    }

    /**
     * POST /admin/appointments/{appointment}/diagnosis
     * Simpan diagnosa / catatan dokter dari halaman EMR.
     */
    public function addDiagnosis(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'diagnosis' => 'required|string|max:5000',
        ]);

        $procedure = MedicalProcedure::query()
            ->where('registration_id', $appointment->id)
            ->first();

        if (!$procedure) {
            $procedure = MedicalProcedure::create([
                'id' => (string) Str::ulid(),
                'registration_id' => $appointment->id,
                'patient_id' => $appointment->patient_id,
                'doctor_id' => $appointment->doctor_id,
                'discount_type' => 'none',
                'discount_value' => 0,
                'total_amount' => 0,
                'notes' => 'Auto-generated from EMR diagnosis input',
            ]);
        }

        $note = DoctorNote::create([
            'id' => (string) Str::ulid(),
            'procedure_id' => $procedure->id,
            'user_id' => Auth::id(),
            'notes' => trim($validated['diagnosis']),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Diagnosa berhasil disimpan.',
            'data' => [
                'id' => $note->id,
                'procedure_id' => $note->procedure_id,
                'notes' => $note->notes,
            ],
        ], 201);
    }
=======
>>>>>>> origin/main

    /*
    |--------------------------------------------------------------------------
    | 🔴 ADMIN — PENDAFTARAN BARU
    |--------------------------------------------------------------------------
    */

    /**
     * GET /admin/registration
     * Halaman registrasi dengan data master untuk dropdown
     */
    public function registrationIndex()
    {
        $doctors        = Doctor::active()->orderBy('full_name')->get();
        $polis          = MasterPoli::active()->get();
        $guarantorTypes = MasterGuarantorType::active()->get();
        $paymentMethods = MasterPaymentMethod::active()->get();
        $visitTypes     = MasterVisitType::active()->get();
        $careTypes      = MasterCareType::active()->get();

        return view('admin.pages.registration', compact(
            'doctors', 'polis', 'guarantorTypes', 'paymentMethods', 'visitTypes', 'careTypes'
        ));
    }

    /**
     * POST /admin/appointments/store
     * Simpan pendaftaran baru dari admin
     */
    public function storeAdmin(Request $request)
    {
        $validated = $request->validate([
            'patient_id'        => 'required|exists:patient,id',
            'doctor_id'         => 'required|exists:doctor,id',
            'poli_id'           => 'required|exists:master_poli,id',
            'guarantor_type_id' => 'nullable|exists:master_guarantor_type,id',
            'payment_method_id' => 'nullable|exists:master_payment_method,id',
            'visit_type_id'     => 'nullable|exists:master_visit_type,id',
            'care_type_id'      => 'nullable|exists:master_care_type,id',
            'patient_type'      => 'nullable|in:rujuk,non_rujuk',
            'appointment_date'  => 'required|date',
            'appointment_time'  => 'required|date_format:H:i',
            'duration_minutes'  => 'nullable|integer|min:1|max:480',
            'complaint'         => 'nullable|string|max:1000',
            'patient_condition' => 'nullable|string|max:1000',
            'procedure_plan'    => 'nullable|string|max:1000',
            'phone_number'      => 'nullable|string|max:20',
            'email'             => 'nullable|email|max:50',
        ]);

        $appointmentDatetime = Carbon::parse(
            $validated['appointment_date'] . ' ' . $validated['appointment_time']
        );

        $appointment = Appointment::create([
            'id'                => (string) Str::ulid(),
            'patient_id'        => $validated['patient_id'],
            'doctor_id'         => $validated['doctor_id'],
            'admin_id'          => Auth::id(),
            'poli_id'           => $validated['poli_id'],
            'guarantor_type_id' => $validated['guarantor_type_id'] ?? null,
            'payment_method_id' => $validated['payment_method_id'] ?? null,
            'visit_type_id'     => $validated['visit_type_id'] ?? null,
            'care_type_id'      => $validated['care_type_id'] ?? null,
            'patient_type'      => $validated['patient_type'] ?? 'non_rujuk',
            'registration_date' => $validated['appointment_date'],
            'appointment_datetime' => $appointmentDatetime,
            'duration_minutes'  => $validated['duration_minutes'] ?? 10,
            'status'            => 'pending',
            'complaint'         => $validated['complaint'] ?? null,
            'patient_condition' => $validated['patient_condition'] ?? null,
            'procedure_plan'    => $validated['procedure_plan'] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pendaftaran berhasil disimpan.',
            'data'    => $appointment->load('patient', 'doctor'),
        ], 201);
    }
<<<<<<< HEAD
}
>>>>>>> Stashed changes
=======
}
>>>>>>> origin/main
