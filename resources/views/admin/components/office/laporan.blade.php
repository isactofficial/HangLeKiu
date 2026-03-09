{{-- resources/views/admin/office/laporan.blade.php --}}
@php $tab = request('tab', 'operasional'); @endphp

<style>
    .lap-tabs { display: flex; gap: 4px; margin-bottom: 24px; flex-wrap: wrap; }
    .lap-tab {
        padding: 8px 22px; border-radius: 6px;
        font-size: 13px; font-weight: 600;
        border: none; cursor: pointer; font-family: inherit;
        text-decoration: none; display: inline-block; transition: all .15s;
    }
    .lap-tab.active   { background: #C58F59; color: #fff; }
    .lap-tab.inactive { background: #F3EDE6; color: #6B513E; }
    .lap-tab.inactive:hover { background: #E5D6C5; color: #582C0C; }

    .lap-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 0; }

    .lap-item {
        display: flex; flex-direction: column; gap: 5px;
        padding: 16px 20px; border-bottom: 1px solid #E5D6C5;
        text-decoration: none; cursor: pointer;
        transition: background .15s;
        position: relative;
    }
    .lap-item:nth-child(odd)  { border-right: 1px solid #E5D6C5; }
    .lap-item:hover { background: rgba(197,143,89,.04); }
    .lap-item:hover .lap-item-title { color: #582C0C; }

    .lap-item-header { display: flex; justify-content: space-between; align-items: flex-start; }
    .lap-item-title {
        font-size: 13px; font-weight: 700; color: #C58F59;
        transition: color .15s; margin: 0; flex: 1; padding-right: 8px;
    }
    .lap-item-arrow { color: #C58F59; flex-shrink: 0; margin-top: 1px; }
    .lap-item-desc  { font-size: 13px; color: #6B513E; margin: 0; }
</style>

<div class="lap-tabs">
    @foreach (['operasional'=>'Operasional','keuangan'=>'Keuangan','bpjs'=>'BPJS','grafik'=>'Grafik'] as $key=>$label)
        <a href="?menu=laporan&tab={{ $key }}" class="lap-tab {{ $tab===$key ? 'active' : 'inactive' }}">{{ $label }}</a>
    @endforeach
</div>

@php
$laporanList = [
    'operasional' => [
        ['Daftar Appointment Pasien',      'Data semua pasien rawat jalan di klinik ini.'],
        ['Daftar Pasien',                  'Data semua pasien rawat jalan di klinik ini.'],
        ['Laporan Diagnosa Pasien',        'Jumlah diagnosa dari semua pasien.'],
        ['Laporan Prosedur Pasien',        'Jumlah tindakan yang dilakukan pada tiap pasien.'],
        ['Laporan Peresepan Obat',         'Jumlah resep yang diberikan pada tiap pasien.'],
        ['Laporan Penjualan Obat',         'Penjualan obat langsung dari apotek'],
        ['Laporan Coret Tindakan',         'Laporan tindakan yang dicoret'],
        ['Laporan Morbid',                 'Laporan kasus baru dan kasus lama'],
        ['Laporan Kunjungan Pasien',       'Laporan Kunjungan Pasien Baru dan Lama Setiap Bulan'],
        ['Laporan Pasien Rujukan',         'Laporan pasien yang dirujukkan ke klinik lain'],
        ['Laporan Pasien Dirujuk',         'Laporan pasien yang dirujukkan ke klinik anda'],
        ['Laporan Kunjungan Sehat',        'Laporan kunjungan sehat pasien'],
        ['Laporan Promotif Preventif',     'Laporan promotif preventif pasien'],
        ['Laporan Kegiatan Kelompok',      'Laporan Kegiatan Kelompok'],
        ['Laporan Stock Adjustment',       'Laporan Stock Adjustment'],
        ['Laporan Hasil Survei',           'Laporan Hasil Survei'],
        ['Laporan Rata-Rata Waktu Tunggu Apotek', 'Data laporan waktu tunggu apotek'],
        ['Laporan Rekap EMR',              'Laporan Rekap EMR yang mencatat data rekam medis pasien per kunjungan'],
        ['Laporan Mutasi Obat',            'Laporan Mutasi Obat'],
        ['Laporan Mutasi BHP',             'Laporan Mutasi BHP'],
        ['Laporan Survei Kepuasan Masyarakat', 'Laporan Survei Kepuasan Masyarakat'],
        ['Laporan Waktu Pendaftaran',      'Laporan Waktu Pendaftaran'],
        ['Laporan Stock Opname Obat',      'Laporan Detail Stock Opname Obat'],
        ['Laporan OHI-S',                  'Laporan OHI-S'],
        ['Laporan Global Stock Obat',      'Laporan Global Stock Obat'],
        ['Laporan Stock Opname BHP',       'Laporan Detail Stock Opname BHP'],
        ['Laporan KB',                     'Laporan Pencatatan KB'],
        ['Laporan Ibu Hamil',              'Laporan Ibu Hamil'],
        ['Laporan Survei AntriCepat',      'Laporan Survei AntriCepat'],
        ['Laporan Surat Menyurat',         'Data semua surat-surat dibuat di klinik ini'],
    ],
    'keuangan' => [
        ['Laporan Pendapatan Harian',      'Rekap pendapatan per hari'],
        ['Laporan Pendapatan Bulanan',     'Rekap pendapatan per bulan'],
        ['Laporan Piutang',                'Daftar piutang pasien yang belum dibayar'],
        ['Laporan Hutang',                 'Daftar hutang klinik ke supplier'],
        ['Laporan Kasir',                  'Rekap transaksi per kasir'],
        ['Laporan Diskon',                 'Laporan penggunaan diskon'],
        ['Laporan Komisi Dokter',          'Rekap komisi per dokter'],
        ['Laporan HPP',                    'Harga Pokok Penjualan obat dan BHP'],
        ['Laporan Laba Rugi',              'Ringkasan laba rugi periode tertentu'],
        ['Laporan Neraca',                 'Laporan posisi keuangan klinik'],
    ],
    'bpjs' => [
        ['Laporan Klaim BPJS',             'Data klaim yang diajukan ke BPJS'],
        ['Laporan SEP',                    'Surat Eligibilitas Peserta'],
        ['Laporan Peserta BPJS',           'Data peserta BPJS yang berkunjung'],
        ['Laporan Obat BPJS',              'Penggunaan obat yang di-cover BPJS'],
        ['Laporan Kapitasi',               'Rekap dana kapitasi bulanan'],
        ['Laporan Rujukan BPJS',           'Data rujukan ke FKRTL'],
    ],
    'grafik' => [
        ['Grafik Kunjungan Pasien',        'Tren kunjungan pasien per periode'],
        ['Grafik Pendapatan',              'Tren pendapatan per periode'],
        ['Grafik Diagnosa',                'Distribusi diagnosa terbanyak'],
        ['Grafik Prosedur',                'Prosedur terbanyak dilakukan'],
        ['Grafik Obat Terlaris',           'Top obat berdasarkan penjualan'],
    ],
];
$items = $laporanList[$tab] ?? [];
@endphp

<div style="background:#fff; border:1px solid #E5D6C5; border-radius:8px; overflow:hidden; box-shadow:0 1px 3px rgba(88,44,12,.05);">
    <div class="lap-grid">
        @foreach ($items as $i => $item)
            <a href="#" class="lap-item" style="{{ ($i >= count($items)-2 && count($items)%2 === 0) || ($i === count($items)-1) ? 'border-bottom:none;' : '' }}">
                <div class="lap-item-header">
                    <p class="lap-item-title">{{ $item[0] }}</p>
                    <svg class="lap-item-arrow" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <path d="M9 18l6-6-6-6"/>
                    </svg>
                </div>
                <p class="lap-item-desc">{{ $item[1] }}</p>
            </a>
        @endforeach
        {{-- pad odd count --}}
        @if (count($items) % 2 !== 0)
            <div class="lap-item" style="background:transparent; border-bottom:none; pointer-events:none;"></div>
        @endif
    </div>
</div>
