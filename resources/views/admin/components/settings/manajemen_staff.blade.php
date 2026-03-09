{{-- resources/views/admin/settings/manajemen_staff.blade.php --}}

<style>
    .ms-header-row { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 6px; flex-wrap: wrap; gap: 12px; }
    .ms-title    { font-size: 18.75px; font-weight: 700; color: #582C0C; margin: 0; }
    .ms-subtitle { font-size: 13px; color: #6B513E; margin: 4px 0 18px; }
    .ms-actions-row { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }

    .ms-btn-group { display: flex; border: 1.5px solid #E5D6C5; border-radius: 6px; overflow: hidden; }
    .ms-btn-group-item {
        padding: 8px 14px; font-size: 13px; font-weight: 600;
        color: #582C0C; background: #fff; border: none;
        cursor: pointer; font-family: inherit; white-space: nowrap;
        transition: background .15s;
    }
    .ms-btn-group-item:not(:last-child) { border-right: 1.5px solid #E5D6C5; }
    .ms-btn-group-item:hover  { background: #fdf8f4; }
    .ms-btn-group-item.active { background: #E5D6C5; color: #582C0C; font-weight: 700; }

    .ms-btn-primary {
        background: #C58F59; color: #fff;
        border: none; padding: 8px 16px; border-radius: 6px;
        font-size: 13px; font-weight: 600; cursor: pointer;
        display: inline-flex; align-items: center; gap: 6px;
        font-family: inherit; white-space: nowrap; transition: background .2s;
    }
    .ms-btn-primary:hover { background: #b07d4a; }

    .ms-search-box {
        display: flex; align-items: center;
        border: 1.5px solid #E5D6C5; border-radius: 6px;
        padding: 8px 14px; gap: 8px; background: #fff; transition: border-color .2s;
    }
    .ms-search-box:focus-within { border-color: #C58F59; }
    .ms-search-box input { border: none; outline: none; font-size: 13px; color: #582C0C; background: transparent; width: 200px; font-family: inherit; }
    .ms-search-box input::placeholder { color: #b09a88; }

    .ms-btn-filter {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 8px 14px; border: 1.5px solid #E5D6C5; border-radius: 6px;
        background: #fff; color: #582C0C; font-size: 13px; font-weight: 600;
        cursor: pointer; font-family: inherit; transition: all .2s;
    }
    .ms-btn-filter:hover { border-color: #C58F59; color: #C58F59; }

    /* Table */
    .ms-table-card { background: #fff; border: 1px solid #E5D6C5; border-radius: 8px; overflow: hidden; box-shadow: 0 1px 3px rgba(88,44,12,.05); margin-top: 16px; }
    .ms-table-wrapper { width: 100%; overflow-x: auto; }
    .ms-table-wrapper::-webkit-scrollbar { height: 6px; }
    .ms-table-wrapper::-webkit-scrollbar-thumb { background: #C58F59; border-radius: 3px; }
    .ms-table { width: 100%; border-collapse: collapse; text-align: left; }
    .ms-table th {
        background: #fdf8f4; color: #582C0C;
        font-size: 13px; font-weight: 600;
        padding: 12px 18px; border-bottom: 2px solid #E5D6C5; white-space: nowrap;
    }
    .ms-table th .sort { display: inline-flex; align-items: center; gap: 4px; cursor: pointer; user-select: none; }
    .ms-table th .sort svg { opacity: .5; }
    .ms-table td { padding: 13px 18px; font-size: 13px; color: #374151; border-bottom: 1px solid #F3EDE6; white-space: nowrap; }
    .ms-table tr:last-child td { border-bottom: none; }
    .ms-table tr:hover td { background: rgba(253,248,244,.7); }

    .ms-badge-aktif {
        display: inline-block; padding: 4px 14px; border-radius: 20px;
        background: #D1FAE5; color: #065F46; font-size: 13px; font-weight: 600;
    }
    .ms-badge-nonaktif {
        display: inline-block; padding: 4px 14px; border-radius: 20px;
        background: #FEE2E2; color: #991B1B; font-size: 13px; font-weight: 600;
    }

    .ms-action-row { display: flex; align-items: center; gap: 8px; }
    .ms-icon-btn {
        width: 30px; height: 30px; border-radius: 6px;
        border: 1.5px solid #E5D6C5; background: #fff;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer; color: #6B513E; transition: all .2s;
    }
    .ms-icon-btn:hover { border-color: #C58F59; color: #C58F59; }
    .ms-kebab-btn {
        width: 30px; height: 30px; border-radius: 6px;
        border: none; background: transparent;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer; color: #9CA3AF; transition: color .2s;
    }
    .ms-kebab-btn:hover { color: #582C0C; }

    /* Pagination */
    .ms-pagination { display: flex; justify-content: flex-end; align-items: center; padding: 12px 18px; gap: 20px; border-top: 1px solid #E5D6C5; }
    .ms-page-size { display: flex; align-items: center; gap: 6px; color: #6B513E; }
    .ms-page-size select { border: none; outline: none; font-weight: 600; color: #582C0C; font-size: 13px; cursor: pointer; background: transparent; font-family: inherit; }
    .ms-page-info { color: #6B513E; }
    .ms-page-controls { display: flex; gap: 4px; }
    .ms-page-btn { background: none; border: none; color: #9CA3AF; cursor: pointer; padding: 4px 6px; border-radius: 4px; line-height: 0; }
    .ms-page-btn:not([disabled]):hover { color: #582C0C; background: #fdf8f4; }
    .ms-page-btn[disabled] { opacity: .4; cursor: default; pointer-events: none; }
</style>

<div class="ms-header-row">
    <div>
        <h2 class="ms-title">Manajemen Staff</h2>
        <p class="ms-subtitle">Last Update: 17 Desember 2024 (13:50 WIB)</p>
    </div>
    <div style="display:flex;gap:10px;align-items:center;flex-wrap:wrap;">
        <div class="ms-btn-group">
            <button class="ms-btn-group-item active">Informasi PIC</button>
            <button class="ms-btn-group-item">Tidak Aktif</button>
        </div>
        <button class="ms-btn-primary">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 5v14M5 12h14"/></svg>
            + Tambah Staff
        </button>
    </div>
</div>

<div style="display:flex;gap:10px;align-items:center;flex-wrap:wrap;">
    <div class="ms-search-box">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#6B513E" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
        <input type="text" placeholder="Cari staff">
    </div>
    <button class="ms-btn-filter">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="4" y1="6" x2="16" y2="6"/><line x1="8" y1="12" x2="20" y2="12"/><line x1="4" y1="18" x2="12" y2="18"/></svg>
        Filter
    </button>
</div>

<div class="ms-table-card">
    <div class="ms-table-wrapper">
        <table class="ms-table">
            <thead>
                <tr>
                    <th><span class="sort">↑↓ Nama</span></th>
                    <th><span class="sort">↑↓ Status</span></th>
                    <th><span class="sort">↑↓ Tipe Akses</span></th>
                    <th>Nomor HP</th>
                    <th>Login Email</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>dinda tegar jelita</td>
                    <td><span class="ms-badge-aktif">Aktif</span></td>
                    <td>Owner</td>
                    <td>**********355</td>
                    <td>**********...</td>
                    <td>
                        <div class="ms-action-row">
                            <button class="ms-icon-btn" title="Edit">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            </button>
                            <button class="ms-kebab-btn" title="More">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="5" r="1.5"/><circle cx="12" cy="12" r="1.5"/><circle cx="12" cy="19" r="1.5"/></svg>
                            </button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>drg. Maya Sp.Perio</td>
                    <td><span class="ms-badge-aktif">Aktif</span></td>
                    <td>Doctor</td>
                    <td>**********43</td>
                    <td>**********...</td>
                    <td>
                        <div class="ms-action-row">
                            <button class="ms-icon-btn" title="Edit">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            </button>
                            <button class="ms-kebab-btn" title="More">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="5" r="1.5"/><circle cx="12" cy="12" r="1.5"/><circle cx="12" cy="19" r="1.5"/></svg>
                            </button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>drg. Ria Budiati Sp.Ortho</td>
                    <td><span class="ms-badge-aktif">Aktif</span></td>
                    <td>Owner</td>
                    <td>**********244</td>
                    <td>**********...</td>
                    <td>
                        <div class="ms-action-row">
                            <button class="ms-icon-btn" title="Edit">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            </button>
                            <button class="ms-kebab-btn" title="More">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="5" r="1.5"/><circle cx="12" cy="12" r="1.5"/><circle cx="12" cy="19" r="1.5"/></svg>
                            </button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Sonia Novitasari</td>
                    <td><span class="ms-badge-aktif">Aktif</span></td>
                    <td>Owner</td>
                    <td>**********3039</td>
                    <td>**********...</td>
                    <td>
                        <div class="ms-action-row">
                            <button class="ms-icon-btn" title="Edit">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            </button>
                            <button class="ms-kebab-btn" title="More">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="5" r="1.5"/><circle cx="12" cy="12" r="1.5"/><circle cx="12" cy="19" r="1.5"/></svg>
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="ms-pagination">
        <div class="ms-page-size">Jumlah baris per halaman: <select><option>5</option><option>10</option><option>25</option></select></div>
        <div class="ms-page-info">1–4 dari 4 data</div>
        <div class="ms-page-controls">
            <button class="ms-page-btn" disabled><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M11 17l-5-5 5-5M18 17l-5-5 5-5"/></svg></button>
            <button class="ms-page-btn" disabled><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M15 18l-6-6 6-6"/></svg></button>
            <button class="ms-page-btn" disabled><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 18l6-6-6-6"/></svg></button>
            <button class="ms-page-btn" disabled><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M13 17l5-5-5-5M6 17l5-5-5-5"/></svg></button>
        </div>
    </div>
</div>
