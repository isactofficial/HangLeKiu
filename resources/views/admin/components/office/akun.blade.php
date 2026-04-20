@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/components/office/akun.css') }}">
@endpush

<form method="GET" action="{{ url()->current() }}" class="akun-toolbar">
    <input type="hidden" name="tab" value="akun">
    <button type="button" class="akun-btn-edit">KELOLA AKUN</button>
    <div class="akun-date-row">
        <input type="date" name="start_date" class="akun-date-input" value="{{ $startDate }}">
        <span class="akun-sep">-</span>
        <input type="date" name="end_date" class="akun-date-input" value="{{ $endDate }}">
        <button type="submit" class="akun-btn-refresh">
            <i class="fa fa-sync-alt"></i>
        </button>
    </div>
</form>

<div class="akun-cards-row" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 25px;">
    {{-- CARD 1: KAS TUNAI --}}
    <div class="akun-card" style="background: #fff; padding: 20px; border-radius: 12px; border: 1px solid #e5d6c5;">
        <p class="akun-card-name" style="color: #8B5E3C; font-weight: 700; font-size: 12px; text-transform: uppercase;">Kas Tunai (Laci)</p>
        <p class="akun-card-total" style="font-size: 20px; font-weight: 800; color: #582C0C; margin: 10px 0;">Rp {{ number_format($saldoKasTunai, 0, ',', '.') }}</p>
        <p class="akun-card-detail" style="font-size: 11px;">
            <span class="plus" style="color: #2ecc71;">+Rp {{ number_format($mutasiKas, 0, ',', '.') }}</span> (Periode ini)
        </p>
    </div>

    {{-- CARD 2: BANK & QRIS --}}
    <div class="akun-card" style="background: #fff; padding: 20px; border-radius: 12px; border: 1px solid #e5d6c5;">
        <p class="akun-card-name" style="color: #2980b9; font-weight: 700; font-size: 12px; text-transform: uppercase;">Rekening Bank / QRIS</p>
        <p class="akun-card-total" style="font-size: 20px; font-weight: 800; color: #582C0C; margin: 10px 0;">Rp {{ number_format($saldoBank, 0, ',', '.') }}</p>
        <p class="akun-card-detail" style="font-size: 11px;">
            <span class="plus" style="color: #2ecc71;">+Rp {{ number_format($mutasiBank, 0, ',', '.') }}</span> (Periode ini)
        </p>
    </div>

    {{-- CARD 3: BPJS (PIUTANG) --}}
    <div class="akun-card" style="background: #fff; padding: 20px; border-radius: 12px; border: 1px solid #e5d6c5;">
        <p class="akun-card-name" style="color: #27ae60; font-weight: 700; font-size: 12px; text-transform: uppercase;">Piutang BPJS / Asuransi</p>
        <p class="akun-card-total" style="font-size: 20px; font-weight: 800; color: #582C0C; margin: 10px 0;">Rp {{ number_format($totalPiutangBPJS, 0, ',', '.') }}</p>
        <p class="akun-card-detail" style="font-size: 11px;">
            <span class="plus" style="color: #2ecc71;">+Rp {{ number_format($mutasiBPJS, 0, ',', '.') }}</span> (Klaim Baru)
        </p>
    </div>
</div>

<div class="akun-chart-wrap" style="background: #fff; padding: 25px; border-radius: 12px; border: 1px solid #e5d6c5; height: 400px;">
    <canvas id="financeChart"></canvas>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const ctx = document.getElementById('financeChart').getContext('2d');
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($chartLabels),
            datasets: [
                {
                    label: 'Kas Tunai',
                    data: @json($chartDataKas),
                    borderColor: '#8B5E3C',
                    backgroundColor: 'rgba(139, 94, 60, 0.1)',
                    fill: true, tension: 0.4
                },
                {
                    label: 'Bank/QRIS',
                    data: @json($chartDataBank),
                    borderColor: '#2980b9',
                    backgroundColor: 'rgba(41, 128, 185, 0.1)',
                    fill: true, tension: 0.4
                },
                {
                    label: 'Piutang BPJS',
                    data: @json($chartDataBPJS),
                    borderColor: '#27ae60',
                    backgroundColor: 'rgba(39, 174, 96, 0.1)',
                    fill: true, tension: 0.4
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: { 
                    beginAtZero: true,
                    ticks: { callback: (v) => 'Rp ' + v.toLocaleString('id-ID') }
                }
            }
        }
    });
});
</script>
@endpush