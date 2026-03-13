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
@endsection