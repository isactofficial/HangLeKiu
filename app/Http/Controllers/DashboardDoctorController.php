<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardDoctorController extends Controller
{
    public function index()
    {
        $user   = Auth::user();
        $doctor = $user->doctor;

        $todayAppointments = collect();
        $totalPatientsTreated = 0;
        $nextPatient = null;

        if ($doctor) {
            // Antrian Hari Ini
            $todayAppointments = Appointment::where('doctor_id', $doctor->id)
                ->whereDate('appointment_datetime', Carbon::today())
                ->with(['patient', 'poli'])
                ->orderBy('appointment_datetime')
                ->get();

            // Pasien Yang statusnya waiting atau engaged
            $nextPatient = Appointment::where('doctor_id', $doctor->id)
                ->whereDate('appointment_datetime', Carbon::today())
                ->whereIn('status', ['waiting', 'engaged'])
                ->with('patient')
                ->orderBy('appointment_datetime')
                ->first();

            // Total Pasien Pernah Dilayani
            $totalPatientsTreated = Appointment::where('doctor_id', $doctor->id)
                ->where('status', 'succeed')
                ->count();
        }

        return view('doctor.pages.dashboard', compact(
            'user',
            'doctor',
            'todayAppointments',
            'nextPatient',
            'totalPatientsTreated'
        ));
    }
}
