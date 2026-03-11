{{-- resources/views/admin/settings/hak_akses.blade.php --}}

<style>
    .ha-header-row { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 6px; flex-wrap: wrap; gap: 12px; }
    .ha-title    { font-size: 18.75px; font-weight: 700; color: #582C0C; margin: 0; }
    .ha-subtitle { font-size: 13px; color: #6B513E; margin: 4px 0 20px; }

    .ha-btn-primary {
        background: #C58F59; color: #fff; border: none; padding: 9px 16px; border-radius: 6px;
        font-size: 13px; font-weight: 600; cursor: pointer;
        display: inline-flex; align-items: center; gap: 6px;
        font-family: inherit; white-space: nowrap; transition: background .2s;
    }
    .ha-btn-primary:hover { background: #b07d4a; }

    .ha-table-card { background: #fff; border: 1px solid #E5D6C5; border-radius: 8px; overflow: hidden; box-shadow: 0 1px 3px rgba(88,44,12,.05); }
    .ha-table { width: 100%; border-collapse: collapse; text-align: left; }
    .ha-table th {
        background: #fdf8f4; color: #582C0C; font-size: 13px; font-weight: 600;
        padding: 12px 20px; border-bottom: 2px solid #E5D6C5; white-space: nowrap;
    }
    .ha-table td { padding: 16px 20px; font-size: 13px; color: #374151; border-bottom: 1px solid #F3EDE6; vertical-align: top; }
    .ha-table tr:last-child td { border-bottom: none; }
    .ha-table tr:hover td { background: rgba(253,248,244,.7); }
    .ha-table .col-tipe { width: 140px; color: #582C0C; font-weight: 500; white-space: nowrap; }
    .ha-table .col-fitur { color: #6B513E; line-height: 1.8; }
    .ha-table .col-actions { width: 80px; white-space: nowrap; }

    .ha-view-more { color: #C58F59; font-weight: 600; font-size: 13px; cursor: pointer; text-decoration: none; display: inline-block; margin-top: 4px; }
    .ha-view-more:hover { text-decoration: underline; }

    .ha-action-row { display: flex; align-items: center; gap: 8px; }
    .ha-icon-btn {
        width: 30px; height: 30px; border-radius: 6px;
        border: 1.5px solid #E5D6C5; background: #fff;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer; color: #6B513E; transition: all .2s;
    }
    .ha-icon-btn:hover { border-color: #C58F59; color: #C58F59; }
    .ha-icon-btn.del { border-color: #FEE2E2; color: #FCA5A5; }
    .ha-icon-btn.del:hover { border-color: #EF4444; color: #EF4444; }

    .ha-pagination { display: flex; justify-content: flex-end; align-items: center; padding: 12px 20px; gap: 20px; border-top: 1px solid #E5D6C5; }
    .ha-page-size { display: flex; align-items: center; gap: 6px; color: #6B513E; }
    .ha-page-size select { border: none; outline: none; font-weight: 600; color: #582C0C; font-size: 13px; cursor: pointer; background: transparent; font-family: inherit; }
    .ha-page-info { color: #6B513E; }
    .ha-page-controls { display: flex; gap: 4px; }
    .ha-page-btn { background: none; border: none; color: #9CA3AF; cursor: pointer; padding: 4px 6px; border-radius: 4px; line-height: 0; }
    .ha-page-btn:not([disabled]):hover { color: #582C0C; background: #fdf8f4; }
    .ha-page-btn[disabled] { opacity: .4; cursor: default; pointer-events: none; }

    .ha-table-wrapper { width: 100%; overflow-x: auto; -webkit-overflow-scrolling: touch; }
    .ha-table-wrapper::-webkit-scrollbar { height: 6px; }
    .ha-table-wrapper::-webkit-scrollbar-thumb { background: #C58F59; border-radius: 3px; }

    @media (max-width: 768px) {
        .ha-header-row { flex-direction: column; align-items: stretch; gap: 8px; }
        .ha-btn-primary { justify-content: center; width: 100%; }
        .ha-title { font-size: 16px; }
        .ha-subtitle { margin-bottom: 12px; font-size: 12px; }
        .ha-pagination { flex-direction: column; align-items: flex-start; gap: 12px; }
        .ha-table td, .ha-table th { padding: 10px 14px; }
    }
</style>

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
