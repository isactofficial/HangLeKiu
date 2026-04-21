@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/components/office/keuangan.css') }}">
@endpush

{{-- ── Ambil nilai dari controller (sudah di-pass via $payload) ── --}}
@php
    $subTab    = $subTab    ?? request('sub', 'ikhtisar');
    $startDate = $startDate ?? request('start_date', now()->startOfMonth()->toDateString());
    $endDate   = $endDate   ?? request('end_date',   now()->endOfMonth()->toDateString());
@endphp

{{-- ── Tab Bar + Filter Form ─────────────────────────────────── --}}
<div class="keu-topbar">

    {{-- Tab links — semua pakai menu=laporan&tab=keuangan --}}
    <div class="keu-tabs">
        @foreach(['ikhtisar' => 'Ikhtisar', 'pemasukan' => 'Pemasukan', 'pengeluaran' => 'Pengeluaran', 'klaim' => 'Klaim'] as $key => $label)
            <a href="?menu=laporan&tab=keuangan&sub={{ $key }}&start_date={{ $startDate }}&end_date={{ $endDate }}"
               class="keu-tab {{ $subTab === $key ? 'active' : 'inactive' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    {{-- Filter Form --}}
    <form id="keuFilterForm" action="{{ url()->current() }}" method="GET" class="keu-filter-row">
        <input type="hidden" name="menu" value="laporan">
        <input type="hidden" name="tab"  value="keuangan">
        <input type="hidden" name="sub"  value="{{ $subTab }}">

        <input type="date" id="keuStartDate" name="start_date" class="keu-date-input" value="{{ $startDate }}">
        <span class="keu-sep">-</span>
        <input type="date" id="keuEndDate"   name="end_date"   class="keu-date-input" value="{{ $endDate }}">

        <button type="button" id="keuFilterBtn" class="keu-btn-filter">FILTER</button>

        <button type="button" id="keuRefreshBtn" class="keu-btn-refresh" title="Reset ke bulan ini">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M23 4v6h-6M1 20v-6h6"/>
                <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"/>
            </svg>
        </button>
    </form>
</div>

{{-- ══════════════════════════════════════════════════
     TAB: IKHTISAR
══════════════════════════════════════════════════ --}}
@if ($subTab === 'ikhtisar')

    <p class="keu-section-label">Operasional</p>
    <div class="keu-grid-2">
        <div class="keu-stat">
            <p class="keu-stat-label">Pemasukan</p>
            <p class="keu-stat-amount plus">+ Rp{{ number_format($income ?? 0, 0, ',', '.') }}</p>
        </div>
        <div class="keu-stat">
            <p class="keu-stat-label">Pengeluaran Operasional</p>
            <p class="keu-stat-amount minus">- Rp{{ number_format($expenses ?? 0, 0, ',', '.') }}</p>
        </div>
    </div>

    <div class="keu-grid-2" style="margin-bottom:28px;">
        <div class="keu-stat">
            <p class="keu-stat-label">Margin</p>
            <p class="keu-stat-amount plus">+ Rp{{ number_format($margin ?? 0, 0, ',', '.') }}</p>
        </div>
        <div class="keu-stat">
            <p class="keu-stat-label">Margin Murni</p>
            <p class="keu-stat-amount plus">+ Rp{{ number_format(($income ?? 0) - ($expenses ?? 0), 0, ',', '.') }}</p>
        </div>
    </div>

    <p class="keu-section-label">Cover</p>
    <div class="keu-grid-1" style="margin-bottom:28px;">
        <div class="keu-stat">
            <p class="keu-stat-label">Langsung (Non-BPJS)</p>
            <p class="keu-stat-amount plus">+ Rp{{ number_format($directIncome ?? 0, 0, ',', '.') }}</p>
        </div>
    </div>

    <p class="keu-section-label">Total</p>
    <div style="border-top:1px solid #ECECEC; margin-bottom:12px;"></div>

    <div class="keu-grid-2" style="margin-bottom:12px;">
        <div class="keu-stat">
            <p class="keu-stat-label">Kas (Lifetime)</p>
            <p class="keu-stat-amount plus">+ Rp{{ number_format($kas ?? 0, 0, ',', '.') }}</p>
        </div>
        <div class="keu-stat">
            <p class="keu-stat-label">Cover BPJS (Lifetime)</p>
            <p class="keu-stat-amount plus">+ Rp{{ number_format($totalClaims ?? 0, 0, ',', '.') }}</p>
        </div>
    </div>
    <div class="keu-grid-2">
        <div class="keu-stat">
            <p class="keu-stat-label">Total Saldo</p>
            <p class="keu-stat-amount plus">+ Rp{{ number_format($kas ?? 0, 0, ',', '.') }}</p>
        </div>
        <div class="keu-stat">
            <p class="keu-stat-label">Total Balance</p>
            <p class="keu-stat-amount plus">+ Rp{{ number_format(($kas ?? 0) + ($totalClaims ?? 0), 0, ',', '.') }}</p>
            <p class="keu-stat-sub">Semua akun</p>
        </div>
    </div>

    {{-- Info periode aktif --}}
    <div style="margin-top:20px; padding:10px 14px; background:#fdf8f3; border:1px solid #e5d6c5; border-radius:8px; font-size:12px; color:#8B5E3C;">
        📅 Menampilkan data periode:
        <strong>{{ \Carbon\Carbon::parse($startDate)->format('d M Y') }}</strong>
        s/d
        <strong>{{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</strong>
    </div>

{{-- ══════════════════════════════════════════════════
     TAB: PEMASUKAN
══════════════════════════════════════════════════ --}}
@elseif ($subTab === 'pemasukan')

    <div class="keu-card">
        <div class="keu-card-header">
            <h2 class="keu-card-title">Pemasukan</h2>
            <div style="font-size:12px; color:#8B5E3C;">
                📅 {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} —
                   {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}
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
                    @forelse($tabData ?? [] as $inv)
                    <tr>
                        <td>{{ $inv->created_at->format('d/m/Y') }}</td>
                        <td style="color:#C58F59;font-weight:600;">{{ $inv->invoice_number }}</td>
                        <td>{{ $inv->registration->patient->full_name ?? ($inv->patient->full_name ?? '-') }}</td>
                        <td>{{ $inv->registration->doctor->full_name ?? '-' }}</td>
                        <td>{{ $inv->payment_type ?? 'Langsung' }}</td>
                        <td style="color:#10B981;font-weight:600;">+ Rp{{ number_format($inv->amount_paid, 0, ',', '.') }}</td>
                        <td>
                            @if($inv->status === 'paid')
                                <span class="keu-badge keu-badge-ok">Lunas</span>
                            @elseif($inv->status === 'partial')
                                <span class="keu-badge keu-badge-warning">Sebagian</span>
                            @elseif($inv->status === 'unpaid')
                                <span class="keu-badge keu-badge-danger">Belum Bayar</span>
                            @else
                                <span class="keu-badge keu-badge-warning">{{ $inv->status }}</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align:center; padding:40px; color:#9ca3af;">
                                Tidak ada data pemasukan untuk periode ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(isset($tabData) && method_exists($tabData, 'links'))
        <div class="keu-pagination">
            {{ $tabData->appends(request()->query())->links('pagination::simple-tailwind') }}
        </div>
        @endif
    </div>

{{-- ══════════════════════════════════════════════════
     TAB: PENGELUARAN
══════════════════════════════════════════════════ --}}
@elseif ($subTab === 'pengeluaran')

    <div class="keu-card">
        <div class="keu-card-header">
            <h2 class="keu-card-title">Pengeluaran</h2>
            <div style="font-size:12px; color:#8B5E3C;">
                📅 {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} —
                   {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}
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
                    @forelse($tabData ?? [] as $exp)
                    <tr>
                        <td>{{ $exp->created_at->format('d/m/Y') }}</td>
                        <td>{{ $exp->restock_type === 'restock' ? 'Restock BHP' : 'Return BHP' }}</td>
                        <td>{{ optional($exp->item)->item_name ?? optional($exp->item)->name ?? '-' }} ({{ $exp->quantity_added }} unit)</td>
                        <td>{{ $exp->notes ?? 'Admin' }}</td>
                        <td style="color:#EF4444;font-weight:600;">
                            - Rp{{ number_format($exp->purchase_price * $exp->quantity_added, 0, ',', '.') }}
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align:center; padding:40px; color:#9ca3af;">
                                Tidak ada data pengeluaran untuk periode ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(isset($tabData) && method_exists($tabData, 'links'))
        <div class="keu-pagination">
            {{ $tabData->appends(request()->query())->links('pagination::simple-tailwind') }}
        </div>
        @endif
    </div>

{{-- ══════════════════════════════════════════════════
     TAB: KLAIM
══════════════════════════════════════════════════ --}}
@elseif ($subTab === 'klaim')

    <div class="keu-card">
        <div class="keu-card-header">
            <h2 class="keu-card-title">Klaim BPJS</h2>
            <div style="font-size:12px; color:#8B5E3C;">
                📅 {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} —
                   {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}
            </div>
        </div>
        <div class="keu-table-wrapper">
            <table class="keu-table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>No Invoice</th>
                        <th>Pasien</th>
                        <th>Diagnosa</th>
                        <th>Nilai Klaim</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tabData ?? [] as $clm)
                    <tr>
                        <td>{{ $clm->created_at->format('d/m/Y') }}</td>
                        <td style="color:#C58F59;font-weight:600;">{{ $clm->invoice_number }}</td>
                        <td>{{ $clm->registration->patient->full_name ?? '-' }}</td>
                        <td>BPJS</td>
                        <td style="font-weight:600;">Rp{{ number_format($clm->amount_paid, 0, ',', '.') }}</td>
                        <td>
                            @if($clm->status === 'paid')
                                <span class="keu-badge keu-badge-ok">Disetujui</span>
                            @elseif($clm->status === 'partial')
                                <span class="keu-badge keu-badge-warning">Sebagian</span>
                            @else
                                <span class="keu-badge keu-badge-warning">Proses</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align:center; padding:40px; color:#9ca3af;">
                                Tidak ada data klaim untuk periode ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(isset($tabData) && method_exists($tabData, 'links'))
        <div class="keu-pagination">
            {{ $tabData->appends(request()->query())->links('pagination::simple-tailwind') }}
        </div>
        @endif
    </div>

@endif

{{-- ── Scripts: Filter & Refresh ──────────────────────────────── --}}
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form      = document.getElementById('keuFilterForm');
    const startInp  = document.getElementById('keuStartDate');
    const endInp    = document.getElementById('keuEndDate');
    const filterBtn = document.getElementById('keuFilterBtn');
    const refreshBtn= document.getElementById('keuRefreshBtn');

    if (!form) return;

    // ── FILTER ──────────────────────────────────────────────────
    filterBtn.addEventListener('click', function () {
        const start = startInp.value.trim();
        const end   = endInp.value.trim();

        if (!start && !end) {
            alert('Isi minimal salah satu tanggal untuk memfilter data.');
            startInp.focus();
            return;
        }
        if (start && end && start > end) {
            alert('Tanggal mulai tidak boleh lebih besar dari tanggal akhir.');
            startInp.focus();
            return;
        }

        form.submit();
    });

    // ── REFRESH / RESET ──────────────────────────────────────────
    refreshBtn.addEventListener('click', function () {
        // Reset ke awal dan akhir bulan ini
        const now   = new Date();
        const y     = now.getFullYear();
        const m     = String(now.getMonth() + 1).padStart(2, '0');
        const last  = new Date(y, now.getMonth() + 1, 0).getDate();

        startInp.value = `${y}-${m}-01`;
        endInp.value   = `${y}-${m}-${String(last).padStart(2, '0')}`;

        form.submit();
    });
});
</script>
@endpush