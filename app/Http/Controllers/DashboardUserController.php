<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\OdontogramRecord;
use App\Models\Treatment;
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
        $activeRegistrations = collect();
        $recentAppointments  = collect();
        $medicalHistoryRows  = collect();
        $odontogramRows      = collect();

        $doctors = Doctor::active()
            ->orderBy('full_name')
            ->get(['id', 'full_name']);

        $treatments = Treatment::active()
            ->orderBy('procedure_name')
            ->get(['id', 'procedure_name']);

        if ($patient) {
            $totalVisits = Appointment::where('patient_id', $patient->id)
                ->where('status', 'succeed')
                ->count();

            $upcomingAppointment = Appointment::where('patient_id', $patient->id)
                ->whereIn('status', ['pending', 'confirmed', 'waiting', 'engaged'])
                ->with(['doctor', 'poli'])
                ->orderBy('appointment_datetime')
                ->first();

            $activeRegistrations = Appointment::where('patient_id', $patient->id)
                ->whereIn('status', ['pending', 'confirmed', 'waiting', 'engaged'])
                ->with(['doctor', 'poli'])
                ->orderBy('appointment_datetime')
                ->take(10)
                ->get();

            $recentAppointments = Appointment::where('patient_id', $patient->id)
                ->with('doctor')
                ->latest('appointment_datetime')
                ->take(5)
                ->get();

            $medicalHistoryRows = Appointment::where('patient_id', $patient->id)
                ->with('doctor')
                ->latest('appointment_datetime')
                ->take(10)
                ->get();

            $odontogramRows = OdontogramRecord::where('patient_id', $patient->id)
                ->withCount('teeth')
                ->latest('examined_at')
                ->take(10)
                ->get();
        }

        return view('user.pages.dashboard', compact(
            'user',
            'patient',
            'totalVisits',
            'upcomingAppointment',
            'activeRegistrations',
            'recentAppointments',
            'medicalHistoryRows',
            'odontogramRows',
            'doctors',
            'treatments'
        ));
    }

    // ── Update Profil Pasien ──────────────────────────────────

    public function updateProfile(Request $request)
    {
        $user    = Auth::user();
        $patient = $user->patient;

        $request->validate([
            'full_name'     => 'required|string|max:255',
            'email'         => 'required|email|max:255|unique:user,email,' . $user->id . ',id',
            'phone_number'  => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'gender'        => 'nullable|in:Male,Female',
            'blood_type'    => 'nullable|in:A,B,AB,O,unknown',
            'rhesus'        => 'nullable|in:+,-,unknown',
            'address'       => 'nullable|string|max:255',
            'city'          => 'nullable|string|max:100',
            'id_card_number' => 'nullable|string|max:20',
            'allergy_history' => 'nullable|string',
            'religion'      => 'nullable|string|max:50',
            'education'     => 'nullable|string|max:50',
            'occupation'    => 'nullable|string|max:50',
            'marital_status' => 'nullable|string|max:50',
            'first_chat_date' => 'nullable|date',
            'photo_base64'  => 'nullable|string',
            'password'      => 'nullable|string|min:8|confirmed',
        ]);

        // 1. Update nama di tabel user
        $user->name = $request->full_name;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        // 2. Update data di tabel patient
        if ($patient) {
            $patient->update([
                'full_name'      => $request->full_name,
                'email'          => $request->email,
                'phone_number'   => $request->phone_number,
                'date_of_birth'  => $request->date_of_birth,
                'gender'         => $request->gender,
                'blood_type'     => $request->blood_type,
                'rhesus'         => $request->rhesus,
                'address'        => $request->address,
                'city'           => $request->city,
                'id_card_number' => $request->id_card_number,
                'allergy_history' => $request->allergy_history,
                'religion'       => $request->religion,
                'education'      => $request->education,
                'occupation'     => $request->occupation,
                'marital_status' => $request->marital_status,
                'first_chat_date' => $request->first_chat_date,
                'photo'          => $request->filled('photo_base64') ? $request->photo_base64 : $patient->photo,
            ]);
        }

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }

    // ── Riwayat Medis ─────────────────────────────────────────

    public function medicalHistory()
    {
        $patient = Auth::user()->patient;

        $appointments = $patient
            ? Appointment::where('patient_id', $patient->id)
                ->with(['doctor', 'medicalProcedures.doctorNotes.user'])
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
            ->with(['doctor', 'medicalProcedures.doctorNotes.user'])
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