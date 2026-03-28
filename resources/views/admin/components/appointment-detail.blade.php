{{-- Modal Detail Janji Temu --}}
<style>
    /* ==========================================================================
       MODAL CONTAINER (Lebih halus & premium)
       ========================================================================== */
    .ad-modal-content {
        background: var(--white);
        border-radius: 8px; /* Radius dikurangi agar tidak terlalu membulat */
        border: 1px solid var(--cream-200);
        width: 100%;
        max-width: 440px;
        font-family: 'Instrument Sans', sans-serif;
        box-shadow: 0 10px 30px rgba(88, 44, 12, 0.08);
        display: flex;
        flex-direction: column;
    }

    /* ==========================================================================
       TOP BAR (Sejajar, tidak menumpuk)
       ========================================================================== */
    .ad-top-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px 24px 8px;
    }

    .ad-top-left {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .ad-code-badge {
        font-size: 12px;
        font-weight: 600;
        color: var(--gold-400);
        letter-spacing: 0.05em;
        text-transform: uppercase;
    }

    .ad-top-right {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .ad-status-text {
        font-size: 13px;
        font-weight: 600;
        color: var(--gold-400);
    }

    .ad-icon-action {
        background: none;
        border: none;
        color: #cbbdad;
        cursor: pointer;
        padding: 4px;
        border-radius: 4px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all var(--transition);
    }
    .ad-icon-action:hover {
        color: var(--gold-500);
        background: var(--cream-50);
    }
    .ad-icon-close:hover {
        color: var(--req-star);
        background: #fef2f2;
    }

    /* ==========================================================================
       PATIENT HEADER (Hierarki jelas)
       ========================================================================== */
    .ad-header-section {
        padding: 0 24px 20px;
    }

    .ad-name-wrapper {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 8px;
    }

    .ad-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background-color: var(--gold-400);
        box-shadow: 0 0 0 3px rgba(197, 143, 89, 0.15);
    }

    .ad-name {
        font-size: 22px;
        font-weight: 700;
        color: var(--brown-700);
        margin: 0;
        line-height: 1.2;
    }

    .ad-mr-wrapper {
        display: flex;
        align-items: center;
        gap: 10px;
        padding-left: 20px;
        margin-bottom: 12px;
    }

    .ad-mr-number {
        font-size: 15px;
        font-weight: 600;
        color: var(--brown-700);
        margin-right: 6px;
    }

    .ad-pill-btn {
        background: var(--white);
        border: 1px solid var(--cream-200);
        color: var(--brown-600);
        border-radius: 6px;
        padding: 4px 10px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.05em;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        height: 26px;
        transition: all var(--transition);
        box-shadow: 0 1px 2px rgba(88, 44, 12, 0.02);
    }
    .ad-pill-btn:hover {
        border-color: var(--gold-400);
        color: var(--gold-500);
        background: var(--cream-50);
    }

    .ad-demo-text {
        font-size: 13px;
        color: #9e8e7d;
        padding-left: 20px;
        font-weight: 400;
        line-height: 1.6; /* Tambahan jarak baca */
    }

    /* ==========================================================================
       BODY SECTION (Aksen Visual & Kerapian)
       ========================================================================== */
    .ad-body-section {
        background: var(--cream-50);
        padding: 24px;
        border-top: 1px dashed var(--cream-200);
        border-bottom: 1px solid var(--cream-100);
    }

    .ad-schedule-card {
        border-left: 3px solid var(--gold-400);
        padding-left: 14px;
        margin-bottom: 28px;
    }

    .ad-schedule-text {
        font-size: 14px;
        line-height: 1.8; /* Jarak antar baris diperlebar */
        color: var(--brown-600);
    }
    .ad-schedule-text strong {
        color: var(--brown-900);
        font-weight: 700;
        font-size: 15px;
    }
    .ad-schedule-sub {
        font-size: 13px;
        line-height: 1.6;
        color: #9e8e7d;
        margin-top: 6px;
    }

    .ad-meta-wrapper {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .ad-meta-info {
        font-size: 13px;
        line-height: 1.8; /* Jarak antar baris diperlebar */
        color: #9e8e7d;
    }
    .ad-meta-info span {
        color: var(--brown-600);
        font-weight: 500;
    }

    .ad-consent-btn {
        background: var(--white);
        border: 1px solid var(--cream-200);
        border-radius: 8px;
        padding: 10px 14px;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 6px;
        cursor: pointer;
        transition: all var(--transition);
        box-shadow: 0 2px 6px rgba(88, 44, 12, 0.04);
    }
    .ad-consent-btn:hover {
        border-color: var(--gold-400);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(88, 44, 12, 0.08);
    }
    .ad-consent-text {
        font-size: 10px;
        font-weight: 700;
        color: var(--brown-700);
        text-align: center;
        line-height: 1.4;
        letter-spacing: 0.02em;
    }

    /* ==========================================================================
       FOOTER ACTIONS & DROPDOWN WRAPPER
       ========================================================================== */
    .ad-footer {
        padding: 16px 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: var(--white);
    }

    .ad-btn-medical {
        background: transparent;
        border: 1.5px solid var(--cream-200);
        color: var(--brown-600);
        border-radius: 8px;
        padding: 8px 16px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all var(--transition);
    }
    .ad-btn-medical:hover {
        border-color: var(--gold-400);
        color: var(--gold-500);
        background: var(--cream-50);
    }

    /* Wrapper untuk Dropdown agar posisinya relatif terhadap tombol */
    .ad-status-wrapper {
        position: relative;
        display: inline-block;
    }

    .ad-btn-engage {
        background: var(--gold-400);
        color: var(--white);
        border: none;
        border-radius: 8px;
        padding: 8px 16px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 2px 8px rgba(197, 143, 89, 0.25);
        transition: all var(--transition);
    }
    .ad-btn-engage:hover {
        background: var(--gold-500);
        box-shadow: 0 4px 12px rgba(197, 143, 89, 0.35);
        transform: translateY(-1px);
    }
    
    .ad-status-dropdown-menu {
        display: none;
        position: absolute;
        bottom: calc(100% + 8px); /* Selalu menempel 8px di atas tombol */
        right: 0;                 /* Rata ke sebelah kanan tombol */
        background: var(--white);
        border-radius: 8px;
        box-shadow: 0 10px 25px rgba(88, 44, 12, 0.1);
        border: 1px solid var(--cream-200);
        z-index: 1010;
        padding: 6px;
        min-width: 150px;
    }
    .ad-status-dropdown-menu .dropdown-item {
        display: block;
        width: 100%;
        padding: 10px 14px;
        text-align: left;
        border: none;
        background: none;
        font-size: 13px;
        font-weight: 500;
        color: var(--brown-700);
        cursor: pointer;
        border-radius: 6px;
        transition: background 0.2s;
    }
    .ad-status-dropdown-menu .dropdown-item:hover {
        background: var(--cream-50);
        color: var(--gold-500);
    }
</style>

<div id="modalAppointmentDetail" class="reg-modal-overlay">
    <div class="ad-modal-content">

        {{-- Top Bar (Sejajar Kiri - Kanan) --}}
        <div class="ad-top-bar">
            <div class="ad-top-left">
                <span class="ad-code-badge">Code: SQKR9Y</span>
                <button class="ad-icon-action" title="Copy Code">
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="9" y="9" width="13" height="13" rx="2" ry="2" /><path d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1" /></svg>
                </button>
                <button class="ad-icon-action" title="Copy Link">
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M10 13a5 5 0 007.54.54l3-3a5 5 0 00-7.07-7.07l-1.72 1.71" /><path d="M14 11a5 5 0 00-7.54-.54l-3 3a5 5 0 007.07 7.07l1.71-1.71" /></svg>
                </button>
            </div>
            
            <div class="ad-top-right">
                <span class="ad-status-text" id="ad_status_text">Engaged</span>
                <button class="ad-icon-action ad-icon-close" onclick="closeRegModal('modalAppointmentDetail')" title="Tutup">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M18 6L6 18M6 6l12 12" /></svg>
                </button>
            </div>
        </div>

        {{-- Patient Header --}}
        <div class="ad-header-section">
            <div class="ad-name-wrapper">
                <div class="ad-dot"></div>
                <h2 class="ad-name" id="ad_patient_name">Kama</h2>
                <div style="margin-left: auto; display: flex; gap: 4px;">
                    <button class="ad-icon-action" title="Edit">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 3a2.828 2.828 0 114 4L7.5 20.5 2 22l1.5-5.5L17 3z" /></svg>
                    </button>
                    <button class="ad-icon-action" title="Print">
                        <svg width="17" height="17" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="6 9 6 2 18 2 18 9" /><path d="M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2" /><rect x="6" y="14" width="12" height="8" /></svg>
                    </button>
                </div>
            </div>

            <div class="ad-mr-wrapper">
                <span class="ad-mr-number" id="ad_mr_number">MR000025</span>
                <button class="ad-pill-btn">LABEL</button>
                <button class="ad-pill-btn" style="padding: 4px 8px;" title="Download">
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4" /><polyline points="7 10 12 15 17 10" /><line x1="12" y1="15" x2="12" y2="3" /></svg>
                </button>
            </div>

            <div class="ad-demo-text">
                Laki - laki &nbsp;&nbsp; 13 Tahun 10 Bulan 28 Hari
            </div>
        </div>

        {{-- Body Section --}}
        <div class="ad-body-section">
            <div class="ad-schedule-card">
                <div class="ad-schedule-text">
                    <strong id="ad_appointment_time">14:45 WIB</strong> dengan <span id="ad_doctor_name">drg. Ria Budiati Sp. Ortho</span>
                </div>
                <div class="ad-schedule-sub">
                    Perkiraan lama konsultasi selama 10 menit
                </div>
            </div>

            <div class="ad-meta-wrapper">
                <div class="ad-meta-info">
                    Metode Pembayaran: <span>Tunai</span><br>
                    Dibuat Oleh: <span>Sonia Novitasari</span><br>
                    Dibuat Jam: <span>14:51 WIB</span>
                </div>

                <button type="button" class="ad-consent-btn">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4" /><polyline points="17 8 12 3 7 8" /><line x1="12" y1="3" x2="12" y2="15" /></svg>
                    <div class="ad-consent-text">GENERAL<br>CONSENT</div>
                </button>
            </div>
        </div>

        {{-- Footer Section --}}
        <div class="ad-footer">
            <button type="button" class="ad-btn-medical">Lihat Rekam Medis</button>

            {{-- Wrapper Dropdown --}}
            <div class="ad-status-wrapper">
                <button type="button" class="ad-btn-engage" onclick="toggleStatusDropdown()">
                    <span id="ad_btn_status_text">Engaged</span>
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                </button>

                {{-- Status Dropdown Menu --}}
                <div id="ad_status_dropdown" class="ad-status-dropdown-menu">
                    <button class="dropdown-item" onclick="updateAppointmentStatus('pending')">Pending</button>
                    <button class="dropdown-item" onclick="updateAppointmentStatus('confirmed')">Confirmed</button>
                    <button class="dropdown-item" onclick="updateAppointmentStatus('waiting')">Waiting</button>
                    <button class="dropdown-item" onclick="updateAppointmentStatus('engaged')">Engaged</button>
                    <button class="dropdown-item" onclick="updateAppointmentStatus('succeed')">Succeed</button>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    let currentAppointmentId = null;

    function openApptDetailModal(id, patientName, mrNumber, treatment, time, doctorName, status) {
        currentAppointmentId = id;
        document.getElementById('ad_patient_name').textContent = patientName;
        document.getElementById('ad_mr_number').textContent = mrNumber || '-';
        document.getElementById('ad_appointment_time').textContent = time || '-';
        
        if (doctorName) {
            const adDoctorName = document.getElementById('ad_doctor_name');
            if (adDoctorName) adDoctorName.textContent = doctorName;
        }

        if (status) {
            const statusCapitalized = status.charAt(0).toUpperCase() + status.slice(1);
            const statusText = document.getElementById('ad_status_text');
            const btnStatusText = document.getElementById('ad_btn_status_text');
            if (statusText) statusText.textContent = statusCapitalized;
            if (btnStatusText) btnStatusText.textContent = statusCapitalized;
        }
        
        openRegModal('modalAppointmentDetail');
    }

    function toggleStatusDropdown() {
        const dropdown = document.getElementById('ad_status_dropdown');
        if (!dropdown) return;
        dropdown.style.display = (dropdown.style.display === 'none' || dropdown.style.display === '') ? 'block' : 'none';
    }

    function updateAppointmentStatus(status) {
        if (!currentAppointmentId) return;

        fetch(`/admin/appointments/${currentAppointmentId}/status`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ status: status })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Gagal memperbarui status: ' + (data.message || 'Error tidak diketahui'));
            }
        })
        .catch(error => console.error('Error:', error));
    }
</script>