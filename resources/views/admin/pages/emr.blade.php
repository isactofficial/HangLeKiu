@extends('admin.layout.admin')
@section('title', 'Electronic Medical Record')

@section('navbar')
    @include('admin.components.navbarSearch', ['title' => 'Electronic Medical Record'])
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/pages/emr.css') }}">
    <style>
        /* ================= 1. LAYOUT SIDEBAR & MAIN (FULL WIDTH) ================= */
        .emr-layout { 
            display: flex; 
            gap: 20px; /* Jarak antara sidebar dan konten utama sedikit dirapatkan */
            align-items: flex-start; 
            width: 100%; 
            margin-top: 20px;
        }

        /* LEBAR SIDEBAR DIPERKECIL (Kanan-Kiri) */
        .emr-sidebar { 
            width: 260px; /* Awalnya 320px, sekarang jauh lebih ramping */
            flex-shrink: 0; 
        }

        .emr-main { 
            flex: 1; 
            background-color: #fff; 
            border: 1px solid #eef2f7; 
            border-radius: 15px; 
            padding: 20px; 
            position: relative; 
            min-height: 80vh; 
        }

        /* ================= 2. SKALA FOTO PROFIL ================= */
        .p-avatar-circle { 
            width: 30px; 
            height: 30px; 
            border-radius: 50%; 
            object-fit: cover; 
            flex-shrink: 0;
            border: 1px solid #eee;
        }

        @media (max-width: 1200px) {
            .p-avatar-circle { width: 18.75px; height: 18.75px; }
        }
        @media (max-width: 768px) {
            .p-avatar-circle { width: 12px; height: 12px; }
        }

        /* ================= 3. SIDEBAR CARDS & SEARCH ================= */
        .emr-sidebar-search-input { 
            width: 100%; padding: 8px 12px; border: 1px solid #e2e8f0; 
            border-radius: 8px; font-size: 12px; outline: none; transition: 0.2s; 
        }
        .emr-sidebar-search-input:focus { border-color: #C58F59; }

        .emr-patient-list { 
            display: flex; flex-direction: column; gap: 8px; overflow-y: auto; 
            max-height: calc(100vh - 280px); padding: 5px; 
        }
        
        /* PADDING KANAN-KIRI KOTAK PASIEN DIPERKECIL */
        .patient-card {
            background: #fff; border: 1px solid #eee; border-radius: 8px; 
            padding: 8px 8px; /* Kanan-kirinya jadi 8px (awalnya 12px atau 14px) */
            display: flex; flex-direction: column; gap: 4px; transition: 0.2s; cursor: pointer;
            text-decoration: none;
        }
        .patient-card:hover { border-color: #C58F59; transform: translateY(-2px); }
        .patient-card.active { border-color: #C58F59; background-color: rgba(197, 143, 89, 0.05); border-left: 4px solid #C58F59; }
        
        .p-card-top, .p-card-bottom { display: flex; justify-content: space-between; align-items: center; }
        
        .p-name { font-weight: 700; color: #333; font-size: 12px; }
        .p-date, .p-mr { font-size: 10px; color: #888; font-weight: 600; }
        
        .status-badge { font-size: 9px; padding: 2px 6px; border-radius: 6px; color: white; font-weight: 800; text-transform: uppercase; }

        /* ================= 4. SPINNER & UTILITIES ================= */
        .spinner { border: 3px solid #f3f3f3; border-top: 3px solid #C58F59; border-radius: 50%; width: 30px; height: 30px; animation: spin 1s linear infinite; margin-bottom: 10px; }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
        
        .hidden { display: none !important; }
    </style>
@endpush

@section('content')
    <div class="emr-container">
        {{-- HEADER --}}
        <div class="emr-header">
            <div class="emr-title-area">
                <h1 class="emr-title">Electronic Medical Record</h1>
                <p class="emr-subtitle">hanglekiu dental specialist</p>
            </div>
            <div class="emr-status-legend">
                @php $legendColors = ['6B7280'=>'Pending', 'F59E0B'=>'Confirmed', '8B5CF6'=>'Waiting', '3B82F6'=>'Engaged', '84CC16'=>'Succeed', 'EF4444'=>'Failed']; @endphp
                @foreach($legendColors as $color => $label)
                    <span class="emr-status-item"><span class="emr-dot" style="background-color: #{{ $color }};"></span> {{ $label }}</span>
                @endforeach
            </div>
            <div class="emr-header-actions">
                <button class="emr-icon-btn"><i class="fa fa-print"></i></button>
                <button class="emr-icon-btn" onclick="window.location.reload()"><i class="fa fa-sync"></i></button>
            </div>
        </div>

        <div class="emr-layout">
            {{-- SIDEBAR --}}
            <div class="emr-sidebar">
                <div class="emr-sidebar-header">
                    <div class="emr-filter-box" id="customFilterDropdown">
                        <div class="emr-select-trigger">
                            <span class="emr-select-text">Hari Ini</span>
                            <i class="fa fa-chevron-down" style="color:#C58F59;"></i>
                        </div>
                        <div class="emr-options">
                            <div class="emr-option is-selected" data-value="hari_ini">Hari Ini</div>
                            <div class="emr-option" data-value="semua">Semua</div>
                        </div>
                    </div>
                    
                </div>

                <div class="emr-patient-list" id="emrPatientList">
                    @php $statusColors = ['pending'=>'#6B7280','confirmed'=>'#F59E0B','waiting'=>'#8B5CF6','engaged'=>'#3B82F6','succeed'=>'#84CC16','failed'=>'#EF4444']; @endphp

                    {{-- LIST HARI INI --}}
                    <div id="list-hari-ini" class="js-patient-list-section">
                        @if(isset($todayPatients) && count($todayPatients) > 0)
                            @foreach($todayPatients as $apt)
                                <a href="{{ route('admin.emr.show', $apt->id) }}" class="js-emr-patient-link">
                                    <div class="patient-card">
                                        <div class="p-card-top">
                                            <span class="p-name">{{ $apt->patient->full_name ?? 'Pasien' }}</span>
                                            <span class="p-date">{{ \Carbon\Carbon::parse($apt->appointment_datetime)->format('H:i') }}</span>
                                        </div>
                                        <div class="p-card-bottom">
                                            <span class="p-mr">{{ $apt->patient->medical_record_no ?? '-' }}</span>
                                            <span class="status-badge" style="background-color: {{ $statusColors[strtolower($apt->status)] ?? '#888' }}">{{ $apt->status }}</span>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        @else
                            <div class="emr-queue-alert" style="text-align:center; padding:20px; color:#888;">Tidak ada antrean hari ini</div>
                        @endif
                    </div>

                    {{-- LIST SEMUA --}}
                    <div id="list-semua" class="hidden js-patient-list-section">
                        @if(isset($allPatients) && count($allPatients) > 0)
                            @foreach($allPatients as $apt)
                                <a href="{{ route('admin.emr.show', $apt->id) }}" class="js-emr-patient-link">
                                    <div class="patient-card">
                                        <div class="p-card-top">
                                            <span class="p-name">{{ $apt->patient->full_name ?? 'Pasien' }}</span>
                                            <span class="p-date">{{ \Carbon\Carbon::parse($apt->appointment_datetime)->format('d/m/y H:i') }}</span>
                                        </div>
                                        <div class="p-card-bottom">
                                            <span class="p-mr">{{ $apt->patient->medical_record_no ?? '-' }}</span>
                                            <span class="status-badge" style="background-color: {{ $statusColors[strtolower($apt->status)] ?? '#888' }}">{{ $apt->status }}</span>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        @else
                             <div class="emr-queue-alert" style="text-align:center; padding:20px; color:#888;">Data pasien tidak ditemukan</div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- MAIN CONTENT (RIWAYAT MEDIS) --}}
            <div class="emr-main" id="emrMainContent">
                {{-- View Kosong --}}
                <div class="emr-empty-state" id="emr-empty-view" style="text-align:center; padding-top:100px;">
                    <img src="{{ asset('images/empty-queue.png') }}" style="width:200px; opacity:0.5;">
                    <h2 style="color:#CBD5E0; margin-top:20px;">Pilih pasien di sebelah kiri</h2>
                </div>

                {{-- View Loading --}}
                <div id="emr-loading" class="hidden" style="position:absolute; top:50%; left:50%; transform:translate(-50%,-50%); display:flex; flex-direction:column; align-items:center;">
                    <div class="spinner"></div>
                    <span style="color:#C58F59; font-weight:600;">Memuat data...</span>
                </div>

                {{-- View Detail Dinamis (Diisi via AJAX) --}}
                <div id="emr-detail-view" class="hidden"></div>
            </div>
        </div>
    </div>

    <script>
document.addEventListener('DOMContentLoaded', function() {
            // ================= 1. FILTER & SEARCH SIDEBAR =================
            const dropdown = document.getElementById('customFilterDropdown');
            const listHariIni = document.getElementById('list-hari-ini');
            const listSemua = document.getElementById('list-semua');
            const searchInput = document.getElementById('js-sidebar-search');

            if(dropdown) {
                dropdown.addEventListener('click', (e) => { e.stopPropagation(); dropdown.classList.toggle('open'); });
                dropdown.querySelectorAll('.emr-option').forEach(opt => {
                    opt.addEventListener('click', function() {
                        dropdown.querySelector('.emr-select-text').textContent = this.textContent;
                        if(this.dataset.value === 'hari_ini') {
                            listHariIni.classList.remove('hidden'); listSemua.classList.add('hidden');
                        } else {
                            listHariIni.classList.add('hidden'); listSemua.classList.remove('hidden');
                        }
                    });
                });
            }

            if(searchInput) {
                searchInput.addEventListener('input', function(e) {
                    const term = e.target.value.toLowerCase();
                    const activeSection = listHariIni.classList.contains('hidden') ? listSemua : listHariIni;
                    activeSection.querySelectorAll('.js-emr-patient-link').forEach(link => {
                        link.style.display = link.textContent.toLowerCase().includes(term) ? "block" : "none";
                    });
                });
            }

            // ================= 2. HELPER FUNGSI: ATTACH PATIENT LINK EVENTS =================
            function attachPatientLinkEvents() {
                document.querySelectorAll('.js-emr-patient-link').forEach(link => {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        
                        // Tandai menu sidebar aktif
                        document.querySelectorAll('.js-emr-patient-link').forEach(l => {
                            const card = l.querySelector('.patient-card');
                            if(card) card.classList.remove('active');
                        });
                        this.querySelector('.patient-card').classList.add('active');

                        // Ganti UI ke Loading
                        document.getElementById('emr-empty-view').classList.add('hidden');
                        document.getElementById('emr-detail-view').classList.add('hidden');
                        document.getElementById('emr-loading').classList.remove('hidden');

                        // Ambil HTML dari controller via AJAX
                        fetch(this.href, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                            .then(res => res.text())
                            .then(html => {
                                document.getElementById('emr-loading').classList.add('hidden');
                                document.getElementById('emr-detail-view').classList.remove('hidden');
                                document.getElementById('emr-detail-view').innerHTML = html;
                                
                                // Eksekusi fungsi setup UI setelah HTML masuk
                                if(typeof bindTabEvents === 'function') bindTabEvents();
                                if(typeof setupFABEvents === 'function') setupFABEvents();
                            })
                            .catch(err => {
                                alert('Gagal memuat data pasien.');
                                console.error(err);
                                document.getElementById('emr-loading').classList.add('hidden');
                            });
                    });
                });
            }

            // ================= 3. INISIAL ATTACH PATIENT LINK EVENTS =================
            attachPatientLinkEvents();

            // ================= 4. AUTO-LOAD PASIEN DARI URL PARAMETER =================
            const patientLinks = document.querySelectorAll('.js-emr-patient-link');
            const urlParams = new URLSearchParams(window.location.search);
            const autoOpenApptId = @json($autoOpenApptId ?? null);
            const openApptId = urlParams.get('open') || autoOpenApptId; // Prioritas URL, fallback ke pasien engaged

            if (openApptId) {
                // 1. Ganti UI langsung ke Loading
                document.getElementById('emr-empty-view').classList.add('hidden');
                document.getElementById('emr-detail-view').classList.add('hidden');
                document.getElementById('emr-loading').classList.remove('hidden');

                // 2. URL endpoint untuk AJAX (Asumsi route detail EMR adalah /admin/emr/{id})
                const fetchUrl = `/admin/emr/${openApptId}`;

                // 3. Tembak AJAX Langsung menggunakan ID
                fetch(fetchUrl, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                    .then(res => {
                        if (!res.ok) throw new Error('Data tidak ditemukan / Gagal memuat');
                        return res.text();
                    })
                    .then(html => {
                        // Sembunyikan loading, tampilkan hasil HTML di Main Content
                        document.getElementById('emr-loading').classList.add('hidden');
                        document.getElementById('emr-detail-view').classList.remove('hidden');
                        document.getElementById('emr-detail-view').innerHTML = html;
                        
                        // Eksekusi fungsi setup UI EMR (Tabs, tombol, dll)
                        if(typeof bindTabEvents === 'function') bindTabEvents();
                        if(typeof setupFABEvents === 'function') setupFABEvents();

                        // 4. (Opsional & Estetika) Cari link di sidebar untuk di-highlight aktif
                        const targetLink = Array.from(patientLinks).find(link => link.href.includes(`/${openApptId}`));
                        if (targetLink) {
                            // Hapus aktif dari semua, tambahkan ke yang ketemu
                            patientLinks.forEach(l => {
                                const card = l.querySelector('.patient-card');
                                if(card) card.classList.remove('active');
                            });
                            
                            const activeCard = targetLink.querySelector('.patient-card');
                            if(activeCard) activeCard.classList.add('active');
                            
                            // Jika ada di tab "Semua", pindahkan filternya agar kelihatan
                            const parentListId = targetLink.closest('ul')?.id;
                            if (parentListId === 'list-semua' && dropdown) {
                                const optionSemua = dropdown.querySelector('.emr-option[data-value="semua"]');
                                if (optionSemua) {
                                    dropdown.querySelector('.emr-select-text').textContent = optionSemua.textContent;
                                    listHariIni.classList.add('hidden'); 
                                    listSemua.classList.remove('hidden');
                                }
                            }
                        }
                        
                        // 5. Bersihkan URL dari '?open=123' agar kalau di-refresh tidak ngeload ulang terus
                        window.history.replaceState({}, document.title, window.location.pathname);
                    })
                    .catch(err => {
                        console.error('Error AJAX EMR:', err);
                        alert('Gagal memuat rekam medis pasien.');
                        // Kembalikan ke tampilan empty jika gagal
                        document.getElementById('emr-loading').classList.add('hidden');
                        document.getElementById('emr-empty-view').classList.remove('hidden'); 
                    });
            } else {
                // ===== FALLBACK: patient_id tanpa appointment =====
                const patientIdParam = urlParams.get('patient_id');
                if (patientIdParam) {
                    // Cari link pasien di sidebar berdasarkan data patient
                    const allLinks = document.querySelectorAll('.js-emr-patient-link');
                    let found = false;
                    
                    allLinks.forEach(link => {
                        const nameText = link.querySelector('.p-name')?.textContent.trim().toLowerCase();
                        if (nameText && patientIdParam.toLowerCase().includes(nameText)) {
                            link.click();
                            found = true;
                            return;
                        }
                    });
                    
                    if (!found) {
                        document.getElementById('emr-empty-view').innerHTML = `
                            <div style="text-align:center; padding-top:80px;">
                                <img src="{{ asset('images/empty-queue.png') }}" style="width:160px; opacity:0.4;">
                                <h3 style="color:#CBD5E0; margin-top:16px;">Pasien belum memiliki kunjungan</h3>
                                <p style="color:#A0AEC0; font-size:13px;">Daftarkan pasien terlebih dahulu melalui menu Pendaftaran</p>
                                <button onclick="openRegModal('modalPendaftaranBaru')" 
                                        style="margin-top:16px; padding:10px 20px; background:#C58F59; color:white; border:none; border-radius:6px; cursor:pointer; font-size:13px;">
                                    <i class="fas fa-plus"></i> Daftarkan Kunjungan
                                </button>
                            </div>
                        `;
                        document.getElementById('emr-empty-view').classList.remove('hidden');
                    }
                    
                    window.history.replaceState({}, document.title, window.location.pathname);
                }
            }
        });


        // ================= 3. FUNGSI GLOBAL (DIPANGGIL SETELAH AJAX) =================
        function bindTabEvents() {
            const tabButtons = document.querySelectorAll('.tab-item');
            const tabPanes = document.querySelectorAll('[data-tab-content]');
            const currentStatusLabel = document.querySelector('.status-current-text');

            if (currentStatusLabel) {
                filterStatusMenuByCurrent(currentStatusLabel.textContent);
            }

            tabButtons.forEach(btn => {
                btn.addEventListener('click', function() {
                    const tab = this.dataset.tab;
                    tabButtons.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');

                    tabPanes.forEach(p => {
                        p.classList.toggle('hidden', p.dataset.tabContent !== tab);
                    });
                });
            });

            const recordTabButtons = document.querySelectorAll('.record-tab-btn');
            const recordPanes = document.querySelectorAll('[data-record-tab-content]');

            recordTabButtons.forEach(btn => {
                btn.addEventListener('click', function() {
                    const tab = this.dataset.recordTab;
                    recordTabButtons.forEach(b => {
                        b.classList.remove('active');
                        b.style.color = '#9ca3af';
                        b.style.borderBottomColor = 'transparent';
                    });
                    this.classList.add('active');
                    this.style.color = '#4b5563';
                    this.style.borderBottomColor = '#8b5cf6';

                    recordPanes.forEach(p => {
                        p.classList.toggle('hidden', p.dataset.recordTabContent !== tab);
                    });
                });
            });
        }

        // Dropdown Tambah Diagnosa
        function toggleDiagnosaMenu(e) {
            e.preventDefault(); e.stopPropagation();
            const menu = document.getElementById('diagnosa-menu');
            if (menu) {
                menu.classList.toggle('hidden');
                if(!menu.classList.contains('hidden')) setTimeout(() => document.getElementById('diagSearchInput').focus(), 100);
            }
        }

        function filterDiagnosaList() {
            const filter = document.getElementById('diagSearchInput').value.toLowerCase();
            document.querySelectorAll('.diagnosa-item').forEach(item => {
                item.style.display = item.textContent.toLowerCase().includes(filter) ? "block" : "none";
            });
        }

        // Setup Floating Action Button (FAB)
        function setupFABEvents() {
            const fabBtn = document.getElementById('fabBtn');
            const fabMenu = document.getElementById('fabMenu');
            const fabSearchInput = document.getElementById('fabSearchInput');
            const fabListItems = document.querySelectorAll('.emr-fab-item');

            if(fabBtn && fabMenu) {
                fabBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    fabMenu.classList.toggle('active');
                    if(fabMenu.classList.contains('active') && fabSearchInput) {
                        setTimeout(() => fabSearchInput.focus(), 100);
                    }
                });
            }

            if(fabSearchInput) {
                fabSearchInput.addEventListener('input', function(e) {
                    const filterText = e.target.value.toLowerCase();
                    fabListItems.forEach(item => {
                        const text = item.textContent.toLowerCase();
                        if (item.parentElement) { // Pastikan parent ada
                           item.parentElement.style.display = text.includes(filterText) ? 'block' : 'none';
                        }
                    });
                });
            }
        }

        // Buka Modal Odontogram via FAB
        function openModalOdontogram(e) {
            e.preventDefault();
            const fabMenu = document.getElementById('fabMenu');
            if(fabMenu) fabMenu.classList.remove('active');

            // Gunakan fungsi toggleOdontogramModal agar overlay full-screen + blur + kunci scroll
            if (typeof toggleOdontogramModal === 'function') {
                toggleOdontogramModal(true, window.lastOdontoPatientData || null);
            } else {
                const modal = document.getElementById('modalOdontogramOverlay');
                if(modal) {
                    modal.classList.remove('hidden');
                } else {
                    console.error("Modal Odontogram tidak ditemukan di halaman ini.");
                }
            }
        }

function openDoctorNoteModalFromDetail() {
    const detail = document.querySelector('.p-detail-container');
    if (!detail) return;

    toggleDoctorNoteModal(true, {
        appointmentId: detail.dataset.appointmentId || '',
        patientName: detail.dataset.patientName || '-',
        patientRm: detail.dataset.patientRm || '-',
        doctorName: detail.dataset.doctorName || '-',
        demography: detail.dataset.patientDemography || '-',
    });
}

function toggleDoctorNoteModal(show, data = null) {
    const modal = document.getElementById('modalDoctorNoteOverlay');
    if (!modal) return;

    if (show) {
        modal.classList.remove('hidden');
        modal.style.display = 'flex';

        if (data) {
            document.getElementById('doctorNoteRegistrationId').value = data.appointmentId || '';
            document.getElementById('doctorNotePatientName').textContent = data.patientName || '-';
            document.getElementById('doctorNotePatientRm').textContent = data.patientRm || '-';
            document.getElementById('doctorNoteDoctorName').textContent = data.doctorName || '-';
            document.getElementById('doctorNotePatientDemography').textContent = data.demography || '-';
        }
        return;
    }

    modal.classList.add('hidden');
    modal.style.display = 'none';
}

async function submitDoctorNote() {
    const registrationId = document.getElementById('doctorNoteRegistrationId').value;
    const subjective = document.getElementById('doctorNoteSubjective').value.trim();
    const objective = document.getElementById('doctorNoteObjective').value.trim();
    const plan = document.getElementById('doctorNotePlan').value.trim();
    const saveBtn = document.getElementById('doctorNoteSaveBtn');

    if (!registrationId) {
        alert('Data kunjungan tidak ditemukan.');
        return;
    }
    if (!subjective && !objective && !plan) {
        alert('Isi minimal salah satu Subjectives, Objectives, atau Plans.');
        return;
    }

    const originalBtnText = saveBtn ? saveBtn.textContent : '';
    if (saveBtn) {
        saveBtn.disabled = true;
        saveBtn.textContent = 'Menyimpan...';
    }

    try {
        const response = await fetch(`/admin/emr/${registrationId}/doctor-note`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ subjective, objective, plan })
        });

        const data = await response.json();
        if (!response.ok || !data.success) {
            throw new Error(data.message || 'Gagal menyimpan catatan dokter');
        }

        document.getElementById('doctorNoteSubjective').value = '';
        document.getElementById('doctorNoteObjective').value = '';
        document.getElementById('doctorNotePlan').value = '';
        toggleDoctorNoteModal(false);

        const activePatientLink = document.querySelector('.js-emr-patient-link .patient-card.active')?.closest('a');
        if (activePatientLink) {
            activePatientLink.click();
        }
    } catch (error) {
        console.error('Gagal simpan catatan dokter:', error);
        alert(error.message || 'Terjadi kesalahan saat menyimpan catatan dokter.');
    } finally {
        if (saveBtn) {
            saveBtn.disabled = false;
            saveBtn.textContent = originalBtnText;
        }
    }
}

window.openDoctorNoteModalFromDetail = openDoctorNoteModalFromDetail;
window.toggleDoctorNoteModal = toggleDoctorNoteModal;
window.submitDoctorNote = submitDoctorNote;

function playCashierNotificationSound() {
    try {
        const AudioCtx = window.AudioContext || window.webkitAudioContext;
        if (!AudioCtx) return;

        const ctx = new AudioCtx();
        const now = ctx.currentTime;

        // Chime 2 nada: lebih "cjreng" dan sedikit lebih keras.
        const playTone = (startTime, freq, type = 'triangle', peak = 0.16, duration = 0.22) => {
            const oscillator = ctx.createOscillator();
            const gainNode = ctx.createGain();

            oscillator.type = type;
            oscillator.frequency.setValueAtTime(freq, startTime);
            oscillator.frequency.exponentialRampToValueAtTime(freq * 1.08, startTime + (duration * 0.5));

            gainNode.gain.setValueAtTime(0.0001, startTime);
            gainNode.gain.exponentialRampToValueAtTime(peak, startTime + 0.012);
            gainNode.gain.exponentialRampToValueAtTime(0.0001, startTime + duration);

            oscillator.connect(gainNode);
            gainNode.connect(ctx.destination);

            oscillator.start(startTime);
            oscillator.stop(startTime + duration + 0.02);
        };

        playTone(now, 1318.51, 'triangle', 0.28, 0.20);      // E6
        playTone(now + 0.11, 1760.00, 'triangle', 0.24, 0.24); // A6

        setTimeout(() => {
            if (typeof ctx.close === 'function') {
                ctx.close().catch(() => {});
            }
        }, 450);
    } catch (e) {
        console.warn('Audio notifikasi gagal diputar:', e);
    }
}

function setCashierAttention(active) {
    if (active) {
        localStorage.setItem('cashier_attention_pending', JSON.stringify({
            active: true,
            count: 1,
            timestamp: Date.now(),
        }));
    } else {
        localStorage.removeItem('cashier_attention_pending');
    }
    window.dispatchEvent(new Event('cashierAttentionChanged'));
    if (typeof window.syncCashierBadgeIndicator === 'function') {
        window.syncCashierBadgeIndicator();
    }
}

function filterStatusMenuByCurrent(currentStatus) {
    const menu = document.getElementById('status-menu-dynamic');
    if (!menu) return;

    const orderedStatuses = ['pending', 'confirmed', 'waiting', 'engaged', 'succeed'];
    const normalizedCurrent = (currentStatus || '').toLowerCase();
    const currentIndex = orderedStatuses.indexOf(normalizedCurrent);
    const isFailed = normalizedCurrent === 'failed';
    const isSucceed = normalizedCurrent === 'succeed';

    let hasVisibleOption = false;
    menu.querySelectorAll('[data-status-option]').forEach((optionEl) => {
        const optionStatus = (optionEl.dataset.statusOption || '').toLowerCase();
        let isAllowed = false;

        if (isSucceed) {
            isAllowed = optionStatus === 'failed';
        } else if (!isFailed) {
            if (optionStatus === 'failed') {
                isAllowed = true;
            } else {
                const optionIndex = orderedStatuses.indexOf(optionStatus);
                isAllowed = currentIndex === -1 ? optionIndex >= 0 : optionIndex > currentIndex;
            }
        }

        const li = optionEl.closest('li');
        if (li) li.style.display = isAllowed ? 'block' : 'none';
        if (isAllowed) hasVisibleOption = true;
    });

    const noOptionEl = document.getElementById('status-no-option');
    if (noOptionEl) {
        noOptionEl.style.display = hasVisibleOption ? 'none' : 'block';
    }
}

async function processUpdateStatus(url, newStatus) {
    if ((newStatus || '').toLowerCase() === 'failed') {
        const confirmed = window.confirm('Yakin ingin mengubah status menjadi FAILED?');
        if (!confirmed) {
            return;
        }
    }

    // 1. Langsung sembunyikan menu dropdown setelah diklik
    const dropdown = document.getElementById('status-menu-dynamic');
    if (dropdown) dropdown.classList.add('hidden');

    try {
        const response = await fetch(url, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ status: newStatus })
        });

        const data = await response.json();

        if (response.ok && data.success) {

            
        
            const activeCardStatus = document.querySelector('.patient-card.active .status-badge');
            if (activeCardStatus) {
                activeCardStatus.innerText = newStatus.toUpperCase();
                const colors = {'pending':'#6B7280','confirmed':'#F59E0B','waiting':'#8B5CF6','engaged':'#3B82F6','succeed':'#84CC16','failed':'#EF4444'};
                activeCardStatus.style.backgroundColor = colors[newStatus];
            }

            const statusColors = {
                'pending': '#6B7280', 'confirmed': '#F59E0B', 'waiting': '#8B5CF6',
                'engaged': '#3B82F6', 'succeed': '#84CC16', 'failed': '#EF4444'
            };

            const currentLabel = document.querySelector('.status-current-text');
            const btnToggle = document.querySelector('.btn-status-toggle');
            if (currentLabel) currentLabel.innerText = newStatus.toUpperCase();
            if (btnToggle && statusColors[newStatus]) {
                btnToggle.style.backgroundColor = statusColors[newStatus];
            }

            const timeInfo = document.querySelector('.card-time-info');
            if (timeInfo) {
                const statusTextMap = {
                    'pending': 'dan belum dimulai',
                    'confirmed': 'dan sudah terkonfirmasi',
                    'waiting': 'dan menunggu pemeriksaan',
                    'engaged': 'dan masih berlangsung',
                    'succeed': 'dan sudah selesai',
                    'failed': 'dan dibatalkan'
                };
                const baseTime = (timeInfo.textContent || '').trim().split(' WIB')[0] || '--:--';
                timeInfo.textContent = `${baseTime} WIB ${statusTextMap[newStatus] || ''}`.trim();
            }

            document.querySelectorAll('[data-status-option]').forEach((optionEl) => {
                const optionStatus = (optionEl.dataset.statusOption || '').toLowerCase();
                const optionColor = optionEl.dataset.optionColor || '#4B5563';
                const isActive = optionStatus === newStatus;

                optionEl.style.background = optionColor;
                optionEl.style.opacity = isActive ? '1' : '0.88';
                optionEl.style.border = isActive ? '2px solid #111827' : '2px solid transparent';
            });

            filterStatusMenuByCurrent(newStatus);

            const addDiagnosaBtn = document.querySelector('.btn-primary-brown');
            if (addDiagnosaBtn) {
                const canAddDiagnosa = newStatus === 'engaged';
                addDiagnosaBtn.disabled = !canAddDiagnosa;
            }

            const actionsRow = document.querySelector('.card-actions-row');
            const existingCashierBtn = actionsRow ? actionsRow.querySelector('.btn-ke-kasir') : null;
            if (newStatus === 'succeed') {
                playCashierNotificationSound();
                setCashierAttention(true);
                if (!existingCashierBtn && actionsRow) {
                    const cashierBtn = document.createElement('a');
                    cashierBtn.href = '{{ route('admin.cashier') }}';
                    cashierBtn.className = 'btn-ke-kasir';
                    cashierBtn.style.cssText = 'background:#10b981;color:white;padding:6px 12px;border-radius:8px;font-weight:800;font-size:11px;text-decoration:none;display:flex;align-items:center;gap:5px;margin-right:5px;';
                    cashierBtn.innerHTML = '<i class="fa fa-wallet"></i> KE KASIR';
                    actionsRow.prepend(cashierBtn);
                }
            } else {
                setCashierAttention(false);
                if (existingCashierBtn) {
                    existingCashierBtn.remove();
                }
            }

            // 2. Buat notifikasi (Toast) yang cantik
            const toast = document.createElement('div');
            
            // Styling notifikasi (Hijau, melayang di atas)
            toast.className = 'fixed top-10 left-1/2 transform -translate-x-1/2 bg-green-600 text-white px-8 py-4 rounded-xl shadow-2xl z-[99999] text-center animate-bounce';
            
            let message = `Status pasien berhasil diubah ke ${newStatus.toUpperCase()}`;
            
            // 3. LOGIKA NOTIF KE KASIR: Muncul jika status diubah ke 'succeed'
            if (newStatus === 'succeed') {
                message = `
                    <div class="flex flex-col items-center gap-1">
                        <span class="font-bold">PASIEN SELESAI DIPERIKSA</span>
                        <span class="text-xs bg-white text-green-700 px-3 py-1 rounded-full mt-2 font-black shadow-sm">
                            <i class="fa fa-arrow-right mr-1"></i> SILAKAN LANJUT KE HALAMAN CASHIER
                        </span>
                    </div>
                `;
            }

            toast.innerHTML = message;
            document.body.appendChild(toast);

            // 5. Hilangkan notifikasi otomatis setelah 3.5 detik
            setTimeout(() => {
                toast.style.transition = 'all 0.5s ease';
                toast.style.opacity = '0';
                toast.style.transform = 'translate(-50%, -20px)';
                setTimeout(() => toast.remove(), 500);
            }, 3500);

        } else {
            throw new Error(data.message || 'Gagal sinkronisasi dengan database');
        }
    } catch (error) {
        console.error('Error updating status:', error);
        alert('Gagal mengubah status pasien. Silakan coba lagi.');
    }
}

// ================= 4. SINKRONISASI REGISTRASI BARU DARI HALAMAN LAIN =================
(function() {
    let lastRefreshTime = 0;
    let lastSignalTimestamp = 0;
    const REFRESH_COOLDOWN = 3000; // Jangan refresh lebih dari 1x per 3 detik
    
    // Fungsi untuk refresh antrean EMR dengan AJAX (TANPA full reload)
    // Ini preserve state EMR yang sedang dilihat
    async function refreshEmrQueueAjax() {
        const now = Date.now();
        if (now - lastRefreshTime < REFRESH_COOLDOWN) {
            console.log('⏱️ Refresh sudah dilakukan baru-baru ini, skip...');
            return;
        }
        lastRefreshTime = now;
        
        try {
            console.log('🔄 Merefresh list pasien via AJAX...');
            
            // Simpan appointment ID yang sedang dilihat
            const activeLink = document.querySelector('.js-emr-patient-link .patient-card.active');
            const activeAppointmentId = activeLink ? activeLink.closest('a').href.split('/').pop() : null;
            
            console.log('📌 Active appointment ID:', activeAppointmentId);
            
            // Fetch HTML baru
            const response = await fetch(window.location.href, {
                method: 'GET',
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });
            
            if (!response.ok) throw new Error('Gagal fetch data baru');
            
            const html = await response.text();
            const parser = new DOMParser();
            const newDoc = parser.parseFromString(html, 'text/html');
            
            // Update list pasien hari ini
            const newTodayList = newDoc.querySelector('#list-hari-ini');
            const oldTodayList = document.querySelector('#list-hari-ini');
            
            if (newTodayList && oldTodayList) {
                oldTodayList.innerHTML = newTodayList.innerHTML;
                console.log('✅ Daftar pasien hari ini diperbarui');
                reattachPatientLinkEvents();
                
                // Re-mark active jika appointment masih ada
                if (activeAppointmentId) {
                    const newActiveLink = oldTodayList.querySelector(`a[href*="${activeAppointmentId}"]`);
                    if (newActiveLink) {
                        const card = newActiveLink.querySelector('.patient-card');
                        if (card) card.classList.add('active');
                    }
                }
            }
            
            // Update list semua pasien
            const newAllList = newDoc.querySelector('#list-semua');
            const oldAllList = document.querySelector('#list-semua');
            
            if (newAllList && oldAllList) {
                oldAllList.innerHTML = newAllList.innerHTML;
                console.log('✅ Daftar semua pasien diperbarui');
                reattachPatientLinkEvents();
                
                // Re-mark active jika appointment masih ada
                if (activeAppointmentId) {
                    const newActiveLink = oldAllList.querySelector(`a[href*="${activeAppointmentId}"]`);
                    if (newActiveLink) {
                        const card = newActiveLink.querySelector('.patient-card');
                        if (card) card.classList.add('active');
                    }
                }
            }
            
            // Tampilkan toast notification
            const toast = document.createElement('div');
            toast.style.cssText = `
                position: fixed;
                bottom: 32px;
                right: 32px;
                background: #10B981;
                color: white;
                padding: 12px 24px;
                border-radius: 8px;
                box-shadow: 0 10px 15px rgba(0, 0, 0, 0.3);
                z-index: 99999;
                font-size: 14px;
                font-weight: 500;
            `;
            toast.innerHTML = '<i class="fa fa-check" style="margin-right: 8px;"></i> Antrean pasien diperbarui!';
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transition = 'opacity 0.5s ease';
                setTimeout(() => toast.remove(), 500);
            }, 3000);
            
            console.log('✅ Refresh selesai, state EMR terjaga');
            
        } catch (error) {
            console.error('❌ Error saat refresh AJAX:', error);
            // Fallback: jika AJAX error, barulah full reload
            console.log('🔄 Fallback: Full page reload...');
            setTimeout(() => location.reload(), 1000);
        }
    }
    
    // Fungsi untuk re-attach event listeners
    function reattachPatientLinkEvents() {
        document.querySelectorAll('.js-emr-patient-link').forEach(link => {
            // Clone untuk remove old listeners
            const newLink = link.cloneNode(true);
            link.parentNode.replaceChild(newLink, link);
            
            newLink.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Tandai aktif
                document.querySelectorAll('.js-emr-patient-link').forEach(l => {
                    const card = l.querySelector('.patient-card');
                    if(card) card.classList.remove('active');
                });
                this.querySelector('.patient-card').classList.add('active');

                // Load detail
                document.getElementById('emr-empty-view').classList.add('hidden');
                document.getElementById('emr-detail-view').classList.add('hidden');
                document.getElementById('emr-loading').classList.remove('hidden');

                fetch(this.href, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                    .then(res => res.text())
                    .then(html => {
                        document.getElementById('emr-loading').classList.add('hidden');
                        document.getElementById('emr-detail-view').classList.remove('hidden');
                        document.getElementById('emr-detail-view').innerHTML = html;
                        
                        if(typeof bindTabEvents === 'function') bindTabEvents();
                        if(typeof setupFABEvents === 'function') setupFABEvents();
                    })
                    .catch(err => {
                        alert('Gagal memuat data pasien.');
                        console.error(err);
                        document.getElementById('emr-loading').classList.add('hidden');
                    });
            });
        });
    }
    
    // ===== LISTENER 1: Custom Event (Same-Tab) =====
    window.addEventListener('emr_new_registration', function(e) {
        const signalData = e.detail;
        console.log('📢 Custom Event: Registrasi baru terdeteksi', signalData);
        
        if (signalData && signalData.timestamp && signalData.timestamp !== lastSignalTimestamp) {
            lastSignalTimestamp = signalData.timestamp;
            setTimeout(() => refreshEmrQueueAjax(), 500);
        }
    });
    
    // ===== LISTENER 2: Storage Event (Cross-Tab) =====
    window.addEventListener('storage', function(e) {
        if (e.key === 'emr_refresh_signal') {
            const signalData = e.newValue ? JSON.parse(e.newValue) : null;
            if (signalData && signalData.type === 'new_registration') {
                console.log('📢 Storage Event: Registrasi baru terdeteksi dari tab lain', signalData);
                
                if (signalData.timestamp && signalData.timestamp !== lastSignalTimestamp) {
                    lastSignalTimestamp = signalData.timestamp;
                    setTimeout(() => refreshEmrQueueAjax(), 1000);
                }
            }
        }
    });
    
    // ===== LISTENER 3: Polling (Fallback untuk Same-Tab) =====
    let pollingInterval = null;
    const pollLocalStorage = () => {
        if (pollingInterval) return;
        
        pollingInterval = setInterval(() => {
            try {
                const signalDataStr = localStorage.getItem('emr_refresh_signal');
                if (signalDataStr) {
                    const signalData = JSON.parse(signalDataStr);
                    
                    if (signalData && signalData.type === 'new_registration') {
                        if (signalData.timestamp && signalData.timestamp !== lastSignalTimestamp) {
                            console.log('📢 Polling: Registrasi baru terdeteksi', signalData);
                            lastSignalTimestamp = signalData.timestamp;
                            localStorage.removeItem('emr_refresh_signal');
                            
                            setTimeout(() => refreshEmrQueueAjax(), 500);
                        }
                    }
                }
            } catch (error) {
                console.error('❌ Polling error:', error);
            }
        }, 1000);
        
        setTimeout(() => {
            if (pollingInterval) {
                clearInterval(pollingInterval);
                pollingInterval = null;
            }
        }, 60000);
    };
    
    // Start polling
    pollLocalStorage();
})();
    </script>
@endsection

@include('admin.components.emr.modal-odontogram')
@include('admin.components.emr.modal-prosedure')
@include('admin.components.emr.modal-doctor-note')