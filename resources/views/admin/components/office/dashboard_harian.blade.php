@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/components/office/dashboard_harian.css') }}">
@endpush

{{-- resources/views/admin/office/dashboard_harian.blade.php --}}
{{-- Re-use the full dashboard content from the original office.blade.php --}}

@php $activeTab = request('tab', 'kunjungan'); @endphp
{{-- ═══ RINGKASAN HARIAN ═══ --}}
<div style="margin-bottom:28px;">
    <div class="dsh-section-header">
        <h2 class="dsh-section-title">Ringkasan Harian</h2>
        <button class="dsh-btn-export">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
            Export PDF
        </button>
    </div>
    <div class="dsh-stat-grid">
        <div class="dsh-stat-card">
            <div class="dsh-stat-card-top">
                <p class="dsh-stat-label">Appointment Hari Ini</p>
                <div class="dsh-stat-icon blue">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
            </div>
            <p class="dsh-stat-number default"></p>
            <p class="dsh-stat-change">
                @if($apptDiff >= 0)
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#10B981" stroke-width="2.5"><polyline points="18 15 12 9 6 15"/></svg>
                    <span style="color:#10B981;">+{{ $apptDiff }}</span>
                @else
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#EF4444" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>
                    <span style="color:#EF4444;">{{ $apptDiff }}</span>
                @endif
                dari kemarin
            </p>
        </div>
        <div class="dsh-stat-card">
            <div class="dsh-stat-card-top">
                <p class="dsh-stat-label">Total Omzet</p>
                <div class="dsh-stat-icon green">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/><polyline points="16 7 22 7 22 13"/></svg>
                </div>
            </div>
            <p class="dsh-stat-number green">Rp {{ number_format($sumTodayOmzet, 0, ',', '.') }}</p>
            <p class="dsh-stat-change">
                @if($omzetDiffPercent >= 0)
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#10B981" stroke-width="2.5"><polyline points="18 15 12 9 6 15"/></svg>
                    <span style="color:#10B981;">+{{ $omzetDiffPercent }}%</span>
                @else
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#EF4444" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>
                    <span style="color:#EF4444;">{{ $omzetDiffPercent }}%</span>
                @endif
                dari kemarin
            </p>
        </div>
        <div class="dsh-stat-card">
            <div class="dsh-stat-card-top">
                <p class="dsh-stat-label">Total Pengeluaran</p>
                <div class="dsh-stat-icon orange">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 17 13.5 8.5 8.5 13.5 2 7"/><polyline points="16 17 22 17 22 11"/></svg>
                </div>
            </div>
            <p class="dsh-stat-number orange">Rp 0</p>
            <p class="dsh-stat-change" style="color:#9CA3AF;"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#9CA3AF" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>0.0% dari kemarin</p>
        </div>
        <div class="dsh-stat-card">
            <div class="dsh-stat-card-top">
                <p class="dsh-stat-label">Saldo Harian</p>
                <div class="dsh-stat-icon purple">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                </div>
            </div>
            <p class="dsh-stat-number purple">Rp {{ number_format($saldoAkhir, 0, ',', '.') }}</p>
            <p class="dsh-stat-change">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#10B981" stroke-width="2.5"><polyline points="18 15 12 9 6 15"/></svg>
                <span style="color:#10B981;">Active</span>
            </p>
        </div>
    </div>
</div>

{{-- ═══ DETAIL OPERASIONAL ═══ --}}
<div style="margin-bottom:28px;">
    <h2 class="dsh-section-title" style="margin-bottom:14px;">Detail Operasional</h2>
    <div class="dsh-card">
        <div class="dsh-tabs"> 
            @foreach(['kunjungan'=>'Kunjungan','prosedur'=>'Prosedur','resep'=>'Resep','kasir'=>'Kasir'] as $k=>$l)
                <a href="?menu=dashboard-harian&tab={{ $k }}" class="dsh-tab {{ $activeTab===$k ? 'active' : 'inactive' }}">
                    {{ $l }}
                </a>
            @endforeach
        </div>
        <div class="dsh-detail-body">
            <div class="dsh-filter-col">
                <a href="?menu=dashboard-harian&tab=kunjungan&sub_filter=status" class="dsh-filter-item {{ $subFilter==='status' ? 'active' : '' }}">Status Kunjungan</a>
                <a href="?menu=dashboard-harian&tab=kunjungan&sub_filter=visit_type" class="dsh-filter-item {{ $subFilter==='visit_type' ? 'active' : '' }}">Tipe Kunjungan</a>
                <a href="?menu=dashboard-harian&tab=kunjungan&sub_filter=patient_type" class="dsh-filter-item {{ $subFilter==='patient_type' ? 'active' : '' }}">Tipe Pasien</a>
                <a href="?menu=dashboard-harian&tab=kunjungan&sub_filter=guarantor_type" class="dsh-filter-item {{ $subFilter==='guarantor_type' ? 'active' : '' }}">Jenis Pasien</a>
            </div>
            <div class="dsh-chart-area">
                @if($activeTab === 'kunjungan')
                    <div style="display:flex; gap:12px; align-items:flex-end; height:60px; margin-bottom:12px;">
                        @foreach($chartData as $label => $count)
                            @php 
                                $maxCount = count($chartData) > 0 ? max(array_values($chartData)) : 1;
                                $height = $maxCount > 0 ? ($count / $maxCount) * 50 : 0;
                                
                                // Color mapping logic
                                $colors = ['pending'=>'#EF4444','confirmed'=>'#F59E0B','waiting'=>'#8B5CF6','engaged'=>'#3B82F6','succeed'=>'#84CC16'];
                                $color = $colors[strtolower($label)] ?? '#C58F59';
                            @endphp
                            <div style="width:14px; height:{{ $height }}px; background-color:{{ $color }}; border-radius:3px;" title="{{ $label }}: {{ $count }}"></div>
                        @endforeach
                    </div>
                    @if($countTodayAppts > 0)
                        <p class="dsh-empty-title">Total {{ $countTodayAppts }} Pasien</p>
                        <p class="dsh-empty-sub">Berdasarkan {{ str_replace('_', ' ', $subFilter) }} hari ini</p>
                    @else
                        <p class="dsh-empty-title">Data Tidak Ditemukan</p>
                        <p class="dsh-empty-sub">Tidak ada kunjungan untuk hari ini</p>
                    @endif
                @elseif($activeTab === 'prosedur')
                    <div style="text-align:center;">
                        <p class="dsh-empty-title" style="font-size:24px; color:#C58F59;">{{ count($tabData) }}</p>
                        <p class="dsh-empty-sub">Prosedur dilakukan hari ini</p>
                    </div>
                @elseif($activeTab === 'resep')
                    <div style="text-align:center;">
                        <p class="dsh-empty-title" style="font-size:24px; color:#C58F59;">{{ $tabData['total'] ?? 0 }}</p>
                        <p class="dsh-empty-sub">Obat/Resep diberikan hari ini</p>
                    </div>
                @else
                    <p class="dsh-empty-title">Data Segera Hadir</p>
                    <p class="dsh-empty-sub">Modul kasir sedang dalam sinkronisasi</p>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- ═══ BREAKDOWN KEUANGAN ═══ --}}
<div style="margin-bottom:28px;">
    <h2 class="dsh-section-title" style="margin-bottom:14px;">Breakdown Keuangan</h2>
    <div class="dsh-breakdown-grid">
        <div class="dsh-breakdown-card">
            <p class="dsh-breakdown-heading"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#10B981" stroke-width="2.5"><polyline points="18 15 12 9 6 15"/></svg>Uang Masuk</p>
            <div class="dsh-breakdown-row"><span class="dsh-breakdown-row-label"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>Pasien Umum</span><span class="dsh-breakdown-row-amount">Rp {{ number_format($totalMasuk, 0, ',', '.') }}</span></div>
            <div class="dsh-breakdown-row"><span class="dsh-breakdown-row-label"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3 21l18 0"/><path d="M5 21v-16a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16"/></svg>Return Obat dan BHP</span><span class="dsh-breakdown-row-amount">Rp 0</span></div>
        </div>
        <div class="dsh-breakdown-card">
            <p class="dsh-breakdown-heading"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#EF4444" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>Uang Keluar</p>
            <div class="dsh-breakdown-row"><span class="dsh-breakdown-row-label"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>Gaji & Komisi</span><span class="dsh-breakdown-row-amount">Rp 0</span></div>
            <div class="dsh-breakdown-row"><span class="dsh-breakdown-row-label"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3 21l18 0"/><path d="M5 21v-16a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16"/></svg>Restock Obat dan BHP</span><span class="dsh-breakdown-row-amount">Rp 0</span></div>
        </div>
        <div class="dsh-breakdown-card">
            <p class="dsh-breakdown-heading"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#C58F59" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-4 0v2M12 12v4M10 14h4"/></svg>Piutang</p>
            <div class="dsh-breakdown-row"><span class="dsh-breakdown-row-label"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#10B981" stroke-width="2.5"><polyline points="18 15 12 9 6 15"/></svg>Total Piutang Hari Ini</span><span class="dsh-breakdown-row-amount" style="color:#10B981;">Rp {{ number_format($receivables, 0, ',', '.') }}</span></div>
        </div>
    </div>
</div>

{{-- ═══ RINGKASAN LABA/RUGI ═══ --}}
<div>
    <h2 class="dsh-section-title" style="margin-bottom:14px; display:flex; align-items:center; gap:8px;">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#C58F59" stroke-width="2"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
        Ringkasan Laba/Rugi Harian
    </h2>
    <div class="dsh-labarugi-grid">
        <div class="dsh-labarugi-card masuk"><p class="dsh-labarugi-label">Total Masuk</p><p class="dsh-labarugi-amount">Rp {{ number_format($totalMasuk, 0, ',', '.') }}</p></div>
        <div class="dsh-labarugi-card keluar"><p class="dsh-labarugi-label">Total Keluar</p><p class="dsh-labarugi-amount">Rp {{ number_format($totalKeluar, 0, ',', '.') }}</p></div>
        <div class="dsh-labarugi-card saldo"><p class="dsh-labarugi-label">Saldo Akhir</p><p class="dsh-labarugi-amount">Rp {{ number_format($saldoAkhir, 0, ',', '.') }}</p><p class="dsh-labarugi-sub">+{{ $profitMargin }}% profit margin</p></div>
    </div>
</div>