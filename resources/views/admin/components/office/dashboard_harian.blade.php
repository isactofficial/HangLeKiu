{{-- resources/views/admin/components/office/dashboard_harian.blade.php --}}

@php $activeTab = request('tab', 'kunjungan'); @endphp

<style>
    .dsh-section-title { font-size: 18.75px; font-weight: 700; color: #582C0C; margin: 0; }
    .dsh-section-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px; }
    .dsh-btn-export { background: #582C0C; color: #fff; border: none; padding: 9px 18px; border-radius: 6px; font-size: 13px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 7px; font-family: inherit; transition: background .2s; white-space: nowrap; }
    .dsh-btn-export:hover { background: #401f08; }

    /* ── Stat Grid ── */
    .dsh-stat-grid { display: grid; grid-template-columns: repeat(4,1fr); gap: 14px; }
    .dsh-stat-card { background: #fff; border: 1px solid #E5D6C5; border-radius: 8px; padding: 16px 18px; box-shadow: 0 1px 3px rgba(88,44,12,.05); }
    .dsh-stat-card-top { display: flex; justify-content: space-between; align-items: flex-start; }
    .dsh-stat-label { font-size: 13px; color: #6B513E; margin: 0; }
    .dsh-stat-icon { width: 36px; height: 36px; border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .dsh-stat-icon.blue   { background: #EFF6FF; color: #3B82F6; }
    .dsh-stat-icon.green  { background: #ECFDF5; color: #10B981; }
    .dsh-stat-icon.orange { background: #FFF7ED; color: #F97316; }
    .dsh-stat-icon.purple { background: #F5F3FF; color: #8B5CF6; }
    .dsh-stat-number { font-size: 30px; font-weight: 700; line-height: 1; margin: 6px 0 4px; }
    .dsh-stat-number.green  { color: #10B981; }
    .dsh-stat-number.orange { color: #F97316; }
    .dsh-stat-number.purple { color: #8B5CF6; }
    .dsh-stat-number.default { color: #582C0C; }
    .dsh-stat-change { font-size: 13px; color: #6B513E; display: flex; align-items: center; gap: 4px; }

    /* ── Card & Tabs ── */
    .dsh-card { background: #fff; border: 1px solid #E5D6C5; border-radius: 8px; box-shadow: 0 1px 3px rgba(88,44,12,.05); overflow: hidden; }
    .dsh-tabs { display: flex; gap: 8px; padding: 16px 20px; border-bottom: 1px solid #E5D6C5; flex-wrap: wrap; }
    .dsh-tab { display: inline-flex; align-items: center; gap: 7px; padding: 8px 18px; border-radius: 6px; font-size: 13px; font-weight: 600; cursor: pointer; border: none; font-family: inherit; transition: all .15s; text-decoration: none; }
    .dsh-tab.active   { background: #C58F59; color: #fff; }
    .dsh-tab.inactive { background: #F3EDE6; color: #6B513E; }
    .dsh-tab.inactive:hover { background: #E5D6C5; color: #582C0C; }

    /* ── Detail body ── */
    .dsh-detail-body { display: flex; }
    .dsh-filter-col { width: 180px; flex-shrink: 0; border-right: 1px solid #E5D6C5; padding: 16px 0; }
    .dsh-filter-item { padding: 10px 18px; font-size: 13px; color: #6B513E; cursor: pointer; border-bottom: 1px solid #F3EDE6; transition: background .15s; }
    .dsh-filter-item:last-child { border-bottom: none; }
    .dsh-filter-item:hover { background: rgba(197,143,89,.05); }
    .dsh-filter-item.active { background: #fdf8f4; color: #582C0C; font-weight: 600; border-left: 3px solid #C58F59; }
    .dsh-chart-area { flex: 1; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 40px 20px; min-height: 220px; }
    .dsh-empty-title { font-size: 13px; font-weight: 600; color: #6B513E; margin: 0 0 4px; }
    .dsh-empty-sub   { font-size: 13px; color: #b09a88; margin: 0; }

    /* ── Breakdown ── */
    .dsh-breakdown-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 14px; }
    .dsh-breakdown-card { background: #fff; border: 1px solid #E5D6C5; border-radius: 8px; padding: 18px 20px; box-shadow: 0 1px 3px rgba(88,44,12,.05); }
    .dsh-breakdown-heading { display: flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 700; color: #582C0C; margin: 0 0 14px; }
    .dsh-breakdown-row { display: flex; justify-content: space-between; align-items: center; padding: 9px 0; border-bottom: 1px solid #F3EDE6; font-size: 13px; }
    .dsh-breakdown-row:last-child { border-bottom: none; padding-bottom: 0; }
    .dsh-breakdown-row-label { display: flex; align-items: center; gap: 8px; color: #6B513E; }
    .dsh-breakdown-row-label svg { color: #C58F59; flex-shrink: 0; }
    .dsh-breakdown-row-amount { font-weight: 600; color: #582C0C; }

    /* ── Laba Rugi ── */
    .dsh-labarugi-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 14px; }
    .dsh-labarugi-card { border-radius: 8px; padding: 22px 20px; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; gap: 6px; }
    .dsh-labarugi-card.masuk  { background: #ECFDF5; border: 1px solid #A7F3D0; }
    .dsh-labarugi-card.keluar { background: #FEF2F2; border: 1px solid #FECACA; }
    .dsh-labarugi-card.saldo  { background: #EFF6FF; border: 1px solid #BFDBFE; }
    .dsh-labarugi-label  { font-size: 13px; color: #6B513E; margin: 0; }
    .dsh-labarugi-amount { font-size: 30px; font-weight: 700; margin: 0; }
    .dsh-labarugi-card.masuk  .dsh-labarugi-amount { color: #10B981; }
    .dsh-labarugi-card.keluar .dsh-labarugi-amount { color: #EF4444; }
    .dsh-labarugi-card.saldo  .dsh-labarugi-amount { color: #3B82F6; }
    .dsh-labarugi-sub { font-size: 13px; color: #9CA3AF; margin: 0; }

    /* ══════════════════════════════
       MOBILE ≤ 768px
    ══════════════════════════════ */
    @media (max-width: 768px) {

        /* Stat grid: 2 kolom */
        .dsh-stat-grid { grid-template-columns: repeat(2, 1fr); gap: 10px; }

        /* Font ikut rumus ÷ 1.6 */
        .dsh-section-title  { font-size: 13px; }  /* 18.75 ÷ 1.6 = 11.72 */
        .dsh-stat-label     { font-size: 11.72px; }   /* 13 ÷ 1.6 = 8.13 */
        .dsh-stat-number    { font-size: 18.75px; }  /* 30 ÷ 1.6 */
        .dsh-stat-change    { font-size: 11.27px; } /* 8.13 */
        .dsh-empty-title    { font-size: 11.27px; } /* 8.13 */
        .dsh-empty-sub      { font-size: 11.27px; } /* 8.13 */
        .dsh-breakdown-heading { font-size: 11.27px; } /* 8.13 */
        .dsh-breakdown-row  { font-size: 11.27px; } /* 8.13 */
        .dsh-labarugi-label { font-size: 11.27px; } /* 8.13 */
        .dsh-labarugi-amount { font-size: 18.75px; } /* 30 ÷ 1.6 */
        .dsh-labarugi-sub   { font-size: 11.27px; }/* 8.13 */
        .dsh-tab            { font-size: 11.72px; } /* 8.13 */
        .dsh-filter-item    { font-size: 10px; } /* 8.13 */

        /* Section header: inline, export tetap di kanan */
        .dsh-section-header { flex-direction: row; align-items: center; gap: 10px; flex-wrap: nowrap; }
        .dsh-btn-export { width: auto; padding: 7px 12px; font-size: 11.27px; }

        /* Tabs: scroll horizontal 1 baris */
        .dsh-tabs { flex-wrap: nowrap; overflow-x: auto; padding: 10px 12px; gap: 6px; }
        .dsh-tabs::-webkit-scrollbar { display: none; }
        .dsh-tab { padding: 6px 12px; white-space: nowrap; flex-shrink: 0; }

        /* Detail body: stack vertikal */
        .dsh-detail-body { flex-direction: column; }

        /* Filter: scroll horizontal 1 baris */
        .dsh-filter-col {
    width: 100%;
    border-right: none;
    border-bottom: 1px solid #E5D6C5;
    display: flex;
    flex-wrap: nowrap;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    gap: 6px;
    padding: 10px 12px;
}
.dsh-filter-col::-webkit-scrollbar { display: none; }
.dsh-filter-item {
    border-bottom: none;
    border: 1px solid #E5D6C5;
    border-radius: 20px;
    padding: 5px 10px;
    white-space: nowrap;
    flex-shrink: 0;
    display: inline-flex;
    align-items: center;
}
        .dsh-filter-item.active {
            border-color: #C58F59;
            border-left-width: 1px;
            background: #FDF8F4;
            color: #582C0C;
            font-weight: 600;
        }

        /* Breakdown: 1 kolom */
        .dsh-breakdown-grid { grid-template-columns: 1fr; gap: 10px; }

        /* Laba rugi: 1 kolom, horizontal */
        .dsh-labarugi-grid { grid-template-columns: 1fr; gap: 10px; }
        .dsh-labarugi-card { padding: 14px 16px; flex-direction: row; justify-content: space-between; text-align: left; gap: 8px; align-items: center; }
    }
</style>

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