<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Treatment;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Str;

class AppointmentController extends Controller
{
    /**
     * Form pendaftaran publik (tidak perlu login)
     * GET /daftar
     */
    public function create()
    {
        $doctors    = Doctor::active()->orderBy('full_name')->get();
        $treatments = Treatment::active()->orderBy('procedure_name')->get();

        return view('user.components.create', compact('doctors', 'treatments'));
    }

    /**
     * Simpan data dari form
     * POST /daftar
     */
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
        ], [
            'patient_name.required'     => 'Nama lengkap wajib diisi.',
            'patient_phone.required'    => 'Nomor WhatsApp wajib diisi.',
            'doctor_id.required'        => 'Pilih dokter terlebih dahulu.',
            'doctor_id.exists'          => 'Dokter tidak ditemukan.',
            'treatment_id.required'     => 'Pilih jenis perawatan.',
            'treatment_id.exists'       => 'Perawatan tidak ditemukan.',
            'appointment_date.required' => 'Tanggal wajib diisi.',
            'appointment_date.after_or_equal' => 'Tanggal tidak boleh sebelum hari ini.',
            'appointment_time.required' => 'Jam wajib diisi.',
            'appointment_time.date_format' => 'Format jam tidak valid.',
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
            ->with('success', 'Pendaftaran berhasil! Kami akan konfirmasi via WhatsApp dalam 1×24 jam.');
    }

    /**
     * Halaman sukses setelah submit form
     * GET /daftar/sukses
     */
    public function success()
    {
        return view('user.components.success');
    }

    /**
     * Halaman Rawat Jalan (admin)
     * GET /rawat-jalan?date=2026-02-25
     */
    public function schedule(Request $request)
    {
        $date    = $request->get('date', today()->toDateString());
        $carbon  = Carbon::parse($date);

        $doctors = Doctor::active()->orderBy('full_name')->get();

        // Ambil semua appointment di tanggal ini
        $appointments = Appointment::with(['doctor', 'patient'])
            ->forDate($date)
            ->get();

        // Susun ke dalam map: [doctor_id][time] = appointment
        // Contoh: $schedule[1]['19:30'] = Appointment object
        $schedule = [];
        foreach ($appointments as $apt) {
            $time = Carbon::parse($apt->appointment_datetime)->format('H:i');
            $schedule[$apt->doctor_id][$time] = $apt;
        }

        // Generate slot waktu 15 menit dari 08:00 – 21:00
        $timeSlots = [];
        $start = Carbon::createFromTime(8, 0);
        $end   = Carbon::createFromTime(21, 0);
        while ($start <= $end) {
            $timeSlots[] = $start->format('H:i');
            $start->addMinutes(15);
        }

        return view('admin.pages.outpatient', compact('doctors', 'schedule', 'timeSlots', 'date', 'carbon'));
    }

    /**
     * Update status appointment (admin)
     * PATCH /appointments/{id}/status
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
}
