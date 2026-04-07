<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\OdontogramRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class DashboardUserController extends Controller
{
    // ── DASHBOARD ─────────────────────────────────────────────

    public function index()
    {
        $user    = Auth::user();
        $patient = $user->patient;

        $totalVisits         = 0;
        $upcomingAppointment = null;
        $recentAppointments  = collect();
        $latestOdontogram    = null;

        if ($patient) {

            // Total kunjungan
            $totalVisits = Appointment::where('patient_id', $patient->id)
                ->whereIn('status', ['confirmed', 'succeed'])
                ->count();

            // Antrean aktif
            $upcomingAppointment = Appointment::where('patient_id', $patient->id)
                ->whereIn('status', ['pending', 'confirmed', 'waiting'])
                ->where('appointment_datetime', '>=', now())
                ->with(['doctor', 'poli'])
                ->orderBy('appointment_datetime')
                ->first();

            // 🔥 Riwayat + CATATAN DOKTER (FIX DI SINI)
            $recentAppointments = Appointment::where('patient_id', $patient->id)
                ->with([
                    'doctor',
                    'medicalProcedures.doctorNotes' // penting
                ])
                ->latest('appointment_datetime')
                ->take(5)
                ->get();

            // 🔥 ODONTOGRAM TERBARU (FIX DI SINI)
            $latestOdontogram = OdontogramRecord::where('patient_id', $patient->id)
                ->with('teeth') // WAJIB biar gigi kebaca
                ->latest('examined_at')
                ->first();
        }

        return view('user.pages.dashboard', compact(
            'user',
            'patient',
            'totalVisits',
            'upcomingAppointment',
            'recentAppointments',
            'latestOdontogram'
        ));
    }

    // ── UPDATE PROFIL ─────────────────────────────────────────

    public function updateProfile(Request $request)
    {
        $user    = Auth::user();
        $patient = $user->patient;

        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'phone_number'  => 'required|numeric',
            'date_of_birth' => 'nullable|date|before:today',
            'password'      => 'nullable|string|min:8|confirmed',
        ]);

        $user->name = $validated['name'];

        if ($request->filled('password')) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        if ($patient) {
            $patient->full_name     = $validated['name'];
            $patient->phone_number  = $validated['phone_number'];
            $patient->date_of_birth = $validated['date_of_birth'] ?? $patient->date_of_birth;
            $patient->save();
        }

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }

    // ── RIWAYAT MEDIS ─────────────────────────────────────────

    public function medicalHistory()
    {
        $patient = Auth::user()->patient;

        $appointments = $patient
            ? Appointment::where('patient_id', $patient->id)
                ->with([
                    'doctor',
                    'medicalProcedures.doctorNotes' // FIX
                ])
                ->latest('appointment_datetime')
                ->paginate(10)
            : collect();

        return view('user.pages.medical-history', compact('appointments'));
    }

    // ── DETAIL RIWAYAT MEDIS ──────────────────────────────────

    public function medicalHistoryDetail(string $appointmentId)
    {
        $patient = Auth::user()->patient;

        $appointment = Appointment::where('patient_id', $patient?->id)
            ->with([
                'doctor',
                'medicalProcedures.doctorNotes' // FIX
            ])
            ->findOrFail($appointmentId);

        return view('user.pages.medical-history-detail', compact('appointment'));
    }

    // ── RIWAYAT ODONTOGRAM ────────────────────────────────────

    public function odontogramHistory()
    {
        $patient = Auth::user()->patient;

        $odontogramRecords = $patient
            ? OdontogramRecord::where('patient_id', $patient->id)
                ->with('teeth') // FIX WAJIB
                ->latest('examined_at')
                ->paginate(10)
            : collect();

        return view('user.pages.odontogram-history', compact('odontogramRecords'));
    }

    // ── DETAIL ODONTOGRAM ─────────────────────────────────────

    public function odontogramDetail(string $recordId)
    {
        $patient = Auth::user()->patient;

        $record = OdontogramRecord::where('patient_id', $patient?->id)
            ->with('teeth') // FIX WAJIB
            ->findOrFail($recordId);

        return view('user.pages.odontogram-detail', compact('record'));
    }
}