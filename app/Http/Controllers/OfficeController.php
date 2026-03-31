<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\MedicalProcedure;
use App\Models\ProcedureMedicine;
use App\Models\Patient;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OfficeController extends Controller
{
    public function index(Request $request)
    {
        $activeTab = $request->query('tab', 'kunjungan');
        $activeMenu = $request->query('menu', 'dashboard-harian');

        // 👉 Jika menu pasien
        if ($activeMenu === 'pasien') {
            return $this->handlePasienMenu($request);
        }

        // =========================
        // DASHBOARD HARIAN
        // =========================
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();

        // 1. Metrics: Appointments
        $countTodayAppts = Appointment::whereDate('appointment_datetime', $today)->count();
        $countYesterdayAppts = Appointment::whereDate('appointment_datetime', $yesterday)->count();
        $apptDiff = $countTodayAppts - $countYesterdayAppts;
        $apptTrendClass = $apptDiff >= 0 ? 'up' : 'down';

        // 2. Metrics: Omzet
        $sumTodayOmzet = MedicalProcedure::whereDate('created_at', $today)->sum('total_amount');
        $sumYesterdayOmzet = MedicalProcedure::whereDate('created_at', $yesterday)->sum('total_amount');

        $omzetDiffPercent = 0;
        if ($sumYesterdayOmzet > 0) {
            $omzetDiffPercent = (($sumTodayOmzet - $sumYesterdayOmzet) / $sumYesterdayOmzet) * 100;
        } elseif ($sumTodayOmzet > 0) {
            $omzetDiffPercent = 100;
        }
        $omzetTrendClass = $omzetDiffPercent >= 0 ? 'up' : 'down';

        // 3. Chart Data
        $subFilter = $request->query('sub_filter', 'status');
        $chartData = [];

        if ($activeTab === 'kunjungan') {
            $query = Appointment::whereDate('appointment_datetime', $today);

            if ($subFilter === 'status') {
                $chartData = $query->select('status as label', DB::raw('count(*) as total'))
                    ->groupBy('status')
                    ->pluck('total', 'label')
                    ->all();

                foreach (['pending','confirmed','waiting','engaged','succeed'] as $s) {
                    if (!isset($chartData[$s])) $chartData[$s] = 0;
                }

            } elseif ($subFilter === 'visit_type') {
                $chartData = $query->join('master_visit_type', 'registration.visit_type_id', '=', 'master_visit_type.id')
                    ->select('master_visit_type.name as label', DB::raw('count(*) as total'))
                    ->groupBy('master_visit_type.name')
                    ->pluck('total', 'label')
                    ->all();

            } elseif ($subFilter === 'patient_type') {
                $rawTypes = $query->select('patient_type', DB::raw('count(*) as total'))
                    ->groupBy('patient_type')
                    ->pluck('total', 'patient_type')
                    ->all();

                $chartData = [
                    'Mandiri' => $rawTypes['non_rujuk'] ?? 0,
                    'Rujukan' => $rawTypes['rujuk'] ?? 0
                ];

            } elseif ($subFilter === 'guarantor_type') {
                $chartData = $query->join('master_guarantor_type', 'registration.guarantor_type_id', '=', 'master_guarantor_type.id')
                    ->select('master_guarantor_type.name as label', DB::raw('count(*) as total'))
                    ->groupBy('master_guarantor_type.name')
                    ->pluck('total', 'label')
                    ->all();
            }
        }

        // 4. Tab Data
        $tabData = [];

        if ($activeTab === 'prosedur') {
            $tabData = MedicalProcedure::whereDate('created_at', $today)
                ->with(['patient', 'doctor'])
                ->latest()
                ->get();

        } elseif ($activeTab === 'resep') {
            $todayMedicinesCount = ProcedureMedicine::whereHas('medicalProcedure', function($q) use ($today) {
                $q->whereDate('created_at', $today);
            })->count();

            $tabData = ['total' => $todayMedicinesCount];
        }

        // 5. Finance
        $totalMasuk = $sumTodayOmzet;
        $totalKeluar = 0;
        $saldoAkhir = $totalMasuk - $totalKeluar;
        $profitMargin = $totalMasuk > 0 ? (($saldoAkhir) / $totalMasuk) * 100 : 0;

        return view('admin.layout.office', [
            'activeMenu' => $activeMenu,
            'activeTab' => $activeTab,

            'countTodayAppts' => $countTodayAppts,
            'countYesterdayAppts' => $countYesterdayAppts,
            'apptDiff' => $apptDiff,
            'apptTrendClass' => $apptTrendClass,

            'sumTodayOmzet' => $sumTodayOmzet,
            'sumYesterdayOmzet' => $sumYesterdayOmzet,
            'omzetDiffPercent' => round($omzetDiffPercent, 1),
            'omzetTrendClass' => $omzetTrendClass,

            'subFilter' => $subFilter,
            'chartData' => $chartData,
            'tabData' => $tabData,

            'totalMasuk' => $totalMasuk,
            'totalKeluar' => $totalKeluar,
            'saldoAkhir' => $saldoAkhir,
            'profitMargin' => round($profitMargin, 1),
        ]);
    }

    // =========================
    // MENU PASIEN
    // =========================
    private function handlePasienMenu(Request $request)
    {
        // 1. Stats
        $totalPatients = Patient::count();

        $newPatientsThisMonth = Patient::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $walkInToday = Appointment::whereDate('appointment_datetime', now()->toDateString())->count();

        // 2. Trend 14 hari
        $trendDates = collect();
        for ($i = 13; $i >= 0; $i--) {
            $trendDates->put(now()->subDays($i)->toDateString(), 0);
        }

        $registrations = Patient::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
            ->where('created_at', '>=', now()->subDays(13)->startOfDay())
            ->groupBy('date')
            ->get()
            ->pluck('total', 'date');

        $trendData = $trendDates->merge($registrations);

        // 3. Upcoming Birthday
        $upcomingBirthdays = Patient::whereRaw("DATE_FORMAT(date_of_birth, '%m-%d') BETWEEN ? AND ?", [
            now()->format('m-d'),
            now()->addDays(7)->format('m-d')
        ])->get();

        // 4. Chart
        $bloodTypeStats = Patient::select('blood_type', DB::raw('count(*) as total'))
            ->groupBy('blood_type')
            ->pluck('total', 'blood_type')
            ->toArray();

        $educationStats = Patient::select('education', DB::raw('count(*) as total'))
            ->groupBy('education')
            ->pluck('total', 'education')
            ->toArray();

        // 5. Table + Search
        $search = $request->get('search');

        $patients = Patient::with(['latestAppointment.guarantorType'])
            ->when($search, function ($query) use ($search) {
                $query->where('full_name', 'like', "%{$search}%")
                      ->orWhere('medical_record_no', 'like', "%{$search}%")
                      ->orWhere('id_card_number', 'like', "%{$search}%");
            })
            ->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();

        return view('admin.layout.office', [
            'activeMenu' => 'pasien',

            'totalPatients' => $totalPatients,
            'newPatientsThisMonth' => $newPatientsThisMonth,
            'walkInToday' => $walkInToday,

            'trendData' => $trendData,
            'upcomingBirthdays' => $upcomingBirthdays,

            'bloodTypeStats' => $bloodTypeStats,
            'educationStats' => $educationStats,

            'patients' => $patients
        ]);
    }
}