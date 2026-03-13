@push('styles')
    @vite('resources/css/pharmacy/antrian.css')
@endpush

<style>
    .apt-card {
        background: #fff;
        border-radius: 8px;
        border: 1px solid #E5D6C5;
        box-shadow: 0 1px 3px rgba(88, 44, 12, .06);
    }

    .apt-tabs {
        display: flex;
    }

    .apt-tab {
        padding: 10px 16px;
        font-size: 13px;
        font-weight: 600;
        color: #6B513E;
        cursor: pointer;
        border-bottom: 2px solid transparent;
        margin-bottom: -2px;
        transition: color .2s;
        text-decoration: none;
    }

    .apt-tab:hover {
        color: #582C0C;
    }

    .apt-tab.active {
        color: #f7f7f7;
        background-color: #582C0C;
        border-radius: 5px
    }

    .apt-card-actions {
        display: flex;
        gap: 10px;
        align-items: center;
        flex-wrap: wrap;
    }

    .apt-search-box {
        display: flex;
        align-items: center;
        border: 1px solid #E5D6C5;
        border-radius: 5px;
        padding: 7px 10px;
        gap: 7px;
        background: #fff;
    }

    .apt-search-box:focus-within {
        border-color: #C58F59;
    }

    .apt-search-box input {
        border: none;
        outline: none;
        font-size: 13px;
        color: #582C0C;
        background: transparent;
        width: 200px;
    }

    .apt-search-box input::placeholder {
        color: #b09a88;
    }

    .apt-btn-primary {
        background: #C58F59;
        color: #fff;
        border: none;
        padding: 8px 14px;
        border-radius: 5px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        white-space: nowrap;
    }

    .apt-btn-outline {
        background: #fff;
        color: #582C0C;
        border: 1px solid #E5D6C5;
        padding: 5px 12px;
        border-radius: 5px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        transition: all .2s;
    }

    .apt-btn-outline:hover {
        border-color: #C58F59;
        color: #C58F59;
    }

    .apt-table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    .apt-table-wrapper::-webkit-scrollbar {
        height: 6px;
    }

    .apt-table-wrapper::-webkit-scrollbar-thumb {
        background: #C58F59;
        border-radius: 3px;
    }

    .apt-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    .apt-table th {
        background: #fdf8f4;
        color: #582C0C;
        font-size: 13px;
        font-weight: 600;
        padding: 11px 16px;
        border-top: 2px solid #E5D6C5;
        border-bottom: 2px solid #E5D6C5;
        white-space: nowrap;
    }

    .apt-table td {
        padding: 11px 16px;
        font-size: 13px;
        color: #374151;
        border-bottom: 1px solid #F3EDE6;
        white-space: nowrap;
    }

    .apt-table tr:last-child td {
        border-bottom: none;
    }

    .apt-table tr:hover td {
        background: rgba(253, 248, 244, .7);
    }

    .apt-badge {
        display: inline-block;
        padding: 3px 9px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
    }

    .apt-badge-warning {
        background: #FEF3C7;
        color: #92400E;
    }

    .apt-badge-ok {
        background: #D1FAE5;
        color: #065F46;
    }

    .apt-pagination {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        padding: 12px 18px;
        gap: 20px;
        border-top: 1px solid #E5D6C5;
    }

    .apt-page-size {
        display: flex;
        align-items: center;
        gap: 6px;
        color: #6B513E;
    }

    .apt-page-size select {
        border: none;
        outline: none;
        font-weight: 600;
        color: #582C0C;
        font-size: 13px;
        cursor: pointer;
        background: transparent;
    }

    .apt-page-info {
        color: #6B513E;
    }

    .apt-page-controls {
        display: flex;
        gap: 8px;
        align-items: center;
    }

    .apt-page-btn {
        background: none;
        border: none;
        color: #9CA3AF;
        cursor: pointer;
        padding: 4px 6px;
        border-radius: 4px;
        line-height: 0;
    }

    .apt-page-btn:hover {
        color: #582C0C;
        background: #fdf8f4;
    }

    .apt-page-btn[disabled] {
        opacity: .4;
        cursor: default;
        pointer-events: none;
    }

</style>

<div class="apt-card">

    <div
        style="display:flex; justify-content:space-between; align-items:center; padding:12px 18px; flex-wrap:wrap; gap:10px;">
        <div class="apt-tabs">
            <a href="#" class="apt-tab active">Belum Selesai</a>
            <a href="#" class="apt-tab">Sudah Selesai</a>
        </div>
        <div class="apt-card-actions">
            <div class="apt-search-box">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <circle cx="11" cy="11" r="8" />
                    <path d="M21 21l-4.35-4.35" />
                </svg>
                <input type="text" placeholder="Cari nama pasien...">
            </div>
            <button class="apt-btn-primary">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2.5">
                    <path d="M12 5v14M5 12h14" />
                </svg>
                Tambah Resep
            </button>
        </div>
    </div>

    <div class="apt-table-wrapper">
        <table class="apt-table" style="min-width:700px;">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Pasien</th>
                    <th>Dokter</th>
                    <th>Waktu Masuk</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Rina Wulandari</td>
                    <td>drg. Anisa Putri</td>
                    <td>08:15</td>
                    <td><span class="apt-badge apt-badge-warning">Menunggu</span></td>
                    <td><button class="apt-btn-outline">Proses</button></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Budi Santoso</td>
                    <td>drg. Budi Raharjo</td>
                    <td>09:00</td>
                    <td><span class="apt-badge apt-badge-warning">Menunggu</span></td>
                    <td><button class="apt-btn-outline">Proses</button></td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Sari Melati</td>
                    <td>drg. Citra Dewi</td>
                    <td>09:30</td>
                    <td><span class="apt-badge apt-badge-ok">Selesai</span></td>
                    <td><button class="apt-btn-outline">Proses</button></td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Hendra Gunawan</td>
                    <td>drg. Anisa Putri</td>
                    <td>10:00</td>
                    <td><span class="apt-badge apt-badge-warning">Menunggu</span></td>
                    <td><button class="apt-btn-outline">Proses</button></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="apt-pagination">
        <div class="apt-page-size">Jumlah baris per halaman: <select>
                <option>10</option>
                <option>25</option>
                <option>50</option>
            </select></div>
        <div class="apt-page-controls">
            <button class="apt-page-btn" disabled><svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2.5">
                    <path d="M15 18l-6-6 6-6" />
                </svg></button>
            <div class="apt-page-info">1–4 dari 4 data</div>
            <button class="apt-page-btn" disabled><svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2.5">
                    <path d="M9 18l6-6-6-6" />
                </svg></button>
        </div>
    </div>

</div>
