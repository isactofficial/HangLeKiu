@extends('admin.layout.admin')
@section('title', 'Electronic Medical Record')

@section('navbar')
    @include('admin.components.navbarSearch', ['title' => 'Electronic Medical Record'])
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/pages/emr.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/pages/emr-mobile.css') }}">
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

        .p-avatar-circle { 
            width: 30px; height: 30px; border-radius: 50%; 
            object-fit: cover; flex-shrink: 0; border: 1px solid #eee;
        }

        .emr-sidebar-search-input { 
            width: 100%; padding: 8px 12px; border: 1px solid #e2e8f0; 
            border-radius: 8px; font-size: 12px; outline: none; transition: 0.2s; 
        }
        .emr-sidebar-search-input:focus { border-color: #C58F59; }

        .emr-patient-list { 
            display: flex; flex-direction: column; gap: 8px; overflow-y: auto; 
            max-height: calc(100vh - 280px); padding: 5px; 
        }
        
        .patient-card {
            background: #fff; border: 1px solid #eee; border-radius: 8px; 
            padding: 8px 8px;
            display: flex; flex-direction: column; gap: 4px; transition: 0.2s; cursor: pointer;
            text-decoration: none;
        }
        .patient-card:hover { border-color: #C58F59; transform: translateY(-2px); }
        .patient-card.active { border-color: #C58F59; background-color: rgba(197, 143, 89, 0.05); border-left: 4px solid #C58F59; }
        
        .p-card-top, .p-card-bottom { display: flex; justify-content: space-between; align-items: center; }
        .p-name { font-weight: 700; color: #8e6a45; font-size: 12px; }
        .p-date, .p-mr { font-size: 10px; color: #888; font-weight: 600; }
        .status-badge { font-size: 9px; padding: 2px 6px; border-radius: 6px; color: white; font-weight: 800; text-transform: uppercase; }

        .spinner { border: 3px solid #f3f3f3; border-top: 3px solid #C58F59; border-radius: 50%; width: 30px; height: 30px; animation: spin 1s linear infinite; margin-bottom: 10px; }
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
        
        .hidden { display: none !important; }

        /* ===== MOBILE SIDEBAR CLOSE BUTTON (inside drawer) ===== */
        .emr-drawer-close {
            display: none;
            align-items: center;
            justify-content: space-between;
            padding: 4px 0 16px;
            border-bottom: 1px solid #f0e5d8;
            margin-bottom: 14px;
        }
        .emr-drawer-close-btn {
            background: none; border: none; color: #8e6a45;
            font-size: 20px; cursor: pointer; padding: 4px 8px;
            border-radius: 8px; line-height: 1;
        }
        .emr-drawer-close-btn:hover { background: #fdf0e5; }
        .emr-drawer-title { font-weight: 800; font-size: 14px; color: #582c0c; }

        @media (max-width: 992px) {
            .emr-drawer-close { display: flex; }
            .emr-main { min-height: 60vh; }
        }
        @media (max-width: 768px) {
            .emr-main { padding: 14px; min-height: 50vh; }
        }
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
        </div>

        {{-- MOBILE BACKDROP --}}
        <div class="emr-sidebar-backdrop" id="emrSidebarBackdrop"></div>

        <div class="emr-layout">
            {{-- SIDEBAR --}}
<div class="emr-sidebar" id="emrSidebar">

    {{-- Toggle button (mobile only, disembunyikan di desktop via CSS) --}}
    <button class="emr-sidebar-toggle" id="emrSidebarToggle" type="button">
        <span class="emr-sidebar-toggle-label">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                <circle cx="9" cy="7" r="4"/>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
            </svg>
            Daftar Pasien
            <span class="emr-sidebar-toggle-count" id="sidebarPatientCount">
                {{ isset($todayPatients) ? count($todayPatients) : 0 }}
            </span>
        </span>
        <svg class="emr-sidebar-toggle-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="6 9 12 15 18 9"/>
        </svg>
    </button>

    {{-- Body: collapsible on mobile, always visible on desktop --}}
    <div class="emr-sidebar-body" id="emrSidebarBody">
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
                        <a href="{{ route('admin.emr.show', $apt->id) }}"
                           class="js-emr-patient-link"
                           data-patient-name="{{ strtolower($apt->patient->full_name ?? 'Pasien') }}"
                           data-patient-rm="{{ strtolower($apt->patient->medical_record_no ?? '-') }}"
                           data-patient-status="{{ strtolower($apt->status ?? '') }}">
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
                    <div style="padding:14px; color:#aaa; font-size:11px; text-align:center; min-width:200px;">
                        Tidak ada antrean hari ini
                    </div>
                @endif
            </div>

            {{-- LIST SEMUA --}}
            <div id="list-semua" class="hidden js-patient-list-section">
                @if(isset($allPatients) && count($allPatients) > 0)
                    @foreach($allPatients as $apt)
                        <a href="{{ route('admin.emr.show', $apt->id) }}"
                           class="js-emr-patient-link"
                           data-patient-name="{{ strtolower($apt->patient->full_name ?? 'Pasien') }}"
                           data-patient-rm="{{ strtolower($apt->patient->medical_record_no ?? '-') }}"
                           data-patient-status="{{ strtolower($apt->status ?? '') }}">
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
                    <div style="padding:14px; color:#aaa; font-size:11px; text-align:center; min-width:200px;">
                        Data pasien tidak ditemukan
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>


            {{-- MAIN CONTENT (RIWAYAT MEDIS) --}}
            <div class="emr-main" id="emrMainContent">
                {{-- Mobile Toggle Button --}}
                <button class="emr-sidebar-toggle-btn" id="emrSidebarToggleBtn" aria-label="Daftar Pasien">
                    <i class="fa fa-bars"></i> Daftar Pasien
                </button>

                {{-- View Kosong --}}
                <div class="emr-empty-state" id="emr-empty-view" style="text-align:center; padding-top:60px;">
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
            // ================= 0. MOBILE SIDEBAR DRAWER =================
            const emrSidebar      = document.getElementById('emrSidebar');
            const emrBackdrop     = document.getElementById('emrSidebarBackdrop');
            const emrToggleBtn    = document.getElementById('emrSidebarToggleBtn');
            const emrDrawerClose  = document.getElementById('emrDrawerCloseBtn');

            function openSidebar() {
                if (!emrSidebar) return;
                emrSidebar.classList.add('drawer-open');
                if (emrBackdrop) emrBackdrop.classList.add('active');
                document.body.style.overflow = 'hidden';
            }

            function closeSidebar() {
                if (!emrSidebar) return;
                emrSidebar.classList.remove('drawer-open');
                if (emrBackdrop) emrBackdrop.classList.remove('active');
                document.body.style.overflow = '';
            }

            if (emrToggleBtn)   emrToggleBtn.addEventListener('click', openSidebar);
            if (emrDrawerClose) emrDrawerClose.addEventListener('click', closeSidebar);
            if (emrBackdrop)    emrBackdrop.addEventListener('click', closeSidebar);

            // Auto-close drawer when a patient is selected on mobile
            document.addEventListener('click', function(e) {
                const link = e.target.closest('.js-emr-patient-link');
                if (link && window.innerWidth <= 992) {
                    closeSidebar();
                }
            });

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

            initEmrTopbarSearch();
            initEmrAdvanceSearch();

            function initEmrTopbarSearch() {
                const input = document.querySelector('.navbar-search-input');
                const wrapper = input ? input.closest('.navbar-search-wrapper') : null;
                if (!input || !wrapper || input.dataset.boundTopbarSearch === '1') {
                    return;
                }

                window.emrTopbarAdvancedFilter = window.emrTopbarAdvancedFilter || {
                    status: '',
                    scope: 'semua',
                };

                input.dataset.boundTopbarSearch = '1';
                wrapper.style.position = 'relative';

                let dropdownResult = document.getElementById('emrTopbarSearchDropdown');
                if (!dropdownResult) {
                    dropdownResult = document.createElement('div');
                    dropdownResult.id = 'emrTopbarSearchDropdown';
                    dropdownResult.style.display = 'none';
                    dropdownResult.style.position = 'absolute';
                    dropdownResult.style.top = 'calc(100% + 6px)';
                    dropdownResult.style.left = '0';
                    dropdownResult.style.right = '0';
                    dropdownResult.style.background = '#fff';
                    dropdownResult.style.border = '1px solid #E5D6C5';
                    dropdownResult.style.borderRadius = '10px';
                    dropdownResult.style.zIndex = '9999';
                    dropdownResult.style.maxHeight = '380px';
                    dropdownResult.style.overflowY = 'auto';
                    dropdownResult.style.boxShadow = '0 8px 24px rgba(88,44,12,0.12)';
                    wrapper.appendChild(dropdownResult);
                }

                let timer;
                input.addEventListener('input', function () {
                    clearTimeout(timer);
                    const q = this.value.trim();
                    if (q.length < 2) {
                        dropdownResult.style.display = 'none';
                        return;
                    }

                    timer = setTimeout(() => doTopbarSearch(q), 350);
                });

                input.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape') {
                        dropdownResult.style.display = 'none';
                        this.blur();
                    }
                });

                document.addEventListener('click', function (e) {
                    if (!wrapper.contains(e.target)) {
                        dropdownResult.style.display = 'none';
                    }
                });

                async function doTopbarSearch(q) {
                    dropdownResult.style.display = 'block';
                    dropdownResult.innerHTML = '<div style="padding:12px 16px; color:#999; font-size:13px;">Mencari...</div>';

                    try {
                        const res = await fetch(`/admin/patients/search?q=${encodeURIComponent(q)}`, {
                            headers: {
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                            }
                        });
                        const data = await res.json();

                        if (data.success && data.data && data.data.length > 0) {
                            const statusColors = {
                                pending: '#EF4444',
                                confirmed: '#F59E0B',
                                waiting: '#8B5CF6',
                                engaged: '#3B82F6',
                                succeed: '#84CC16',
                                failed: '#6B7280',
                            };

                            const activeStatusFilter = (window.emrTopbarAdvancedFilter?.status || '').toLowerCase();
                            const activeScopeFilter = (window.emrTopbarAdvancedFilter?.scope || 'semua').toLowerCase();
                            const todayKey = new Date().toISOString().slice(0, 10);

                            const filteredPatients = data.data.map((p) => {
                                const sourceAppointments = Array.isArray(p.appointments) ? p.appointments : [];
                                const filteredAppointments = sourceAppointments.filter((a) => {
                                    const statusMatch = !activeStatusFilter || String(a.status || '').toLowerCase() === activeStatusFilter;

                                    let scopeMatch = true;
                                    if (activeScopeFilter === 'hari_ini') {
                                        const apptDate = a.datetime ? new Date(a.datetime).toISOString().slice(0, 10) : '';
                                        scopeMatch = apptDate === todayKey;
                                    }

                                    return statusMatch && scopeMatch;
                                });

                                return {
                                    ...p,
                                    filteredAppointments,
                                };
                            }).filter((p) => {
                                if (!activeStatusFilter && activeScopeFilter === 'semua') {
                                    return true;
                                }
                                return p.filteredAppointments.length > 0;
                            });

                            if (filteredPatients.length === 0) {
                                dropdownResult.innerHTML = '<div style="padding:12px 16px; color:#999; font-size:13px;">Tidak ada hasil sesuai filter.</div>';
                                return;
                            }

                            dropdownResult.innerHTML = filteredPatients.map(p => {
                                const appointmentsForRender = p.filteredAppointments || [];
                                const appointmentRows = appointmentsForRender.length > 0
                                    ? appointmentsForRender.map(a => {
                                        const dt = new Date(a.datetime);
                                        const tgl = dt.toLocaleDateString('id-ID', { day:'2-digit', month:'short', year:'numeric' });
                                        const jam = dt.toLocaleTimeString('id-ID', { hour:'2-digit', minute:'2-digit' });
                                        const badgeColor = statusColors[(a.status || '').toLowerCase()] || '#888';

                                        return `
                                            <div onclick="emrTopbarSearchSelect('${a.id}', '${String(p.full_name || '').replace(/'/g, "\\'")}')"
                                                 style="padding: 7px 16px 7px 28px; cursor: pointer; border-bottom: 1px solid #faf3ec; font-size: 12px; display: flex; justify-content: space-between; align-items: center; background: #fdfaf7;"
                                                 onmouseover="this.style.background='#f5ede0'"
                                                 onmouseout="this.style.background='#fdfaf7'">
                                                <div style="display:flex; align-items:center; gap:8px;">
                                                    <i class="fas fa-calendar-alt" style="color:#C58F59; font-size:10px;"></i>
                                                    <span style="color:#5a3e28;">${tgl}, ${jam}</span>
                                                    <span style="color:#aaa;">- ${a.poli || '-'} / ${a.doctor || '-'}</span>
                                                </div>
                                                <div style="display:flex; align-items:center; gap:6px;">
                                                    <span style="background:${badgeColor}; color:white; font-size:9px; padding:2px 7px; border-radius:20px; font-weight:700; text-transform:uppercase;">${a.status || '-'}</span>
                                                    <span style="color:#C58F59; font-size:10px;"><i class="fas fa-arrow-right"></i></span>
                                                </div>
                                            </div>
                                        `;
                                    }).join('')
                                    : '<div style="padding: 7px 16px 7px 28px; font-size: 12px; color: #bbb; background:#fdfaf7; border-bottom: 1px solid #faf3ec;"><i class="fas fa-info-circle"></i> Belum ada kunjungan</div>';

                                return `
                                    <div>
                                        <div style="padding: 10px 16px; border-bottom: 1px solid #f0e8df; background: white; display: flex; justify-content: space-between; align-items: center;">
                                            <div>
                                                <div style="font-weight: 700; color: #2C1810; font-size: 13px;">${p.full_name || '-'}</div>
                                                <div style="color: #999; font-size: 11px; margin-top: 2px;">MR: ${p.medical_record_no || '-'} | KTP: ${p.id_card_number || '-'}</div>
                                            </div>
                                            <div style="color:#aaa; font-size:11px; white-space:nowrap; margin-left:8px;">${appointmentsForRender.length} kunjungan</div>
                                        </div>
                                        ${appointmentRows}
                                    </div>
                                `;
                            }).join('');
                        } else {
                            dropdownResult.innerHTML = '<div style="padding:12px 16px; color:#999; font-size:13px;">Pasien tidak ditemukan.</div>';
                        }
                    } catch (error) {
                        console.error('Topbar EMR search error:', error);
                        dropdownResult.innerHTML = '<div style="padding:12px 16px; color:#e05252; font-size:13px;">Gagal mencari data.</div>';
                    }
                }

                window.emrTopbarSearchSelect = function(apptId, patientName) {
                    dropdownResult.style.display = 'none';
                    input.value = patientName;
                    window.location.href = `/admin/emr?open=${apptId}`;
                };

                window.emrRunTopbarSearch = async function(query) {
                    const q = String(query || '').trim();
                    if (q.length < 2) {
                        dropdownResult.style.display = 'block';
                        dropdownResult.innerHTML = '<div style="padding:12px 16px; color:#999; font-size:13px;">Masukkan minimal 2 karakter untuk mencari.</div>';
                        return;
                    }

                    await doTopbarSearch(q);
                };
            }

            function initEmrAdvanceSearch() {
                const advanceBtn = document.querySelector('.navbar-btn-primary');
                const topbarInput = document.querySelector('.navbar-search-input');

                if (!advanceBtn || advanceBtn.dataset.boundAdvanceSearch === '1') {
                    return;
                }

                advanceBtn.dataset.boundAdvanceSearch = '1';
                advanceBtn.type = 'button';

                const host = advanceBtn.parentElement || document.body;
                host.style.position = 'relative';

                let panel = document.getElementById('emrAdvanceSearchPanel');
                if (!panel) {
                    panel = document.createElement('div');
                    panel.id = 'emrAdvanceSearchPanel';
                    panel.style.cssText = [
                        'display:none',
                        'position:absolute',
                        'top:calc(100% + 8px)',
                        'left:0',
                        'min-width:320px',
                        'background:#fff',
                        'border:1px solid #E5D6C5',
                        'border-radius:12px',
                        'padding:12px',
                        'box-shadow:0 10px 24px rgba(88,44,12,0.16)',
                        'z-index:9999'
                    ].join(';');

                    panel.innerHTML = `
                        <div style="font-size:12px;font-weight:800;color:#5a3e28;margin-bottom:8px;">Advance Search</div>
                        <div style="display:flex;flex-direction:column;gap:8px;">
                            <div>
                                <label style="font-size:11px;color:#8e6a45;font-weight:700;display:block;margin-bottom:4px;">Keyword</label>
                                <input id="emrAdvKeyword" type="text" placeholder="Nama/MR/KTP" style="width:100%;border:1px solid #E5D6C5;border-radius:8px;padding:8px 10px;font-size:12px;outline:none;">
                            </div>
                            <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;">
                                <div>
                                    <label style="font-size:11px;color:#8e6a45;font-weight:700;display:block;margin-bottom:4px;">Status</label>
                                    <select id="emrAdvStatus" style="width:100%;border:1px solid #E5D6C5;border-radius:8px;padding:8px 10px;font-size:12px;background:#fff;outline:none;">
                                        <option value="">Semua</option>
                                        <option value="pending">Pending</option>
                                        <option value="confirmed">Confirmed</option>
                                        <option value="waiting">Waiting</option>
                                        <option value="engaged">Engaged</option>
                                        <option value="succeed">Succeed</option>
                                        <option value="failed">Failed</option>
                                    </select>
                                </div>
                                <div>
                                    <label style="font-size:11px;color:#8e6a45;font-weight:700;display:block;margin-bottom:4px;">Cakupan</label>
                                    <select id="emrAdvScope" style="width:100%;border:1px solid #E5D6C5;border-radius:8px;padding:8px 10px;font-size:12px;background:#fff;outline:none;">
                                        <option value="hari_ini">Hari Ini</option>
                                        <option value="semua">Semua</option>
                                    </select>
                                </div>
                            </div>
                            <div style="display:flex;justify-content:flex-end;gap:8px;margin-top:2px;">
                                <button id="emrAdvReset" type="button" style="padding:7px 10px;border:1px solid #d8c7b2;background:#fff;color:#6f5635;border-radius:8px;font-size:12px;font-weight:700;cursor:pointer;">Reset</button>
                                <button id="emrAdvApply" type="button" style="padding:7px 10px;border:1px solid #8e6a45;background:#8e6a45;color:#fff;border-radius:8px;font-size:12px;font-weight:700;cursor:pointer;">Terapkan</button>
                            </div>
                        </div>
                    `;

                    host.appendChild(panel);
                }

                const keywordInput = panel.querySelector('#emrAdvKeyword');
                const statusSelect = panel.querySelector('#emrAdvStatus');
                const scopeSelect = panel.querySelector('#emrAdvScope');
                const applyBtn = panel.querySelector('#emrAdvApply');
                const resetBtn = panel.querySelector('#emrAdvReset');

                function applyAdvancedFilter() {
                    const rawKeyword = (keywordInput?.value || topbarInput?.value || '').trim();
                    const keyword = rawKeyword.toLowerCase();
                    const selectedStatus = (statusSelect?.value || '').toLowerCase();
                    const selectedScope = scopeSelect?.value || 'hari_ini';

                    if (keywordInput) {
                        keywordInput.value = rawKeyword;
                    }

                    window.emrTopbarAdvancedFilter = {
                        status: selectedStatus,
                        scope: selectedScope,
                    };

                    if (topbarInput) {
                        topbarInput.value = rawKeyword;
                    }

                    if (typeof window.emrRunTopbarSearch === 'function') {
                        window.emrRunTopbarSearch(rawKeyword);
                    }
                }

                function resetAdvancedFilter() {
                    if (keywordInput) keywordInput.value = '';
                    if (statusSelect) statusSelect.value = '';
                    if (scopeSelect) scopeSelect.value = 'hari_ini';
                    if (topbarInput) topbarInput.value = '';

                    window.emrTopbarAdvancedFilter = {
                        status: '',
                        scope: 'semua',
                    };
                }

                advanceBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    if (keywordInput && topbarInput) {
                        keywordInput.value = topbarInput.value || '';
                    }
                    panel.style.display = panel.style.display === 'none' ? 'block' : 'none';
                });

                if (applyBtn) {
                    applyBtn.addEventListener('click', function() {
                        applyAdvancedFilter();
                        panel.style.display = 'none';
                    });
                }

                if (keywordInput) {
                    keywordInput.addEventListener('keydown', function(e) {
                        if (e.key === 'Enter') {
                            e.preventDefault();
                            applyAdvancedFilter();
                            panel.style.display = 'none';
                        }
                    });
                }

                if (resetBtn) {
                    resetBtn.addEventListener('click', function() {
                        resetAdvancedFilter();
                        panel.style.display = 'none';
                    });
                }

                panel.addEventListener('click', function(e) {
                    e.stopPropagation();
                });

                document.addEventListener('click', function(e) {
                    if (!host.contains(e.target)) {
                        panel.style.display = 'none';
                    }
                });
            }

            // ===== FIXED SIDEBAR TOGGLE (MOBILE) - BLACKBOXAI FIX =====
            (function initMobileSidebarToggle() {
                const sidebar = document.getElementById('emrSidebar');
                const toggleBtn = document.getElementById('emrSidebarToggle');
                const patientList = document.getElementById('emrPatientList');
                if (!sidebar || !toggleBtn || !patientList) return;

                function isMobile() { 
                    return window.matchMedia('(max-width: 768px)').matches; 
                }

                // Persist state
                const STORAGE_KEY = 'emr_sidebar_mobile_state';
                function getStoredState() {
                    return localStorage.getItem(STORAGE_KEY) === 'expanded';
                }
                function setStoredState(expanded) {
                    localStorage.setItem(STORAGE_KEY, expanded ? 'expanded' : 'collapsed');
                }

                // Reset carousel scroll
                function resetCarouselScroll() {
                    if (patientList) {
                        patientList.scrollLeft = 0;
                        patientList.style.scrollSnapType = 'x mandatory';
                    }
                }

                // Haptic feedback
                function hapticFeedback() {
                    if (navigator.vibrate) {
                        navigator.vibrate(50);
                    }
                }

                // Update arrow rotation + label
                function updateToggleUI(expanded) {
                    const arrow = toggleBtn.querySelector('.emr-sidebar-toggle-arrow');
                    const countBadge = document.getElementById('sidebarPatientCount');
                    if (arrow) {
                        arrow.style.transform = expanded ? 'rotate(180deg)' : 'rotate(0deg)';
                    }
                    // countBadge already handled by blade/filter
                }

                // Toggle handler - FIXED
                toggleBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    if (!isMobile()) return;

                    const wasExpanded = sidebar.classList.contains('expanded');
                    const willExpand = !wasExpanded;

                    sidebar.classList.toggle('expanded');
                    updateToggleUI(willExpand);
                    
                    if (willExpand) {
                        // On expand: reset scroll + haptic
                        resetCarouselScroll();
                        setTimeout(hapticFeedback, 100);
                    }

                    setStoredState(willExpand);
                });

                // Auto-collapse on patient select - DELAYED until AJAX complete
                let patientSelectPending = false;
                document.addEventListener('click', function(e) {
                    const patientLink = e.target.closest('.js-emr-patient-link');
                    if (!patientLink || !isMobile()) return;

                    patientSelectPending = true; // Mark pending
                    
                    // Delay collapse until AFTER AJAX loads detail
                    setTimeout(() => {
                        if (patientSelectPending && sidebar.classList.contains('expanded')) {
                            sidebar.classList.remove('expanded');
                            updateToggleUI(false);
                            setStoredState(false);
                            resetCarouselScroll(); // Reset even on collapse
                            patientSelectPending = false;
                        }
                    }, 800); // Wait for AJAX + animations
                });

                // Listen for patient detail AJAX complete to clear pending
                const observer = new MutationObserver(() => {
                    if (patientSelectPending) {
                        patientSelectPending = false; // AJAX done, safe to collapse now
                    }
                });
                observer.observe(document.getElementById('emr-detail-view') || document.body, {
                    childList: true,
                    subtree: true
                });

                // Restore state on load/resize
                if (isMobile() && getStoredState()) {
                    sidebar.classList.add('expanded');
                    updateToggleUI(true);
                }

                window.addEventListener('resize', () => {
                    if (!isMobile() && sidebar.classList.contains('expanded')) {
                        sidebar.classList.remove('expanded');
                    }
                });

                // Filter count update
                const filterBox = document.getElementById('customFilterDropdown');
                if (filterBox) {
                    filterBox.querySelectorAll('.emr-option').forEach(opt => {
                        opt.addEventListener('click', function() {
                            const countBadge = document.getElementById('sidebarPatientCount');
                            if (countBadge) {
                                const listId = this.dataset.value === 'hari_ini' ? 'list-hari-ini' : 'list-semua';
                                const listEl = document.getElementById(listId);
                                const count = listEl ? listEl.querySelectorAll('.js-emr-patient-link').length : 0;
                                countBadge.textContent = count;
                            }
                        });
                    });
                }
            })();

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
        const RECORD_PAGE_SIZE = 5;

        function applyRecordPaginationForPane(pane, forceFirstPage = false) {
            if (!pane) return;

            const shell = pane.querySelector('.record-table-shell');
            if (!shell) return;

            const rows = Array.from(shell.querySelectorAll('.record-table-row'));
            const totalRows = rows.length;
            const totalPages = Math.max(1, Math.ceil(totalRows / RECORD_PAGE_SIZE));

            if (forceFirstPage) {
                pane.dataset.recordPage = '1';
            }

            let currentPage = parseInt(pane.dataset.recordPage || '1', 10);
            if (!Number.isFinite(currentPage) || currentPage < 1) currentPage = 1;
            if (currentPage > totalPages) currentPage = totalPages;
            pane.dataset.recordPage = String(currentPage);

            const start = (currentPage - 1) * RECORD_PAGE_SIZE;
            const end = start + RECORD_PAGE_SIZE;

            rows.forEach((row, index) => {
                row.classList.toggle('hidden', !(index >= start && index < end));
            });

            let pager = pane.querySelector('.record-pagination');
            if (!pager) {
                pager = document.createElement('div');
                pager.className = 'record-pagination';
                pager.style.display = 'flex';
                pager.style.justifyContent = 'space-between';
                pager.style.alignItems = 'center';
                pager.style.gap = '10px';
                pager.style.padding = '12px 14px';
                pager.style.borderTop = '1px solid var(--brown-200)';
                pager.style.background = '#fff';
                shell.appendChild(pager);
            }

            if (totalRows <= RECORD_PAGE_SIZE) {
                pager.style.display = 'none';
                return;
            }

            pager.style.display = 'flex';
            pager.innerHTML = `
                <div style="font-size:12px; color:var(--brown-500); font-weight:700;">
                    Halaman ${currentPage} dari ${totalPages} • ${totalRows} data
                </div>
                <div style="display:flex; gap:8px;">
                    <button type="button" class="record-page-prev" style="border:1px solid var(--brown-200); background:#fff; color:var(--brown-700); border-radius:8px; padding:6px 12px; font-size:12px; font-weight:700; cursor:pointer;">
                        Prev
                    </button>
                    <button type="button" class="record-page-next" style="border:1px solid var(--brown-200); background:#fff; color:var(--brown-700); border-radius:8px; padding:6px 12px; font-size:12px; font-weight:700; cursor:pointer;">
                        Next
                    </button>
                </div>
            `;

            const prevBtn = pager.querySelector('.record-page-prev');
            const nextBtn = pager.querySelector('.record-page-next');

            const syncBtnState = (btn, disabled) => {
                if (!btn) return;
                btn.disabled = disabled;
                btn.style.opacity = disabled ? '0.45' : '1';
                btn.style.cursor = disabled ? 'not-allowed' : 'pointer';
            };

            syncBtnState(prevBtn, currentPage <= 1);
            syncBtnState(nextBtn, currentPage >= totalPages);

            if (prevBtn) {
                prevBtn.onclick = () => {
                    pane.dataset.recordPage = String(Math.max(1, currentPage - 1));
                    applyRecordPaginationForPane(pane);
                };
            }

            if (nextBtn) {
                nextBtn.onclick = () => {
                    pane.dataset.recordPage = String(Math.min(totalPages, currentPage + 1));
                    applyRecordPaginationForPane(pane);
                };
            }
        }

        function initRecordPagination() {
            const recordPanes = document.querySelectorAll('[data-record-tab-content]');
            recordPanes.forEach((pane) => applyRecordPaginationForPane(pane));
        }

        function bindTabEvents() {
            const tabButtons = document.querySelectorAll('.tab-item');
            const tabPanes = document.querySelectorAll('[data-tab-content]');
            const currentStatusLabel = document.querySelector('.status-current-text');

            if (currentStatusLabel) {
                filterStatusMenuByCurrent(currentStatusLabel.textContent);
            }
            if (typeof initPatientDetailPhotoInput === 'function') {
                initPatientDetailPhotoInput();
            }
            if (typeof initSensitiveInfoToggles === 'function') {
                initSensitiveInfoToggles();
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

                    const activePane = Array.from(recordPanes).find(p => p.dataset.recordTabContent === tab);
                    if (activePane) {
                        applyRecordPaginationForPane(activePane);
                    }
                });
            });

            initRecordPagination();
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

function formatDoctorNoteDisplayDate(rawDate) {
    if (!rawDate) return '-';

    const parsedDate = new Date(rawDate);
    if (!Number.isNaN(parsedDate.getTime())) {
        return parsedDate.toLocaleDateString('id-ID', {
            day: '2-digit',
            month: 'long',
            year: 'numeric'
        });
    }

    const monthMap = {
        Jan: 'Januari',
        Feb: 'Februari',
        Mar: 'Maret',
        Apr: 'April',
        May: 'Mei',
        Jun: 'Juni',
        Jul: 'Juli',
        Aug: 'Agustus',
        Sep: 'September',
        Oct: 'Oktober',
        Nov: 'November',
        Dec: 'Desember',
    };

    const parts = String(rawDate).trim().split(/\s+/);
    if (parts.length >= 3) {
        const day = parts[0];
        const month = monthMap[parts[1]] || parts[1];
        const year = parts[2];
        return `${day} ${month} ${year}`;
    }

    return String(rawDate);
}

function prependDoctorNoteToRecordTab(noteData = {}) {
    const pane = document.querySelector('[data-record-tab-content="catatan-dokter"]');
    const recordShell = pane?.querySelector('.record-table-shell');
    if (!recordShell) return;

    const emptyState = recordShell.querySelector('#doctor-note-empty');
    if (emptyState) {
        emptyState.remove();
    }

    const row = document.createElement('div');
    row.className = 'record-table-row';
    row.style.gridTemplateColumns = '180px 300px 1fr';

    const dateCell = document.createElement('div');
    dateCell.className = 'record-table-text';
    dateCell.style.fontWeight = '600';
    dateCell.textContent = formatDoctorNoteDisplayDate(noteData.created_at);

    const doctorCell = document.createElement('div');
    doctorCell.className = 'record-table-text';
    doctorCell.style.fontWeight = '700';
    doctorCell.style.lineHeight = '1.5';
    const doctorName = document.createElement('div');
    doctorName.textContent = noteData.doctor_name || '-';
    doctorCell.appendChild(doctorName);

    const noteCell = document.createElement('div');
    noteCell.style.padding = '10px 12px';

    const noteGrid = document.createElement('div');
    noteGrid.style.display = 'grid';
    noteGrid.style.gridTemplateColumns = '150px minmax(0, 1fr)';
    noteGrid.style.gap = '6px 12px';
    noteGrid.style.alignItems = 'start';

    const appendSection = (title, content) => {
        const label = document.createElement('div');
        label.style.fontSize = '11px';
        label.style.color = 'var(--brown-500)';
        label.style.fontWeight = '800';
        label.style.textTransform = 'uppercase';
        label.textContent = title;

        const value = document.createElement('div');
        value.className = 'record-table-text';
        value.style.lineHeight = '1.35';
        value.textContent = content || '-';

        noteGrid.appendChild(label);
        noteGrid.appendChild(value);
    };

    appendSection('Subjectives', noteData.subjective);
    appendSection('Objectives', noteData.objective);
    appendSection('Plans', noteData.plan);

    noteCell.appendChild(noteGrid);

    row.appendChild(dateCell);
    row.appendChild(doctorCell);
    row.appendChild(noteCell);

    const tableHead = recordShell.querySelector('.record-table-head');
    if (tableHead && tableHead.parentNode === recordShell) {
        recordShell.insertBefore(row, tableHead.nextSibling);
    } else {
        recordShell.appendChild(row);
    }

    if (pane) {
        applyRecordPaginationForPane(pane, true);
    }
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

        if (data.data) {
            prependDoctorNoteToRecordTab(data.data);
        }

        toggleDoctorNoteModal(false);
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

const patientDetailPhotoCropperState = {
    image: null,
    originalWidth: 0,
    originalHeight: 0,
    frameX: undefined,
    frameY: undefined,
    frameSize: 180,
    isDragging: false,
    startX: 0,
    startY: 0,
    mouseDownHandler: null,
    mouseMoveHandler: null,
    mouseUpHandler: null,
};

function togglePatientDetailEdit(isEditMode) {
    const fields = document.querySelectorAll('[data-patient-field]');
    const editBtn = document.getElementById('patientDetailEditBtn');
    const cancelBtn = document.getElementById('patientDetailCancelBtn');
    const saveBtn = document.getElementById('patientDetailSaveBtn');
    const photoInput = document.getElementById('patientDetailPhotoInput');
    const photoUploadLabel = document.getElementById('patientDetailPhotoUploadLabel');
    const photoBase64 = document.getElementById('patientDetailPhotoBase64');
    const photoPreview = document.getElementById('patientDetailPhotoPreview');

    fields.forEach((field) => {
        field.disabled = !isEditMode;
    });

    if (isEditMode && photoPreview) {
        photoPreview.dataset.originalSrc = photoPreview.src || '';
    }

    if (photoInput) {
        photoInput.disabled = !isEditMode;
        if (!isEditMode) {
            photoInput.value = '';
            if (photoBase64) photoBase64.value = '';
        }
    }

    if (!isEditMode && photoPreview && photoPreview.dataset.originalSrc) {
        photoPreview.src = photoPreview.dataset.originalSrc;
    }

    if (photoUploadLabel) {
        photoUploadLabel.classList.toggle('disabled', !isEditMode);
    }

    if (editBtn) editBtn.classList.toggle('hidden', isEditMode);
    if (cancelBtn) cancelBtn.classList.toggle('hidden', !isEditMode);
    if (saveBtn) saveBtn.classList.toggle('hidden', !isEditMode);
}

function openPatientDetailPhotoCropperModal() {
    const modal = document.getElementById('patientDetailPhotoCropperModal');
    if (!modal) return;

    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';

    setTimeout(() => {
        renderPatientDetailPhotoCropperCanvas();
        attachPatientDetailPhotoCropperEvents();
    }, 60);
}

function closePatientDetailPhotoCropperModal() {
    const modal = document.getElementById('patientDetailPhotoCropperModal');
    if (modal) {
        modal.style.display = 'none';
    }
    document.body.style.overflow = '';
    detachPatientDetailPhotoCropperEvents();
    patientDetailPhotoCropperState.isDragging = false;
}

function renderPatientDetailPhotoCropperCanvas() {
    const canvas = document.getElementById('patientDetailPhotoCropperCanvas');
    const img = patientDetailPhotoCropperState.image;
    if (!canvas || !img) return;

    let displayWidth = Math.min(img.width, 520);
    let displayHeight = (img.height / img.width) * displayWidth;

    if (displayHeight > 420) {
        displayHeight = 420;
        displayWidth = (img.width / img.height) * displayHeight;
    }

    displayWidth = Math.round(displayWidth);
    displayHeight = Math.round(displayHeight);

    canvas.width = displayWidth;
    canvas.height = displayHeight;

    if (patientDetailPhotoCropperState.frameX === undefined || patientDetailPhotoCropperState.frameY === undefined) {
        patientDetailPhotoCropperState.frameX = displayWidth / 2;
        patientDetailPhotoCropperState.frameY = displayHeight / 2;
    }

    const ctx = canvas.getContext('2d');
    if (!ctx) return;

    ctx.clearRect(0, 0, displayWidth, displayHeight);
    ctx.drawImage(img, 0, 0, displayWidth, displayHeight);

    ctx.fillStyle = 'rgba(0,0,0,0.48)';
    ctx.fillRect(0, 0, displayWidth, displayHeight);

    ctx.save();
    ctx.globalCompositeOperation = 'destination-out';
    ctx.beginPath();
    ctx.arc(
        patientDetailPhotoCropperState.frameX,
        patientDetailPhotoCropperState.frameY,
        patientDetailPhotoCropperState.frameSize / 2,
        0,
        Math.PI * 2
    );
    ctx.fill();
    ctx.restore();

    ctx.drawImage(img, 0, 0, displayWidth, displayHeight);
    ctx.globalCompositeOperation = 'destination-in';
    ctx.beginPath();
    ctx.arc(
        patientDetailPhotoCropperState.frameX,
        patientDetailPhotoCropperState.frameY,
        patientDetailPhotoCropperState.frameSize / 2,
        0,
        Math.PI * 2
    );
    ctx.fill();
    ctx.globalCompositeOperation = 'source-over';

    ctx.strokeStyle = '#C58F59';
    ctx.lineWidth = 3;
    ctx.beginPath();
    ctx.arc(
        patientDetailPhotoCropperState.frameX,
        patientDetailPhotoCropperState.frameY,
        patientDetailPhotoCropperState.frameSize / 2,
        0,
        Math.PI * 2
    );
    ctx.stroke();
}

function attachPatientDetailPhotoCropperEvents() {
    const canvas = document.getElementById('patientDetailPhotoCropperCanvas');
    if (!canvas) return;

    detachPatientDetailPhotoCropperEvents();

    const mouseDownHandler = function(event) {
        const rect = canvas.getBoundingClientRect();
        const x = event.clientX - rect.left;
        const y = event.clientY - rect.top;
        const dx = x - patientDetailPhotoCropperState.frameX;
        const dy = y - patientDetailPhotoCropperState.frameY;
        const distance = Math.sqrt(dx * dx + dy * dy);

        if (distance <= (patientDetailPhotoCropperState.frameSize / 2) + 10) {
            patientDetailPhotoCropperState.isDragging = true;
            patientDetailPhotoCropperState.startX = x;
            patientDetailPhotoCropperState.startY = y;
        }
    };

    const mouseMoveHandler = function(event) {
        if (!patientDetailPhotoCropperState.isDragging) return;

        const rect = canvas.getBoundingClientRect();
        const x = event.clientX - rect.left;
        const y = event.clientY - rect.top;

        const deltaX = x - patientDetailPhotoCropperState.startX;
        const deltaY = y - patientDetailPhotoCropperState.startY;

        let nextX = patientDetailPhotoCropperState.frameX + deltaX;
        let nextY = patientDetailPhotoCropperState.frameY + deltaY;
        const radius = patientDetailPhotoCropperState.frameSize / 2;

        nextX = Math.max(radius * 0.25, Math.min(canvas.width - (radius * 0.25), nextX));
        nextY = Math.max(radius * 0.25, Math.min(canvas.height - (radius * 0.25), nextY));

        patientDetailPhotoCropperState.frameX = nextX;
        patientDetailPhotoCropperState.frameY = nextY;
        patientDetailPhotoCropperState.startX = x;
        patientDetailPhotoCropperState.startY = y;

        renderPatientDetailPhotoCropperCanvas();
    };

    const mouseUpHandler = function() {
        patientDetailPhotoCropperState.isDragging = false;
    };

    canvas.addEventListener('mousedown', mouseDownHandler);
    document.addEventListener('mousemove', mouseMoveHandler);
    document.addEventListener('mouseup', mouseUpHandler);

    patientDetailPhotoCropperState.mouseDownHandler = mouseDownHandler;
    patientDetailPhotoCropperState.mouseMoveHandler = mouseMoveHandler;
    patientDetailPhotoCropperState.mouseUpHandler = mouseUpHandler;
}

function detachPatientDetailPhotoCropperEvents() {
    const canvas = document.getElementById('patientDetailPhotoCropperCanvas');
    if (canvas && patientDetailPhotoCropperState.mouseDownHandler) {
        canvas.removeEventListener('mousedown', patientDetailPhotoCropperState.mouseDownHandler);
    }
    if (patientDetailPhotoCropperState.mouseMoveHandler) {
        document.removeEventListener('mousemove', patientDetailPhotoCropperState.mouseMoveHandler);
    }
    if (patientDetailPhotoCropperState.mouseUpHandler) {
        document.removeEventListener('mouseup', patientDetailPhotoCropperState.mouseUpHandler);
    }

    patientDetailPhotoCropperState.mouseDownHandler = null;
    patientDetailPhotoCropperState.mouseMoveHandler = null;
    patientDetailPhotoCropperState.mouseUpHandler = null;
}

function applyPatientDetailPhotoCrop() {
    const canvas = document.getElementById('patientDetailPhotoCropperCanvas');
    const photoPreview = document.getElementById('patientDetailPhotoPreview');
    const photoBase64 = document.getElementById('patientDetailPhotoBase64');

    if (!canvas || !photoPreview || !photoBase64 || !patientDetailPhotoCropperState.image) {
        return;
    }

    const size = patientDetailPhotoCropperState.frameSize;
    const croppedCanvas = document.createElement('canvas');
    croppedCanvas.width = size;
    croppedCanvas.height = size;

    const ctx = croppedCanvas.getContext('2d');
    if (!ctx) return;

    const scaleX = patientDetailPhotoCropperState.originalWidth / canvas.width;
    const scaleY = patientDetailPhotoCropperState.originalHeight / canvas.height;

    const srcX = (patientDetailPhotoCropperState.frameX - (size / 2)) * scaleX;
    const srcY = (patientDetailPhotoCropperState.frameY - (size / 2)) * scaleY;
    const srcSizeX = size * scaleX;
    const srcSizeY = size * scaleY;

    ctx.drawImage(
        patientDetailPhotoCropperState.image,
        srcX, srcY, srcSizeX, srcSizeY,
        0, 0, size, size
    );

    ctx.globalCompositeOperation = 'destination-in';
    ctx.beginPath();
    ctx.arc(size / 2, size / 2, size / 2, 0, Math.PI * 2);
    ctx.fill();

    const fullDataUrl = croppedCanvas.toDataURL('image/png');
    photoPreview.src = fullDataUrl;
    photoBase64.value = fullDataUrl;

    closePatientDetailPhotoCropperModal();
}

function initPatientDetailPhotoInput() {
    const photoInput = document.getElementById('patientDetailPhotoInput');
    const cropperModal = document.getElementById('patientDetailPhotoCropperModal');

    if (!photoInput || photoInput.dataset.bound === '1') {
        return;
    }

    photoInput.dataset.bound = '1';
    photoInput.addEventListener('change', function(event) {
        const file = event.target.files && event.target.files[0];
        if (!file) return;

        if (!file.type.startsWith('image/')) {
            alert('File harus berupa gambar.');
            event.target.value = '';
            return;
        }

        if (file.size > 2 * 1024 * 1024) {
            alert('Ukuran foto maksimal 2MB.');
            event.target.value = '';
            return;
        }

        const reader = new FileReader();
        reader.onload = function(loadEvent) {
            const result = loadEvent.target && loadEvent.target.result ? String(loadEvent.target.result) : '';
            if (!result) return;

            const image = new Image();
            image.onload = function() {
                patientDetailPhotoCropperState.image = image;
                patientDetailPhotoCropperState.originalWidth = image.width;
                patientDetailPhotoCropperState.originalHeight = image.height;
                patientDetailPhotoCropperState.frameX = undefined;
                patientDetailPhotoCropperState.frameY = undefined;
                openPatientDetailPhotoCropperModal();
            };
            image.src = result;
        };
        reader.readAsDataURL(file);
    });

    if (cropperModal && cropperModal.dataset.bound !== '1') {
        cropperModal.dataset.bound = '1';
        cropperModal.addEventListener('click', function(event) {
            if (event.target && event.target.id === 'patientDetailPhotoCropperModal') {
                closePatientDetailPhotoCropperModal();
            }
        });
    }
}

function initSensitiveInfoToggles() {
    document.querySelectorAll('.js-sensitive-toggle').forEach((icon) => {
        if (icon.dataset.bound === '1') return;

        icon.dataset.bound = '1';
        icon.addEventListener('click', function() {
            const targetId = icon.dataset.sensitiveTarget;
            if (!targetId) return;

            const target = document.getElementById(targetId);
            if (!target) return;

            const original = target.dataset.sensitiveOriginal || '-';
            const isVisible = target.dataset.sensitiveVisible === '1';

            if (isVisible) {
                target.textContent = original === '-' ? '-' : '••••••••';
                target.dataset.sensitiveVisible = '0';
                target.classList.add('is-masked');
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
                icon.classList.remove('is-active');
                return;
            }

            target.textContent = original;
            target.dataset.sensitiveVisible = '1';
            target.classList.remove('is-masked');
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
            icon.classList.add('is-active');
        });
    });
}

async function savePatientDetailFromModal() {
    const patientId = document.getElementById('patientDetailPatientId')?.value;
    const saveBtn = document.getElementById('patientDetailSaveBtn');

    if (!patientId) {
        alert('Data pasien tidak ditemukan.');
        return;
    }

    const payload = {};
    document.querySelectorAll('[data-patient-field]').forEach((field) => {
        payload[field.dataset.patientField] = field.value;
    });

    const photoBase64 = document.getElementById('patientDetailPhotoBase64')?.value || '';
    if (photoBase64) {
        payload.photo_base64 = photoBase64;
    }

    const originalText = saveBtn ? saveBtn.textContent : '';
    if (saveBtn) {
        saveBtn.disabled = true;
        saveBtn.textContent = 'Menyimpan...';
    }

    try {
        const response = await fetch(`/api/patients/${patientId}`, {
            method: 'PUT',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            },
            body: JSON.stringify(payload)
        });

        const data = await response.json();
        if (!response.ok || !data.success) {
            throw new Error(data.message || 'Gagal menyimpan data pasien.');
        }

        togglePatientDetailEdit(false);

        const activePatientLink = document.querySelector('.js-emr-patient-link .patient-card.active')?.closest('a');
        if (activePatientLink) {
            activePatientLink.click();
        }

        alert('Data pasien berhasil diperbarui.');
    } catch (error) {
        console.error('Gagal update data pasien:', error);
        alert(error.message || 'Terjadi kesalahan saat memperbarui data pasien.');
    } finally {
        if (saveBtn) {
            saveBtn.disabled = false;
            saveBtn.textContent = originalText;
        }
    }
}

window.togglePatientDetailEdit = togglePatientDetailEdit;
window.savePatientDetailFromModal = savePatientDetailFromModal;
window.initPatientDetailPhotoInput = initPatientDetailPhotoInput;
window.closePatientDetailPhotoCropperModal = closePatientDetailPhotoCropperModal;
window.applyPatientDetailPhotoCrop = applyPatientDetailPhotoCrop;

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

            const addDiagnosaBtn = document.querySelector('.btn-primary-blue, .btn-primary-brown');
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