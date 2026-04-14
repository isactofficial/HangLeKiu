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
            <h2 class="mc-title">{{ $title }}</h2>
            <p class="mc-subtitle">{{ $subtitle }}</p>
        </div>
    </div>
    <button class="mc-btn-primary" onclick="openMasterModal()">+ Tambah {{ $itemLabel }}</button>
</div>

@include('admin.components.settings.partials.inline_notice')

<div class="mc-actions-row">
    <div class="mc-search-box">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#6B513E" stroke-width="2">
            <circle cx="11" cy="11" r="8"></circle>
            <path d="M21 21l-4.35-4.35"></path>
        </svg>
        <input type="text" id="master-search" placeholder="{{ $searchPlaceholder }}" onkeyup="fetchMasterData()">
    </div>
</div>

<div class="mc-table-card">
    <table class="mc-table">
        <thead>
            <tr>
                <th>{{ $columnName ?? 'Nama' }}</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody id="master-table-body">
            <!-- Data loaded via AJAX -->
        </tbody>
    </table>
    <div class="mc-pagination" id="master-pagination"></div>
</div>

<!-- Modal Master -->
<div id="master-modal" class="mc-modal-overlay">
    <div class="mc-modal-content">
        <div class="mc-modal-header">
            <h3 id="master-modal-title">Tambah {{ $itemLabel }}</h3>
            <button class="mc-modal-close" onclick="closeMasterModal()">&times;</button>
        </div>
        <form id="master-form" onsubmit="saveMasterData(event)">
            <input type="hidden" id="master-id">
            <div class="mc-modal-body">
                <div class="mc-form-group">
                    <label class="mc-label">{{ $inputLabel }}</label>
                    <input type="text" id="master-input-name" class="mc-input" placeholder="{{ $inputPlaceholder }}" required>
                </div>
                <div class="mc-form-group">
                    <label class="mc-label">Status Aktif</label>
                    <select id="master-input-active" class="mc-input">
                        <option value="1">Aktif</option>
                        <option value="0">Tidak Aktif</option>
                    </select>
                </div>
            </div>
            <div class="mc-modal-footer">
                <button type="button" class="mc-btn-secondary" onclick="closeMasterModal()">Batal</button>
                <button type="submit" class="mc-btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
    (function() {
        let currentPage = 1;
        const apiUrl = '{{ $apiUrl }}';

        function showMasterToast(message, type = 'success') {
            window.showSettingsInlineNotice?.(message, type);
        }

        function showMasterConfirm(message) {
            return new Promise((resolve) => {
                const existing = document.getElementById('master-confirm-overlay');
                if (existing) existing.remove();

                const overlay = document.createElement('div');
                overlay.id = 'master-confirm-overlay';
                overlay.style.position = 'fixed';
                overlay.style.inset = '0';
                overlay.style.background = 'rgba(17,24,39,0.45)';
                overlay.style.display = 'flex';
                overlay.style.alignItems = 'center';
                overlay.style.justifyContent = 'center';
                overlay.style.zIndex = '10000';
                overlay.style.padding = '16px';
                overlay.style.boxSizing = 'border-box';

                const box = document.createElement('div');
                box.style.width = 'min(100%, 620px)';
                box.style.maxHeight = 'calc(100vh - 32px)';
                box.style.overflow = 'auto';
                box.style.background = '#FFFDFB';
                box.style.borderRadius = '18px';
                box.style.boxShadow = '0 26px 56px rgba(47, 29, 17, 0.28)';
                box.style.border = '1px solid #E9D8C8';
                box.style.padding = '28px 24px';
                box.style.boxSizing = 'border-box';
                box.style.textAlign = 'center';
                box.innerHTML = `
                    <div style="font-size:24px;font-weight:700;line-height:1.15;color:#2B1609;margin-bottom:14px;">Konfirmasi Hapus</div>
                    <div style="font-size:20px;color:#5E3A24;line-height:1.45;max-width:90%;margin:0 auto;">${message}</div>
                    <div style="display:flex;justify-content:center;gap:14px;margin-top:32px;">
                        <button type="button" data-action="cancel" style="border:1px solid #D3BCA7;background:#FFF8F2;color:#4A2D1A;padding:12px 20px;border-radius:12px;cursor:pointer;font-size:16px;font-weight:600;line-height:1.2;">Batal</button>
                        <button type="button" data-action="ok" style="border:none;background:#4A2B1B;color:#fff;padding:12px 20px;border-radius:12px;cursor:pointer;font-size:16px;font-weight:600;line-height:1.2;">Ya, Hapus</button>
                    </div>
                `;

                overlay.appendChild(box);
                document.body.appendChild(overlay);

                const cleanup = (value) => {
                    overlay.remove();
                    resolve(value);
                };

                box.querySelector('[data-action="cancel"]').addEventListener('click', () => cleanup(false));
                box.querySelector('[data-action="ok"]').addEventListener('click', () => cleanup(true));
                overlay.addEventListener('click', (e) => {
                    if (e.target === overlay) cleanup(false);
                });
            });
        }

        window.fetchMasterData = function(page = 1) {
            currentPage = page;
            const search = document.getElementById('master-search').value;
            const url = `${apiUrl}?page=${page}&search=${search}`;

            fetch(url)
                .then(r => r.json())
                .then(data => {
                    const tbody = document.getElementById('master-table-body');
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
                                        <button class="mc-btn-icon" onclick="openMasterModal('${item.id}')" title="Edit">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                        </button>
                                        <button class="mc-btn-icon delete" onclick="deleteMasterData('${item.id}')" title="Hapus">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                        </button>
                                    </div>
                                </td>
                            `;
                            tbody.appendChild(tr);
                        });
                    }

                    const pagination = document.getElementById('master-pagination');
                    pagination.innerHTML = `<span>Menampilkan ${data.data.from || 0}–${data.data.to || 0} dari ${data.data.total} data</span>`;
                    if (data.data.last_page > 1) {
                        pagination.appendChild(renderMasterPagination(data.data, fetchMasterData));
                    }
                });
        };

        window.openMasterModal = function(id = null) {
            const modal = document.getElementById('master-modal');
            const form = document.getElementById('master-form');
            form.reset();
            document.getElementById('master-id').value = '';
            document.getElementById('master-modal-title').innerText = id ? 'Edit {{ $itemLabel }}' : 'Tambah {{ $itemLabel }}';
            
            if (id) {
                fetch(`${apiUrl}/${id}`)
                    .then(r => r.json())
                    .then(res => {
                        const data = res.data;
                        document.getElementById('master-id').value = data.id;
                        document.getElementById('master-input-name').value = data.name;
                        document.getElementById('master-input-active').value = data.is_active ? "1" : "0";
                    });
            }
            modal.classList.add('show');
        };

        window.closeMasterModal = function() {
            document.getElementById('master-modal').classList.remove('show');
        };

        window.saveMasterData = function(e) {
            e.preventDefault();
            const id = document.getElementById('master-id').value;
            const method = id ? 'PUT' : 'POST';
            const url = id ? `${apiUrl}/${id}` : apiUrl;

            fetch(url, {
                method: method,
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({
                    name: document.getElementById('master-input-name').value,
                    is_active: document.getElementById('master-input-active').value === "1"
                })
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    closeMasterModal();
                    fetchMasterData(currentPage);
                    showMasterToast(id ? 'Data berhasil diperbarui' : 'Data berhasil ditambahkan');
                } else {
                    showMasterToast(data.message || 'Gagal menyimpan data', 'error');
                }
            });
        };

        window.deleteMasterData = async function(id) {
            const confirmed = await showMasterConfirm('Data yang dihapus tidak dapat dikembalikan. Lanjutkan?');
            if (!confirmed) return;

            fetch(`${apiUrl}/${id}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    fetchMasterData(currentPage);
                    showMasterToast('Data berhasil dihapus');
                } else {
                    showMasterToast(data.message || 'Gagal menghapus data', 'error');
                }
            })
            .catch(() => showMasterToast('Terjadi kesalahan saat menghapus data', 'error'));
        };

        function renderMasterPagination(data, callback) {
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

        function createPageBtn(html, disabled, onclick, active = false) {
            const btn = document.createElement('button');
            btn.className = `mc-page-btn ${active ? 'active' : ''}`;
            btn.disabled = disabled;
            btn.innerHTML = html;
            btn.onclick = onclick;
            return btn;
        }

        fetchMasterData();
    })();
</script>
