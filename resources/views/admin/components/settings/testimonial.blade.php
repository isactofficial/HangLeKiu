@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/components/settings/master_crud.css') }}">
@endpush

<div class="mc-header-row">
    <div style="display: flex; align-items: center; gap: 16px;">
        <a href="?menu=beranda-settings" class="mc-btn-icon" title="Kembali ke Beranda Settings">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
        </a>
        <div>
            <h2 class="mc-title">Manajemen Testimonial</h2>
            <p class="mc-subtitle">Kelola testimonial apresiasi pasien untuk homepage</p>
        </div>
    </div>
    <button class="mc-btn-primary" onclick="openTestimonialModal()">+ Tambah Testimonial</button>
</div>

<div class="mc-actions-row">
    <div class="mc-search-box">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#6B513E" stroke-width="2">
            <circle cx="11" cy="11" r="8"></circle>
            <path d="M21 21l-4.35-4.35"></path>
        </svg>
        <input type="text" id="search-testimonial" placeholder="Cari nama atau profesi..." onkeyup="fetchTestimonialData()">
    </div>
</div>

<div class="mc-table-card">
    <table class="mc-table">
        <thead>
            <tr>
                <th>Foto</th>
                <th>Nama</th>
                <th>Profesi</th>
                <th>Urutan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody id="testimonial-table-body">
            <!-- Data loaded via AJAX -->
        </tbody>
    </table>
    <div class="mc-pagination" id="testimonial-pagination"></div>
</div>

{{-- ===== MODAL FORM ===== --}}
<div id="testimonial-modal" class="mc-modal-overlay">
    <div class="mc-modal-content" style="display:flex;flex-direction:column;max-height:90vh;width:100%;max-width:540px;">
        <div class="mc-modal-header" style="flex-shrink:0;">
            <h3 id="testimonial-modal-title">Tambah Testimonial</h3>
            <button class="mc-modal-close" onclick="closeTestimonialModal()">&times;</button>
        </div>
        <form id="testimonial-form" enctype="multipart/form-data" onsubmit="saveTestimonialData(event)"
              style="display:flex;flex-direction:column;flex:1;overflow:hidden;">
            @csrf
            <input type="hidden" id="testimonial-id" name="id">
            <input type="hidden" id="testimonial-cropped-photo" name="cropped_photo">

            <div class="mc-modal-body" style="overflow-y:auto;flex:1;padding:20px;display:flex;flex-direction:column;gap:14px;">

                {{-- CROP SECTION --}}
                <div>
                    <label class="mc-label" style="display:block;margin-bottom:8px;">
                        Foto Profil <span style="color:red">*</span>
                        <span style="font-weight:400;color:#9CA3AF;font-size:12px;">— drag untuk atur posisi, scroll untuk zoom</span>
                    </label>
                    <div style="display:flex;gap:14px;align-items:flex-start;">
                        {{-- Canvas crop --}}
                        <div id="crop-box" style="position:relative;width:200px;height:200px;flex-shrink:0;
                             border-radius:8px;overflow:hidden;border:1px solid #E5E7EB;
                             background:#F9FAFB;cursor:crosshair;user-select:none;">
                            <canvas id="crop-canvas" width="200" height="200" style="display:block;width:200px;height:200px;"></canvas>
                            <svg style="position:absolute;top:0;left:0;width:200px;height:200px;pointer-events:none;"
                                 viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                                <defs>
                                    <mask id="tpl-circle-mask">
                                        <rect width="200" height="200" fill="white"/>
                                        <circle cx="100" cy="100" r="88" fill="black"/>
                                    </mask>
                                </defs>
                                <rect width="200" height="200" fill="rgba(0,0,0,0.42)" mask="url(#tpl-circle-mask)"/>
                                <circle cx="100" cy="100" r="88" fill="none" stroke="rgba(255,255,255,0.7)"
                                        stroke-width="1.5" stroke-dasharray="5 3"/>
                            </svg>
                        </div>
                        {{-- Preview + upload --}}
                        <div style="display:flex;flex-direction:column;gap:10px;flex:1;">
                            <div style="font-size:12px;color:#6B7280;">Preview foto profil</div>
                            <div style="width:80px;height:80px;border-radius:50%;overflow:hidden;
                                        border:2px solid #E5E7EB;flex-shrink:0;">
                                <canvas id="crop-preview" width="80" height="80" style="display:block;width:80px;height:80px;"></canvas>
                            </div>
                            <label for="testimonial-photo" style="display:flex;align-items:center;gap:6px;
                                   padding:7px 12px;border-radius:8px;border:1px dashed #D1D5DB;
                                   background:#F9FAFB;font-size:12px;color:#6B7280;cursor:pointer;
                                   justify-content:center;">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/>
                                    <polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/>
                                </svg>
                                Upload foto
                            </label>
                            <input type="file" id="testimonial-photo" accept="image/*" style="display:none;">
                            <div style="font-size:11px;color:#9CA3AF;line-height:1.6;">
                                • Drag gambar untuk memilih area<br>
                                • Scroll / pinch untuk zoom<br>
                                • Foto akan dipotong bulat
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mc-form-group">
                    <label class="mc-label">Nama <span style="color:red">*</span></label>
                    <input type="text" id="testimonial-name" name="name" class="mc-input" required>
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                    <div class="mc-form-group">
                        <label class="mc-label">Profesi</label>
                        <input type="text" id="testimonial-profession" name="profession" class="mc-input">
                    </div>
                    <div class="mc-form-group">
                        <label class="mc-label">Urutan tampil <span style="font-weight:400;font-size:11px;color:#9CA3AF;">(0 = terakhir)</span></label>
                        <input type="number" id="testimonial-order" name="order" class="mc-input" min="0" max="999" value="0">
                    </div>
                </div>

                <div class="mc-form-group">
                    <label class="mc-label">Komentar <span style="color:red">*</span></label>
                    <textarea id="testimonial-comment" name="comment" class="mc-input"
                              rows="4" style="resize:vertical;min-height:90px;" required></textarea>
                </div>

                <div class="mc-form-group">
                    <label class="mc-label">Status</label>
                    <select id="testimonial-active" name="is_active" class="mc-input">
                        <option value="1">Aktif — tampil di homepage</option>
                        <option value="0">Tidak aktif</option>
                    </select>
                </div>
            </div>

            <div class="mc-modal-footer" style="flex-shrink:0;">
                <button type="button" class="mc-btn-secondary" onclick="closeTestimonialModal()">Batal</button>
                <button type="submit" class="mc-btn-primary">Simpan Testimonial</button>
            </div>
        </form>
    </div>
</div>

<script>
const TESTIMONIAL_API = '/api/master-testimonial';
let testimonialCurrentPage = 1;
const STORAGE_URL = '{{ asset('storage') }}/';
const FALLBACK_IMG = '/images/profile.svg';

// ========== CROP ENGINE ==========
let cropImg = null, cropScale = 1, cropOffsetX = 0, cropOffsetY = 0, cropDragging = false, cropLastX = 0, cropLastY = 0;
const CROP_W = 200, CROP_H = 200;

function initCropCanvas() {
    const box = document.getElementById('crop-box');
    const canvas = document.getElementById('crop-canvas');
    const ctx = canvas.getContext('2d');
    const pCanvas = document.getElementById('crop-preview');
    const pCtx = pCanvas.getContext('2d');

    function draw() {
        ctx.clearRect(0, 0, CROP_W, CROP_H);
        if (!cropImg) {
            ctx.fillStyle = '#F9FAFB';
            ctx.fillRect(0, 0, CROP_W, CROP_H);
            ctx.strokeStyle = '#D1D5DB';
            ctx.lineWidth = 1.5;
            ctx.beginPath(); ctx.arc(100, 85, 30, 0, Math.PI * 2); ctx.stroke();
            ctx.beginPath(); ctx.arc(100, 140, 50, Math.PI, 0); ctx.stroke();
            pCtx.clearRect(0, 0, 80, 80);
            pCtx.fillStyle = '#F3F4F6';
            pCtx.fillRect(0, 0, 80, 80);
            return;
        }
        ctx.save();
        ctx.translate(cropOffsetX, cropOffsetY);
        ctx.scale(cropScale, cropScale);
        ctx.drawImage(cropImg, 0, 0);
        ctx.restore();

        // Preview
        pCtx.clearRect(0, 0, 80, 80);
        pCtx.save();
        pCtx.beginPath(); pCtx.arc(40, 40, 40, 0, Math.PI * 2); pCtx.clip();
        const r = 80 / CROP_W;
        pCtx.translate(cropOffsetX * r, cropOffsetY * r);
        pCtx.scale(cropScale * r * (CROP_W / cropImg.width), cropScale * r * (CROP_H / cropImg.height));
        pCtx.drawImage(cropImg, 0, 0, cropImg.width, cropImg.height);
        pCtx.restore();

        // Update hidden field dengan data cropped
        const out = document.createElement('canvas');
        out.width = 200; out.height = 200;
        const outCtx = out.getContext('2d');
        outCtx.save();
        outCtx.beginPath(); outCtx.arc(100, 100, 100, 0, Math.PI * 2); outCtx.clip();
        outCtx.translate(cropOffsetX, cropOffsetY);
        outCtx.scale(cropScale, cropScale);
        outCtx.drawImage(cropImg, 0, 0);
        outCtx.restore();
        document.getElementById('testimonial-cropped-photo').value = out.toDataURL('image/jpeg', 0.85);
    }

    function clamp() {
        if (!cropImg) return;
        if (cropImg.width * cropScale >= CROP_W) {
            cropOffsetX = Math.min(0, Math.max(CROP_W - cropImg.width * cropScale, cropOffsetX));
        }
        if (cropImg.height * cropScale >= CROP_H) {
            cropOffsetY = Math.min(0, Math.max(CROP_H - cropImg.height * cropScale, cropOffsetY));
        }
    }

    function fitImg() {
        if (!cropImg) return;
        const s = Math.max(CROP_W / cropImg.width, CROP_H / cropImg.height);
        cropScale = s;
        cropOffsetX = (CROP_W - cropImg.width * s) / 2;
        cropOffsetY = (CROP_H - cropImg.height * s) / 2;
        draw();
    }

    if (box) box.addEventListener('mousedown', e => { cropDragging = true; cropLastX = e.offsetX; cropLastY = e.offsetY; box.style.cursor = 'grabbing'; });
    if (box) box.addEventListener('mousemove', e => {
        if (!cropDragging || !cropImg) return;
        cropOffsetX += e.offsetX - cropLastX;
        cropOffsetY += e.offsetY - cropLastY;
        cropLastX = e.offsetX; cropLastY = e.offsetY;
        clamp(); draw();
    });
    if (box) box.addEventListener('mouseup', () => { cropDragging = false; box.style.cursor = 'crosshair'; });
    if (box) box.addEventListener('mouseleave', () => { cropDragging = false; box.style.cursor = 'crosshair'; });

    if (box) box.addEventListener('wheel', e => {
        e.preventDefault();
        if (!cropImg) return;
        const delta = e.deltaY > 0 ? 0.9 : 1.1;
        const newScale = Math.max(0.2, Math.min(8, cropScale * delta));
        cropOffsetX = e.offsetX - (e.offsetX - cropOffsetX) * (newScale / cropScale);
        cropOffsetY = e.offsetY - (e.offsetY - cropOffsetY) * (newScale / cropScale);
        cropScale = newScale;
        clamp(); draw();
    }, { passive: false });

    let touch1 = null;
    if (box) box.addEventListener('touchstart', e => {
        if (e.touches.length === 1) { cropDragging = true; cropLastX = e.touches[0].clientX; cropLastY = e.touches[0].clientY; }
        if (e.touches.length === 2) { touch1 = Math.hypot(e.touches[0].clientX - e.touches[1].clientX, e.touches[0].clientY - e.touches[1].clientY); }
    }, { passive: true });
    box.addEventListener('touchmove', e => {
        if (!cropImg) return;
        if (e.touches.length === 1 && cropDragging) {
            cropOffsetX += e.touches[0].clientX - cropLastX;
            cropOffsetY += e.touches[0].clientY - cropLastY;
            cropLastX = e.touches[0].clientX; cropLastY = e.touches[0].clientY;
            clamp(); draw();
        }
        if (e.touches.length === 2 && touch1) {
            const d = Math.hypot(e.touches[0].clientX - e.touches[1].clientX, e.touches[0].clientY - e.touches[1].clientY);
            const newScale = Math.max(0.2, Math.min(8, cropScale * (d / touch1)));
            cropScale = newScale; touch1 = d;
            clamp(); draw();
        }
    }, { passive: true });
    box.addEventListener('touchend', () => { cropDragging = false; touch1 = null; });

    document.getElementById('testimonial-photo').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = ev => {
            const i = new Image();
            i.onload = () => { cropImg = i; fitImg(); };
            i.src = ev.target.result;
        };
        reader.readAsDataURL(file);
    });

    window._cropDraw = draw;
    window._cropFitImg = fitImg;
    window._cropReset = () => {
        cropImg = null; cropScale = 1; cropOffsetX = 0; cropOffsetY = 0;
        document.getElementById('testimonial-photo').value = '';
        document.getElementById('testimonial-cropped-photo').value = '';
        draw();
    };
    window._cropLoadUrl = (url) => {
        const i = new Image();
        i.crossOrigin = 'anonymous';
        i.onload = () => { cropImg = i; fitImg(); };
        i.onerror = () => { cropImg = null; draw(); };
        i.src = url;
    };

    draw();
}

// ========== TABLE ==========
window.fetchTestimonialData = function(page = 1) {
    testimonialCurrentPage = page;
    const search = document.getElementById('search-testimonial').value;
    fetch(`${TESTIMONIAL_API}?page=${page}&search=${encodeURIComponent(search)}`)
        .then(r => r.json())
        .then(res => renderTestimonialTable(res.data))
        .catch(() => alert('Gagal memuat data'));
};

function renderTestimonialTable(paginator) {
    const tbody = document.getElementById('testimonial-table-body');
    tbody.innerHTML = '';
    const items = paginator.data;

    if (!items || items.length === 0) {
        tbody.innerHTML = '<tr><td colspan="6" style="text-align:center;color:#9CA3AF;padding:40px;">Belum ada testimonial</td></tr>';
        renderPaginationTestimonial(paginator);
        return;
    }

    items.forEach(item => {
        const tr = document.createElement('tr');
        // ✅ FIX: Semua cell termasuk foto dirender sekaligus lewat innerHTML
        // Sebelumnya foto di-append dulu pakai appendChild, lalu tr.innerHTML += '...'
        // yang menyebabkan seluruh DOM di-rebuild dan foto node hilang.
        const photoSrc = item.photo ? (STORAGE_URL + item.photo) : '/images/profile.svg';

        tr.innerHTML = `
            <td>
                <div class="photo-cell">
                    <img class="table-photo"
                         alt="${item.name}"
                         src="${photoSrc}"
                         onerror="this.onerror=null;this.src='/images/profile.svg';">
                </div>
            </td>
            <td><strong>${item.name}</strong></td>
            <td style="color:#6B7280;font-size:13px">${item.profession || '-'}</td>
            <td style="color:#2563EB;font-weight:500">#${item.order || 0}</td>
            <td>
                <span class="mc-badge ${item.is_active ? 'mc-badge-active' : 'mc-badge-inactive'}">
                    ${item.is_active ? 'Aktif' : 'Tidak Aktif'}
                </span>
            </td>
            <td>
                <div class="mc-action-btns">
                    <button class="mc-btn-icon" onclick="openTestimonialModal('${item.id}')" title="Edit">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    </button>
                    <button class="mc-btn-icon delete" onclick="deleteTestimonialData('${item.id}')" title="Hapus">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                    </button>
                </div>
            </td>
        `;
        tbody.appendChild(tr);
    });

    renderPaginationTestimonial(paginator);
}

function renderPaginationTestimonial(data) {
    const pag = document.getElementById('testimonial-pagination');
    pag.innerHTML = `<span>Menampilkan ${data.from || 0}–${data.to || 0} dari ${data.total} data</span>`;
    if (data.last_page <= 1) return;
    const controls = document.createElement('div');
    controls.className = 'mc-pagination-controls';
    if (data.current_page > 1) {
        const prev = document.createElement('button');
        prev.className = 'mc-page-btn';
        prev.innerHTML = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M15 18l-6-6 6-6"/></svg>';
        prev.onclick = () => fetchTestimonialData(data.current_page - 1);
        controls.appendChild(prev);
    }
    for (let i = Math.max(1, data.current_page - 2); i <= Math.min(data.last_page, data.current_page + 2); i++) {
        const btn = document.createElement('button');
        btn.className = `mc-page-btn ${i === data.current_page ? 'active' : ''}`;
        btn.textContent = i;
        btn.onclick = () => fetchTestimonialData(i);
        controls.appendChild(btn);
    }
    if (data.current_page < data.last_page) {
        const next = document.createElement('button');
        next.className = 'mc-page-btn';
        next.innerHTML = '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 18l6-6-6-6"/></svg>';
        next.onclick = () => fetchTestimonialData(data.current_page + 1);
        controls.appendChild(next);
    }
    pag.appendChild(controls);
}

// ========== MODAL ==========
window.openTestimonialModal = function(id = null) {
    const modal = document.getElementById('testimonial-modal');
    document.getElementById('testimonial-form').reset();
    document.getElementById('testimonial-id').value = '';
    document.getElementById('testimonial-modal-title').textContent = id ? 'Edit Testimonial' : 'Tambah Testimonial';
    window._cropReset && window._cropReset();

    if (id) {
        fetch(`${TESTIMONIAL_API}/${id}`)
            .then(r => r.json())
            .then(res => {
                const d = res.data;
                document.getElementById('testimonial-id').value = d.id;
                document.getElementById('testimonial-name').value = d.name;
                document.getElementById('testimonial-profession').value = d.profession || '';
                document.getElementById('testimonial-comment').value = d.comment;
                document.getElementById('testimonial-order').value = d.order || 0;
                document.getElementById('testimonial-active').value = d.is_active ? '1' : '0';
                if (d.photo && window._cropLoadUrl) {
                    window._cropLoadUrl(STORAGE_URL + d.photo);
                }
            });
    }
    modal.classList.add('show');
};

window.closeTestimonialModal = function() {
    document.getElementById('testimonial-modal').classList.remove('show');
};

window.saveTestimonialData = async function(e) {
    e.preventDefault();
    const id = document.getElementById('testimonial-id').value;
    const url = id ? `${TESTIMONIAL_API}/${id}` : TESTIMONIAL_API;
    const formData = new FormData(e.target);
    if (id) formData.append('_method', 'PUT');

    try {
        const response = await fetch(url, {
            method: 'POST',
            body: formData,
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
        });
        const res = await response.json();
        if (res.success) { closeTestimonialModal(); fetchTestimonialData(testimonialCurrentPage); }
        else alert(res.message || 'Gagal menyimpan');
    } catch (err) {
        console.error(err);
        alert('Terjadi kesalahan saat menyimpan');
    }
};

window.deleteTestimonialData = function(id) {
    if (confirm('Yakin ingin menghapus testimonial ini?')) {
        fetch(`${TESTIMONIAL_API}/${id}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
        })
        .then(r => r.json())
        .then(res => {
            if (res.success) fetchTestimonialData(testimonialCurrentPage);
            else alert('Gagal menghapus');
        })
        .catch(() => alert('Terjadi kesalahan'));
    }
};

document.addEventListener('DOMContentLoaded', function() {
    initCropCanvas();
    fetchTestimonialData();
});
</script>

<style>
.table-photo { width:48px;height:48px;object-fit:cover;border-radius:8px;border:1px solid #F3F4F6;display:block; }
.photo-cell { width:60px; }
</style>

<style>
    .photo-preview-container {
        border: 2px dashed #D1D5DB;
        border-radius: 12px;
        padding: 24px;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s;
        margin-bottom: 8px;
    }
    .photo-preview-container:hover {
        border-color: #C58F59;
        background: #FEF3E8;
    }
    .photo-preview-container.has-photo {
        border-style: solid;
        border-color: #10B981;
    }
    .photo-preview-placeholder svg { color: #9CA3AF; margin-bottom: 8px; }
    .photo-preview-placeholder p { color: #6B7280; font-size: 14px; margin: 0; }
    .photo-preview-img {
        width: 100%;
        height: 120px;
        object-fit: cover;
        border-radius: 8px;
        margin-top: 8px;
    }
    .mc-input-file { display: none; }
    .table-photo {
        width: 48px;
        height: 48px;
        object-fit: cover;
        border-radius: 8px;
        border: 2px solid #F3F4F6;
    }
    .photo-cell { width: 80px; }
</style>