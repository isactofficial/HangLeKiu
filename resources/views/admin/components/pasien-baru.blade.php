<div class="reg-modal-overlay" id="modalPasienBaru" style="z-index: 1100;">
    <div class="reg-modal-content">
        <button type="button" class="modal-close-btn" onclick="closePasienModalAndBackToReg()">
            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

        <h1 class="page-title">Tambah Pasien Baru</h1>

        {{-- Alert area --}}
        <div id="pasienBaruAlert" style="display:none; margin-bottom:16px; padding:12px 16px; border-radius:8px; font-size:13px;"></div>

        {{-- PERHATIKAN: Saya tambahkan onsubmit="simpanDataPasienBaru(event)" --}}
        <form id="pasienBaruForm" onsubmit="simpanDataPasienBaru(event)">
            @csrf
            <div class="form-card">
                
                <div class="section-header">
                    Informasi Dasar
                </div>

                <div class="form-body">
                    
                    {{-- Top Section: Photo & Notice --}}
                    <div class="top-section">
                        <div class="photo-box" id="photoBox" style="cursor: pointer;">
                            <img id="photoPreview" style="display: none; width: 100%; height: 100%; object-fit: cover;">
                            <div id="photoPlaceholder" style="display: flex; flex-direction: column; align-items: center; justify-content: center;">
                                <div class="photo-btn" id="photoBtnTrigger" style="position: relative; cursor: pointer;">Pilih Foto</div>
                                <svg class="photo-icon" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
                                </svg>
                            </div>
                            <input type="file" id="photoInput" name="photo" accept="image/*" style="display: none;">
                            <input type="hidden" id="photoCroppedBase64" name="photo_base64" value="">
                        </div>
                        <div class="info-texts">
                            <div class="req-notice">Tanda <span>*</span> wajib diisi!</div>
                            <div class="last-rm-notice" id="lastMrnDisplay">Memuat nomor MR terakhir...</div>
                        </div>
                    </div>

                    {{-- Row 1 --}}
                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label">Nama Lengkap <span class="req">*</span></label>
                            <input type="text" name="full_name" class="input-line" id="pb_full_name">
                            <span class="field-error" id="err_full_name" style="color:#e05252;font-size:11px;display:none;"></span>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Nomor Medical Record</label>
                            <input type="text" class="input-line" placeholder="Auto-generated" readonly>
                        </div>
                    </div>

                    {{-- Row 2 --}}
                    <div class="grid-3">
                        <div class="form-group">
                            <label class="form-label">Kota Tempat Lahir</label>
                            <input type="text" name="city" class="input-line">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Tanggal Lahir <span class="req">*</span></label>
                            <div class="input-icon-wrapper">
                                <input type="date" name="date_of_birth" class="input-line" id="pb_date_of_birth">
                                <svg class="icon-right" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                                </svg>
                            </div>
                            <span class="field-error" id="err_date_of_birth" style="color:#e05252;font-size:11px;display:none;"></span>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Nomor KTP</label>
                            <input type="text" name="id_card_number" class="input-line" maxlength="20">
                        </div>
                    </div>

                    {{-- Row 3 --}}
                    <div class="grid-3">
                        <div class="form-group">
                            <label class="form-label">Jenis Kelamin <span class="req">*</span></label>
                            <select name="gender" class="input-pill" id="pb_gender">
                                <option value="">-- Pilih --</option>
                                <option value="Male">Laki - laki</option>
                                <option value="Female">Perempuan</option>
                            </select>
                            <span class="field-error" id="err_gender" style="color:#e05252;font-size:11px;display:none;"></span>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Agama</label>
                            <select name="religion" class="input-pill">
                                <option value="">-- Pilih --</option>
                                <option value="Islam">Islam</option>
                                <option value="Kristen">Kristen</option>
                                <option value="Katolik">Katolik</option>
                                <option value="Hindu">Hindu</option>
                                <option value="Buddha">Buddha</option>
                                <option value="Konghucu">Konghucu</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Status Pernikahan</label>
                            <select name="marital_status" class="input-pill">
                                <option value="">-- Pilih --</option>
                                <option value="Belum Kawin">Belum Kawin</option>
                                <option value="Kawin">Kawin</option>
                                <option value="Cerai Hidup">Cerai Hidup</option>
                                <option value="Cerai Mati">Cerai Mati</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                    </div>

                    {{-- Row 4 --}}
                    <div class="grid-3">
                        <div class="form-group">
                            <label class="form-label">Golongan Darah</label>
                            <select name="blood_type" class="input-pill">
                                <option value="unknown">Tidak Tahu</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="AB">AB</option>
                                <option value="O">O</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Pendidikan Terakhir</label>
                            <select name="education" class="input-pill">
                                <option value="">-- Pilih --</option>
                                <option value="SD/Sederajat">SD/Sederajat</option>
                                <option value="SMP/Sederajat">SMP/Sederajat</option>
                                <option value="SMA/Sederajat">SMA/Sederajat</option>
                                <option value="D3">D3</option>
                                <option value="S1/D4">S1/D4</option>
                                <option value="S2">S2</option>
                                <option value="S3">S3</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Pekerjaan</label>
                            <select name="occupation" class="input-pill">
                                <option value="">-- Pilih --</option>
                                <option value="PNS">PNS</option>
                                <option value="Wiraswasta">Wiraswasta</option>
                                <option value="Karyawan Swasta">Karyawan Swasta</option>
                                <option value="Pelajar/Mahasiswa">Pelajar/Mahasiswa</option>
                                <option value="Belum Bekerja">Belum Bekerja</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                    </div>

                    {{-- Row 5 --}}
                    <div class="grid-2">
                        <div class="form-group">
                            <label class="form-label">Nomor HP</label>
                            <div class="input-icon-wrapper">
                                <svg class="icon-left" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                                <input type="text" name="phone_number" class="input-line">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="input-line">
                            <span class="field-error" id="err_email" style="color:#e05252;font-size:11px;display:none;"></span>
                        </div>
                    </div>

                    {{-- Row 6 --}}
                    <div class="grid-3" style="margin-bottom: 40px;">
                        <div class="form-group">
                            <label class="form-label">Tanggal Pertama Chat</label>
                            <div class="input-icon-wrapper">
                                <input type="date" name="first_chat_date" class="input-line">
                                <svg class="icon-right" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                                </svg>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Alamat</label>
                            <input type="text" name="address" class="input-line">
                        </div>
                    </div>

                    {{-- Submit Button --}}
                    <div style="display:flex; justify-content:flex-end; gap:12px; margin-top:8px;">
                        <button type="button" class="btn-outline" onclick="closePasienModalAndBackToReg()">Batal</button>
                        <button type="submit" class="btn-solid" id="pasienBaruSubmitBtn">Simpan Pasien Baru</button>
                    </div>

                </div>
            </div>
        </form>
    </div>
</div>

<script>
// Fungsi ini dipanggil dari onsubmit form di atas
async function simpanDataPasienBaru(e) {
    e.preventDefault(); // SUPER PENTING: Mencegah URL berubah menjadi GET /reload
    
    console.log('📝 Form submit triggered');

    const form = document.getElementById('pasienBaruForm');
    const btn = document.getElementById('pasienBaruSubmitBtn');
    const alert = document.getElementById('pasienBaruAlert');

    if (!form || !btn || !alert) {
        console.error('❌ Form elements not found');
        return;
    }

    // Bersihkan pesan error sebelumnya
    document.querySelectorAll('#pasienBaruForm .field-error').forEach(el => {
        el.style.display = 'none';
        el.textContent = '';
    });
    alert.style.display = 'none';

    // Animasi tombol loading
    btn.textContent = 'Menyimpan...';
    btn.disabled = true;

    const formData = new FormData(form);
    
    console.log('📦 FormData prepared:', {
        full_name: formData.get('full_name'),
        date_of_birth: formData.get('date_of_birth'),
        gender: formData.get('gender'),
        photo_base64: formData.get('photo_base64') ? 'YES' : 'NO'
    });

    try {
        const endpoint = '{{ route("admin.patients.store") }}';
        console.log('🚀 Sending to:', endpoint);
        
        const res = await fetch(endpoint, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                // Ingat: Token CSRF sudah ada di dalam formData karena tag @csrf di form
            },
            body: formData,
        });

        console.log('📡 Response status:', res.status);
        
        const contentType = res.headers.get("content-type");
        if (!contentType || !contentType.includes("application/json")) {
            console.error('❌ Response is not JSON:', contentType);
            throw new Error("Server tidak mengembalikan JSON. Cek console server untuk error details.");
        }

        const data = await res.json();
        console.log('📥 Response data:', data);

        // JIKA SUKSES
        if (res.ok && data.success) {
            console.log('✅ Success!');
            alert.style.background = '#f0fdf4';
            alert.style.color = '#166534';
            alert.style.border = '1px solid #bbf7d0';
            alert.textContent = '✓ ' + (data.message || 'Data berhasil disimpan!');
            alert.style.display = 'block';
            
            form.reset();
            
            // Dispatch event untuk auto-select patient di registration form
            if (data.data) {
                window.dispatchEvent(new CustomEvent('patientCreatedInModal', {
                    detail: { patient: data.data }
                }));
            }
            
            // Reset photo preview
            const photoPreview = document.getElementById('photoPreview');
            const photoPlaceholder = document.getElementById('photoPlaceholder');
            const photoCroppedBase64 = document.getElementById('photoCroppedBase64');
            if (photoPreview) photoPreview.style.display = 'none';
            if (photoPlaceholder) photoPlaceholder.style.display = 'flex';
            if (photoCroppedBase64) photoCroppedBase64.value = '';
            
            // Tutup pop-up setelah 1.5 detik dan kembali ke form daftar
            setTimeout(() => {
                if(typeof closePasienModalAndBackToReg === 'function') {
                    closePasienModalAndBackToReg();
                    console.log('Modal closed and back to registration form');
                }
            }, 1500);

        // JIKA VALIDASI GAGAL (KOLOM KOSONG/SALAH FORMAT)
        } else if (res.status === 422 && data.errors) {
            console.log('⚠️ Validation error:', data.errors);
            Object.entries(data.errors).forEach(([field, msgs]) => {
                const errEl = document.getElementById('err_' + field);
                if (errEl) {
                    errEl.textContent = msgs[0];
                    errEl.style.display = 'block';
                }
            });
            alert.style.background = '#fef2f2';
            alert.style.color = '#991b1b';
            alert.style.border = '1px solid #fecaca';
            alert.textContent = 'Mohon periksa kembali isian form yang berwarna merah.';
            alert.style.display = 'block';
            
        // JIKA ERROR LAIN (MYSQL ERROR, DLL)
        } else {
            console.error('❌ Server error:', data);
            throw new Error(data.error || data.message || 'Terjadi kesalahan pada server.');
        }

    } catch (err) {
        console.error('❌ Catch error:', err.message);
        alert.style.background = '#fef2f2';
        alert.style.color = '#991b1b';
        alert.style.border = '1px solid #fecaca';
        alert.textContent = 'Error: ' + err.message;
        alert.style.display = 'block';
    } finally {
        // Kembalikan tombol ke semula
        btn.textContent = 'Simpan Pasien Baru';
        btn.disabled = false;
    }
}
</script>

{{-- Photo Crop Modal --}}
<div id="cropperModal" class="cropper-modal-overlay" style="display: none;">
    <div class="cropper-modal">
        <div class="cropper-modal-header">
            <h3>Posisikan Foto Profil</h3>
            <button type="button" class="cropper-close-btn" onclick="closeCropperModal()">&times;</button>
        </div>
        <div class="cropper-modal-body">
            <p style="color: #666; font-size: 14px; margin-bottom: 16px;">Drag area lingkaran untuk memposisikan foto sesuai keinginan</p>
            <div class="cropper-container">
                <canvas id="cropperCanvas"></canvas>
            </div>
        </div>
        <div class="cropper-modal-footer">
            <button type="button" class="btn-outline" onclick="closeCropperModal()">Batal</button>
            <button type="button" class="btn-solid" onclick="applyCrop()">Terapkan Crop</button>
        </div>
    </div>
</div>

<script>
// ========================================
// Photo Crop Functionality - Simplified
// ========================================

let cropperState = {
    isDragging: false,
    startX: 0,
    startY: 0,
    frameX: 25,
    frameY: 25,
    frameSize: 150,
    image: null,
    imageData: null,
    originalWidth: 0,
    originalHeight: 0
};

function initPhotoCropper() {
    const photoInput = document.getElementById('photoInput');
    const photoBox = document.getElementById('photoBox');
    const photoBtnTrigger = document.getElementById('photoBtnTrigger');
    
    // Only run if elements exist (pasien-baru form is present)
    if (!photoInput || !photoBox || !photoBtnTrigger) {
        return;
    }
    
    photoBtnTrigger.addEventListener('click', (e) => {
        e.stopPropagation();
        photoInput.click();
    });
    
    photoBox.addEventListener('click', (e) => {
        if (e.target.id !== 'photoBtnTrigger') {
            photoInput.click();
        }
    });
    
    photoInput.addEventListener('change', handlePhotoSelect);
}

function handlePhotoSelect(e) {
    const file = e.target.files[0];
    if (!file) return;
    
    const reader = new FileReader();
    reader.onload = (evt) => {
        const img = new Image();
        img.onload = () => {
            cropperState.image = img;
            cropperState.imageData = evt.target.result;
            cropperState.originalWidth = img.width;
            cropperState.originalHeight = img.height;
            openCropperModal();
            setTimeout(renderCanvas, 100);
        };
        img.src = evt.target.result;
    };
    reader.readAsDataURL(file);
}

function renderCanvas() {
    const canvas = document.getElementById('cropperCanvas');
    if (!canvas || !cropperState.image) return;
    
    const img = cropperState.image;
    
    // Set canvas size (max 500px)
    let displayWidth = Math.min(img.width, 500);
    let displayHeight = (img.height / img.width) * displayWidth;
    
    if (displayHeight > 400) {
        displayHeight = 400;
        displayWidth = (img.width / img.height) * displayHeight;
    }
    
    // Round to avoid blurriness
    displayWidth = Math.round(displayWidth);
    displayHeight = Math.round(displayHeight);
    
    canvas.width = displayWidth;
    canvas.height = displayHeight;
    
    // Initialize frame position to center (only once)
    if (cropperState.frameX === undefined || cropperState.frameX === 25) {
        cropperState.frameX = displayWidth / 2;
        cropperState.frameY = displayHeight / 2;
    }
    
    const ctx = canvas.getContext('2d');
    
    // Draw image
    ctx.drawImage(img, 0, 0, displayWidth, displayHeight);
    
    // Draw dark overlay
    ctx.fillStyle = 'rgba(0, 0, 0, 0.5)';
    ctx.fillRect(0, 0, displayWidth, displayHeight);
    
    // Clear frame area (make it visible)
    ctx.clearRect(
        cropperState.frameX - cropperState.frameSize / 2,
        cropperState.frameY - cropperState.frameSize / 2,
        cropperState.frameSize,
        cropperState.frameSize
    );
    
    // Redraw image in frame area only
    ctx.drawImage(img, 0, 0, displayWidth, displayHeight);
    ctx.globalCompositeOperation = 'destination-in';
    ctx.beginPath();
    ctx.arc(
        cropperState.frameX,
        cropperState.frameY,
        cropperState.frameSize / 2,
        0,
        Math.PI * 2
    );
    ctx.fill();
    ctx.globalCompositeOperation = 'source-over';
    
    // Draw circular border
    ctx.strokeStyle = '#C58F59';
    ctx.lineWidth = 3;
    ctx.beginPath();
    ctx.arc(
        cropperState.frameX,
        cropperState.frameY,
        cropperState.frameSize / 2,
        0,
        Math.PI * 2
    );
    ctx.stroke();
}

function openCropperModal() {
    const modal = document.getElementById('cropperModal');
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
    attachCanvasEvents();
}

function closeCropperModal() {
    const modal = document.getElementById('cropperModal');
    modal.style.display = 'none';
    document.body.style.overflow = '';
    detachCanvasEvents();
    cropperState.isDragging = false;
}

function attachCanvasEvents() {
    const canvas = document.getElementById('cropperCanvas');
    if (!canvas) return;
    
    // Remove any existing listeners first
    detachCanvasEvents();
    
    const onMouseDown = (e) => {
        const rect = canvas.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;
        
        // Circle center and radius (frameX/Y is center now)
        const cx = cropperState.frameX;
        const cy = cropperState.frameY;
        const r = cropperState.frameSize / 2;
        
        // Check if click is within circle (with tolerance for easier interaction)
        const dx = x - cx;
        const dy = y - cy;
        const distance = Math.sqrt(dx * dx + dy * dy);
        
        // Allow clicking anywhere within circle + 10px tolerance
        if (distance < r + 10) {
            cropperState.isDragging = true;
            cropperState.startX = x;
            cropperState.startY = y;
        }
    };
    
    const onMouseMove = (e) => {
        if (!cropperState.isDragging) return;
        
        const rect = canvas.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;
        
        const deltaX = x - cropperState.startX;
        const deltaY = y - cropperState.startY;
        
        // Update frame position (center-based)
        let newX = cropperState.frameX + deltaX;
        let newY = cropperState.frameY + deltaY;
        
        // Gentle boundary constraint - allow frame to go nearly to edge
        const r = cropperState.frameSize / 2;
        const minX = r * 0.2;  // Allow frame to go ~80% of radius to left edge
        const maxX = canvas.width - r * 0.2;
        const minY = r * 0.2;  // Allow frame to go ~80% of radius to top edge
        const maxY = canvas.height - r * 0.2;
        
        if (newX < minX) newX = minX;
        if (newX > maxX) newX = maxX;
        if (newY < minY) newY = minY;
        if (newY > maxY) newY = maxY;
        
        cropperState.frameX = newX;
        cropperState.frameY = newY;
        cropperState.startX = x;
        cropperState.startY = y;
        
        renderCanvas();
    };
    
    const onMouseUp = () => {
        cropperState.isDragging = false;
    };
    
    canvas.addEventListener('mousedown', onMouseDown);
    document.addEventListener('mousemove', onMouseMove);
    document.addEventListener('mouseup', onMouseUp);
    
    // Store for cleanup
    cropperState._mouseDown = onMouseDown;
    cropperState._mouseMove = onMouseMove;
    cropperState._mouseUp = onMouseUp;
}

function detachCanvasEvents() {
    const canvas = document.getElementById('cropperCanvas');
    if (!canvas) return;
    
    if (cropperState._mouseDown) canvas.removeEventListener('mousedown', cropperState._mouseDown);
    if (cropperState._mouseMove) document.removeEventListener('mousemove', cropperState._mouseMove);
    if (cropperState._mouseUp) document.removeEventListener('mouseup', cropperState._mouseUp);
}

function applyCrop() {
    const canvas = document.getElementById('cropperCanvas');
    if (!canvas || !cropperState.image) return;
    
    // Create circular cropped image
    const size = cropperState.frameSize;
    const croppedCanvas = document.createElement('canvas');
    croppedCanvas.width = size;
    croppedCanvas.height = size;
    
    const ctx = croppedCanvas.getContext('2d');
    
    // Calculate source coordinates (frameX/Y is center-based now)
    const scaleX = cropperState.originalWidth / canvas.width;
    const scaleY = cropperState.originalHeight / canvas.height;
    
    // Top-left corner of bounding square (since frameX/Y is center)
    const srcX = (cropperState.frameX - size / 2) * scaleX;
    const srcY = (cropperState.frameY - size / 2) * scaleY;
    const srcSize = size * scaleX;
    
    // Draw circular image from original coordinates
    ctx.drawImage(
        cropperState.image,
        srcX, srcY, srcSize, srcSize,
        0, 0, size, size
    );
    
    // Apply circular mask
    ctx.globalCompositeOperation = 'destination-in';
    ctx.beginPath();
    ctx.arc(size / 2, size / 2, size / 2, 0, Math.PI * 2);
    ctx.fill();
    
    // Convert to base64
    const base64 = croppedCanvas.toDataURL('image/png');
    document.getElementById('photoCroppedBase64').value = base64;
    
    // Show preview
    const preview = document.getElementById('photoPreview');
    const placeholder = document.getElementById('photoPlaceholder');
    preview.src = base64;
    preview.style.display = 'block';
    placeholder.style.display = 'none';
    
    closeCropperModal();
}

// Close modal when clicking outside
document.addEventListener('DOMContentLoaded', () => {
    initPhotoCropper();
    
    const modal = document.getElementById('cropperModal');
    modal.addEventListener('click', (e) => {
        if (e.target.id === 'cropperModal') {
            closeCropperModal();
        }
    });
});

/**
 * Close Pasien Baru modal dan kembali ke form Daftar Kunjungan
 */
window.closePasienModalAndBackToReg = function() {
    const pasienModal = document.getElementById('modalPasienBaru');
    const regModal = document.getElementById('modalPendaftaranBaru');
    
    if (pasienModal) {
        pasienModal.style.display = 'none';
    }
    if (regModal) {
        regModal.classList.add('open');
        regModal.style.display = ''; 
    }
};
</script>