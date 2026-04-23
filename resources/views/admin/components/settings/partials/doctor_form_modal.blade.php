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
    <div class="ms-modal-card" style="max-width: 1000px;" role="dialog" aria-modal="true">
        <div class="ms-modal-header">
            <h3 id="ms-doctor-modal-title">Tambah Tenaga Medis</h3>
            <button type="button" class="ms-modal-close" id="ms-close-doctor-modal">x</button>
        </div>

        <form method="POST" action="{{ route('admin.settings.staff.doctor.store') }}" class="ms-modal-form" enctype="multipart/form-data" id="ms-doctor-form">
            @csrf

            {{-- CONTAINER DUA KOLOM (PROFIL & JADWAL) --}}
            <div style="display: flex; gap: 30px; padding: 20px; border-bottom: 1px solid #eee;">
                
                {{-- KOLOM KIRI: PROFIL --}}
                <div style="flex: 1;">
                    <h4 class="ms-section-title" style="margin-top: 0; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #C58F59; color: #8A6B52; font-weight: 800; text-transform: uppercase; font-size: 13px;">
                        <i class="fa fa-user-md" style="margin-right: 8px; color: #C58F59;"></i> Profil Tenaga Medis
                    </h4>
                    
                    <div class="ms-form-grid" style="display: flex; flex-direction: column; gap: 12px;">
                        <div style="display: flex; gap: 15px; align-items: flex-start;">
                            {{-- Placeholder Foto Profil --}}
                            <div class="ms-field">
                                <label style="font-size: 11px; color: #8A6B52; font-weight: 700; margin-bottom: 5px; display: block; text-transform: uppercase;">Foto Profil</label>
                                <div id="box-foto" style="width: 100px; height: 120px; border: 2px dashed #C58F59; border-radius: 8px; background: #fdfaf8; display: flex; align-items: center; justify-content: center; overflow: hidden; position: relative;">
                                    <i class="fa fa-camera" id="icon-foto" style="color: #d2b48c; font-size: 24px;"></i>
                                    <img id="foto-profil-preview" style="display:none; width: 100%; height: 100%; object-fit: cover; position: absolute; inset: 0;">
                                </div>
                                <input id="foto_profil" name="foto_profil" type="file" accept="image/*" style="font-size: 11px; margin-top: 5px; width: 100px; color: #8A6B52;" onchange="previewImage(this, 'foto-profil-preview', 'icon-foto', 'box-foto')">
                            </div>

                            <div style="flex: 1; display: flex; flex-direction: column; gap: 12px;">
                                <div class="ms-field">
                                    <label for="full_name" style="color: #8A6B52; font-weight: 700; font-size: 11px; text-transform: uppercase;">Nama Lengkap *</label>
                                    <input id="full_name" name="full_name" type="text" value="{{ old('full_name') }}" placeholder="Contoh: drg. Anisa Putri" required style="border-bottom: 1px solid #C58F59;">
                                </div>
                                <div class="ms-field">
                                    <label for="email" style="color: #8A6B52; font-weight: 700; font-size: 11px; text-transform: uppercase;">Email Kontak</label>
                                    <input id="email" name="email" type="email" value="{{ old('email') }}" placeholder="dokter@hanglekiu.com" style="border-bottom: 1px solid #C58F59;">
                                </div>
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                            <div class="ms-field">
                                <label for="phone_number" style="color: #8A6B52; font-weight: 700; font-size: 11px; text-transform: uppercase;">Nomor HP</label>
                                <input id="phone_number" name="phone_number" type="text" value="{{ old('phone_number') }}" style="border-bottom: 1px solid #C58F59;">
                            </div>
                            <div class="ms-field">
                                <label for="title_prefix" style="color: #8A6B52; font-weight: 700; font-size: 11px; text-transform: uppercase;">Gelar Depan</label>
                                <input id="title_prefix" name="title_prefix" type="text" value="{{ old('title_prefix') }}" placeholder="drg." style="border-bottom: 1px solid #C58F59;">
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                            <div class="ms-field">
                                <label for="job_title" style="color: #8A6B52; font-weight: 700; font-size: 11px; text-transform: uppercase;">Jabatan</label>
                                <input id="job_title" name="job_title" type="text" value="{{ old('job_title') }}" style="border-bottom: 1px solid #C58F59;">
                            </div>
                            <div class="ms-field">
                                <label for="specialization" style="color: #8A6B52; font-weight: 700; font-size: 11px; text-transform: uppercase;">Spesialisasi</label>
                                <input id="specialization" name="specialization" type="text" value="{{ old('specialization') }}" style="border-bottom: 1px solid #C58F59;">
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                            <div class="ms-field">
                                <label for="estimasi_konsultasi" style="color: #8A6B52; font-weight: 700; font-size: 11px; text-transform: uppercase;">Estimasi (Menit)</label>
                                <input id="estimasi_konsultasi" name="estimasi_konsultasi" type="number" value="{{ old('estimasi_konsultasi', 15) }}" style="border-bottom: 1px solid #C58F59;">
                            </div>
                            <div class="ms-field">
                                <label for="default_fee_percentage" style="color: #8A6B52; font-weight: 700; font-size: 11px; text-transform: uppercase;">Fee Dokter Default (%)</label>
                                <input id="default_fee_percentage" name="default_fee_percentage" type="number" step="0.01" min="0" max="100" value="{{ old('default_fee_percentage', 0) }}" style="border-bottom: 1px solid #C58F59;">
                            </div>
                        </div>

                        {{-- SOSIAL MEDIA --}}
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                            <div class="ms-field">
                                <label for="instagram_url" style="color: #8A6B52; font-weight: 700; font-size: 11px; text-transform: uppercase;">
                                    <i class="fa-brands fa-instagram" style="margin-right: 4px;"></i> Instagram
                                </label>
                                <input id="instagram_url" name="instagram_url" type="text" value="{{ old('instagram_url') }}" placeholder="@username atau URL" style="border-bottom: 1px solid #C58F59;">
                            </div>
                            <div class="ms-field">
                                <label for="linkedin_url" style="color: #8A6B52; font-weight: 700; font-size: 11px; text-transform: uppercase;">
                                    <i class="fa-brands fa-linkedin" style="margin-right: 4px;"></i> LinkedIn
                                </label>
                                <input id="linkedin_url" name="linkedin_url" type="text" value="{{ old('linkedin_url') }}" placeholder="URL atau username" style="border-bottom: 1px solid #C58F59;">
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                            {{-- Placeholder TTD Digital --}}
                            <div class="ms-field">
                                <label style="font-size: 11px; color: #8A6B52; font-weight: 700; margin-bottom: 5px; display: block; text-transform: uppercase;">TTD Digital</label>
                                <div id="box-ttd" style="width: 100%; height: 45px; border: 2px dashed #C58F59; border-radius: 8px; background: #fdfaf8; display: flex; align-items: center; justify-content: center; overflow: hidden; position: relative;">
                                    <i class="fa fa-signature" id="icon-ttd" style="color: #d2b48c; font-size: 18px;"></i>
                                    <img id="ttd-preview" style="display:none; width: 100%; height: 100%; object-fit: contain; position: absolute; inset: 0; background: white;">
                                </div>
                                <input id="ttd" name="ttd" type="file" accept="image/*" style="font-size: 11px; margin-top: 5px; color: #8A6B52;" onchange="previewImage(this, 'ttd-preview', 'icon-ttd', 'box-ttd')">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- KOLOM KANAN: JADWAL PRAKTEK --}}
                <div style="flex: 1; background: #fcfcfc; padding: 15px; border-radius: 8px; border: 1px solid #f0f0f0;">
                    <h4 class="ms-section-title" style="margin-top: 0; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #C58F59; color: #8A6B52; font-weight: 800; letter-spacing: 0.5px; text-transform: uppercase; font-size: 14px;">
                        <i class="fa fa-calendar-alt" style="margin-right: 8px; color: #C58F59;"></i> Jadwal Praktek
                    </h4>

                    <div style="display: flex; flex-direction: column; gap: 10px;">
                        @php
                            $days = ['monday' => 'Senin', 'tuesday' => 'Selasa', 'wednesday' => 'Rabu', 'thursday' => 'Kamis', 'friday' => 'Jumat', 'saturday' => 'Sabtu', 'sunday' => 'Minggu'];
                        @endphp
                        @foreach($days as $dayKey => $dayLabel)
                            <div style="display: flex; align-items: center; justify-content: space-between; padding-bottom: 8px; border-bottom: 1px dashed #eee;">
                                <label style="font-weight: bold; font-size: 13px; min-width: 100px; display: flex; align-items: center; cursor: pointer; color: #4b5563;">
                                    <input type="checkbox" 
                                        name="schedules[{{ $dayKey }}][is_active]" 
                                        value="1" 
                                        {{ old("schedules.$dayKey.is_active") ? 'checked' : '' }}
                                        style="margin-right: 12px; width: 16px; height: 16px; accent-color: #C58F59; cursor: pointer;">
                                    {{ $dayLabel }}
                                </label>
                                
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <input type="time" name="schedules[{{ $dayKey }}][start_time]" value="{{ old("schedules.$dayKey.start_time") }}" data-day="{{ $dayKey }}" data-kind="start" 
                                        style="padding: 4px 6px; border: 1px solid #e2e8f0; border-radius: 4px; font-size: 12px; outline: none; transition: border-color 0.2s;"
                                        onfocus="this.style.borderColor='#C58F59'" onblur="this.style.borderColor='#e2e8f0'">
                                    
                                    <span style="color: #94a3b8; font-weight: bold;">-</span>
                                    
                                    <input type="time" name="schedules[{{ $dayKey }}][end_time]" value="{{ old("schedules.$dayKey.end_time") }}" data-day="{{ $dayKey }}" data-kind="end" 
                                        style="padding: 4px 6px; border: 1px solid #e2e8f0; border-radius: 4px; font-size: 12px; outline: none; transition: border-color 0.2s;"
                                        onfocus="this.style.borderColor='#C58F59'" onblur="this.style.borderColor='#e2e8f0'">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- SECTION LEGALITAS (DI BAWAH - FULL WIDTH) --}}
            <section class="ms-section" style="padding: 20px; border-top: 1px solid #f0f0f0;">
                <h4 class="ms-section-title" style="margin-top: 0; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #C58F59; color: #8A6B52; font-weight: 800; text-transform: uppercase; font-size: 13px;">
                    <i class="fa fa-file-medical" style="margin-right: 8px; color: #C58F59;"></i> Legalitas (STR, SIP, Lisensi)
                </h4>
                
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px;">
                    
                    {{-- BARIS 1 --}}
                    <div class="ms-field">
                        <label for="license_no" style="font-size: 11px; color: #8A6B52; font-weight: 700; text-transform: uppercase;">Nomor Lisensi Klinik</label>
                        <input id="license_no" name="license_no" type="text" value="{{ old('license_no') }}" placeholder="Contoh: L-001" style="border-bottom: 1px solid #C58F59;">
                    </div>
                    <div class="ms-field">
                        <label for="str_number" style="font-size: 11px; color: #8A6B52; font-weight: 700; text-transform: uppercase;">Nomor STR *</label>
                        <input id="str_number" name="str_number" type="text" value="{{ old('str_number') }}" placeholder="Input nomor STR" style="border-bottom: 1px solid #C58F59;">
                    </div>
                    <div class="ms-field">
                        <label for="sip_number" style="font-size: 11px; color: #8A6B52; font-weight: 700; text-transform: uppercase;">Nomor SIP</label>
                        <input id="sip_number" name="sip_number" type="text" value="{{ old('sip_number') }}" placeholder="Input nomor SIP" style="border-bottom: 1px solid #C58F59;">
                    </div>

                    {{-- BARIS 2 --}}
                    <div class="ms-field">
                        {{-- Spacer --}}
                    </div>
                    <div class="ms-field">
                        <label for="str_institution" style="font-size: 11px; color: #8A6B52; font-weight: 700; text-transform: uppercase;">Instansi STR</label>
                        <input id="str_institution" name="str_institution" type="text" value="{{ old('str_institution') }}" placeholder="Contoh: KKI" style="border-bottom: 1px solid #C58F59;">
                    </div>
                    <div class="ms-field">
                        <label for="sip_institution" style="font-size: 11px; color: #8A6B52; font-weight: 700; text-transform: uppercase;">Instansi SIP</label>
                        <input id="sip_institution" name="sip_institution" type="text" value="{{ old('sip_institution') }}" placeholder="Contoh: Dinkes" style="border-bottom: 1px solid #C58F59;">
                    </div>

                    {{-- BARIS 3 --}}
                    <div class="ms-field">
                        {{-- Spacer --}}
                    </div>
                    <div class="ms-field">
                        <label for="str_expiry_date" style="font-size: 11px; color: #8A6B52; font-weight: 700; text-transform: uppercase;">Masa Berlaku STR</label>
                        <input id="str_expiry_date" name="str_expiry_date" type="date" value="{{ old('str_expiry_date') }}" style="border-bottom: 1px solid #C58F59; color: #8A6B52;">
                    </div>
                    <div class="ms-field">
                        <label for="sip_expiry_date" style="font-size: 11px; color: #8A6B52; font-weight: 700; text-transform: uppercase;">Masa Berlaku SIP</label>
                        <input id="sip_expiry_date" name="sip_expiry_date" type="date" value="{{ old('sip_expiry_date') }}" style="border-bottom: 1px solid #C58F59; color: #8A6B52;">
                    </div>

                </div>
            </section>

            <div class="ms-modal-actions" style="padding: 20px; background: #f9f9f9;">
                <button type="button" class="ms-btn-filter" id="ms-cancel-doctor-modal">Batal</button>
                <button type="submit" class="ms-btn-primary">SIMPAN DATA TENAGA MEDIS</button>
            </div>
        </form>
    </div>
</div>

<script>
    (function () {
        const modal = document.getElementById('ms-doctor-modal');
        const openBtn = document.getElementById('ms-open-doctor-modal');
        const closeBtn = document.getElementById('ms-close-doctor-modal');
        const cancelBtn = document.getElementById('ms-cancel-doctor-modal');
        const doctorForm = document.getElementById('ms-doctor-form');

        const setupPreview = (inputId, previewId) => {
            const input = document.getElementById(inputId);
            const preview = document.getElementById(previewId);
            if (!input) return;
            input.addEventListener('change', () => {
                const file = input.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = (e) => { preview.src = e.target.result; preview.style.display = 'block'; };
                    reader.readAsDataURL(file);
                }
            });
        };
        setupPreview('foto_profil', 'foto-profil-preview');

        const toggleModal = (show) => {
            modal.classList.toggle('show', show);
            document.body.classList.toggle('ms-modal-open', show);
        };

        openBtn?.addEventListener('click', () => toggleModal(true));
        [closeBtn, cancelBtn].forEach(btn => btn?.addEventListener('click', () => toggleModal(false)));

        doctorForm?.addEventListener('submit', (e) => {
            let valid = true;
            doctorForm.querySelectorAll('input[type="checkbox"]:checked').forEach(cb => {
                const day = cb.name.match(/schedules\[(.+?)\]/)[1];
                const start = doctorForm.querySelector(`input[data-day="${day}"][data-kind="start"]`);
                const end = doctorForm.querySelector(`input[data-day="${day}"][data-kind="end"]`);
                if (!start.value || !end.value) {
                    start.setCustomValidity('Wajib isi jam!');
                    valid = false;
                } else if (end.value <= start.value) {
                    end.setCustomValidity('Selesai harus setelah mulai!');
                    valid = false;
                } else {
                    start.setCustomValidity(''); end.setCustomValidity('');
                }
            });
            if (!valid) { e.preventDefault(); doctorForm.reportValidity(); }
        });

        @if($errors->has('doctor_create') || $errors->any()) toggleModal(true); @endif
    })();

    function previewImage(input, imgId, iconId, boxId) {
        const preview = document.getElementById(imgId);
        const icon = document.getElementById(iconId);
        const box = document.getElementById(boxId);

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
                icon.style.display = 'none';
                box.style.borderColor = '#C58F59';
                box.style.background = '#fff';
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.style.display = 'none';
            icon.style.display = 'block';
            box.style.borderColor = '#ddd';
            box.style.background = '#f9f9f9';
        }
    }
</script>