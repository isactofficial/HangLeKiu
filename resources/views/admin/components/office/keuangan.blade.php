@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/components/office/keuangan.css') }}">
@endpush

{{-- resources/views/admin/office/keuangan.blade.php --}}
@php $tab = request('tab', 'ikhtisar'); @endphp
{{-- Tab Bar + Date Filter --}}
<div class="keu-topbar">
    <div class="keu-tabs">
        @foreach (['ikhtisar'=>'Ikhtisar','pemasukan'=>'Pemasukan','pengeluaran'=>'Pengeluaran','klaim'=>'Klaim'] as $key=>$label)
            <a href="?menu=keuangan&tab={{ $key }}&start_date={{ $startDate }}&end_date={{ $endDate }}" class="keu-tab {{ $tab===$key ? 'active' : 'inactive' }}">{{ $label }}</a>
        @endforeach
    </div>
    <form action="" method="GET" class="keu-filter-row">
        <input type="hidden" name="menu" value="keuangan">
        <input type="hidden" name="tab" value="{{ $tab }}">
        <input type="date" name="start_date" class="keu-date-input" value="{{ $startDate }}">
        <span class="keu-sep">-</span>
        <input type="date" name="end_date" class="keu-date-input" value="{{ $endDate }}">
        <button type="submit" class="keu-btn-filter">FILTER</button>
        <a href="?menu=keuangan&tab={{ $tab }}" class="keu-btn-refresh">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M23 4v6h-6M1 20v-6h6"/><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"/></svg>
        </a>
    </form>
</div>

@if ($tab === 'ikhtisar')

    <p class="keu-section-label">Operasional</p>
    <div class="keu-grid-2">
        <div class="keu-stat">
            <p class="keu-stat-label">Pemasukan</p>
            <p class="keu-stat-amount plus">+ Rp{{ number_format($income, 0, ',', '.') }}</p>
        </div>
        <div class="keu-stat">
            <p class="keu-stat-label">Pengeluaran Operasional</p>
            <p class="keu-stat-amount minus">- Rp{{ number_format($expenses, 0, ',', '.') }}</p>
        </div>
    </div>

    <div class="keu-grid-2" style="margin-bottom:28px;">
        <div class="keu-stat">
            <p class="keu-stat-label">Margin</p>
            <p class="keu-stat-amount plus">+ Rp{{ number_format($margin, 0, ',', '.') }}</p>
        </div>
        <div class="keu-stat">
            <p class="keu-stat-label">Margin Murni</p>
            <p class="keu-stat-amount plus">+ Rp{{ number_format($income, 0, ',', '.') }}</p>
        </div>
    </div>

    <p class="keu-section-label">Cover</p>
    <div class="keu-grid-1" style="margin-bottom:28px;">
        <div class="keu-stat">
            <p class="keu-stat-label">Langsung</p>
            <p class="keu-stat-amount plus">+ Rp{{ number_format($directIncome, 0, ',', '.') }}</p>
        </div>
    </div>

    <p class="keu-section-label">Total</p>
    <div style="border-top:1px solid #ECECEC; margin-bottom:12px;"></div>

    <div class="keu-grid-2" style="margin-bottom:12px;">
        <div class="keu-stat">
            <p class="keu-stat-label">Kas</p>
            <p class="keu-stat-amount plus">+ Rp{{ number_format($kas, 0, ',', '.') }}</p>
        </div>
        <div class="keu-stat">
            <p class="keu-stat-label">Cover BPJS</p>
            <p class="keu-stat-amount plus">+ Rp{{ number_format($totalClaims, 0, ',', '.') }}</p>
        </div>
    </div>
    <div class="keu-grid-2">
        <div class="keu-stat">
            <p class="keu-stat-label">Total Saldo</p>
            <p class="keu-stat-amount plus">+ Rp{{ number_format($kas, 0, ',', '.') }}</p>
        </div>
        <div class="keu-stat">
            <p class="keu-stat-label">Total Balance</p>
            <p class="keu-stat-amount plus">+ Rp{{ number_format($kas, 0, ',', '.') }}</p>
            <p class="keu-stat-sub">Semua akun</p>
        </div>
    </div>

@elseif ($tab === 'pemasukan')

    <div class="keu-card">
        <div class="keu-card-header">
            <h2 class="keu-card-title">Pemasukan</h2>
            <div style="display:flex;gap:10px;align-items:center;flex-wrap:wrap;">
                <div class="keu-search-box">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#6B513E" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                    <input type="text" placeholder="Cari transaksi...">
                </div>
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
                    @foreach($tabData as $inv)
                    <tr>
                        <td>{{ $inv->created_at->format('d/m/Y') }}</td>
                        <td style="color:#C58F59;font-weight:600;">{{ $inv->invoice_number }}</td>
                        <td>{{ $inv->registration->patient->full_name ?? '-' }}</td>
                        <td>{{ $inv->registration->doctor->full_name ?? '-' }}</td>
                        <td>{{ $inv->payment_type ?? 'Langsung' }}</td>
                        <td style="color:#10B981;font-weight:600;">+ Rp{{ number_format($inv->amount_paid, 0, ',', '.') }}</td>
                        <td>
                            @if($inv->status === 'paid')
                                <span class="keu-badge keu-badge-ok">Lunas</span>
                            @elseif($inv->status === 'unpaid')
                                <span class="keu-badge keu-badge-danger">Belum Bayar</span>
                            @else
                                <span class="keu-badge keu-badge-warning">{{ $inv->status }}</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    @if($tabData->isEmpty())
                        <tr><td colspan="7" style="text-align:center;">Tidak ada data pemasukan.</td></tr>
                    @endif
                </tbody>
            </table>
        </div>
        <div class="keu-pagination">
            {{ $tabData->links('pagination::simple-tailwind') }}
        </div>
    </div>

@elseif ($tab === 'pengeluaran')

    <div class="keu-card">
        <div class="keu-card-header">
            <h2 class="keu-card-title">Pengeluaran</h2>
            <div style="display:flex;gap:10px;align-items:center;flex-wrap:wrap;">
                <div class="keu-search-box">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#6B513E" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                    <input type="text" placeholder="Cari pengeluaran...">
                </div>
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
                    @foreach($tabData as $exp)
                    <tr>
                        <td>{{ $exp->created_at->format('d/m/Y') }}</td>
                        <td>{{ $exp->restock_type === 'restock' ? 'Restock BHP' : 'Return BHP' }}</td>
                        <td>{{ $exp->item->name ?? '-' }} ({{ $exp->quantity_added }} unit)</td>
                        <td>{{ $exp->notes ?? 'Admin' }}</td>
                        <td style="color:#EF4444;font-weight:600;">- Rp{{ number_format($exp->purchase_price * $exp->quantity_added, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                    @if($tabData->isEmpty())
                        <tr><td colspan="5" style="text-align:center;">Tidak ada data pengeluaran.</td></tr>
                    @endif
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
            <div style="display:flex;gap:10px;align-items:center;flex-wrap:wrap;">
                <div class="keu-search-box">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#6B513E" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                    <input type="text" placeholder="Cari klaim...">
                </div>
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
                    @foreach($tabData as $clm)
                    <tr>
                        <td>{{ $clm->created_at->format('d/m/Y') }}</td>
                        <td style="color:#C58F59;font-weight:600;">{{ $clm->invoice_number }}</td>
                        <td>{{ $clm->registration->patient->full_name ?? '-' }}</td>
                        <td>BPJS</td>
                        <td style="font-weight:600;">Rp{{ number_format($clm->amount_paid, 0, ',', '.') }}</td>
                        <td>
                            @if($clm->status === 'paid')
                                <span class="keu-badge keu-badge-ok">Disetujui</span>
                            @else
                                <span class="keu-badge keu-badge-warning">Proses</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    @if($tabData->isEmpty())
                        <tr><td colspan="6" style="text-align:center;">Tidak ada data klaim.</td></tr>
                    @endif
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