{{-- resources/views/admin/components/settings/partials/doctor_edit_modal.blade.php --}}

<div id="ms-doctor-edit-modal" class="ms-modal-overlay" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center;">
    <div class="ms-modal-card" style="background: white; width: 90%; max-width: 1000px; border-radius: 12px; overflow: hidden; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);">
        
        <div class="ms-modal-header" style="padding: 20px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #eee;">
            <h3 style="color: #8A6B52; font-weight: 800; margin: 0; text-transform: uppercase; font-size: 18px;">
                <i class="fa fa-user-edit" style="margin-right: 8px; color: #C58F59;"></i> Edit Tenaga Medis
            </h3>
            <button type="button" onclick="closeEditModal()" style="background: none; border: none; font-size: 24px; cursor: pointer; color: #ccc;">&times;</button>
        </div>

        <form id="ms-doctor-edit-form" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" id="edit-doctor-id">

            <div id="edit-modal-content" style="max-height: 70vh; overflow-y: auto;">
                {{-- CONTAINER ATAS (PROFIL & JADWAL) --}}
                <div style="display: flex; gap: 30px; padding: 20px; border-bottom: 1px solid #eee;">
                    
                    {{-- KOLOM KIRI: PROFIL --}}
                    <div style="flex: 1;">
                        <h4 style="margin-top: 0; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #C58F59; color: #8A6B52; font-weight: 800; text-transform: uppercase; font-size: 13px;">
                            <i class="fa fa-user-md" style="margin-right: 8px; color: #C58F59;"></i> Profil Tenaga Medis
                        </h4>

                        <div class="ms-form-grid" style="display: flex; flex-direction: column; gap: 12px;">
                            <div style="display: flex; gap: 15px; align-items: flex-start;">
                                <div class="ms-field">
                                    <label style="font-size: 11px; color: #8A6B52; font-weight: 700; margin-bottom: 5px; display: block; text-transform: uppercase;">Foto Profil</label>
                                    <div id="edit-box-foto" style="width: 100px; height: 120px; border: 2px dashed #C58F59; border-radius: 8px; background: #fdfaf8; display: flex; align-items: center; justify-content: center; overflow: hidden; position: relative;">
                                        <i class="fa fa-camera" id="edit-icon-foto" style="color: #d2b48c; font-size: 24px;"></i>
                                        <img id="edit-foto-profil-preview" style="display:none; width: 100%; height: 100%; object-fit: cover; position: absolute; inset: 0;">
                                    </div>
                                    <input name="foto_profil" type="file" accept="image/*" style="font-size: 11px; margin-top: 5px; width: 100px; color: #8A6B52;" onchange="previewImage(this, 'edit-foto-profil-preview', 'edit-icon-foto', 'edit-box-foto')">
                                </div>
                                <div style="flex: 1; display: flex; flex-direction: column; gap: 12px;">
                                    <div class="ms-field">
                                        <label style="color: #8A6B52; font-weight: 700; font-size: 11px; text-transform: uppercase;">Nama Lengkap *</label>
                                        <input id="edit_full_name" name="full_name" type="text" required style="width:100%; border:none; border-bottom: 1px solid #C58F59; outline:none; padding:5px 0;">
                                    </div>
                                    <div class="ms-field">
                                        <label style="color: #8A6B52; font-weight: 700; font-size: 11px; text-transform: uppercase;">Email Kontak</label>
                                        <input id="edit_email" name="email" type="email" style="width:100%; border:none; border-bottom: 1px solid #C58F59; outline:none; padding:5px 0;">
                                    </div>
                                </div>
                            </div>

                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                                <div class="ms-field">
                                    <label style="color: #8A6B52; font-weight: 700; font-size: 11px; text-transform: uppercase;">Nomor HP</label>
                                    <input id="edit_phone_number" name="phone_number" type="text" style="width:100%; border:none; border-bottom: 1px solid #C58F59; outline:none; padding:5px 0;">
                                </div>
                                <div class="ms-field">
                                    <label style="color: #8A6B52; font-weight: 700; font-size: 11px; text-transform: uppercase;">Gelar Depan</label>
                                    <input id="edit_title_prefix" name="title_prefix" type="text" style="width:100%; border:none; border-bottom: 1px solid #C58F59; outline:none; padding:5px 0;">
                                </div>
                            </div>

                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                                <div class="ms-field">
                                    <label style="color: #8A6B52; font-weight: 700; font-size: 11px; text-transform: uppercase;">Jabatan</label>
                                    <input id="edit_job_title" name="job_title" type="text" style="width:100%; border:none; border-bottom: 1px solid #C58F59; outline:none; padding:5px 0;">
                                </div>
                                <div class="ms-field">
                                    <label style="color: #8A6B52; font-weight: 700; font-size: 11px; text-transform: uppercase;">Spesialisasi</label>
                                    <input id="edit_specialization" name="specialization" type="text" style="width:100%; border:none; border-bottom: 1px solid #C58F59; outline:none; padding:5px 0;">
                                </div>
                            </div>

                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                                <div class="ms-field">
                                    <label style="color: #8A6B52; font-weight: 700; font-size: 11px; text-transform: uppercase;">Estimasi (Menit)</label>
                                    <input id="edit_estimasi_konsultasi" name="estimasi_konsultasi" type="number" style="width:100%; border:none; border-bottom: 1px solid #C58F59; outline:none; padding:5px 0;">
                                </div>
                                <div class="ms-field">
                                    <label style="color: #8A6B52; font-weight: 700; font-size: 11px; text-transform: uppercase;">Fee Dokter Default (%)</label>
                                    <input id="edit_default_fee_percentage" name="default_fee_percentage" type="number" step="0.01" min="0" max="100" style="width:100%; border:none; border-bottom: 1px solid #C58F59; outline:none; padding:5px 0;">
                                </div>
                            </div>

                            {{-- SOSIAL MEDIA --}}
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                                <div class="ms-field">
                                    <label style="color: #8A6B52; font-weight: 700; font-size: 11px; text-transform: uppercase;">
                                        <i class="fa-brands fa-instagram" style="margin-right: 4px;"></i> Instagram
                                    </label>
                                    <input id="edit_instagram_url" name="instagram_url" type="text" placeholder="@username atau URL" style="width:100%; border:none; border-bottom: 1px solid #C58F59; outline:none; padding:5px 0;">
                                </div>
                                <div class="ms-field">
                                    <label style="color: #8A6B52; font-weight: 700; font-size: 11px; text-transform: uppercase;">
                                        <i class="fa-brands fa-linkedin" style="margin-right: 4px;"></i> LinkedIn
                                    </label>
                                    <input id="edit_linkedin_url" name="linkedin_url" type="text" placeholder="URL atau username" style="width:100%; border:none; border-bottom: 1px solid #C58F59; outline:none; padding:5px 0;">
                                </div>
                            </div>

                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                                <div class="ms-field">
                                    <label style="font-size: 11px; color: #8A6B52; font-weight: 700; margin-bottom: 5px; display: block; text-transform: uppercase;">TTD Digital</label>
                                    <div id="edit-box-ttd" style="width: 100%; height: 45px; border: 2px dashed #C58F59; border-radius: 8px; background: #fdfaf8; display: flex; align-items: center; justify-content: center; overflow: hidden; position: relative;">
                                        <i class="fa fa-signature" id="edit-icon-ttd" style="color: #d2b48c; font-size: 18px;"></i>
                                        <img id="edit-ttd-preview" style="display:none; width: 100%; height: 100%; object-fit: contain; position: absolute; inset: 0; background: white;">
                                    </div>
                                    <input name="ttd" type="file" accept="image/*" style="font-size: 11px; margin-top: 5px; color: #8A6B52;" onchange="previewImage(this, 'edit-ttd-preview', 'edit-icon-ttd', 'edit-box-ttd')">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- KOLOM KANAN: JADWAL --}}
                    <div style="flex: 1; background: #fcfcfc; padding: 15px; border-radius: 8px; border: 1px solid #f0f0f0;">
                        <h4 style="margin-top: 0; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #C58F59; color: #8A6B52; font-weight: 800; text-transform: uppercase; font-size: 13px;">
                            <i class="fa fa-calendar-alt" style="margin-right: 8px; color: #C58F59;"></i> Jadwal Praktek
                        </h4>
                        <div id="edit-schedule-container" style="display: flex; flex-direction: column; gap: 10px;">
                            {{-- Diisi via JS --}}
                        </div>
                    </div>
                </div>

                {{-- SECTION LEGALITAS (3 KOLOM) --}}
                <section style="padding: 20px;">
                    <h4 style="margin-top: 0; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #C58F59; color: #8A6B52; font-weight: 800; text-transform: uppercase; font-size: 13px;">
                        <i class="fa fa-file-medical" style="margin-right: 8px; color: #C58F59;"></i> Legalitas (STR, SIP, Lisensi)
                    </h4>
                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px;">
                        <div class="ms-field">
                            <label style="font-size: 11px; color: #8A6B52; font-weight: 700; text-transform: uppercase;">No. Lisensi</label>
                            <input id="edit_license_no" name="license_no" type="text" style="width:100%; border:none; border-bottom: 1px solid #C58F59; outline:none; padding:5px 0;">
                        </div>
                        <div class="ms-field">
                            <label style="font-size: 11px; color: #8A6B52; font-weight: 700; text-transform: uppercase;">No. STR</label>
                            <input id="edit_str_number" name="str_number" type="text" style="width:100%; border:none; border-bottom: 1px solid #C58F59; outline:none; padding:5px 0;">
                        </div>
                        <div class="ms-field">
                            <label style="font-size: 11px; color: #8A6B52; font-weight: 700; text-transform: uppercase;">No. SIP</label>
                            <input id="edit_sip_number" name="sip_number" type="text" style="width:100%; border:none; border-bottom: 1px solid #C58F59; outline:none; padding:5px 0;">
                        </div>

                        <div class="ms-field"></div>
                        <div class="ms-field">
                            <label style="font-size: 11px; color: #8A6B52; font-weight: 700; text-transform: uppercase;">Instansi STR</label>
                            <input id="edit_str_institution" name="str_institution" type="text" style="width:100%; border:none; border-bottom: 1px solid #C58F59; outline:none; padding:5px 0;">
                        </div>
                        <div class="ms-field">
                            <label style="font-size: 11px; color: #8A6B52; font-weight: 700; text-transform: uppercase;">Instansi SIP</label>
                            <input id="edit_sip_institution" name="sip_institution" type="text" style="width:100%; border:none; border-bottom: 1px solid #C58F59; outline:none; padding:5px 0;">
                        </div>

                        <div class="ms-field"></div>
                        <div class="ms-field">
                            <label style="font-size: 11px; color: #8A6B52; font-weight: 700; text-transform: uppercase;">Masa Berlaku STR</label>
                            <input id="edit_str_expiry_date" name="str_expiry_date" type="date" style="width:100%; border:none; border-bottom: 1px solid #C58F59; outline:none; padding:5px 0; color:#8A6B52;">
                        </div>
                        <div class="ms-field">
                            <label style="font-size: 11px; color: #8A6B52; font-weight: 700; text-transform: uppercase;">Masa Berlaku SIP</label>
                            <input id="edit_sip_expiry_date" name="sip_expiry_date" type="date" style="width:100%; border:none; border-bottom: 1px solid #C58F59; outline:none; padding:5px 0; color:#8A6B52;">
                        </div>
                    </div>
                </section>
            </div>

            <div class="ms-modal-actions" style="padding: 20px; background: #f9f9f9; display: flex; justify-content: space-between; align-items: center;">
                <button type="button" onclick="deleteDoctor()" class="ms-btn-delete" style="background: #ef4444; color: white; border: none; padding: 10px 20px; border-radius: 8px; cursor: pointer; font-weight: bold;">
                    <i class="fa fa-trash"></i> HAPUS DATA
                </button>
                <div style="display: flex; gap: 10px;">
                    <button type="button" onclick="closeEditModal()" class="ms-btn-filter" style="padding: 10px 20px; border-radius: 8px; border: 1px solid #ddd; background: white; cursor: pointer;">BATAL</button>
                    <button type="submit" class="ms-btn-primary" style="background: #8A6B52; color: white; border: none; padding: 10px 30px; border-radius: 8px; cursor: pointer; font-weight: bold;">UPDATE DATA</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function normalizeDateInput(value) {
        if (!value) return '';
        if (/^\d{4}-\d{2}-\d{2}$/.test(value)) return value;
        const date = new Date(value);
        if (Number.isNaN(date.getTime())) return '';
        return date.toISOString().slice(0, 10);
    }

    function closeEditModal() {
        document.getElementById('ms-doctor-edit-modal').style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    function openEditModal(doctorId) {
        const modal = document.getElementById('ms-doctor-edit-modal');
        modal.style.setProperty('display', 'flex', 'important');
        document.body.style.overflow = 'hidden';

        fetch(`/admin/settings/doctor/${doctorId}`)
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    const d = data.doctor;
                    document.getElementById('edit-doctor-id').value = d.id;
                    
                    // Profil
                    document.getElementById('edit_full_name').value = d.full_name;
                    document.getElementById('edit_email').value = d.email || '';
                    document.getElementById('edit_phone_number').value = d.phone_number || '';
                    document.getElementById('edit_title_prefix').value = d.title_prefix || '';
                    document.getElementById('edit_job_title').value = d.job_title || '';
                    document.getElementById('edit_specialization').value = d.specialization || '';
                    document.getElementById('edit_estimasi_konsultasi').value = d.estimasi_konsultasi;
                    document.getElementById('edit_default_fee_percentage').value = d.default_fee_percentage ?? 0;

                    // Sosial Media
                    document.getElementById('edit_instagram_url').value = d.instagram_url || '';
                    document.getElementById('edit_linkedin_url').value = d.linkedin_url || '';
                    
                    // Legalitas
                    document.getElementById('edit_license_no').value = d.license_no || '';
                    document.getElementById('edit_str_number').value = d.str_number || '';
                    document.getElementById('edit_sip_number').value = d.sip_number || '';
                    document.getElementById('edit_str_institution').value = d.str_institution || '';
                    document.getElementById('edit_sip_institution').value = d.sip_institution || '';
                    document.getElementById('edit_str_expiry_date').value = normalizeDateInput(d.str_expiry_date);
                    document.getElementById('edit_sip_expiry_date').value = normalizeDateInput(d.sip_expiry_date);

                    // Foto & TTD
                    if(d.foto_profil) setupEditPreview('edit-foto-profil-preview', 'edit-icon-foto', 'edit-box-foto', d.foto_profil);
                    if(d.ttd) setupEditPreview('edit-ttd-preview', 'edit-icon-ttd', 'edit-box-ttd', d.ttd);

                    renderEditSchedule(d.schedules);
                }
            });
    }

    function setupEditPreview(imgId, iconId, boxId, path) {
        const img = document.getElementById(imgId);
        const icon = document.getElementById(iconId);
        const box = document.getElementById(boxId);
        img.src = '/storage/' + path;
        img.style.display = 'block';
        icon.style.display = 'none';
        box.style.background = '#fff';
    }

    function renderEditSchedule(schedules) {
        const container = document.getElementById('edit-schedule-container');
        const days = { monday: 'Senin', tuesday: 'Selasa', wednesday: 'Rabu', thursday: 'Kamis', friday: 'Jumat', saturday: 'Sabtu', sunday: 'Minggu' };
        container.innerHTML = '';

        Object.keys(days).forEach(dayKey => {
            const sch = schedules.find(s => s.day === dayKey);
            const isActive = sch ? 'checked' : '';
            const startTime = sch ? sch.start_time.substring(0,5) : '';
            const endTime = sch ? sch.end_time.substring(0,5) : '';

            container.innerHTML += `
                <div style="display: flex; align-items: center; justify-content: space-between; padding-bottom: 8px; border-bottom: 1px dashed #eee;">
                    <label style="font-weight: bold; font-size: 13px; min-width: 100px; display: flex; align-items: center; color: #4b5563;">
                        <input type="checkbox" name="schedules[${dayKey}][is_active]" value="1" ${isActive} style="margin-right: 12px; accent-color: #C58F59;">
                        ${days[dayKey]}
                    </label>
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <input type="time" name="schedules[${dayKey}][start_time]" value="${startTime}" style="padding: 4px; border: 1px solid #e2e8f0; border-radius: 4px; font-size: 12px;">
                        <span>-</span>
                        <input type="time" name="schedules[${dayKey}][end_time]" value="${endTime}" style="padding: 4px; border: 1px solid #e2e8f0; border-radius: 4px; font-size: 12px;">
                    </div>
                </div>`;
        });
    }

    document.getElementById('ms-doctor-edit-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const id = document.getElementById('edit-doctor-id').value;
        const formData = new FormData(this);
        
        fetch(`/admin/settings/doctor/${id}`, {
            method: 'POST',
            body: formData,
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                alert('Data berhasil diperbarui!');
                location.reload();
            } else {
                alert('Gagal: ' + data.message);
            }
        });
    });

    function deleteDoctor() {
        if(confirm('Yakin ingin menghapus data ini?')) {
            const id = document.getElementById('edit-doctor-id').value;
            fetch(`/admin/settings/doctor/${id}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    alert('Data dihapus.');
                    location.reload();
                }
            });
        }
    }
</script>