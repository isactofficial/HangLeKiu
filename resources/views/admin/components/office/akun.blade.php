@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/components/office/akun.css') }}">
@endpush

{{-- ── Toolbar: Filter Tanggal ──────────────────────────────── --}}
<form id="akunFilterForm" method="GET" action="{{ url()->current() }}" class="akun-toolbar">
    {{-- Pertahankan semua parameter URL yang aktif --}}
    <input type="hidden" name="menu" value="laporan">
    <input type="hidden" name="tab"  value="akun">

    <div class="akun-date-row" 
     style="display: flex; justify-content: flex-end; align-items: center; gap: 8px; width: 100%; margin-left: auto;">
        <input
            type="date"
            id="akunStartDate"
            name="start_date"
            class="akun-date-input"
            value="{{ $startDate ?? '' }}"
        >
        <span class="akun-sep">-</span>
        <input
            type="date"
            id="akunEndDate"
            name="end_date"
            class="akun-date-input"
            value="{{ $endDate ?? '' }}"
        >

        {{-- Tombol FILTER --}}
        <button
            type="button"
            id="akunFilterBtn"
            class="keu-btn-filter"
        >FILTER</button>

        {{-- Tombol REFRESH / RESET --}}
        <button
            type="button"
            id="akunRefreshBtn"
            class="keu-btn-refresh"
            title="Reset filter"
        >
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M23 4v6h-6M1 20v-6h6"/>
                <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"/>
            </svg>
        </button>
    </div>
</form>

{{-- ── Kartu Saldo ───────────────────────────────────────────── --}}
<div class="akun-cards-row" style="display:grid; grid-template-columns:repeat(3,1fr); gap:20px; margin-bottom:25px;">

    {{-- CARD 1: KAS TUNAI --}}
    <div class="akun-card" style="background:#fff; padding:20px; border-radius:12px; border:1px solid #e5d6c5;">
        <p class="akun-card-name" style="color:#8B5E3C; font-weight:700; font-size:12px; text-transform:uppercase;">Kas Tunai (Laci)</p>
        <p class="akun-card-total" style="font-size:20px; font-weight:800; color:#582C0C; margin:10px 0;">
            Rp {{ number_format($saldoKasTunai ?? 0, 0, ',', '.') }}
        </p>
        <p class="akun-card-detail" style="font-size:11px;">
            <span class="plus" style="color:#2ecc71;">+Rp {{ number_format($mutasiKas ?? 0, 0, ',', '.') }}</span>
            (Periode ini)
        </p>
    </div>

    {{-- CARD 2: BANK & QRIS --}}
    <div class="akun-card" style="background:#fff; padding:20px; border-radius:12px; border:1px solid #e5d6c5;">
        <p class="akun-card-name" style="color:#2980b9; font-weight:700; font-size:12px; text-transform:uppercase;">Rekening Bank / QRIS</p>
        <p class="akun-card-total" style="font-size:20px; font-weight:800; color:#582C0C; margin:10px 0;">
            Rp {{ number_format($saldoBank ?? 0, 0, ',', '.') }}
        </p>
        <p class="akun-card-detail" style="font-size:11px;">
            <span class="plus" style="color:#2ecc71;">+Rp {{ number_format($mutasiBank ?? 0, 0, ',', '.') }}</span>
            (Periode ini)
        </p>
    </div>

    {{-- CARD 3: BPJS (PIUTANG) --}}
    <div class="akun-card" style="background:#fff; padding:20px; border-radius:12px; border:1px solid #e5d6c5;">
        <p class="akun-card-name" style="color:#27ae60; font-weight:700; font-size:12px; text-transform:uppercase;">Piutang BPJS / Asuransi</p>
        <p class="akun-card-total" style="font-size:20px; font-weight:800; color:#582C0C; margin:10px 0;">
            Rp {{ number_format($totalPiutangBPJS ?? 0, 0, ',', '.') }}
        </p>
        <p class="akun-card-detail" style="font-size:11px;">
            <span class="plus" style="color:#2ecc71;">+Rp {{ number_format($mutasiBPJS ?? 0, 0, ',', '.') }}</span>
            (Klaim Baru)
        </p>
    </div>
</div>

{{-- ── Chart ─────────────────────────────────────────────────── --}}
<div class="akun-chart-wrap" style="background:#fff; padding:25px; border-radius:12px; border:1px solid #e5d6c5; height:400px;">
    <canvas id="financeChart"></canvas>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const form       = document.getElementById('akunFilterForm');
    const startInput = document.getElementById('akunStartDate');
    const endInput   = document.getElementById('akunEndDate');
    const filterBtn  = document.getElementById('akunFilterBtn');
    const refreshBtn = document.getElementById('akunRefreshBtn');

    // ── Tombol FILTER ────────────────────────────────────────────
    filterBtn.addEventListener('click', function () {
        const start = startInput.value.trim();
        const end   = endInput.value.trim();

        if (!start && !end) {
            alert('Isi minimal salah satu tanggal untuk memfilter data.');
            startInput.focus();
            return;
        }

        // Validasi: start tidak boleh lebih besar dari end
        if (start && end && start > end) {
            alert('Tanggal mulai tidak boleh lebih besar dari tanggal akhir.');
            startInput.focus();
            return;
        }

        form.submit();
    });

    // ── Tombol REFRESH / RESET ────────────────────────────────────
    refreshBtn.addEventListener('click', function () {
        startInput.value = '';
        endInput.value   = '';
        form.submit();
    });

    // ── Chart ─────────────────────────────────────────────────────
    const ctx = document.getElementById('financeChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($chartLabels ?? []),
            datasets: [
                {
                    label: 'Kas Tunai',
                    data: @json($chartDataKas ?? []),
                    borderColor: '#8B5E3C',
                    backgroundColor: 'rgba(139,94,60,0.1)',
                    fill: true,
                    tension: 0.4,
                    pointRadius: 4,
                    pointBackgroundColor: '#8B5E3C',
                },
                {
                    label: 'Bank / QRIS',
                    data: @json($chartDataBank ?? []),
                    borderColor: '#2980b9',
                    backgroundColor: 'rgba(41,128,185,0.1)',
                    fill: true,
                    tension: 0.4,
                    pointRadius: 4,
                    pointBackgroundColor: '#2980b9',
                },
                {
                    label: 'Piutang BPJS',
                    data: @json($chartDataBPJS ?? []),
                    borderColor: '#27ae60',
                    backgroundColor: 'rgba(39,174,96,0.1)',
                    fill: true,
                    tension: 0.4,
                    pointRadius: 4,
                    pointBackgroundColor: '#27ae60',
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { mode: 'index', intersect: false },
            plugins: {
                legend: { position: 'top' },
                tooltip: {
                    callbacks: {
                        label: ctx => ' ' + ctx.dataset.label + ': Rp ' + Number(ctx.raw).toLocaleString('id-ID')
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: v => 'Rp ' + Number(v).toLocaleString('id-ID')
                    },
                    grid: { color: '#f5ede3' }
                },
                x: { grid: { display: false } }
            }
        }
    });
});
</script>
@endpush