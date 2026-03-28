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

                <div class="emr-queue-alert">
                    Tidak ada antrean pasien
                </div>
            </div>

            <div class="emr-main">
                <!-- Info Pasien Asli -->
                @if(isset($registration) && isset($patient))
                <div class="emr-patient-info" style="display:flex;align-items:center;gap:24px;margin-bottom:18px;">
                    <div style="width:80px;height:80px;background:#f3f3f3;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                        <svg width="48" height="48" fill="#bbb"><circle cx="24" cy="20" r="16"/><ellipse cx="24" cy="44" rx="18" ry="10"/></svg>
                    </div>
                    <div>
                        <div style="font-size:20px;font-weight:700;">{{ $patient->name ?? '-' }}</div>
                        <div style="color:#888;">No. RM: {{ $patient->medical_record_number ?? '-' }} | {{ $patient->gender ?? '-' }} | {{ $patient->age ?? '-' }} Tahun</div>
                        <div style="color:#888;">Alamat: {{ $patient->address ?? '-' }}</div>
                    </div>
                </div>
                @endif
                <!-- Tab -->
                <div class="emr-tab-bar" style="display:flex;align-items:center;gap:32px;margin-bottom:8px;">
                    <button class="emr-tab-btn emr-tab-active" id="tabTimeline" style="background:none;border:none;font-weight:700;font-size:16px;color:#C58F59;border-bottom:2px solid #C58F59;padding:8px 0;cursor:pointer;">TIMELINE</button>
                    <button class="emr-tab-btn" id="tabRecord" style="background:none;border:none;font-weight:700;font-size:16px;color:#888;padding:8px 0;cursor:pointer;">RECORD</button>
                    <button class="emr-tab-btn" id="tabCppt" style="background:none;border:none;font-weight:700;font-size:16px;color:#888;padding:8px 0;cursor:pointer;">CPPT</button>
                </div>
                <!-- Info Registrasi di Timeline -->
                @if(isset($registration))
                <div class="emr-info-registrasi" style="margin-top:24px;padding:18px 24px;background:#fff;border-radius:10px;border:1px solid #eee;max-width:520px;margin-left:auto;margin-right:auto;">
                    <div style="font-weight:700;margin-bottom:8px;">INFORMASI REGISTRASI</div>
                    <div><b>ID Registrasi:</b> {{ $registration->id ?? '-' }}</div>
                    <div><b>Tanggal Registrasi:</b> {{ $registration->created_at ?? '-' }}</div>
                    <div><b>Poli:</b> {{ $registration->poli_name ?? '-' }}</div>
                    <div><b>Dokter:</b> {{ $registration->doctor_name ?? '-' }}</div>
                    <div><b>Jenis Kunjungan:</b> {{ $registration->visit_type ?? '-' }}</div>
                    <div><b>Jenis Penjamin:</b> {{ $registration->guarantor_type ?? '-' }}</div>
                    <div><b>Metode Pembayaran:</b> {{ $registration->payment_method ?? '-' }}</div>
                    <div><b>Keluhan:</b> {{ $registration->complaint ?? '-' }}</div>
                    <div><b>Rencana Tindakan:</b> {{ $registration->plan ?? '-' }}</div>
                </div>
                @else
                <div class="emr-empty-state" style="margin-top:24px;">
                    <h2 class="emr-empty-title">Tidak ada antrean pasien hari ini</h2>
                    <p class="emr-empty-desc">Gunakan search bar atau advance search pada pojok kiri atas untuk mencari pasien.</p>
                </div>
                @endif
            </div>
        </div>

<<<<<<< HEAD
<<<<<<< Updated upstream
=======

>>>>>>> Stashed changes
=======
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

>>>>>>> origin/main
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
    </script>
@endsection


@include('admin.components.emr.modal-odontogram')
@include('admin.components.emr.modal-prosedure')
