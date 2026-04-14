@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/components/settings/master_crud.css') }}">
@endpush

@include('admin.components.settings.partials.flash_success')

<div class="mc-header-row">
    <div style="display: flex; align-items: center; gap: 16px;">
        <a href="?menu=general-settings" class="mc-btn-icon" title="Kembali ke General Settings">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
        </a>
        <div>
            <h2 class="mc-title">Manajemen Jenis Perawatan</h2>
            <p class="mc-subtitle">Kelola data jenis perawatan di sistem hanglekiu</p>
        </div>
    </div>
    <button class="mc-btn-primary" onclick="openCareModal()">+ Tambah Jenis Perawatan</button>
</div>

@include('admin.components.settings.partials.inline_notice')

<div class="mc-actions-row">
    <div class="mc-search-box">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#6B513E" stroke-width="2">
            <circle cx="11" cy="11" r="8"></circle>
            <path d="M21 21l-4.35-4.35"></path>
        </svg>
        <input type="text" id="care-search" placeholder="Cari jenis perawatan..." onkeyup="fetchCareData()">
    </div>
</div>

<div class="mc-table-card">
    <table class="mc-table">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody id="care-table-body">
            <!-- Data loaded via AJAX -->
        </tbody>
    </table>
    <div class="mc-pagination" id="care-pagination"></div>
</div>

<!-- Modal Care Type -->
<div id="care-modal" class="mc-modal-overlay">
    <div class="mc-modal-content">
        <div class="mc-modal-header">
            <h3 id="care-modal-title">Tambah Jenis Perawatan</h3>
            <button class="mc-modal-close" onclick="closeCareModal()">&times;</button>
        </div>
        <form id="care-form" onsubmit="saveCareData(event)">
            <input type="hidden" id="care-id">
            <div class="mc-modal-body">
                <div class="mc-form-group">
                    <label class="mc-label">Nama Jenis Perawatan</label>
                    <input type="text" id="care-input-name" class="mc-input" placeholder="Masukkan nama jenis perawatan" required>
                </div>
                <div class="mc-form-group">
                    <label class="mc-label">Deskripsi (Opsional)</label>
                    <textarea id="care-input-description" class="mc-input" placeholder="Masukkan deskripsi" rows="3"></textarea>
                </div>
                <div class="mc-form-group">
                    <label class="mc-label">Status Aktif</label>
                    <select id="care-input-active" class="mc-input">
                        <option value="1">Aktif</option>
                        <option value="0">Tidak Aktif</option>
                    </select>
                </div>
            </div>
            <div class="mc-modal-footer">
                <button type="button" class="mc-btn-secondary" onclick="closeCareModal()">Batal</button>
                <button type="submit" class="mc-btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
    (function() {
        let currentPage = 1;
        const apiUrl = '/api/master-care-type';

        function showCareToast(message, type = 'success') {
            window.showSettingsInlineNotice?.(message, type);
        }

        function showCareConfirm(message) {
            return new Promise((resolve) => {
                const old = document.getElementById('care-confirm-overlay');
                if (old) old.remove();

                const overlay = document.createElement('div');
                overlay.id = 'care-confirm-overlay';
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

        window.fetchCareData = function(page = 1) {
            currentPage = page;
            const search = document.getElementById('care-search').value;
            const url = `${apiUrl}?page=${page}&search=${search}`;

            fetch(url)
                .then(r => r.json())
                .then(data => {
                    const tbody = document.getElementById('care-table-body');
                    tbody.innerHTML = '';

                    if (data.data.data.length === 0) {
                        tbody.innerHTML = '<tr><td colspan="3" style="text-align:center">Data tidak ditemukan</td></tr>';
                    } else {
                        data.data.data.forEach(item => {
                            const tr = document.createElement('tr');
                            tr.innerHTML = `
                                <td>${item.name}</td>
                                <td>
                                    <span class="mc-badge ${item.is_active ? 'mc-badge-active' : 'mc-badge-inactive'}">
                                        ${item.is_active ? 'Aktif' : 'Tidak Aktif'}
                                    </span>
                                </td>
                                <td>
                                    <div class="mc-action-btns">
                                        <button class="mc-btn-icon" onclick="openCareModal('${item.id}')" title="Edit">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                        </button>
                                        <button class="mc-btn-icon delete" onclick="deleteCareData('${item.id}')" title="Hapus">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                        </button>
                                    </div>
                                </td>
                            `;
                            tbody.appendChild(tr);
                        });
                    }

                    const pagination = document.getElementById('care-pagination');
                    pagination.innerHTML = `<span>Menampilkan ${data.data.from || 0}–${data.data.to || 0} dari ${data.data.total} data</span>`;
                    if (data.data.last_page > 1) {
                        pagination.appendChild(renderCarePagination(data.data, fetchCareData));
                    }
                });
        };

        window.openCareModal = function(id = null) {
            const modal = document.getElementById('care-modal');
            const form = document.getElementById('care-form');
            form.reset();
            document.getElementById('care-id').value = '';
            document.getElementById('care-modal-title').innerText = id ? 'Edit Jenis Perawatan' : 'Tambah Jenis Perawatan';

            if (id) {
                fetch(`${apiUrl}/${id}`)
                    .then(r => r.json())
                    .then(res => {
                        const data = res.data;
                        document.getElementById('care-id').value = data.id;
                        document.getElementById('care-input-name').value = data.name;
                        document.getElementById('care-input-description').value = data.description || '';
                        document.getElementById('care-input-active').value = data.is_active ? "1" : "0";
                    });
            }
            modal.classList.add('show');
        };

        window.closeCareModal = function() {
            document.getElementById('care-modal').classList.remove('show');
        };

        window.saveCareData = function(e) {
            e.preventDefault();
            const id = document.getElementById('care-id').value;
            const method = id ? 'PUT' : 'POST';
            const url = id ? `${apiUrl}/${id}` : apiUrl;

            fetch(url, {
                method: method,
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({
                    name: document.getElementById('care-input-name').value,
                    price: 0,
                    description: document.getElementById('care-input-description').value,
                    is_active: document.getElementById('care-input-active').value === "1"
                })
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    closeCareModal();
                    fetchCareData(currentPage);
                    showCareToast(id ? 'Data berhasil diperbarui' : 'Data berhasil ditambahkan');
                } else {
                    showCareToast(data.message || 'Gagal menyimpan data', 'error');
                }
            });
        };

        window.deleteCareData = async function(id) {
            const confirmed = await showCareConfirm('Data yang dihapus tidak dapat dikembalikan. Lanjutkan?');
            if (!confirmed) return;

            fetch(`${apiUrl}/${id}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            })
            .then(r => r.json())
            .then(data => { 
                if (data.success) {
                    fetchCareData(currentPage);
                    showCareToast('Data berhasil dihapus');
                } else {
                    showCareToast(data.message || 'Gagal menghapus data', 'error');
                }
            })
            .catch(() => showCareToast('Terjadi kesalahan saat menghapus data', 'error'));
        };

        function createPageBtn(html, disabled, onclick, active = false) {
            const btn = document.createElement('button');
            btn.className = `mc-page-btn ${active ? 'active' : ''}`;
            btn.disabled = disabled;
            btn.innerHTML = html;
            btn.onclick = onclick;
            return btn;
        }

        function renderCarePagination(data, callback) {
            const controls = document.createElement('div');
            controls.className = 'mc-pagination-controls';

            const prevBtn = createPageBtn('<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M15 18l-6-6 6-6"/></svg>', data.current_page === 1, () => callback(data.current_page - 1));
            controls.appendChild(prevBtn);

            let start = Math.max(1, data.current_page - 2);
            let end = Math.min(data.last_page, start + 4);
            if (end - start < 4) start = Math.max(1, end - 4);

            for (let i = start; i <= end; i++) {
                const btn = createPageBtn(i, false, () => callback(i), i === data.current_page);
                controls.appendChild(btn);
            }

            const nextBtn = createPageBtn('<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 18l6-6-6-6"/></svg>', data.current_page === data.last_page, () => callback(data.current_page + 1));
            controls.appendChild(nextBtn);

            return controls;
        }

        // Load data on page init
        fetchCareData();
    })();
</script>