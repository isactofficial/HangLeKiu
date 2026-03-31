<style>
    /* ================= 1. FORCING FULL WIDTH ================= */
    #emr-detail-view { width: 100% !important; display: block !important; }
    .p-detail-container { width: 100% !important; max-width: 100% !important; display: block; box-sizing: border-box; }

    /* ================= 2. PROFIL HEADER ================= */
    .p-detail-header { width: 100%; padding-bottom: 25px; border-bottom: 1px solid #edf2f7; margin-bottom: 25px; }
    .p-profile-flex { display: flex; width: 100%; gap: 30px; align-items: flex-start; }
    
    /* Foto Profil Kotak & Diperbesar */
    .p-avatar-square { 
        width: 80px; height: 80px; border-radius: 10px; 
        background: #f8f9fa; border: 1px solid #e2e8f0; 
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
    .info-group label { display: flex; align-items: center; gap: 6px; font-size: 10px; color: #a0aec0; font-weight: 800; text-transform: uppercase; margin-bottom: 4px; }
    .info-group label i { color: #cbd5e0; font-size: 11px; cursor: pointer; }
    .info-value { font-size: 14px; color: #2d3748; font-weight: 600; line-height: 1.4; }
    .name-highlight { font-size: 26px; font-weight: 800; color: #1a202c; letter-spacing: -0.5px; margin-top: -3px; }
    
    .info-link { margin-top: 8px; }
    .info-link a { font-size: 12px; color: #3182ce; text-decoration: none; font-weight: 700; transition: 0.2s; }
    .info-link a:hover { text-decoration: underline; color: #2b6cb0; }

    /* ================= 3. TABS NAV ================= */
    .emr-tabs-nav { display: flex; gap: 40px; border-bottom: 2px solid #f7fafc; margin-bottom: 30px; width: 100%; }
    .tab-item { background: none; border: none; padding: 12px 0; font-weight: 700; font-size: 14px; color: #a0aec0; cursor: pointer; position: relative; }
    .tab-item.active { color: #9333ea; }
    .tab-item.active::after { content: ''; position: absolute; bottom: -2px; left: 0; width: 100%; height: 2px; background: #db2777; }

    /* ================= 4. CONTENT BODY ================= */
    .emr-content-body { display: flex; gap: 50px; width: 100%; align-items: flex-start; justify-content: space-between; }
    
    .emr-timeline-section { flex: 1 1 auto; width: 100%; min-width: 0; }
    .timeline-row { display: flex; gap: 20px; width: 100%; }
    .timeline-date { width: 65px; text-align: right; color: #718096; padding-top: 5px; flex-shrink: 0; }
    .timeline-date .day { font-size: 22px; font-weight: 800; color: #2d3748; display: block; line-height: 1; margin-bottom: 2px; }
    .timeline-date .month { font-size: 11px; font-weight: 700; text-transform: uppercase; color: #718096; }

    .timeline-line { width: 20px; position: relative; display: flex; justify-content: center; flex-shrink: 0; }
    .line-vertical { position: absolute; top: 0; bottom: -40px; width: 2px; background: #edf2f7; }
    .line-dot { width: 12px; height: 12px; border-radius: 50%; background: #1e3a8a; z-index: 1; margin-top: 10px; border: 2px solid #fff; box-shadow: 0 0 0 1px #edf2f7; }

    .timeline-content-card { 
        flex: 1 1 auto; width: 100%;
        border: 1px solid #e2e8f0; border-radius: 12px; 
        padding: 25px; background: #fff; margin-bottom: 30px; 
        box-shadow: 0 2px 8px rgba(0,0,0,0.02); 
    }
    .card-title { font-size: 15px; color: #4a5568; margin-bottom: 15px; }
    .doc-link { color: #3182ce; font-weight: 700; }

    /* LAYOUT KIRI-KANAN TIMELINE */
    .tl-split-row { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 15px; }
    .tl-split-bottom { display: flex; justify-content: space-between; align-items: center; }

    .payment-box-static {
        background: #fdf6e3; border: 1px solid #e2e8f0; border-radius: 8px;
        padding: 8px 18px; font-size: 13px; font-weight: 700; color: #4a5568;
        margin: 0; /* Hapus margin agar rapi di flex */
    }

    .card-actions-row { display: flex; align-items: center; gap: 15px; }
    .icon-action { color: #a0aec0; cursor: pointer; font-size: 18px; transition: 0.2s; }
    .icon-action:hover { color: #3182ce; }
    
    .status-container { position: relative; display: inline-block; }
    .btn-status-toggle { 
        color: #fff; border: none; padding: 10px 22px; border-radius: 8px; 
        font-size: 13px; font-weight: 800; cursor: pointer; display: flex; align-items: center; gap: 12px;
    }
    .status-menu {
        position: absolute; bottom: 110%; right: 0; background: white; border: 1px solid #e2e8f0;
        border-radius: 8px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); z-index: 500; list-style: none; padding: 5px 0; min-width: 150px;
    }
    .status-menu li a { display: block; padding: 10px 15px; font-size: 13px; color: #4a5568; text-decoration: none; font-weight: 600; text-align: left; }
    .status-menu li a:hover { background: #f0f7ff; color: #3182ce; }

    .card-time-info { font-size: 13px; color: #a0aec0; margin: 0; }

    /* ================= 5. RIGHT ACTIONS ================= */
    .emr-side-actions { flex: 0 0 280px; width: 280px; display: flex; flex-direction: column; gap: 15px; }
    .diagnosa-container { position: relative; width: 100%; }
    .btn-primary-brown { 
        background: #3b331e; color: #fff; border: none; padding: 15px 18px; 
        border-radius: 10px; font-weight: 700; font-size: 13px; width: 100%; 
        cursor: pointer; display: flex; justify-content: space-between; align-items: center;
        box-shadow: 0 4px 12px rgba(59, 51, 30, 0.2);
        transition: 0.3s;
    }
    .btn-primary-brown:hover:not(:disabled) { background: #2a2415; }
    .btn-primary-brown:disabled { 
        background: #cbd5e0; color: #718096; cursor: not-allowed; 
        box-shadow: none; 
    }
    .diagnosa-dropdown { position: absolute; top: 105%; left: 0; width: 100%; background: white; border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.15); z-index: 200; padding: 12px; }
    .diag-search-input { width: 100%; padding: 10px 15px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 13px; background: #f8fafc; margin-bottom: 12px; box-sizing: border-box; outline: none; }
    .diag-list { max-height: 250px; overflow-y: auto; list-style: none; padding: 0; margin: 0; }
    .diagnosa-item { display: block; padding: 12px 15px; font-size: 13px; font-weight: 600; color: #4a5568; text-decoration: none; border-radius: 8px; }
    .diagnosa-item:hover { background-color: #f5f5f5; color: #3b331e; }

    .btn-outline-brown { background: #fff; color: #3b331e; border: 2px solid #3b331e; padding: 15px 18px; border-radius: 10px; font-weight: 700; font-size: 13px; width: 100%; cursor: pointer; transition: 0.3s; }
    .btn-outline-brown:hover { background: #3b331e; color: #fff; }
    .riwayat-accordion { margin-top: 15px; padding: 15px 0; border-top: 1px solid #edf2f7; display: flex; justify-content: space-between; align-items: center; cursor: pointer; font-size: 14px; font-weight: 800; color: #2d3748; }
    
    .hidden { display: none !important; }
</style>

<div class="p-detail-container">
    
    {{-- 1. HEADER PROFIL --}}
    <div class="p-detail-header">
        <div class="p-profile-flex">
            <div class="p-avatar-wrapper">
                <img src="{{ $appointment->patient->photo ? asset('storage/'.$appointment->patient->photo) : asset('images/avatar-placeholder.png') }}" class="p-avatar-square">
            </div>
            
            <div class="p-info-grid">
                <div class="info-group">
                    <label>NAMA PASIEN</label>
                    <div class="info-value name-highlight">{{ $appointment->patient->full_name }}</div>
                </div>
                <div class="info-group">
                    <label>TANGGAL LAHIR / UMUR</label>
                    <div class="info-value">
                        {{ \Carbon\Carbon::parse($appointment->patient->date_of_birth)->translatedFormat('d F Y') }}
                        <span style="color: #a0aec0; font-weight: 400;">({{ \Carbon\Carbon::parse($appointment->patient->date_of_birth)->age }} Thn)</span>
                    </div>
                </div>
                <div></div>
                
                <div class="info-group">
                    <label>ALAMAT RUMAH <i class="fa fa-eye-slash"></i></label>
                    <div class="info-value">{{ $appointment->patient->address ?? '-' }}</div>
                    <div class="info-link" style="text-align: left; margin-top: 8px;">
                        <a href="#">Lihat data lainnya ></a>
                    </div>
                </div>
                <div class="info-group">
                    <label>NOMOR KTP <i class="fa fa-eye-slash"></i></label>
                    <div class="info-value">{{ $appointment->patient->ktp_number ?? '-' }}</div>
                </div>
                <div class="info-group">
                    <label>NOMOR HP <i class="fa fa-eye-slash"></i></label>
                    <div class="info-value">{{ $appointment->patient->phone_number ?? '-' }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- 2. TABS --}}
    <div class="emr-tabs-nav">
        <button class="tab-item active" data-tab="timeline">TIMELINE</button>
        <button class="tab-item" data-tab="record">RECORD</button>
        <button class="tab-item" data-tab="cppt">CPPT</button>
    </div>

    {{-- 3. TIMELINE & KANAN --}}
    <div class="emr-content-body">
        
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
                            Metode Pembayaran: {{ $appointment->payment_method ?? 'Tunai' }}
                        </div>
                        
                        <div class="card-actions-row">
                            @if($appointment->status == 'succeed')
                                <a href="{{ route('admin.cashier') }}" class="btn-ke-kasir" style="background: #10b981; color: white; padding: 6px 12px; border-radius: 8px; font-weight: 800; font-size: 11px; text-decoration: none; display: flex; align-items: center; gap: 5px; margin-right: 5px;">
                                    <i class="fa fa-wallet"></i> KE KASIR
                                </a>
                            @endif
                            <i class="fa fa-print icon-action"></i>
                            <i class="fa fa-eye icon-action"></i>
                            
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
                                        $statuses = ['pending', 'confirmed', 'waiting', 'engaged', 'succeed'];
                                    @endphp

                                    @foreach($statuses as $st)
                                    <li>
                                        <a href="javascript:void(0)" 
                                        onclick="processUpdateStatus('{{ route('admin.appointments.updateStatus', $appointment->id) }}', '{{ $st }}')" 
                                        style="display:block; padding:10px 15px; font-size:12px; color:#444; text-decoration:none; font-weight:600; text-transform: uppercase;">
                                        {{ $st }}
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                               
                            </div>
                        </div>
                    </div>
                    
                    {{-- ROW 2: Jam Berlangsung (Kiri) & CPPT (Kanan) --}}
                    <div class="tl-split-bottom">
                        <div class="card-time-info">
                            {{ \Carbon\Carbon::parse($appointment->appointment_datetime)->format('H:i') }} WIB dan masih berlangsung
                        </div>
                        <br>
                        {{-- Diberi margin-right agar sejajar lurus dengan dropdown status di atasnya --}}
                        <a href="#" style="color:#3182ce; font-size:13px; font-weight:700; text-decoration:underline; margin-left: 5px;">CPPT</a>
                    </div>

                </div>
            </div>
        </div>

        {{-- KANAN: ACTIONS --}}
        <div class="emr-side-actions">
            <div class="diagnosa-container">
                <button class="btn-primary-brown" onclick="toggleDiagnosaMenu(event)" {{ ($appointment->status ?? '') !== 'engaged' ? 'disabled' : '' }}>
                    <span>+ TAMBAH DIAGNOSA</span>
                    <i class="fa fa-chevron-down"></i>
                </button>
                <div class="diagnosa-dropdown hidden" id="diagnosa-menu">
                    <input type="text" id="diagSearchInput" onkeyup="filterDiagnosaList()" placeholder="Cari fitur medis..." class="diag-search-input">
                    <ul class="diag-list" id="diagList">
                        <li><a href="javascript:void(0)" class="diagnosa-item" onclick="toggleProsedureModal(true, {
                                name: '{{ $appointment->patient->full_name ?? '-' }}',
                                rm: '{{ $appointment->patient->medical_record_no ?? '-' }}',
                                gender: '{{ ($appointment->patient->gender ?? '') == 'Male' ? 'Laki-laki' : 'Perempuan' }}',
                                age: '{{ \Carbon\Carbon::parse($appointment->patient->date_of_birth)->age ?? 0 }} Tahun',
                                payment: '{{ $appointment->guarantorType->name ?? 'Tunai' }}',
                                patient_id: '{{ $appointment->patient_id ?? '' }}',
                                registration_id: '{{ $appointment->id ?? '' }}',
                                doctor_id: '{{ $appointment->doctor_id ?? '' }}',
                                doctor_name: '{{ $appointment->doctor->full_name ?? '' }}'
                            })">
                                Tambah Prosedur
                            </a></li>
                        <li><a href="javascript:void(0)" class="diagnosa-item" onclick="toggleOdontogramModal(true, {
                                    name: '{{ $appointment->patient->full_name ?? '-' }}',
                                    rm: '{{ $appointment->patient->medical_record_no ?? '-' }}',
                                    gender: '{{ ($appointment->patient->gender ?? '') == 'Male' ? 'Laki-laki' : 'Perempuan' }}',
                                    age: '{{ \Carbon\Carbon::parse($appointment->patient->date_of_birth)->age ?? 0 }} Tahun',
                                    payment: '{{ $appointment->guarantorType->name ?? 'Tunai' }}',
                                    patient_id: '{{ $appointment->patient_id ?? '' }}',
                                    registration_id: '{{ $appointment->id ?? '' }}',
                                    doctor_id: '{{ $appointment->doctor_id ?? '' }}',
                                    doctor_name: '{{ $appointment->doctor->full_name ?? '' }}'
                                })">Tambah Odontogram</a></li>
                    </ul>
                </div>
            </div>
            
            <button class="btn-outline-brown">PRINT REKAM MEDIS</button>
            
            <div class="riwayat-accordion">
                <span>RIWAYAT PENYAKIT</span>
                <i class="fa fa-chevron-down"></i>
            </div>
        </div>
    </div>
</div>
<script>
    const detailViewParent = document.getElementById('emr-detail-view');
    if (detailViewParent) detailViewParent.style.width = '100%';

    // FUNGSI UPDATE STATUS YANG SUDAH TERKONEKSI
    function processUpdateStatus(url, newStatus) {
        fetch(url, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ status: newStatus })
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                // Jika sukses, kita klik ulang pasien yang aktif di sidebar
                // Ini akan memicu AJAX load ulang sehingga warna tombol status
                // dan badge di sidebar langsung berubah otomatis (Realtime feel!)
                const activePatientCard = document.querySelector('.patient-card.active');
                if(activePatientCard) {
                    activePatientCard.parentElement.click(); 
                }
            } else {
                alert("Gagal update status boss!");
            }
        })
        .catch(err => {
            console.error("Error:", err);
            alert("Terjadi kesalahan jaringan.");
        });
    }

    // Menutup dropdown status kalau diklik di luar area
    window.addEventListener('click', function() {
        const menu = document.getElementById('status-menu-dynamic');
        if(menu) menu.classList.add('hidden');
    });
</script>