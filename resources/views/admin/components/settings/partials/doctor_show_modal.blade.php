{{-- resources/views/admin/components/settings/partials/doctor_show_modal.blade.php --}}

<div id="ms-doctor-show-modal" class="ms-modal-overlay" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center;">
    <div class="ms-modal-card" style="background: white; width: 90%; max-width: 1000px; border-radius: 12px; overflow: hidden; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);">
        
        {{-- Header --}}
        <div class="ms-modal-header" style="padding: 20px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #eee;">
            <h3 style="color: #8A6B52; font-weight: 800; margin: 0; text-transform: uppercase; font-size: 18px;">
                <i class="fa fa-info-circle" style="margin-right: 8px; color: #C58F59;"></i> Detail Tenaga Medis
            </h3>
            <button type="button" onclick="closeShowModal()" style="background: none; border: none; font-size: 24px; cursor: pointer; color: #ccc;">&times;</button>
        </div>

        <div id="show-modal-content" style="max-height: 85vh; overflow-y: auto;">
            {{-- Konten Utama (Akan diisi via AJAX) --}}
            <div style="padding: 40px; text-align: center;">
                <i class="fa fa-spinner fa-spin" style="font-size: 30px; color: #C58F59;"></i>
                <p style="color: #8A6B52;">Memuat data tenaga medis...</p>
            </div>
        </div>
    </div>
</div>

<script>
    function closeShowModal() {
        document.getElementById('ms-doctor-show-modal').style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    function openShowModal(doctorId) {
        const modal = document.getElementById('ms-doctor-show-modal');
        const content = document.getElementById('show-modal-content');
        
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';

        fetch(`/admin/settings/doctor/${doctorId}`)
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    renderDoctorDetail(data.doctor);
                } else {
                    content.innerHTML = '<div style="padding:40px; text-align:center; color:red;">Gagal memuat data.</div>';
                }
            })
            .catch(error => {
                content.innerHTML = '<div style="padding:40px; text-align:center; color:red;">Terjadi kesalahan koneksi.</div>';
            });
    }

    function renderDoctorDetail(doctor) {
        const content = document.getElementById('show-modal-content');
        
        // Render List Jadwal
        let scheduleHtml = '';
        const dayNames = { monday: 'Senin', tuesday: 'Selasa', wednesday: 'Rabu', thursday: 'Kamis', friday: 'Jumat', saturday: 'Sabtu', sunday: 'Minggu' };
        
        // Buat urutan indeks untuk sorting dari Senin (1) ke Minggu (7)
        const dayOrder = { monday: 1, tuesday: 2, wednesday: 3, thursday: 4, friday: 5, saturday: 6, sunday: 7 };
        
        if(doctor.schedules && doctor.schedules.length > 0) {
            
            // LAKUKAN SORTING DI SINI SEBELUM DI-LOOPING
            doctor.schedules.sort((a, b) => {
                let orderA = dayOrder[a.day.toLowerCase()] || 99; // 99 jika nama hari tidak valid
                let orderB = dayOrder[b.day.toLowerCase()] || 99;
                return orderA - orderB;
            });

            doctor.schedules.forEach(s => {
                scheduleHtml += `
                    <div style="display: flex; align-items: center; justify-content: space-between; padding-bottom: 8px; border-bottom: 1px dashed #eee; margin-bottom: 8px;">
                        <span style="font-weight: bold; font-size: 13px; color: #4b5563;">${dayNames[s.day.toLowerCase()] || s.day}</span>
                        <div style="color: #8A6B52; font-weight: bold; font-size: 13px;">
                            ${s.start_time.substring(0,5)} - ${s.end_time.substring(0,5)}
                        </div>
                    </div>`;
            });
        } else {
            scheduleHtml = '<p style="color: #ccc; font-style: italic; text-align: center;">Tidak ada jadwal praktek.</p>';
        }

        content.innerHTML = `
            {{-- CONTAINER ATAS: PROFIL & JADWAL --}}
            <div style="display: flex; gap: 30px; padding: 20px; border-bottom: 1px solid #eee;">
                
                {{-- KOLOM KIRI: PROFIL --}}
                <div style="flex: 1;">
                    <h4 style="margin-top: 0; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #C58F59; color: #8A6B52; font-weight: 800; text-transform: uppercase; font-size: 13px;">
                        <i class="fa fa-user-md" style="margin-right: 8px; color: #C58F59;"></i> Profil Tenaga Medis
                    </h4>
                    
                    <div style="display: flex; flex-direction: column; gap: 15px;">
                        <div style="display: flex; gap: 20px; align-items: flex-start;">
                            <div style="width: 100px; height: 130px; border: 2px solid #C58F59; border-radius: 8px; overflow: hidden; background: #fdfaf8;">
                                <img src="${doctor.foto_profil ? '/storage/'+doctor.foto_profil : 'https://ui-avatars.com/api/?name='+doctor.full_name+'&background=fdfaf8&color=8A6B52'}" 
                                     style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                            <div style="flex: 1; display: flex; flex-direction: column; gap: 10px;">
                                <div>
                                    <label style="font-size: 10px; color: #8A6B52; font-weight: 700; text-transform: uppercase; display:block;">Nama Lengkap</label>
                                    <div style="font-size: 15px; color: #333; font-weight: bold; border-bottom: 1px solid #C58F59; padding-bottom: 4px;">
                                        ${doctor.title_prefix ? doctor.title_prefix + ' ' : ''}${doctor.full_name}
                                    </div>
                                </div>
                                <div>
                                    <label style="font-size: 10px; color: #8A6B52; font-weight: 700; text-transform: uppercase; display:block;">Email Kontak</label>
                                    <div style="font-size: 14px; color: #555; border-bottom: 1px solid #C58F59; padding-bottom: 4px;">${doctor.email || '-'}</div>
                                </div>
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                            <div>
                                <label style="font-size: 10px; color: #8A6B52; font-weight: 700; text-transform: uppercase; display:block;">Nomor HP</label>
                                <div style="font-size: 14px; color: #555; border-bottom: 1px solid #C58F59; padding-bottom: 4px;">${doctor.phone_number || '-'}</div>
                            </div>
                            <div>
                                <label style="font-size: 10px; color: #8A6B52; font-weight: 700; text-transform: uppercase; display:block;">Jabatan</label>
                                <div style="font-size: 14px; color: #555; border-bottom: 1px solid #C58F59; padding-bottom: 4px;">${doctor.job_title || '-'}</div>
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                            <div>
                                <label style="font-size: 10px; color: #8A6B52; font-weight: 700; text-transform: uppercase; display:block;">Spesialisasi</label>
                                <div style="font-size: 14px; color: #555; border-bottom: 1px solid #C58F59; padding-bottom: 4px;">${doctor.specialization || '-'}</div>
                            </div>
                            <div>
                                <label style="font-size: 10px; color: #8A6B52; font-weight: 700; text-transform: uppercase; display:block;">Estimasi Konsultasi</label>
                                <div style="font-size: 14px; color: #555; border-bottom: 1px solid #C58F59; padding-bottom: 4px;">${doctor.estimasi_konsultasi} Menit</div>
                            </div>
                        </div>

                        <div style="margin-top: 10px;">
                            <label style="font-size: 10px; color: #8A6B52; font-weight: 700; text-transform: uppercase; display:block; margin-bottom:5px;">Tanda Tangan Digital</label>
                            <div style="width: 150px; height: 60px; border: 1px solid #C58F59; border-radius: 6px; padding: 5px; background: white;">
                                ${doctor.ttd ? `<img src="/storage/${doctor.ttd}" style="width:100%; height:100%; object-fit:contain;">` : '<span style="color:#ccc; font-size:11px;">Tidak ada TTD</span>'}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- KOLOM KANAN: JADWAL --}}
                <div style="flex: 0.8; background: #fcfcfc; padding: 20px; border-radius: 8px; border: 1px solid #f0f0f0;">
                    <h4 style="margin-top: 0; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #C58F59; color: #8A6B52; font-weight: 800; text-transform: uppercase; font-size: 13px;">
                        <i class="fa fa-calendar-alt" style="margin-right: 8px; color: #C58F59;"></i> Jadwal Praktek
                    </h4>
                    <div style="display: flex; flex-direction: column;">
                        ${scheduleHtml}
                    </div>
                </div>
            </div>

            {{-- SECTION BAWAH: LEGALITAS (3 KOLOM) --}}
            <section style="padding: 25px;">
                <h4 style="margin-top: 0; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #C58F59; color: #8A6B52; font-weight: 800; text-transform: uppercase; font-size: 13px;">
                    <i class="fa fa-file-medical" style="margin-right: 8px; color: #C58F59;"></i> Legalitas (STR, SIP, Lisensi)
                </h4>
                
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;">
                    {{-- BARIS 1 --}}
                    <div>
                        <label style="font-size: 10px; color: #8A6B52; font-weight: 700; text-transform: uppercase; display:block;">Nomor Lisensi Klinik</label>
                        <div style="font-size: 14px; color: #555; border-bottom: 1px solid #C58F59; padding-bottom: 4px;">${doctor.license_no || '-'}</div>
                    </div>
                    <div>
                        <label style="font-size: 10px; color: #8A6B52; font-weight: 700; text-transform: uppercase; display:block;">Nomor STR</label>
                        <div style="font-size: 14px; color: #555; border-bottom: 1px solid #C58F59; padding-bottom: 4px;">${doctor.str_number || '-'}</div>
                    </div>
                    <div>
                        <label style="font-size: 10px; color: #8A6B52; font-weight: 700; text-transform: uppercase; display:block;">Nomor SIP</label>
                        <div style="font-size: 14px; color: #555; border-bottom: 1px solid #C58F59; padding-bottom: 4px;">${doctor.sip_number || '-'}</div>
                    </div>

                    {{-- BARIS 2 --}}
                    <div></div> {{-- Spacer --}}
                    <div>
                        <label style="font-size: 10px; color: #8A6B52; font-weight: 700; text-transform: uppercase; display:block;">Instansi STR</label>
                        <div style="font-size: 14px; color: #555; border-bottom: 1px solid #C58F59; padding-bottom: 4px;">${doctor.str_institution || '-'}</div>
                    </div>
                    <div>
                        <label style="font-size: 10px; color: #8A6B52; font-weight: 700; text-transform: uppercase; display:block;">Instansi SIP</label>
                        <div style="font-size: 14px; color: #555; border-bottom: 1px solid #C58F59; padding-bottom: 4px;">${doctor.sip_institution || '-'}</div>
                    </div>

                    {{-- BARIS 3 --}}
                    <div></div> {{-- Spacer --}}
                    <div>
                        <label style="font-size: 10px; color: #8A6B52; font-weight: 700; text-transform: uppercase; display:block;">Masa Berlaku STR</label>
                        <div style="font-size: 14px; color: #555; border-bottom: 1px solid #C58F59; padding-bottom: 4px;">${doctor.str_expiry_date || '-'}</div>
                    </div>
                    <div>
                        <label style="font-size: 10px; color: #8A6B52; font-weight: 700; text-transform: uppercase; display:block;">Masa Berlaku SIP</label>
                        <div style="font-size: 14px; color: #555; border-bottom: 1px solid #C58F59; padding-bottom: 4px;">${doctor.sip_expiry_date || '-'}</div>
                    </div>
                </div>
            </section>
        `;
    }
</script>