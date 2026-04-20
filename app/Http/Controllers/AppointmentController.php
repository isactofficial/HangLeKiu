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
use App\Models\DoctorSchedule;
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
        $doctors        = Doctor::with('schedules')->active()->orderBy('full_name')->get();
        $treatments     = Treatment::active()->orderBy('procedure_name')->get();
        $polis          = MasterPoli::active()->orderBy('name')->get();
        $guarantorTypes = MasterGuarantorType::active()->orderBy('name')->get();
        $paymentMethods = MasterPaymentMethod::active()->orderBy('name')->get();
        $visitTypes     = MasterVisitType::active()->orderBy('name')->get();
        $careTypes      = MasterCareType::active()->orderBy('name')->get();
        $patient    = Auth::user()?->patient;

        return view('user.components.create', compact(
            'doctors',
            'treatments',
            'patient',
            'polis',
            'guarantorTypes',
            'paymentMethods',
            'visitTypes',
            'careTypes'
        ));
    }
    public function checkSlot(Request $request)
    {
        $doctorId = $request->get('doctor_id');
        $date     = $request->get('date');
        $time     = $request->get('time');
        if (!$doctorId || !$date || !$time) {
            return response()->json(['available' => true]);
        }
        
        // Snap ke 15 menit
        [$h, $m]       = explode(':', $time);
        $roundedMinute = floor((int)$m / 15) * 15;
        $snappedTime   = sprintf('%02d:%02d:00', (int)$h, $roundedMinute);
        
        $exists = Appointment::where('doctor_id', $doctorId)
        ->whereRaw("DATE(appointment_datetime) = ?", [$date])
        ->whereRaw("TIME_FORMAT(
            SEC_TO_TIME(
                FLOOR(TIME_TO_SEC(TIME(appointment_datetime)) / 900) * 900
                ), '%H:%i:%s') = ?", [$snappedTime])
        ->whereNotIn('status', ['failed'])
        ->exists();

        return response()->json([
            'available' => !$exists,
            'message'   => $exists
                ? 'Slot ini sudah terisi oleh pasien lain. Silakan pilih jam yang berbeda.'
                : null,
        ]);
    }

    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_name'     => 'required|string|max:100',        
            'patient_phone'    => 'required|string|max:20',
            'date_of_birth'    => 'required|date|before:today',
            'gender'           => 'required|in:Male,Female',
            'patient_type'     => 'required|in:non_rujuk,rujuk',
            'guarantor_type_id'=> 'required|exists:master_guarantor_type,id',
            'payment_method_id'=> 'required|exists:master_payment_method,id',
            'visit_type_id'    => 'required|exists:master_visit_type,id',
            'care_type_id'     => 'required|exists:master_care_type,id',
            'poli_id'          => 'required|exists:master_poli,id',
            'doctor_id'        => 'required|exists:doctor,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required|date_format:H:i',
            'duration_minutes' => 'nullable|integer|min:1|max:480',
            'complaint'        => 'nullable|string|max:500',
            'procedure_plan'   => 'nullable|string|max:255',
            'patient_condition'=> 'nullable|string|max:255',
            ]);

            if (Auth::check() && Auth::user()->patient) {
                $patient = Auth::user()->patient;
            } else {
                $patient = Patient::firstOrCreate(
                    ['phone_number' => $validated['patient_phone']],
                    [
                        'id'                => (string) Str::ulid(),            
                        'full_name'         => $validated['patient_name'],            
                        'medical_record_no' => 'MR' . str_pad(Patient::count() + 1, 6, '0', STR_PAD_LEFT),
                        'date_of_birth'     => $validated['date_of_birth'],
                        'gender'            => $validated['gender'],
                        'user_id'           => Auth::id()
                    ]
                );

                if (Auth::check() && !$patient->user_id) {
                    $patient->update(['user_id' => Auth::id()]);
                }
            }

                $appointmentDateTime = Carbon::parse(
                $validated['appointment_date'] . ' ' . $validated['appointment_time']
                );

                $dayMap = [
                    0 => 'sunday',
                    1 => 'monday',
                    2 => 'tuesday',
                    3 => 'wednesday',
                    4 => 'thursday',
                    5 => 'friday',
                    6 => 'saturday',
                ];
                $dayKey = $dayMap[(int) $appointmentDateTime->dayOfWeek];

                $doctor = Doctor::find($validated['doctor_id']);
                $isFlexible = (bool)($doctor->is_flexible ?? false);

                if (!$isFlexible) {
                    $doctorSchedule = DoctorSchedule::where('doctor_id', $validated['doctor_id'])
                        ->where('day', $dayKey)
                        ->where('is_active', true)
                        ->first();

                    if (!$doctorSchedule) {
                        return back()->withInput()->withErrors([
                            'appointment_date' => 'Dokter tidak memiliki jadwal praktek pada tanggal yang dipilih.',
                        ]);
                    }

                    $selectedTime = $appointmentDateTime->format('H:i');
                    $startTime = Carbon::parse($doctorSchedule->start_time)->format('H:i');
                    $endTime = Carbon::parse($doctorSchedule->end_time)->format('H:i');

                    if ($selectedTime < $startTime || $selectedTime > $endTime) {
                        return back()->withInput()->withErrors([
                            'appointment_time' => "Jam kunjungan di luar jadwal praktek dokter ({$startTime} - {$endTime}).",
                        ]);
                    }
                }

                Appointment::create([
                'id'                   => (string) Str::ulid(),
                'patient_id'           => $patient->id,
                'doctor_id'            => $validated['doctor_id'],
                'poli_id'              => $validated['poli_id'],
                'guarantor_type_id'    => $validated['guarantor_type_id'],
                'payment_method_id'    => $validated['payment_method_id'],
                'visit_type_id'        => $validated['visit_type_id'],
                'care_type_id'         => $validated['care_type_id'],
                'patient_type'         => $validated['patient_type'],
                'registration_date'    => $validated['appointment_date'],
                'appointment_datetime' => $appointmentDateTime,
                'duration_minutes'     => $validated['duration_minutes'] ?? 30,
                'status'               => 'pending',        
                'procedure_plan'       => $validated['procedure_plan'] ?? null,
                'complaint'            => $validated['complaint'] ?? null,
                'patient_condition'    => $validated['patient_condition'] ?? null,
                'admin_id'             => null,                            
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

    public function schedule(Request $request)
    {
        // 1. Ambil Parameter
        $dateParam = $request->get('date', now()->toDateString());
        $doctorId  = $request->get('doctor_id');
        $viewMode  = $doctorId ? 'single' : 'all';

        // 2. Tentukan Range Tanggal (Harian vs 7 Hari Mingguan)
        if ($viewMode === 'single') {
            $startDate = Carbon::parse($dateParam)->startOfDay();
            $endDate   = $startDate->copy()->addDays(6)->endOfDay();
        } else {
            $startDate = Carbon::parse($dateParam)->startOfDay();
            $endDate   = Carbon::parse($dateParam)->endOfDay();
        }

        // 3. Ambil Master Data
        $doctors        = Doctor::active()->orderBy('full_name')->get();
        $polis          = MasterPoli::active()->get();
        $guarantorTypes = MasterGuarantorType::active()->get();
        $paymentMethods = MasterPaymentMethod::active()->get()->unique('name');
        $visitTypes     = MasterVisitType::active()->get();
        $careTypes      = MasterCareType::active()->get();

        // 4. Query Data Pendaftaran
        $query = Appointment::with(['doctor', 'patient'])
            ->whereBetween('appointment_datetime', [$startDate, $endDate]);

        if ($viewMode === 'single') {
            $query->where('doctor_id', $doctorId);
        }

        $appointments = $query->get();

        // 5. Mapping Data ke Grid (LOGIKA SNAP 15 MENIT)
        $schedule = [];
        foreach ($appointments as $apt) {
            $timeCarbon = Carbon::parse($apt->appointment_datetime);
            $dateKey    = $timeCarbon->toDateString();

            $minute        = $timeCarbon->minute;
            $roundedMinute = floor($minute / 15) * 15;
            $timeKey       = $timeCarbon->minute($roundedMinute)->second(0)->format('H:i');

            $apt->patient_name   = $apt->patient->full_name ?? 'Pasien';
            $apt->mr_number      = $apt->patient->medical_record_no ?? '-';
            $apt->treatment_name = Str::limit($apt->complaint ?? $apt->procedure_plan ?? '-', 20);

            // RESOLVED: Gunakan warna dari v2 — pending abu-abu netral, failed merah eksplisit
            $statusColors = [
                'pending'   => '#6B7280',
                'confirmed' => '#F59E0B',
                'waiting'   => '#8B5CF6',
                'engaged'   => '#3B82F6',
                'succeed'   => '#84CC16',
                'failed'    => '#EF4444',
            ];
            $apt->status_color = $statusColors[strtolower($apt->status)] ?? '#C58F59';

            if ($viewMode === 'all') {
                $schedule[$apt->doctor_id][$timeKey] = $apt;
            } else {
                $schedule[$dateKey][$timeKey] = $apt;
            }
        }

        // 6. Slot Waktu Grid (08:00 - 21:00)
        $timeSlots = [];
        $start     = Carbon::createFromTime(8, 0);
        $end       = Carbon::createFromTime(21, 0);
        while ($start <= $end) {
            $timeSlots[] = $start->format('H:i');
            $start->addMinutes(15);
        }

        // 7. Siapkan array Tanggal untuk kolom Header
        $dateColumns = [];
        $tempDate    = $startDate->copy();
        for ($i = 0; $i < 7; $i++) {
            $dateColumns[] = $tempDate->toDateString();
            $tempDate->addDay();
        }

        return view('admin.pages.outpatient', compact(
            'doctors', 'schedule', 'timeSlots', 'dateParam', 'dateColumns',
            'polis', 'guarantorTypes', 'paymentMethods', 'visitTypes', 'careTypes'
        ))->with([
            'date'   => $dateParam,
            'carbon' => $startDate,
        ]);
    }

    // RESOLVED: Gunakan implementasi v2 — lebih lengkap dengan validasi transisi status
    public function updateStatus(Request $request, Appointment $appointment)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,waiting,engaged,succeed,failed',
        ]);

        $statusOrder  = ['pending', 'confirmed', 'waiting', 'engaged', 'succeed'];
        $currentIndex = array_search(strtolower($appointment->status ?? 'pending'), $statusOrder);
        $newIndex     = array_search(strtolower($request->status), $statusOrder);

        // Jangan izinkan kembali ke status sebelumnya (urutan lebih kecil)
        if ($newIndex !== false && $currentIndex !== false && $newIndex < $currentIndex) {
            return response()->json([
                'success' => false,
                'message' => "Tidak dapat kembali dari status '" . ucfirst($appointment->status) . "' ke '" . ucfirst($request->status) . "'.",
            ], 422);
        }

        $currentStatus = strtolower((string) $appointment->status);
        $targetStatus  = strtolower((string) $request->status);

        $allowedTransitions = [
            'pending'   => ['confirmed', 'waiting', 'engaged', 'succeed', 'failed'],
            'confirmed' => ['waiting', 'engaged', 'succeed', 'failed'],
            'waiting'   => ['engaged', 'succeed', 'failed'],
            'engaged'   => ['succeed', 'failed'],
            'succeed'   => ['failed'],
            'failed'    => [],
        ];

        if (!in_array($targetStatus, $allowedTransitions[$currentStatus] ?? [], true)) {
            return response()->json([
                'success' => false,
                'message' => 'Status tidak valid. Perubahan hanya boleh ke status lanjutan, kecuali succeed dapat diubah ke failed.',
            ], 422);
        }

        $updateData = ['status' => $targetStatus];
        if ($targetStatus === 'waiting' && !$appointment->waiting_at) {
            $updateData['waiting_at'] = now();
        } elseif ($targetStatus === 'engaged' && !$appointment->engaged_at) {
            $updateData['engaged_at'] = now();
        }

        $appointment->update($updateData);

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
            'photo_base64'      => 'nullable|string',
        ]);

        $appointmentDatetime = Carbon::parse($validated['appointment_date'] . ' ' . $validated['appointment_time']);

        $appointment = Appointment::create([
            'id'                   => (string) Str::ulid(),
            'patient_id'           => $validated['patient_id'],
            'doctor_id'            => $validated['doctor_id'],
            'admin_id'             => Auth::id() ?? 1,
            'poli_id'              => $validated['poli_id'],
            'guarantor_type_id'    => $validated['guarantor_type_id'] ?? null,
            'payment_method_id'    => $validated['payment_method_id'] ?? null,
            'visit_type_id'        => $validated['visit_type_id'] ?? null,
            'care_type_id'         => $validated['care_type_id'] ?? null,
            'patient_type'         => $validated['patient_type'] ?? 'non_rujuk',
            'registration_date'    => $validated['appointment_date'],
            'appointment_datetime' => $appointmentDatetime,
            'duration_minutes'     => $validated['duration_minutes'] ?? 10,
            'status'               => 'pending',
            'complaint'            => $validated['complaint'] ?? null,
            'patient_condition'    => $validated['patient_condition'] ?? null,
            'procedure_plan'       => $validated['procedure_plan'] ?? null,
        ]);

        $photoBase64 = $request->input('photo_base64');
        if (!empty($photoBase64)) {
            try {
                $patient = Patient::find($validated['patient_id']);
                if ($patient) {
                    $patient->update(['photo' => $photoBase64]);
                    \Log::info('Patient photo updated on storeAdmin', ['patient_id' => $patient->id]);
                }
            } catch (\Exception $e) {
                \Log::error('Failed to update patient photo on storeAdmin: ' . $e->getMessage(), [
                    'patient_id' => $validated['patient_id'],
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Pendaftaran berhasil disimpan.',
            'data'    => $appointment->load('patient', 'doctor'),
        ], 201);
    }

    public function show($id)
    {
        \Log::info('Fetching appointment detail', ['id' => $id]);

        try {
            $appointment = Appointment::findOrFail($id);
            $appointment->load(['patient', 'doctor', 'poli', 'paymentMethod', 'admin']);

            return response()->json([
                'success' => true,
                'data'    => $appointment->toArray(),
            ], 200);
        } catch (\Exception $e) {
            \Log::error('Error fetching appointment detail', [
                'id'    => $id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan: ' . $e->getMessage(),
            ], 404);
        }
    }

    public function index(Request $request)
    {
        $date      = $request->get('date');
        $poliId    = $request->get('filter_poli');
        $doctorId  = $request->get('filter_dokter');
        $paymentId = $request->get('filter_bayar');
        $search    = $request->get('search');

        $query = Appointment::with(['patient', 'doctor', 'poli', 'paymentMethod']);

        if ($date) {
            $query->whereDate('appointment_datetime', $date);
        }
        if ($poliId && $poliId !== 'semua') {
            $query->where('poli_id', $poliId);
        }
        if ($doctorId && $doctorId !== 'semua') {
            $query->where('doctor_id', $doctorId);
        }
        if ($paymentId && $paymentId !== 'semua') {
            $query->where('payment_method_id', $paymentId);
        }
        if ($search) {
            $query->whereHas('patient', function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('medical_record_no', 'like', "%{$search}%");
            });
        }

        $appointments = $query->orderByRaw('DATE(appointment_datetime) DESC')
                              ->orderByRaw('TIME(appointment_datetime) ASC')
                              ->paginate(10);
        $appointments->appends($request->all());

        $doctors        = Doctor::active()->orderBy('full_name')->get();
        $polis          = MasterPoli::active()->get()->unique('name')->sortBy('name')->values();
        $guarantorTypes = MasterGuarantorType::active()->get();
        $paymentMethods = MasterPaymentMethod::active()->get()->unique('name');
        $visitTypes     = MasterVisitType::active()->get();
        $careTypes      = MasterCareType::active()->get();

        return view('admin.pages.registration', compact(
            'appointments', 'date', 'search',
            'doctors', 'polis', 'guarantorTypes', 'paymentMethods', 'visitTypes', 'careTypes'
        ));
    }

    public function update(Request $request, Appointment $appointment)
    {
        \Log::info('Appointment update request', [
            'appointment_id'   => $appointment->id,
            'patient_id'       => $appointment->patient_id,
            'content_type'     => $request->header('Content-Type'),
            'has_photo_base64' => $request->has('photo_base64'),
        ]);

        // RESOLVED: Hapus completed & cancelled agar konsisten dengan enum di updateStatus
        $validated = $request->validate([
            'complaint'      => 'nullable|string|max:1000',
            'procedure_plan' => 'nullable|string|max:1000',
            'status'         => 'nullable|in:pending,confirmed,waiting,engaged,succeed,failed',
            'notes'          => 'nullable|string|max:1000',
            'photo_base64'   => 'nullable|string',
        ]);

        $updateData = [];

        if (array_key_exists('complaint', $validated)) {
            $updateData['complaint'] = $validated['complaint'];
        }
        if (array_key_exists('procedure_plan', $validated)) {
            $updateData['procedure_plan'] = $validated['procedure_plan'];
        }
        if (array_key_exists('status', $validated)) {
            $updateData['status'] = $validated['status'];
        }
        if (array_key_exists('notes', $validated)) {
            $updateData['patient_condition'] = $validated['notes'];
        }

        if (!empty($updateData)) {
            $appointment->update($updateData);
        }

        $photoBase64 = $request->input('photo_base64');

        if (!empty($photoBase64) && $appointment->patient_id) {
            try {
                $patient = Patient::find($appointment->patient_id);
                if ($patient) {
                    $patient->update(['photo' => $photoBase64]);
                    \Log::info('Patient photo updated successfully', ['patient_id' => $patient->id]);
                } else {
                    \Log::warning('Patient not found for photo update', ['patient_id' => $appointment->patient_id]);
                }
            } catch (\Exception $e) {
                \Log::error('Failed to update patient photo: ' . $e->getMessage(), [
                    'appointment_id' => $appointment->id,
                    'patient_id'     => $appointment->patient_id,
                ]);
            }
        }

        $appointment->refresh();
        $appointment->load(['patient', 'doctor', 'poli', 'paymentMethod']);

        \Log::info('Update response data', [
            'appointment_id'    => $appointment->id,
            'has_patient_photo' => !empty($appointment->patient->photo),
            'photo_length'      => strlen($appointment->patient->photo ?? ''),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Detail kunjungan berhasil diperbarui',
            'data'    => $appointment,
        ], 200);
    }
}