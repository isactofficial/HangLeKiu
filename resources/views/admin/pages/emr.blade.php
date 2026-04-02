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
                    
                </div>

                <div class="emr-patient-list" id="emrPatientList">
                    @php $statusColors = ['pending'=>'#EF4444','confirmed'=>'#F59E0B','waiting'=>'#8B5CF6','engaged'=>'#3B82F6','succeed'=>'#84CC16']; @endphp

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
            const urlParams = new URLSearchParams(window.location.search);
            const openApptId = urlParams.get('open'); // Menangkap ID dari URL ?open=123

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
            }
        });

        // ================= 3. FUNGSI GLOBAL (DIPANGGIL SETELAH AJAX) =================
        function bindTabEvents() {
            document.querySelectorAll('.tab-item').forEach(btn => {
                btn.addEventListener('click', function() {
                    document.querySelectorAll('.tab-item').forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
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

            const modal = document.getElementById('modalOdontogramOverlay');
            if(modal) {
                modal.classList.remove('hidden');
            } else {
                console.error("Modal Odontogram tidak ditemukan di halaman ini.");
            }
        }
async function processUpdateStatus(url, newStatus) {
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
                const colors = {'pending':'#EF4444','confirmed':'#F59E0B','waiting':'#8B5CF6','engaged':'#3B82F6','succeed':'#84CC16'};
                activeCardStatus.style.backgroundColor = colors[newStatus];
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

            // 4. Update tampilan tombol secara realtime (Warna & Teks)
            const currentLabel = document.querySelector('.status-current-text');
            const btnToggle = document.querySelector('.btn-status-toggle');
            
            if (currentLabel) currentLabel.innerText = newStatus.toUpperCase();
            
            // Sinkronkan warna tombol sesuai status baru
            const statusColors = {
                'pending': '#EF4444', 'confirmed': '#F59E0B', 'waiting': '#8B5CF6', 
                'engaged': '#3B82F6', 'succeed': '#84CC16'
            };
            if (btnToggle && statusColors[newStatus]) {
                btnToggle.style.backgroundColor = statusColors[newStatus];
            }

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