@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/components/settings/master_crud.css') }}">
@endpush

<div class="mc-header-row">
    <div style="display: flex; align-items: center; gap: 16px;">
        <a href="?menu=general-settings" class="mc-btn-icon" title="Kembali ke General Settings">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
        </a>
        <div>
            <h2 class="mc-title">Manajemen Tindakan</h2>
            <p class="mc-subtitle">Kelola data tindakan detail dan harga di sistem hanglekiu</p>
        </div>
    </div>
    <button class="mc-btn-primary" onclick="openProcedureModal()">+ Tambah Tindakan</button>
</div>

<div class="mc-actions-row">
    <div class="mc-search-box">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#6B513E" stroke-width="2">
            <circle cx="11" cy="11" r="8"></circle>
            <path d="M21 21l-4.35-4.35"></path>
        </svg>
        <input type="text" id="procedure-search" placeholder="Cari tindakan..." onkeyup="fetchProcedureData()">
    </div>
</div>

<div class="mc-table-card">
    <table class="mc-table">
        <thead>
            <tr>
                <th>Nama Tindakan</th>
                <th>Jenis Perawatan</th>
                <th>Harga</th>
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

<!-- Modal Procedure -->
<div id="procedure-modal" class="mc-modal-overlay">
    <div class="mc-modal-content">
        <div class="mc-modal-header">
            <h3 id="procedure-modal-title">Tambah Tindakan</h3>
            <button class="mc-modal-close" onclick="closeProcedureModal()">&times;</button>
        </div>
        <form id="procedure-form" onsubmit="saveProcedureData(event)">
            <input type="hidden" id="procedure-id">
            <div class="mc-modal-body">
                <div class="mc-form-group">
                    <label class="mc-label">Nama Tindakan</label>
                    <input type="text" id="procedure-input-name" class="mc-input" placeholder="Masukkan nama tindakan" required>
                </div>
                <div class="mc-form-group">
                    <label class="mc-label">Jenis Perawatan</label>
                    <select id="procedure-input-care-type" class="mc-input" required>
                        <option value="">-- Pilih Jenis Perawatan --</option>
                    </select>
                </div>
                <div class="mc-form-group">
                    <label class="mc-label">Harga (Rp)</label>
                    <input type="number" id="procedure-input-price" class="mc-input" placeholder="Masukkan harga" min="0" step="0.01" required>
                </div>
                <div class="mc-form-group">
                    <label class="mc-label">Deskripsi (Opsional)</label>
                    <textarea id="procedure-input-description" class="mc-input" placeholder="Masukkan deskripsi" rows="3"></textarea>
                </div>
                <div class="mc-form-group">
                    <label class="mc-label">Status Aktif</label>
                    <select id="procedure-input-active" class="mc-input">
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
    (function() {
        let currentPage = 1;
        const apiUrl = '/api/master-procedure-detail';
        let careTypesCache = [];

        // Load care types for dropdown
        function loadCareTypes() {
            fetch('/api/master-care-type?per_page=9999')
                .then(r => r.json())
                .then(data => {
                    careTypesCache = data.data.data || [];
                    const select = document.getElementById('procedure-input-care-type');
                    careTypesCache.forEach(care => {
                        const option = document.createElement('option');
                        option.value = care.id;
                        option.textContent = care.name;
                        select.appendChild(option);
                    });
                })
                .catch(e => console.error('Error loading care types:', e));
        }

        function getCareTypeName(careTypeId) {
            const care = careTypesCache.find(c => c.id === careTypeId);
            return care ? care.name : 'N/A';
        }

        window.fetchProcedureData = function(page = 1) {
            currentPage = page;
            const search = document.getElementById('procedure-search').value;
            const url = `${apiUrl}?page=${page}&search=${search}`;

            fetch(url)
                .then(r => r.json())
                .then(data => {
                    const tbody = document.getElementById('procedure-table-body');
                    tbody.innerHTML = '';

                    if (data.data.data.length === 0) {
                        tbody.innerHTML = '<tr><td colspan="5" style="text-align:center">Data tidak ditemukan</td></tr>';
                    } else {
                        data.data.data.forEach(item => {
                            const tr = document.createElement('tr');
                            const price = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(item.price);
                            const careTypeName = item.care_type?.name || 'N/A';
                            tr.innerHTML = `
                                <td>${item.name}</td>
                                <td>${careTypeName}</td>
                                <td>${price}</td>
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
                    }

                    const pagination = document.getElementById('procedure-pagination');
                    pagination.innerHTML = `<span>Menampilkan ${data.data.from || 0}–${data.data.to || 0} dari ${data.data.total} data</span>`;
                    if (data.data.last_page > 1) {
                        pagination.appendChild(renderProcedurePagination(data.data, fetchProcedureData));
                    }
                });
        };

        window.openProcedureModal = function(id = null) {
            const modal = document.getElementById('procedure-modal');
            const form = document.getElementById('procedure-form');
            form.reset();
            document.getElementById('procedure-id').value = '';
            document.getElementById('procedure-modal-title').innerText = id ? 'Edit Tindakan' : 'Tambah Tindakan';
            
            if (id) {
                fetch(`${apiUrl}/${id}`)
                    .then(r => r.json())
                    .then(res => {
                        const data = res.data;
                        document.getElementById('procedure-id').value = data.id;
                        document.getElementById('procedure-input-name').value = data.name;
                        document.getElementById('procedure-input-care-type').value = data.care_type_id || '';
                        document.getElementById('procedure-input-price').value = data.price;
                        document.getElementById('procedure-input-description').value = data.description || '';
                        document.getElementById('procedure-input-active').value = data.is_active ? "1" : "0";
                    });
            }
            modal.classList.add('show');
        };

        window.closeProcedureModal = function() {
            document.getElementById('procedure-modal').classList.remove('show');
        };

        window.saveProcedureData = function(e) {
            e.preventDefault();
            const id = document.getElementById('procedure-id').value;
            const method = id ? 'PUT' : 'POST';
            const url = id ? `${apiUrl}/${id}` : apiUrl;

            fetch(url, {
                method: method,
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({
                    name: document.getElementById('procedure-input-name').value,
                    care_type_id: document.getElementById('procedure-input-care-type').value,
                    price: parseFloat(document.getElementById('procedure-input-price').value),
                    description: document.getElementById('procedure-input-description').value,
                    is_active: document.getElementById('procedure-input-active').value === "1"
                })
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) { closeProcedureModal(); fetchProcedureData(currentPage); }
                else alert('Gagal menyimpan data: ' + (data.message || 'Unknown error'));
            })
            .catch(e => alert('Error: ' + e.message));
        };

        window.deleteProcedureData = function(id) {
            if (confirm('Yakin ingin menghapus data ini?')) {
                fetch(`${apiUrl}/${id}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                })
                .then(r => r.json())
                .then(data => { if (data.success) fetchProcedureData(currentPage); else alert('Gagal menghapus'); });
            }
        };

        function createPageBtn(html, disabled, onclick, active = false) {
            const btn = document.createElement('button');
            btn.className = `mc-page-btn ${active ? 'active' : ''}`;
            btn.disabled = disabled;
            btn.innerHTML = html;
            btn.onclick = onclick;
            return btn;
        }

        function renderProcedurePagination(data, callback) {
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

        // Load data and care types on page init
        loadCareTypes();
        fetchProcedureData();
    })();
</script>
