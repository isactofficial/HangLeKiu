@extends('admin.layout.admin')
@section('title', 'Dashboard')

@section('navbar')
    @include('admin.components.navbar', ['title' => 'Dashboard'])
@endsection

@section('content')
<div class="dash-container">
    {{-- Page Header --}}
    <div class="dash-header">
        <h1 class="dash-title">Dashboard</h1>
        <p class="dash-subtitle">hanglekiu dental specialist</p>
    </div>

    {{-- Layout Utama (Kiri 65%, Kanan 35%) --}}
    <div class="dash-layout">
        
        {{-- KOLOM KIRI (Grafik & Keuangan) --}}
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
                            
                            {{-- Bars (Warna diganti ke tema cokelat) --}}
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
                    <div class="dash-card dash-stat-card">
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
                    
                    <div class="dash-card dash-stat-card">
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

        {{-- KOLOM KANAN (Statistik Kecil & Tabel Antrian) --}}
        <div class="dash-right-col">
            
            {{-- Grid Statistik (4 Card Atas) --}}
            <div class="dash-stats-grid">
                <div class="dash-card dash-mini-card">
                    <div class="stat-header"><i class="fas fa-clock stat-icon"></i></div>
                    <p class="stat-title">Rata-Rata Waktu Tunggu Dokter</p>
                    <div class="stat-value-row">
                        <span class="stat-value">0 m 3 s</span>
                        <span class="dash-trend trend-up"><i class="fas fa-arrow-up"></i> 91.8%</span>
                    </div>
                </div>

                <div class="dash-card dash-mini-card">
                    <div class="stat-header"><i class="fas fa-user-plus stat-icon"></i></div>
                    <p class="stat-title">Pasien Baru</p>
                    <div class="stat-value-row">
                        <span class="stat-value">9</span>
                        <span class="dash-trend trend-down"><i class="fas fa-arrow-down"></i> 52.63%</span>
                    </div>
                </div>

                <div class="dash-card dash-mini-card">
                    <div class="stat-header"><i class="fas fa-file-medical stat-icon"></i></div>
                    <p class="stat-title">Pasien Terdaftar</p>
                    <div class="stat-value-row">
                        <span class="stat-value">383</span>
                        <span class="dash-trend trend-up"><i class="fas fa-arrow-up"></i> 2.35%</span>
                    </div>
                </div>

                <div class="dash-card dash-mini-card">
                    <div class="stat-header"><i class="fas fa-stopwatch stat-icon"></i></div>
                    <p class="stat-title">Rata-Rata Waktu Konsultasi</p>
                    <div class="stat-value-row">
                        <span class="stat-value">23 m 18 s</span>
                        <span class="dash-trend trend-down"><i class="fas fa-arrow-down"></i> 93.9%</span>
                    </div>
                </div>

                {{-- 2 Card Bawah --}}
                <div class="dash-card dash-mini-card">
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
                            {{-- State Kosong --}}
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

<style>
    /* ===== DASHBOARD PAGE - BROWN THEME ===== */
    .dash-container {
        padding: 0 0px 24px 0px;
        font-family: 'Instrument Sans', sans-serif;
        min-height: 100vh;
    }

    /* Header */
    .dash-header {
        margin-bottom: 20px;
    }
    .dash-title {
        font-size: 30px;
        font-weight: 700;
        color: #582C0C;
    }
    .dash-subtitle {
        font-size: 18.75px;
        color: #C58F59;
    }

    /* Layout System */
    .dash-layout {
        display: flex;
        gap: 20px;
        align-items: flex-start;
    }
    .dash-left-col {
        flex: 1.8; /* Lebih lebar */
        display: flex;
        flex-direction: column;
        gap: 20px;
        min-width: 0;
    }
    .dash-right-col {
        flex: 1; /* Lebih sempit */
        display: flex;
        flex-direction: column;
        gap: 20px;
        min-width: 0;
    }

    /* General Cards */
    .dash-card {
        background: white;
        border-radius: 12px;
        border: 1px solid #E5E7EB;
        padding: 20px;
        box-shadow: 0 1px 2px rgba(0,0,0,0.02);
    }
    .dash-card-title {
        font-size: 13px;
        font-weight: 700;
        color: #582C0C;
    }
    .info-icon {
        color: #9CA3AF;
        font-size: 13px;
        margin-left: 6px;
        cursor: help;
    }

    /* Chart Area */
    .dash-chart-filters {
        display: flex;
        gap: 12px;
        margin-bottom: 16px;
        flex-wrap: wrap;
    }
    .dash-select {
        padding: 8px 12px;
        border: 1px solid #E5D6C5;
        border-radius: 6px;
        font-size: 13px;
        color: #582C0C;
        outline: none;
    }
    .dash-chart-stats {
        margin-bottom: 24px;
    }
    .dash-chart-number {
        font-size: 30px;
        font-weight: 700;
        color: #582C0C;
        margin-right: 12px;
    }

    /* Trend Badges */
    .dash-trend {
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 13px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    .dash-trend small {
        font-weight: 400;
        color: #9CA3AF;
    }
    .trend-down { background: #FEE2E2; color: #EF4444; }
    .trend-up { background: #D1FAE5; color: #10B981; }

    /* CSS Bar Chart Mockup */
    .dash-bar-chart {
        display: flex;
        height: 200px;
        gap: 12px;
    }
    .y-axis {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        font-size: 13px;
        color: #9CA3AF;
        padding-bottom: 24px;
        text-align: right;
    }
    .bar-area {
        flex: 1;
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        position: relative;
        padding-bottom: 24px;
    }
    .grid-line {
        position: absolute;
        left: 0;
        right: 0;
        height: 1px;
        background: #F3F4F6;
        z-index: 1;
    }
    .bar-group {
        display: flex;
        flex-direction: column;
        align-items: center;
        height: 100%;
        justify-content: flex-end;
        z-index: 2;
        width: 30px;
    }
    .bar {
        width: 100%;
        background-color: #C58F59; /* Warna Bar Tema */
        border-radius: 4px 4px 0 0;
        transition: height 0.5s ease;
    }
    .bar-group span {
        font-size: 13px;
        color: #6B7280;
        margin-top: 8px;
        position: absolute;
        bottom: 0;
    }

    /* Donut & Finance Row */
    .dash-bottom-row {
        display: flex;
        gap: 20px;
    }
    .dash-donut-card {
        flex: 1.2;
    }
    .dash-finance-wrapper {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    /* Donut Chart Mockup */
    .dash-donut-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }
    .badge-blue {
        background: #EFF6FF;
        color: #2563EB;
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 600;
    }
    .dash-donut-content {
        display: flex;
        align-items: center;
        gap: 24px;
    }
    .dash-donut-chart {
        width: 140px;
        height: 140px;
        border-radius: 50%;
        background: conic-gradient(#582C0C 100%, #E5E7EB 0); /* 100% karena sisanya 0 */
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .donut-hole {
        width: 100px;
        height: 100px;
        background: white;
        border-radius: 50%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
    .donut-number { font-size: 18.75px; font-weight: 700; color: #582C0C; line-height: 1; }
    .donut-label { font-size: 13px; color: #6B513E; }
    .dash-donut-legend {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }
    .legend-item {
        font-size: 13px;
        color: #6B7280;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .legend-item .dot { width: 10px; height: 10px; border-radius: 50%; }
    .legend-item strong { color: #111827; margin-left: auto; }

    /* Stat Cards */
    .dash-stat-card, .dash-mini-card {
        padding: 16px 20px;
    }
    .stat-header {
        color: #C58F59;
        font-size: 13px;
        margin-bottom: 8px;
    }
    .stat-title {
        font-size: 13px;
        color: #582C0C;
        font-weight: 600;
        margin: 0 0 8px 0;
    }
    .stat-value-row {
        display: flex;
        align-items: center;
        gap: 13px;
    }
    .stat-value {
        font-size: 18.75px;
        font-weight: 700;
        color: #111827;
    }
    .stat-desc {
        font-size: 13px;
        color: #9CA3AF;
        margin: 6px 0 0 0;
    }

    /* Grid for Right Col Mini Cards */
    .dash-stats-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    /* Table Card */
    .dash-table-card {
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    .table-header-top {
        margin-bottom: 16px;
    }
    .dash-card-subtitle {
        font-size: 13px;
        color: #9CA3AF;
        margin: 4px 0 0 0;
    }
    .table-actions {
        display: flex;
        justify-content: flex-end;
        gap: 16px;
        margin-bottom: 16px;
    }
    .action-btn {
        background: none;
        border: none;
        color: #582C0C;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .dash-table-container {
        flex: 1;
        overflow-x: auto;
    }
    .dash-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }
    .dash-table th {
        font-size: 13px;
        color: #6B7280;
        font-weight: 500;
        padding: 12px 8px;
        border-top: 1px solid #E5E7EB;
        border-bottom: 1px solid #E5E7EB;
    }
    .empty-state {
        text-align: center;
        padding: 40px !important;
        color: #9CA3AF;
        font-size: 13px;
    }
    .table-footer {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        padding-top: 16px;
        gap: 20px;
        font-size: 13px;
        color: #6B7280;
    }
    .pagination-icons i { margin-left: 12px; cursor: pointer; }
    .pagination-icons .disabled { color: #D1D5DB; cursor: not-allowed; }

    /* Responsive */
    @media (max-width: 1200px) {
        .dash-layout { flex-direction: column; }
        .dash-left-col, .dash-right-col { width: 100%; }
        .dash-container { padding: 0 16px 24px 16px; }
    }
    @media (max-width: 768px) {
        .dash-bottom-row { flex-direction: column; }
        .dash-stats-grid { grid-template-columns: 1fr; }
        .dash-donut-content { flex-direction: column; align-items: center; }
        .dash-donut-header { flex-direction: column; gap: 12px; align-items: flex-start; }
        .table-footer { flex-direction: column; align-items: flex-start; gap: 12px; }
        .dash-donut-legend { width: 100%; }
    }
    @media (max-width: 480px) {
        .dash-title { font-size: 24px; }
        .dash-chart-number { font-size: 24px; }
        .stat-value { font-size: 16px; }
        .dash-select { width: 100%; }
        .table-actions { flex-direction: column; gap: 8px; align-items: stretch; }
        .action-btn { justify-content: center; }
    }
</style>
@endsection