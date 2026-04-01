@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/components/settings/master_crud.css') }}">
@endpush

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

    // Load care types for dropdown
    function loadCareTypes() {
        fetch(CARE_TYPE_API + '?per_page=999')
            .then(r => r.json())
            .then(data => {
                const select = document.getElementById('procedure-care-type');
                console.log('DEBUG - loaded care types:', data.data.data);
                select.innerHTML = '<option value="">-- Pilih Jenis Perawatan --</option>';
                data.data.data.forEach(care => {
                    console.log('DEBUG - adding care type option:', care.id, care.name);
                    const opt = document.createElement('option');
                    opt.value = care.id;
                    opt.textContent = care.name;
                    select.appendChild(opt);
                    careTypeMap[care.id] = care.name;
                });
                console.log('DEBUG - careTypeMap:', careTypeMap);
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
            .catch(() => alert('Gagal memuat data'));
    };

    function formatCurrency(num) {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(num);
    }

    function renderProcedureTable(data) {
        const tbody = document.getElementById('procedure-table-body');
        tbody.innerHTML = '';

        if (!data.data || data.data.length === 0) {
            tbody.innerHTML = '<tr><td colspan="5" style="text-align:center;color:#9CA3AF">Data tidak ditemukan</td></tr>';
            return;
        }

        data.data.forEach(item => {
            const tr = document.createElement('tr');
            const careName = careTypeMap[item.care_type_id] || '-';
            tr.innerHTML = `
                <td><strong>${item.name || item.procedure_name}</strong></td>
                <td style="color:#6B7280; font-size:13px">${careName}</td>
                <td style="color:#2563EB; font-weight:600">${formatCurrency(item.price || 0)}</td>
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
                    document.getElementById('procedure-price').value = res.data.price || 0;
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
        
        // Validate that care type is selected (required field)
        const careTypeSelect = document.getElementById('procedure-care-type');
        if (!careTypeSelect.value) {
            alert('Silakan pilih Jenis Perawatan terlebih dahulu');
            careTypeSelect.focus();
            return;
        }

        const id = document.getElementById('procedure-id').value;
        const method = id ? 'PUT' : 'POST';
        const url = id ? `${PROCEDURE_API}/${id}` : PROCEDURE_API;

        const careTypeValue = careTypeSelect.value;
        
        console.log('DEBUG - care_type select value:', careTypeValue);
        console.log('DEBUG - care_type select displayed text:', careTypeSelect.options[careTypeSelect.selectedIndex]?.text);

        const data = {
            name: document.getElementById('procedure-name').value,
            care_type_id: careTypeValue,
            price: parseFloat(document.getElementById('procedure-price').value) || 0,
            description: document.getElementById('procedure-description').value,
            is_active: document.getElementById('procedure-active').value === "1"
        };

        console.log('DEBUG - data being sent:', JSON.stringify(data, null, 2));

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
            console.log('DEBUG - response:', res);
            if (res.success) { 
                closeProcedureModal(); 
                fetchProcedureData(procedureCurrentPage); 
            }
            else alert(res.message || 'Gagal menyimpan data');
        })
        .catch(err => {
            console.error('Save error:', err);
            alert('Gagal menyimpan: ' + err.message);
        });
    };

    window.deleteProcedureData = function(id) {
        if (confirm('Yakin ingin menghapus data ini?')) {
            fetch(`${PROCEDURE_API}/${id}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            })
            .then(r => r.json())
            .then(res => { if (res.success) fetchProcedureData(procedureCurrentPage); else alert('Gagal menghapus'); })
            .catch(() => alert('Terjadi kesalahan'));
        }
    };

    // Initialize
    loadCareTypes();
    fetchProcedureData();
</script>

