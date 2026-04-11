@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/components/settings/master_crud.css') }}">
@endpush

<div class="mc-header-row">
    <div style="display: flex; align-items: center; gap: 16px;">
        <a href="?menu=beranda-settings" class="mc-btn-icon" title="Kembali ke Beranda Settings">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
        </a>
        <div>
            <h2 class="mc-title">Partner Asuransi</h2>
            <p class="mc-subtitle">Kelola logo partner asuransi yang tampil di landing page</p>
        </div>
    </div>
    <button class="mc-btn-primary" onclick="openPartnerModal()">+ Tambah Partner</button>
</div>

<div class="mc-actions-row">
    <div class="mc-search-box">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#6B513E" stroke-width="2">
            <circle cx="11" cy="11" r="8"></circle>
            <path d="M21 21l-4.35-4.35"></path>
        </svg>
        <input type="text" id="search-partner" placeholder="Cari nama partner..." onkeyup="fetchPartnerData()">
    </div>
</div>

<div class="mc-table-card">
    <table class="mc-table">
        <thead>
            <tr>
                <th>Logo</th>
                <th>Nama Partner</th>
                <th>Urutan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody id="partner-table-body">
            <!-- Data loaded via AJAX -->
        </tbody>
    </table>
    <div class="mc-pagination" id="partner-pagination"></div>
</div>

{{-- ===== MODAL FORM ===== --}}
<div id="partner-modal" class="mc-modal-overlay">
    <div class="mc-modal-content">
        <div class="mc-modal-header">
            <h3 id="partner-modal-title">Tambah Partner</h3>
            <button class="mc-modal-close" onclick="closePartnerModal()">&times;</button>
        </div>
        <form id="partner-form" enctype="multipart/form-data" onsubmit="savePartnerData(event)">
            @csrf
            <input type="hidden" id="partner-id" name="id">
            
            <div class="mc-modal-body">
                <div class="mc-form-group">
                    <label class="mc-label">Nama Partner <span style="color:red">*</span></label>
                    <input type="text" id="partner-name" name="name" class="mc-input" placeholder="Contoh: Prudential" required>
                </div>

                <div class="mc-form-group">
                    <label class="mc-label">Logo Partner</label>
                    <div id="logo-preview-container" class="photo-preview-container" onclick="document.getElementById('partner-logo').click()">
                        <div id="logo-placeholder" class="photo-preview-placeholder">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                                <circle cx="8.5" cy="8.5" r="1.5"/>
                                <polyline points="21 15 16 10 5 21"/>
                            </svg>
                            <p>Klik untuk upload logo</p>
                        </div>
                        <img id="logo-preview-img" class="photo-preview-img" style="display:none; object-fit: contain;">
                    </div>
                    <input type="file" id="partner-logo" name="logo" class="mc-input-file" accept="image/*" onchange="previewLogo(this)">
                    <p style="font-size:11px;color:#9CA3AF;margin-top:4px;">Format: SVG, PNG, JPG (Max. 5MB). Rekomendasi background transparan.</p>
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                    <div class="mc-form-group">
                        <label class="mc-label">Urutan Tampil</label>
                        <input type="number" id="partner-order" name="order" class="mc-input" min="0" max="999" value="0">
                    </div>
                    <div class="mc-form-group">
                        <label class="mc-label">Status</label>
                        <select id="partner-active" name="is_active" class="mc-input">
                            <option value="1">Aktif</option>
                            <option value="0">Tidak Aktif</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="mc-modal-footer">
                <button type="button" class="mc-btn-secondary" onclick="closePartnerModal()">Batal</button>
                <button type="submit" class="mc-btn-primary">Simpan Partner</button>
            </div>
        </form>
    </div>
</div>

<script>
const PARTNER_API = '/api/insurance-partners';
let partnerCurrentPage = 1;
const STORAGE_URL = '{{ asset('storage') }}/';

function fetchPartnerData(page = 1) {
    partnerCurrentPage = page;
    const search = document.getElementById('search-partner').value;
    fetch(`${PARTNER_API}?page=${page}&search=${encodeURIComponent(search)}`)
        .then(r => r.json())
        .then(res => renderPartnerTable(res.data))
        .catch(() => console.error('Gagal memuat data'));
}

function renderPartnerTable(paginator) {
    const tbody = document.getElementById('partner-table-body');
    tbody.innerHTML = '';
    const items = paginator.data;

    if (!items || items.length === 0) {
        tbody.innerHTML = '<tr><td colspan="5" style="text-align:center;color:#9CA3AF;padding:40px;">Belum ada data partner</td></tr>';
        return;
    }

    items.forEach(item => {
        const logoSrc = item.logo ? (STORAGE_URL + item.logo) : '/images/gigi.svg';
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>
                <div class="photo-cell">
                    <img class="table-photo" style="object-fit: contain; background: #f9f9f9;" src="${logoSrc}" alt="${item.name}">
                </div>
            </td>
            <td><strong>${item.name}</strong></td>
            <td>${item.order}</td>
            <td>
                <span class="mc-badge ${item.is_active ? 'mc-badge-active' : 'mc-badge-inactive'}">
                    ${item.is_active ? 'Aktif' : 'Tidak Aktif'}
                </span>
            </td>
            <td>
                <div class="mc-action-btns">
                    <button class="mc-btn-icon" onclick="openPartnerModal('${item.id}')" title="Edit">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    </button>
                    <button class="mc-btn-icon delete" onclick="deletePartnerData('${item.id}')" title="Hapus">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                    </button>
                </div>
            </td>
        `;
        tbody.appendChild(tr);
    });

    renderPaginationPartner(paginator);
}

function renderPaginationPartner(data) {
    const pag = document.getElementById('partner-pagination');
    pag.innerHTML = `<span>Menampilkan ${data.from || 0}–${data.to || 0} dari ${data.total} data</span>`;
    if (data.last_page <= 1) return;
    
    const controls = document.createElement('div');
    controls.className = 'mc-pagination-controls';
    
    if (data.current_page > 1) {
        const prev = document.createElement('button');
        prev.className = 'mc-page-btn';
        prev.innerHTML = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M15 18l-6-6 6-6"/></svg>';
        prev.onclick = () => fetchPartnerData(data.current_page - 1);
        controls.appendChild(prev);
    }

    for (let i = Math.max(1, data.current_page - 2); i <= Math.min(data.last_page, data.current_page + 2); i++) {
        const btn = document.createElement('button');
        btn.className = `mc-page-btn ${i === data.current_page ? 'active' : ''}`;
        btn.textContent = i;
        btn.onclick = () => fetchPartnerData(i);
        controls.appendChild(btn);
    }

    if (data.current_page < data.last_page) {
        const next = document.createElement('button');
        next.className = 'mc-page-btn';
        next.innerHTML = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 18l6-6-6-6"/></svg>';
        next.onclick = () => fetchPartnerData(data.current_page + 1);
        controls.appendChild(next);
    }
    pag.appendChild(controls);
}

function openPartnerModal(id = null) {
    const modal = document.getElementById('partner-modal');
    document.getElementById('partner-form').reset();
    document.getElementById('partner-id').value = '';
    document.getElementById('logo-preview-img').style.display = 'none';
    document.getElementById('logo-placeholder').style.display = 'block';
    document.getElementById('partner-modal-title').textContent = id ? 'Edit Partner' : 'Tambah Partner';

    if (id) {
        fetch(`${PARTNER_API}/${id}`)
            .then(r => r.json())
            .then(res => {
                const d = res.data;
                document.getElementById('partner-id').value = d.id;
                document.getElementById('partner-name').value = d.name;
                document.getElementById('partner-order').value = d.order || 0;
                document.getElementById('partner-active').value = d.is_active ? '1' : '0';
                if (d.logo) {
                    const img = document.getElementById('logo-preview-img');
                    img.src = STORAGE_URL + d.logo;
                    img.style.display = 'block';
                    document.getElementById('logo-placeholder').style.display = 'none';
                }
            });
    }
    modal.classList.add('show');
}

function closePartnerModal() {
    document.getElementById('partner-modal').classList.remove('show');
}

function previewLogo(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.getElementById('logo-preview-img');
            img.src = e.target.result;
            img.style.display = 'block';
            document.getElementById('logo-placeholder').style.display = 'none';
        };
        reader.readAsDataURL(input.files[0]);
    }
}

async function savePartnerData(e) {
    e.preventDefault();
    const id = document.getElementById('partner-id').value;
    const url = id ? `${PARTNER_API}/${id}` : PARTNER_API;
    const formData = new FormData(e.target);
    
    // Workaround for PUT with FormData
    if (id) {
        formData.append('_method', 'PUT');
    }

    try {
        const response = await fetch(url, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });
        const res = await response.json();
        if (res.success) {
            closePartnerModal();
            fetchPartnerData(partnerCurrentPage);
        } else {
            alert(res.message || 'Gagal menyimpan data');
        }
    } catch (err) {
        console.error(err);
        alert('Terjadi kesalahan');
    }
}

function deletePartnerData(id) {
    if (confirm('Yakin ingin menghapus partner ini?')) {
        fetch(`${PARTNER_API}/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(r => r.json())
        .then(res => {
            if (res.success) fetchPartnerData(partnerCurrentPage);
            else alert('Gagal menghapus');
        });
    }
}

document.addEventListener('DOMContentLoaded', fetchPartnerData);
</script>

<style>
.photo-preview-container {
    border: 2.5px dashed #ECDCCA;
    border-radius: 12px;
    padding: 20px;
    text-align: center;
    cursor: pointer;
    background: #FDF9F5;
    transition: all 0.2s;
}
.photo-preview-container:hover {
    border-color: #C58F59;
    background: #FFF;
}
.photo-preview-placeholder svg { color: #B09A85; margin-bottom: 8px; }
.photo-preview-placeholder p { font-size: 13px; color: #7A4F28; margin: 0; }
.photo-preview-img { max-height: 120px; max-width: 100%; border-radius: 8px; }
.mc-input-file { display: none; }

.photo-cell {
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.table-photo {
    max-width: 100%;
    max-height: 100%;
    border-radius: 4px;
}
</style>
