@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/components/settings/master_crud.css') }}">
@endpush

<div class="mc-header-row">
    <div style="display: flex; align-items: center; gap: 16px;">
        <a href="?menu=general-settings" class="mc-btn-icon" title="Kembali ke General Settings">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
        </a>
        <div>
            <h2 class="mc-title">Manajemen Jenis Perawatan</h2>
            <p class="mc-subtitle">Kelola data jenis perawatan dengan tarif di sistem hanglekiu</p>
        </div>
    </div>
    <button class="mc-btn-primary" onclick="openCareModal()">+ Tambah Jenis Perawatan</button>
</div>

<div class="mc-actions-row">
    <div class="mc-search-box">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#6B513E" stroke-width="2">
            <circle cx="11" cy="11" r="8"></circle>
            <path d="M21 21l-4.35-4.35"></path>
        </svg>
        <input type="text" id="search-care" placeholder="Cari jenis perawatan..." onkeyup="fetchCareData()">
    </div>
</div>

<div class="mc-table-card">
    <table class="mc-table">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Harga</th>
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

<!-- Modal Form -->
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
                    <label class="mc-label">Nama Jenis Perawatan <span style="color:red">*</span></label>
                    <input type="text" id="care-name" class="mc-input" placeholder="Masukkan nama jenis perawatan" required>
                </div>
                <div class="mc-form-group">
                    <label class="mc-label">Harga <span style="color:red">*</span></label>
                    <input type="number" id="care-price" class="mc-input" placeholder="0" step="0.01" min="0" required>
                </div>
                <div class="mc-form-group">
                    <label class="mc-label">Deskripsi</label>
                    <textarea id="care-description" class="mc-input" placeholder="Deskripsi jenis perawatan" style="resize:vertical; min-height:80px;"></textarea>
                </div>
                <div class="mc-form-group">
                    <label class="mc-label">Status</label>
                    <select id="care-active" class="mc-input">
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
    const CARE_API = '/api/master-care-type';
    let careCurrentPage = 1;

    window.fetchCareData = function(page = 1) {
        careCurrentPage = page;
        const search = document.getElementById('search-care').value;
        const url = `${CARE_API}?page=${page}&search=${search}`;

        fetch(url)
            .then(r => r.json())
            .then(data => renderCareTable(data.data))
            .catch(() => alert('Gagal memuat data'));
    };

    function formatCurrency(num) {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(num);
    }

    function renderCareTable(data) {
        const tbody = document.getElementById('care-table-body');
        tbody.innerHTML = '';

        if (!data.data || data.data.length === 0) {
            tbody.innerHTML = '<tr><td colspan="4" style="text-align:center;color:#9CA3AF">Data tidak ditemukan</td></tr>';
            return;
        }

        data.data.forEach(item => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td><strong>${item.name}</strong></td>
                <td style="color:#2563EB; font-weight:600">${formatCurrency(item.price || 0)}</td>
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

        renderPaginationCare(data);
    }

    function renderPaginationCare(data) {
        const pag = document.getElementById('care-pagination');
        pag.innerHTML = `<span>Menampilkan ${data.from || 0}–${data.to || 0} dari ${data.total} data</span>`;

        if (data.last_page <= 1) return;

        const controls = document.createElement('div');
        controls.className = 'mc-pagination-controls';

        if (data.current_page > 1) {
            const prev = document.createElement('button');
            prev.className = 'mc-page-btn';
            prev.innerHTML = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M15 18l-6-6 6-6"/></svg>';
            prev.onclick = () => fetchCareData(data.current_page - 1);
            controls.appendChild(prev);
        }

        for (let i = Math.max(1, data.current_page - 2); i <= Math.min(data.last_page, data.current_page + 2); i++) {
            const btn = document.createElement('button');
            btn.className = `mc-page-btn ${i === data.current_page ? 'active' : ''}`;
            btn.textContent = i;
            btn.onclick = () => fetchCareData(i);
            controls.appendChild(btn);
        }

        if (data.current_page < data.last_page) {
            const next = document.createElement('button');
            next.className = 'mc-page-btn';
            next.innerHTML = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 18l6-6-6-6"/></svg>';
            next.onclick = () => fetchCareData(data.current_page + 1);
            controls.appendChild(next);
        }

        pag.appendChild(controls);
    }

    window.openCareModal = function(id = null) {
        const modal = document.getElementById('care-modal');
        document.getElementById('care-form').reset();
        document.getElementById('care-id').value = '';
        document.getElementById('care-modal-title').textContent = id ? 'Edit Jenis Perawatan' : 'Tambah Jenis Perawatan';

        if (id) {
            fetch(`${CARE_API}/${id}`)
                .then(r => r.json())
                .then(res => {
                    document.getElementById('care-id').value = res.data.id;
                    document.getElementById('care-name').value = res.data.name;
                    document.getElementById('care-price').value = res.data.price || 0;
                    document.getElementById('care-description').value = res.data.description || '';
                    document.getElementById('care-active').value = res.data.is_active ? "1" : "0";
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
        const url = id ? `${CARE_API}/${id}` : CARE_API;

        const data = {
            name: document.getElementById('care-name').value,
            price: parseFloat(document.getElementById('care-price').value) || 0,
            description: document.getElementById('care-description').value,
            is_active: document.getElementById('care-active').value === "1"
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
            if (res.success) { closeCareModal(); fetchCareData(careCurrentPage); }
            else alert(res.message || 'Gagal menyimpan data');
        })
        .catch(err => {
            console.error('Save error:', err);
            alert('Gagal menyimpan: ' + err.message);
        });
    };

    window.deleteCareData = function(id) {
        if (confirm('Yakin ingin menghapus data ini?')) {
            fetch(`${CARE_API}/${id}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            })
            .then(r => r.json())
            .then(res => { if (res.success) fetchCareData(careCurrentPage); else alert('Gagal menghapus'); })
            .catch(() => alert('Terjadi kesalahan'));
        }
    };

    // Load data on page load
    fetchCareData();
</script>
