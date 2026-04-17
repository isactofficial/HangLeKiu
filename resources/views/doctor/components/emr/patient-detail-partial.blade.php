<style>
    :root {
        --brown-900:#3b331e; --brown-800:#57462c; --brown-700:#6f5635;
        --brown-600:#8e6a45; --brown-500:#b08963; --brown-300:#d8c7b2;
        --brown-200:#eadfd3; --brown-100:#f7f1ea; --brown-50:#fdfaf6;
    }

    #emr-detail-view { width:100% !important; display:block !important; }
    .p-detail-container { width:100% !important; max-width:100% !important; display:block; box-sizing:border-box; }

    /* ── Header profil ── */
    .p-detail-header { width:100%; padding-bottom:25px; border-bottom:1px solid var(--brown-200); margin-bottom:25px; }
    .p-profile-flex  { display:flex; width:100%; gap:30px; align-items:flex-start; }
    .p-avatar-square { width:80px; height:80px; border-radius:50%; background:var(--brown-50); border:1px solid var(--brown-200); object-fit:cover; flex-shrink:0; }

    .p-info-grid {
        flex:1; display:grid;
        grid-template-columns: minmax(250px,1.5fr) minmax(200px,1fr) minmax(200px,1fr);
        gap:20px 40px; width:100%;
    }
    .info-group { display:flex; flex-direction:column; }
    .info-group label { display:flex; align-items:center; gap:6px; font-size:10px; color:var(--brown-800); font-weight:800; text-transform:uppercase; margin-bottom:4px; }
    .info-group label i { color:var(--brown-300); font-size:11px; cursor:pointer; }
    .info-group label i.is-active { color:var(--brown-700); }
    .info-value { font-size:14px; color:var(--brown-600); font-weight:600; line-height:1.4; }
    .name-highlight { font-size:26px; font-weight:800; color:var(--brown-600); letter-spacing:-.5px; margin-top:-3px; }
    .info-link { margin-top:8px; }
    .info-link a { font-size:12px; color:var(--brown-700); text-decoration:none; font-weight:700; }
    .info-link a:hover { text-decoration:underline; }

    /* ── Tabs ── */
    .emr-tabs-nav { display:flex; gap:40px; border-bottom:2px solid var(--brown-100); margin-bottom:30px; }
    .tab-item { background:none; border:none; padding:12px 0; font-weight:700; font-size:14px; color:var(--brown-500); cursor:pointer; position:relative; }
    .tab-item.active { color:var(--brown-800); }
    .tab-item.active::after { content:''; position:absolute; bottom:-2px; left:0; width:100%; height:2px; background:var(--brown-700); }
    .record-tab-btn { transition:all .2s; }
    .record-tab-btn.active { color:var(--brown-800) !important; border-bottom-color:var(--brown-700) !important; }

    /* ── Record table ── */
    .record-table-shell { border:1px solid var(--brown-200); border-radius:12px; background:#fff; overflow:hidden; }
    .record-table-head  { display:grid; background:var(--brown-50); border-bottom:1px solid var(--brown-200); }
    .record-table-head div { padding:12px; font-size:11px; font-weight:800; color:var(--brown-900); text-transform:uppercase; }
    .record-table-row   { display:grid; border-bottom:1px solid #f3ece5; }
    .record-table-row div { padding:12px; }
    .record-table-text  { color:var(--brown-600); font-size:12px; line-height:1.5; }
    .record-empty-state { padding:18px; text-align:center; color:var(--brown-500); font-size:12px; }

    /* ── Timeline ── */
    .emr-content-body    { display:flex; gap:50px; width:100%; align-items:flex-start; justify-content:space-between; }
    .emr-timeline-section{ flex:1 1 auto; width:100%; min-width:0; }
    .timeline-row        { display:flex; gap:20px; width:100%; }
    .timeline-date       { width:65px; text-align:right; color:var(--brown-500); padding-top:5px; flex-shrink:0; }
    .timeline-date .day  { font-size:22px; font-weight:800; color:var(--brown-900); display:block; line-height:1; margin-bottom:2px; }
    .timeline-date .month{ font-size:11px; font-weight:700; text-transform:uppercase; color:var(--brown-500); }
    .timeline-line       { width:20px; position:relative; display:flex; justify-content:center; flex-shrink:0; }
    .line-vertical       { position:absolute; top:0; bottom:-40px; width:2px; background:var(--brown-200); }
    .line-dot            { width:12px; height:12px; border-radius:50%; background:var(--brown-700); z-index:1; margin-top:10px; border:2px solid #fff; box-shadow:0 0 0 1px var(--brown-200); }
    .timeline-content-card { flex:1 1 auto; width:100%; border:1px solid var(--brown-200); border-radius:12px; padding:25px; background:#fff; margin-bottom:30px; box-shadow:0 2px 8px rgba(0,0,0,.02); }
    .card-title          { font-size:15px; color:var(--brown-600); margin-bottom:15px; }
    .doc-link            { color:var(--brown-700); font-weight:700; }
    .tl-split-row        { display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:15px; }
    .tl-split-bottom     { display:flex; justify-content:space-between; align-items:center; }
    .payment-box-static  { background:var(--brown-100); border:1px solid var(--brown-200); border-radius:8px; padding:8px 18px; font-size:13px; font-weight:700; color:var(--brown-800); }
    .card-actions-row    { display:flex; align-items:center; gap:15px; }
    .status-container    { position:relative; display:inline-block; }
    .btn-status-toggle   { color:#fff; border:none; padding:10px 22px; border-radius:8px; font-size:13px; font-weight:800; cursor:pointer; display:flex; align-items:center; gap:12px; }
    .status-menu         { position:absolute; bottom:110%; right:0; background:#fff; border:1px solid var(--brown-200); border-radius:8px; box-shadow:0 10px 25px rgba(0,0,0,.1); z-index:500; list-style:none; padding:5px 0; min-width:150px; }
    .card-time-info      { font-size:13px; color:var(--brown-500); margin:0; }

    /* ── Side actions (tambah diagnosa) ── */
    .emr-side-actions  { flex:0 0 280px; width:280px; display:flex; flex-direction:column; gap:15px; }
    .diagnosa-container{ position:relative; width:100%; }
    .btn-primary-blue  { background:#2563eb; color:#fff; border:none; padding:15px 18px; border-radius:10px; font-weight:700; font-size:13px; width:100%; cursor:pointer; display:flex; justify-content:center; align-items:center; box-shadow:0 4px 12px rgba(37,99,235,.3); transition:.3s; }
    .btn-primary-blue:hover:not(:disabled) { background:#1d4ed8; }
    .btn-primary-blue:disabled { background:#cbd5e0; color:#718096; cursor:not-allowed; box-shadow:none; }
    .diagnosa-dropdown { position:absolute; top:105%; left:0; width:100%; background:#fff; border:1px solid var(--brown-200); border-radius:12px; box-shadow:0 10px 25px rgba(59,51,30,.12); z-index:200; padding:12px; }
    .diag-search-input { width:100%; padding:10px 15px; border:1px solid var(--brown-200); border-radius:8px; font-size:13px; background:var(--brown-50); margin-bottom:12px; box-sizing:border-box; outline:none; }
    .diag-list         { max-height:250px; overflow-y:auto; list-style:none; padding:0; margin:0; }
    .diagnosa-item     { display:block; padding:12px 15px; font-size:13px; font-weight:600; color:var(--brown-800); text-decoration:none; border-radius:8px; }
    .diagnosa-item:hover { background:var(--brown-100); }

    .hidden { display:none !important; }

    /* ── Modal Pop Up Detail Pasien ── */
    .patient-detail-modal {
        position: fixed; inset: 0; background: rgba(28, 22, 14, 0.45); backdrop-filter: blur(4px);
        display: none; align-items: center; justify-content: center; padding: 20px; z-index: 2147483001;
    }
    .patient-detail-modal-card {
        width: min(100%, 760px); max-height: calc(100vh - 40px); overflow: hidden; display: flex; flex-direction: column;
        border-radius: 14px; background: #fff; border: 1px solid var(--brown-200); box-shadow: 0 20px 48px rgba(59, 51, 30, 0.28);
    }
    .patient-detail-modal-head {
        display: flex; align-items: center; justify-content: center; padding: 14px 16px; border-bottom: 1px solid var(--brown-200);
        background: linear-gradient(180deg, #fdf7f1 0%, #ffffff 100%); position: relative;
    }
    .patient-detail-modal-title { margin: 0; font-size: 15px; color: var(--brown-800); font-weight: 800; }
    .patient-detail-modal-close {
        position: absolute; right: 16px; top: 50%; transform: translateY(-50%);
        color: var(--brown-700); font-size: 20px; text-decoration: none; font-weight: 700;
    }
    .patient-detail-modal-body { padding: 20px; overflow-y: auto; }
    .patient-detail-photo-wrap {
        display: flex; align-items: center; gap: 15px; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 1px solid var(--brown-200);
    }
    .patient-detail-photo { width: 70px; height: 70px; border-radius: 50%; object-fit: cover; border: 1px solid var(--brown-200); background: var(--brown-50); }
    .patient-detail-photo-name { font-size: 16px; font-weight: 800; color: var(--brown-800); }
    .patient-detail-photo-rm { font-size: 12px; font-weight: 700; color: var(--brown-500); margin-top: 4px; }
    .pd-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px; }
    .pd-item { border: 1px solid var(--brown-200); border-radius: 10px; padding: 12px; background: var(--brown-50); }
    .pd-item.full { grid-column: 1 / -1; }
    .pd-label { font-size: 10px; font-weight: 800; text-transform: uppercase; color: var(--brown-500); margin-bottom: 6px; }
    .pd-value { font-size: 13px; color: var(--brown-800); font-weight: 600; line-height: 1.4; }
    @media (max-width: 768px) { .pd-grid { grid-template-columns: 1fr; } }
</style>

@php
    $patient            = $appointment->patient;
    $paymentLabel       = $appointment->paymentMethod->name ?? $appointment->guarantorType->name ?? 'Tunai';
    $appointmentTimeText= $appointment->appointment_datetime
        ? \Carbon\Carbon::parse($appointment->appointment_datetime)->format('H:i') : '--:--';
    $statusTextMap      = [
        'pending'=>'dan belum dimulai','confirmed'=>'dan sudah terkonfirmasi',
        'waiting'=>'dan menunggu pemeriksaan','engaged'=>'dan masih berlangsung',
        'succeed'=>'dan sudah selesai','failed'=>'dan dibatalkan',
    ];
    $statusDescription  = $statusTextMap[strtolower((string) $appointment->status)] ?? '';
    $patientDob         = $patient?->date_of_birth;
    $patientDobText     = $patientDob ? \Carbon\Carbon::parse($patientDob)->translatedFormat('d F Y') : '-';
    $patientAgeText     = $patientDob ? \Carbon\Carbon::parse($patientDob)->age . ' Thn' : '-';
    $patientAgeNumber   = $patientDob ? \Carbon\Carbon::parse($patientDob)->age : 0;
    $patientGenderLabel = ($patient->gender ?? '') === 'Male' ? 'Laki-laki' : 'Perempuan';

    /* ── Foto pasien ── */
    $patientPhoto = $patient?->photo ?? '';
    $normalizedPhoto = trim((string) $patientPhoto);
    $looksLikeRawBase64 = $normalizedPhoto !== ''
        && !str_starts_with($normalizedPhoto, 'data:image')
        && !preg_match('/^(https?:\/\/|\/)/i', $normalizedPhoto)
        && !preg_match('/\.(jpg|jpeg|png|gif|webp|svg)$/i', $normalizedPhoto)
        && !str_contains($normalizedPhoto, 'storage/')
        && strlen(preg_replace('/\s+/', '', $normalizedPhoto)) > 120;

    if (str_starts_with($normalizedPhoto, 'data:image'))       { $patientPhotoSrc = $normalizedPhoto; }
    elseif ($looksLikeRawBase64)                               { $patientPhotoSrc = 'data:image/png;base64,' . preg_replace('/\s+/', '', $normalizedPhoto); }
    elseif ($normalizedPhoto !== '')                           { $patientPhotoSrc = asset('storage/' . ltrim($normalizedPhoto, '/')); }
    else                                                       { $patientPhotoSrc = asset('images/avatar-placeholder.png'); }
@endphp

<div class="p-detail-container"
     data-appointment-id="{{ $appointment->id }}"
     data-patient-name="{{ $patient->full_name ?? '-' }}"
     data-patient-rm="{{ $patient->medical_record_no ?? '-' }}"
     data-doctor-name="{{ $appointment->doctor->full_name ?? '-' }}"
     data-patient-demography="{{ $patientDobText }} ({{ $patientAgeText }})">

    {{-- ── 1. HEADER PROFIL ── --}}
    <div class="p-detail-header">
        <div class="p-profile-flex">
            <img src="{{ $patientPhotoSrc }}" class="p-avatar-square" alt="foto pasien">
            <div class="p-info-grid">
                <div class="info-group">
                    <label>NAMA PASIEN</label>
                    <div class="info-value name-highlight">{{ $patient->full_name ?? '-' }}</div>
                </div>
                <div class="info-group">
                    <label>TANGGAL LAHIR / UMUR</label>
                    <div class="info-value">
                        {{ $patientDobText }}
                        <span style="color:#a0aec0; font-weight:400;">({{ $patientAgeText }})</span>
                    </div>
                </div>
                <div></div>

                <div class="info-group">
                    <label>
                        ALAMAT RUMAH
                        <i class="fa fa-eye js-sensitive-toggle is-active"
                           data-sensitive-target="patientAddressValue" title="Tampilkan/Sembunyikan"></i>
                    </label>
                    <div class="info-value"
                         id="patientAddressValue"
                         data-sensitive-original="{{ e($patient->address ?? '-') }}"
                         data-sensitive-visible="1">{{ e($patient->address ?? '-') }}</div>
                    <div class="info-link" style="text-align: left; margin-top: 8px;">
                        <a href="javascript:void(0)" onclick="document.getElementById('patientDetailModal').style.display='flex'">Lihat detail lainnya &gt;</a>
                    </div>
                </div>
                <div class="info-group">
                    <label>
                        NOMOR KTP
                        <i class="fa fa-eye js-sensitive-toggle is-active"
                           data-sensitive-target="patientIdCardValue" title="Tampilkan/Sembunyikan"></i>
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
                           data-sensitive-target="patientPhoneValue" title="Tampilkan/Sembunyikan"></i>
                    </label>
                    <div class="info-value"
                         id="patientPhoneValue"
                         data-sensitive-original="{{ e($patient->phone_number ?? '-') }}"
                         data-sensitive-visible="1">{{ e($patient->phone_number ?? '-') }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── 2. TABS ── --}}
    <div class="emr-tabs-nav">
        <button class="tab-item active" data-tab="timeline">TIMELINE</button>
        <button class="tab-item" data-tab="record">RECORD</button>
    </div>

    {{-- ───────────── TAB: TIMELINE ───────────── --}}
    <div class="emr-content-body" data-tab-content="timeline">

        {{-- Kiri: timeline card --}}
        <div class="emr-timeline-section">
            <div class="timeline-row">
                <div class="timeline-date">
                    <span class="day">{{ \Carbon\Carbon::parse($appointment->appointment_datetime)->format('d') }}</span>
                    <span class="month">{{ \Carbon\Carbon::parse($appointment->appointment_datetime)->format('M Y') }}</span>
                </div>
                <div class="timeline-line"><div class="line-vertical"></div><div class="line-dot"></div></div>
                <div class="timeline-content-card">
                    <div class="card-title">
                        Poli <strong>{{ $appointment->doctor->specialization ?? 'Gigi' }}</strong>
                        dengan <span class="doc-link">drg. {{ $appointment->doctor->full_name }}</span>
                    </div>

                    {{-- Baris 1: Pembayaran & Status --}}
                    <div class="tl-split-row">
                        <div class="payment-box-static">Metode Pembayaran: {{ $paymentLabel }}</div>

                        <div class="card-actions-row">
                            <div class="status-container">
                                <button class="btn-status-toggle"
                                        style="background-color:{{ $appointment->status_color ?? '#3B82F6' }}"
                                        onclick="event.stopPropagation(); document.getElementById('status-menu-dynamic').classList.toggle('hidden')">
                                    <span class="status-current-text">{{ strtoupper($appointment->status) }}</span>
                                    <i class="fa fa-chevron-down"></i>
                                </button>

                                @php
                                    $orderedStatuses  = ['pending','confirmed','waiting','engaged','succeed'];
                                    $currentStatus    = strtolower((string) $appointment->status);
                                    $currentIdx       = array_search($currentStatus, $orderedStatuses, true);
                                    $statusOptionColors = [
                                        'pending'=>'#6B7280','confirmed'=>'#F59E0B','waiting'=>'#8B5CF6',
                                        'engaged'=>'#3B82F6','succeed'=>'#84CC16','failed'=>'#EF4444',
                                    ];

                                    if ($currentStatus === 'succeed') {
                                        $statuses = collect(['failed']);
                                    } elseif ($currentStatus !== 'failed') {
                                        $statuses = collect($currentIdx !== false
                                            ? array_slice($orderedStatuses, $currentIdx + 1)
                                            : $orderedStatuses);
                                        $statuses->push('failed');
                                    } else {
                                        $statuses = collect();
                                    }
                                    $statuses = $statuses->unique()->values();
                                @endphp

                                <ul class="status-menu hidden" id="status-menu-dynamic">
                                    @foreach($statuses as $st)
                                    <li>
                                        <a href="javascript:void(0)"
                                           onclick="processUpdateStatus('{{ route('doctor.emr.updateStatus', $appointment->id) }}', '{{ $st }}')"
                                           data-status-option="{{ $st }}"
                                           data-option-color="{{ $statusOptionColors[$st] ?? '#4B5563' }}"
                                           style="display:block;margin:4px 8px;padding:8px 12px;border-radius:7px;font-size:12px;color:#fff;font-weight:700;text-transform:uppercase;text-decoration:none;background:{{ $statusOptionColors[$st] ?? '#4B5563' }};">
                                            {{ $st }}
                                        </a>
                                    </li>
                                    @endforeach
                                    <li id="status-no-option" style="display:none;margin:4px 8px;padding:8px 12px;border-radius:7px;font-size:12px;color:#8b5e3c;background:#f7f1ea;font-weight:700;text-transform:uppercase;">
                                        Tidak ada status lanjutan
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    {{-- Baris 2: Waktu --}}
                    <div class="tl-split-bottom">
                        <p class="card-time-info">{{ $appointmentTimeText }} WIB {{ $statusDescription }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kanan: Tambah Diagnosa (hanya tampil bila engaged) --}}
        <div class="emr-side-actions">
            <div class="diagnosa-container">
                <button class="btn-primary-blue"
                        onclick="toggleDiagnosaMenu(event)"
                        {{ ($appointment->status ?? '') !== 'engaged' ? 'disabled' : '' }}>
                    <span>+ TAMBAH DIAGNOSA</span>
                </button>

                <div class="diagnosa-dropdown hidden" id="diagnosa-menu">
                    <input type="text" id="diagSearchInput" onkeyup="filterDiagnosaList()"
                           placeholder="Cari fitur medis..." class="diag-search-input">
                    <ul class="diag-list" id="diagList">
                        <li>
                            <a href="javascript:void(0)" class="diagnosa-item"
                               onclick="toggleProsedureModal(true, {
                                   name: @js($patient->full_name ?? '-'),
                                   rm: @js($patient->medical_record_no ?? '-'),
                                   gender: @js($patientGenderLabel),
                                   age: @js($patientAgeNumber . ' Tahun'),
                                   payment: @js($paymentLabel),
                                   patient_id: @js($appointment->patient_id ?? ''),
                                   registration_id: @js($appointment->id ?? ''),
                                   doctor_id: @js($appointment->doctor_id ?? ''),
                                   doctor_name: @js($appointment->doctor->full_name ?? '')
                               })">Tambah Prosedur</a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" class="diagnosa-item"
                               onclick="toggleOdontogramModal(true, {
                                   name: @js($patient->full_name ?? '-'),
                                   rm: @js($patient->medical_record_no ?? '-'),
                                   gender: @js($patientGenderLabel),
                                   age: @js($patientAgeNumber . ' Tahun'),
                                   payment: @js($paymentLabel),
                                   patient_id: @js($appointment->patient_id ?? ''),
                                   registration_id: @js($appointment->id ?? ''),
                                   doctor_id: @js($appointment->doctor_id ?? ''),
                                   doctor_name: @js($appointment->doctor->full_name ?? '')
                               })">Tambah Odontogram</a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" class="diagnosa-item"
                               onclick="openDoctorNoteModalFromDetail()">Tambah Catatan Dokter</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- ───────────── TAB: RECORD ───────────── --}}
    <div class="hidden" data-tab-content="record" style="padding-top:12px;">
        <div style="display:flex;gap:12px;border-bottom:1px solid #e5e7eb;margin-bottom:14px;">
            <button class="record-tab-btn active" data-record-tab="rekam-medis"
                    style="border:none;background:none;padding:10px 4px;font-weight:700;border-bottom:2px solid var(--brown-700);cursor:pointer;">
                REKAM MEDIS
            </button>
            <button class="record-tab-btn" data-record-tab="catatan-dokter"
                    style="border:none;background:none;padding:10px 4px;font-weight:700;border-bottom:2px solid transparent;cursor:pointer;">
                CATATAN DOKTER
            </button>
            <button class="record-tab-btn" data-record-tab="odontogram-history"
                    style="border:none;background:none;padding:10px 4px;font-weight:700;border-bottom:2px solid transparent;cursor:pointer;">
                ODONTOGRAM
            </button>
        </div>

        {{-- Rekam Medis --}}
        <div data-record-tab-content="rekam-medis">
            <div class="record-table-shell">
                <div class="record-table-head" style="grid-template-columns:190px 260px 1fr 150px 130px;">
                    <div>Tanggal Kunjungan</div>
                    <div>Dokter</div>
                    <div>Tindakan Prosedur / Obat</div>
                    <div>No Gigi</div>
                    <div>Status</div>
                </div>

                @php
                    $sortedRegs = collect($patientRegistrations ?? collect())
                        ->sortByDesc(fn ($r) => $r->created_at ?? $r->appointment_datetime)
                        ->values();
                @endphp

                @forelse($sortedRegs as $reg)
                    @php
                        $primaryDoctorName = $reg->doctor->full_name
                            ?? optional($reg->medicalProcedures->first()?->doctor)->full_name
                            ?? '-';

                        $assistantDoctorNames = $reg->medicalProcedures
                            ->flatMap(fn ($p) => $p->relationLoaded('assistants')
                                ? $p->assistants->map(fn ($a) => optional($a->doctor)->full_name)
                                : collect())
                            ->filter()->reject(fn ($n) => $n === $primaryDoctorName)
                            ->unique()->values();

                        $doctorDisplayNames = collect([$primaryDoctorName])
                            ->merge($assistantDoctorNames)->filter()->values();

                        $procedureNames = $reg->medicalProcedures
                            ->flatMap(fn ($mp) => $mp->items)
                            ->map(fn ($i) => optional($i->masterProcedure)->procedure_name ?? optional($i->masterProcedure)->name)
                            ->filter()->unique()->values();

                        $medicineNames = $reg->medicalProcedures
                            ->flatMap(fn ($mp) => $mp->medicines)
                            ->map(fn ($m) => optional($m->medicine)->medicine_name)
                            ->filter()->unique()->values();

                        $bhpNames = $reg->medicalProcedures
                            ->flatMap(fn ($mp) => $mp->bhpUsages)
                            ->map(fn ($u) => optional($u->item)->item_name)
                            ->filter()->unique()->values();

                        $toothNumbers = $reg->medicalProcedures
                            ->flatMap(fn ($mp) => $mp->items)
                            ->pluck('tooth_numbers')->filter()
                            ->flatMap(fn ($v) => collect(preg_split('/\s*,\s*/', (string)$v, -1, PREG_SPLIT_NO_EMPTY)))
                            ->unique()->values();
                    @endphp
                    <div class="record-table-row" style="grid-template-columns:190px 260px 1fr 150px 130px;">
                        <div class="record-table-text" style="font-weight:600;">
                            {{ optional($reg->created_at ?? $reg->appointment_datetime)->translatedFormat('d F Y') }}
                        </div>
                        <div class="record-table-text" style="font-weight:600;line-height:1.5;">
                            @if($doctorDisplayNames->count() <= 1)
                                <div>{{ $doctorDisplayNames->first() ?? '-' }}</div>
                            @else
                                @foreach($doctorDisplayNames as $n)
                                    <div style="color:#8e6a45;">&gt; {{ $n }}</div>
                                @endforeach
                            @endif
                        </div>
                        <div class="record-table-text">
                            <div><strong>Prosedur</strong> {{ $procedureNames->isNotEmpty() ? $procedureNames->implode(', ') : '-' }}</div>
                            <div><strong>Obat</strong> {{ $medicineNames->isNotEmpty() ? $medicineNames->implode(', ') : '-' }}</div>
                            <div><strong>BHP</strong> {{ $bhpNames->isNotEmpty() ? $bhpNames->implode(', ') : '-' }}</div>
                        </div>
                        <div class="record-table-text" style="font-weight:600;">{{ $toothNumbers->isNotEmpty() ? $toothNumbers->implode(', ') : '-' }}</div>
                        <div class="record-table-text" style="font-weight:700;text-transform:uppercase;">{{ $reg->status ?? '-' }}</div>
                    </div>
                @empty
                    <div class="record-empty-state">Belum ada histori kunjungan.</div>
                @endforelse
            </div>
        </div>

        {{-- Catatan Dokter --}}
        <div class="hidden" data-record-tab-content="catatan-dokter">
            <div class="record-table-shell">
                <div class="record-table-head" style="grid-template-columns:180px 300px 1fr;">
                    <div>Tanggal</div>
                    <div>Dokter</div>
                    <div>Catatan</div>
                </div>

                @php
                    $sortedNotes = collect($doctorNotes ?? collect())
                        ->sortByDesc(fn ($n) => data_get($n, 'created_at'))
                        ->values();
                @endphp

                @forelse($sortedNotes as $note)
                    @php
                        $noteDoctorName  = $note['doctor_name'] ?? '-';
                        $noteAssistants  = collect($note['assistant_names'] ?? [])
                            ->filter()->reject(fn ($n) => $n === $noteDoctorName)->unique()->values();
                    @endphp
                    <div class="record-table-row" style="grid-template-columns:180px 300px 1fr;">
                        <div class="record-table-text" style="font-weight:600;">
                            {{ optional($note['created_at'] ?? null)->translatedFormat('d F Y') ?? ($note['created_at_label'] ?? '-') }}
                        </div>
                        <div class="record-table-text" style="font-weight:700;line-height:1.5;">
                            <div>{{ $noteDoctorName }}</div>
                            @foreach($noteAssistants as $an)
                                <div style="color:#8e6a45;">&gt; {{ $an }}</div>
                            @endforeach
                        </div>
                        <div style="padding:10px 12px;">
                            <div style="display:grid;grid-template-columns:150px minmax(0,1fr);gap:6px 12px;align-items:start;">
                                @foreach([['Subjectives',$note['subjective']??''],['Objectives',$note['objective']??''],['Plans',$note['plan']??'']] as [$label,$value])
                                    <div style="font-size:11px;color:var(--brown-500);font-weight:800;text-transform:uppercase;">{{ $label }}</div>
                                    <div class="record-table-text" style="line-height:1.35;">{{ $value !== '' ? $value : '-' }}</div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @empty
                    <div id="doctor-note-empty" class="record-empty-state">Belum ada catatan dokter.</div>
                @endforelse
            </div>
        </div>

        {{-- Odontogram History --}}
        <div class="hidden" data-record-tab-content="odontogram-history">
            <div class="record-table-shell">
                <div class="record-table-head" style="grid-template-columns:180px 250px 1fr 120px;">
                    <div>Tanggal Periksa</div>
                    <div>Pemeriksa</div>
                    <div>Catatan</div>
                    <div>Aksi</div>
                </div>

                @forelse($odontogramRecords ?? [] as $rec)
                    <div class="record-table-row" style="grid-template-columns:180px 250px 1fr 120px;">
                        <div class="record-table-text" style="font-weight:600;">
                            {{ $rec->examined_at ? \Carbon\Carbon::parse($rec->examined_at)->translatedFormat('d F Y') : '-' }}
                        </div>
                        <div class="record-table-text" style="font-weight:700;">{{ $rec->examined_by ?? '-' }}</div>
                        <div class="record-table-text">{{ $rec->notes ?? '-' }}</div>
                        <div class="record-table-text">
                            <button type="button" 
                                    style="padding:6px 12px; background:var(--brown-700); color:white; border:none; border-radius:6px; cursor:pointer; font-size:11px; font-weight:700;"
                                    onclick="toggleOdontogramModal(true, {
                                        name: @js($patient->full_name ?? '-'),
                                        rm: @js($patient->medical_record_no ?? '-'),
                                        gender: @js($patientGenderLabel),
                                        age: @js($patientAgeNumber . ' Tahun'),
                                        payment: @js($paymentLabel),
                                        patient_id: @js($appointment->patient_id ?? ''),
                                        registration_id: @js($rec->visit_id ?? ''),
                                        record_id: @js($rec->id)
                                    })">
                                <i class="fa fa-eye"></i> LIHAT
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="record-empty-state">Belum ada riwayat odontogram pasien.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<div id="patientDetailModal" class="patient-detail-modal">
    <div class="patient-detail-modal-card">
        <div class="patient-detail-modal-head">
            <h3 class="patient-detail-modal-title">Detail Lengkap Pasien</h3>
            <a href="javascript:void(0)" class="patient-detail-modal-close" title="Tutup" onclick="document.getElementById('patientDetailModal').style.display='none'">✕</a>
        </div>
        <div class="patient-detail-modal-body">
            <div class="patient-detail-photo-wrap">
                <img src="{{ $patientPhotoSrc }}" alt="Foto pasien" class="patient-detail-photo">
                <div>
                    <div class="patient-detail-photo-name">{{ $patient->full_name ?? '-' }}</div>
                    <div class="patient-detail-photo-rm">RM: {{ $patient->medical_record_no ?? '-' }}</div>
                </div>
            </div>

            <div class="pd-grid">
                <div class="pd-item"><div class="pd-label">ID Pasien</div><div class="pd-value">{{ $patient->id ?? '-' }}</div></div>
                <div class="pd-item"><div class="pd-label">Email</div><div class="pd-value">{{ $patient->email ?? '-' }}</div></div>
                <div class="pd-item"><div class="pd-label">Tanggal Lahir</div><div class="pd-value">{{ $patientDobText }} ({{ $patientAgeText }})</div></div>
                <div class="pd-item"><div class="pd-label">Jenis Kelamin</div><div class="pd-value">{{ $patientGenderLabel }}</div></div>
                <div class="pd-item"><div class="pd-label">Golongan Darah</div><div class="pd-value">{{ $patient->blood_type ?? '-' }}</div></div>
                <div class="pd-item"><div class="pd-label">Rhesus</div><div class="pd-value">{{ $patient->rhesus ?? '-' }}</div></div>
                <div class="pd-item"><div class="pd-label">Nomor HP</div><div class="pd-value">{{ $patient->phone_number ?? '-' }}</div></div>
                <div class="pd-item"><div class="pd-label">Nomor KTP</div><div class="pd-value">{{ $patient->id_card_number ?? '-' }}</div></div>
                <div class="pd-item"><div class="pd-label">Kota</div><div class="pd-value">{{ $patient->city ?? '-' }}</div></div>
                <div class="pd-item"><div class="pd-label">Agama</div><div class="pd-value">{{ $patient->religion ?? '-' }}</div></div>
                <div class="pd-item"><div class="pd-label">Pendidikan</div><div class="pd-value">{{ $patient->education ?? '-' }}</div></div>
                <div class="pd-item"><div class="pd-label">Pekerjaan</div><div class="pd-value">{{ $patient->occupation ?? '-' }}</div></div>
                <div class="pd-item"><div class="pd-label">Status Perkawinan</div><div class="pd-value">{{ $patient->marital_status ?? '-' }}</div></div>
                <div class="pd-item"><div class="pd-label">Tgl. Chat Pertama</div><div class="pd-value">{{ $patient->first_chat_date ? \Carbon\Carbon::parse($patient->first_chat_date)->translatedFormat('d F Y') : '-' }}</div></div>
                
                <div class="pd-item full"><div class="pd-label">Alamat Lengkap</div><div class="pd-value">{{ $patient->address ?? '-' }}</div></div>
                <div class="pd-item full"><div class="pd-label">Riwayat Alergi</div><div class="pd-value" style="color: #d97706;">{{ $patient->allergy_history ?: 'Tidak ada riwayat alergi' }}</div></div>
            </div>
            
            <div style="margin-top: 20px; display: flex; justify-content: flex-end;">
                <a href="javascript:void(0)" onclick="document.getElementById('patientDetailModal').style.display='none'" style="background: var(--brown-800); color: #fff; padding: 10px 20px; border-radius: 8px; font-weight: 700; font-size: 13px; text-decoration: none;">Tutup</a>
            </div>
        </div>
    </div>
</div>