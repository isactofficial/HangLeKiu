@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/components/office/keuangan.css') }}">
@endpush

{{-- resources/views/admin/office/keuangan.blade.php --}}
@php $tab = request('tab', 'ikhtisar'); @endphp
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
