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
            gap: 25px; 
            align-items: flex-start; 
            width: 100%; 
            margin-top: 20px;
        }

        .emr-sidebar { 
            width: 320px; 
            flex-shrink: 0; 
        }

        .emr-main { 
            flex: 1; /* Ini agar konten tengah memenuhi sisa layar */
            background-color: #fff; 
            border: 1px solid #eef2f7; 
            border-radius: 15px; 
            padding: 25px; 
            position: relative; 
            min-height: 80vh; 
        }

        /* ================= 2. SKALA FOTO PROFIL (30 > 18.75 > 12) ================= */
        /* CSS ini ditaruh di sini agar partial yang di-inject AJAX otomatis mengikuti */
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
            width: 100%; padding: 10px 15px; border: 1px solid #e2e8f0; 
            border-radius: 10px; font-size: 12px; outline: none; transition: 0.2s; 
        }
        .emr-sidebar-search-input:focus { border-color: #C58F59; }

        .emr-patient-list { display: flex; flex-direction: column; gap: 10px; overflow-y: auto; max-height: calc(100vh - 280px); padding: 5px; }
        
        .patient-card {
            background: #fff; border: 1px solid #eee; border-radius: 12px; padding: 14px;
            display: flex; flex-direction: column; gap: 6px; transition: 0.2s; cursor: pointer;
            text-decoration: none;
        }
        .patient-card:hover { border-color: #C58F59; transform: translateY(-2px); }
        .patient-card.active { border-color: #C58F59; background-color: rgba(197, 143, 89, 0.05); border-left: 4px solid #C58F59; }
        
        .p-card-top, .p-card-bottom { display: flex; justify-content: space-between; align-items: center; }
        .p-name { font-weight: 700; color: #333; font-size: 12px; }
        .p-date { font-size: 12px; color: #888; }
        .status-badge { font-size: 9px; padding: 2px 8px; border-radius: 20px; color: white; font-weight: 800; text-transform: uppercase; }

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
                @php $legendColors = ['EF4444'=>'Pending', 'F59E0B'=>'Confirmed', '8B5CF6'=>'Waiting', '3B82F6'=>'Engaged', '84CC16'=>'Succeed']; @endphp
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
                    <input type="text" id="js-sidebar-search" placeholder="Cari nama pasien atau No RM..." class="emr-sidebar-search-input">
                </div>

                <div class="emr-patient-list" id="emrPatientList">
                    @php $statusColors = ['pending'=>'#EF4444','confirmed'=>'#F59E0B','waiting'=>'#8B5CF6','engaged'=>'#3B82F6','succeed'=>'#84CC16']; @endphp

                    <div id="list-hari-ini" class="js-patient-list-section">
                        @forelse($todayPatients as $apt)
                            <a href="{{ route('admin.emr.show', $apt->id) }}" class="js-emr-patient-link">
                                <div class="patient-card">
                                    <div class="p-card-top">
                                        <span class="p-name">{{ $apt->patient->full_name }}</span>
                                        <span class="p-date">{{ \Carbon\Carbon::parse($apt->appointment_datetime)->format('H:i') }}</span>
                                    </div>
                                    <div class="p-card-bottom">
                                        <span class="p-mr">{{ $apt->patient->medical_record_no }}</span>
                                        <span class="status-badge" style="background-color: {{ $statusColors[strtolower($apt->status)] ?? '#888' }}">{{ $apt->status }}</span>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="emr-queue-alert">Tidak ada antrean hari ini</div>
                        @endforelse
                    </div>

                    <div id="list-semua" class="hidden js-patient-list-section">
                        @foreach($allPatients as $apt)
                            <a href="{{ route('admin.emr.show', $apt->id) }}" class="js-emr-patient-link">
                                <div class="patient-card">
                                    <div class="p-card-top">
                                        <span class="p-name">{{ $apt->patient->full_name }}</span>
                                        <span class="p-date">{{ \Carbon\Carbon::parse($apt->appointment_datetime)->format('d/m/y H:i') }}</span>
                                    </div>
                                    <div class="p-card-bottom">
                                        <span class="p-mr">{{ $apt->patient->medical_record_no }}</span>
                                        <span class="status-badge" style="background-color: {{ $statusColors[strtolower($apt->status)] ?? '#888' }}">{{ $apt->status }}</span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
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

                {{-- View Detail Dinamis --}}
                <div id="emr-detail-view" class="hidden"></div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dropdown = document.getElementById('customFilterDropdown');
            const listHariIni = document.getElementById('list-hari-ini');
            const listSemua = document.getElementById('list-semua');

            // --- 1. DROPDOWN FILTER ---
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

            // --- 2. SEARCH SIDEBAR ---
            document.getElementById('js-sidebar-search').addEventListener('input', function(e) {
                const term = e.target.value.toLowerCase();
                const activeSection = listHariIni.classList.contains('hidden') ? listSemua : listHariIni;
                activeSection.querySelectorAll('.js-emr-patient-link').forEach(link => {
                    link.style.display = link.textContent.toLowerCase().includes(term) ? "block" : "none";
                });
            });

            // --- 3. AJAX LOADER ---
            const patientLinks = document.querySelectorAll('.js-emr-patient-link');
            patientLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    patientLinks.forEach(l => l.querySelector('.patient-card').classList.remove('active'));
                    this.querySelector('.patient-card').classList.add('active');

                    document.getElementById('emr-empty-view').classList.add('hidden');
                    document.getElementById('emr-detail-view').classList.add('hidden');
                    document.getElementById('emr-loading').classList.remove('hidden');

                    fetch(this.href, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                        .then(res => res.text())
                        .then(html => {
                            document.getElementById('emr-loading').classList.add('hidden');
                            document.getElementById('emr-detail-view').classList.remove('hidden');
                            document.getElementById('emr-detail-view').innerHTML = html;
                            bindTabEvents();
                        });
                });
            });

            window.addEventListener('click', () => dropdown.classList.remove('open'));
        });

        // --- FUNGSI GLOBAL ---
        function bindTabEvents() {
            document.querySelectorAll('.tab-item').forEach(btn => {
                btn.addEventListener('click', function() {
                    document.querySelectorAll('.tab-item').forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                });
            });
        }

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

        window.addEventListener('click', () => {
            const diagMenu = document.getElementById('diagnosa-menu');
            if(diagMenu) diagMenu.classList.add('hidden');
        });
    </script>
@endsection

@include('admin.components.emr.modal-odontogram')
@include('admin.components.emr.modal-prosedure')