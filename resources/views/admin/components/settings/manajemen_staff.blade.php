@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/components/settings/manajemen_staff.css') }}">
@endpush

{{-- resources/views/admin/settings/manajemen_staff.blade.php --}}
<div class="ms-header-row">
    <div>
        <h2 class="ms-title">Manajemen Staff</h2>
        <p class="ms-subtitle">Last Update: 17 Desember 2024 (13:50 WIB)</p>
    </div>
    <div class="ms-actions-row">
        <div class="ms-btn-group">
            <button class="ms-btn-group-item active">Informasi PIC</button>
            <button class="ms-btn-group-item">Tidak Aktif</button>
        </div>
        <button class="ms-btn-primary">
            + Tambah Staff
        </button>
    </div>
</div>

<div class="ms-actions-row">
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
