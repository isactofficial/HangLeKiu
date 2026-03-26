@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/components/settings/manajemen_staff.css') }}">
@endpush

{{-- resources/views/admin/settings/manajemen_staff.blade.php --}}
<div class="ms-header-row">
    <div>
        <h2 class="ms-title">Manajemen Staff</h2>
        <p class="ms-subtitle">Last Update: 17 Desember 2024 (13:50 WIB)</p>
    </div>
    <div class="ms-actions-row">
        <div class="ms-btn-group">
            <button class="ms-btn-group-item active">Informasi PIC</button>
            <button class="ms-btn-group-item">Tidak Aktif</button>
        </div>
        <button class="ms-btn-primary" type="button" id="ms-open-doctor-modal">
            + Tambah Staff
        </button>
    </div>
</div>

@if (session('success'))
    <div class="ms-alert ms-alert-success">
        {{ session('success') }}
    </div>
@endif

@if($errors->has('doctor_create') || $errors->any())
    <div class="ms-alert ms-alert-error">
        {{ $errors->first('doctor_create') ?: 'Periksa kembali form tambah staff.' }}
    </div>
@endif

<div id="ms-doctor-modal" class="ms-modal-overlay" aria-hidden="true">
    <div class="ms-modal-card" role="dialog" aria-modal="true" aria-labelledby="ms-doctor-modal-title">
        <div class="ms-modal-header">
            <h3 id="ms-doctor-modal-title">Tambah Staff Dokter</h3>
            <button type="button" class="ms-modal-close" id="ms-close-doctor-modal" aria-label="Tutup">x</button>
        </div>

        <form method="POST" action="{{ route('admin.settings.staff.doctor.store') }}" class="ms-modal-form" enctype="multipart/form-data" id="ms-doctor-form">
            @csrf

            <section class="ms-section">
                <h4 class="ms-section-title">Akun Login (Wajib)</h4>
                <p class="ms-section-help">Data ini dipakai dokter untuk login ke halaman dokter.</p>
                <div class="ms-form-grid">
                    <div class="ms-field full">
                        <label for="full_name">Nama Lengkap *</label>
                        <input id="full_name" name="full_name" type="text" value="{{ old('full_name') }}" placeholder="Contoh: drg. Anisa Putri" maxlength="100" required>
                    </div>

                    <div class="ms-field">
                        <label for="email">Email Login *</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" placeholder="dokter@hanglekiu.com" maxlength="50" required>
                    </div>

                    <div class="ms-field">
                        <label for="password">Password Login *</label>
                        <input id="password" name="password" type="password" placeholder="Minimal 8 karakter" minlength="8" required>
                    </div>

                    <div class="ms-field">
                        <label for="password_confirmation">Konfirmasi Password *</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" required>
                    </div>
                </div>
            </section>

            <section class="ms-section">
                <h4 class="ms-section-title">Profil Dokter</h4>
                <div class="ms-form-grid">
                    <div class="ms-field full">
                        <label for="foto_profil">Foto Profil Dokter</label>
                        <input id="foto_profil" name="foto_profil" type="file" accept="image/png,image/jpeg,image/jpg,image/webp">
                        <small id="foto-profil-file-name" style="display:block;margin-top:6px;color:#8a6b52;">Belum ada foto profil dipilih.</small>
                        <img id="foto-profil-preview" alt="Preview Foto Profil" style="display:none;margin-top:8px;max-height:120px;border:1px solid #dbc7b2;border-radius:8px;padding:4px;background:#fff;">
                    </div>

                    <div class="ms-field full">
                        <label for="ttd">TTD Dokter (Gambar)</label>
                        <input id="ttd" name="ttd" type="file" accept="image/png,image/jpeg,image/jpg,image/webp">
                        <small id="ttd-file-name" style="display:block;margin-top:6px;color:#8a6b52;">Belum ada file TTD dipilih.</small>
                        <img id="ttd-preview" alt="Preview TTD" style="display:none;margin-top:8px;max-height:90px;border:1px solid #dbc7b2;border-radius:8px;padding:4px;background:#fff;">
                    </div>

                    <div class="ms-field">
                        <label for="estimasi_konsultasi">Estimasi Lama Konsultasi (Menit)</label>
                        <input id="estimasi_konsultasi" name="estimasi_konsultasi" type="number" min="1" max="600" step="1" value="{{ old('estimasi_konsultasi') }}" placeholder="Contoh: 15">
                    </div>

                    <div class="ms-field">
                        <label for="phone_number">Nomor HP</label>
                        <input id="phone_number" name="phone_number" type="text" value="{{ old('phone_number') }}" placeholder="08xxxxxxxxxx" pattern="[0-9+\-\s]{8,20}" maxlength="20" title="Nomor HP hanya boleh angka/simbol + - spasi, 8-20 karakter.">
                    </div>

                    <div class="ms-field">
                        <label for="title_prefix">Gelar Depan</label>
                        <input id="title_prefix" name="title_prefix" type="text" value="{{ old('title_prefix') }}" placeholder="Contoh: drg.">
                    </div>

                    <div class="ms-field">
                        <label for="specialization">Spesialisasi</label>
                        <input id="specialization" name="specialization" type="text" value="{{ old('specialization') }}" placeholder="Contoh: Sp.Ortho">
                    </div>

                    <div class="ms-field">
                        <label for="subspecialization">Subspesialisasi</label>
                        <input id="subspecialization" name="subspecialization" type="text" value="{{ old('subspecialization') }}">
                    </div>

                    <div class="ms-field">
                        <label for="job_title">Jabatan</label>
                        <input id="job_title" name="job_title" type="text" value="{{ old('job_title') }}" placeholder="Contoh: Dokter Gigi Spesialis">
                    </div>

                    <div class="ms-field">
                        <label for="is_active">Status</label>
                        <select id="is_active" name="is_active">
                            <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                    </div>
                </div>
            </section>

            <section class="ms-section">
                <h4 class="ms-section-title">Jadwal Praktek</h4>
                <p class="ms-section-help">Centang hari aktif, lalu isi jam mulai dan jam selesai.</p>
                <div class="ms-form-grid">
                    @php
                        $days = [
                            'monday' => 'Senin',
                            'tuesday' => 'Selasa',
                            'wednesday' => 'Rabu',
                            'thursday' => 'Kamis',
                            'friday' => 'Jumat',
                            'saturday' => 'Sabtu',
                            'sunday' => 'Minggu',
                        ];
                    @endphp

                    @foreach($days as $dayKey => $dayLabel)
                        <div class="ms-field full">
                            <label>
                                <input
                                    type="checkbox"
                                    name="schedules[{{ $dayKey }}][is_active]"
                                    value="1"
                                    {{ old("schedules.$dayKey.is_active") ? 'checked' : '' }}
                                >
                                {{ $dayLabel }}
                            </label>
                            <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-top:8px;">
                                <input
                                    type="time"
                                    name="schedules[{{ $dayKey }}][start_time]"
                                    value="{{ old("schedules.$dayKey.start_time") }}"
                                    placeholder="Jam Mulai"
                                    data-day="{{ $dayKey }}"
                                    data-kind="start"
                                >
                                <input
                                    type="time"
                                    name="schedules[{{ $dayKey }}][end_time]"
                                    value="{{ old("schedules.$dayKey.end_time") }}"
                                    placeholder="Jam Selesai"
                                    data-day="{{ $dayKey }}"
                                    data-kind="end"
                                >
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <details class="ms-section ms-optional" {{ old('license_no') || old('str_number') || old('sip_number') ? 'open' : '' }}>
                <summary class="ms-section-title">Legalitas: STR, SIP, Lisensi</summary>
                <div class="ms-form-grid">
                    <div class="ms-field">
                        <label for="license_no">Nomor Lisensi</label>
                        <input id="license_no" name="license_no" type="text" value="{{ old('license_no') }}">
                    </div>

                    <div class="ms-field">
                        <label for="str_institution">Instansi STR</label>
                        <input id="str_institution" name="str_institution" type="text" value="{{ old('str_institution') }}">
                    </div>

                    <div class="ms-field">
                        <label for="str_number">Nomor STR</label>
                        <input id="str_number" name="str_number" type="text" value="{{ old('str_number') }}">
                    </div>

                    <div class="ms-field">
                        <label for="str_expiry_date">Tanggal Expired STR</label>
                        <input id="str_expiry_date" name="str_expiry_date" type="date" value="{{ old('str_expiry_date') }}">
                    </div>

                    <div class="ms-field">
                        <label for="sip_institution">Instansi SIP</label>
                        <input id="sip_institution" name="sip_institution" type="text" value="{{ old('sip_institution') }}">
                    </div>

                    <div class="ms-field">
                        <label for="sip_number">Nomor SIP</label>
                        <input id="sip_number" name="sip_number" type="text" value="{{ old('sip_number') }}">
                    </div>

                    <div class="ms-field">
                        <label for="sip_expiry_date">Tanggal Expired SIP</label>
                        <input id="sip_expiry_date" name="sip_expiry_date" type="date" value="{{ old('sip_expiry_date') }}">
                    </div>
                </div>
            </details>

            <div class="ms-modal-actions">
                <button type="button" class="ms-btn-filter" id="ms-cancel-doctor-modal">Batal</button>
                <button type="submit" class="ms-btn-primary">Simpan Akun Dokter</button>
            </div>
        </form>
    </div>
</div>

<div class="ms-actions-row">
    <div class="ms-search-box">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#6B513E" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
        <input type="text" placeholder="Cari staff">
    </div>
    <button class="ms-btn-filter">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="4" y1="6" x2="16" y2="6"/><line x1="8" y1="12" x2="20" y2="12"/><line x1="4" y1="18" x2="12" y2="18"/></svg>
        Filter
    </button>
</div>

<script>
    (function () {
        const modal = document.getElementById('ms-doctor-modal');
        const openBtn = document.getElementById('ms-open-doctor-modal');
        const closeBtn = document.getElementById('ms-close-doctor-modal');
        const cancelBtn = document.getElementById('ms-cancel-doctor-modal');
        const doctorForm = document.getElementById('ms-doctor-form');
        const fotoProfilInput = document.getElementById('foto_profil');
        const fotoProfilFileName = document.getElementById('foto-profil-file-name');
        const fotoProfilPreview = document.getElementById('foto-profil-preview');
        const ttdInput = document.getElementById('ttd');
        const ttdFileName = document.getElementById('ttd-file-name');
        const ttdPreview = document.getElementById('ttd-preview');

        if (!modal || !openBtn) {
            return;
        }

        const openModal = () => {
            modal.classList.add('show');
            modal.setAttribute('aria-hidden', 'false');
            document.body.classList.add('ms-modal-open');
            document.getElementById('full_name')?.focus();
        };

        const closeModal = () => {
            modal.classList.remove('show');
            modal.setAttribute('aria-hidden', 'true');
            document.body.classList.remove('ms-modal-open');
        };

        const updateImagePreview = (input, fileNameEl, previewEl, emptyMessage) => {
            if (!input || !fileNameEl || !previewEl) {
                return;
            }

            const file = input.files && input.files[0] ? input.files[0] : null;

            if (!file) {
                fileNameEl.textContent = emptyMessage;
                previewEl.style.display = 'none';
                previewEl.removeAttribute('src');
                return;
            }

            fileNameEl.textContent = `File dipilih: ${file.name}`;
            const reader = new FileReader();
            reader.onload = (event) => {
                previewEl.src = String(event.target?.result ?? '');
                previewEl.style.display = 'block';
            };
            reader.readAsDataURL(file);
        };

        openBtn.addEventListener('click', openModal);
        closeBtn?.addEventListener('click', closeModal);
        cancelBtn?.addEventListener('click', closeModal);

        modal.addEventListener('click', (event) => {
            if (event.target === modal) {
                closeModal();
            }
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && modal.classList.contains('show')) {
                closeModal();
            }
        });

        fotoProfilInput?.addEventListener('change', () => {
            updateImagePreview(fotoProfilInput, fotoProfilFileName, fotoProfilPreview, 'Belum ada foto profil dipilih.');
        });

        ttdInput?.addEventListener('change', () => {
            updateImagePreview(ttdInput, ttdFileName, ttdPreview, 'Belum ada file TTD dipilih.');
        });

        updateImagePreview(fotoProfilInput, fotoProfilFileName, fotoProfilPreview, 'Belum ada foto profil dipilih.');
        updateImagePreview(ttdInput, ttdFileName, ttdPreview, 'Belum ada file TTD dipilih.');

        const validateScheduleRows = () => {
            if (!doctorForm) {
                return true;
            }

            let isValid = true;
            const dayRows = doctorForm.querySelectorAll('input[type="checkbox"][name^="schedules["]');

            dayRows.forEach((checkbox) => {
                const day = checkbox.name.match(/schedules\[(.+?)\]/)?.[1];
                if (!day) {
                    return;
                }

                const start = doctorForm.querySelector(`input[data-day="${day}"][data-kind="start"]`);
                const end = doctorForm.querySelector(`input[data-day="${day}"][data-kind="end"]`);

                if (!start || !end) {
                    return;
                }

                start.setCustomValidity('');
                end.setCustomValidity('');

                if (!checkbox.checked && !start.value && !end.value) {
                    return;
                }

                if (!start.value || !end.value) {
                    const message = 'Lengkapi jam mulai dan jam selesai untuk hari ini.';
                    start.setCustomValidity(message);
                    end.setCustomValidity(message);
                    isValid = false;
                    return;
                }

                if (end.value <= start.value) {
                    end.setCustomValidity('Jam selesai harus lebih besar dari jam mulai.');
                    isValid = false;
                }
            });

            return isValid;
        };

        if (doctorForm) {
            doctorForm.addEventListener('submit', (event) => {
                const scheduleValid = validateScheduleRows();
                if (!scheduleValid || !doctorForm.checkValidity()) {
                    event.preventDefault();
                    doctorForm.reportValidity();
                }
            });

            doctorForm.addEventListener('input', (event) => {
                const target = event.target;
                if (!(target instanceof HTMLInputElement || target instanceof HTMLSelectElement)) {
                    return;
                }

                if (target.name.startsWith('schedules[') || target.name === 'phone_number') {
                    validateScheduleRows();
                    target.setCustomValidity('');
                }
            });
        }

        @if($errors->has('doctor_create') || $errors->any())
            openModal();
        @endif
    })();
</script>

<div class="ms-table-card">
    <div class="ms-table-wrapper">
        <table class="ms-table">
            <thead>
                <tr>
                    <th><span class="sort">↑↓ Nama</span></th>
                    <th><span class="sort">↑↓ Status</span></th>
                    <th><span class="sort">↑↓ Tipe Akses</span></th>
                    <th>Nomor HP</th>
                    <th>Login Email</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>dinda tegar jelita</td>
                    <td><span class="ms-badge-aktif">Aktif</span></td>
                    <td>Owner</td>
                    <td>**********355</td>
                    <td>**********...</td>
                    <td>
                        <div class="ms-action-row">
                            <button class="ms-icon-btn" title="Edit">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            </button>
                            <button class="ms-kebab-btn" title="More">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="5" r="1.5"/><circle cx="12" cy="12" r="1.5"/><circle cx="12" cy="19" r="1.5"/></svg>
                            </button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>drg. Maya Sp.Perio</td>
                    <td><span class="ms-badge-aktif">Aktif</span></td>
                    <td>Doctor</td>
                    <td>**********43</td>
                    <td>**********...</td>
                    <td>
                        <div class="ms-action-row">
                            <button class="ms-icon-btn" title="Edit">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            </button>
                            <button class="ms-kebab-btn" title="More">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="5" r="1.5"/><circle cx="12" cy="12" r="1.5"/><circle cx="12" cy="19" r="1.5"/></svg>
                            </button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>drg. Ria Budiati Sp.Ortho</td>
                    <td><span class="ms-badge-aktif">Aktif</span></td>
                    <td>Owner</td>
                    <td>**********244</td>
                    <td>**********...</td>
                    <td>
                        <div class="ms-action-row">
                            <button class="ms-icon-btn" title="Edit">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            </button>
                            <button class="ms-kebab-btn" title="More">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="5" r="1.5"/><circle cx="12" cy="12" r="1.5"/><circle cx="12" cy="19" r="1.5"/></svg>
                            </button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Sonia Novitasari</td>
                    <td><span class="ms-badge-aktif">Aktif</span></td>
                    <td>Owner</td>
                    <td>**********3039</td>
                    <td>**********...</td>
                    <td>
                        <div class="ms-action-row">
                            <button class="ms-icon-btn" title="Edit">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            </button>
                            <button class="ms-kebab-btn" title="More">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="5" r="1.5"/><circle cx="12" cy="12" r="1.5"/><circle cx="12" cy="19" r="1.5"/></svg>
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="ms-pagination">
        <div class="ms-page-size">Jumlah baris per halaman: <select><option>5</option><option>10</option><option>25</option></select></div>
        <div class="ms-page-info">1–4 dari 4 data</div>
        <div class="ms-page-controls">
            <button class="ms-page-btn" disabled><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M11 17l-5-5 5-5M18 17l-5-5 5-5"/></svg></button>
            <button class="ms-page-btn" disabled><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M15 18l-6-6 6-6"/></svg></button>
            <button class="ms-page-btn" disabled><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 18l6-6-6-6"/></svg></button>
            <button class="ms-page-btn" disabled><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M13 17l5-5-5-5M6 17l5-5-5-5"/></svg></button>
        </div>
    </div>
</div>
