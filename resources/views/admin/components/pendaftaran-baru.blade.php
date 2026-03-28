<div class="reg-modal-overlay" id="modalPendaftaranBaru">
    <div class="reg-modal-content">
        <button type="button" class="modal-close-btn" onclick="closeRegModal('modalPendaftaranBaru')">
            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

    <h1 class="page-title">Daftar Kunjungan</h1>

    {{-- Alert --}}
    <div id="pendBaruAlert" style="display:none; margin-bottom:16px; padding:12px 16px; border-radius:8px; font-size:13px;"></div>

    <div class="form-card">
        
        {{-- Header Row: Search & Notice --}}
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
                    {{-- Dropdown hasil pencarian --}}
                    <div id="patientSearchResults" style="display:none; position:absolute; top:100%; left:0; right:0; background:white; border:1px solid #E5D6C5; border-radius:8px; z-index:100; max-height:200px; overflow-y:auto; box-shadow:0 4px 12px rgba(88,44,12,0.1);"></div>
                </div>
                <button type="button" class="btn-solid" onclick="searchPatient()">Cari</button>
            </div>
            <div class="req-notice">Tanda <span>*</span> wajib diisi!</div>
        </div>

        {{-- Patient Info Container --}}
        <div class="patient-info-container" id="patientInfoContainer" style="display:none;">
            <div class="patient-info-card">
                <div class="patient-photo">
                    <svg fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
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

        {{-- Main Form Sections --}}
        <form id="pendaftaranBaruForm">
            @csrf
            {{-- Hidden selected patient ID --}}
            <input type="hidden" name="patient_id" id="selected_patient_id">

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
                    </div>

                    <div class="form-group" style="margin-bottom: 10px;">
                        <label class="form-label">Tanggal <span class="req">*</span></label>
                        <div class="input-icon-wrapper">
                            <input type="date" name="appointment_date" class="input-line" id="pb_appointment_date" value="{{ date('Y-m-d') }}">
                            <svg class="icon-right" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                            </svg>
                        </div>
                        <span id="err_appointment_date" style="color:#e05252;font-size:11px;display:none;"></span>
                    </div>
                    <div class="form-group" style="margin-bottom: 10px;">
                        <label class="form-label">Jam <span class="req">*</span></label>
                        <div class="input-icon-wrapper">
                            <input type="time" name="appointment_time" class="input-line" id="pb_appointment_time">
                        </div>
                        <span id="err_appointment_time" style="color:#e05252;font-size:11px;display:none;"></span>
                    </div>

                    <div class="form-group" style="margin-bottom: 10px;">
                        <label class="form-label">Lama Durasi</label>
                        <div class="input-flex-wrapper">
                            <input type="number" name="duration_minutes" class="input-line" value="30" min="1" max="480">
                            <span class="input-suffix">menit</span>
                        </div>
                    </div>
                </div>

                {{-- Additional Inputs --}}
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

                {{-- Submit --}}
                <div style="display:flex; justify-content:flex-end; gap:12px; margin-top:32px;">
                    <button type="button" class="btn-outline" onclick="closeRegModal('modalPendaftaranBaru')">Batal</button>
                    <button type="submit" class="btn-solid" id="pendBaruSubmitBtn">Simpan Pendaftaran</button>
                </div>

            </div>
        </form>
    </div>
    </div>
</div>

<script>
(function() {
    const searchInput = document.getElementById('patientSearchInput');
    const resultsBox  = document.getElementById('patientSearchResults');
    let searchTimeout;

    // Live search on keyup
    searchInput?.addEventListener('keyup', function() {
        clearTimeout(searchTimeout);
        const q = this.value.trim();
        if (q.length < 2) { resultsBox.style.display = 'none'; return; }
        searchTimeout = setTimeout(() => searchPatient(q), 400);
    });

    window.searchPatient = async function(q) {
        q = q || searchInput.value.trim();
        if (!q) return;
        try {
            const res = await fetch(`{{ route('admin.patients.search') }}?q=${encodeURIComponent(q)}`, {
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

    window.selectPatient = function(p) {
        document.getElementById('selected_patient_id').value = p.id;
        searchInput.value = p.full_name + ' (' + p.medical_record_no + ')';
        resultsBox.style.display = 'none';

        // Populate info card
        document.getElementById('pi_name').textContent    = p.full_name || '-';
        document.getElementById('pi_dob').textContent     = p.date_of_birth || '-';
        document.getElementById('pi_gender').textContent  = p.gender === 'Male' ? 'Laki-Laki' : (p.gender === 'Female' ? 'Perempuan' : '-');
        document.getElementById('pi_address').textContent = p.address || '-';
        document.getElementById('pi_id_card').textContent = p.id_card_number || '-';
        document.getElementById('pi_phone').textContent   = p.phone_number || '-';

        document.getElementById('patientInfoContainer').style.display = 'block';
        document.getElementById('patientActions').style.display = 'flex';
    };

    window.clearPatientSearch = function() {
        searchInput.value = '';
        resultsBox.style.display = 'none';
        document.getElementById('selected_patient_id').value = '';
        document.getElementById('patientInfoContainer').style.display = 'none';
        document.getElementById('patientActions').style.display = 'none';
    };

    window.togglePatientInfo = function() {
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

    // Close dropdown on outside click
    document.addEventListener('click', function(e) {
        if (e.target !== searchInput) resultsBox.style.display = 'none';
    });

    // Form submit
    document.getElementById('pendaftaranBaruForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const btn   = document.getElementById('pendBaruSubmitBtn');
        const alert = document.getElementById('pendBaruAlert');

        // Validate patient selected
        const patientId = document.getElementById('selected_patient_id').value;
        if (!patientId) {
            alert.style.background = '#fef2f2';
            alert.style.color = '#991b1b';
            alert.style.border = '1px solid #fecaca';
            alert.textContent = 'Harap pilih pasien terlebih dahulu!';
            alert.style.display = 'block';
            return;
        }

        // Clear errors
        document.querySelectorAll('#pendaftaranBaruForm [id^="err_"]').forEach(el => {
            el.style.display = 'none'; el.textContent = '';
        });
        alert.style.display = 'none';

        btn.textContent = 'Menyimpan...';
        btn.disabled = true;

        const formData = new FormData(this);

        try {
            const res = await fetch('{{ route('admin.appointments.store') }}', {
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
                clearPatientSearch();
                setTimeout(() => {
                    closeRegModal('modalPendaftaranBaru');
                    location.reload(); // Refresh table
                }, 1500);
            } else if (res.status === 422 && data.errors) {
                Object.entries(data.errors).forEach(([field, msgs]) => {
                    const errEl = document.getElementById('err_' + field);
                    if (errEl) { errEl.textContent = msgs[0]; errEl.style.display = 'block'; }
                });
                alert.style.background = '#fef2f2';
                alert.style.color = '#991b1b';
                alert.style.border = '1px solid #fecaca';
                alert.textContent = 'Mohon periksa kembali isian form.';
                alert.style.display = 'block';
            } else {
                throw new Error(data.message || 'Terjadi kesalahan server.');
            }
        } catch (err) {
            alert.style.background = '#fef2f2';
            alert.style.color = '#991b1b';
            alert.style.border = '1px solid #fecaca';
            alert.textContent = err.message;
            alert.style.display = 'block';
        } finally {
            btn.textContent = 'Simpan Pendaftaran';
            btn.disabled = false;
        }
    });
})();
</script>