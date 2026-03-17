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
            <p class="dsh-stat-number default">12</p>
            <p class="dsh-stat-change"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#10B981" stroke-width="2.5"><polyline points="18 15 12 9 6 15"/></svg><span style="color:#10B981;">+2</span> dari kemarin</p>
        </div>
        <div class="dsh-stat-card">
            <div class="dsh-stat-card-top">
                <p class="dsh-stat-label">Total Omzet</p>
                <div class="dsh-stat-icon green">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/><polyline points="16 7 22 7 22 13"/></svg>
                </div>
            </div>
            <p class="dsh-stat-number green">Rp 4,2 jt</p>
            <p class="dsh-stat-change"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#10B981" stroke-width="2.5"><polyline points="18 15 12 9 6 15"/></svg><span style="color:#10B981;">+12.5%</span> dari kemarin</p>
        </div>
        <div class="dsh-stat-card">
            <div class="dsh-stat-card-top">
                <p class="dsh-stat-label">Total Pengeluaran</p>
                <div class="dsh-stat-icon orange">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 17 13.5 8.5 8.5 13.5 2 7"/><polyline points="16 17 22 17 22 11"/></svg>
                </div>
            </div>
            <p class="dsh-stat-number orange">Rp 1,8 jt</p>
            <p class="dsh-stat-change" style="color:#9CA3AF;"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#9CA3AF" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>0.0% dari kemarin</p>
        </div>
        <div class="dsh-stat-card">
            <div class="dsh-stat-card-top">
                <p class="dsh-stat-label">Saldo Harian</p>
                <div class="dsh-stat-icon purple">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                </div>
            </div>
            <p class="dsh-stat-number purple">Rp 2,4 jt</p>
            <p class="dsh-stat-change"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#10B981" stroke-width="2.5"><polyline points="18 15 12 9 6 15"/></svg><span style="color:#10B981;">+8.3%</span> dari kemarin</p>
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
                <div class="dsh-filter-item active">Status Kunjungan</div>
                <div class="dsh-filter-item">Tipe Kunjungan</div>
                <div class="dsh-filter-item">Tipe Pasien</div>
                <div class="dsh-filter-item">Jenis Pasien</div>
            </div>
            <div class="dsh-chart-area">
                <svg width="52" height="52" viewBox="0 0 64 64" fill="none" style="margin-bottom:12px;opacity:.5;">
                    <rect x="4"  y="32" width="12" height="28" rx="2" fill="#C58F59" opacity=".4"/>
                    <rect x="20" y="20" width="12" height="40" rx="2" fill="#C58F59" opacity=".6"/>
                    <rect x="36" y="12" width="12" height="48" rx="2" fill="#C58F59" opacity=".8"/>
                    <rect x="52" y="24" width="12" height="36" rx="2" fill="#C58F59"/>
                </svg>
                <p class="dsh-empty-title">Data Tidak Ditemukan</p>
                <p class="dsh-empty-sub">Tidak ada data untuk ditampilkan</p>
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
            <div class="dsh-breakdown-row"><span class="dsh-breakdown-row-label"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>Pasien Umum</span><span class="dsh-breakdown-row-amount">Rp 3.200.000</span></div>
            <div class="dsh-breakdown-row"><span class="dsh-breakdown-row-label"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3 21l18 0"/><path d="M5 21v-16a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16"/></svg>Return Obat dan BHP</span><span class="dsh-breakdown-row-amount">Rp 150.000</span></div>
        </div>
        <div class="dsh-breakdown-card">
            <p class="dsh-breakdown-heading"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#EF4444" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>Uang Keluar</p>
            <div class="dsh-breakdown-row"><span class="dsh-breakdown-row-label"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>Gaji & Komisi</span><span class="dsh-breakdown-row-amount">Rp 1.200.000</span></div>
            <div class="dsh-breakdown-row"><span class="dsh-breakdown-row-label"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3 21l18 0"/><path d="M5 21v-16a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16"/></svg>Restock Obat dan BHP</span><span class="dsh-breakdown-row-amount">Rp 640.000</span></div>
        </div>
        <div class="dsh-breakdown-card">
            <p class="dsh-breakdown-heading"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#C58F59" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-4 0v2M12 12v4M10 14h4"/></svg>Piutang & Hutang</p>
            <div class="dsh-breakdown-row"><span class="dsh-breakdown-row-label"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#10B981" stroke-width="2.5"><polyline points="18 15 12 9 6 15"/></svg>Piutang</span><span class="dsh-breakdown-row-amount" style="color:#10B981;">Rp 1.800.000</span></div>
            <div class="dsh-breakdown-row"><span class="dsh-breakdown-row-label"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#EF4444" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>Hutang</span><span class="dsh-breakdown-row-amount" style="color:#EF4444;">Rp 4.200.000</span></div>
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
        <div class="dsh-labarugi-card masuk"><p class="dsh-labarugi-label">Total Masuk</p><p class="dsh-labarugi-amount">Rp 3,35 jt</p></div>
        <div class="dsh-labarugi-card keluar"><p class="dsh-labarugi-label">Total Keluar</p><p class="dsh-labarugi-amount">Rp 1,84 jt</p></div>
        <div class="dsh-labarugi-card saldo"><p class="dsh-labarugi-label">Saldo Akhir</p><p class="dsh-labarugi-amount">Rp 1,51 jt</p><p class="dsh-labarugi-sub">+45% profit margin</p></div>
    </div>
</div>