<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\MasterCareType;
use App\Models\MasterGuarantorType;
use App\Models\MasterPaymentMethod;
use App\Models\MasterPoli;
use App\Models\MasterVisitType;
use App\Models\Patient;
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
}