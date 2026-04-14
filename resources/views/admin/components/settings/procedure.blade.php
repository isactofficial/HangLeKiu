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
            <h2 class="mc-title">Manajemen Prosedur</h2>
            <p class="mc-subtitle">Kelola master prosedur treatment di sistem hanglekiu</p>
        </div>
    </div>
    <button class="mc-btn-primary" onclick="openProcedureModal()">+ Tambah Prosedur</button>
</div>

@include('admin.components.settings.partials.inline_notice')

<div class="mc-actions-row">
    <div class="mc-search-box">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#6B513E" stroke-width="2">
            <circle cx="11" cy="11" r="8"></circle>
            <path d="M21 21l-4.35-4.35"></path>
        </svg>
        <input type="text" id="search-procedure" placeholder="Cari nama prosedur..." onkeyup="fetchProcedureData()">
    </div>
</div>

<div class="mc-table-card">
    <table class="mc-table">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Jenis Perawatan</th>
                <th>Harga</th>
                <th>Deskripsi</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody id="procedure-table-body">
            <!-- Data loaded via AJAX -->
        </tbody>
    </table>
    <div class="mc-pagination" id="procedure-pagination"></div>
</div>

<!-- Modal Form -->
<div id="procedure-modal" class="mc-modal-overlay">
    <div class="mc-modal-content">
        <div class="mc-modal-header">
            <h3 id="procedure-modal-title">Tambah Prosedur</h3>
            <button class="mc-modal-close" onclick="closeProcedureModal()">&times;</button>
        </div>
        <form id="procedure-form" onsubmit="saveProcedureData(event)">
            <input type="hidden" id="procedure-id">
            <div class="mc-modal-body">
                <div class="mc-form-group">
                    <label class="mc-label">Nama Prosedur <span style="color:red">*</span></label>
                    <input type="text" id="procedure-name" class="mc-input" placeholder="Masukkan nama prosedur" required>
                </div>
                <div class="mc-form-group">
                    <label class="mc-label">Jenis Perawatan <span style="color:red">*</span></label>
                    <select id="procedure-care-type" class="mc-input" required>
                        <option value="">-- Pilih Jenis Perawatan --</option>
                    </select>
                </div>
                <div class="mc-form-group">
                    <label class="mc-label">Harga</label>
                    <input type="number" id="procedure-price" class="mc-input" placeholder="0" step="0.01" min="0">
                </div>
                <div class="mc-form-group">
                    <label class="mc-label">Deskripsi</label>
                    <textarea id="procedure-description" class="mc-input" placeholder="Deskripsi prosedur" style="resize:vertical; min-height:80px;"></textarea>
                </div>
                <div class="mc-form-group">
                    <label class="mc-label">Status</label>
                    <select id="procedure-active" class="mc-input">
                        <option value="1">Aktif</option>
                        <option value="0">Tidak Aktif</option>
                    </select>
                </div>
            </div>
            <div class="mc-modal-footer">
                <button type="button" class="mc-btn-secondary" onclick="closeProcedureModal()">Batal</button>
                <button type="submit" class="mc-btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
    const PROCEDURE_API = '/api/master-procedure';
    const CARE_TYPE_API = '/api/master-care-type';
    let procedureCurrentPage = 1;
    let careTypeMap = {};

    function showProcedureToast(message, type = 'success') {
        window.showSettingsInlineNotice?.(message, type);
    }

    function showProcedureConfirm(message) {
        return new Promise((resolve) => {
            const old = document.getElementById('procedure-confirm-overlay');
            if (old) old.remove();

            const overlay = document.createElement('div');
            overlay.id = 'procedure-confirm-overlay';
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

    // Load care types for dropdown
    function loadCareTypes() {
        fetch(CARE_TYPE_API + '?per_page=999')
            .then(r => r.json())
            .then(data => {
                const select = document.getElementById('procedure-care-type');
                select.innerHTML = '<option value="">-- Pilih Jenis Perawatan --</option>';
                const careRows = data?.data?.data || data?.data || [];
                careRows.forEach(care => {
                    const opt = document.createElement('option');
                    opt.value = care.id;
                    opt.textContent = care.name;
                    select.appendChild(opt);
                    careTypeMap[care.id] = care.name;
                });
            })
            .catch(err => {
                console.error('ERROR loading care types:', err);
            });
    }

    window.fetchProcedureData = function(page = 1) {
        procedureCurrentPage = page;
        const search = document.getElementById('search-procedure').value;
        const url = `${PROCEDURE_API}?page=${page}&search=${search}`;

        fetch(url)
            .then(r => r.json())
            .then(data => renderProcedureTable(data.data))
            .catch(() => showProcedureToast('Gagal memuat data', 'error'));
    };

    function formatCurrency(num) {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(num);
    }

    function renderProcedureTable(data) {
        const tbody = document.getElementById('procedure-table-body');
        tbody.innerHTML = '';

        if (!data.data || data.data.length === 0) {
            tbody.innerHTML = '<tr><td colspan="6" style="text-align:center;color:#B08968">Data tidak ditemukan</td></tr>';
            return;
        }

        data.data.forEach(item => {
            const tr = document.createElement('tr');
            const name = item.name || item.procedure_name || '-';
            const careName = item?.care_type?.name || careTypeMap[item.care_type_id] || '-';
            const rawPrice = item.price ?? item.base_price ?? 0;
            const description = (item.description || '-').toString();
            tr.innerHTML = `
                <td><strong>${name}</strong></td>
                <td style="color:#B08968; font-size:13px">${careName}</td>
                <td style="color:#2563EB; font-weight:600">${formatCurrency(rawPrice)}</td>
                <td style="color:#B08968; font-size:13px; max-width:260px; white-space:normal; word-break:break-word;">${description}</td>
                <td>
                    <span class="mc-badge ${item.is_active ? 'mc-badge-active' : 'mc-badge-inactive'}">
                        ${item.is_active ? 'Aktif' : 'Tidak Aktif'}
                    </span>
                </td>
                <td>
                    <div class="mc-action-btns">
                        <button class="mc-btn-icon" onclick="openProcedureModal('${item.id}')" title="Edit">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        </button>
                        <button class="mc-btn-icon delete" onclick="deleteProcedureData('${item.id}')" title="Hapus">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                        </button>
                    </div>
                </td>
            `;
            tbody.appendChild(tr);
        });

        renderPaginationProcedure(data);
    }

    function renderPaginationProcedure(data) {
        const pag = document.getElementById('procedure-pagination');
        pag.innerHTML = `<span>Menampilkan ${data.from || 0}–${data.to || 0} dari ${data.total} data</span>`;

        if (data.last_page <= 1) return;

        const controls = document.createElement('div');
        controls.className = 'mc-pagination-controls';

        if (data.current_page > 1) {
            const prev = document.createElement('button');
            prev.className = 'mc-page-btn';
            prev.innerHTML = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M15 18l-6-6 6-6"/></svg>';
            prev.onclick = () => fetchProcedureData(data.current_page - 1);
            controls.appendChild(prev);
        }

        for (let i = Math.max(1, data.current_page - 2); i <= Math.min(data.last_page, data.current_page + 2); i++) {
            const btn = document.createElement('button');
            btn.className = `mc-page-btn ${i === data.current_page ? 'active' : ''}`;
            btn.textContent = i;
            btn.onclick = () => fetchProcedureData(i);
            controls.appendChild(btn);
        }

        if (data.current_page < data.last_page) {
            const next = document.createElement('button');
            next.className = 'mc-page-btn';
            next.innerHTML = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 18l6-6-6-6"/></svg>';
            next.onclick = () => fetchProcedureData(data.current_page + 1);
            controls.appendChild(next);
        }

        pag.appendChild(controls);
    }

    window.openProcedureModal = function(id = null) {
        const modal = document.getElementById('procedure-modal');
        document.getElementById('procedure-form').reset();
        document.getElementById('procedure-id').value = '';
        document.getElementById('procedure-modal-title').textContent = id ? 'Edit Prosedur' : 'Tambah Prosedur';

        if (id) {
            fetch(`${PROCEDURE_API}/${id}`)
                .then(r => r.json())
                .then(res => {
                    document.getElementById('procedure-id').value = res.data.id;
                    document.getElementById('procedure-name').value = res.data.name || res.data.procedure_name;
                    document.getElementById('procedure-care-type').value = res.data.care_type_id || '';
                    document.getElementById('procedure-price').value = res.data.price ?? res.data.base_price ?? 0;
                    document.getElementById('procedure-description').value = res.data.description || '';
                    document.getElementById('procedure-active').value = res.data.is_active ? "1" : "0";
                });
        }
        modal.classList.add('show');
    };

    window.closeProcedureModal = function() {
        document.getElementById('procedure-modal').classList.remove('show');
    };

    window.saveProcedureData = function(e) {
        e.preventDefault();

        const careTypeSelect = document.getElementById('procedure-care-type');
        if (!careTypeSelect.value) {
            showProcedureToast('Silakan pilih Jenis Perawatan terlebih dahulu', 'error');
            careTypeSelect.focus();
            return;
        }

        const id = document.getElementById('procedure-id').value;
        const method = id ? 'PUT' : 'POST';
        const url = id ? `${PROCEDURE_API}/${id}` : PROCEDURE_API;

        const data = {
            name: document.getElementById('procedure-name').value,
            procedure_name: document.getElementById('procedure-name').value,
            care_type_id: careTypeSelect.value,
            price: parseFloat(document.getElementById('procedure-price').value) || 0,
            base_price: parseFloat(document.getElementById('procedure-price').value) || 0,
            description: document.getElementById('procedure-description').value,
            is_active: document.getElementById('procedure-active').value === "1"
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
                    try {
                        const errorData = JSON.parse(text);
                        const errorMessage = errorData.message || Object.values(errorData.errors || {})?.flat()?.join(', ') || text.substring(0, 200);
                        throw new Error(errorMessage);
                    } catch (e) {
                        throw new Error(`HTTP ${r.status}: ${text.substring(0, 200)}`);
                    }
                });
            }
            return r.json();
        })
        .then(res => {
            if (res.success) {
                closeProcedureModal();
                fetchProcedureData(procedureCurrentPage);
                showProcedureToast(id ? 'Data berhasil diperbarui' : 'Data berhasil ditambahkan');
            } else {
                showProcedureToast(res.message || 'Gagal menyimpan data', 'error');
            }
        })
        .catch(err => {
            console.error('Save error:', err);
            showProcedureToast('Gagal menyimpan: ' + err.message, 'error');
        });
    };

    window.deleteProcedureData = async function(id) {
        const confirmed = await showProcedureConfirm('Data yang dihapus tidak dapat dikembalikan. Lanjutkan?');
        if (!confirmed) return;

        fetch(`${PROCEDURE_API}/${id}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
        })
        .then(r => r.json())
        .then(res => {
            if (res.success) {
                fetchProcedureData(procedureCurrentPage);
                showProcedureToast('Data berhasil dihapus');
            } else {
                showProcedureToast(res.message || 'Gagal menghapus data', 'error');
            }
        })
        .catch(() => showProcedureToast('Terjadi kesalahan saat menghapus data', 'error'));
    };

    // Initialize
    loadCareTypes();
    fetchProcedureData();
</script>