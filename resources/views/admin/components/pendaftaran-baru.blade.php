<div class="reg-modal-overlay" id="modalPendaftaranBaru">
    <div class="reg-modal-content">
        <button type="button" class="modal-close-btn" onclick="closeRegModal('modalPendaftaranBaru')">
            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

    <h1 class="page-title">Daftar Kunjungan</h1>

    {{-- Alert utama form --}}
    <div id="pendBaruAlert" style="display:none; margin-bottom:16px; padding:12px 16px; border-radius:8px; font-size:13px;"></div>

    <div class="form-card">

        {{-- Header Row --}}
        <div class="search-header-row">
            <div class="search-group-wrapper">
                <div class="search-input-box">
                    <label>Cari Pasien</label>
                    <div class="input-with-clear">
                        <input type="text" id="patientSearchInput" placeholder="Ketik nama atau nomor MR..." autocomplete="off">
                        <button type="button" class="btn-clear" onclick="clearPatientSearch()">
                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                    <div id="patientSearchResults" style="display:none; position:absolute; top:100%; left:0; right:0; background:white; border:1px solid #E5D6C5; border-radius:8px; z-index:100; max-height:200px; overflow-y:auto; box-shadow:0 4px 12px rgba(88,44,12,0.1);"></div>
                </div>
                <button type="button" class="btn-solid" onclick="searchPatient()">Cari</button>
            </div>
            <div class="req-notice">Tanda <span>*</span> wajib diisi!</div>
        </div>

        {{-- Patient Info --}}
        <div class="patient-info-container" id="patientInfoContainer" style="display:none;">
            <div class="patient-info-card">
                <div class="patient-photo" id="pbPhotoWrapper"
                     style="cursor:pointer; position:relative;"
                     onclick="document.getElementById('pbPhotoFileInput').click()"
                     title="Klik untuk upload/ganti foto">
                    <img id="patientPhotoImg" src="" alt="Foto Pasien"
                         style="display:none; width:100%; height:100%; object-fit:cover; border-radius:50%;">
                    <svg id="patientPhotoPlaceholder" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                    <div id="pbPhotoOverlay" style="display:none; position:absolute; inset:0; border-radius:50%; background:rgba(0,0,0,0.45); align-items:center; justify-content:center; pointer-events:none;">
                        <i class="fas fa-camera" style="color:white; font-size:20px;"></i>
                    </div>
                </div>
                <div style="text-align:center; font-size:10px; color:#C58F59; margin-top:4px; cursor:pointer;" onclick="document.getElementById('pbPhotoFileInput').click()">
                    Upload Foto
                </div>
                <div class="patient-details">
                    <div class="detail-label">Nama Lengkap</div>  <div class="detail-value" id="pi_name">-</div>
                    <div class="detail-label">Tanggal Lahir</div> <div class="detail-value" id="pi_dob">-</div>
                    <div class="detail-label">Jenis Kelamin</div> <div class="detail-value" id="pi_gender">-</div>
                    <div class="detail-label">Alamat</div>        <div class="detail-value" id="pi_address">-</div>
                    <div class="detail-label">Nomor KTP</div>     <div class="detail-value" id="pi_id_card">-</div>
                    <div class="detail-label">Nomor HP</div>      <div class="detail-value" id="pi_phone">-</div>
                </div>
            </div>
        </div>

        {{-- Patient Actions --}}
        <div class="patient-actions" id="patientActions" style="display:none;">
            <button type="button" class="btn-outline" onclick="togglePatientInfo()">
                <span id="toggleText">Sembunyikan </span>
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path id="toggleIconPath" stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7"></path>
                </svg>
            </button>
        </div>

        {{-- Main Form --}}
        <form id="pendaftaranBaruForm">
            @csrf
            <input type="hidden" name="patient_id" id="selected_patient_id">
            <input type="hidden" name="photo_base64" id="pb_photo_base64" value="">
            <input type="file" id="pbPhotoFileInput" accept="image/*" style="display:none;">

            <div class="form-section">

                <div class="grid-1">
                    <div class="form-group">
                        <label class="form-label">Tipe Pasien</label>
                        <select name="patient_type" class="input-pill">
                            <option value="non_rujuk">Pasien Non Rujuk</option>
                            <option value="rujuk">Pasien Rujuk</option>
                        </select>
                    </div>
                </div>

                <div class="grid-2" style="margin-bottom: 40px;">
                    <div class="form-group">
                        <label class="form-label">Penjamin <span class="req">*</span></label>
                        <select name="guarantor_type_id" class="input-pill">
                            <option value="">-- Pilih Penjamin --</option>
                            @isset($guarantorTypes)
                                @foreach($guarantorTypes as $gt)
                                    <option value="{{ $gt->id }}">{{ $gt->name }}</option>
                                @endforeach
                            @endisset
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Metode Pembayaran <span class="req">*</span></label>
                        <select name="payment_method_id" class="input-pill">
                            <option value="">-- Pilih Metode Bayar --</option>
                            @isset($paymentMethods)
                                @foreach($paymentMethods as $pm)
                                    <option value="{{ $pm->id }}">{{ $pm->name }}</option>
                                @endforeach
                            @endisset
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Jenis Kunjungan <span class="req">*</span></label>
                        <select name="visit_type_id" class="input-pill">
                            <option value="">-- Pilih Jenis Kunjungan --</option>
                            @isset($visitTypes)
                                @foreach($visitTypes as $vt)
                                    <option value="{{ $vt->id }}">{{ $vt->name }}</option>
                                @endforeach
                            @endisset
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Jenis Perawatan <span class="req">*</span></label>
                        <select name="care_type_id" class="input-pill">
                            <option value="">-- Pilih Jenis Perawatan --</option>
                            @isset($careTypes)
                                @foreach($careTypes as $ct)
                                    <option value="{{ $ct->id }}">{{ $ct->name }}</option>
                                @endforeach
                            @endisset
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Nomor HP</label>
                        <input type="text" name="phone_number" class="input-line">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Alamat Email</label>
                        <input type="email" name="email" class="input-line">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Poli <span class="req">*</span></label>
                        <select name="poli_id" class="input-pill" id="pb_poli_id">
                            <option value="">-- Pilih Poli --</option>
                            @isset($polis)
                                @foreach($polis as $poli)
                                    <option value="{{ $poli->id }}">{{ $poli->name }}</option>
                                @endforeach
                            @endisset
                        </select>
                        <span id="err_poli_id" style="color:#e05252;font-size:11px;display:none;"></span>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Tenaga Medis <span class="req">*</span></label>
                        <select name="doctor_id" class="input-pill" id="pb_doctor_id">
                            <option value="">-- Pilih Dokter --</option>
                            @isset($doctors)
                                @foreach($doctors as $doctor)
                                    <option value="{{ $doctor->id }}">{{ $doctor->full_title }}</option>
                                @endforeach
                            @endisset
                        </select>
                        <span id="err_doctor_id" style="color:#e05252;font-size:11px;display:none;"></span>
                        {{-- Info ringkasan jadwal dokter --}}
                        <div id="pb_doctor_schedule_info" style="display:none; margin-top:6px; padding:8px 10px; background:#fdf8f4; border:1px solid #E5D6C5; border-radius:6px; font-size:11px; color:#8A6B52; line-height:1.8;"></div>
                    </div>

                    {{-- TANGGAL --}}
                    <div class="form-group" style="margin-bottom:10px;">
                        <label class="form-label">Tanggal <span class="req">*</span></label>
                        <div class="input-icon-wrapper" id="pb_date_wrapper">
                            <input type="date" name="appointment_date" class="input-line" id="pb_appointment_date" value="{{ date('Y-m-d') }}">
                            <svg class="icon-right" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                            </svg>
                        </div>
                        <span id="err_appointment_date" style="color:#e05252;font-size:11px;display:none;"></span>
                        <div id="pb_date_schedule_warning" style="display:none; margin-top:5px; padding:8px 10px; border-radius:5px; font-size:11px;"></div>
                    </div>

                    {{-- JAM --}}
                    <div class="form-group" style="margin-bottom:10px;">
                        <label class="form-label">Jam <span class="req">*</span></label>
                        <div class="input-icon-wrapper" id="pb_time_wrapper">
                            <input type="time" name="appointment_time" class="input-line" id="pb_appointment_time">
                        </div>
                        <span id="err_appointment_time" style="color:#e05252;font-size:11px;display:none;"></span>
                        <div id="pb_time_schedule_warning" style="display:none; margin-top:5px; padding:8px 10px; border-radius:5px; font-size:11px;"></div>
                    </div>

                    <div class="form-group" style="margin-bottom:10px;">
                        <label class="form-label">Lama Durasi</label>
                        <div class="input-flex-wrapper">
                            <input type="number" name="duration_minutes" class="input-line" value="30" min="1" max="480">
                            <span class="input-suffix">menit</span>
                        </div>
                    </div>
                </div>

                <div class="simple-line-group">
                    <label class="simple-line-label">Keluhan</label>
                    <input type="text" name="complaint" class="input-line">
                </div>
                <div class="simple-line-group">
                    <label class="simple-line-label">Prosedur Rencana</label>
                    <input type="text" name="procedure_plan" class="input-line">
                </div>
                <div class="simple-line-group">
                    <label class="simple-line-label">Informasi Kondisi Pasien</label>
                    <input type="text" name="patient_condition" class="input-line">
                </div>

                {{-- Blok error jadwal yang jelas di atas tombol simpan --}}
                <div id="pb_schedule_block_error" style="display:none; margin-top:20px; padding:14px 16px; background:#fef2f2; border:1.5px solid #fca5a5; border-radius:8px; color:#991b1b; font-size:13px; line-height:1.6;">
                    <div style="font-weight:700; margin-bottom:4px; display:flex; align-items:center; gap:6px;">
                        <i class="fas fa-ban"></i> Pendaftaran Tidak Dapat Disimpan
                    </div>
                    <div id="pb_schedule_block_error_msg"></div>
                </div>

                <div style="display:flex; justify-content:flex-end; gap:12px; margin-top:20px;">
                    <button type="button" class="btn-outline" onclick="closeRegModal('modalPendaftaranBaru')">Batal</button>
                    <button type="submit" class="btn-solid" id="pendBaruSubmitBtn">Simpan Pendaftaran</button>
                </div>

            </div>
        </form>
    </div>
</div>

{{-- CROPPER MODAL --}}
<div id="pbCropperModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.7); z-index:10001; align-items:center; justify-content:center;">
    <div style="background:white; padding:20px; border-radius:12px; max-width:500px; width:90%; box-shadow:0 20px 60px rgba(0,0,0,0.4);">
        <h3 style="margin:0 0 14px 0; font-size:16px; color:#2C1810;">Atur Foto Profil</h3>
        <canvas id="pbCropperCanvas" style="border:1px solid #E5D6C5; width:100%; max-height:380px; display:block; margin-bottom:14px; background:#111; border-radius:6px;"></canvas>
        <div style="display:flex; gap:10px;">
            <button type="button" onclick="pbCloseCropperModal()" style="flex:1; padding:10px; background:#E5D6C5; border:none; border-radius:6px; cursor:pointer; font-size:14px; color:#2C1810;">Batal</button>
            <button type="button" onclick="pbApplyCrop()" style="flex:1; padding:10px; background:#2C8659; color:white; border:none; border-radius:6px; cursor:pointer; font-size:14px; font-weight:600;"><i class="fas fa-check"></i> Gunakan Foto Ini</button>
        </div>
    </div>
</div>

<script>
(function () {

    /* ============================================================
       STATE
    ============================================================ */
    let pbCropper = {
        image: null, origW: 0, origH: 0,
        frameX: undefined, frameY: undefined,
        frameSize: 200, dragging: false,
    };

    // null  = dokter belum dipilih / fetch belum selesai
    // {}    = dokter dipilih tapi tidak punya jadwal aktif
    // { monday: {start, end}, ... } = jadwal terisi
    let pbDoctorSchedules = null;

    // Flag: apakah saat ini ada pelanggaran jadwal yang hard-block?
    let pbScheduleBlocked = false;

    const DAY_MAP   = ['sunday','monday','tuesday','wednesday','thursday','friday','saturday'];
    const DAY_LABEL = { monday:'Senin', tuesday:'Selasa', wednesday:'Rabu', thursday:'Kamis', friday:'Jumat', saturday:'Sabtu', sunday:'Minggu' };

    /* ============================================================
       HOVER FOTO
    ============================================================ */
    const pbPhotoWrapper = document.getElementById('pbPhotoWrapper');
    const pbPhotoOverlay = document.getElementById('pbPhotoOverlay');
    if (pbPhotoWrapper && pbPhotoOverlay) {
        pbPhotoWrapper.addEventListener('mouseenter', () => pbPhotoOverlay.style.display = 'flex');
        pbPhotoWrapper.addEventListener('mouseleave', () => pbPhotoOverlay.style.display = 'none');
    }

    /* ============================================================
       CROPPER
    ============================================================ */
    document.getElementById('pbPhotoFileInput').addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = (evt) => {
            const img = new Image();
            img.onload = () => {
                pbCropper.image  = img;
                pbCropper.origW  = img.width;
                pbCropper.origH  = img.height;
                pbCropper.frameX = undefined;
                pbCropper.frameY = undefined;
                pbOpenCropperModal();
            };
            img.src = evt.target.result;
        };
        reader.readAsDataURL(file);
        this.value = '';
    });

    window.pbOpenCropperModal = function () {
        document.getElementById('pbCropperModal').style.display = 'flex';
        setTimeout(() => { pbRenderCanvas(); pbAttachCanvasEvents(); }, 80);
    };
    window.pbCloseCropperModal = function () {
        document.getElementById('pbCropperModal').style.display = 'none';
    };

    function pbRenderCanvas() {
        const canvas = document.getElementById('pbCropperCanvas');
        if (!canvas || !pbCropper.image) return;
        const img = pbCropper.image;
        let dw = Math.min(img.width, 460), dh = (img.height / img.width) * dw;
        if (dh > 380) { dh = 380; dw = (img.width / img.height) * dh; }
        dw = Math.round(dw); dh = Math.round(dh);
        canvas.width = dw; canvas.height = dh;
        if (pbCropper.frameX === undefined) {
            pbCropper.frameX    = dw / 2;
            pbCropper.frameY    = dh / 2;
            pbCropper.frameSize = Math.min(200, dw - 20, dh - 20);
        }
        const ctx = canvas.getContext('2d'), half = pbCropper.frameSize / 2;
        ctx.drawImage(img, 0, 0, dw, dh);
        ctx.save();
        ctx.fillStyle = 'rgba(0,0,0,0.52)'; ctx.fillRect(0, 0, dw, dh);
        ctx.globalCompositeOperation = 'destination-out';
        ctx.beginPath(); ctx.arc(pbCropper.frameX, pbCropper.frameY, half, 0, Math.PI*2); ctx.fill();
        ctx.restore();
        ctx.save();
        ctx.beginPath(); ctx.arc(pbCropper.frameX, pbCropper.frameY, half, 0, Math.PI*2); ctx.clip();
        ctx.drawImage(img, 0, 0, dw, dh); ctx.restore();
        ctx.strokeStyle = '#C58F59'; ctx.lineWidth = 2.5;
        ctx.beginPath(); ctx.arc(pbCropper.frameX, pbCropper.frameY, half, 0, Math.PI*2); ctx.stroke();
    }

    function pbAttachCanvasEvents() {
        const canvas = document.getElementById('pbCropperCanvas');
        if (!canvas) return;
        canvas.replaceWith(canvas.cloneNode(true));
        const c = document.getElementById('pbCropperCanvas');
        function move(cx, cy) {
            const r = c.getBoundingClientRect();
            const half = pbCropper.frameSize / 2;
            pbCropper.frameX = Math.max(half, Math.min(c.width  - half, (cx - r.left) * (c.width  / r.width)));
            pbCropper.frameY = Math.max(half, Math.min(c.height - half, (cy - r.top)  * (c.height / r.height)));
            pbRenderCanvas();
        }
        c.addEventListener('mousedown',  ()  => { pbCropper.dragging = true; });
        c.addEventListener('mousemove',  (e) => { if (pbCropper.dragging) move(e.clientX, e.clientY); });
        c.addEventListener('mouseup',    ()  => { pbCropper.dragging = false; });
        c.addEventListener('mouseleave', ()  => { pbCropper.dragging = false; });
        c.addEventListener('touchstart', (e) => { pbCropper.dragging = true;  e.preventDefault(); }, { passive:false });
        c.addEventListener('touchmove',  (e) => { if (!pbCropper.dragging) return; e.preventDefault(); move(e.touches[0].clientX, e.touches[0].clientY); }, { passive:false });
        c.addEventListener('touchend',   ()  => { pbCropper.dragging = false; });
    }

    window.pbApplyCrop = function () {
        const canvas = document.getElementById('pbCropperCanvas');
        if (!canvas || !pbCropper.image) return;
        const size = pbCropper.frameSize;
        const out  = document.createElement('canvas');
        out.width  = out.height = size;
        const ctx  = out.getContext('2d');
        const sx   = pbCropper.origW / canvas.width, sy = pbCropper.origH / canvas.height;
        ctx.drawImage(pbCropper.image, (pbCropper.frameX - size/2)*sx, (pbCropper.frameY - size/2)*sy, size*sx, size*sy, 0, 0, size, size);
        ctx.globalCompositeOperation = 'destination-in';
        ctx.beginPath(); ctx.arc(size/2, size/2, size/2, 0, Math.PI*2); ctx.fill();
        const dataUrl = out.toDataURL('image/png');
        document.getElementById('pb_photo_base64').value = dataUrl.split(',')[1];
        const img = document.getElementById('patientPhotoImg'), ph = document.getElementById('patientPhotoPlaceholder');
        if (img) { img.src = dataUrl; img.style.display = 'block'; }
        if (ph)  { ph.style.display = 'none'; }
        pbCloseCropperModal();
    };

    /* ============================================================
       HELPERS JADWAL
    ============================================================ */

    function getDayKeyFromDate(dateStr) {
        if (!dateStr) return null;
        return DAY_MAP[new Date(dateStr + 'T00:00:00').getDay()];
    }

    /**
     * Evaluasi jadwal berdasarkan dokter, tanggal, jam yang terisi.
     * Return: { blocked: bool, reason: string|null }
     *   blocked = true  → tidak boleh disimpan
     *   reason         → kalimat penjelasan untuk ditampilkan ke user
     */
    function evaluateSchedule() {
        const doctorId = document.getElementById('pb_doctor_id').value;
        const dateVal  = document.getElementById('pb_appointment_date').value;
        const timeVal  = document.getElementById('pb_appointment_time').value;

        // Kalau dokter belum dipilih atau jadwal belum di-fetch, tidak ada yang dievaluasi
        if (!doctorId || pbDoctorSchedules === null) return { blocked: false, reason: null };
        // Kalau tanggal / jam belum diisi, juga tidak diblokir dulu
        if (!dateVal) return { blocked: false, reason: null };

        const dayKey   = getDayKeyFromDate(dateVal);
        const dayLabel = DAY_LABEL[dayKey] || dayKey;
        const sch      = pbDoctorSchedules[dayKey];

        // KASUS 1: Hari tidak ada jadwal sama sekali
        if (!sch) {
            return {
                blocked: true,
                reason: `Dokter <strong>tidak berpraktek</strong> pada hari <strong>${dayLabel}</strong>. Silakan pilih tanggal lain sesuai jadwal praktek dokter.`,
            };
        }

        // KASUS 2: Jam diisi tapi di luar range
        if (timeVal && (timeVal < sch.start || timeVal > sch.end)) {
            return {
                blocked: true,
                reason: `Jam <strong>${timeVal}</strong> di luar jam praktek dokter pada hari <strong>${dayLabel}</strong> (<strong>${sch.start} – ${sch.end}</strong>). Pilih jam yang sesuai jadwal.`,
            };
        }

        return { blocked: false, reason: null };
    }

    /** Perbarui semua UI warning/error jadwal sekaligus */
    function updateScheduleUI() {
        const doctorId  = document.getElementById('pb_doctor_id').value;
        const dateVal   = document.getElementById('pb_appointment_date').value;
        const timeVal   = document.getElementById('pb_appointment_time').value;
        const dateWarn  = document.getElementById('pb_date_schedule_warning');
        const timeWarn  = document.getElementById('pb_time_schedule_warning');
        const blockErr  = document.getElementById('pb_schedule_block_error');
        const blockMsg  = document.getElementById('pb_schedule_block_error_msg');
        const submitBtn = document.getElementById('pendBaruSubmitBtn');

        // Reset semua warning dulu
        dateWarn.style.display = 'none';
        timeWarn.style.display = 'none';
        blockErr.style.display = 'none';
        pbScheduleBlocked      = false;

        // Tidak ada dokter / jadwal belum di-fetch
        if (!doctorId || pbDoctorSchedules === null || !dateVal) {
            submitBtn.disabled = false;
            submitBtn.style.opacity = '1';
            return;
        }

        const dayKey   = getDayKeyFromDate(dateVal);
        const dayLabel = DAY_LABEL[dayKey] || dayKey;
        const sch      = pbDoctorSchedules[dayKey];

        // ── HARI TIDAK ADA JADWAL ───────────────────────────────────────
        if (!sch) {
            // Warning merah di bawah field tanggal
            dateWarn.style.cssText = 'display:block; margin-top:5px; padding:8px 10px; border-radius:5px; font-size:11px; background:#fef2f2; color:#991b1b; border:1px solid #fecaca;';
            dateWarn.innerHTML     = `<i class="fas fa-ban"></i> Dokter <strong>tidak berpraktek</strong> pada hari <strong>${dayLabel}</strong>.`;
            timeWarn.style.display = 'none';

            // Block error di atas tombol simpan
            blockMsg.innerHTML     = `Tidak dapat menyimpan pendaftaran karena dokter tidak memiliki jadwal praktek pada hari <strong>${dayLabel}</strong>.<br>Silakan pilih tanggal lain yang sesuai dengan jadwal praktek dokter.`;
            blockErr.style.display = 'block';

            // Disable tombol simpan
            pbScheduleBlocked      = true;
            submitBtn.disabled     = true;
            submitBtn.style.opacity = '0.4';
            submitBtn.style.cursor  = 'not-allowed';
            return;
        }

        // ── HARI ADA JADWAL — tampilkan info hijau ──────────────────────
        dateWarn.style.cssText = 'display:block; margin-top:5px; padding:8px 10px; border-radius:5px; font-size:11px; background:#f0fdf4; color:#166534; border:1px solid #bbf7d0;';
        dateWarn.innerHTML     = `<i class="fas fa-check-circle"></i> Dokter praktek hari <strong>${dayLabel}</strong>: <strong>${sch.start} – ${sch.end}</strong>`;

        // ── CEK JAM ─────────────────────────────────────────────────────
        if (timeVal) {
            if (timeVal < sch.start || timeVal > sch.end) {
                // Warning merah di bawah field jam
                timeWarn.style.cssText = 'display:block; margin-top:5px; padding:8px 10px; border-radius:5px; font-size:11px; background:#fef2f2; color:#991b1b; border:1px solid #fecaca;';
                timeWarn.innerHTML     = `<i class="fas fa-clock"></i> Jam <strong>${timeVal}</strong> di luar jam praktek (<strong>${sch.start} – ${sch.end}</strong>).`;

                // Block error di atas tombol simpan
                blockMsg.innerHTML     = `Tidak dapat menyimpan pendaftaran karena jam <strong>${timeVal}</strong> berada di luar jadwal praktek dokter pada hari <strong>${dayLabel}</strong> (<strong>${sch.start} – ${sch.end}</strong>).<br>Silakan pilih jam yang sesuai.`;
                blockErr.style.display = 'block';

                // Disable tombol simpan
                pbScheduleBlocked      = true;
                submitBtn.disabled     = true;
                submitBtn.style.opacity = '0.4';
                submitBtn.style.cursor  = 'not-allowed';
            } else {
                // Jam valid
                timeWarn.style.cssText = 'display:block; margin-top:5px; padding:8px 10px; border-radius:5px; font-size:11px; background:#f0fdf4; color:#166534; border:1px solid #bbf7d0;';
                timeWarn.innerHTML     = `<i class="fas fa-check-circle"></i> Jam <strong>${timeVal}</strong> sesuai dengan jadwal praktek dokter.`;

                submitBtn.disabled     = false;
                submitBtn.style.opacity = '1';
                submitBtn.style.cursor  = '';
            }
        } else {
            // Jam belum diisi → tidak blokir
            timeWarn.style.display  = 'none';
            submitBtn.disabled      = false;
            submitBtn.style.opacity = '1';
            submitBtn.style.cursor  = '';
        }
    }

    /* ============================================================
       FETCH JADWAL SAAT DOKTER DIPILIH
    ============================================================ */
    document.getElementById('pb_doctor_id').addEventListener('change', async function () {
        const doctorId  = this.value;
        const infoEl    = document.getElementById('pb_doctor_schedule_info');
        const submitBtn = document.getElementById('pendBaruSubmitBtn');

        if (!doctorId) {
            pbDoctorSchedules = null;
            pbScheduleBlocked = false;
            infoEl.style.display = 'none';
            document.getElementById('pb_date_schedule_warning').style.display = 'none';
            document.getElementById('pb_time_schedule_warning').style.display = 'none';
            document.getElementById('pb_schedule_block_error').style.display  = 'none';
            submitBtn.disabled     = false;
            submitBtn.style.opacity = '1';
            submitBtn.style.cursor  = '';
            return;
        }

        // Loading state sementara fetch
        infoEl.innerHTML     = '<i class="fas fa-spinner fa-spin" style="color:#C58F59;"></i> Memuat jadwal...';
        infoEl.style.display = 'block';

        try {
            const res  = await fetch(`/admin/settings/doctor/${doctorId}`, {
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
            });
            const data = await res.json();

            if (data.success && data.doctor?.schedules) {
                pbDoctorSchedules = {};
                data.doctor.schedules.forEach(s => {
                    if (s.is_active) {
                        pbDoctorSchedules[s.day] = {
                            start: s.start_time.substring(0, 5),
                            end:   s.end_time.substring(0, 5),
                        };
                    }
                });

                const activeDays = Object.keys(pbDoctorSchedules);
                if (activeDays.length > 0) {
                    const lines = activeDays
                        .map(d => `<span style="display:inline-block; margin-right:8px;"><strong>${DAY_LABEL[d]}:</strong> ${pbDoctorSchedules[d].start}–${pbDoctorSchedules[d].end}</span>`)
                        .join('');
                    infoEl.innerHTML = `<i class="fas fa-calendar-check" style="color:#C58F59; margin-right:4px;"></i> <strong>Jadwal praktek:</strong><br>${lines}`;
                } else {
                    pbDoctorSchedules = {};
                    infoEl.innerHTML  = `<i class="fas fa-calendar-times" style="color:#e05252; margin-right:4px;"></i> Dokter belum memiliki jadwal praktek aktif.`;
                }
            } else {
                pbDoctorSchedules    = null;
                infoEl.style.display = 'none';
            }
        } catch (err) {
            console.error('[pb] Gagal fetch jadwal dokter:', err);
            pbDoctorSchedules    = null;
            infoEl.style.display = 'none';
        }

        updateScheduleUI();
    });

    document.getElementById('pb_appointment_date').addEventListener('change', updateScheduleUI);
    document.getElementById('pb_appointment_time').addEventListener('change', updateScheduleUI);
    document.getElementById('pb_appointment_time').addEventListener('blur',   updateScheduleUI);

    /* ============================================================
       SEARCH PATIENT
    ============================================================ */
    const searchInput = document.getElementById('patientSearchInput');
    const resultsBox  = document.getElementById('patientSearchResults');
    let searchTimeout;

    searchInput?.addEventListener('keyup', function () {
        clearTimeout(searchTimeout);
        const q = this.value.trim();
        if (q.length < 2) { resultsBox.style.display = 'none'; return; }
        searchTimeout = setTimeout(() => searchPatient(q), 400);
    });

    window.searchPatient = async function (q) {
        q = q || searchInput.value.trim();
        if (!q) return;
        try {
            const res  = await fetch(`{{ route('admin.patients.search') }}?q=${encodeURIComponent(q)}`, {
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
            });
            const data = await res.json();
            if (data.success && data.data.length > 0) {
                resultsBox.innerHTML = data.data.map(p => `
                    <div onclick="selectPatient(${JSON.stringify(p).replace(/"/g, '&quot;')})"
                         style="padding:10px 14px; cursor:pointer; border-bottom:1px solid #f0e8df; font-size:13px;"
                         onmouseover="this.style.background='#fdf8f4'" onmouseout="this.style.background='white'">
                        <strong style="color:#582C0C;">${p.full_name}</strong>
                        <span style="color:#C58F59; margin-left:8px;">${p.medical_record_no}</span>
                    </div>`).join('');
                resultsBox.style.display = 'block';
            } else {
                resultsBox.innerHTML = '<div style="padding:10px 14px; color:#b09a85; font-size:13px;">Pasien tidak ditemukan.</div>';
                resultsBox.style.display = 'block';
            }
        } catch (e) { console.error(e); }
    };

    window.selectPatient = function (p) {
        document.getElementById('selected_patient_id').value = p.id;
        searchInput.value = p.full_name + ' (' + p.medical_record_no + ')';
        resultsBox.style.display = 'none';

        document.getElementById('pi_name').textContent    = p.full_name     || '-';
        document.getElementById('pi_dob').textContent     = p.date_of_birth || '-';
        document.getElementById('pi_gender').textContent  = p.gender === 'Male' ? 'Laki-Laki' : (p.gender === 'Female' ? 'Perempuan' : '-');
        document.getElementById('pi_address').textContent = p.address        || '-';
        document.getElementById('pi_id_card').textContent = p.id_card_number || '-';
        document.getElementById('pi_phone').textContent   = p.phone_number   || '-';

        document.getElementById('pb_photo_base64').value = '';
        const photoImg = document.getElementById('patientPhotoImg');
        const photoPlaceholder = document.getElementById('patientPhotoPlaceholder');
        if (p.photo) {
            photoImg.src           = p.photo.startsWith('data:') ? p.photo : `data:image/png;base64,${p.photo}`;
            photoImg.style.display = 'block';
            photoPlaceholder.style.display = 'none';
        } else {
            photoImg.style.display         = 'none';
            photoPlaceholder.style.display = 'block';
        }

        document.getElementById('patientInfoContainer').style.display = 'block';
        document.getElementById('patientActions').style.display       = 'flex';
    };

    window.clearPatientSearch = function () {
        searchInput.value = '';
        resultsBox.style.display = 'none';
        document.getElementById('selected_patient_id').value  = '';
        document.getElementById('pb_photo_base64').value      = '';
        document.getElementById('patientInfoContainer').style.display = 'none';
        document.getElementById('patientActions').style.display       = 'none';
        const photoImg = document.getElementById('patientPhotoImg');
        const photoPlaceholder = document.getElementById('patientPhotoPlaceholder');
        if (photoImg)         { photoImg.src = ''; photoImg.style.display = 'none'; }
        if (photoPlaceholder) { photoPlaceholder.style.display = 'block'; }
    };

    window.togglePatientInfo = function () {
        const container = document.getElementById('patientInfoContainer');
        const textSpan  = document.getElementById('toggleText');
        const iconPath  = document.getElementById('toggleIconPath');
        if (container.style.display === 'none') {
            container.style.display = 'block';
            textSpan.textContent = 'Sembunyikan ';
            iconPath.setAttribute('d', 'M5 15l7-7 7 7');
        } else {
            container.style.display = 'none';
            textSpan.textContent = 'Tampilkan ';
            iconPath.setAttribute('d', 'M19 9l-7 7-7-7');
        }
    };

    document.addEventListener('click', function (e) {
        if (e.target !== searchInput) resultsBox.style.display = 'none';
    });

    /* ============================================================
       FORM SUBMIT
    ============================================================ */
    document.getElementById('pendaftaranBaruForm').addEventListener('submit', async function (e) {
        e.preventDefault();

        const btn      = document.getElementById('pendBaruSubmitBtn');
        const alertBox = document.getElementById('pendBaruAlert');

        // ── HARD-BLOCK: cek flag jadwal ──────────────────────────────────
        if (pbScheduleBlocked) {
            // Scroll ke pesan error jadwal agar terlihat
            document.getElementById('pb_schedule_block_error').scrollIntoView({ behavior: 'smooth', block: 'center' });
            return; // STOP — tidak kirim request
        }
        // ─────────────────────────────────────────────────────────────────

        const patientId = document.getElementById('selected_patient_id').value;
        if (!patientId) {
            alertBox.style.cssText = 'display:block; margin-bottom:16px; padding:12px 16px; border-radius:8px; font-size:13px; background:#fef2f2; color:#991b1b; border:1px solid #fecaca;';
            alertBox.textContent   = 'Harap pilih pasien terlebih dahulu!';
            return;
        }

        document.querySelectorAll('#pendaftaranBaruForm [id^="err_"]').forEach(el => { el.style.display = 'none'; el.textContent = ''; });
        alertBox.style.display = 'none';
        btn.textContent = 'Menyimpan...';
        btn.disabled    = true;

        const formData = new FormData(this);

        try {
            const res  = await fetch('{{ route('admin.appointments.store') }}', {
                method:  'POST',
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Accept': 'application/json' },
                body:    formData,
            });
            const data = await res.json();

            if (res.ok && data.success) {
                alertBox.style.cssText = 'display:block; margin-bottom:16px; padding:12px 16px; border-radius:8px; font-size:13px; background:#f0fdf4; color:#166534; border:1px solid #bbf7d0;';
                alertBox.textContent   = '✓ ' + data.message;

                localStorage.setItem('emr_refresh_signal', JSON.stringify({ type: 'new_registration', timestamp: Date.now(), appointmentId: data.data?.id }));
                window.dispatchEvent(new CustomEvent('emr_new_registration', { detail: { appointmentId: data.data?.id } }));

                this.reset();
                clearPatientSearch();
                pbDoctorSchedules = null;
                pbScheduleBlocked = false;
                document.getElementById('pb_doctor_schedule_info').style.display  = 'none';
                document.getElementById('pb_date_schedule_warning').style.display = 'none';
                document.getElementById('pb_time_schedule_warning').style.display = 'none';
                document.getElementById('pb_schedule_block_error').style.display  = 'none';
                btn.disabled     = false;
                btn.style.opacity = '1';
                btn.style.cursor  = '';

                setTimeout(() => { closeRegModal('modalPendaftaranBaru'); location.reload(); }, 1500);

            } else if (res.status === 422 && data.errors) {
                Object.entries(data.errors).forEach(([field, msgs]) => {
                    const errEl = document.getElementById('err_' + field);
                    if (errEl) { errEl.textContent = msgs[0]; errEl.style.display = 'block'; }
                });
                alertBox.style.cssText = 'display:block; margin-bottom:16px; padding:12px 16px; border-radius:8px; font-size:13px; background:#fef2f2; color:#991b1b; border:1px solid #fecaca;';
                alertBox.textContent   = 'Mohon periksa kembali isian form.';
                btn.disabled     = false;
                btn.style.opacity = '1';
            } else {
                throw new Error(data.message || 'Terjadi kesalahan server.');
            }
        } catch (err) {
            alertBox.style.cssText = 'display:block; margin-bottom:16px; padding:12px 16px; border-radius:8px; font-size:13px; background:#fef2f2; color:#991b1b; border:1px solid #fecaca;';
            alertBox.textContent   = err.message;
            btn.textContent = 'Simpan Pendaftaran';
            btn.disabled    = false;
            btn.style.opacity = '1';
            btn.style.cursor  = '';
        }
    });

})();
</script>