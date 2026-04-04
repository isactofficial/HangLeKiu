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
    .info-group label { display: flex; align-items: center; gap: 6px; font-size: 10px; color: var(--brown-500); font-weight: 800; text-transform: uppercase; margin-bottom: 4px; }
    .info-group label i { color: var(--brown-300); font-size: 11px; cursor: pointer; }
    .info-value { font-size: 14px; color: var(--brown-800); font-weight: 600; line-height: 1.4; }
    .name-highlight { font-size: 26px; font-weight: 800; color: var(--brown-900); letter-spacing: -0.5px; margin-top: -3px; }
    
    .info-link { margin-top: 8px; }
    .info-link a { font-size: 12px; color: var(--brown-700); text-decoration: none; font-weight: 700; transition: 0.2s; }
    .info-link a:hover { text-decoration: underline; color: var(--brown-900); }

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
        color: var(--brown-500);
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
        color: var(--brown-800);
        font-size: 12px;
        line-height: 1.5;
    }

    .record-table-text strong {
        color: var(--brown-900);
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
    .card-title { font-size: 15px; color: var(--brown-800); margin-bottom: 15px; }
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
    $patientGenderLabel = ($patient->gender ?? '') === 'Male' ? 'Laki-laki' : 'Perempuan';
    $patientPhoto = $patient?->photo ?? '';
    $patientPhotoSrc = str_starts_with((string) $patientPhoto, 'data:image')
        ? $patientPhoto
        : ($patientPhoto ? asset('storage/' . $patientPhoto) : asset('images/avatar-placeholder.png'));
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
                    <label>ALAMAT RUMAH <i class="fa fa-eye-slash"></i></label>
                    <div class="info-value">{{ $patient->address ?? '-' }}</div>
                    <div class="info-link" style="text-align: left; margin-top: 8px;">
                        <a href="#">Lihat data lainnya ></a>
                    </div>
                </div>
                <div class="info-group">
                    <label>NOMOR KTP <i class="fa fa-eye-slash"></i></label>
                    <div class="info-value">{{ $patient->id_card_number ?? '-' }}</div>
                </div>
                <div class="info-group">
                    <label>NOMOR HP <i class="fa fa-eye-slash"></i></label>
                    <div class="info-value">{{ $patient->phone_number ?? '-' }}</div>
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

                @forelse(($patientRegistrations ?? collect()) as $reg)
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

                @forelse(($doctorNotes ?? collect()) as $note)
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