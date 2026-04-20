@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/components/office/laporan.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/components/office/keuangan.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/components/office/pasien.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/components/office/akun.css') }}">
    <style>
        .pas-chart-full {
            background: #fff; border: 1px solid #E5D6C5; border-radius: 8px;
            padding: 20px; box-shadow: 0 1px 3px rgba(88,44,12,.05);
            margin-bottom: 20px;
        }
        .pas-chart-container { height: 250px; position: relative; }
        .pas-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px; }
        @media (max-width: 768px) { .pas-row { grid-template-columns: 1fr; } }
    </style>
@endpush

{{-- resources/views/admin/components/office/laporan.blade.php --}}
@php $tab = request('tab', 'keuangan'); @endphp

{{-- ═══ TAB BAR ═══ --}}
<div class="lap-tabs">
    @foreach ([
        'keuangan'    => 'Keuangan',
        'pasien'      => 'Pasien',
        'akun'        => 'Akun',
        'operasional' => 'Operasional',
        'bpjs'        => 'BPJS',
        'grafik'      => 'Grafik',
    ] as $key => $label)
        <a href="?menu=laporan&tab={{ $key }}" class="lap-tab {{ $tab === $key ? 'active' : 'inactive' }}">
            {{ $label }}
        </a>
    @endforeach
</div>


{{-- ══════════════════════════════════════════
     TAB: KEUANGAN (dari keuangan.blade.php)
═══════════════════════════════════════════ --}}
@if ($tab === 'keuangan')

    @include('admin.components.office.keuangan')



{{-- ══════════════════════════════════════════
    TAB: PASIEN (dari pasien.blade.php)
═══════════════════════════════════════════ --}}
@elseif ($tab === 'pasien')
    @include('admin.components.office.pasien')




{{-- ══════════════════════════════════════════
     TAB: AKUN (dari akun.blade.php)
═══════════════════════════════════════════ --}}
@elseif ($tab === 'akun')

    @include('admin.components.office.akun')


{{-- ══════════════════════════════════════════
     TAB: OPERASIONAL
═══════════════════════════════════════════ }}
@elseif ($tab === 'operasional')

    @php
        $laporanList = [
            ['Daftar Appointment Pasien',           'Data semua pasien rawat jalan di klinik ini.'],
            ['Daftar Pasien',                        'Data semua pasien rawat jalan di klinik ini.'],
            ['Laporan Diagnosa Pasien',              'Jumlah diagnosa dari semua pasien.'],
            ['Laporan Prosedur Pasien',              'Jumlah tindakan yang dilakukan pada tiap pasien.'],
            ['Laporan Peresepan Obat',               'Jumlah resep yang diberikan pada tiap pasien.'],
            ['Laporan Penjualan Obat',               'Penjualan obat langsung dari apotek'],
            ['Laporan Coret Tindakan',               'Laporan tindakan yang dicoret'],
            ['Laporan Morbid',                       'Laporan kasus baru dan kasus lama'],
            ['Laporan Kunjungan Pasien',             'Laporan Kunjungan Pasien Baru dan Lama Setiap Bulan'],
            ['Laporan Pasien Rujukan',               'Laporan pasien yang dirujukkan ke klinik lain'],
            ['Laporan Pasien Dirujuk',               'Laporan pasien yang dirujukkan ke klinik anda'],
            ['Laporan Kunjungan Sehat',              'Laporan kunjungan sehat pasien'],
            ['Laporan Promotif Preventif',           'Laporan promotif preventif pasien'],
            ['Laporan Kegiatan Kelompok',            'Laporan Kegiatan Kelompok'],
            ['Laporan Stock Adjustment',             'Laporan Stock Adjustment'],
            ['Laporan Hasil Survei',                 'Laporan Hasil Survei'],
            ['Laporan Rata-Rata Waktu Tunggu Apotek','Data laporan waktu tunggu apotek'],
            ['Laporan Rekap EMR',                    'Laporan Rekap EMR yang mencatat data rekam medis pasien per kunjungan'],
            ['Laporan Mutasi Obat',                  'Laporan Mutasi Obat'],
            ['Laporan Mutasi BHP',                   'Laporan Mutasi BHP'],
            ['Laporan Survei Kepuasan Masyarakat',   'Laporan Survei Kepuasan Masyarakat'],
            ['Laporan Waktu Pendaftaran',            'Laporan Waktu Pendaftaran'],
            ['Laporan Stock Opname Obat',            'Laporan Detail Stock Opname Obat'],
            ['Laporan OHI-S',                        'Laporan OHI-S'],
            ['Laporan Global Stock Obat',            'Laporan Global Stock Obat'],
            ['Laporan Stock Opname BHP',             'Laporan Detail Stock Opname BHP'],
            ['Laporan KB',                           'Laporan Pencatatan KB'],
            ['Laporan Ibu Hamil',                    'Laporan Ibu Hamil'],
            ['Laporan Survei AntriCepat',            'Laporan Survei AntriCepat'],
            ['Laporan Surat Menyurat',               'Data semua surat-surat dibuat di klinik ini'],
        ];
    @endphp

    <div style="background:#fff;border:1px solid #E5D6C5;border-radius:8px;overflow:hidden;box-shadow:0 1px 3px rgba(88,44,12,.05);">
        <div class="lap-grid">
            @foreach ($laporanList as $i => $item)
                <a href="#" class="lap-item" style="{{ ($i === count($laporanList) - 1 && count($laporanList) % 2 !== 0) ? 'border-bottom:none;' : '' }}">
                    <div class="lap-item-header">
                        <p class="lap-item-title">{{ $item[0] }}</p>
                        <svg class="lap-item-arrow" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 18l6-6-6-6"/></svg>
                    </div>
                    <p class="lap-item-desc">{{ $item[1] }}</p>
                </a>
            @endforeach
            @if (count($laporanList) % 2 !== 0)
                <div class="lap-item" style="background:transparent;border-bottom:none;pointer-events:none;"></div>
            @endif
        </div>
    </div>


{{-- ══════════════════════════════════════════
     TAB: BPJS
═══════════════════════════════════════════ --}}
@elseif ($tab === 'bpjs')

    @php
        $bpjsList = [
            ['Laporan Klaim BPJS',    'Data klaim yang diajukan ke BPJS'],
            ['Laporan SEP',           'Surat Eligibilitas Peserta'],
            ['Laporan Peserta BPJS',  'Data peserta BPJS yang berkunjung'],
            ['Laporan Obat BPJS',     'Penggunaan obat yang di-cover BPJS'],
            ['Laporan Kapitasi',      'Rekap dana kapitasi bulanan'],
            ['Laporan Rujukan BPJS',  'Data rujukan ke FKRTL'],
        ];
    @endphp

    <div style="background:#fff;border:1px solid #E5D6C5;border-radius:8px;overflow:hidden;box-shadow:0 1px 3px rgba(88,44,12,.05);">
        <div class="lap-grid">
            @foreach ($bpjsList as $i => $item)
                <a href="#" class="lap-item">
                    <div class="lap-item-header">
                        <p class="lap-item-title">{{ $item[0] }}</p>
                        <svg class="lap-item-arrow" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 18l6-6-6-6"/></svg>
                    </div>
                    <p class="lap-item-desc">{{ $item[1] }}</p>
                </a>
            @endforeach
            @if (count($bpjsList) % 2 !== 0)
                <div class="lap-item" style="background:transparent;border-bottom:none;pointer-events:none;"></div>
            @endif
        </div>
    </div>


{{-- ══════════════════════════════════════════
     TAB: GRAFIK
═══════════════════════════════════════════ --}}
@elseif ($tab === 'grafik')

    @php
        $grafikList = [
            ['Grafik Kunjungan Pasien', 'Tren kunjungan pasien per periode'],
            ['Grafik Pendapatan',       'Tren pendapatan per periode'],
            ['Grafik Diagnosa',         'Distribusi diagnosa terbanyak'],
            ['Grafik Prosedur',         'Prosedur terbanyak dilakukan'],
            ['Grafik Obat Terlaris',    'Top obat berdasarkan penjualan'],
        ];
    @endphp

    <div style="background:#fff;border:1px solid #E5D6C5;border-radius:8px;overflow:hidden;box-shadow:0 1px 3px rgba(88,44,12,.05);">
        <div class="lap-grid">
            @foreach ($grafikList as $i => $item)
                <a href="#" class="lap-item">
                    <div class="lap-item-header">
                        <p class="lap-item-title">{{ $item[0] }}</p>
                        <svg class="lap-item-arrow" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 18l6-6-6-6"/></svg>
                    </div>
                    <p class="lap-item-desc">{{ $item[1] }}</p>
                </a>
            @endforeach
            @if (count($grafikList) % 2 !== 0)
                <div class="lap-item" style="background:transparent;border-bottom:none;pointer-events:none;"></div>
            @endif
        </div>
    </div>

@endif


@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    @if ($tab === 'pasien' && request('sub', 'summary') === 'summary')
    const primaryColor   = '#C58F59';
    const secondaryColor = '#582C0C';
    const gridColor      = '#F3EDE6';

    const bloodCtx = document.getElementById('bloodTypeChart')?.getContext('2d');
    if (bloodCtx) {
        new Chart(bloodCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode(array_keys($bloodTypeStats ?? [])) !!},
                datasets: [{ data: {!! json_encode(array_values($bloodTypeStats ?? [])) !!}, backgroundColor: primaryColor, hoverBackgroundColor: primaryColor, borderRadius: 4 }]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { color: gridColor }, border: { display: true, color: primaryColor, width: 2 } },
                    x: { grid: { display: false }, border: { display: true, color: primaryColor, width: 2 } }
                }
            }
        });
    }

    const eduCtx = document.getElementById('educationChart')?.getContext('2d');
    if (eduCtx) {
        new Chart(eduCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode(array_keys($educationStats ?? [])) !!},
                datasets: [{ data: {!! json_encode(array_values($educationStats ?? [])) !!}, backgroundColor: secondaryColor, hoverBackgroundColor: secondaryColor, borderRadius: 4 }]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { color: gridColor }, border: { display: true, color: secondaryColor, width: 2 } },
                    x: { grid: { display: false }, border: { display: true, color: secondaryColor, width: 2 } }
                }
            }
        });
    }
    @endif
});
</script>
@endpush