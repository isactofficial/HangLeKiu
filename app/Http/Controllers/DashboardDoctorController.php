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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;

class DashboardDoctorController extends Controller
{
    public function index()
    {
        $user   = Auth::user();
        $doctor = $user->doctor;
        $selectedMonth = (int) request()->input('month', Carbon::now()->month);
        $selectedYear = (int) request()->input('year', Carbon::now()->year);

        $todayAppointments = collect();
        $totalPatientsTreated = 0;
        $nextPatient = null;
        $doctorProcedureSummary = collect();
        $doctorIncomeTotal = 0;
        $totalProcedureActions = 0;

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

            // Total Pasien Dilayani Hari Ini
            $totalPatientsTreated = Appointment::where('doctor_id', $doctor->id)
                ->whereDate('appointment_datetime', Carbon::today())
                ->where('status', 'succeed')
                ->count();

            $netSubtotalExpression = 'COALESCE(pi.subtotal, (COALESCE(pi.unit_price, 0) * COALESCE(pi.quantity, 0)))';
            $hasFeeSnapshotColumn = Schema::hasColumn('medical_procedure', 'doctor_fee_percentage_snapshot');
            $doctorFeePercentageExpression = $hasFeeSnapshotColumn
                ? 'COALESCE(mp.doctor_fee_percentage_snapshot, d.default_fee_percentage, 0)'
                : 'COALESCE(d.default_fee_percentage, 0)';

            // Total Pendapatan Hari Ini
            $todayIncomeTotal = DB::table('procedure_item as pi')
                ->join('medical_procedure as mp', 'pi.procedure_id', '=', 'mp.id')
                ->join('registration as ap', 'mp.registration_id', '=', 'ap.id')
                ->leftJoin('doctor as d', 'mp.doctor_id', '=', 'd.id')
                ->where('mp.doctor_id', $doctor->id)
                ->where('ap.status', 'succeed')
                ->whereNull('ap.deleted_at')
                ->whereNull('mp.deleted_at')
                ->whereNull('pi.deleted_at')
                ->whereDate('mp.created_at', Carbon::today())
                ->selectRaw("SUM(({$netSubtotalExpression}) * (({$doctorFeePercentageExpression}) / 100)) as income")
                ->value('income') ?? 0;

            $doctorProcedureSummary = DB::table('procedure_item as pi')
                ->join('medical_procedure as mp', 'pi.procedure_id', '=', 'mp.id')
                ->join('registration as ap', 'mp.registration_id', '=', 'ap.id')
                ->leftJoin('doctor as d', 'mp.doctor_id', '=', 'd.id')
                ->leftJoin('master_procedure as mpr', 'pi.master_procedure_id', '=', 'mpr.id')
                ->where('mp.doctor_id', $doctor->id)
                ->where('ap.status', 'succeed')
                ->whereNull('ap.deleted_at')
                ->whereNull('mp.deleted_at')
                ->whereNull('pi.deleted_at')
                ->whereMonth('mp.created_at', $selectedMonth)
                ->whereYear('mp.created_at', $selectedYear)
                ->selectRaw('COALESCE(mpr.procedure_name, "Prosedur Tanpa Nama") as procedure_name')
                ->selectRaw('COUNT(pi.id) as total_actions')
                ->selectRaw("SUM({$netSubtotalExpression}) as gross_total")
                ->selectRaw("SUM(({$netSubtotalExpression}) * (({$doctorFeePercentageExpression}) / 100)) as doctor_income")
                ->groupBy('mpr.procedure_name')
                ->orderByDesc('doctor_income')
                ->get();

            $doctorIncomeTotal = (float) $doctorProcedureSummary->sum('doctor_income');
            $totalProcedureActions = (int) $doctorProcedureSummary->sum('total_actions');
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
            'doctorProcedureSummary',
            'doctorIncomeTotal',
            'todayIncomeTotal',
            'totalProcedureActions',
            'selectedMonth',
            'selectedYear',
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
            'name'                => 'required|string|max:255',
            'email'               => 'required|email|max:255|unique:user,email,' . $user->id,
            'phone_number'        => 'nullable|string|max:20',
            'title_prefix'        => 'nullable|string|max:50',
            'specialization'      => 'nullable|string|max:100',
            'subspecialization'   => 'nullable|string|max:100',
            'job_title'           => 'nullable|string|max:50',
            'license_no'          => 'nullable|string|max:50',
            'str_number'          => 'nullable|string|max:50',
            'str_institution'     => 'nullable|string|max:50',
            'str_expiry_date'     => 'nullable|date',
            'sip_number'          => 'nullable|string|max:50',
            'sip_institution'     => 'nullable|string|max:50',
            'sip_expiry_date'     => 'nullable|date',
            'alma_mater'          => 'nullable|string|max:255',
            'experience'          => 'nullable|string|max:255',
            'bio'                 => 'nullable|string',
            'instagram_url'       => 'nullable|url|max:255',
            'linkedin_url'        => 'nullable|url|max:255',
            'foto_profil'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'password'            => 'nullable|string|min:8|confirmed',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }
        $user->save();

        if ($doctor) {
            $doctorData = [
                'full_name'          => $validated['name'],
                'email'              => $validated['email'],
                'phone_number'       => $validated['phone_number'],
                'title_prefix'       => $validated['title_prefix'],
                'specialization'     => $validated['specialization'],
                'subspecialization'  => $validated['subspecialization'],
                'job_title'          => $validated['job_title'],
                'license_no'         => $validated['license_no'],
                'str_number'         => $validated['str_number'],
                'str_institution'    => $validated['str_institution'],
                'str_expiry_date'    => $validated['str_expiry_date'],
                'sip_number'         => $validated['sip_number'],
                'sip_institution'    => $validated['sip_institution'],
                'sip_expiry_date'    => $validated['sip_expiry_date'],
                'alma_mater'         => $validated['alma_mater'],
                'experience'         => $validated['experience'],
                'bio'                => $validated['bio'],
                'instagram_url'      => $validated['instagram_url'],
                'linkedin_url'       => $validated['linkedin_url'],
            ];

            if ($request->hasFile('foto_profil')) {
                if ($doctor->foto_profil) {
                    Storage::disk('public')->delete($doctor->foto_profil);
                }
                $doctorData['foto_profil'] = $request->file('foto_profil')->store('doctor_profiles', 'public');
            }

            $doctor->update($doctorData);
        }

        return redirect()->back()->with('success', 'Profil Anda berhasil diperbarui!');
    }
}
