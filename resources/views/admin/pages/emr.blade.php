@extends('admin.layout.admin')
@section('title', 'Electronic Medical Record')

@section('navbar')
    @include('admin.components.navbarSearch', ['title' => 'Electronic Medical Record'])
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/pages/emr.css') }}">
@endpush

@section('content')
    <div class="emr-container">

        <div class="emr-header">
            <div class="emr-title-area">
                <h1 class="emr-title">Electronic Medical Record</h1>
                <p class="emr-subtitle">hanglekiu dental specialist</p>
            </div>

            <div class="emr-status-legend">
                <span class="emr-status-item"><span class="emr-dot" style="background-color: #EF4444;"></span> Pending</span>
                <span class="emr-status-item"><span class="emr-dot" style="background-color: #F59E0B;"></span> Confirmed</span>
                <span class="emr-status-item"><span class="emr-dot" style="background-color: #8B5CF6;"></span> Waiting</span>
                <span class="emr-status-item"><span class="emr-dot" style="background-color: #3B82F6;"></span> Engaged</span>
                <span class="emr-status-item"><span class="emr-dot" style="background-color: #84CC16;"></span> Succeed</span>
            </div>

            <div class="emr-header-actions">
                <button class="emr-icon-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" class="emr-action-icon" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18.25 7.034V3.375" /></svg>
                </button>
                <button class="emr-icon-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" class="emr-action-icon" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182M21.015 4.353v4.992" /></svg>
                </button>
            </div>
        </div>

        <div class="emr-layout">
            <div class="emr-sidebar">

                <div class="emr-filter-box" id="customFilterDropdown">
                    <div class="emr-select-trigger">
                        <span class="emr-select-text">Hari Ini</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="emr-select-icon" viewBox="0 0 24 24" fill="none" stroke="#C58F59" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                    </div>

                    <div class="emr-options">
                        <div class="emr-option is-selected" data-value="hari_ini">Hari Ini</div>
                        <div class="emr-option" data-value="semua">Semua</div>
                    </div>

                    <input type="hidden" name="filter_waktu" id="filterWaktuVal" value="hari_ini">
                </div>

                @if(isset($appointments) && $appointments->count() > 0)
                    <div class="emr-queue-list mt-4 px-3 space-y-2 overflow-y-auto pb-6" style="max-height: calc(100vh - 150px);">
                        @foreach($appointments as $apt)
                            @if($apt->patient)
                                <!-- Item Antrean -->
                                <div class="bg-white rounded-xl p-4 shadow-sm relative emr-queue-item cursor-pointer border border-transparent hover:border-gray-200 transition-colors"
                                    onclick="selectPatientForTesting(
                                        {{ json_encode($apt->patient) }},
                                        '{{ $apt->guarantorType->guarantor_type_name ?? '-' }}',
                                        '{{ $apt->id }}',
                                        '{{ $apt->doctor->full_name ?? '-' }}',
                                        '{{ $apt->doctor_id ?? '' }}',
                                        event
                                    )">
                                    <div class="font-bold text-gray-800">{{ $apt->patient->full_name }}</div>
                                    <div class="text-xs text-gray-400 mt-1 flex justify-between">
                                        <span>{{ $apt->poli ? $apt->poli->name : 'Pemeriksaan' }}</span>
                                        <span>{{ \Carbon\Carbon::parse($apt->appointment_datetime)->format('H:i') }}</span>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @else
                    <div class="emr-queue-alert">
                        Tidak ada antrean pasien
                    </div>
                @endif
            </div>

            <div class="emr-main">
                <div class="emr-empty-state">
                    <img src="{{ asset('../images/empty-queue.png') }}" alt="Tidak ada antrean" class="emr-empty-img">
                    <h2 class="emr-empty-title">Tidak ada antrean pasien hari ini</h2>
                    <p class="emr-empty-desc">Gunakan search bar atau advance search pada pojok kiri atas untuk mencari pasien.</p>
                </div>
            </div>
        </div>

        <div class="emr-fab-container" id="fabContainer">
        <!-- Menu Popup -->
        <div class="emr-fab-menu" id="fabMenu">
            <div class="emr-fab-search-box">
                <input type="text" id="fabSearchInput" placeholder="Cari fitur" class="emr-fab-search-input">
            </div>
            <ul class="emr-fab-list" id="fabList">
                <li><a href="#" class="emr-fab-item" onclick="toggleProsedureModal(true)">Tambah Prosedur</a></li>
                <li><a href="#" class="emr-fab-item">Tambah Catatan Organ</a></li>
                <li><a href="#" class="emr-fab-item">Tambah Catatan Dokter</a></li>
                <li><a href="#" class="emr-fab-item" onclick="toggleOdontogramModal(true)">Tambah Odontogram</a></li>
                <li><a href="#" class="emr-fab-item">Tambah Asuhan Keperawatan</a></li>
                <li><a href="#" class="emr-fab-item">Tambah Obgyn</a></li>
                <li><a href="#" class="emr-fab-item">Tambah Catatan Obstetri</a></li>
                <li><a href="#" class="emr-fab-item">Tambah Catatan KB</a></li>
                <li><a href="#" class="emr-fab-item">Tambah Rekam Medis Tubuh</a></li>
                <li><a href="#" class="emr-fab-item">Tambah Catatan Awal Kehamilan</a></li>
            </ul>
        </div>
        <!-- Tombol Utama Biru -->
        <button class="emr-fab-btn" id="fabBtn">📄</button>
</div>
<!-- END: Floating Action Button -->

    </div>


{{-- SCRIPT CUSTOM DROPDOWN --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dropdown = document.getElementById('customFilterDropdown');
            const trigger = dropdown.querySelector('.emr-select-trigger');
            const options = dropdown.querySelectorAll('.emr-option');
            const textDisplay = dropdown.querySelector('.emr-select-text');
            const hiddenInput = document.getElementById('filterWaktuVal');

            trigger.addEventListener('click', function(e) {
                e.stopPropagation();
                dropdown.classList.toggle('open');
            });

            options.forEach(option => {
                option.addEventListener('click', function() {
                    options.forEach(opt => opt.classList.remove('is-selected'));

                    this.classList.add('is-selected');

                    textDisplay.textContent = this.textContent;
                    hiddenInput.value = this.dataset.value;

                    dropdown.classList.remove('open');
                });
            });

            window.addEventListener('click', function(e) {
                if (!dropdown.contains(e.target)) {
                    dropdown.classList.remove('open');
                }
            });
        });

        // --- SCRIPT FLOATING ACTION BUTTON ---
const fabBtn = document.getElementById('fabBtn');
const fabMenu = document.getElementById('fabMenu');
const fabSearchInput = document.getElementById('fabSearchInput');
const fabListItems = document.querySelectorAll('.emr-fab-item');

// Toggle menu saat FAB diklik
fabBtn.addEventListener('click', function(e) {
    e.stopPropagation(); // Mencegah event merambat ke window
    fabMenu.classList.toggle('active');

    // Auto-focus ke input pencarian jika menu dibuka
    if(fabMenu.classList.contains('active')) {
        setTimeout(() => fabSearchInput.focus(), 100);
    }
});

// Tutup menu jika klik di luar elemen FAB
window.addEventListener('click', function(e) {
    const fabContainer = document.getElementById('fabContainer');
    if (!fabContainer.contains(e.target)) {
        fabMenu.classList.remove('active');
    }
});

// Fitur Pencarian Realtime
fabSearchInput.addEventListener('input', function(e) {
    const filterText = e.target.value.toLowerCase();

    fabListItems.forEach(item => {
        const text = item.textContent.toLowerCase();
        // Sembunyikan item yang tidak cocok dengan kata kunci
        if (text.includes(filterText)) {
            item.parentElement.style.display = 'block';
        } else {
            item.parentElement.style.display = 'none';
        }
    });
});

// Fungsi untuk membuka Modal Odontogram dari Menu FAB
function openModalOdontogram(e) {
    e.preventDefault(); // Mencegah scroll ke atas karena tag <a>
    fabMenu.classList.remove('active'); // Tutup menu FAB

    // Pastikan di file modal-odontogram.blade.php yang dibuat sebelumnya,
    // div pembungkus overlay modalnya memiliki id="modalOdontogramOverlay" (atau sesuaikan)
    const modal = document.getElementById('modalOdontogramOverlay');
    if(modal) {
        modal.classList.remove('hidden'); // Atau sesuaikan dengan class CSS Anda untuk menampilkan modal
    } else {
        console.error("Modal Odontogram tidak ditemukan.");
    }
}

// ==========================================
// FUNGSI GANTI PASIEN (UNTUK TESTING)
// ==========================================
function selectPatientForTesting(patient, guarantor, visitId, doctorName, doctorId, event) {
    if(!patient || !patient.id) return;
    
    // Reset Form Prosedur
    if (typeof resetProsedurForm === 'function') resetProsedurForm();

    // Fetch riwayat Odontogram pasien untuk fitur Autocomplete No. Gigi di Prosedur
    window.currentPatientTeeth = [];
    fetch(`/api/odontogram/patient/${patient.id}`)
        .then(r => r.json())
        .then(res => {
            if (res.status === 'success' && res.data) {
                let tMap = new Map();
                res.data.forEach(rec => {
                    (rec.teeth || []).forEach(t => {
                        if (!tMap.has(t.tooth_number)) {
                            tMap.set(t.tooth_number, t);
                        }
                    });
                });
                window.currentPatientTeeth = Array.from(tMap.values());
            }
        }).catch(err => console.error(err));

    // Inject ID ke hidden input Odontogram (atau modal lain jika butuh ID parent)
    const odontoIdInput = document.getElementById('odontogramPatientId');
    if (odontoIdInput) odontoIdInput.value = patient.id;

    const odontoVisitInput = document.getElementById('odontogramVisitId');
    if (odontoVisitInput) odontoVisitInput.value = visitId;
    
    const odontoDoctorInput = document.getElementById('odontogramExaminedBy');
    if (odontoDoctorInput) odontoDoctorInput.value = doctorName;

    // UPDATE Tampilan Tanggal & Pasien di Odontogram
    const odontoDateDisplay = document.getElementById('odonto-date-display');
    const odontoName = document.getElementById('odonto-patient-name');
    const odontoPayment = document.getElementById('odonto-patient-payment');
    const odontoMr = document.getElementById('odonto-patient-mr');
    const odontoDemographics = document.getElementById('odonto-patient-demographics');

    if (odontoDateDisplay) {
        const todayUrl = new Date();
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        odontoDateDisplay.innerText = todayUrl.toLocaleDateString('id-ID', options);
    }
    
    if (odontoName) odontoName.innerText = patient.full_name || 'Tanpa Nama';
    if (odontoPayment) odontoPayment.innerText = guarantor || '-';
    if (odontoMr) odontoMr.innerText = patient.medical_record_number || 'Tidak Ada MR';

    if (odontoDemographics) {
        let genderStr = patient.gender === 'female' || patient.gender === 'P' ? 'Perempuan' : 'Laki-laki';
        
        // hitung umur kasar
        let ageStr = '-';
        if(patient.date_of_birth) {
            const dob = new Date(patient.date_of_birth);
            const ageDifMs = Date.now() - dob.getTime();
            const ageDate = new Date(ageDifMs); 
            const calcAge = Math.abs(ageDate.getUTCFullYear() - 1970);
            ageStr = calcAge + ' Tahun';
        }
        odontoDemographics.innerHTML = `&middot; ${genderStr} &middot; ${ageStr}`;

        // == UPDATE PULA KE HEADER MODAL PROSEDUR ==
        const prosDateDisplay = document.getElementById('prosedur-date-display');
        const prosName = document.getElementById('prosedur-patient-name');
        const prosPayment = document.getElementById('prosedur-patient-payment');
        const prosDemographics = document.getElementById('prosedur-patient-demographics');
        
        const prosPatientId = document.getElementById('prosedur-patient-id');
        const prosRegistrationId = document.getElementById('prosedur-registration-id');
        const prosDoctorSelect = document.getElementById('prosedur-doctor-select');

        if (prosDateDisplay && odontoDateDisplay) prosDateDisplay.innerText = odontoDateDisplay.innerText;
        if (prosName) prosName.innerText = patient.full_name || 'Tanpa Nama';
        if (prosPayment) prosPayment.innerText = guarantor || '-';
        if (prosDemographics) {
            prosDemographics.innerHTML = `${patient.medical_record_number || '-'} &middot; ${genderStr} &middot; ${ageStr}`;
        }
        
        if (prosPatientId) prosPatientId.value = patient.id;
        if (prosRegistrationId) prosRegistrationId.value = visitId;
        if (prosDoctorSelect && doctorId) {
            prosDoctorSelect.value = doctorId;
        }
    }

    // Ubah Teks Header EMR
    const titleArea = document.querySelector('.emr-title-area');
    if (titleArea) {
        titleArea.innerHTML = `
            <h1 class="emr-title text-brown-600" style="color: #6C4A3A;">${patient.full_name}</h1>
            <p class="emr-subtitle">MR: ${patient.medical_record_number || '-'} | ID: ${patient.id}</p>
        `;
    }

    // Ubah Ilustrasi Kosong di Tengah
    const mainArea = document.querySelector('.emr-empty-state');
    if (mainArea) {
        mainArea.innerHTML = `
            <div class="text-center mt-10">
                <h2 class="text-2xl font-bold text-brown-600 mb-2">Pasien Terpilih</h2>
                <h3 class="text-xl text-gray-800 mb-6">${patient.full_name}</h3>
                <p class="text-gray-500 max-w-md mx-auto">Untuk memulai, silakan tekan tombol <strong>[ 📄 ]</strong> di sudut kanan bawah dan buka <strong>Tambah Odontogram</strong>.</p>
            </div>
        `;
    }

    // Highlight card yang diklik
    document.querySelectorAll('.emr-queue-list > div').forEach(el => {
        el.style.border = "1px solid #e5e7eb";
        el.style.backgroundColor = "#fff";
    });
    if(event && event.currentTarget) {
        event.currentTarget.style.border = "2px solid #C58F59";
        event.currentTarget.style.backgroundColor = "#FDF8F3";
    }

    // [AUTO CLEAR] Reset riwayat coretan Odontogram karena pasien telah berganti
    if (typeof clearOdontogramState === 'function') {
        clearOdontogramState();
    }
}
    </script>
@endsection


@include('admin.components.emr.modal-odontogram')
@include('admin.components.emr.modal-prosedure')
