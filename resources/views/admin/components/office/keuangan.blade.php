{{-- resources/views/admin/office/keuangan.blade.php --}}
@php $tab = request('tab', 'ikhtisar'); @endphp

<style>
    /* ── shared ── */
    .keu-tabs { display: flex; gap: 4px; margin-bottom: 20px; flex-wrap: wrap; align-items: center; }
    .keu-tab {
        padding: 8px 20px; border-radius: 6px;
        font-size: 13px; font-weight: 600;
        border: none; cursor: pointer; font-family: inherit;
        text-decoration: none; display: inline-block;
        transition: all .15s;
    }
    .keu-tab.active   { background: #C58F59; color: #fff; }
    .keu-tab.inactive { background: #F3EDE6; color: #6B513E; }
    .keu-tab.inactive:hover { background: #E5D6C5; color: #582C0C; }

    /* date + filter row */
    .keu-filter-row { display: flex; align-items: center; gap: 10px; margin-left: auto; flex-wrap: wrap; }
    .keu-date-input {
        border: none; border-bottom: 1.5px solid #E5D6C5;
        padding: 4px 0; font-size: 13px; color: #582C0C; font-weight: 600;
        outline: none; background: transparent; width: 110px; font-family: inherit;
    }
    .keu-date-input:focus { border-color: #C58F59; }
    .keu-sep { color: #6B513E; }
    .keu-btn-filter {
        background: #E5D6C5; color: #582C0C;
        border: none; padding: 7px 18px; border-radius: 5px;
        font-size: 13px; font-weight: 700; cursor: pointer; font-family: inherit;
        transition: background .2s;
    }
    .keu-btn-filter:hover { background: #d4c3b0; }
    .keu-btn-refresh {
        width: 32px; height: 32px;
        border: 1.5px solid #E5D6C5; border-radius: 5px;
        background: #fff; color: #C58F59;
        display: inline-flex; align-items: center; justify-content: center;
        cursor: pointer; transition: all .2s;
    }
    .keu-btn-refresh:hover { border-color: #C58F59; }

    /* section label */
    .keu-section-label {
        font-size: 13px; font-weight: 700; color: #582C0C;
        padding-bottom: 8px; border-bottom: 1.5px solid #E5D6C5;
        margin: 0 0 14px;
    }

    /* stat grid */
    .keu-grid-4 { display: grid; grid-template-columns: repeat(4,1fr); gap: 12px; margin-bottom: 14px; }
    .keu-grid-3 { display: grid; grid-template-columns: repeat(3,1fr); gap: 12px; margin-bottom: 14px; }
    .keu-grid-2 { display: grid; grid-template-columns: repeat(2,1fr); gap: 12px; margin-bottom: 14px; }

    .keu-stat {
        background: #fff; border: 1px solid #E5D6C5; border-radius: 8px;
        padding: 18px 20px; box-shadow: 0 1px 3px rgba(88,44,12,.05);
        display: flex; flex-direction: column; gap: 6px;
    }
    .keu-stat-label { font-size: 13px; font-weight: 600; color: #582C0C; margin: 0; }
    .keu-stat-amount { font-size: 18.75px; font-weight: 700; margin: 0; }
    .keu-stat-amount.plus  { color: #10B981; }
    .keu-stat-amount.minus { color: #EF4444; }
    .keu-stat-sub { font-size: 13px; color: #6B513E; margin: 0; }

    .keu-stat-arrow {
        width: 32px; height: 32px; border-radius: 6px;
        display: flex; align-items: center; justify-content: center;
        align-self: flex-end;
    }
    .keu-stat-arrow.green  { background: #ECFDF5; color: #10B981; }
    .keu-stat-arrow.red    { background: #FEF2F2; color: #EF4444; }

    /* show more card */
    .keu-show-more {
        background: #fff; border: 1px solid #E5D6C5; border-radius: 8px;
        padding: 18px 20px; box-shadow: 0 1px 3px rgba(88,44,12,.05);
        display: flex; flex-direction: column; align-items: flex-start; justify-content: space-between;
        cursor: pointer; transition: border-color .2s;
    }
    .keu-show-more:hover { border-color: #C58F59; }
    .keu-show-more-label { font-size: 13px; font-weight: 600; color: #582C0C; }
    .keu-show-more-arrow { font-size: 22px; color: #6B513E; margin-top: 8px; }

    /* table */
    .keu-card { background:#fff; border:1px solid #E5D6C5; border-radius:8px; overflow:hidden; box-shadow:0 1px 3px rgba(88,44,12,.05); }
    .keu-card-header { padding:14px 18px; border-bottom:1px solid #E5D6C5; display:flex; justify-content:space-between; align-items:center; gap:12px; flex-wrap:wrap; }
    .keu-card-title { font-size:18.75px; font-weight:700; color:#C58F59; margin:0; }
    .keu-search-box { display:flex; align-items:center; border:1px solid #E5D6C5; border-radius:5px; padding:7px 10px; gap:7px; background:#fff; }
    .keu-search-box:focus-within { border-color:#C58F59; }
    .keu-search-box input { border:none; outline:none; font-size:13px; color:#582C0C; background:transparent; width:200px; font-family:inherit; }
    .keu-search-box input::placeholder { color:#b09a88; }
    .keu-btn-export { background:#582C0C; color:#fff; border:none; padding:8px 14px; border-radius:5px; font-size:13px; font-weight:600; cursor:pointer; font-family:inherit; white-space:nowrap; transition:background .2s; }
    .keu-btn-export:hover { background:#401f08; }
    .keu-table-wrapper { width:100%; overflow-x:auto; }
    .keu-table-wrapper::-webkit-scrollbar { height:6px; }
    .keu-table-wrapper::-webkit-scrollbar-thumb { background:#C58F59; border-radius:3px; }
    .keu-table { width:100%; border-collapse:collapse; text-align:left; }
    .keu-table th { background:#fdf8f4; color:#582C0C; font-size:13px; font-weight:600; padding:11px 16px; border-bottom:2px solid #E5D6C5; white-space:nowrap; }
    .keu-table td { padding:11px 16px; font-size:13px; color:#374151; border-bottom:1px solid #F3EDE6; white-space:nowrap; }
    .keu-table tr:last-child td { border-bottom:none; }
    .keu-table tr:hover td { background:rgba(253,248,244,.7); }
    .keu-badge { display:inline-block; padding:3px 9px; border-radius:20px; font-size:13px; font-weight:600; }
    .keu-badge-ok      { background:#D1FAE5; color:#065F46; }
    .keu-badge-warning { background:#FEF3C7; color:#92400E; }
    .keu-badge-danger  { background:#FEE2E2; color:#991B1B; }
    .keu-pagination { display:flex; justify-content:flex-end; align-items:center; padding:12px 18px; gap:20px; border-top:1px solid #E5D6C5; }
    .keu-page-size { display:flex; align-items:center; gap:6px; color:#6B513E; }
    .keu-page-size select { border:none; outline:none; font-weight:600; color:#582C0C; font-size:13px; cursor:pointer; background:transparent; font-family:inherit; }
    .keu-page-info { color:#6B513E; }
    .keu-page-controls { display:flex; gap:4px; }
    .keu-page-btn { background:none; border:none; color:#9CA3AF; cursor:pointer; padding:4px 6px; border-radius:4px; line-height:0; }
    .keu-page-btn:not([disabled]):hover { color:#582C0C; background:#fdf8f4; }
    .keu-page-btn[disabled] { opacity:.4; cursor:default; pointer-events:none; }
</style>

{{-- Tab Bar + Date Filter --}}
<div style="display:flex; align-items:center; gap:4px; margin-bottom:20px; flex-wrap:wrap;">
    @foreach (['ikhtisar'=>'Ikhtisar','pemasukan'=>'Pemasukan','pengeluaran'=>'Pengeluaran','klaim'=>'Klaim'] as $key=>$label)
        <a href="?menu=keuangan&tab={{ $key }}" class="keu-tab {{ $tab===$key ? 'active' : 'inactive' }}">{{ $label }}</a>
    @endforeach
    <div class="keu-filter-row">
        <input type="text" class="keu-date-input" value="01/03/2026">
        <span class="keu-sep">-</span>
        <input type="text" class="keu-date-input" value="06/03/2026">
        <button class="keu-btn-filter">FILTER</button>
        <button class="keu-btn-refresh">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M23 4v6h-6M1 20v-6h6"/><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"/></svg>
        </button>
    </div>
</div>

@if ($tab === 'ikhtisar')

    <p class="keu-section-label">Operasional</p>
    <div class="keu-grid-4">
        <div class="keu-stat">
            <p class="keu-stat-label">Pemasukan</p>
            <p class="keu-stat-amount plus">+ Rp3.600.000</p>
        </div>
        <div class="keu-stat">
            <p class="keu-stat-label">Pengeluaran</p>
            <p class="keu-stat-amount minus">- Rp0</p>
        </div>
        <div class="keu-stat">
            <p class="keu-stat-label">Piutang</p>
            <p class="keu-stat-amount plus">+ Rp2.500.000</p>
        </div>
        <div class="keu-stat">
            <p class="keu-stat-label">Hutang</p>
            <p class="keu-stat-amount minus">- Rp0</p>
        </div>
    </div>

    <div class="keu-grid-3" style="margin-bottom:28px;">
        <div class="keu-stat">
            <p class="keu-stat-label">Margin</p>
            <p class="keu-stat-amount plus">+ Rp3.600.000</p>
        </div>
        <div class="keu-stat">
            <p class="keu-stat-label">Margin Murni</p>
            <p class="keu-stat-amount plus">+ Rp6.100.000</p>
        </div>
        <div class="keu-show-more">
            <span class="keu-show-more-label">Show More</span>
            <span class="keu-show-more-arrow">→</span>
        </div>
    </div>

    <p class="keu-section-label">Cover</p>
    <div class="keu-grid-4" style="margin-bottom:28px;">
        <div class="keu-stat">
            <p class="keu-stat-label">Langsung</p>
            <p class="keu-stat-amount plus">+ Rp3.600.000</p>
        </div>
    </div>

    <p class="keu-section-label">Total</p>
    <div class="keu-grid-4">
        <div class="keu-stat">
            <p class="keu-stat-label">Kas</p>
            <p class="keu-stat-amount plus">+ Rp246.150.000</p>
        </div>
        <div class="keu-stat">
            <p class="keu-stat-label">Cover BPJS</p>
            <p class="keu-stat-amount plus">+ Rp0</p>
        </div>
        <div class="keu-stat">
            <p class="keu-stat-label">Hutang</p>
            <p class="keu-stat-amount minus">- Rp0</p>
        </div>
        <div class="keu-stat">
            <p class="keu-stat-label">Piutang</p>
            <p class="keu-stat-amount plus">+ Rp17.570.000</p>
        </div>
    </div>
    <div class="keu-grid-2">
        <div class="keu-stat">
            <p class="keu-stat-label">Total Saldo</p>
            <p class="keu-stat-amount plus">+ Rp246.150.000</p>
        </div>
        <div class="keu-stat">
            <p class="keu-stat-label">Total Balance</p>
            <p class="keu-stat-amount plus">+ Rp263.720.000</p>
            <p class="keu-stat-sub">Semua akun - hutang + piutang</p>
        </div>
    </div>

@elseif ($tab === 'pemasukan')

    <div class="keu-card">
        <div class="keu-card-header">
            <h2 class="keu-card-title">Pemasukan</h2>
            <div style="display:flex;gap:10px;align-items:center;">
                <div class="keu-search-box">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#6B513E" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                    <input type="text" placeholder="Cari transaksi...">
                </div>
                <button class="keu-btn-export">Export</button>
            </div>
        </div>
        <div class="keu-table-wrapper">
            <table class="keu-table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Invoice</th>
                        <th>Pasien</th>
                        <th>Dokter</th>
                        <th>Cover</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>05/03/2026</td>
                        <td style="color:#C58F59;font-weight:600;">INV-2026-0301</td>
                        <td>Rina Wulandari</td>
                        <td>drg. Anisa Putri</td>
                        <td>Langsung</td>
                        <td style="color:#10B981;font-weight:600;">+ Rp450.000</td>
                        <td><span class="keu-badge keu-badge-ok">Lunas</span></td>
                    </tr>
                    <tr>
                        <td>05/03/2026</td>
                        <td style="color:#C58F59;font-weight:600;">INV-2026-0302</td>
                        <td>Budi Santoso</td>
                        <td>drg. Budi Raharjo</td>
                        <td>Langsung</td>
                        <td style="color:#10B981;font-weight:600;">+ Rp1.200.000</td>
                        <td><span class="keu-badge keu-badge-ok">Lunas</span></td>
                    </tr>
                    <tr>
                        <td>06/03/2026</td>
                        <td style="color:#C58F59;font-weight:600;">INV-2026-0303</td>
                        <td>Sari Melati</td>
                        <td>drg. Citra Dewi</td>
                        <td>BPJS</td>
                        <td style="color:#92400E;font-weight:600;">+ Rp350.000</td>
                        <td><span class="keu-badge keu-badge-warning">Pending</span></td>
                    </tr>
                    <tr>
                        <td>06/03/2026</td>
                        <td style="color:#C58F59;font-weight:600;">INV-2026-0304</td>
                        <td>Hendra Gunawan</td>
                        <td>drg. Anisa Putri</td>
                        <td>Langsung</td>
                        <td style="color:#EF4444;font-weight:600;">+ Rp2.500.000</td>
                        <td><span class="keu-badge keu-badge-danger">Belum Bayar</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="keu-pagination">
            <div class="keu-page-size">Jumlah baris per halaman: <select><option>10</option><option>25</option></select></div>
            <div class="keu-page-info">1–4 dari 4 data</div>
            <div class="keu-page-controls">
                <button class="keu-page-btn" disabled><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M11 17l-5-5 5-5M18 17l-5-5 5-5"/></svg></button>
                <button class="keu-page-btn" disabled><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M15 18l-6-6 6-6"/></svg></button>
                <button class="keu-page-btn" disabled><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 18l6-6-6-6"/></svg></button>
                <button class="keu-page-btn" disabled><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M13 17l5-5-5-5M6 17l5-5-5-5"/></svg></button>
            </div>
        </div>
    </div>

@elseif ($tab === 'pengeluaran')

    <div class="keu-card">
        <div class="keu-card-header">
            <h2 class="keu-card-title">Pengeluaran</h2>
            <div style="display:flex;gap:10px;align-items:center;">
                <div class="keu-search-box">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#6B513E" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                    <input type="text" placeholder="Cari pengeluaran...">
                </div>
                <button class="keu-btn-export">Export</button>
            </div>
        </div>
        <div class="keu-table-wrapper">
            <table class="keu-table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Kategori</th>
                        <th>Keterangan</th>
                        <th>PIC</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>03/03/2026</td>
                        <td>Restock Obat</td>
                        <td>Amoxicillin 500mg × 200</td>
                        <td>apt. Sari</td>
                        <td style="color:#EF4444;font-weight:600;">- Rp640.000</td>
                    </tr>
                    <tr>
                        <td>04/03/2026</td>
                        <td>Gaji Staff</td>
                        <td>Gaji bulan Maret 2026</td>
                        <td>Admin</td>
                        <td style="color:#EF4444;font-weight:600;">- Rp8.500.000</td>
                    </tr>
                    <tr>
                        <td>05/03/2026</td>
                        <td>Operasional</td>
                        <td>Listrik & Air</td>
                        <td>Admin</td>
                        <td style="color:#EF4444;font-weight:600;">- Rp1.200.000</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="keu-pagination">
            <div class="keu-page-size">Jumlah baris per halaman: <select><option>10</option><option>25</option></select></div>
            <div class="keu-page-info">1–3 dari 3 data</div>
            <div class="keu-page-controls">
                <button class="keu-page-btn" disabled><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M11 17l-5-5 5-5M18 17l-5-5 5-5"/></svg></button>
                <button class="keu-page-btn" disabled><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M15 18l-6-6 6-6"/></svg></button>
                <button class="keu-page-btn" disabled><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 18l6-6-6-6"/></svg></button>
                <button class="keu-page-btn" disabled><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M13 17l5-5-5-5M6 17l5-5-5-5"/></svg></button>
            </div>
        </div>
    </div>

@elseif ($tab === 'klaim')

    <div class="keu-card">
        <div class="keu-card-header">
            <h2 class="keu-card-title">Klaim</h2>
            <div style="display:flex;gap:10px;align-items:center;">
                <div class="keu-search-box">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#6B513E" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                    <input type="text" placeholder="Cari klaim...">
                </div>
                <button class="keu-btn-export">Export</button>
            </div>
        </div>
        <div class="keu-table-wrapper">
            <table class="keu-table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>No SEP</th>
                        <th>Pasien</th>
                        <th>Diagnosa</th>
                        <th>Nilai Klaim</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>04/03/2026</td>
                        <td style="color:#C58F59;font-weight:600;">0301R0010226V000001</td>
                        <td>Sari Melati</td>
                        <td>K02.1 – Karies Email</td>
                        <td style="font-weight:600;">Rp180.000</td>
                        <td><span class="keu-badge keu-badge-warning">Proses</span></td>
                    </tr>
                    <tr>
                        <td>02/03/2026</td>
                        <td style="color:#C58F59;font-weight:600;">0301R0010226V000002</td>
                        <td>Dewi Kusuma</td>
                        <td>K05.1 – Periodontitis</td>
                        <td style="font-weight:600;">Rp220.000</td>
                        <td><span class="keu-badge keu-badge-ok">Disetujui</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="keu-pagination">
            <div class="keu-page-size">Jumlah baris per halaman: <select><option>10</option><option>25</option></select></div>
            <div class="keu-page-info">1–2 dari 2 data</div>
            <div class="keu-page-controls">
                <button class="keu-page-btn" disabled><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M11 17l-5-5 5-5M18 17l-5-5 5-5"/></svg></button>
                <button class="keu-page-btn" disabled><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M15 18l-6-6 6-6"/></svg></button>
                <button class="keu-page-btn" disabled><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 18l6-6-6-6"/></svg></button>
                <button class="keu-page-btn" disabled><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M13 17l5-5-5-5M6 17l5-5-5-5"/></svg></button>
            </div>
        </div>
    </div>

@endif
