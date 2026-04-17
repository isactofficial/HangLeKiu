@extends('doctor.layout.doctor')
@section('title', 'EMR Saya')



@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/pages/emr.css') }}">
<link rel="stylesheet" href="{{ asset('css/admin/pages/emr-mobile.css') }}">
<style>
    :root {
        --doctor-navbar-offset: 88px;
    }

    /* ===== LAYOUT ===== */
    .emr-container { padding: 18px 24px 26px; }
    .emr-layout { display:flex; gap:20px; align-items:flex-start; width:100%; margin-top:20px; }
    .emr-sidebar { width:260px; flex-shrink:0; }
    .emr-main { flex:1; background:#fff; border:1px solid #eef2f7; border-radius:15px; padding:20px; position:relative; min-height:80vh; }
    .emr-title-area { min-width: 0; }

    .emr-sidebar-header { margin-bottom: 8px; }
    .emr-sidebar-search {
        width:100%;
        padding:9px 12px;
        border:1px solid #e2e8f0;
        border-radius:8px;
        font-size:12px;
        outline:none;
        margin-bottom:10px;
        box-sizing:border-box;
        color:#582C0C;
        transition:border-color .2s ease, box-shadow .2s ease;
    }
    .emr-sidebar-search:focus {
        border-color:#C58F59;
        box-shadow:0 0 0 3px rgba(197,143,89,.14);
    }

    .emr-empty-view { text-align:center; padding-top:100px; }
    .emr-empty-view img { width:180px; opacity:0.45; }
    .emr-empty-view h2 { color:#CBD5E0; margin-top:20px; font-size:18px; }

    .emr-loading-view {
        position:absolute;
        top:50%;
        left:50%;
        transform:translate(-50%,-50%);
        display:flex;
        flex-direction:column;
        align-items:center;
    }

    /* ===== MOBILE SIDEBAR TOGGLE ===== */
    .emr-sidebar-toggle-btn { display:none; align-items:center; gap:8px; background:#fff; border:1.5px solid #e5d6c5; border-radius:8px; padding:10px 12px; color:#582c0c; font-weight:700; font-size:13px; cursor:pointer; margin-bottom:12px; width:100%; transition:all 0.2s; }
    .emr-sidebar-toggle-btn:hover { border-color:#C58F59; background:#fdf8f4; }
    .emr-sidebar-backdrop { display:none; position:fixed; inset:0; background:rgba(28,18,6,0.45); backdrop-filter:blur(2px); z-index:1099; }
    .emr-sidebar-backdrop.active { display:block; }

    /* ===== SIDEBAR CARDS ===== */
    .patient-card { background:#fff; border:1px solid #eee; border-radius:8px; padding:8px; display:flex; flex-direction:column; gap:4px; transition:.2s; cursor:pointer; text-decoration:none; }
    .patient-card:hover { border-color:#C58F59; transform:translateY(-2px); }
    .patient-card.active { border-color:#C58F59; background:rgba(197,143,89,.05); border-left:4px solid #C58F59; }
    .p-card-top,.p-card-bottom { display:flex; justify-content:space-between; align-items:center; }
    .p-name { font-weight:700; color:#8e6a45; font-size:12px; }
    .p-date,.p-mr { font-size:10px; color:#888; font-weight:600; }
    .status-badge { font-size:9px; padding:2px 6px; border-radius:6px; color:#fff; font-weight:800; text-transform:uppercase; }

    /* ===== DROPDOWN FILTER ===== */
    .emr-filter-box { position:relative; background:#fff; border:1px solid #e2e8f0; border-radius:8px; padding:8px 12px; cursor:pointer; margin-bottom:10px; }
    .emr-select-trigger { display:flex; justify-content:space-between; align-items:center; font-size:13px; font-weight:700; color:#3b331e; }
    .emr-options { display:none; position:absolute; top:100%; left:0; right:0; background:#fff; border:1px solid #e2e8f0; border-radius:8px; z-index:100; box-shadow:0 4px 12px rgba(0,0,0,.08); }
    .emr-filter-box.open .emr-options { display:block; }
    .emr-option { padding:10px 14px; font-size:13px; font-weight:600; color:#5a3e28; cursor:pointer; }
    .emr-option:hover { background:#fef0e5; }
    .emr-option.is-selected { background:#fef0e5; color:#c58f59; }

    /* ===== PATIENT LIST ===== */
    .emr-patient-list { display:flex; flex-direction:column; gap:8px; overflow-y:auto; max-height:calc(100vh - 280px); padding:5px; }

    /* ===== SPINNER ===== */
    .spinner { border:3px solid #f3f3f3; border-top:3px solid #C58F59; border-radius:50%; width:30px; height:30px; animation:spin 1s linear infinite; margin-bottom:10px; }
    @keyframes spin { 0%{transform:rotate(0deg)} 100%{transform:rotate(360deg)} }

    /* ===== STATUS LEGEND ===== */
    .emr-status-legend { display:flex; flex-wrap:wrap; gap:10px; align-items:center; }
    .emr-status-item { display:flex; align-items:center; gap:5px; font-size:11px; font-weight:600; color:#666; }
    .emr-dot { width:8px; height:8px; border-radius:50%; display:inline-block; }

    .hidden { display:none !important; }


    #js-sidebar-search:-webkit-autofill {
    -webkit-text-fill-color: #582C0C !important;
    -webkit-box-shadow: 0 0 0px 1000px white inset !important;
    }

    #js-sidebar-search::placeholder {
    color: #C58F59;
    opacity: 1;
    }

    /* ===== MOBILE RESPONSIVE (max-width: 768px) ===== */
    @media (max-width: 768px) {
        .emr-container {
            padding: calc(var(--doctor-navbar-offset, 88px) + 8px) 12px 120px !important;
        }

        .emr-layout { flex-direction:column; gap:0; margin-top:8px; }
        .emr-header { margin-bottom: 10px; }
        
        .emr-sidebar { 
            position:fixed; top:var(--doctor-navbar-offset, 88px); left:0; bottom:0; width:280px; max-width:90vw; 
            height: calc(100dvh - var(--doctor-navbar-offset, 88px));
            background:#fff; z-index:1100; padding:16px 12px; box-shadow:4px 0 24px rgba(88,44,12,0.16);
            transform:translateX(-110%); transition:transform 0.3s cubic-bezier(0.4,0,0.2,1);
            overflow-y:auto; flex-shrink:0;
        }

        .emr-sidebar-backdrop {
            top: var(--doctor-navbar-offset, 88px);
        }
        
        .emr-sidebar.drawer-open { transform:translateX(0); }
        
        .emr-sidebar-toggle-btn { display:flex; }
        
        .emr-main { 
            flex:1; min-height:calc(100vh - 140px); border:none; border-radius:0; 
            padding:16px 12px; background:#fcfaf8;
        }

        .emr-patient-list { max-height:calc(100vh - 280px); }
        
        .patient-card { padding:6px; font-size:11px; }
        .p-name { font-size:11px; }
        .p-date, .p-mr { font-size:9px; }
        
        .status-badge { font-size:8px; padding:1px 4px; }
        
        h1 { font-size:20px !important; }
        
        .emr-status-legend { flex-wrap:wrap; gap:6px; }
        .emr-status-item { font-size:10px; }

        .emr-empty-view { padding-top:48px; }
        .emr-empty-view img { width:150px; }
        .emr-empty-view h2 { margin-top:14px; font-size:15px; }
        .emr-loading-view span { font-size:12px; }
    }

</style>
@endpush

@section('content')


<div class="emr-container">
    {{-- HEADER --}}
    <div class="emr-header">
        <div class="emr-title-area">
            <h1 class="emr-title">Electronic Medical Record</h1>
            <p class="emr-subtitle">Pasien saya — {{ optional($doctor)->full_name }}</p>
        </div>
        <div class="emr-status-legend">
            @php $legendColors = ['6B7280'=>'Pending','F59E0B'=>'Confirmed','8B5CF6'=>'Waiting','3B82F6'=>'Engaged','84CC16'=>'Succeed','EF4444'=>'Failed']; @endphp
            @foreach($legendColors as $color => $label)
                <span class="emr-status-item">
                    <span class="emr-dot" style="background:#{{ $color }};"></span> {{ $label }}
                </span>
            @endforeach
        </div>
    </div>

    {{-- MOBILE SIDEBAR BACKDROP --}}
    <div class="emr-sidebar-backdrop" id="emrSidebarBackdrop"></div>

    <div class="emr-layout">
        {{-- ===== SIDEBAR ===== --}}
        <div class="emr-sidebar" id="emrSidebar">
            <button class="emr-sidebar-toggle" id="emrSidebarToggle" type="button">
                <span class="emr-sidebar-toggle-label">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                    Daftar Pasien
                    <span class="emr-sidebar-toggle-count" id="sidebarPatientCount">{{ count($todayPatients ?? []) }}</span>
                </span>
                <svg class="emr-sidebar-toggle-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="6 9 12 15 18 9"/>
                </svg>
            </button>

            <div class="emr-sidebar-body" id="emrSidebarBody">
                <div class="emr-sidebar-header">
                    {{-- Filter dropdown --}}
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

                {{-- Search --}}
                <input type="text" id="js-sidebar-search" class="emr-sidebar-search" placeholder="Cari nama pasien...">
                <div class="emr-patient-list" id="emrPatientList">
                    @php $statusColors = ['pending'=>'#6B7280','confirmed'=>'#F59E0B','waiting'=>'#8B5CF6','engaged'=>'#3B82F6','succeed'=>'#84CC16','failed'=>'#EF4444']; @endphp

                    {{-- TODAY --}}
                    <div id="list-hari-ini" class="js-patient-list-section">
                        @forelse($todayPatients as $apt)
                            <a href="{{ route('doctor.emr.show', $apt->id) }}"
                               class="js-emr-patient-link"
                               data-patient-name="{{ strtolower($apt->patient->full_name ?? '') }}"
                               data-patient-rm="{{ strtolower($apt->patient->medical_record_no ?? '') }}">
                                <div class="patient-card">
                                    <div class="p-card-top">
                                        <span class="p-name">{{ $apt->patient->full_name ?? 'Pasien' }}</span>
                                        <span class="p-date">{{ \Carbon\Carbon::parse($apt->appointment_datetime)->format('H:i') }}</span>
                                    </div>
                                    <div class="p-card-bottom">
                                        <span class="p-mr">{{ $apt->patient->medical_record_no ?? '-' }}</span>
                                        <span class="status-badge" style="background:{{ $statusColors[strtolower($apt->status)] ?? '#888' }}">{{ $apt->status }}</span>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div style="text-align:center; padding:20px; color:#888; font-size:12px;">Tidak ada pasien hari ini</div>
                        @endforelse
                    </div>

                    {{-- SEMUA --}}
                    <div id="list-semua" class="hidden js-patient-list-section">
                        @forelse($allPatients as $apt)
                            <a href="{{ route('doctor.emr.show', $apt->id) }}"
                               class="js-emr-patient-link"
                               data-patient-name="{{ strtolower($apt->patient->full_name ?? '') }}"
                               data-patient-rm="{{ strtolower($apt->patient->medical_record_no ?? '') }}">
                                <div class="patient-card">
                                    <div class="p-card-top">
                                        <span class="p-name">{{ $apt->patient->full_name ?? 'Pasien' }}</span>
                                        <span class="p-date">{{ \Carbon\Carbon::parse($apt->appointment_datetime)->format('d/m/y H:i') }}</span>
                                    </div>
                                    <div class="p-card-bottom">
                                        <span class="p-mr">{{ $apt->patient->medical_record_no ?? '-' }}</span>
                                        <span class="status-badge" style="background:{{ $statusColors[strtolower($apt->status)] ?? '#888' }}">{{ $apt->status }}</span>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div style="text-align:center; padding:20px; color:#888; font-size:12px;">Belum ada pasien</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        {{-- ===== MAIN CONTENT ===== --}}
        <div class="emr-main" id="emrMainContent">
            <button class="emr-sidebar-toggle-btn" id="emrSidebarToggleBtn" aria-label="Daftar Pasien">
                <i class="fa fa-bars"></i> Daftar Pasien
            </button>
            <div id="emr-empty-view" class="emr-empty-view">
                <img src="{{ asset('images/empty-queue.png') }}" alt="Empty queue">
                <h2>Pilih pasien di sebelah kiri</h2>
            </div>
            <div id="emr-loading" class="hidden emr-loading-view">
                <div class="spinner"></div>
                <span style="color:#C58F59; font-weight:600;">Memuat data...</span>
            </div>
            <div id="emr-detail-view" class="hidden"></div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // ── Sidebar Drawer Toggle (tablet/mobile)
    const emrSidebar   = document.getElementById('emrSidebar');
    const emrBackdrop  = document.getElementById('emrSidebarBackdrop');
    const emrToggleBtn = document.getElementById('emrSidebarToggleBtn');

    function openSidebarDrawer() {
        if (!emrSidebar) return;
        emrSidebar.classList.add('drawer-open');
        emrBackdrop?.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeSidebarDrawer() {
        if (!emrSidebar) return;
        emrSidebar.classList.remove('drawer-open');
        emrBackdrop?.classList.remove('active');
        document.body.style.overflow = '';
    }

    emrToggleBtn?.addEventListener('click', openSidebarDrawer);
    emrBackdrop?.addEventListener('click', closeSidebarDrawer);

    // ── Sidebar Collapse Toggle (mobile carousel mode)
    (function initMobileSidebarToggle() {
        const sidebar = document.getElementById('emrSidebar');
        const toggle  = document.getElementById('emrSidebarToggle');
        const patientList = document.getElementById('emrPatientList');
        if (!sidebar || !toggle || !patientList) return;

        const STORAGE_KEY = 'doctor_emr_sidebar_mobile_state';
        const isMobile = () => window.matchMedia('(max-width: 768px)').matches;

        function setExpanded(expanded) {
            sidebar.classList.toggle('expanded', expanded);
            localStorage.setItem(STORAGE_KEY, expanded ? 'expanded' : 'collapsed');
        }

        toggle.addEventListener('click', function (e) {
            e.stopPropagation();
            if (!isMobile()) return;
            const expanded = !sidebar.classList.contains('expanded');
            setExpanded(expanded);
            if (expanded) patientList.scrollLeft = 0;
        });

        document.addEventListener('click', function (e) {
            const patientLink = e.target.closest('.js-emr-patient-link');
            if (!patientLink) return;

            if (window.innerWidth <= 992) {
                closeSidebarDrawer();
            }

            if (isMobile() && sidebar.classList.contains('expanded')) {
                setTimeout(() => setExpanded(false), 500);
            }
        });

        if (isMobile() && localStorage.getItem(STORAGE_KEY) === 'expanded') {
            setExpanded(true);
        }

        window.addEventListener('resize', () => {
            if (!isMobile()) sidebar.classList.remove('expanded');
        });
    })();

    // ── Filter dropdown
    const dropdown = document.getElementById('customFilterDropdown');
    const listHariIni = document.getElementById('list-hari-ini');
    const listSemua   = document.getElementById('list-semua');

    dropdown?.addEventListener('click', e => { e.stopPropagation(); dropdown.classList.toggle('open'); });
    dropdown?.querySelectorAll('.emr-option').forEach(opt => {
        opt.addEventListener('click', function () {
            dropdown.querySelector('.emr-select-text').textContent = this.textContent;
            dropdown.querySelectorAll('.emr-option').forEach(o => o.classList.remove('is-selected'));
            this.classList.add('is-selected');
            if (this.dataset.value === 'hari_ini') {
                listHariIni.classList.remove('hidden'); listSemua.classList.add('hidden');
            } else {
                listHariIni.classList.add('hidden'); listSemua.classList.remove('hidden');
            }

            const countBadge = document.getElementById('sidebarPatientCount');
            const listId = this.dataset.value === 'hari_ini' ? 'list-hari-ini' : 'list-semua';
            const listEl = document.getElementById(listId);
            if (countBadge && listEl) {
                countBadge.textContent = listEl.querySelectorAll('.js-emr-patient-link').length;
            }
        });
    });
    document.addEventListener('click', () => dropdown?.classList.remove('open'));

    // ── Sidebar search
    document.getElementById('js-sidebar-search')?.addEventListener('input', function () {
        const term = this.value.toLowerCase();
        const activeSection = listHariIni.classList.contains('hidden') ? listSemua : listHariIni;
        activeSection.querySelectorAll('.js-emr-patient-link').forEach(link => {
            const name = link.dataset.patientName || '';
            const rm   = link.dataset.patientRm   || '';
            link.style.display = (name.includes(term) || rm.includes(term)) ? 'block' : 'none';
        });
    });

    // ── Patient link handler
    function attachPatientLinkEvents() {
        document.querySelectorAll('.js-emr-patient-link').forEach(link => {
            link.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelectorAll('.js-emr-patient-link .patient-card').forEach(c => c.classList.remove('active'));
                this.querySelector('.patient-card')?.classList.add('active');

                document.getElementById('emr-empty-view').classList.add('hidden');
                document.getElementById('emr-detail-view').classList.add('hidden');
                document.getElementById('emr-loading').classList.remove('hidden');

                fetch(this.href, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                    .then(r => r.text())
                    .then(html => {
                        document.getElementById('emr-loading').classList.add('hidden');
                        document.getElementById('emr-detail-view').classList.remove('hidden');
                        document.getElementById('emr-detail-view').innerHTML = html;
                        if (typeof bindTabEvents === 'function') bindTabEvents();
                        if (typeof setupFABEvents  === 'function') setupFABEvents();
                    })
                    .catch(() => {
                        alert('Gagal memuat data pasien.');
                        document.getElementById('emr-loading').classList.add('hidden');
                    });
            });
        });
    }

    attachPatientLinkEvents();

    // ── Auto-open dari URL / engaged
    const autoOpenId  = @json($autoOpenApptId ?? null);
    const urlOpen     = new URLSearchParams(location.search).get('open');
    const openId      = urlOpen || autoOpenId;

    if (openId) {
        document.getElementById('emr-empty-view').classList.add('hidden');
        document.getElementById('emr-loading').classList.remove('hidden');

        fetch(`/doctor/emr/${openId}`, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(r => { if (!r.ok) throw new Error('Gagal'); return r.text(); })
            .then(html => {
                document.getElementById('emr-loading').classList.add('hidden');
                document.getElementById('emr-detail-view').classList.remove('hidden');
                document.getElementById('emr-detail-view').innerHTML = html;
                if (typeof bindTabEvents === 'function') bindTabEvents();

                const target = document.querySelector(`.js-emr-patient-link[href*="/${openId}"] .patient-card`);
                target?.classList.add('active');
                history.replaceState({}, '', location.pathname);
            })
            .catch(() => {
                document.getElementById('emr-loading').classList.add('hidden');
                document.getElementById('emr-empty-view').classList.remove('hidden');
            });
    }
});

// ── Pagination untuk record tab (dipakai oleh partial)
const RECORD_PAGE_SIZE = 5;
function applyRecordPaginationForPane(pane, forceFirst = false) {
    if (!pane) return;
    const shell = pane.querySelector('.record-table-shell');
    if (!shell) return;
    const rows = Array.from(shell.querySelectorAll('.record-table-row'));
    const totalPages = Math.max(1, Math.ceil(rows.length / RECORD_PAGE_SIZE));
    if (forceFirst) pane.dataset.recordPage = '1';
    let cur = parseInt(pane.dataset.recordPage || '1', 10);
    if (cur < 1) cur = 1; if (cur > totalPages) cur = totalPages;
    pane.dataset.recordPage = String(cur);
    const start = (cur - 1) * RECORD_PAGE_SIZE;
    rows.forEach((r, i) => r.classList.toggle('hidden', !(i >= start && i < start + RECORD_PAGE_SIZE)));
    let pager = pane.querySelector('.record-pagination');
    if (!pager) {
        pager = document.createElement('div');
        pager.className = 'record-pagination';
        Object.assign(pager.style, { display:'flex', justifyContent:'space-between', alignItems:'center', padding:'12px 14px', borderTop:'1px solid #eadfd3' });
        shell.appendChild(pager);
    }
    if (rows.length <= RECORD_PAGE_SIZE) { pager.style.display = 'none'; return; }
    pager.style.display = 'flex';
    pager.innerHTML = `
        <div style="font-size:12px;color:#8e6a45;font-weight:700;">Hal ${cur}/${totalPages} &bull; ${rows.length} data</div>
        <div style="display:flex;gap:8px;">
            <button class="record-page-prev" style="border:1px solid #d8c7b2;background:#fff;color:#6f5635;border-radius:8px;padding:6px 12px;font-size:12px;font-weight:700;cursor:pointer;">Prev</button>
            <button class="record-page-next" style="border:1px solid #d8c7b2;background:#fff;color:#6f5635;border-radius:8px;padding:6px 12px;font-size:12px;font-weight:700;cursor:pointer;">Next</button>
        </div>`;
    const prev = pager.querySelector('.record-page-prev');
    const next = pager.querySelector('.record-page-next');
    prev.disabled = cur <= 1; prev.style.opacity = cur <= 1 ? '.45' : '1';
    next.disabled = cur >= totalPages; next.style.opacity = cur >= totalPages ? '.45' : '1';
    prev.onclick = () => { pane.dataset.recordPage = String(cur - 1); applyRecordPaginationForPane(pane); };
    next.onclick = () => { pane.dataset.recordPage = String(cur + 1); applyRecordPaginationForPane(pane); };
}

function bindTabEvents() {
    document.querySelectorAll('.tab-item').forEach(btn => {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.tab-item').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            document.querySelectorAll('[data-tab-content]').forEach(p =>
                p.classList.toggle('hidden', p.dataset.tabContent !== this.dataset.tab));
        });
    });

    document.querySelectorAll('.record-tab-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.record-tab-btn').forEach(b => {
                b.classList.remove('active');
                b.style.color = '#9ca3af';
                b.style.borderBottomColor = 'transparent';
            });
            this.classList.add('active');
            this.style.color = '#4b5563';
            this.style.borderBottomColor = '#8b5cf6';
            document.querySelectorAll('[data-record-tab-content]').forEach(p =>
                p.classList.toggle('hidden', p.dataset.recordTabContent !== this.dataset.recordTab));
            const active = document.querySelector(`[data-record-tab-content="${this.dataset.recordTab}"]`);
            if (active) applyRecordPaginationForPane(active);
        });
    });

    document.querySelectorAll('[data-record-tab-content]').forEach(p => applyRecordPaginationForPane(p));

    if (typeof initSensitiveInfoToggles === 'function') initSensitiveInfoToggles();
    if (typeof initPatientDetailPhotoInput === 'function') initPatientDetailPhotoInput();

    const statusLabel = document.querySelector('.status-current-text');
    if (statusLabel && typeof filterStatusMenuByCurrent === 'function') {
        filterStatusMenuByCurrent(statusLabel.textContent);
    }
}

// ── Dropdown Diagnosa
function toggleDiagnosaMenu(e) {
    e.preventDefault(); e.stopPropagation();
    document.getElementById('diagnosa-menu')?.classList.toggle('hidden');
}
function filterDiagnosaList() {
    const filter = document.getElementById('diagSearchInput')?.value.toLowerCase() || '';
    document.querySelectorAll('.diagnosa-item').forEach(item => {
        item.style.display = item.textContent.toLowerCase().includes(filter) ? 'block' : 'none';
    });
}

// ── Doctor Note Modal helpers (dipakai oleh partial)
function openDoctorNoteModalFromDetail() {
    const detail = document.querySelector('.p-detail-container');
    if (!detail) return;
    toggleDoctorNoteModal(true, {
        appointmentId: detail.dataset.appointmentId || '',
        patientName:   detail.dataset.patientName   || '-',
        patientRm:     detail.dataset.patientRm     || '-',
        doctorName:    detail.dataset.doctorName    || '-',
        demography:    detail.dataset.patientDemography || '-',
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
            document.getElementById('doctorNotePatientName').textContent  = data.patientName  || '-';
            document.getElementById('doctorNotePatientRm').textContent    = data.patientRm    || '-';
            document.getElementById('doctorNoteDoctorName').textContent   = data.doctorName   || '-';
            document.getElementById('doctorNotePatientDemography').textContent = data.demography || '-';
        }
    } else {
        modal.classList.add('hidden');
        modal.style.display = 'none';
    }
}

function prependDoctorNoteToRecordTab(noteData = {}) {
    const pane = document.querySelector('[data-record-tab-content="catatan-dokter"]');
    const shell = pane?.querySelector('.record-table-shell');
    if (!shell) return;
    shell.querySelector('#doctor-note-empty')?.remove();

    const row = document.createElement('div');
    row.className = 'record-table-row';
    row.style.gridTemplateColumns = '180px 300px 1fr';

    const dateCell = document.createElement('div');
    dateCell.className = 'record-table-text';
    dateCell.style.fontWeight = '600';
    try {
        dateCell.textContent = noteData.created_at
            ? new Date(noteData.created_at).toLocaleDateString('id-ID', { day:'2-digit', month:'long', year:'numeric' })
            : '-';
    } catch { dateCell.textContent = noteData.created_at || '-'; }

    const doctorCell = document.createElement('div');
    doctorCell.className = 'record-table-text';
    doctorCell.style.fontWeight = '700';
    doctorCell.textContent = noteData.doctor_name || '-';

    const noteCell = document.createElement('div');
    noteCell.style.padding = '10px 12px';
    const grid = document.createElement('div');
    grid.style.cssText = 'display:grid;grid-template-columns:150px minmax(0,1fr);gap:6px 12px;align-items:start;';
    [['Subjectives', noteData.subjective], ['Objectives', noteData.objective], ['Plans', noteData.plan]].forEach(([t, v]) => {
        const lbl = document.createElement('div');
        lbl.style.cssText = 'font-size:11px;color:#b08963;font-weight:800;text-transform:uppercase;';
        lbl.textContent = t;
        const val = document.createElement('div');
        val.className = 'record-table-text';
        val.textContent = v || '-';
        grid.appendChild(lbl); grid.appendChild(val);
    });
    noteCell.appendChild(grid);

    row.appendChild(dateCell); row.appendChild(doctorCell); row.appendChild(noteCell);
    const head = shell.querySelector('.record-table-head');
    head ? shell.insertBefore(row, head.nextSibling) : shell.appendChild(row);
    if (pane) applyRecordPaginationForPane(pane, true);
}

async function submitDoctorNote() {
    const regId   = document.getElementById('doctorNoteRegistrationId')?.value;
    const subj    = document.getElementById('doctorNoteSubjective')?.value.trim() || '';
    const obj     = document.getElementById('doctorNoteObjective')?.value.trim()  || '';
    const plan    = document.getElementById('doctorNotePlan')?.value.trim()        || '';
    const saveBtn = document.getElementById('doctorNoteSaveBtn');

    if (!regId) { alert('Data kunjungan tidak ditemukan.'); return; }
    if (!subj && !obj && !plan) { alert('Isi minimal salah satu Subjectives, Objectives, atau Plans.'); return; }

    const orig = saveBtn?.textContent;
    if (saveBtn) { saveBtn.disabled = true; saveBtn.textContent = 'Menyimpan...'; }

    try {
        const res = await fetch(`/doctor/emr/${regId}/doctor-note`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content,
                'Content-Type': 'application/json',
                'Accept':       'application/json',
            },
            body: JSON.stringify({ subjective: subj, objective: obj, plan }),
        });
        const data = await res.json();
        if (!res.ok || !data.success) throw new Error(data.message || 'Gagal');

        document.getElementById('doctorNoteSubjective').value = '';
        document.getElementById('doctorNoteObjective').value  = '';
        document.getElementById('doctorNotePlan').value       = '';
        if (data.data) prependDoctorNoteToRecordTab(data.data);
        toggleDoctorNoteModal(false);
    } catch (err) {
        alert(err.message || 'Terjadi kesalahan.');
    } finally {
        if (saveBtn) { saveBtn.disabled = false; saveBtn.textContent = orig; }
    }
}

// ── Status update helpers (sama dengan admin EMR)
function filterStatusMenuByCurrent(currentStatus) {
    const menu = document.getElementById('status-menu-dynamic');
    if (!menu) return;
    const ordered = ['pending','confirmed','waiting','engaged','succeed'];
    const cur = (currentStatus || '').toLowerCase();
    const curIdx = ordered.indexOf(cur);
    let hasVisible = false;
    menu.querySelectorAll('[data-status-option]').forEach(el => {
        const st = (el.dataset.statusOption || '').toLowerCase();
        let allowed = false;
        if (cur === 'succeed') { allowed = st === 'failed'; }
        else if (cur !== 'failed') {
            if (st === 'failed') { allowed = true; }
            else { const i = ordered.indexOf(st); allowed = curIdx === -1 ? i >= 0 : i > curIdx; }
        }
        const li = el.closest('li');
        if (li) li.style.display = allowed ? 'block' : 'none';
        if (allowed) hasVisible = true;
    });
    const noOpt = document.getElementById('status-no-option');
    if (noOpt) noOpt.style.display = hasVisible ? 'none' : 'block';
}

async function processUpdateStatus(url, newStatus) {
    if ((newStatus||'').toLowerCase() === 'failed') {
        if (!confirm('Yakin ingin mengubah status menjadi FAILED?')) return;
    }
    document.getElementById('status-menu-dynamic')?.classList.add('hidden');
    try {
        const res = await fetch(url, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content,
                'Accept': 'application/json', 'Content-Type': 'application/json',
            },
            body: JSON.stringify({ status: newStatus }),
        });
        const data = await res.json();
        if (!res.ok || !data.success) throw new Error(data.message || 'Gagal');

        const colors = { pending:'#6B7280',confirmed:'#F59E0B',waiting:'#8B5CF6',engaged:'#3B82F6',succeed:'#84CC16',failed:'#EF4444' };

        const statusText = document.querySelector('.status-current-text');
        if (statusText) statusText.innerText = newStatus.toUpperCase();

        const tog = document.querySelector('.btn-status-toggle');
        if (tog && colors[newStatus]) tog.style.backgroundColor = colors[newStatus];

        const activeBadge = document.querySelector('.patient-card.active .status-badge');
        if (activeBadge) {
        activeBadge.innerText = newStatus.toUpperCase();
        activeBadge.style.backgroundColor = colors[newStatus];
    }

filterStatusMenuByCurrent(newStatus);

// Update tombol TAMBAH DIAGNOSA (enable/disable sesuai status baru)
const tambahBtn = document.querySelector('.btn-primary-blue');
if (tambahBtn) {
    if (newStatus === 'engaged') {
        tambahBtn.disabled = false;
    } else {
        tambahBtn.disabled = true;
    }
}

        // Toast
        const toast = document.createElement('div');
        toast.style.cssText = 'position:fixed;top:40px;left:50%;transform:translateX(-50%);background:#10b981;color:#fff;padding:12px 32px;border-radius:10px;box-shadow:0 8px 24px rgba(0,0,0,.2);z-index:99999;font-weight:700;font-size:14px;';
        toast.textContent = `Status diubah ke ${newStatus.toUpperCase()}`;
        document.body.appendChild(toast);
        setTimeout(() => { toast.style.opacity = '0'; toast.style.transition = 'opacity .4s'; setTimeout(() => toast.remove(), 400); }, 3000);
    } catch (err) {
        alert(err.message || 'Gagal mengubah status.');
    }
}

// expose globals untuk partial
window.openDoctorNoteModalFromDetail = openDoctorNoteModalFromDetail;
window.toggleDoctorNoteModal         = toggleDoctorNoteModal;
window.submitDoctorNote              = submitDoctorNote;
window.bindTabEvents                 = bindTabEvents;
window.toggleDiagnosaMenu            = toggleDiagnosaMenu;
window.filterDiagnosaList            = filterDiagnosaList;
window.processUpdateStatus           = processUpdateStatus;
window.filterStatusMenuByCurrent     = filterStatusMenuByCurrent;
window.applyRecordPaginationForPane  = applyRecordPaginationForPane;

// Sensitive info toggles (reusable dari admin)
function initSensitiveInfoToggles() {
    document.querySelectorAll('.js-sensitive-toggle').forEach(icon => {
        if (icon.dataset.bound === '1') return;
        icon.dataset.bound = '1';
        icon.addEventListener('click', function () {
            const target = document.getElementById(icon.dataset.sensitiveTarget);
            if (!target) return;
            const original  = target.dataset.sensitiveOriginal || '-';
            const isVisible = target.dataset.sensitiveVisible === '1';
            if (isVisible) {
                target.textContent = original === '-' ? '-' : '••••••••';
                target.dataset.sensitiveVisible = '0';
                icon.classList.replace('fa-eye','fa-eye-slash');
                icon.classList.remove('is-active');
            } else {
                target.textContent = original;
                target.dataset.sensitiveVisible = '1';
                icon.classList.replace('fa-eye-slash','fa-eye');
                icon.classList.add('is-active');
            }
        });
    });
}
window.initSensitiveInfoToggles = initSensitiveInfoToggles;
</script>
@endsection

@include('admin.components.emr.modal-doctor-note')
@include('admin.components.emr.modal-odontogram')
@include('admin.components.emr.modal-prosedure')