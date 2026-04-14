@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/components/settings/master_crud.css') }}">
    <style>
        .mc-form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        @media (max-width: 600px) { .mc-form-row { grid-template-columns: 1fr; } }
    </style>
@endpush

@include('admin.components.settings.partials.flash_success')

<div class="mc-header-row">
    <div style="display: flex; align-items: center; gap: 16px;">
        <a href="?menu=general-settings" class="mc-btn-icon" title="Kembali ke General Settings">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
        </a>
        <div>
            <h2 class="mc-title">Manajemen Jenis Kunjungan</h2>
            <p class="mc-subtitle">Kelola data jenis kunjungan di sistem hanglekiu</p>
        </div>
    </div>
    <button class="mc-btn-primary" onclick="openVisitModal()">+ Tambah Jenis Kunjungan</button>
</div>

@include('admin.components.settings.partials.inline_notice')

<div class="mc-actions-row">
    <div class="mc-search-box">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#6B513E" stroke-width="2">
            <circle cx="11" cy="11" r="8"></circle>
            <path d="M21 21l-4.35-4.35"></path>
        </svg>
        <input type="text" id="search-visit" placeholder="Cari jenis kunjungan..." onkeyup="fetchVisitData()">
    </div>
</div>

<div class="mc-table-card">
    <table class="mc-table">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Deskripsi</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody id="visit-table-body">
            <!-- Data loaded via AJAX -->
        </tbody>
    </table>
    <div class="mc-pagination" id="visit-pagination"></div>
</div>

<!-- Modal Form -->
<div id="visit-modal" class="mc-modal-overlay">
    <div class="mc-modal-content">
        <div class="mc-modal-header">
            <h3 id="visit-modal-title">Tambah Jenis Kunjungan</h3>
            <button class="mc-modal-close" onclick="closeVisitModal()">&times;</button>
        </div>
        <form id="visit-form" onsubmit="saveVisitData(event)">
            <input type="hidden" id="visit-id">
            <div class="mc-modal-body">
                <div class="mc-form-group">
                    <label class="mc-label">Nama Jenis Kunjungan <span style="color:red">*</span></label>
                    <input type="text" id="visit-name" class="mc-input" placeholder="Masukkan nama jenis kunjungan" required>
                </div>
                <div class="mc-form-group">
                    <label class="mc-label">Deskripsi</label>
                    <textarea id="visit-description" class="mc-input" placeholder="Deskripsi jenis kunjungan" style="resize:vertical; min-height:80px;"></textarea>
                </div>
                <div class="mc-form-group">
                    <label class="mc-label">Status</label>
                    <select id="visit-active" class="mc-input">
                        <option value="1">Aktif</option>
                        <option value="0">Tidak Aktif</option>
                    </select>
                </div>
            </div>
            <div class="mc-modal-footer">
                <button type="button" class="mc-btn-secondary" onclick="closeVisitModal()">Batal</button>
                <button type="submit" class="mc-btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
    const VISIT_API = '/api/master-visit-type';
    let visitCurrentPage = 1;

    function showVisitToast(message, type = 'success') {
        window.showSettingsInlineNotice?.(message, type);
    }

    function showVisitConfirm(message) {
        return new Promise((resolve) => {
            const old = document.getElementById('visit-confirm-overlay');
            if (old) old.remove();

            const overlay = document.createElement('div');
            overlay.id = 'visit-confirm-overlay';
            overlay.style.cssText = 'position:fixed;inset:0;background:rgba(44,27,16,.46);display:flex;align-items:center;justify-content:center;z-index:10000;padding:16px;box-sizing:border-box;';
            overlay.innerHTML = `
                <div style="width:min(100%,620px);max-height:calc(100vh - 32px);overflow:auto;background:#FFFDFB;border-radius:18px;box-shadow:0 26px 56px rgba(47,29,17,.28);border:1px solid #E9D8C8;padding:28px 24px;box-sizing:border-box;text-align:center;">
                    <div style="font-size:24px;font-weight:700;line-height:1.15;color:#2B1609;margin-bottom:14px;">Konfirmasi Hapus</div>
                    <div style="font-size:20px;color:#5E3A24;line-height:1.45;max-width:90%;margin:0 auto;">${message}</div>
                    <div style="display:flex;justify-content:center;gap:14px;margin-top:32px;">
                        <button type="button" data-action="cancel" style="border:1px solid #D3BCA7;background:#FFF8F2;color:#4A2D1A;padding:12px 20px;border-radius:12px;cursor:pointer;font-size:16px;font-weight:600;line-height:1.2;">Batal</button>
                        <button type="button" data-action="ok" style="border:none;background:#4A2B1B;color:#fff;padding:12px 20px;border-radius:12px;cursor:pointer;font-size:16px;font-weight:600;line-height:1.2;">Ya, Hapus</button>
                    </div>
                </div>
            `;
            document.body.appendChild(overlay);

            const close = (val) => {
                overlay.remove();
                resolve(val);
            };
            overlay.querySelector('[data-action="cancel"]').addEventListener('click', () => close(false));
            overlay.querySelector('[data-action="ok"]').addEventListener('click', () => close(true));
            overlay.addEventListener('click', (e) => {
                if (e.target === overlay) close(false);
            });
        });
    }

    window.fetchVisitData = function(page = 1) {
        visitCurrentPage = page;
        const search = document.getElementById('search-visit').value;
        const url = `${VISIT_API}?page=${page}&search=${search}`;

        fetch(url)
            .then(r => r.json())
            .then(data => renderVisitTable(data.data))
            .catch(() => alert('Gagal memuat data'));
    };

    function renderVisitTable(data) {
        const tbody = document.getElementById('visit-table-body');
        tbody.innerHTML = '';

        if (!data.data || data.data.length === 0) {
            tbody.innerHTML = '<tr><td colspan="4" style="text-align:center;color:#9CA3AF">Data tidak ditemukan</td></tr>';
            return;
        }

        data.data.forEach(item => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td><strong>${item.name}</strong></td>
                <td style="color:#6B7280; font-size:13px">${item.description || '-'}</td>
                <td>
                    <span class="mc-badge ${item.is_active ? 'mc-badge-active' : 'mc-badge-inactive'}">
                        ${item.is_active ? 'Aktif' : 'Tidak Aktif'}
                    </span>
                </td>
                <td>
                    <div class="mc-action-btns">
                        <button class="mc-btn-icon" onclick="openVisitModal('${item.id}')" title="Edit">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        </button>
                        <button class="mc-btn-icon delete" onclick="deleteVisitData('${item.id}')" title="Hapus">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                        </button>
                    </div>
                </td>
            `;
            tbody.appendChild(tr);
        });

        renderPaginationVisit(data);
    }

    function renderPaginationVisit(data) {
        const pag = document.getElementById('visit-pagination');
        pag.innerHTML = `<span>Menampilkan ${data.from || 0}–${data.to || 0} dari ${data.total} data</span>`;

        if (data.last_page <= 1) return;

        const controls = document.createElement('div');
        controls.className = 'mc-pagination-controls';

        if (data.current_page > 1) {
            const prev = document.createElement('button');
            prev.className = 'mc-page-btn';
            prev.innerHTML = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M15 18l-6-6 6-6"/></svg>';
            prev.onclick = () => fetchVisitData(data.current_page - 1);
            controls.appendChild(prev);
        }

        for (let i = Math.max(1, data.current_page - 2); i <= Math.min(data.last_page, data.current_page + 2); i++) {
            const btn = document.createElement('button');
            btn.className = `mc-page-btn ${i === data.current_page ? 'active' : ''}`;
            btn.textContent = i;
            btn.onclick = () => fetchVisitData(i);
            controls.appendChild(btn);
        }

        if (data.current_page < data.last_page) {
            const next = document.createElement('button');
            next.className = 'mc-page-btn';
            next.innerHTML = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 18l6-6-6-6"/></svg>';
            next.onclick = () => fetchVisitData(data.current_page + 1);
            controls.appendChild(next);
        }

        pag.appendChild(controls);
    }

    window.openVisitModal = function(id = null) {
        const modal = document.getElementById('visit-modal');
        document.getElementById('visit-form').reset();
        document.getElementById('visit-id').value = '';
        document.getElementById('visit-modal-title').textContent = id ? 'Edit Jenis Kunjungan' : 'Tambah Jenis Kunjungan';

        if (id) {
            fetch(`${VISIT_API}/${id}`)
                .then(r => r.json())
                .then(res => {
                    document.getElementById('visit-id').value = res.data.id;
                    document.getElementById('visit-name').value = res.data.name;
                    document.getElementById('visit-description').value = res.data.description || '';
                    document.getElementById('visit-active').value = res.data.is_active ? "1" : "0";
                });
        }
        modal.classList.add('show');
    };

    window.closeVisitModal = function() {
        document.getElementById('visit-modal').classList.remove('show');
    };

    window.saveVisitData = function(e) {
        e.preventDefault();
        const id = document.getElementById('visit-id').value;
        const method = id ? 'PUT' : 'POST';
        const url = id ? `${VISIT_API}/${id}` : VISIT_API;

        const data = {
            name: document.getElementById('visit-name').value,
            description: document.getElementById('visit-description').value,
            is_active: document.getElementById('visit-active').value === "1"
        };

        fetch(url, {
            method: method,
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify(data)
        })
        .then(r => {
            if (!r.ok) {
                return r.text().then(text => {
                    console.error('Error response:', r.status, text);
                    throw new Error(`HTTP ${r.status}: ${text.substring(0, 200)}`);
                });
            }
            return r.json();
        })
        .then(res => {
            if (res.success) {
                closeVisitModal();
                fetchVisitData(visitCurrentPage);
                showVisitToast(id ? 'Data berhasil diperbarui' : 'Data berhasil ditambahkan');
            } else {
                showVisitToast(res.message || 'Gagal menyimpan data', 'error');
            }
        })
        .catch(err => {
            console.error('Save error:', err);
            showVisitToast('Gagal menyimpan: ' + err.message, 'error');
        });
    };

    window.deleteVisitData = async function(id) {
        const confirmed = await showVisitConfirm('Data yang dihapus tidak dapat dikembalikan. Lanjutkan?');
        if (!confirmed) return;

        fetch(`${VISIT_API}/${id}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
        })
        .then(r => r.json())
        .then(res => {
            if (res.success) {
                fetchVisitData(visitCurrentPage);
                showVisitToast('Data berhasil dihapus');
            } else {
                showVisitToast(res.message || 'Gagal menghapus data', 'error');
            }
        })
        .catch(() => showVisitToast('Terjadi kesalahan saat menghapus data', 'error'));
    };

    // Load data on page load
    fetchVisitData();
</script>