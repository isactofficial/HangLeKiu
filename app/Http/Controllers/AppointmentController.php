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
            'id'                   => (string) Str::ulid(),
            'doctor_id'            => $validated['doctor_id'],
            'registration_date'    => $validated['appointment_date'],
            'appointment_datetime' => $appointmentDateTime,
            'status'               => 'pending',
            'procedure_plan'       => $treatment?->procedure_name,
            'complaint'            => trim("Nama: {$validated['patient_name']}\nWhatsApp: {$validated['patient_phone']}\nCatatan: " . ($validated['notes'] ?? '-')),
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

            $apt->patient_name  = $apt->patient->full_name ?? 'Pasien';
            $apt->mr_number     = $apt->patient->medical_record_no ?? '-';
            $apt->treatment_name = Str::limit($apt->complaint ?? $apt->procedure_plan ?? '-', 20);

            $statusColors = [
                'pending'   => '#EF4444',
                'confirmed' => '#F59E0B',
                'waiting'   => '#8B5CF6',
                'engaged'   => '#3B82F6',
                'succeed'   => '#84CC16',
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
            // FIX: Terima foto dari form pendaftaran baru
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

        // FIX: Update foto pasien jika dikirim dari form pendaftaran baru
        $photoBase64 = $request->input('photo_base64');
        if (!empty($photoBase64)) {
            try {
                $patient = Patient::find($validated['patient_id']);
                if ($patient) {
                    $patient->update(['photo' => $photoBase64]);
                    \Log::info('Patient photo updated on storeAdmin', ['patient_id' => $patient->id]);
                }
            } catch (\Exception $e) {
                // Jangan gagalkan seluruh request hanya karena foto gagal
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

    public function show(Appointment $appointment)
    {
        $appointment->load(['patient', 'doctor', 'poli', 'paymentMethod']);

        return response()->json([
            'success' => true,
            'data'    => $appointment,
        ], 200);
    }

    public function index(Request $request)
    {
        $date     = $request->get('date');
        $poliId   = $request->get('filter_poli');
        $doctorId = $request->get('filter_dokter');
        $paymentId = $request->get('filter_bayar');
        $search   = $request->get('search');

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

        // FIX: Hapus batas max pada photo_base64 agar tidak memotong data base64 besar
        $validated = $request->validate([
            'complaint'      => 'nullable|string|max:1000',
            'procedure_plan' => 'nullable|string|max:1000',
            'status'         => 'nullable|in:pending,confirmed,waiting,engaged,succeed,completed,cancelled',
            'notes'          => 'nullable|string|max:1000',
            'photo_base64'   => 'nullable|string',
        ]);

        // Bangun array update hanya dari field yang dikirim
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

        // FIX: Baca photo_base64 dari JSON body (request->input() sudah handle keduanya)
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
                // Log error tapi jangan gagalkan seluruh request
                \Log::error('Failed to update patient photo: ' . $e->getMessage(), [
                    'appointment_id' => $appointment->id,
                    'patient_id'     => $appointment->patient_id,
                ]);
            }
        }

        // FIX: Reload relasi dengan fresh data agar foto terbaru ikut terkirim ke frontend
        $appointment->refresh();
        $appointment->load(['patient', 'doctor', 'poli', 'paymentMethod']);

        \Log::info('Update response data', [
            'appointment_id'     => $appointment->id,
            'has_patient_photo'  => !empty($appointment->patient->photo),
            'photo_length'       => strlen($appointment->patient->photo ?? ''),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Detail kunjungan berhasil diperbarui',
            'data'    => $appointment,
        ], 200);
    }
}