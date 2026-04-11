@extends('admin.layout.admin')
@section('title', 'Dashboard')

@section('navbar')
    @include('admin.components.navbar', ['title' => 'Dashboard'])
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/pages/dashboard.css') }}">
@endpush

@section('content')
<div class="dash-container">
    {{-- Page Header --}}
    <div class="dash-header">
        <h1 class="dash-title">Dashboard</h1>
        <p class="dash-subtitle">hanglekiu dental specialist</p>
    </div>

    <div class="dash-layout">

        <div class="dash-left-col">
            
            {{-- Card: Grafik Kunjungan --}}
            <div class="dash-card dash-chart-card">
                <div class="dash-chart-filters">
                    <select class="dash-select"><option>Kunjungan Sakit</option></select>
                    <select class="dash-select"><option>Gigi</option></select>
                    <select class="dash-select"><option>Bulan</option></select>
                </div>
                
                <div class="dash-chart-stats">
                    <span class="dash-chart-number">74</span>
                    <span class="dash-trend trend-down"><i class="fas fa-arrow-down"></i> 27.91% <small>dari Bulan lalu</small></span>
                </div>

                {{-- Mockup Bar Chart CSS --}}
                <div class="dash-bar-chart-wrapper" style="overflow-x: auto; padding-bottom: 8px;">
                    <div class="dash-bar-chart" style="min-width: 500px;">
                        <div class="y-axis">
                            <span>40</span><span>30</span><span>20</span><span>10</span><span>0</span>
                        </div>
                        <div class="bar-area">
                            {{-- Garis grid background --}}
                            <div class="grid-line" style="bottom: 25%"></div>
                            <div class="grid-line" style="bottom: 50%"></div>
                            <div class="grid-line" style="bottom: 75%"></div>
                            <div class="grid-line" style="bottom: 100%"></div>
                            
                            {{-- Bars --}}
                            <div class="bar-group"><div class="bar" style="height: 100%;"></div><span>Jan</span></div>
                            <div class="bar-group"><div class="bar" style="height: 75%;"></div><span>Feb</span></div>
                            <div class="bar-group"><div class="bar" style="height: 0%;"></div><span>Mar</span></div>
                            <div class="bar-group"><div class="bar" style="height: 0%;"></div><span>Apr</span></div>
                            <div class="bar-group"><div class="bar" style="height: 0%;"></div><span>May</span></div>
                            <div class="bar-group"><div class="bar" style="height: 0%;"></div><span>Jun</span></div>
                            <div class="bar-group"><div class="bar" style="height: 0%;"></div><span>Jul</span></div>
                            <div class="bar-group"><div class="bar" style="height: 0%;"></div><span>Aug</span></div>
                            <div class="bar-group"><div class="bar" style="height: 0%;"></div><span>Sep</span></div>
                            <div class="bar-group"><div class="bar" style="height: 0%;"></div><span>Oct</span></div>
                            <div class="bar-group"><div class="bar" style="height: 0%;"></div><span>Nov</span></div>
                            <div class="bar-group"><div class="bar" style="height: 0%;"></div><span>Dec</span></div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Row Bawah: Donut Chart & Finansial --}}
            <div class="dash-bottom-row">
                {{-- Card: Total Kunjungan (Donut Chart) --}}
                <div class="dash-card dash-donut-card">
                    <div class="dash-donut-header">
                        <span class="dash-card-title">Total Kunjungan <i class="fas fa-info-circle info-icon"></i></span>
                        <span class="dash-badge badge-blue">Tidak Terhubung BPJS</span>
                    </div>
                    
                    <div class="dash-donut-content">
                        {{-- CSS Donut Chart Mockup --}}
                        <div class="dash-donut-chart">
                            <div class="donut-hole">
                                <span class="donut-number">363</span>
                                <span class="donut-label">Pasien</span>
                            </div>
                        </div>
                        
                        <div class="dash-donut-legend">
                            <div class="legend-item"><span class="dot" style="background: #582C0C;"></span> Rawat Jalan <strong>363</strong></div>
                            <div class="legend-item"><span class="dot" style="background: #C58F59;"></span> Rawat Inap <strong>0</strong></div>
                            <div class="legend-item"><span class="dot" style="background: #E5D6C5;"></span> Kunjungan Sehat <strong>0</strong></div>
                            <div class="legend-item"><span class="dot" style="background: #FDF8F4;"></span> Apotek <strong>0</strong></div>
                        </div>
                    </div>
                </div>

                {{-- Wrapper Card Finansial --}}
                <div class="dash-finance-wrapper">
                    <div class="dash-card dash-stat-card" data-stat="income">
                        <div class="stat-header">
                            <i class="fas fa-wallet stat-icon"></i> <i class="fas fa-info-circle info-icon"></i>
                        </div>
                        <p class="stat-title">Pendapatan Bulan Ini</p>
                        <div class="stat-value-row">
                            <span class="stat-value">Rp11.200.000</span>
                            <span class="dash-trend trend-down"><i class="fas fa-arrow-down"></i> 47.91%</span>
                        </div>
                        <p class="stat-desc">dari Februari</p>
                    </div>
                    
                    <div class="dash-card dash-stat-card" data-stat="expense">
                        <div class="stat-header">
                            <i class="fas fa-money-bill-wave stat-icon"></i> <i class="fas fa-info-circle info-icon"></i>
                        </div>
                        <p class="stat-title">Pengeluaran Bulan Ini</p>
                        <div class="stat-value-row">
                            <span class="stat-value">Rp0</span>
                            <span class="dash-trend trend-up"><i class="fas fa-arrow-up"></i> 0%</span>
                        </div>
                        <p class="stat-desc">dari Februari</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- KOLOM KANAN --}}
        <div class="dash-right-col">
            
            {{-- Grid Statistik (Mini Cards) --}}
            <div class="dash-stats-grid">
                <div class="dash-card dash-mini-card" data-stat="avg-wait">
                    <div class="stat-header"><i class="fas fa-clock stat-icon"></i></div>
                    <p class="stat-title">Rata-Rata Waktu Tunggu Dokter</p>
                    <div class="stat-value-row">
                        <span class="stat-value">0 m 3 s</span>
                        <span class="dash-trend trend-up"><i class="fas fa-arrow-up"></i> 91.8%</span>
                    </div>
                </div>

                <div class="dash-card dash-mini-card" data-stat="new-patients">
                    <div class="stat-header"><i class="fas fa-user-plus stat-icon"></i></div>
                    <p class="stat-title">Pasien Baru</p>
                    <div class="stat-value-row">
                        <span class="stat-value">9</span>
                        <span class="dash-trend trend-down"><i class="fas fa-arrow-down"></i> 52.63%</span>
                    </div>
                </div>

                <div class="dash-card dash-mini-card" data-stat="total-patients">
                    <div class="stat-header"><i class="fas fa-file-medical stat-icon"></i></div>
                    <p class="stat-title">Pasien Terdaftar</p>
                    <div class="stat-value-row">
                        <span class="stat-value">383</span>
                        <span class="dash-trend trend-up"><i class="fas fa-arrow-up"></i> 2.35%</span>
                    </div>
                </div>

                <div class="dash-card dash-mini-card" data-stat="avg-consult">
                    <div class="stat-header"><i class="fas fa-stopwatch stat-icon"></i></div>
                    <p class="stat-title">Rata-Rata Waktu Konsultasi</p>
                    <div class="stat-value-row">
                        <span class="stat-value">23 m 18 s</span>
                        <span class="dash-trend trend-down"><i class="fas fa-arrow-down"></i> 93.9%</span>
                    </div>
                </div>

                <div class="dash-card dash-mini-card" data-stat="low-stock">
                    <div class="stat-header"><i class="fas fa-pills stat-icon"></i></div>
                    <p class="stat-title">Stok Menipis</p>
                    <div class="stat-value-row">
                        <span class="stat-value">0</span>
                    </div>
                </div>

                <div class="dash-card dash-mini-card">
                    <div class="stat-header"><i class="fas fa-hourglass-half stat-icon"></i></div>
                    <p class="stat-title">Rata-Rata Waktu Tunggu Apotek</p>
                    <div class="stat-value-row">
                        <span class="stat-value">0 m 0 s</span>
                        <span class="dash-trend trend-up"><i class="fas fa-arrow-up"></i> 0%</span>
                    </div>
                </div>
            </div>

            {{-- Card Tabel Pasien AntriCepat --}}
            <div class="dash-card dash-table-card">
                <div class="table-header-top">
                    <h3 class="dash-card-title">Pasien AntriCepat</h3>
                    <p class="dash-card-subtitle">Last Update: -</p>
                </div>
                
                <div class="table-actions">
                    <button class="action-btn"><i class="fas fa-sort"></i> SORTIR</button>
                    <button class="action-btn"><i class="fas fa-filter"></i> FILTER</button>
                </div>

                <div class="dash-table-container">
                    <table class="dash-table">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Tenaga Medis</th>
                                <th>Jadwal</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="4" class="empty-state">Belum ada pasien antrian</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="table-footer">
                    <span>Rows per page: <strong>8 <i class="fas fa-caret-down"></i></strong></span>
                    <span>0-0 of 0</span>
                    <div class="pagination-icons">
                        <i class="fas fa-chevron-left disabled"></i>
                        <i class="fas fa-chevron-right disabled"></i>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
const API = '/api/admin/dashboard';
let filters = {
    month: new Date().getMonth() + 1,
    year:  new Date().getFullYear(),
    visit_type: '',
    poli_id: '',
};

// ── Fetch utama ───────────────────────────────────────────────────────────
async function fetchDashboard() {
    const params = new URLSearchParams(
        Object.fromEntries(Object.entries(filters).filter(([,v]) => v !== ''))
    );
    try {
        const res  = await fetch(`${API}?${params}`, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            }
        });
        const data = await res.json();

        renderBarChart(data.bar_chart);
        renderDonut(data.donut);
        renderStats(data.stats);
        renderFinancial(data.financial);
        renderQueue(data.queue);
    } catch (e) {
        console.error('Dashboard fetch error:', e);
    }
}

// ── Bar Chart ─────────────────────────────────────────────────────────────
function renderBarChart(chart) {
    const maxVal = Math.max(...chart.data.map(d => d.total), 1);
    document.querySelectorAll('.bar-group').forEach((group, i) => {
        const bar = group.querySelector('.bar');
        const pct = (chart.data[i].total / maxVal) * 100;
        bar.style.height = pct + '%';
        bar.title = chart.data[i].total + ' kunjungan';
    });

    document.querySelector('.dash-chart-number').textContent = chart.current_total;

    const trendEl = document.querySelector('.dash-chart-stats .dash-trend');
    const isDown  = chart.trend_percent < 0;
    trendEl.className = `dash-trend ${isDown ? 'trend-down' : 'trend-up'}`;
    trendEl.innerHTML = `<i class="fas fa-arrow-${isDown ? 'down' : 'up'}"></i>
                         ${Math.abs(chart.trend_percent)}%
                         <small>dari Bulan lalu</small>`;
}

// Donut
const DONUT_COLORS = ['#582C0C', '#C58F59', '#E5D6C5', '#9B7B62', '#6B513E', '#D4A574'];

function escapeHtml(text) {
    const d = document.createElement('div');
    d.textContent = text == null ? '' : String(text);
    return d.innerHTML;
}

function renderDonut(donut) {
    const total = Number(donut.total) || 0;
    document.querySelector('.donut-number').textContent = total;

    const legend = document.querySelector('.dash-donut-legend');
    const chartEl = document.querySelector('.dash-donut-chart');
    const rows = Array.isArray(donut.breakdown) ? donut.breakdown : [];

    if (!rows.length || total === 0) {
        legend.innerHTML = '<div class="legend-item"><span class="dot" style="background:#E5D6C5;"></span> <span>Belum ada kunjungan pada bulan ini</span> <strong>0</strong></div>';
        chartEl.style.background = '#E5D6C5';
        return;
    }

    legend.innerHTML = rows.map((b, i) => {
        const n = Number(b.total) || 0;
        const label = b.visit_type ?? b.name ?? 'Lainnya';
        const color = DONUT_COLORS[i % DONUT_COLORS.length];
        return `<div class="legend-item"><span class="dot" style="background:${color};"></span> ${escapeHtml(label)} <strong>${n}</strong></div>`;
    }).join('');

    let acc = 0;
    const parts = rows.map((b, i) => {
        const n = Number(b.total) || 0;
        const pct = total > 0 ? (n / total) * 100 : 0;
        const start = acc;
        acc += pct;
        const color = DONUT_COLORS[i % DONUT_COLORS.length];
        return `${color} ${start}% ${acc}%`;
    });
    chartEl.style.background = `conic-gradient(${parts.join(', ')})`;
}

// ── Stats Cards ───────────────────────────────────────────────────────────
function renderStats(stats) {
    setCard('new-patients',   stats.new_patients.value,   stats.new_patients.trend);
    setCard('total-patients', stats.total_patients.value, stats.total_patients.trend);
    setCard('low-stock',      stats.low_stock);
    setCard('avg-wait',       formatSeconds(stats.avg_wait_seconds));
    setCard('avg-consult',    formatSeconds(stats.avg_consult_seconds));
}

// ── Financial ─────────────────────────────────────────────────────────────
function renderFinancial(financial) {
    setCard('income',  financial.income.value,  financial.income.trend,  true);
    setCard('expense', financial.expense.value, financial.expense.trend, true);
}

// ── Queue Table ───────────────────────────────────────────────────────────
function renderQueue(queue) {
    const tbody = document.querySelector('.dash-table tbody');
    if (!queue.length) {
        tbody.innerHTML = '<tr><td colspan="4" class="empty-state">Belum ada pasien antrian</td></tr>';
        return;
    }
    const statusLabel = {
        pending:   'Menunggu',
        confirmed: 'Terkonfirmasi',
        waiting:   'Menunggu Dokter',
        engaged:   'Sedang Diperiksa',
    };
    tbody.innerHTML = queue.map(q => `
        <tr>
            <td>${q.patient_name}</td>
            <td>${q.doctor_name}</td>
            <td>${q.schedule ?? '-'}</td>
            <td><span class="badge-status status-${q.status}">
                ${statusLabel[q.status] ?? q.status}
            </span></td>
        </tr>
    `).join('');
}

// ── Helpers ───────────────────────────────────────────────────────────────
function formatSeconds(sec) {
    const m = Math.floor(sec / 60);
    const s = sec % 60;
    return `${m} m ${s} s`;
}

function setCard(key, value, trend = null, isCurrency = false) {
    const card = document.querySelector(`[data-stat="${key}"]`);
    if (!card) return;
    const valEl   = card.querySelector('.stat-value');
    const trendEl = card.querySelector('.dash-trend');
    if (valEl) valEl.textContent = isCurrency
        ? 'Rp' + Number(value).toLocaleString('id-ID')
        : value;
    if (trendEl && trend !== null) {
        const isDown = trend < 0;
        trendEl.className = `dash-trend ${isDown ? 'trend-down' : 'trend-up'}`;
        trendEl.innerHTML = `<i class="fas fa-arrow-${isDown ? 'down' : 'up'}"></i> ${Math.abs(trend)}%`;
    }
}

// ── Load dropdown filter ──────────────────────────────────────────────────
async function loadFilters() {
    const [vtRes, poliRes] = await Promise.all([
        fetch('/api/admin/master/visit-types'),
        fetch('/api/admin/master/poli'),
    ]);
    const visitTypes = await vtRes.json();
    const polis      = await poliRes.json();

    const vtSelect   = document.querySelectorAll('.dash-select')[0];
    const poliSelect = document.querySelectorAll('.dash-select')[1];

    visitTypes.forEach(vt => {
        const opt = new Option(vt.name, vt.id);
        vtSelect.add(opt);
    });
    polis.forEach(p => {
        const opt = new Option(p.name, p.id);
        poliSelect.add(opt);
    });

    vtSelect.addEventListener('change', e => {
        filters.visit_type = e.target.value;
        fetchDashboard();
    });
    poliSelect.addEventListener('change', e => {
        filters.poli_id = e.target.value;
        fetchDashboard();
    });
}

// ── Init ──────────────────────────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', async () => {
    await loadFilters();
    fetchDashboard();
    setInterval(fetchDashboard, 60_000);
});
</script>
@endpush