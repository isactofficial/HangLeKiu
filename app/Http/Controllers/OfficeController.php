<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\MedicalProcedure;
use App\Models\ProcedureMedicine;
use App\Models\Patient;
use App\Models\Invoice;
use App\Models\ConsumableRestock;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OfficeController extends Controller
{
    public function index(Request $request)
    {
        $activeMenu = $request->query('menu', 'dashboard-harian');

        if ($activeMenu === 'laporan') {
            return $this->handleLaporanMenu($request);
        }

        return $this->handleDashboardHarian($request);
    }

    // ═══════════════════════════════════════════════════════════
    // DASHBOARD HARIAN
    // ═══════════════════════════════════════════════════════════
    private function handleDashboardHarian(Request $request)
    {
        $activeTab = $request->query('tab', 'kunjungan');
        $today     = Carbon::today();
        $yesterday = Carbon::yesterday();

        $countTodayAppts     = Appointment::whereDate('appointment_datetime', $today)->count();
        $countYesterdayAppts = Appointment::whereDate('appointment_datetime', $yesterday)->count();
        $apptDiff            = $countTodayAppts - $countYesterdayAppts;
        $apptTrendClass      = $apptDiff >= 0 ? 'up' : 'down';

        $sumTodayOmzet     = MedicalProcedure::whereDate('created_at', $today)->sum('total_amount');
        $sumYesterdayOmzet = MedicalProcedure::whereDate('created_at', $yesterday)->sum('total_amount');

        $omzetDiffPercent = 0;
        if ($sumYesterdayOmzet > 0) {
            $omzetDiffPercent = (($sumTodayOmzet - $sumYesterdayOmzet) / $sumYesterdayOmzet) * 100;
        } elseif ($sumTodayOmzet > 0) {
            $omzetDiffPercent = 100;
        }
        $omzetTrendClass = $omzetDiffPercent >= 0 ? 'up' : 'down';

        $subFilter = $request->query('sub_filter', 'status');
        $chartData = [];

        if ($activeTab === 'kunjungan') {
            $query = Appointment::whereDate('appointment_datetime', $today);

            if ($subFilter === 'status') {
                $chartData = $query->select('status as label', DB::raw('count(*) as total'))
                    ->groupBy('status')->pluck('total', 'label')->all();
                foreach (['pending', 'confirmed', 'waiting', 'engaged', 'succeed'] as $s) {
                    if (!isset($chartData[$s])) $chartData[$s] = 0;
                }
            } elseif ($subFilter === 'visit_type') {
                $chartData = $query->join('master_visit_type', 'registration.visit_type_id', '=', 'master_visit_type.id')
                    ->select('master_visit_type.name as label', DB::raw('count(*) as total'))
                    ->groupBy('master_visit_type.name')->pluck('total', 'label')->all();
            } elseif ($subFilter === 'patient_type') {
                $rawTypes  = $query->select('patient_type', DB::raw('count(*) as total'))
                    ->groupBy('patient_type')->pluck('total', 'patient_type')->all();
                $chartData = ['Mandiri' => $rawTypes['non_rujuk'] ?? 0, 'Rujukan' => $rawTypes['rujuk'] ?? 0];
            } elseif ($subFilter === 'guarantor_type') {
                $chartData = $query->join('master_guarantor_type', 'registration.guarantor_type_id', '=', 'master_guarantor_type.id')
                    ->select('master_guarantor_type.name as label', DB::raw('count(*) as total'))
                    ->groupBy('master_guarantor_type.name')->pluck('total', 'label')->all();
            }
        }

        $tabData = [];
        if ($activeTab === 'prosedur') {
            $tabData = MedicalProcedure::whereDate('created_at', $today)->with(['patient', 'doctor'])->latest()->get();
        } elseif ($activeTab === 'resep') {
            $count   = ProcedureMedicine::whereHas('medicalProcedure', fn($q) => $q->whereDate('created_at', $today))->count();
            $tabData = ['total' => $count];
        }

        $totalMasuk   = $sumTodayOmzet;
        $totalKeluar  = 0;
        $saldoAkhir   = $totalMasuk - $totalKeluar;
        $profitMargin = $totalMasuk > 0 ? ($saldoAkhir / $totalMasuk) * 100 : 0;

        return view('admin.layout.office', [
            'activeMenu'          => 'dashboard-harian',
            'activeTab'           => $activeTab,
            'countTodayAppts'     => $countTodayAppts,
            'countYesterdayAppts' => $countYesterdayAppts,
            'apptDiff'            => $apptDiff,
            'apptTrendClass'      => $apptTrendClass,
            'sumTodayOmzet'       => $sumTodayOmzet,
            'sumYesterdayOmzet'   => $sumYesterdayOmzet,
            'omzetDiffPercent'    => round($omzetDiffPercent, 1),
            'omzetTrendClass'     => $omzetTrendClass,
            'subFilter'           => $subFilter,
            'chartData'           => $chartData,
            'tabData'             => $tabData,
            'totalMasuk'          => $totalMasuk,
            'totalKeluar'         => $totalKeluar,
            'saldoAkhir'          => $saldoAkhir,
            'profitMargin'        => round($profitMargin, 1),
        ]);
    }

    // ═══════════════════════════════════════════════════════════
    // LAPORAN (gabungan: Keuangan + Pasien + Akun + dst.)
    // ═══════════════════════════════════════════════════════════
    private function handleLaporanMenu(Request $request)
    {
        $tab     = $request->query('tab', 'keuangan');
        $payload = ['activeMenu' => 'laporan'];

        // ── TAB KEUANGAN ─────────────────────────────────────────
        if ($tab === 'keuangan') {
            $subTab    = $request->query('sub', 'ikhtisar');
            $startDate = $request->query('start_date', now()->startOfMonth()->toDateString());
            $endDate   = $request->query('end_date',   now()->endOfMonth()->toDateString());
            $range     = [$startDate . ' 00:00:00', $endDate . ' 23:59:59'];

            $directIncome = Invoice::where('payment_type', '!=', 'BPJS')
                ->whereBetween('created_at', $range)->sum('amount_paid');
            $bpjsIncome   = Invoice::where('payment_type', 'BPJS')
                ->whereBetween('created_at', $range)->sum('amount_paid');
            $income       = $directIncome + $bpjsIncome;
            $expenses     = ConsumableRestock::where('restock_type', 'restock')
                ->whereBetween('created_at', $range)
                ->sum(DB::raw('purchase_price * quantity_added'));

            $totalClaims = Invoice::where('payment_type', 'BPJS')->sum('amount_paid');
            $kas         = Invoice::sum('amount_paid') - ConsumableRestock::where('restock_type', 'restock')
                ->sum(DB::raw('purchase_price * quantity_added'));

            $tabData = collect();
            if ($subTab === 'pemasukan') {
                $tabData = Invoice::with(['registration.patient', 'registration.doctor'])
                    ->whereBetween('created_at', $range)->orderByDesc('created_at')->paginate(10)->withQueryString();
            } elseif ($subTab === 'pengeluaran') {
                $tabData = ConsumableRestock::with(['item'])->where('restock_type', 'restock')
                    ->whereBetween('created_at', $range)->orderByDesc('created_at')->paginate(10)->withQueryString();
            } elseif ($subTab === 'klaim') {
                $tabData = Invoice::with(['registration.patient'])->where('payment_type', 'BPJS')
                    ->whereBetween('created_at', $range)->orderByDesc('created_at')->paginate(10)->withQueryString();
            }

            $payload = array_merge($payload, compact(
                'subTab', 'startDate', 'endDate',
                'directIncome', 'income', 'expenses',
                'totalClaims', 'kas', 'tabData'
            ));
            $payload['margin'] = $income - $expenses;
        }

        // ── TAB PASIEN ───────────────────────────────────────────
        elseif ($tab === 'pasien') {
            $subTab  = $request->query('sub', 'summary');
            $perPage = (int) $request->query('per_page', 10);
            if (!in_array($perPage, [10, 30, 50, 100])) $perPage = 10;

            // ── Stat cards ────────────────────────────
            $totalPatients        = Patient::count();
            $newPatientsThisMonth = Patient::whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)->count();
            $walkInToday          = Appointment::whereDate('appointment_datetime', now()->toDateString())->count();
            $totalOnlinePatients  = Patient::whereNotNull('user_id')->count();

            // ── Upcoming birthdays ────────────────────
            $upcomingBirthdays = Patient::whereRaw(
                "DATE_FORMAT(date_of_birth, '%m-%d') BETWEEN ? AND ?",
                [now()->format('m-d'), now()->addDays(7)->format('m-d')]
            )->get();

            // ── Chart: Golongan Darah ─────────────────
            $bloodTypeStats = Patient::select('blood_type', DB::raw('count(*) as total'))
                ->whereNotNull('blood_type')->where('blood_type', '!=', '')
                ->groupBy('blood_type')->orderByDesc('total')
                ->pluck('total', 'blood_type')->toArray();
            if (empty($bloodTypeStats)) $bloodTypeStats = ['Belum diisi' => $totalPatients];

            // ── Chart: Gender ─────────────────────────
            $rawGender = Patient::select('gender', DB::raw('count(*) as total'))
                ->groupBy('gender')->pluck('total', 'gender')->toArray();
            $genderStats = [
                'Laki-laki' => $rawGender['Male']   ?? 0,
                'Perempuan' => $rawGender['Female']  ?? 0,
            ];
            if (isset($rawGender[null]) || isset($rawGender[''])) {
                $genderStats['Tidak diisi'] = $rawGender[null] ?? ($rawGender[''] ?? 0);
            }

            // ── Chart: Sumber Pendaftaran ─────────────
            $onlineCount   = Patient::whereNotNull('user_id')->count();
            $langsungCount = Patient::whereNull('user_id')->count();
            $sourceStats   = [
                'Online (Aplikasi/Web)' => $onlineCount,
                'Langsung (Klinik)'     => $langsungCount,
            ];

            // ── Chart: Pendidikan ─────────────────────
            $educationStats = Patient::select('education', DB::raw('count(*) as total'))
                ->whereNotNull('education')->where('education', '!=', '')
                ->groupBy('education')->orderByDesc('total')
                ->pluck('total', 'education')->toArray();

            // ── Chart: Status Pernikahan ──────────────
            $maritalStats = Patient::select('marital_status', DB::raw('count(*) as total'))
                ->whereNotNull('marital_status')->where('marital_status', '!=', '')
                ->groupBy('marital_status')->orderByDesc('total')
                ->pluck('total', 'marital_status')->toArray();

            // ── Chart: Agama ──────────────────────────
            $religionStats = Patient::select('religion', DB::raw('count(*) as total'))
                ->whereNotNull('religion')->where('religion', '!=', '')
                ->groupBy('religion')->orderByDesc('total')
                ->pluck('total', 'religion')->toArray();

            // ── Chart: Pekerjaan ──────────────────────
            $occupationStats = Patient::select('occupation', DB::raw('count(*) as total'))
                ->whereNotNull('occupation')->where('occupation', '!=', '')
                ->groupBy('occupation')->orderByDesc('total')
                ->limit(10)
                ->pluck('total', 'occupation')->toArray();

            // ── Chart: Pertumbuhan 12 Bulan ───────────
            $growthStats = [];
            for ($i = 11; $i >= 0; $i--) {
                $month = now()->subMonths($i);
                $label = $month->format('M Y');
                $growthStats[$label] = Patient::whereYear('created_at', $month->year)
                    ->whereMonth('created_at', $month->month)->count();
            }

            // ── Tabel Data Pasien (dengan filter) ────
            $search       = $request->get('search');
            $genderFilter = $request->get('gender_filter');
            $sourceFilter = $request->get('source_filter');

            $patients = Patient::with(['latestAppointment.guarantorType'])
                ->when($search, fn($q) => $q->where(function($q2) use ($search) {
                    $q2->where('full_name', 'like', "%{$search}%")
                       ->orWhere('medical_record_no', 'like', "%{$search}%")
                       ->orWhere('id_card_number', 'like', "%{$search}%")
                       ->orWhere('phone_number', 'like', "%{$search}%");
                }))
                ->when($genderFilter, fn($q) => $q->where('gender', $genderFilter))
                ->when($sourceFilter === 'online',   fn($q) => $q->whereNotNull('user_id'))
                ->when($sourceFilter === 'langsung', fn($q) => $q->whereNull('user_id'))
                ->orderByDesc('created_at')
                ->paginate($perPage)
                ->withQueryString();

            $payload = array_merge($payload, compact(
                'subTab', 'perPage',
                'totalPatients', 'newPatientsThisMonth', 'walkInToday', 'totalOnlinePatients',
                'upcomingBirthdays',
                'bloodTypeStats', 'genderStats', 'sourceStats',
                'educationStats', 'maritalStats', 'religionStats',
                'occupationStats', 'growthStats',
                'patients'
            ));
        }
        elseif ($tab === 'akun') {
    $subTab    = $request->query('sub', 'ikhtisar');
    $startDate = $request->query('start_date', now()->startOfMonth()->toDateString());
    $endDate   = $request->query('end_date',   now()->endOfMonth()->toDateString());
    $range     = [$startDate . ' 00:00:00', $endDate . ' 23:59:59'];

    // 1. KATEGORI KAS TUNAI (Laci Kasir)
    $kasTunaiIncome = \App\Models\Invoice::whereIn('cash_account', ['Kas Utama Klinik', 'Kas Kecil'])
                        ->where('payment_type', '!=', 'BPJS')
                        ->sum('amount_paid');
    
    // Pengeluaran restock biasanya diambil dari Kas Utama
    $totalExpense = \Illuminate\Support\Facades\DB::table('consumable_restock')
                        ->where('restock_type', 'restock')
                        ->sum(\Illuminate\Support\Facades\DB::raw('purchase_price * quantity_added'));
    
    $saldoKasTunai = $kasTunaiIncome - $totalExpense;

    // 2. KATEGORI REKENING BANK / QRIS
    $saldoBank = \App\Models\Invoice::where('cash_account', 'like', 'Rekening%')
                        ->sum('amount_paid');

    // 3. KATEGORI PIUTANG (BPJS / Asuransi)
    // Piutang adalah tagihan yang statusnya 'BPJS' tapi uangnya belum cair ke Bank
    $totalPiutangBPJS = \App\Models\Invoice::where('payment_type', 'BPJS')
                        ->sum('amount_paid');

    // 4. DATA MUTASI (Berdasarkan Filter Tanggal)
    $mutasiKas = \App\Models\Invoice::whereIn('cash_account', ['Kas Utama Klinik', 'Kas Kecil'])
                    ->whereBetween('created_at', $range)->sum('amount_paid');
    
    $mutasiBank = \App\Models\Invoice::where('cash_account', 'like', 'Rekening%')
                    ->whereBetween('created_at', $range)->sum('amount_paid');

    $mutasiBPJS = \App\Models\Invoice::where('payment_type', 'BPJS')
                    ->whereBetween('created_at', $range)->sum('amount_paid');

    // 5. DATA GRAFIK (6 Bulan Terakhir)
    $chartLabels = []; $chartDataKas = []; $chartDataBank = []; $chartDataBPJS = [];

    for ($i = 5; $i >= 0; $i--) {
        $month = now()->subMonths($i);
        $chartLabels[] = $month->translatedFormat('M Y');
        $mStart = $month->copy()->startOfMonth();
        $mEnd = $month->copy()->endOfMonth();

        $chartDataKas[] = \App\Models\Invoice::whereIn('cash_account', ['Kas Utama Klinik', 'Kas Kecil'])->whereBetween('created_at', [$mStart, $mEnd])->sum('amount_paid');
        $chartDataBank[] = \App\Models\Invoice::where('cash_account', 'like', 'Rekening%')->whereBetween('created_at', [$mStart, $mEnd])->sum('amount_paid');
        $chartDataBPJS[] = \App\Models\Invoice::where('payment_type', 'BPJS')->whereBetween('created_at', [$mStart, $mEnd])->sum('amount_paid');
    }

    return view('admin.layout.office', array_merge($payload, [
        'tab' => $tab,
        'startDate' => $startDate,
        'endDate' => $endDate,
        'saldoKasTunai' => $saldoKasTunai,
        'saldoBank' => $saldoBank,
        'totalPiutangBPJS' => $totalPiutangBPJS,
        'mutasiKas' => $mutasiKas,
        'mutasiBank' => $mutasiBank,
        'mutasiBPJS' => $mutasiBPJS,
        'chartLabels' => $chartLabels,
        'chartDataKas' => $chartDataKas,
        'chartDataBank' => $chartDataBank,
        'chartDataBPJS' => $chartDataBPJS,
    ]));
}
        // ── TAB AKUN / OPERASIONAL / BPJS / GRAFIK ──────────────
        // Tab statis, tidak butuh data tambahan
        else {
            // tidak ada variabel tambahan
        }

        return view('admin.layout.office', $payload);
    }
}