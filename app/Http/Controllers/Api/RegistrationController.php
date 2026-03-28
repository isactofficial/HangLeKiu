<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\MasterPoli;
use App\Models\MasterGuarantorType;
use App\Models\MasterPaymentMethod;
use App\Models\MasterVisitType;
use App\Models\MasterCareType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RegistrationController extends Controller
{
    // ─────────────────────────────────────────────
    // GET /api/registration/master-data
    // Semua dropdown sekaligus
    // ─────────────────────────────────────────────
    public function masterData()
    {
        return response()->json([
            'poli'           => MasterPoli::active()->orderBy('name')->get(['id', 'name']),
            'guarantor_type' => MasterGuarantorType::active()->orderBy('name')->get(['id', 'name']),
            'payment_method' => MasterPaymentMethod::active()->orderBy('name')->get(['id', 'name']),
            'visit_type'     => MasterVisitType::active()->orderBy('name')->get(['id', 'name']),
            'care_type'      => MasterCareType::active()->orderBy('name')->get(['id', 'name']),
        ]);
    }

    // ─────────────────────────────────────────────
    // GET /api/registration/doctors
    // Daftar dokter aktif + jadwal hari ini
    // ─────────────────────────────────────────────
    public function doctors(Request $request)
    {
        $date    = $request->get('date', today()->toDateString());
        $dayName = strtolower(Carbon::parse($date)->englishDayOfWeek);

        $doctors = Doctor::active()
            ->with(['schedules' => function ($q) use ($dayName) {
                $q->where('day', $dayName)->where('is_active', true);
            }])
            ->orderBy('full_name')
            ->get(['id', 'full_name', 'specialization', 'title_prefix']);

        return response()->json($doctors);
    }

    // ─────────────────────────────────────────────
    // GET /api/registration/slots?doctor_id=&date=
    // Slot waktu tersedia (belum dipakai)
    // ─────────────────────────────────────────────
    public function availableSlots(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctor,id',
            'date'      => 'required|date',
        ]);

        $doctorId = $request->doctor_id;
        $date     = $request->date;
        $dayName  = strtolower(Carbon::parse($date)->englishDayOfWeek);

        // Jadwal kerja dokter di hari itu
        $schedule = \App\Models\DoctorSchedule::where('doctor_id', $doctorId)
            ->where('day', $dayName)
            ->where('is_active', true)
            ->first();

        if (!$schedule) {
            return response()->json(['slots' => [], 'message' => 'Dokter tidak praktik di hari ini']);
        }

        // Generate slot 15 menit
        $slots  = [];
        $cursor = Carbon::parse($date . ' ' . $schedule->start_time);
        $end    = Carbon::parse($date . ' ' . $schedule->end_time);

        while ($cursor < $end) {
            $slots[] = $cursor->format('H:i');
            $cursor->addMinutes(15);
        }

        // Slot yang sudah dipakai
        $booked = Appointment::where('doctor_id', $doctorId)
            ->whereDate('appointment_datetime', $date)
            ->whereNotIn('status', ['succeed'])
            ->pluck('appointment_datetime')
            ->map(fn($dt) => Carbon::parse($dt)->format('H:i'))
            ->toArray();

        $result = array_map(fn($slot) => [
            'time'      => $slot,
            'available' => !in_array($slot, $booked),
        ], $slots);

        return response()->json(['slots' => $result]);
    }

    // ─────────────────────────────────────────────
    // GET /api/registration/search-patient?q=
    // Cari pasien lama (autocomplete)
    // ─────────────────────────────────────────────
    public function searchPatient(Request $request)
    {
        $q = $request->get('q', '');

        if (strlen($q) < 2) {
            return response()->json([]);
        }

        $patients = Patient::where('full_name', 'like', "%$q%")
            ->orWhere('medical_record_no', 'like', "%$q%")
            ->limit(10)
            ->get(['id', 'full_name', 'medical_record_no', 'date_of_birth', 'gender', 'email', 'address', 'phone_number' ?? null]);

        return response()->json($patients);
    }

    // ─────────────────────────────────────────────
    // POST /api/registration
    // Simpan pendaftaran baru
    // ─────────────────────────────────────────────
    public function store(Request $request)
    {
        $validated = $request->validate([
            'doctor_id'          => 'required|exists:doctor,id',
            'poli_id'            => 'nullable|exists:master_poli,id',
            'guarantor_type_id'  => 'nullable|exists:master_guarantor_type,id',
            'payment_method_id'  => 'nullable|exists:master_payment_method,id',
            'visit_type_id'      => 'nullable|exists:master_visit_type,id',
            'care_type_id'       => 'nullable|exists:master_care_type,id',
            'patient_type'       => 'required|in:existing,new',
            'date'               => 'required|date',
            'time'               => 'required|date_format:H:i',
            'complaint'          => 'nullable|string|max:1000',

            // Pasien lama
            'patient_id'         => 'required_if:patient_type,existing|nullable|exists:patient,id',

            // Pasien baru
            'full_name'          => 'required_if:patient_type,new|nullable|string|max:100',
            'date_of_birth'      => 'required_if:patient_type,new|nullable|date',
            'gender'             => 'required_if:patient_type,new|nullable|in:Male,Female',
            'email'              => 'nullable|email|max:100',
            'phone_number'       => 'nullable|string|max:20',
            'address'            => 'nullable|string|max:255',
        ], [
            'patient_id.required_if'   => 'Pilih pasien terlebih dahulu.',
            'full_name.required_if'    => 'Nama pasien wajib diisi.',
            'date_of_birth.required_if'=> 'Tanggal lahir wajib diisi.',
            'gender.required_if'       => 'Jenis kelamin wajib dipilih.',
        ]);

        // ── Handle Pasien ──────────────────────────
        if ($validated['patient_type'] === 'existing') {
            $patient = Patient::find($validated['patient_id']);

            if (!$patient) {
                return response()->json(['message' => 'Pasien tidak ditemukan.'], 404);
            }
        } else {
            // Generate nomor MR otomatis: MR + tahun + 6 digit
            $lastMr  = Patient::orderByDesc('created_at')->value('medical_record_no');
            $seq     = $lastMr ? ((int) substr($lastMr, -6)) + 1 : 1;
            $mrNo    = 'MR' . now()->format('Y') . str_pad($seq, 6, '0', STR_PAD_LEFT);

            $patient = Patient::create([
                'id'                => (string) Str::uuid(),
                'full_name'         => $validated['full_name'],
                'medical_record_no' => $mrNo,
                'date_of_birth'     => $validated['date_of_birth'],
                'gender'            => $validated['gender'],
                'email'             => $validated['email'] ?? null,
                'address'           => $validated['address'] ?? null,
            ]);
        }

        // ── Simpan Registrasi ──────────────────────
        $appointment = Appointment::create([
            'id'                   => (string) Str::uuid(),
            'patient_id'           => $patient->id,
            'doctor_id'            => $validated['doctor_id'],
            'admin_id'             => auth()->id(),
            'poli_id'              => $validated['poli_id'] ?? null,
            'guarantor_type_id'    => $validated['guarantor_type_id'] ?? null,
            'payment_method_id'    => $validated['payment_method_id'] ?? null,
            'visit_type_id'        => $validated['visit_type_id'] ?? null,
            'care_type_id'         => $validated['care_type_id'] ?? null,
            'patient_type'         => $validated['patient_type'] === 'new' ? 'non_rujuk' : 'non_rujuk',
            'registration_date'    => $validated['date'],
            'appointment_datetime' => Carbon::parse($validated['date'] . ' ' . $validated['time']),
            'status'               => 'pending',
            'complaint'            => $validated['complaint'] ?? null,
        ]);

        return response()->json([
            'message'     => 'Pendaftaran berhasil.',
            'data'        => $appointment->load(['patient', 'doctor']),
        ], 201);
    }
<<<<<<< HEAD

    // ─────────────────────────────────────────────
    // GET /api/registration/appointments
    // List appointments dengan filter untuk registration page
    // Query params: date, poli_id, doctor_id, payment_method_id, search, page, per_page
    // ─────────────────────────────────────────────
    public function listAppointments(Request $request)
    {
        try {
            $perPage = $request->get('per_page', 10);
            $search = $request->get('search', '');
            $date = $request->get('date', null); // null jika tidak dikirim
            $poliId = $request->get('poli_id', null);
            $doctorId = $request->get('doctor_id', null);
            $paymentMethodId = $request->get('payment_method_id', null);

            $query = Appointment::query()
                ->with(['patient', 'doctor', 'poli', 'paymentMethod']);

            // Filter tanggal hanya jika date diisi
            if ($date) {
                $query->whereDate('registration_date', $date);
            }

            // Filter berdasarkan poli
            if ($poliId && $poliId !== 'semua') {
                $query->where('poli_id', $poliId);
            }

            // Filter berdasarkan dokter
            if ($doctorId && $doctorId !== 'semua') {
                $query->where('doctor_id', $doctorId);
            }

            // Filter berdasarkan metode pembayaran
            if ($paymentMethodId && $paymentMethodId !== 'semua') {
                $query->where('payment_method_id', $paymentMethodId);
            }

            // Search berdasarkan nama pasien atau nomor MR
            if ($search) {
                $query->whereHas('patient', function ($q) use ($search) {
                    $q->where('full_name', 'like', "%$search%")
                      ->orWhere('medical_record_no', 'like', "%$search%");
                });
            }

            // Order by appointment_datetime ASC
            $appointments = $query
                ->orderBy('appointment_datetime', 'asc')
                ->paginate($perPage);

            return response()->json($appointments);
        } catch (\Exception $e) {
            \Log::error('ListAppointments Error: ' . $e->getMessage(), [
                'exception' => $e,
                'request' => $request->all()
            ]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // ─────────────────────────────────────────────
    // GET /api/registration/appointments-emr
    // List appointments untuk EMR page (hanya yang status pending/waiting/engaged)
    // Query params: filter_waktu (hari_ini, semua), search
    // ─────────────────────────────────────────────
    public function listAppointmentsEmr(Request $request)
    {
        try {
            $filterWaktu = $request->get('filter_waktu', 'hari_ini');
            $search = trim((string) $request->get('search', ''));

            $query = Appointment::query()
                ->with(['patient', 'doctor', 'poli', 'paymentMethod', 'visitType', 'careType', 'guarantorType'])
                ->whereIn('status', ['pending', 'confirmed', 'waiting', 'engaged']);

            // Filter waktu
            if ($filterWaktu === 'hari_ini') {
                $query->whereDate('appointment_datetime', today());
            }
            // jika "semua", tidak perlu filter tanggal

            // Search
            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->whereHas('patient', function ($subQ) use ($search) {
                        $subQ->where('full_name', 'like', "%$search%")
                             ->orWhere('medical_record_no', 'like', "%$search%")
                             ->orWhere('id_card_number', 'like', "%$search%")
                             ->orWhere('phone_number', 'like', "%$search%");
                    })
                    ->orWhere('id', 'like', "%$search%")
                    ->orWhere('patient_id', 'like', "%$search%");
                });
            }

            $appointments = $query
                ->orderBy('appointment_datetime', 'asc')
                ->get();

            return response()->json([
                'data' => $appointments,
                'count' => $appointments->count(),
            ]);
        } catch (\Exception $e) {
            \Log::error('ListAppointmentsEmr Error: ' . $e->getMessage(), [
                'exception' => $e,
                'request' => $request->all()
            ]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
=======
>>>>>>> origin/main
}