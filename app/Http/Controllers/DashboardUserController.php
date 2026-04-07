<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\OdontogramRecord;
use Illuminate\Support\Facades\Auth;

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