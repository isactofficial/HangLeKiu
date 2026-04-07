<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\OdontogramRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class DashboardUserController extends Controller
{
    // ── Dashboard Utama ───────────────────────────────────────

    public function index()
    {
        $user    = Auth::user();
        $patient = $user->patient;

        $totalVisits         = 0;
        $upcomingAppointment = null;
        $recentAppointments  = collect();

        if ($patient) {
            $totalVisits = Appointment::where('patient_id', $patient->id)
                ->whereIn('status', ['confirmed', 'succeed'])
                ->count();

            $upcomingAppointment = Appointment::where('patient_id', $patient->id)
                ->whereIn('status', ['pending', 'confirmed', 'waiting'])
                ->where('appointment_datetime', '>=', now())
                ->with('doctor')
                ->orderBy('appointment_datetime')
                ->first();

            $recentAppointments = Appointment::where('patient_id', $patient->id)
                ->with('doctor')
                ->latest('appointment_datetime')
                ->take(5)
                ->get();
        }

        return view('user.pages.dashboard', compact(
            'user',
            'patient',
            'totalVisits',
            'upcomingAppointment',
            'recentAppointments'
        ));
    }

    // ── Update Profil Pasien ──────────────────────────────────

    public function updateProfile(Request $request)
    {
        $user    = Auth::user();
        $patient = $user->patient;

        $request->validate([
            'name'          => 'required|string|max:255',
            'phone_number'  => 'required|numeric',
            'date_of_birth' => 'nullable|date',
            'password'      => 'nullable|string|min:8|confirmed',
        ]);

        // 1. Update nama di tabel user
        $user->name = $request->name;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        // 2. Update data di tabel patient
        if ($patient) {
            $patient->full_name    = $request->name;
            $patient->phone_number = $request->phone_number;
            $patient->date_of_birth = $request->date_of_birth;
            $patient->save();
        }

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }

    // ── Riwayat Medis ─────────────────────────────────────────

    public function medicalHistory()
    {
        $patient = Auth::user()->patient;

        $appointments = $patient
            ? Appointment::where('patient_id', $patient->id)
                ->with(['doctor', 'medicalProcedures.doctorNotes.doctor'])
                ->latest('appointment_datetime')
                ->paginate(10)
            : collect();

        return view('user.pages.medical-history', compact('appointments'));
    }

    // ── Detail Riwayat Medis ──────────────────────────────────

    public function medicalHistoryDetail(string $appointmentId)
    {
        $patient = Auth::user()->patient;

        $appointment = Appointment::where('patient_id', $patient?->id)
            ->with(['doctor', 'medicalProcedures.doctorNotes.doctor'])
            ->findOrFail($appointmentId);

        return view('user.pages.medical-history-detail', compact('appointment'));
    }

    // ── Riwayat Odontogram ────────────────────────────────────

    public function odontogramHistory()
    {
        $patient = Auth::user()->patient;

        $odontogramRecords = $patient
            ? OdontogramRecord::where('patient_id', $patient->id)
                ->with('teeth')
                ->latest('examined_at')
                ->paginate(10)
            : collect();

        return view('user.pages.odontogram-history', compact('odontogramRecords'));
    }

    // ── Detail Odontogram ─────────────────────────────────────

    public function odontogramDetail(string $recordId)
    {
        $patient = Auth::user()->patient;

        $record = OdontogramRecord::where('patient_id', $patient?->id)
            ->with('teeth')
            ->findOrFail($recordId);

        return view('user.pages.odontogram-detail', compact('record'));
    }
}