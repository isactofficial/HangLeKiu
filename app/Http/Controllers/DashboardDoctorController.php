<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\MasterGuarantorType;
use App\Models\MasterPaymentMethod;
use App\Models\MasterVisitType;
use App\Models\MasterCareType;
use App\Models\MasterPoli;
use App\Models\Doctor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

        $guarantorTypes = MasterGuarantorType::all();
        $paymentMethods = MasterPaymentMethod::all();
        $visitTypes     = MasterVisitType::all();
        $careTypes      = MasterCareType::all();
        $polis          = MasterPoli::all();
        $doctors        = Doctor::where('is_active', true)->get();

        return view('doctor.pages.dashboard', compact(
            'user',
            'doctor',
            'todayAppointments',
            'nextPatient',
            'totalPatientsTreated',
            'guarantorTypes',
            'paymentMethods',
            'visitTypes',
            'careTypes',
            'polis',
            'doctors'
        ));
    }
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $doctor = $user->doctor;

        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|max:255|unique:user,email,' . $user->id,
            'phone_number'   => 'nullable|string|max:20',
            'sip_number'     => 'nullable|string|max:50',
            'license_no'     => 'nullable|string|max:50',
            'photo_base64'   => 'nullable|string',
            'password'       => 'nullable|string|min:8|confirmed',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }
        $user->save();

        if ($doctor) {
            $doctorData = [
                'full_name'    => $validated['name'],
                'email'        => $validated['email'],
                'phone_number' => $validated['phone_number'],
                'sip_number'   => $validated['sip_number'],
                'license_no'   => $validated['license_no'],
            ];

            if ($request->filled('photo_base64')) {
                $doctorData['foto_profil'] = $validated['photo_base64'];
            }

            $doctor->update($doctorData);
        }

        return redirect()->back()->with('success', 'Profil Anda berhasil diperbarui!');
    }
}
