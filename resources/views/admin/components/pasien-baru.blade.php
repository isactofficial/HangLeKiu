<div class="reg-modal-overlay" id="modalPasienBaru">
    <div class="reg-modal-content">
        <button type="button" class="modal-close-btn" onclick="closeRegModal('modalPasienBaru')">
            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

    <h1 class="page-title">Tambah Pasien Baru</h1>

    {{-- Alert area --}}
    <div id="pasienBaruAlert" style="display:none; margin-bottom:16px; padding:12px 16px; border-radius:8px; font-size:13px;"></div>

    <form id="pasienBaruForm">
        @csrf
        <div class="form-card">
            
            <div class="section-header">
                Informasi Dasar
            </div>

            <div class="form-body">
                
                {{-- Top Section: Photo & Notice --}}
                <div class="top-section">
                    <div class="photo-box">
                        <div class="photo-btn">Pilih Foto</div>
                        <svg class="photo-icon" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
                        </svg>
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
                    <button type="button" class="btn-outline" onclick="closeRegModal('modalPasienBaru')">Batal</button>
                    <button type="submit" class="btn-solid" id="pasienBaruSubmitBtn">Simpan Pasien Baru</button>
                </div>

            </div>
        </div>
    </form>
    </div>
</div>

<script>
(function() {
    document.getElementById('pasienBaruForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const btn = document.getElementById('pasienBaruSubmitBtn');
        const alert = document.getElementById('pasienBaruAlert');

        // Clear previous errors
        document.querySelectorAll('#pasienBaruForm .field-error').forEach(el => {
            el.style.display = 'none';
            el.textContent = '';
        });
        alert.style.display = 'none';

        btn.textContent = 'Menyimpan...';
        btn.disabled = true;

        const formData = new FormData(this);

        try {
            const res = await fetch('{{ route('admin.patients.store') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                body: formData,
            });

            const data = await res.json();

            if (res.ok && data.success) {
                alert.style.background = '#f0fdf4';
                alert.style.color = '#166534';
                alert.style.border = '1px solid #bbf7d0';
                alert.textContent = '✓ ' + data.message;
                alert.style.display = 'block';
                this.reset();
                setTimeout(() => closeRegModal('modalPasienBaru'), 1500);
            } else if (res.status === 422 && data.errors) {
                // Validation errors
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
                alert.textContent = 'Mohon periksa kembali isian form.';
                alert.style.display = 'block';
            } else {
                throw new Error(data.message || 'Terjadi kesalahan.');
            }
        } catch (err) {
            alert.style.background = '#fef2f2';
            alert.style.color = '#991b1b';
            alert.style.border = '1px solid #fecaca';
            alert.textContent = err.message;
            alert.style.display = 'block';
        } finally {
            btn.textContent = 'Simpan Pasien Baru';
            btn.disabled = false;
        }
    });
})();
</script>