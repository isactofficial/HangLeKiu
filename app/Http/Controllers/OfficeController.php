<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\MedicalProcedure;
use App\Models\ProcedureItem;
use App\Models\ProcedureMedicine;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OfficeController extends Controller
{
    public function index(Request $request)
    {
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();

        // 1. Metrics: Appointments
        $countTodayAppts = Appointment::whereDate('appointment_datetime', $today)->count();
        $countYesterdayAppts = Appointment::whereDate('appointment_datetime', $yesterday)->count();
        $apptDiff = $countTodayAppts - $countYesterdayAppts;
        $apptTrendClass = $apptDiff >= 0 ? 'up' : 'down';

        // 2. Metrics: Omzet (Revenue)
        $sumTodayOmzet = MedicalProcedure::whereDate('created_at', $today)->sum('total_amount');
        $sumYesterdayOmzet = MedicalProcedure::whereDate('created_at', $yesterday)->sum('total_amount');
        
        $omzetDiffPercent = 0;
        if ($sumYesterdayOmzet > 0) {
            $omzetDiffPercent = (($sumTodayOmzet - $sumYesterdayOmzet) / $sumYesterdayOmzet) * 100;
        } elseif ($sumTodayOmzet > 0) {
            $omzetDiffPercent = 100;
        }
        $omzetTrendClass = $omzetDiffPercent >= 0 ? 'up' : 'down';

        // 3. Operational Data (Chart Breakdown)
        $subFilter = $request->query('sub_filter', 'status');
        $activeTab = $request->query('tab', 'kunjungan');
        
        $chartData = [];
        if ($activeTab === 'kunjungan') {
            $query = Appointment::whereDate('appointment_datetime', $today);
            
            if ($subFilter === 'status') {
                $chartData = $query->select('status as label', DB::raw('count(*) as total'))
                    ->groupBy('status')
                    ->pluck('total', 'label')
                    ->all();
                // Ensure all statuses exist
                foreach(['pending','confirmed','waiting','engaged','succeed'] as $s) {
                    if(!isset($chartData[$s])) $chartData[$s] = 0;
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
                // Map to labels
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

        // 4. Tab Specific Data
        $tabData = [];

        if ($activeTab === 'prosedur') {
            $tabData = MedicalProcedure::whereDate('created_at', $today)
                ->with(['patient', 'doctor'])
                ->latest()
                ->get();
        } elseif ($activeTab === 'resep') {
            // Count total medicines used today via MedicalProcedure
            $todayMedicinesCount = ProcedureMedicine::whereHas('medicalProcedure', function($q) use ($today) {
                $q->whereDate('created_at', $today);
            })->count();
            $tabData = ['total' => $todayMedicinesCount];
        }

        // 5. Financial Breakdown (Placeholder for now as no explicit expense table exists)
        $totalMasuk = $sumTodayOmzet;
        $totalKeluar = 0; // Placeholder
        $saldoAkhir = $totalMasuk - $totalKeluar;
        $profitMargin = $totalMasuk > 0 ? (($totalMasuk - $totalKeluar) / $totalMasuk) * 100 : 0;

        return view('admin.layout.office', [
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
            'activeTab' => $activeTab,
            'tabData' => $tabData,
            
            'totalMasuk' => $totalMasuk,
            'totalKeluar' => $totalKeluar,
            'saldoAkhir' => $saldoAkhir,
            'profitMargin' => round($profitMargin, 1),
        ]);
    }
}
