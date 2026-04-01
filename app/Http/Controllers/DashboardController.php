<?php

namespace App\Http\Controllers; 

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $month     = (int) $request->input('month', Carbon::now()->month);
        $year      = (int) $request->input('year',  Carbon::now()->year);
        $visitType = $request->input('visit_type');
        $poliId    = $request->input('poli_id');
        $prevMonth = Carbon::create($year, $month, 1)->subMonth();

        return response()->json([
            'bar_chart' => $this->barChart($year, $visitType, $poliId, $month),
            'donut'     => $this->donut($month, $year),
            'stats'     => $this->stats($month, $year, $prevMonth),
            'financial' => $this->financial($month, $year, $prevMonth),
            'queue'     => $this->queue(),
        ]);
    }

    // ── 1. Bar Chart ──────────────────────────────────────────────────────
    private function barChart($year, $visitType, $poliId, $currentMonth)
    {
        $query = DB::table('registration')
            ->selectRaw('MONTH(registration_date) as month, COUNT(*) as total')
            ->whereYear('registration_date', $year)
            ->whereNull('deleted_at')
            ->whereNotIn('status', ['cancelled']);

        if ($visitType) $query->where('visit_type_id', $visitType);
        if ($poliId)    $query->where('poli_id', $poliId);

        $rows = $query->groupByRaw('MONTH(registration_date)')
                      ->get()->keyBy('month');

        $data = [];
        for ($m = 1; $m <= 12; $m++) {
            $data[] = ['month' => $m, 'total' => $rows->get($m)?->total ?? 0];
        }

        $currentTotal = $rows->get($currentMonth)?->total ?? 0;
        $prevM        = $currentMonth > 1 ? $currentMonth - 1 : 12;
        $prevTotal    = $rows->get($prevM)?->total ?? 0;

        return [
            'data'          => $data,
            'current_total' => $currentTotal,
            'trend_percent' => $this->trend($currentTotal, $prevTotal),
        ];
    }

    // ── 2. Donut ──────────────────────────────────────────────────────────
    private function donut($month, $year)
    {
        $rows = DB::table('registration as r')
            ->join('master_visit_type as vt', 'r.visit_type_id', '=', 'vt.id')
            ->selectRaw('vt.name as visit_type, COUNT(*) as total')
            ->whereMonth('r.registration_date', $month)
            ->whereYear('r.registration_date', $year)
            ->whereNull('r.deleted_at')
            ->whereNotIn('r.status', ['cancelled'])
            ->groupBy('vt.name')
            ->get();

        return [
            'total'     => $rows->sum('total'),
            'breakdown' => $rows,
        ];
    }

    // ── 3. Stats Cards ────────────────────────────────────────────────────
    private function stats($month, $year, $prevMonth)
    {
        $newThis = DB::table('patient')
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->whereNull('deleted_at')->count();

        $newPrev = DB::table('patient')
            ->whereMonth('created_at', $prevMonth->month)
            ->whereYear('created_at', $prevMonth->year)
            ->whereNull('deleted_at')->count();

        $totalNow  = DB::table('patient')->whereNull('deleted_at')->count();
        $totalPrev = DB::table('patient')
            ->whereNull('deleted_at')
            ->where('created_at', '<', Carbon::create($year, $month, 1))
            ->count();

        // Stok menipis: current_stock <= min_stock
        $lowStock = DB::table('consumable_items')
            ->whereColumn('current_stock', '<=', 'min_stock')
            ->count();

        // Waktu tunggu: selisih created_at → appointment_datetime (detik)
        $avgWait = DB::table('registration')
            ->whereMonth('registration_date', $month)
            ->whereYear('registration_date', $year)
            ->whereNull('deleted_at')
            ->whereNotNull('appointment_datetime')
            ->where('appointment_datetime', '>', DB::raw('created_at'))
            ->avg(DB::raw('TIMESTAMPDIFF(SECOND, created_at, appointment_datetime)'));

        // Rata-rata durasi konsultasi dari duration_minutes → konversi ke detik
        $avgConsult = DB::table('registration')
            ->whereMonth('registration_date', $month)
            ->whereYear('registration_date', $year)
            ->whereNull('deleted_at')
            ->whereNotNull('duration_minutes')
            ->where('duration_minutes', '>', 0)
            ->avg('duration_minutes');

        return [
            'new_patients'        => ['value' => $newThis,   'trend' => $this->trend($newThis, $newPrev)],
            'total_patients'      => ['value' => $totalNow,  'trend' => $this->trend($totalNow, $totalPrev)],
            'low_stock'           => $lowStock,
            'avg_wait_seconds'    => round($avgWait ?? 0),
            'avg_consult_seconds' => round(($avgConsult ?? 0) * 60),
        ];
    }

    // ── 4. Financial ──────────────────────────────────────────────────────
    private function financial($month, $year, $prevMonth)
    {
        // Pendapatan: SUM(total_amount) dari medical_procedure
        $incomeThis = DB::table('medical_procedure as mp')
            ->join('registration as r', 'mp.registration_id', '=', 'r.id')
            ->whereMonth('r.registration_date', $month)
            ->whereYear('r.registration_date', $year)
            ->whereNull('r.deleted_at')
            ->whereNull('mp.deleted_at')
            ->sum('mp.total_amount');

        $incomePrev = DB::table('medical_procedure as mp')
            ->join('registration as r', 'mp.registration_id', '=', 'r.id')
            ->whereMonth('r.registration_date', $prevMonth->month)
            ->whereYear('r.registration_date', $prevMonth->year)
            ->whereNull('r.deleted_at')
            ->whereNull('mp.deleted_at')
            ->sum('mp.total_amount');

        // Pengeluaran: purchase_price * quantity_added dari consumable_restock
        // hanya tipe 'restock' (bukan 'return')
        $expenseThis = DB::table('consumable_restock')
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->where('restock_type', 'restock')
            ->sum(DB::raw('purchase_price * quantity_added'));

        $expensePrev = DB::table('consumable_restock')
            ->whereMonth('created_at', $prevMonth->month)
            ->whereYear('created_at', $prevMonth->year)
            ->where('restock_type', 'restock')
            ->sum(DB::raw('purchase_price * quantity_added'));

        return [
            'income'  => ['value' => (float)$incomeThis,  'trend' => $this->trend($incomeThis,  $incomePrev)],
            'expense' => ['value' => (float)$expenseThis, 'trend' => $this->trend($expenseThis, $expensePrev)],
        ];
    }

    // ── 5. Antrian Aktif Hari Ini ─────────────────────────────────────────
    private function queue()
{
    return DB::table('registration as r')
        ->join('patient as p', 'r.patient_id', '=', 'p.id')
        ->join('doctor as d', 'r.doctor_id', '=', 'd.id')
        ->select(
            'p.full_name as patient_name',
            'd.full_name as doctor_name',
            'r.appointment_datetime as schedule', 
            'r.status',
            'r.appointment_datetime'
        )
        ->whereDate('r.registration_date', Carbon::today())
        ->whereNull('r.deleted_at')
        ->whereNotIn('r.status', ['cancelled', 'done'])
        ->orderBy('r.appointment_datetime')
        ->limit(50)
        ->get();
}

    // ── Helper ────────────────────────────────────────────────────────────
    private function trend($current, $previous): float
    {
        if ($previous == 0) return 0;
        return round((($current - $previous) / $previous) * 100, 2);
    }
}