{{-- dental_visit_type.blade.php --}}
<div class="dental-master-page">

    {{-- ===== HEADER ===== --}}
    <div class="dmp-header">
        <div class="dmp-header-icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path d="M12 2C8.5 2 6 4.5 6 7c0 1.5.5 3 1.5 4L12 22l4.5-11C17.5 10 18 8.5 18 7c0-2.5-2.5-5-6-5z"/>
                <circle cx="12" cy="7" r="1.5" fill="currentColor" stroke="none"/>
            </svg>
        </div>
        <div>
            <h1 class="dmp-title">Manajemen Jenis Kunjungan</h1>
            <p class="dmp-subtitle">Kelola tipe kunjungan pasien — konsultasi, kontrol, darurat, dan lainnya</p>
        </div>

        {{-- ===== TOMBOL TAMBAH ===== --}}
        <button class="dmp-btn-add" onclick="openModal()">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
            </svg>
            Tambah Jenis Kunjungan
        </button>
    </div>

    {{-- ===== SEARCH + FILTER ===== --}}
    <div class="dmp-toolbar">
        <div class="dmp-search-wrap">
            <svg class="dmp-search-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
            </svg>
            <input type="text" id="searchInput" class="dmp-search" placeholder="Cari jenis kunjungan..." oninput="filterData()">
        </div>
        <div class="dmp-filter-group">
            <button class="dmp-filter active" data-filter="all" onclick="setFilter('all', this)">Semua</button>
            <button class="dmp-filter" data-filter="1" onclick="setFilter('1', this)">Aktif</button>
            <button class="dmp-filter" data-filter="0" onclick="setFilter('0', this)">Nonaktif</button>
        </div>
    </div>

    {{-- ===== TABEL ===== --}}
    <div class="dmp-table-wrap">
        <table class="dmp-table">
            <thead>
                <tr>
                    <th style="width:48px">#</th>
                    <th>Jenis Kunjungan</th>
                    <th style="width:120px">Status</th>
                    <th style="width:130px">Aksi</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                <tr id="loadingRow">
                    <td colspan="4" class="dmp-loading">
                        <span class="dmp-spinner"></span> Memuat data...
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- ===== PAGINATION ===== --}}
    <div class="dmp-pagination" id="pagination"></div>

</div>

{{-- ===== MODAL TAMBAH/EDIT ===== --}}
<div class="dmp-overlay" id="modalOverlay" onclick="closeModal()"></div>
<div class="dmp-modal" id="modal">
    <div class="dmp-modal-header">
        <div class="dmp-modal-icon">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path d="M12 2C8.5 2 6 4.5 6 7c0 1.5.5 3 1.5 4L12 22l4.5-11C17.5 10 18 8.5 18 7c0-2.5-2.5-5-6-5z"/>
            </svg>
        </div>
        <h2 class="dmp-modal-title" id="modalTitle">Tambah Jenis Kunjungan</h2>
        <button class="dmp-modal-close" onclick="closeModal()">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
            </svg>
        </button>
    </div>
    <div class="dmp-modal-body">
        <input type="hidden" id="editId">
        <div class="dmp-field">
            <label class="dmp-label">Nama Jenis Kunjungan <span class="dmp-required">*</span></label>
            <input type="text" id="nameInput" class="dmp-input" placeholder="Contoh: Konsultasi Awal, Kontrol Rutin, Darurat...">
            <span class="dmp-hint">Gunakan nama yang jelas dan mudah dipahami staf klinik</span>
        </div>
        <div class="dmp-field">
            <label class="dmp-label">Status</label>
            <div class="dmp-toggle-wrap">
                <label class="dmp-toggle">
                    <input type="checkbox" id="isActive" checked>
                    <span class="dmp-toggle-slider"></span>
                </label>
                <span class="dmp-toggle-label" id="toggleLabel">Aktif</span>
            </div>
        </div>
    </div>
    <div class="dmp-modal-footer">
        <button class="dmp-btn-cancel" onclick="closeModal()">Batal</button>
        <button class="dmp-btn-save" id="saveBtn" onclick="saveData()">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <polyline points="20 6 9 17 4 12"/>
            </svg>
            Simpan
        </button>
    </div>
</div>

{{-- ===== MODAL KONFIRMASI HAPUS ===== --}}
<div class="dmp-overlay" id="deleteOverlay" onclick="closeDelete()"></div>
<div class="dmp-modal dmp-modal-sm" id="deleteModal">
    <div class="dmp-delete-icon">
        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <polyline points="3 6 5 6 21 6"/>
            <path d="M19 6l-1 14H6L5 6"/>
            <path d="M10 11v6M14 11v6"/>
            <path d="M9 6V4h6v2"/>
        </svg>
    </div>
    <h3 class="dmp-delete-title">Hapus Jenis Kunjungan?</h3>
    <p class="dmp-delete-desc">Data <strong id="deleteItemName"></strong> akan dihapus permanen dan tidak bisa dikembalikan.</p>
    <div class="dmp-modal-footer">
        <button class="dmp-btn-cancel" onclick="closeDelete()">Batal</button>
        <button class="dmp-btn-delete" id="confirmDeleteBtn" onclick="confirmDelete()">Hapus</button>
    </div>
</div>

{{-- ===== TOAST ===== --}}
<div class="dmp-toast" id="toast"></div>

@push('styles')
<style>
/* ===== RESET & BASE ===== */
.dental-master-page { padding: 28px 32px; max-width: 960px; }

/* ===== HEADER ===== */
.dmp-header { display:flex; align-items:center; gap:16px; margin-bottom:28px; }
.dmp-header-icon { width:52px; height:52px; background:#EBF4FF; border-radius:14px; display:flex; align-items:center; justify-content:center; color:#2563EB; flex-shrink:0; }
.dmp-title { font-size:22px; font-weight:700; color:#111827; margin:0 0 2px; }
.dmp-subtitle { font-size:13.5px; color:#6B7280; margin:0; }
.dmp-btn-add { margin-left:auto; display:flex; align-items:center; gap:8px; background:#2563EB; color:#fff; border:none; border-radius:10px; padding:10px 18px; font-size:14px; font-weight:600; cursor:pointer; transition:.15s; white-space:nowrap; }
.dmp-btn-add:hover { background:#1D4ED8; }

/* ===== TOOLBAR ===== */
.dmp-toolbar { display:flex; align-items:center; gap:12px; margin-bottom:20px; }
.dmp-search-wrap { position:relative; flex:1; max-width:360px; }
.dmp-search-icon { position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#9CA3AF; pointer-events:none; }
.dmp-search { width:100%; padding:9px 12px 9px 38px; border:1.5px solid #E5E7EB; border-radius:9px; font-size:14px; color:#111827; outline:none; transition:.15s; background:#FAFAFA; }
.dmp-search:focus { border-color:#2563EB; background:#fff; }
.dmp-filter-group { display:flex; gap:6px; }
.dmp-filter { padding:8px 14px; border:1.5px solid #E5E7EB; border-radius:8px; font-size:13px; color:#6B7280; background:#fff; cursor:pointer; transition:.15s; }
.dmp-filter:hover { border-color:#2563EB; color:#2563EB; }
.dmp-filter.active { background:#EBF4FF; border-color:#2563EB; color:#2563EB; font-weight:600; }

/* ===== TABLE ===== */
.dmp-table-wrap { background:#fff; border:1.5px solid #E5E7EB; border-radius:14px; overflow:hidden; }
.dmp-table { width:100%; border-collapse:collapse; }
.dmp-table thead tr { background:#F9FAFB; }
.dmp-table th { padding:12px 16px; text-align:left; font-size:12.5px; font-weight:600; color:#6B7280; text-transform:uppercase; letter-spacing:.5px; border-bottom:1.5px solid #E5E7EB; }
.dmp-table td { padding:14px 16px; font-size:14px; color:#374151; border-bottom:1px solid #F3F4F6; }
.dmp-table tbody tr:last-child td { border-bottom:none; }
.dmp-table tbody tr:hover { background:#F9FAFB; }

/* ===== BADGE STATUS ===== */
.dmp-badge { display:inline-flex; align-items:center; gap:5px; padding:3px 10px; border-radius:20px; font-size:12px; font-weight:600; }
.dmp-badge-active { background:#DCFCE7; color:#15803D; }
.dmp-badge-inactive { background:#F3F4F6; color:#9CA3AF; }
.dmp-badge-dot { width:6px; height:6px; border-radius:50%; background:currentColor; }

/* ===== ACTION BUTTONS ===== */
.dmp-actions { display:flex; gap:6px; }
.dmp-btn-icon { width:32px; height:32px; border:1.5px solid #E5E7EB; border-radius:7px; background:#fff; cursor:pointer; display:flex; align-items:center; justify-content:center; color:#6B7280; transition:.15s; }
.dmp-btn-icon:hover { border-color:#2563EB; color:#2563EB; background:#EBF4FF; }
.dmp-btn-icon.del:hover { border-color:#EF4444; color:#EF4444; background:#FEF2F2; }

/* ===== LOADING & EMPTY ===== */
.dmp-loading, .dmp-empty { text-align:center; padding:48px 16px; color:#9CA3AF; font-size:14px; }
.dmp-spinner { display:inline-block; width:18px; height:18px; border:2.5px solid #E5E7EB; border-top-color:#2563EB; border-radius:50%; animation:spin .7s linear infinite; vertical-align:middle; margin-right:8px; }
@keyframes spin { to { transform:rotate(360deg); } }

/* ===== PAGINATION ===== */
.dmp-pagination { display:flex; gap:6px; justify-content:flex-end; margin-top:16px; }
.dmp-page-btn { width:34px; height:34px; border:1.5px solid #E5E7EB; border-radius:8px; background:#fff; font-size:13px; color:#374151; cursor:pointer; display:flex; align-items:center; justify-content:center; transition:.15s; }
.dmp-page-btn:hover { border-color:#2563EB; color:#2563EB; }
.dmp-page-btn.active { background:#2563EB; border-color:#2563EB; color:#fff; font-weight:700; }
.dmp-page-btn:disabled { opacity:.4; cursor:not-allowed; }

/* ===== MODAL ===== */
.dmp-overlay { display:none; position:fixed; inset:0; background:rgba(0,0,0,.35); z-index:1000; backdrop-filter:blur(2px); }
.dmp-overlay.show { display:block; }
.dmp-modal { display:none; position:fixed; top:50%; left:50%; transform:translate(-50%,-50%); background:#fff; border-radius:18px; width:460px; max-width:95vw; z-index:1001; box-shadow:0 24px 60px rgba(0,0,0,.18); }
.dmp-modal.show { display:block; }
.dmp-modal-sm { width:360px; text-align:center; padding:32px 28px 24px; }
.dmp-modal-header { display:flex; align-items:center; gap:12px; padding:20px 24px 0; }
.dmp-modal-icon { width:40px; height:40px; background:#EBF4FF; border-radius:10px; display:flex; align-items:center; justify-content:center; color:#2563EB; flex-shrink:0; }
.dmp-modal-title { font-size:17px; font-weight:700; color:#111827; margin:0; flex:1; }
.dmp-modal-close { width:32px; height:32px; border:none; background:none; cursor:pointer; color:#9CA3AF; border-radius:7px; display:flex; align-items:center; justify-content:center; transition:.15s; }
.dmp-modal-close:hover { background:#F3F4F6; color:#374151; }
.dmp-modal-body { padding:20px 24px; }
.dmp-field { margin-bottom:18px; }
.dmp-label { display:block; font-size:13.5px; font-weight:600; color:#374151; margin-bottom:7px; }
.dmp-required { color:#EF4444; }
.dmp-input { width:100%; padding:10px 13px; border:1.5px solid #E5E7EB; border-radius:9px; font-size:14px; color:#111827; outline:none; transition:.15s; box-sizing:border-box; }
.dmp-input:focus { border-color:#2563EB; box-shadow:0 0 0 3px rgba(37,99,235,.1); }
.dmp-hint { font-size:12px; color:#9CA3AF; margin-top:5px; display:block; }
.dmp-modal-footer { display:flex; gap:10px; justify-content:flex-end; padding:16px 24px 20px; border-top:1px solid #F3F4F6; }

/* ===== TOGGLE ===== */
.dmp-toggle-wrap { display:flex; align-items:center; gap:10px; }
.dmp-toggle { position:relative; display:inline-block; width:44px; height:24px; }
.dmp-toggle input { opacity:0; width:0; height:0; }
.dmp-toggle-slider { position:absolute; inset:0; background:#D1D5DB; border-radius:24px; cursor:pointer; transition:.25s; }
.dmp-toggle-slider:before { content:''; position:absolute; left:3px; top:3px; width:18px; height:18px; background:#fff; border-radius:50%; transition:.25s; box-shadow:0 1px 3px rgba(0,0,0,.2); }
.dmp-toggle input:checked + .dmp-toggle-slider { background:#2563EB; }
.dmp-toggle input:checked + .dmp-toggle-slider:before { transform:translateX(20px); }
.dmp-toggle-label { font-size:14px; color:#374151; }

/* ===== BUTTONS ===== */
.dmp-btn-cancel { padding:9px 18px; border:1.5px solid #E5E7EB; border-radius:9px; background:#fff; font-size:14px; color:#6B7280; cursor:pointer; transition:.15s; }
.dmp-btn-cancel:hover { border-color:#D1D5DB; background:#F9FAFB; }
.dmp-btn-save { display:flex; align-items:center; gap:7px; padding:9px 20px; background:#2563EB; border:none; border-radius:9px; font-size:14px; font-weight:600; color:#fff; cursor:pointer; transition:.15s; }
.dmp-btn-save:hover { background:#1D4ED8; }

/* ===== DELETE MODAL ===== */
.dmp-delete-icon { width:64px; height:64px; background:#FEF2F2; border-radius:50%; display:flex; align-items:center; justify-content:center; color:#EF4444; margin:0 auto 16px; }
.dmp-delete-title { font-size:18px; font-weight:700; color:#111827; margin:0 0 8px; }
.dmp-delete-desc { font-size:14px; color:#6B7280; margin:0 0 20px; line-height:1.5; }
.dmp-btn-delete { padding:9px 20px; background:#EF4444; border:none; border-radius:9px; font-size:14px; font-weight:600; color:#fff; cursor:pointer; transition:.15s; }
.dmp-btn-delete:hover { background:#DC2626; }

/* ===== TOAST ===== */
.dmp-toast { position:fixed; bottom:28px; right:28px; background:#111827; color:#fff; padding:12px 20px; border-radius:10px; font-size:14px; font-weight:500; opacity:0; transform:translateY(10px); transition:.25s; pointer-events:none; z-index:2000; max-width:320px; }
.dmp-toast.show { opacity:1; transform:translateY(0); }
.dmp-toast.success { background:#15803D; }
.dmp-toast.error { background:#DC2626; }
</style>
@endpush

@push('scripts')
<script>
const API_URL = '/api/master-visit-type';
let currentPage = 1;
let currentFilter = 'all';
let searchDebounce;
let deleteId = null;

// ===== FETCH DATA =====
async function loadData(page = 1) {
    currentPage = page;
    const search = document.getElementById('searchInput').value;
    let url = `${API_URL}?page=${page}&search=${encodeURIComponent(search)}`;
    if (currentFilter !== 'all') url += `&is_active=${currentFilter}`;

    showLoading();
    try {
        const res = await fetch(url);
        const json = await res.json();
        renderTable(json.data);
        renderPagination(json.data);
    } catch {
        showError();
    }
}

function showLoading() {
    document.getElementById('tableBody').innerHTML = `
        <tr id="loadingRow"><td colspan="4" class="dmp-loading">
            <span class="dmp-spinner"></span> Memuat data...
        </td></tr>`;
    document.getElementById('pagination').innerHTML = '';
}

function showError() {
    document.getElementById('tableBody').innerHTML = `
        <tr><td colspan="4" class="dmp-empty">Gagal memuat data. Coba refresh halaman.</td></tr>`;
}

// ===== RENDER TABLE =====
function renderTable(data) {
    const rows = data.data;
    if (!rows.length) {
        document.getElementById('tableBody').innerHTML = `
            <tr><td colspan="4" class="dmp-empty">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#D1D5DB" stroke-width="1.5" style="display:block;margin:0 auto 10px">
                    <path d="M12 2C8.5 2 6 4.5 6 7c0 1.5.5 3 1.5 4L12 22l4.5-11C17.5 10 18 8.5 18 7c0-2.5-2.5-5-6-5z"/>
                </svg>
                Belum ada jenis kunjungan
            </td></tr>`;
        return;
    }
    const html = rows.map((r, i) => `
        <tr>
            <td style="color:#9CA3AF;font-size:13px">${(data.current_page - 1) * data.per_page + i + 1}</td>
            <td><strong style="color:#111827">${esc(r.name || r.visit_type_name)}</strong></td>
            <td>${badge(r.is_active)}</td>
            <td>
                <div class="dmp-actions">
                    <button class="dmp-btn-icon" onclick="openEdit('${r.id}', '${esc(r.name || r.visit_type_name)}', ${r.is_active})" title="Edit">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                        </svg>
                    </button>
                    <button class="dmp-btn-icon del" onclick="openDelete('${r.id}', '${esc(r.name || r.visit_type_name)}')" title="Hapus">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="3 6 5 6 21 6"/>
                            <path d="M19 6l-1 14H6L5 6"/>
                            <path d="M10 11v6M14 11v6"/>
                            <path d="M9 6V4h6v2"/>
                        </svg>
                    </button>
                </div>
            </td>
        </tr>`).join('');
    document.getElementById('tableBody').innerHTML = html;
}

function badge(active) {
    return active
        ? `<span class="dmp-badge dmp-badge-active"><span class="dmp-badge-dot"></span>Aktif</span>`
        : `<span class="dmp-badge dmp-badge-inactive"><span class="dmp-badge-dot"></span>Nonaktif</span>`;
}

function esc(str) { return String(str).replace(/'/g, "\\'").replace(/"/g, '&quot;'); }

// ===== PAGINATION =====
function renderPagination(data) {
    if (data.last_page <= 1) { document.getElementById('pagination').innerHTML = ''; return; }
    let html = '';
    for (let i = 1; i <= data.last_page; i++) {
        html += `<button class="dmp-page-btn${i === data.current_page ? ' active' : ''}" onclick="loadData(${i})">${i}</button>`;
    }
    document.getElementById('pagination').innerHTML = html;
}

// ===== FILTER & SEARCH =====
function setFilter(val, btn) {
    currentFilter = val;
    document.querySelectorAll('.dmp-filter').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    loadData(1);
}

function filterData() {
    clearTimeout(searchDebounce);
    searchDebounce = setTimeout(() => loadData(1), 400);
}

// ===== MODAL TAMBAH =====
function openModal() {
    document.getElementById('modalTitle').textContent = 'Tambah Jenis Kunjungan';
    document.getElementById('editId').value = '';
    document.getElementById('nameInput').value = '';
    document.getElementById('isActive').checked = true;
    updateToggleLabel();
    showModal();
}

// ===== MODAL EDIT =====
function openEdit(id, name, active) {
    document.getElementById('modalTitle').textContent = 'Edit Jenis Kunjungan';
    document.getElementById('editId').value = id;
    document.getElementById('nameInput').value = name;
    document.getElementById('isActive').checked = !!active;
    updateToggleLabel();
    showModal();
}

function showModal() {
    document.getElementById('modal').classList.add('show');
    document.getElementById('modalOverlay').classList.add('show');
    setTimeout(() => document.getElementById('nameInput').focus(), 100);
}

function closeModal() {
    document.getElementById('modal').classList.remove('show');
    document.getElementById('modalOverlay').classList.remove('show');
}

document.getElementById('isActive').addEventListener('change', updateToggleLabel);
function updateToggleLabel() {
    document.getElementById('toggleLabel').textContent = document.getElementById('isActive').checked ? 'Aktif' : 'Nonaktif';
}

// ===== SAVE =====
async function saveData() {
    const id = document.getElementById('editId').value;
    const name = document.getElementById('nameInput').value.trim();
    const isActive = document.getElementById('isActive').checked;

    if (!name) {
        document.getElementById('nameInput').focus();
        document.getElementById('nameInput').style.borderColor = '#EF4444';
        return;
    }
    document.getElementById('nameInput').style.borderColor = '';

    const btn = document.getElementById('saveBtn');
    btn.disabled = true; btn.textContent = 'Menyimpan...';

    try {
        const method = id ? 'PUT' : 'POST';
        const url = id ? `${API_URL}/${id}` : API_URL;
        const res = await fetch(url, {
            method,
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
            body: JSON.stringify({ name, is_active: isActive })
        });
        const json = await res.json();
        if (json.success) {
            closeModal();
            toast(id ? 'Jenis kunjungan berhasil diupdate' : 'Jenis kunjungan berhasil ditambahkan', 'success');
            loadData(currentPage);
        } else {
            toast(json.message || 'Gagal menyimpan data', 'error');
        }
    } catch {
        toast('Terjadi kesalahan, coba lagi', 'error');
    } finally {
        btn.disabled = false;
        btn.innerHTML = `<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg> Simpan`;
    }
}

// ===== DELETE =====
function openDelete(id, name) {
    deleteId = id;
    document.getElementById('deleteItemName').textContent = name;
    document.getElementById('deleteModal').classList.add('show');
    document.getElementById('deleteOverlay').classList.add('show');
}

function closeDelete() {
    document.getElementById('deleteModal').classList.remove('show');
    document.getElementById('deleteOverlay').classList.remove('show');
    deleteId = null;
}

async function confirmDelete() {
    if (!deleteId) return;
    const btn = document.getElementById('confirmDeleteBtn');
    btn.disabled = true; btn.textContent = 'Menghapus...';
    try {
        const res = await fetch(`${API_URL}/${deleteId}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
        });
        const json = await res.json();
        if (json.success) {
            closeDelete();
            toast('Jenis kunjungan berhasil dihapus', 'success');
            loadData(currentPage);
        } else {
            toast(json.message || 'Gagal menghapus data', 'error');
        }
    } catch {
        toast('Terjadi kesalahan', 'error');
    } finally {
        btn.disabled = false; btn.textContent = 'Hapus';
    }
}

// ===== TOAST =====
function toast(msg, type = '') {
    const el = document.getElementById('toast');
    el.textContent = msg;
    el.className = `dmp-toast show ${type}`;
    setTimeout(() => el.classList.remove('show'), 3000);
}

// ===== INIT =====
loadData();
</script>
@endpush