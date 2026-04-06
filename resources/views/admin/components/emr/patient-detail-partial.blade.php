<style>
    :root {
        --brown-900: #3b331e;
        --brown-800: #57462c;
        --brown-700: #6f5635;
        --brown-600: #8e6a45;
        --brown-500: #b08963;
        --brown-300: #d8c7b2;
        --brown-200: #eadfd3;
        --brown-100: #f7f1ea;
        --brown-50: #fdfaf6;
    }

    /* ================= 1. FORCING FULL WIDTH ================= */
    #emr-detail-view { width: 100% !important; display: block !important; }
    .p-detail-container { width: 100% !important; max-width: 100% !important; display: block; box-sizing: border-box; }

    /* ================= 2. PROFIL HEADER ================= */
    .p-detail-header { width: 100%; padding-bottom: 25px; border-bottom: 1px solid var(--brown-200); margin-bottom: 25px; }
    .p-profile-flex { display: flex; width: 100%; gap: 30px; align-items: flex-start; }
    
    /* Foto Profil Kotak & Diperbesar */
    .p-avatar-square {
        width: 80px; height: 80px; border-radius: 50%; 
        background: var(--brown-50); border: 1px solid var(--brown-200);
        object-fit: cover; flex-shrink: 0;
    }
    @media (max-width: 1200px) { .p-avatar-square { width: 60px; height: 60px; } }
    @media (max-width: 768px) { .p-avatar-square { width: 45px; height: 45px; } }

    .p-info-grid { 
        flex: 1; display: grid; 
        grid-template-columns: minmax(250px, 1.5fr) minmax(200px, 1fr) minmax(200px, 1fr); 
        gap: 20px 40px; width: 100%;
    }
    .info-group { display: flex; flex-direction: column; }
    .info-group label { display: flex; align-items: center; gap: 6px; font-size: 10px; color: #111827; font-weight: 800; text-transform: uppercase; margin-bottom: 4px; }
    .info-group label i { color: var(--brown-300); font-size: 11px; cursor: pointer; }
    .info-group label i.is-active { color: var(--brown-700); }
    .info-value { font-size: 14px; color: var(--brown-600); font-weight: 600; line-height: 1.4; }
    .info-value.is-masked { letter-spacing: 1px; }
    .name-highlight { font-size: 26px; font-weight: 800; color: var(--brown-600); letter-spacing: -0.5px; margin-top: -3px; }
    
    .info-link { margin-top: 8px; }
    .info-link a { font-size: 12px; color: var(--brown-700); text-decoration: none; font-weight: 700; transition: 0.2s; }
    .info-link a:hover { text-decoration: underline; color: var(--brown-900); }

    .patient-detail-modal {
        position: fixed;
        inset: 0;
        background: rgba(28, 22, 14, 0.45);
        backdrop-filter: blur(4px);
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
        z-index: 2147483001;
    }

    .patient-detail-modal:target {
        display: flex;
    }

    .patient-detail-modal-card {
        width: min(100%, 760px);
        max-height: calc(100vh - 40px);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        border-radius: 14px;
        background: #fff;
        border: 1px solid var(--brown-200);
        box-shadow: 0 20px 48px rgba(59, 51, 30, 0.28);
    }

    .patient-detail-modal-head {
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        flex-shrink: 0;
        padding: 14px 16px;
        border-bottom: 1px solid var(--brown-200);
        background: linear-gradient(180deg, #fdf7f1 0%, #ffffff 100%);
    }

    .patient-detail-modal-title {
        margin: 0;
        font-size: 15px;
        color: #111827;
        font-weight: 800;
        text-align: center;
        width: 100%;
    }

    .patient-detail-modal-close {
        position: absolute;
        right: 16px;
        top: 50%;
        transform: translateY(-50%);
        width: 28px;
        height: 28px;
        border-radius: 8px;
        color: var(--brown-700);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        font-weight: 700;
    }

    .patient-detail-modal-body {
        padding: 16px;
        overflow-y: auto;
        min-height: 0;
    }

    .patient-detail-photo-wrap {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 14px;
        padding-bottom: 12px;
        border-bottom: 1px solid var(--brown-200);
    }

    .patient-detail-photo {
        width: 62px;
        height: 62px;
        border-radius: 50%;
        object-fit: cover;
        border: 1px solid var(--brown-200);
        background: var(--brown-50);
        flex-shrink: 0;
    }

    .patient-detail-photo-meta {
        min-width: 0;
    }

    .patient-detail-photo-actions {
        margin-top: 6px;
    }

    .patient-detail-photo-upload-label {
        font-size: 11px;
        font-weight: 700;
        color: var(--brown-700);
        border: 1px solid var(--brown-200);
        border-radius: 8px;
        padding: 5px 10px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #fff;
        cursor: pointer;
    }

    .patient-detail-photo-upload-label.disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    .patient-detail-photo-hint {
        margin-top: 4px;
        font-size: 10px;
        color: var(--brown-500);
    }

    .patient-detail-photo-cropper-modal {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.6);
        z-index: 2147483010;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 16px;
    }

    .patient-detail-photo-cropper-card {
        background: #fff;
        border: 1px solid var(--brown-200);
        border-radius: 12px;
        width: min(96vw, 680px);
        max-height: 92vh;
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    .patient-detail-photo-cropper-head {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 16px;
        border-bottom: 1px solid var(--brown-200);
    }

    .patient-detail-photo-cropper-head h3 {
        margin: 0;
        font-size: 16px;
        color: var(--brown-900);
        font-weight: 800;
    }

    .patient-detail-photo-cropper-close {
        border: none;
        background: transparent;
        color: var(--brown-700);
        font-size: 22px;
        line-height: 1;
        cursor: pointer;
    }

    .patient-detail-photo-cropper-body {
        padding: 16px;
    }

    .patient-detail-photo-cropper-note {
        margin: 0 0 10px;
        font-size: 12px;
        color: var(--brown-600);
    }

    .patient-detail-photo-cropper-canvas-wrap {
        border: 1px solid var(--brown-200);
        border-radius: 10px;
        background: var(--brown-50);
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 280px;
        padding: 10px;
    }

    #patientDetailPhotoCropperCanvas {
        display: block;
        max-width: 100%;
        height: auto;
        user-select: none;
        cursor: grab;
        border-radius: 8px;
    }

    #patientDetailPhotoCropperCanvas:active {
        cursor: grabbing;
    }

    .patient-detail-photo-cropper-actions {
        padding: 12px 16px;
        border-top: 1px solid var(--brown-200);
        display: flex;
        justify-content: flex-end;
        gap: 8px;
    }

    .patient-detail-photo-name {
        font-size: 14px;
        font-weight: 800;
        color: var(--brown-600);
        line-height: 1.2;
    }

    .patient-detail-photo-rm {
        font-size: 11px;
        font-weight: 700;
        color: var(--brown-500);
        margin-top: 2px;
    }

    .patient-detail-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 12px;
    }

    .patient-detail-item {
        border: 1px solid var(--brown-200);
        border-radius: 10px;
        padding: 10px 12px;
        background: var(--brown-50);
    }

    .patient-detail-item.full {
        grid-column: 1 / -1;
    }

    .patient-detail-label {
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        color: var(--brown-500);
        margin-bottom: 3px;
    }

    .patient-detail-value {
        font-size: 13px;
        color: var(--brown-600);
        font-weight: 600;
        line-height: 1.4;
        word-break: break-word;
    }

    .patient-detail-input,
    .patient-detail-select,
    .patient-detail-textarea {
        width: 100%;
        border: 1px solid var(--brown-200);
        border-radius: 8px;
        padding: 8px 10px;
        font-size: 12px;
        color: var(--brown-600);
        background: #fff;
        outline: none;
    }

    .patient-detail-textarea {
        min-height: 74px;
        resize: vertical;
    }

    .patient-detail-input:disabled,
    .patient-detail-select:disabled,
    .patient-detail-textarea:disabled {
        background: var(--brown-50);
        color: var(--brown-600);
        opacity: 1;
        cursor: not-allowed;
    }

    .patient-detail-actions {
        margin-top: 14px;
        display: flex;
        justify-content: flex-end;
        gap: 8px;
        flex-wrap: wrap;
    }

    .patient-detail-btn {
        border: 1px solid var(--brown-200);
        border-radius: 8px;
        padding: 7px 12px;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .patient-detail-btn.primary {
        background: var(--brown-800);
        color: #fff;
        border-color: var(--brown-800);
    }

    .patient-detail-btn.secondary {
        background: #fff;
        color: var(--brown-800);
    }

    .patient-detail-btn.success {
        background: #166534;
        color: #fff;
        border-color: #166534;
    }

    @media (max-width: 768px) {
        .patient-detail-grid {
            grid-template-columns: 1fr;
        }
    }

    /* ================= 3. TABS NAV ================= */
    .emr-tabs-nav { display: flex; gap: 40px; border-bottom: 2px solid var(--brown-100); margin-bottom: 30px; width: 100%; }
    .tab-item { background: none; border: none; padding: 12px 0; font-weight: 700; font-size: 14px; color: var(--brown-500); cursor: pointer; position: relative; }
    .tab-item.active { color: var(--brown-800); }
    .tab-item.active::after { content: ''; position: absolute; bottom: -2px; left: 0; width: 100%; height: 2px; background: var(--brown-700); }

    .record-tab-btn { transition: all 0.2s ease; }
    .record-tab-btn.active {
        color: var(--brown-800) !important;
        border-bottom-color: var(--brown-700) !important;
    }

    .record-tab-btn:not(.active) {
        color: var(--brown-500) !important;
    }

    .record-table-shell {
        border: 1px solid var(--brown-200);
        border-radius: 12px;
        background: #fff;
        overflow: hidden;
    }

    .record-table-head {
        display: grid;
        gap: 0;
        background: var(--brown-50);
        border-bottom: 1px solid var(--brown-200);
    }

    .record-table-head div {
        padding: 12px;
        font-size: 11px;
        font-weight: 800;
        color: var(--brown-900);
        text-transform: uppercase;
    }

    .record-table-row {
        display: grid;
        gap: 0;
        border-bottom: 1px solid #f3ece5;
    }

    .record-table-row div {
        padding: 12px;
    }

    .record-table-text {
        color: var(--brown-600);
        font-size: 12px;
        line-height: 1.5;
    }

    .record-table-text strong {
        color: var(--brown-600);
    }

    .record-empty-state {
        padding: 18px;
        text-align: center;
        color: var(--brown-500);
        font-size: 12px;
    }

    /* ================= 4. CONTENT BODY ================= */
    .emr-content-body { display: flex; gap: 50px; width: 100%; align-items: flex-start; justify-content: space-between; }
    
    .emr-timeline-section { flex: 1 1 auto; width: 100%; min-width: 0; }
    .timeline-row { display: flex; gap: 20px; width: 100%; }
    .timeline-date { width: 65px; text-align: right; color: var(--brown-500); padding-top: 5px; flex-shrink: 0; }
    .timeline-date .day { font-size: 22px; font-weight: 800; color: var(--brown-900); display: block; line-height: 1; margin-bottom: 2px; }
    .timeline-date .month { font-size: 11px; font-weight: 700; text-transform: uppercase; color: var(--brown-500); }

    .timeline-line { width: 20px; position: relative; display: flex; justify-content: center; flex-shrink: 0; }
    .line-vertical { position: absolute; top: 0; bottom: -40px; width: 2px; background: var(--brown-200); }
    .line-dot { width: 12px; height: 12px; border-radius: 50%; background: var(--brown-700); z-index: 1; margin-top: 10px; border: 2px solid #fff; box-shadow: 0 0 0 1px var(--brown-200); }

    .timeline-content-card { 
        flex: 1 1 auto; width: 100%;
        border: 1px solid var(--brown-200); border-radius: 12px;
        padding: 25px; background: #fff; margin-bottom: 30px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.02); 
    }
    .card-title { font-size: 15px; color: var(--brown-600); margin-bottom: 15px; }
    .doc-link { color: var(--brown-700); font-weight: 700; }

    /* LAYOUT KIRI-KANAN TIMELINE */
    .tl-split-row { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 15px; }
    .tl-split-bottom { display: flex; justify-content: space-between; align-items: center; }

    .payment-box-static {
        background: var(--brown-100); border: 1px solid var(--brown-200); border-radius: 8px;
        padding: 8px 18px; font-size: 13px; font-weight: 700; color: var(--brown-800);
        margin: 0; /* Hapus margin agar rapi di flex */
    }

    .card-actions-row { display: flex; align-items: center; gap: 15px; }
    .icon-action { color: var(--brown-300); cursor: pointer; font-size: 18px; transition: 0.2s; }
    .icon-action:hover { color: var(--brown-700); }
    
    .status-container { position: relative; display: inline-block; }
    .btn-status-toggle { 
        color: #fff; border: none; padding: 10px 22px; border-radius: 8px; 
        font-size: 13px; font-weight: 800; cursor: pointer; display: flex; align-items: center; gap: 12px;
    }
    .status-menu {
        position: absolute; bottom: 110%; right: 0; background: white; border: 1px solid var(--brown-200);
        border-radius: 8px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); z-index: 500; list-style: none; padding: 5px 0; min-width: 150px;
    }
    .status-menu li a { display: block; padding: 10px 15px; font-size: 13px; color: var(--brown-800); text-decoration: none; font-weight: 600; text-align: left; }
    .status-menu li a:hover { background: var(--brown-100); color: var(--brown-900); }

    .card-time-info { font-size: 13px; color: var(--brown-500); margin: 0; }

    /* ================= 5. RIGHT ACTIONS ================= */
    .emr-side-actions { flex: 0 0 280px; width: 280px; display: flex; flex-direction: column; gap: 15px; }
    .diagnosa-container { position: relative; width: 100%; }
    .btn-primary-blue { 
        background: #2563eb; /* Warna biru utama */
        color: #fff; 
        border: none; 
        padding: 15px 18px; 
        border-radius: 10px; 
        font-weight: 700; 
        font-size: 13px; 
        width: 100%; 
        cursor: pointer; 
        display: flex; 
        justify-content: center; /* KUNCI KETENGAH: Ubah dari space-between jadi center */
        align-items: center;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3); /* Bayangan disesuaikan jadi kebiruan */
        transition: 0.3s;
    }
    .btn-primary-blue:hover:not(:disabled) { 
        background: #1d4ed8; /* Biru yang sedikit lebih gelap saat di-hover */
    }
    .btn-primary-blue:disabled { 
        background: #cbd5e0; 
        color: #718096; 
        cursor: not-allowed; 
        box-shadow: none; 
    }
    .diagnosa-dropdown { position: absolute; top: 105%; left: 0; width: 100%; background: white; border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.15); z-index: 200; padding: 12px; }
    .diagnosa-dropdown { position: absolute; top: 105%; left: 0; width: 100%; background: white; border: 1px solid var(--brown-200); border-radius: 12px; box-shadow: 0 10px 25px rgba(59,51,30,0.12); z-index: 200; padding: 12px; }
    .diag-search-input { width: 100%; padding: 10px 15px; border: 1px solid var(--brown-200); border-radius: 8px; font-size: 13px; background: var(--brown-50); margin-bottom: 12px; box-sizing: border-box; outline: none; color: var(--brown-900); }
    .diag-list { max-height: 250px; overflow-y: auto; list-style: none; padding: 0; margin: 0; }
    .diagnosa-item { display: block; padding: 12px 15px; font-size: 13px; font-weight: 600; color: var(--brown-800); text-decoration: none; border-radius: 8px; }
    .diagnosa-item:hover { background-color: var(--brown-100); color: var(--brown-900); }

    .btn-outline-brown { background: #fff; color: #3b331e; border: 2px solid #3b331e; padding: 15px 18px; border-radius: 10px; font-weight: 700; font-size: 13px; width: 100%; cursor: pointer; transition: 0.3s; }
    .btn-outline-brown:hover { background: #3b331e; color: #fff; }
    .riwayat-accordion { margin-top: 15px; padding: 15px 0; border-top: 1px solid var(--brown-200); display: flex; justify-content: space-between; align-items: center; cursor: pointer; font-size: 14px; font-weight: 800; color: var(--brown-900); }
    
    .hidden { display: none !important; }
</style>

@php
    $patient = $appointment->patient;
    $paymentLabel = $appointment->paymentMethod->name ?? $appointment->guarantorType->name ?? 'Tunai';
    $appointmentTimeText = $appointment->appointment_datetime
        ? \Carbon\Carbon::parse($appointment->appointment_datetime)->format('H:i')
        : '--:--';
    $statusTextMap = [
        'pending' => 'dan belum dimulai',
        'confirmed' => 'dan sudah terkonfirmasi',
        'waiting' => 'dan menunggu pemeriksaan',
        'engaged' => 'dan masih berlangsung',
        'succeed' => 'dan sudah selesai',
        'failed' => 'dan dibatalkan',
    ];
    $statusDescription = $statusTextMap[strtolower((string) $appointment->status)] ?? '';
    $patientDob = $patient?->date_of_birth;
    $patientDobText = $patientDob ? \Carbon\Carbon::parse($patientDob)->translatedFormat('d F Y') : '-';
    $patientAgeText = $patientDob ? \Carbon\Carbon::parse($patientDob)->age . ' Thn' : '-';
    $patientAgeNumber = $patientDob ? \Carbon\Carbon::parse($patientDob)->age : 0;
    $patientFirstChatDateValue = $patient?->first_chat_date
        ? \Carbon\Carbon::parse($patient->first_chat_date)->format('Y-m-d')
        : '';
    $patientGenderLabel = ($patient->gender ?? '') === 'Male' ? 'Laki-laki' : 'Perempuan';
    $patientPhoto = $patient?->photo ?? '';
    $normalizedPhoto = trim((string) $patientPhoto);
    $looksLikeRawBase64 = $normalizedPhoto !== ''
        && !str_starts_with($normalizedPhoto, 'data:image')
        && !preg_match('/^(https?:\/\/|\/)/i', $normalizedPhoto)
        && !preg_match('/\.(jpg|jpeg|png|gif|webp|svg)$/i', $normalizedPhoto)
        && !str_contains($normalizedPhoto, 'storage/')
        && strlen(preg_replace('/\s+/', '', $normalizedPhoto)) > 120;

    if (str_starts_with($normalizedPhoto, 'data:image')) {
        $patientPhotoSrc = $normalizedPhoto;
    } elseif ($looksLikeRawBase64) {
        $patientPhotoSrc = 'data:image/png;base64,' . preg_replace('/\s+/', '', $normalizedPhoto);
    } elseif ($normalizedPhoto !== '') {
        $patientPhotoSrc = asset('storage/' . ltrim($normalizedPhoto, '/'));
    } else {
        $patientPhotoSrc = asset('images/avatar-placeholder.png');
    }
@endphp

<div class="p-detail-container"
     data-appointment-id="{{ $appointment->id }}"
     data-patient-name="{{ $patient->full_name ?? '-' }}"
     data-patient-rm="{{ $patient->medical_record_no ?? '-' }}"
     data-doctor-name="{{ $appointment->doctor->full_name ?? '-' }}"
     data-patient-demography="{{ $patientDobText }} ({{ $patientAgeText }})">
    
    {{-- 1. HEADER PROFIL --}}
    <div class="p-detail-header">
        <div class="p-profile-flex">
            <div class="p-avatar-wrapper">
                <img src="{{ $patientPhotoSrc }}" class="p-avatar-square">
            </div>
            
            <div class="p-info-grid">
                <div class="info-group">
                    <label>NAMA PASIEN</label>
                    <div class="info-value name-highlight">{{ $patient->full_name ?? '-' }}</div>
                </div>
                <div class="info-group">
                    <label>TANGGAL LAHIR / UMUR</label>
                    <div class="info-value">
                        {{ $patientDobText }}
                        <span style="color: #a0aec0; font-weight: 400;">({{ $patientAgeText }})</span>
                    </div>
                </div>
                <div></div>
                
                <div class="info-group">
                    <label>
                        ALAMAT RUMAH
                        <i class="fa fa-eye js-sensitive-toggle is-active"
                           data-sensitive-target="patientAddressValue"
                           title="Tampilkan/Sembunyikan"></i>
                    </label>
                    <div class="info-value"
                         id="patientAddressValue"
                         data-sensitive-original="{{ e($patient->address ?? '-') }}"
                         data-sensitive-visible="1">{{ e($patient->address ?? '-') }}</div>
                    <div class="info-link" style="text-align: left; margin-top: 8px;">
                        <a href="#patientDetailModal">Lihat data lainnya &gt;</a>
                    </div>
                </div>
                <div class="info-group">
                    <label>
                        NOMOR KTP
                        <i class="fa fa-eye js-sensitive-toggle is-active"
                           data-sensitive-target="patientIdCardValue"
                           title="Tampilkan/Sembunyikan"></i>
                    </label>
                    <div class="info-value"
                         id="patientIdCardValue"
                         data-sensitive-original="{{ e($patient->id_card_number ?? '-') }}"
                         data-sensitive-visible="1">{{ e($patient->id_card_number ?? '-') }}</div>
                </div>
                <div class="info-group">
                    <label>
                        NOMOR HP
                        <i class="fa fa-eye js-sensitive-toggle is-active"
                           data-sensitive-target="patientPhoneValue"
                           title="Tampilkan/Sembunyikan"></i>
                    </label>
                    <div class="info-value"
                         id="patientPhoneValue"
                         data-sensitive-original="{{ e($patient->phone_number ?? '-') }}"
                         data-sensitive-visible="1">{{ e($patient->phone_number ?? '-') }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- 2. TABS --}}
    <div class="emr-tabs-nav">
        <button class="tab-item active" data-tab="timeline">TIMELINE</button>
        <button class="tab-item" data-tab="record">RECORD</button>
    </div>

    <div class="emr-content-body" data-tab-content="timeline">
        
        {{-- KIRI: TIMELINE --}}
        <div class="emr-timeline-section">
            <div class="timeline-row">
                <div class="timeline-date">
                    <span class="day">{{ \Carbon\Carbon::parse($appointment->appointment_datetime)->format('d') }}</span>
                    <span class="month">{{ \Carbon\Carbon::parse($appointment->appointment_datetime)->format('M Y') }}</span>
                </div>
                
                <div class="timeline-line"><div class="line-vertical"></div><div class="line-dot"></div></div>
                
                <div class="timeline-content-card">
                    <div class="card-title">
                        Poli <strong>{{ $appointment->doctor->specialization ?? 'Bedah Mulut' }}</strong> dengan <span class="doc-link">drg. {{ $appointment->doctor->full_name }}</span>
                    </div>
                    
                    {{-- ROW 1: Pembayaran (Kiri) & Icons+Status (Kanan) --}}
                    <div class="tl-split-row">
                        <div class="payment-box-static">
                            Metode Pembayaran: {{ $paymentLabel }}
                        </div>
                        
                        <div class="card-actions-row">
                            @if($appointment->status == 'succeed')
                                <a href="{{ route('admin.cashier') }}" class="btn-ke-kasir" style="background: #10b981; color: white; padding: 6px 12px; border-radius: 8px; font-weight: 800; font-size: 11px; text-decoration: none; display: flex; align-items: center; gap: 5px; margin-right: 5px;">
                                    <i class="fa fa-wallet"></i> KE KASIR
                                </a>
                            @endif
                            
                            
                            <div class="status-container">
                              {{-- TOMBOL TETAP SESUAI LAYOUT--}}
                                <button class="btn-status-toggle" 
                                        style="background-color: {{ $appointment->status_color ?? '#3B82F6' }}" 
                                        onclick="event.stopPropagation(); document.getElementById('status-menu-dynamic').classList.toggle('hidden')">
                                    <span class="status-current-text">{{ strtoupper($appointment->status) }}</span>
                                    <i class="fa fa-chevron-down"></i>
                                </button>

                                {{-- DROPDOWN MENU DENGAN LOGIKA UPDATE STATUS --}}
                                <ul class="status-menu hidden" id="status-menu-dynamic" style="position:absolute; bottom:115%; left:0; background:white; border:1px solid #eee; border-radius:8px; box-shadow:0 4px 15px rgba(0,0,0,0.1); list-style:none; padding:5px 0; min-width:150px; z-index:999;">
                                    @php
                                        $orderedStatuses = ['pending', 'confirmed', 'waiting', 'engaged', 'succeed'];
                                        $currentStatus = strtolower((string) $appointment->status);
                                        $currentStatusIndex = array_search($currentStatus, $orderedStatuses, true);

                                        $statuses = collect();
                                        if ($currentStatus === 'succeed') {
                                            $statuses = collect(['failed']);
                                        } elseif ($currentStatus !== 'failed') {
                                            if ($currentStatusIndex !== false) {
                                                $statuses = collect(array_slice($orderedStatuses, $currentStatusIndex + 1));
                                            } else {
                                                $statuses = collect($orderedStatuses);
                                            }

                                            if ($currentStatus !== 'failed') {
                                                $statuses->push('failed');
                                            }
                                        }

                                        $statuses = $statuses->unique()->values();

                                        $statusOptionColors = [
                                            'pending' => '#6B7280',
                                            'confirmed' => '#F59E0B',
                                            'waiting' => '#8B5CF6',
                                            'engaged' => '#3B82F6',
                                            'succeed' => '#84CC16',
                                            'failed' => '#EF4444',
                                        ];
                                    @endphp

                                    @foreach($statuses as $st)
                                    <li>
                                        @php
                                            $optionColor = $statusOptionColors[$st] ?? '#4B5563';
                                        @endphp
                                        <a href="javascript:void(0)" 
                                        onclick="processUpdateStatus('{{ route('admin.appointments.updateStatus', $appointment->id) }}', '{{ $st }}')" 
                                        data-status-option="{{ $st }}"
                                        data-option-color="{{ $optionColor }}"
                                        style="display:block; margin:4px 8px; padding:8px 12px; border-radius:7px; font-size:12px; color:#fff; text-decoration:none; font-weight:700; text-transform: uppercase; background:{{ $optionColor }}; opacity:0.92; border:2px solid transparent;">
                                        {{ $st }}
                                        </a>
                                    </li>
                                    @endforeach

                                    <li id="status-no-option" style="display:none; margin:4px 8px; padding:8px 12px; border-radius:7px; font-size:12px; color:#8b5e3c; background:#f7f1ea; font-weight:700; text-transform:uppercase;">
                                        Tidak ada status lanjutan
                                    </li>
                                </ul>
                               
                            </div>
                        </div>
                    </div>
                    
                    {{-- ROW 2: Jam Berlangsung (Kiri)--}}
                    <div class="tl-split-bottom">
                        <div class="card-time-info">
                            {{ $appointmentTimeText }} WIB {{ $statusDescription }}
                        </div>
                        <br>
                    </div>

                </div>
            </div>
        </div>

        {{-- KANAN: ACTIONS --}}
        <div class="emr-side-actions">
            <div class="diagnosa-container">
                <button class="btn-primary-blue" onclick="toggleDiagnosaMenu(event)" {{ ($appointment->status ?? '') !== 'engaged' ? 'disabled' : '' }}>
                    <span>+ TAMBAH DIAGNOSA</span>
                </button>
                <div class="diagnosa-dropdown hidden" id="diagnosa-menu">
                    <input type="text" id="diagSearchInput" onkeyup="filterDiagnosaList()" placeholder="Cari fitur medis..." class="diag-search-input">
                    <ul class="diag-list" id="diagList">
                        <li><a href="javascript:void(0)" class="diagnosa-item" onclick="toggleProsedureModal(true, {
                                name: @js($patient->full_name ?? '-'),
                                rm: @js($patient->medical_record_no ?? '-'),
                                gender: @js($patientGenderLabel),
                                age: @js($patientAgeNumber . ' Tahun'),
                                payment: @js($paymentLabel),
                                patient_id: @js($appointment->patient_id ?? ''),
                                registration_id: @js($appointment->id ?? ''),
                                doctor_id: @js($appointment->doctor_id ?? ''),
                                doctor_name: @js($appointment->doctor->full_name ?? '')
                            })">
                                Tambah Prosedur
                            </a></li>
                        <li><a href="javascript:void(0)" class="diagnosa-item" onclick="toggleOdontogramModal(true, {
                                    name: @js($patient->full_name ?? '-'),
                                    rm: @js($patient->medical_record_no ?? '-'),
                                    gender: @js($patientGenderLabel),
                                    age: @js($patientAgeNumber . ' Tahun'),
                                    payment: @js($paymentLabel),
                                    patient_id: @js($appointment->patient_id ?? ''),
                                    registration_id: @js($appointment->id ?? ''),
                                    doctor_id: @js($appointment->doctor_id ?? ''),
                                    doctor_name: @js($appointment->doctor->full_name ?? '')
                                })">Tambah Odontogram</a></li>
                        <li><a href="javascript:void(0)" class="diagnosa-item" onclick="openDoctorNoteModalFromDetail()">Tambah Catatan Dokter</a></li>
                    </ul>
                </div>
            </div>
            
        </div>
    </div>

    <div class="hidden" data-tab-content="record" style="padding-top: 12px;">
        <div style="display:flex; gap:12px; border-bottom:1px solid #e5e7eb; margin-bottom:14px;">
            <button class="record-tab-btn active" data-record-tab="rekam-medis" style="border:none; background:none; padding:10px 4px; font-weight:700; border-bottom:2px solid var(--brown-700); cursor:pointer;">REKAM MEDIS</button>
            <button class="record-tab-btn" data-record-tab="catatan-dokter" style="border:none; background:none; padding:10px 4px; font-weight:700; border-bottom:2px solid transparent; cursor:pointer;">CATATAN DOKTER</button>
        </div>

        <div data-record-tab-content="rekam-medis">
            <div class="record-table-shell">
                <div class="record-table-head" style="grid-template-columns:190px 170px 1fr 150px 130px;">
                    <div>Tanggal Kunjungan</div>
                    <div>Dokter</div>
                    <div>Tindakan Prosedur / Obat</div>
                    <div>No Gigi</div>
                    <div>Status</div>
                </div>

                @php
                    $sortedPatientRegistrations = collect($patientRegistrations ?? collect())
                        ->sortByDesc(function ($reg) {
                            return $reg->created_at ?? $reg->appointment_datetime;
                        })
                        ->values();
                @endphp

                @forelse($sortedPatientRegistrations as $reg)
                    @php
                        $primaryDoctorName = $reg->doctor->full_name
                            ?? optional($reg->medicalProcedures->first()?->doctor)->full_name
                            ?? '-';

                        $assistantDoctorNames = $reg->medicalProcedures
                            ->flatMap(function ($procedure) {
                                if (!method_exists($procedure, 'assistants') || !$procedure->relationLoaded('assistants')) {
                                    return collect();
                                }

                                return $procedure->assistants
                                    ->map(fn($assistant) => optional($assistant->doctor)->full_name);
                            })
                            ->filter()
                            ->reject(fn($name) => $name === $primaryDoctorName)
                            ->unique()
                            ->values();

                        $doctorDisplayNames = collect([$primaryDoctorName])
                            ->merge($assistantDoctorNames)
                            ->filter()
                            ->values();

                        $procedureNames = $reg->medicalProcedures
                            ->flatMap(fn($mp) => $mp->items)
                            ->map(fn($item) => optional($item->masterProcedure)->procedure_name ?? optional($item->masterProcedure)->name)
                            ->filter()
                            ->unique()
                            ->values();

                        $medicineNames = $reg->medicalProcedures
                            ->flatMap(fn($mp) => $mp->medicines)
                            ->map(fn($med) => optional($med->medicine)->medicine_name)
                            ->filter()
                            ->unique()
                            ->values();

                        $bhpNames = $reg->medicalProcedures
                            ->flatMap(fn($mp) => $mp->bhpUsages)
                            ->map(fn($usage) => optional($usage->item)->item_name)
                            ->filter()
                            ->unique()
                            ->values();

                        $toothNumbers = $reg->medicalProcedures
                            ->flatMap(fn($mp) => $mp->items)
                            ->pluck('tooth_numbers')
                            ->filter()
                            ->flatMap(function ($value) {
                                return collect(preg_split('/\s*,\s*/', (string) $value, -1, PREG_SPLIT_NO_EMPTY));
                            })
                            ->unique()
                            ->values();
                    @endphp
                    <div class="record-table-row" style="grid-template-columns:190px 170px 1fr 150px 130px;">
                        <div class="record-table-text" style="font-weight:600;">{{ optional($reg->created_at ?? $reg->appointment_datetime)->translatedFormat('d F Y H:i') }} WIB</div>
                        <div class="record-table-text" style="font-weight:600; line-height:1.5;">
                            @if($doctorDisplayNames->count() <= 1)
                                <div>{{ $doctorDisplayNames->first() ?? '-' }}</div>
                            @else
                                @foreach($doctorDisplayNames as $doctorName)
                                    <div style="color:#8e6a45;">&gt; {{ $doctorName }}</div>
                                @endforeach
                            @endif
                        </div>
                        <div class="record-table-text">
                            <div><strong>Prosedur</strong> {{ $procedureNames->isNotEmpty() ? $procedureNames->implode(', ') : '-' }}</div>
                            <div><strong>Obat</strong> {{ $medicineNames->isNotEmpty() ? $medicineNames->implode(', ') : '-' }}</div>
                            <div><strong>BHP</strong> {{ $bhpNames->isNotEmpty() ? $bhpNames->implode(', ') : '-' }}</div>
                        </div>
                        <div class="record-table-text" style="font-weight:600;">{{ $toothNumbers->isNotEmpty() ? $toothNumbers->implode(', ') : '-' }}</div>
                        <div class="record-table-text" style="font-weight:700; text-transform:uppercase;">{{ $reg->status ?? '-' }}</div>
                    </div>
                @empty
                    <div class="record-empty-state">Belum ada histori registrasi pasien.</div>
                @endforelse
            </div>
        </div>

        <div class="hidden" data-record-tab-content="catatan-dokter">
            <div class="record-table-shell">
                <div class="record-table-head" style="grid-template-columns:180px 220px 1fr;">
                    <div>Tanggal</div>
                    <div>Dokter</div>
                    <div>Catatan</div>
                </div>

                @php
                    $sortedDoctorNotes = collect($doctorNotes ?? collect())
                        ->sortByDesc(function ($note) {
                            return data_get($note, 'created_at');
                        })
                        ->values();
                @endphp

                @forelse($sortedDoctorNotes as $note)
                    @php
                        $doctorName = $note['doctor_name'] ?? '-';
                        $assistantNames = collect($note['assistant_names'] ?? [])
                            ->filter()
                            ->reject(fn($name) => $name === $doctorName)
                            ->unique()
                            ->values();
                    @endphp
                    <div class="record-table-row" style="grid-template-columns:180px 220px 1fr;">
                        <div class="record-table-text" style="font-weight:600;">{{ $note['created_at_label'] ?? '-' }}</div>
                        <div class="record-table-text" style="font-weight:700; line-height:1.5;">
                            <div>{{ $doctorName }}</div>
                            @foreach($assistantNames as $assistantName)
                                <div style="color:#8e6a45;">&gt; {{ $assistantName }}</div>
                            @endforeach
                        </div>
                        <div style="padding:10px 12px;">
                            <div style="display:grid; grid-template-columns:repeat(2, minmax(0, 1fr)); gap:6px 12px;">
                                @if(($note['subjective'] ?? '') !== '')
                                    <div>
                                        <div style="font-size:11px; color:var(--brown-500); font-weight:800; text-transform:uppercase; margin-bottom:2px;">Subjectives</div>
                                        <div class="record-table-text" style="line-height:1.35;">{{ $note['subjective'] }}</div>
                                    </div>
                                @endif

                                @if(($note['objective'] ?? '') !== '')
                                    <div>
                                        <div style="font-size:11px; color:var(--brown-500); font-weight:800; text-transform:uppercase; margin-bottom:2px;">Objectives</div>
                                        <div class="record-table-text" style="line-height:1.35;">{{ $note['objective'] }}</div>
                                    </div>
                                @endif

                                @if(($note['plan'] ?? '') !== '')
                                    <div style="grid-column:1 / -1;">
                                        <div style="font-size:11px; color:var(--brown-500); font-weight:800; text-transform:uppercase; margin-bottom:2px;">Plans</div>
                                        <div class="record-table-text" style="line-height:1.35;">{{ $note['plan'] }}</div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div id="doctor-note-empty" class="record-empty-state">Belum ada catatan dokter untuk kunjungan ini.</div>
                @endforelse
            </div>
        </div>
    </div>

</div>

<div id="patientDetailModal" class="patient-detail-modal">
    <div class="patient-detail-modal-card">
        <div class="patient-detail-modal-head">
            <h3 class="patient-detail-modal-title">Detail Data Pasien</h3>
            <a href="#" class="patient-detail-modal-close">✕</a>
        </div>
        <div class="patient-detail-modal-body">
            <input type="hidden" id="patientDetailPatientId" value="{{ $patient->id ?? '' }}">
            <input type="hidden" id="patientDetailPhotoBase64" value="">

            <div class="patient-detail-photo-wrap">
                <img src="{{ $patientPhotoSrc }}" alt="Foto pasien" class="patient-detail-photo" id="patientDetailPhotoPreview">
                <div class="patient-detail-photo-meta">
                    <div class="patient-detail-photo-name">{{ $patient->full_name ?? '-' }}</div>
                    <div class="patient-detail-photo-rm">RM: {{ $patient->medical_record_no ?? '-' }}</div>
                    <div class="patient-detail-photo-actions">
                        <label for="patientDetailPhotoInput" id="patientDetailPhotoUploadLabel" class="patient-detail-photo-upload-label disabled">
                            <i class="fa fa-image"></i> Ganti Foto
                        </label>
                        <input id="patientDetailPhotoInput" type="file" accept="image/*" class="hidden" disabled>
                        <div class="patient-detail-photo-hint">Format: JPG/PNG, maksimal 2MB</div>
                    </div>
                </div>
            </div>

            <div class="patient-detail-grid">
                <div class="patient-detail-item">
                    <div class="patient-detail-label">ID Pasien</div>
                    <input class="patient-detail-input" value="{{ $patient->id ?? '-' }}" disabled data-readonly-permanent="1">
                </div>
                <div class="patient-detail-item">
                    <div class="patient-detail-label">User ID</div>
                    <input class="patient-detail-input" value="{{ $patient->user_id ?? '-' }}" disabled data-readonly-permanent="1">
                </div>
                <div class="patient-detail-item">
                    <div class="patient-detail-label">Nama Lengkap</div>
                    <input id="patientDetailFullName" data-patient-field="full_name" class="patient-detail-input" value="{{ $patient->full_name ?? '' }}" disabled>
                </div>
                <div class="patient-detail-item">
                    <div class="patient-detail-label">Email</div>
                    <input id="patientDetailEmail" data-patient-field="email" class="patient-detail-input" value="{{ $patient->email ?? '' }}" disabled>
                </div>
                <div class="patient-detail-item">
                    <div class="patient-detail-label">No. Rekam Medis</div>
                    <input class="patient-detail-input" value="{{ $patient->medical_record_no ?? '-' }}" disabled data-readonly-permanent="1">
                </div>
                <div class="patient-detail-item">
                    <div class="patient-detail-label">Tanggal Lahir</div>
                    <input id="patientDetailDob" type="date" data-patient-field="date_of_birth" class="patient-detail-input" value="{{ optional($patient?->date_of_birth)->format('Y-m-d') }}" disabled>
                </div>
                <div class="patient-detail-item">
                    <div class="patient-detail-label">Jenis Kelamin</div>
                    <select id="patientDetailGender" data-patient-field="gender" class="patient-detail-select" disabled>
                        <option value="">-</option>
                        <option value="Male" {{ ($patient->gender ?? '') === 'Male' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Female" {{ ($patient->gender ?? '') === 'Female' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
                <div class="patient-detail-item">
                    <div class="patient-detail-label">Golongan Darah</div>
                    <select id="patientDetailBloodType" data-patient-field="blood_type" class="patient-detail-select" disabled>
                        <option value="">-</option>
                        <option value="A" {{ ($patient->blood_type ?? '') === 'A' ? 'selected' : '' }}>A</option>
                        <option value="B" {{ ($patient->blood_type ?? '') === 'B' ? 'selected' : '' }}>B</option>
                        <option value="AB" {{ ($patient->blood_type ?? '') === 'AB' ? 'selected' : '' }}>AB</option>
                        <option value="O" {{ ($patient->blood_type ?? '') === 'O' ? 'selected' : '' }}>O</option>
                        <option value="unknown" {{ ($patient->blood_type ?? '') === 'unknown' ? 'selected' : '' }}>Tidak diketahui</option>
                    </select>
                </div>
                <div class="patient-detail-item">
                    <div class="patient-detail-label">Rhesus</div>
                    <select id="patientDetailRhesus" data-patient-field="rhesus" class="patient-detail-select" disabled>
                        <option value="">-</option>
                        <option value="+" {{ ($patient->rhesus ?? '') === '+' ? 'selected' : '' }}>+</option>
                        <option value="-" {{ ($patient->rhesus ?? '') === '-' ? 'selected' : '' }}>-</option>
                        <option value="unknown" {{ ($patient->rhesus ?? '') === 'unknown' ? 'selected' : '' }}>Tidak diketahui</option>
                    </select>
                </div>
                <div class="patient-detail-item">
                    <div class="patient-detail-label">Nomor HP</div>
                    <input id="patientDetailPhone" data-patient-field="phone_number" class="patient-detail-input" value="{{ $patient->phone_number ?? '' }}" disabled>
                </div>
                <div class="patient-detail-item">
                    <div class="patient-detail-label">Nomor KTP</div>
                    <input id="patientDetailIdCard" data-patient-field="id_card_number" class="patient-detail-input" value="{{ $patient->id_card_number ?? '' }}" disabled>
                </div>
                <div class="patient-detail-item">
                    <div class="patient-detail-label">Kota</div>
                    <input id="patientDetailCity" data-patient-field="city" class="patient-detail-input" value="{{ $patient->city ?? '' }}" disabled>
                </div>
                <div class="patient-detail-item">
                    <div class="patient-detail-label">Agama</div>
                    <select id="patientDetailReligion" data-patient-field="religion" class="patient-detail-select" disabled>
                        <option value="">-</option>
                        <option value="Islam" {{ ($patient->religion ?? '') === 'Islam' ? 'selected' : '' }}>Islam</option>
                        <option value="Kristen" {{ ($patient->religion ?? '') === 'Kristen' ? 'selected' : '' }}>Kristen</option>
                        <option value="Katolik" {{ ($patient->religion ?? '') === 'Katolik' ? 'selected' : '' }}>Katolik</option>
                        <option value="Hindu" {{ ($patient->religion ?? '') === 'Hindu' ? 'selected' : '' }}>Hindu</option>
                        <option value="Buddha" {{ ($patient->religion ?? '') === 'Buddha' ? 'selected' : '' }}>Buddha</option>
                        <option value="Konghucu" {{ ($patient->religion ?? '') === 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                    </select>
                </div>
                <div class="patient-detail-item">
                    <div class="patient-detail-label">Pendidikan</div>
                    <select id="patientDetailEducation" data-patient-field="education" class="patient-detail-select" disabled>
                        <option value="">-</option>
                        <option value="SD/Sederajat" {{ in_array(($patient->education ?? ''), ['SD/Sederajat', 'SD'], true) ? 'selected' : '' }}>SD/Sederajat</option>
                        <option value="SMP/Sederajat" {{ in_array(($patient->education ?? ''), ['SMP/Sederajat', 'SMP'], true) ? 'selected' : '' }}>SMP/Sederajat</option>
                        <option value="SMA/Sederajat" {{ in_array(($patient->education ?? ''), ['SMA/Sederajat', 'SMA'], true) ? 'selected' : '' }}>SMA/Sederajat</option>
                        <option value="D3" {{ ($patient->education ?? '') === 'D3' ? 'selected' : '' }}>D3</option>
                        <option value="S1/D4" {{ in_array(($patient->education ?? ''), ['S1/D4', 'S1'], true) ? 'selected' : '' }}>S1/D4</option>
                        <option value="S2" {{ ($patient->education ?? '') === 'S2' ? 'selected' : '' }}>S2</option>
                        <option value="S3" {{ ($patient->education ?? '') === 'S3' ? 'selected' : '' }}>S3</option>
                        <option value="Lainnya" {{ ($patient->education ?? '') === 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>
                <div class="patient-detail-item">
                    <div class="patient-detail-label">Pekerjaan</div>
                    <select id="patientDetailOccupation" data-patient-field="occupation" class="patient-detail-select" disabled>
                        <option value="">-</option>
                        <option value="Pelajar/Mahasiswa" {{ ($patient->occupation ?? '') === 'Pelajar/Mahasiswa' ? 'selected' : '' }}>Pelajar/Mahasiswa</option>
                        <option value="PNS" {{ ($patient->occupation ?? '') === 'PNS' ? 'selected' : '' }}>PNS</option>
                        <option value="Karyawan Swasta" {{ ($patient->occupation ?? '') === 'Karyawan Swasta' ? 'selected' : '' }}>Karyawan Swasta</option>
                        <option value="Wiraswasta" {{ ($patient->occupation ?? '') === 'Wiraswasta' ? 'selected' : '' }}>Wiraswasta</option>
                        <option value="Ibu Rumah Tangga" {{ ($patient->occupation ?? '') === 'Ibu Rumah Tangga' ? 'selected' : '' }}>Ibu Rumah Tangga</option>
                        <option value="Lainnya" {{ ($patient->occupation ?? '') === 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>
                <div class="patient-detail-item">
                    <div class="patient-detail-label">Status Perkawinan</div>
                    <select id="patientDetailMaritalStatus" data-patient-field="marital_status" class="patient-detail-select" disabled>
                        <option value="">-</option>
                        <option value="Belum Kawin" {{ in_array(($patient->marital_status ?? ''), ['Belum Kawin', 'Belum Menikah'], true) ? 'selected' : '' }}>Belum Kawin</option>
                        <option value="Kawin" {{ in_array(($patient->marital_status ?? ''), ['Kawin', 'Menikah'], true) ? 'selected' : '' }}>Kawin</option>
                        <option value="Cerai Hidup" {{ in_array(($patient->marital_status ?? ''), ['Cerai Hidup', 'Cerai'], true) ? 'selected' : '' }}>Cerai Hidup</option>
                        <option value="Cerai Mati" {{ ($patient->marital_status ?? '') === 'Cerai Mati' ? 'selected' : '' }}>Cerai Mati</option>
                        <option value="Lainnya" {{ ($patient->marital_status ?? '') === 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>
                <div class="patient-detail-item">
                    <div class="patient-detail-label">Tanggal Chat Pertama</div>
                    <input id="patientDetailFirstChatDate" type="date" data-patient-field="first_chat_date" class="patient-detail-input" value="{{ $patientFirstChatDateValue }}" disabled>
                </div>
                <div class="patient-detail-item full">
                    <div class="patient-detail-label">Alamat Rumah</div>
                    <textarea id="patientDetailAddress" data-patient-field="address" class="patient-detail-textarea" disabled>{{ $patient->address ?? '' }}</textarea>
                </div>
                <div class="patient-detail-item full">
                    <div class="patient-detail-label">Riwayat Alergi</div>
                    <textarea id="patientDetailAllergy" data-patient-field="allergy_history" class="patient-detail-textarea" disabled>{{ $patient->allergy_history ?? '' }}</textarea>
                </div>
            </div>

            <div class="patient-detail-actions">
                <a href="#" class="patient-detail-btn secondary">Tutup</a>
                <button type="button" id="patientDetailEditBtn" class="patient-detail-btn primary" onclick="togglePatientDetailEdit(true)">Edit Data</button>
                <button type="button" id="patientDetailCancelBtn" class="patient-detail-btn secondary hidden" onclick="togglePatientDetailEdit(false)">Batal</button>
                <button type="button" id="patientDetailSaveBtn" class="patient-detail-btn success hidden" onclick="savePatientDetailFromModal()">Simpan</button>
            </div>
        </div>
    </div>
</div>

<div id="patientDetailPhotoCropperModal" class="patient-detail-photo-cropper-modal">
    <div class="patient-detail-photo-cropper-card">
        <div class="patient-detail-photo-cropper-head">
            <h3>Pilih Area Foto Bulat</h3>
            <button type="button" class="patient-detail-photo-cropper-close" onclick="closePatientDetailPhotoCropperModal()">&times;</button>
        </div>
        <div class="patient-detail-photo-cropper-body">
            <p class="patient-detail-photo-cropper-note">Geser area bulat untuk menentukan posisi foto profil.</p>
            <div class="patient-detail-photo-cropper-canvas-wrap">
                <canvas id="patientDetailPhotoCropperCanvas"></canvas>
            </div>
        </div>
        <div class="patient-detail-photo-cropper-actions">
            <button type="button" class="patient-detail-btn secondary" onclick="closePatientDetailPhotoCropperModal()">Batal</button>
            <button type="button" class="patient-detail-btn success" onclick="applyPatientDetailPhotoCrop()">Terapkan Crop</button>
        </div>
    </div>
</div>