@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/components/settings/hak_akses.css') }}">
@endpush

{{-- resources/views/admin/settings/hak_akses.blade.php --}}
<div class="ha-header-row">
    <div>
        <h2 class="ha-title">Hak Akses</h2>
        <p class="ha-subtitle">Last Update: Data belum pernah di update</p>
    </div>
    <button class="ha-btn-primary">
        + Tambah Tipe Akses
    </button>
</div>

<div class="ha-table-card">
    <div class="ha-table-wrapper">
        <table class="ha-table">
            <thead>
            <tr>
                <th>Tipe Akses</th>
                <th>Fitur</th>
                <th class="col-actions" style="text-align:right;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ([
                ['Owner',       '1. Melihat list appointment semua dokter.',  '2. Menghandle online referral semua dokter.'],
                ['Admission',   '1. Melihat list appointment semua dokter.',  '2. Menghandle online referral semua dokter.'],
                ['Doctor',      '1. Melihat list appointment satu dokter.',   '2. Menghandle online referral satu dokter.'],
                ['Nurse',       '1. Melihat list appointment semua dokter.',  '2. Menghandle online referral semua dokter.'],
                ['Pharmacist',  '1. Melihat overview apotek.',                '2. Melihat login & Complete profile.'],
            ] as [$tipe, $f1, $f2])
                <tr>
                    <td class="col-tipe">{{ $tipe }}</td>
                    <td class="col-fitur">
                        {{ $f1 }}<br>
                        {{ $f2 }}<br>
                        <a href="#" class="ha-view-more">View More &gt;&gt;</a>
                    </td>
                    <td style="text-align:right;">
                        <div class="ha-action-row" style="justify-content:flex-end;">
                            <button class="ha-icon-btn" title="Edit">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            </button>
                            <button class="ha-icon-btn del" title="Hapus">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 6L6 18M6 6l12 12"/></svg>
                            </button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
        </table>
    </div>
    <div class="ha-pagination">
        <div class="ha-page-size">Jumlah baris per halaman: <select><option>5</option><option>10</option></select></div>
        <div class="ha-page-info">1–5 dari 7 data</div>
        <div class="ha-page-controls">
            <button class="ha-page-btn" disabled><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M11 17l-5-5 5-5M18 17l-5-5 5-5"/></svg></button>
            <button class="ha-page-btn" disabled><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M15 18l-6-6 6-6"/></svg></button>
            <button class="ha-page-btn"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 18l6-6-6-6"/></svg></button>
            <button class="ha-page-btn"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M13 17l5-5-5-5M6 17l5-5-5-5"/></svg></button>
        </div>
    </div>
</div>
