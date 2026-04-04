@extends('admin.layout.admin')
@section('title', 'Registration')

@section('navbar')
    @include('admin.components.navbarPendaftaranBaru', ['title' => 'Registration'])
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/pages/registration.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/pages/registration-shared.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/pages/pasien-baru.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/pages/pendaftaran-baru.css') }}">
@endpush

@section('content')
<div class="reg-container">
    {{-- Page Header --}}
    <div class="reg-header">
        <div class="reg-title-area">
            <h1 class="reg-title">Registration</h1>
            <p class="reg-subtitle">hanglekiu dental specialist</p>
        </div>
    </div>

    <div class="reg-layout">

        {{-- Konten Utama Kanan --}}
        <div class="reg-main">
            <div class="reg-card">
                
                <div class="reg-card-header">
                    <h2 class="reg-card-title">
                        Rawat Jalan Poli <i class="fas fa-desktop" style="color: #C58F59; margin-left: 8px;"></i>
                    </h2>

                </div>

                {{-- Filter Pencarian --}}
                <div class="reg-filters">
                    <div class="reg-filter-row">
                        <div class="reg-input-group" style="flex: 1;">
                            {{-- Tambahkan for="filter_date" agar label hanya fokus ke input --}}
                            <label for="filter_date">Tanggal Kunjungan</label>
                            
                            {{-- Gunakan display: flex agar kotak dan tombol sejajar rapi & tidak tumpang tindih --}}
                            <div class="reg-date-wrapper" style="display: flex; align-items: center; gap: 10px;">
                                
                                <input type="date" id="filter_date" class="reg-input" value="{{ request('date') }}" onchange="applyFilter()" style="flex: 1; cursor: pointer;">

                                {{-- Tambahkan event.stopPropagation() dan z-index --}}
                                <button type="button" onclick="event.stopPropagation(); clearDateFilter();" title="Hapus Tanggal" 
                                    style="
                                        color: #C58F59; /* Coklat tua ikon HDS */
                                        background-color: transparent;
                                        border: 1px solid #C58F59;
                                        border-radius: 4px;
                                        width: 35px;
                                        height: 35px;
                                        display: flex;
                                        align-items: center;
                                        justify-content: center;
                                        cursor: pointer;
                                        position: relative;
                                        z-index: 10; /* Memastikan tombol berada di lapisan paling atas */
                                    ">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="reg-input-group" style="flex: 1.5;">
                            <label>Poli *</label>
                            <div class="reg-custom-select">
                                <div class="reg-select-trigger">
                                    @php
                                        $selectedPoliName = 'Semua Poli';
                                        if(request('filter_poli') && request('filter_poli') !== 'semua') {
                                            $selectedPoli = $polis->firstWhere('id', request('filter_poli'));
                                            if($selectedPoli) $selectedPoliName = $selectedPoli->name;
                                        }
                                    @endphp
                                    <span class="reg-select-text">{{ $selectedPoliName }}</span>
                                    <svg class="reg-select-icon" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#C58F59" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                                </div>
                                <div class="reg-options">
                                    <div class="reg-option {{ request('filter_poli', 'semua') === 'semua' ? 'is-selected' : '' }}" data-value="semua">Semua Poli</div>
                                    @foreach($polis as $p)
                                        <div class="reg-option {{ request('filter_poli') == $p->id ? 'is-selected' : '' }}" data-value="{{ $p->id }}">{{ $p->name }}</div>
                                    @endforeach
                                </div>
                                <input type="hidden" id="filter_poli" value="{{ request('filter_poli', 'semua') }}">
                            </div>
                        </div>
                    </div>

                    <div class="reg-filter-row">
                        <div class="reg-input-group">
                            <label>Tenaga Medis *</label>
                            <div class="reg-custom-select">
                                <div class="reg-select-trigger">
                                    @php
                                        $selectedDoctorName = 'Semua Tenaga Medis';
                                        if(request('filter_dokter') && request('filter_dokter') !== 'semua') {
                                            $selectedDoctor = $doctors->firstWhere('id', request('filter_dokter'));
                                            if($selectedDoctor) $selectedDoctorName = $selectedDoctor->full_name;
                                        }
                                    @endphp
                                    <span class="reg-select-text">{{ $selectedDoctorName }}</span>
                                    <svg class="reg-select-icon" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#C58F59" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                                </div>
                                <div class="reg-options">
                                    <div class="reg-option {{ request('filter_dokter', 'semua') === 'semua' ? 'is-selected' : '' }}" data-value="semua">Semua Tenaga Medis</div>
@foreach($doctors as $d)
                                        <div class="reg-option {{ request('filter_dokter') == $d->id ? 'is-selected' : '' }}" data-value="{{ $d->id }}" data-avatar="{{ $d->foto_profil ? 'data:image/png;base64,' . $d->foto_profil : asset('images/profile.svg') }}">
                                            <img src="{{ $d->foto_profil ? 'data:image/png;base64,' . $d->foto_profil : asset('images/profile.svg') }}" style="width:24px;height:24px;border-radius:50%;margin-right:8px;object-fit:cover;flex-shrink:0;" alt="{{ $d->full_name }}">
                                            <span>{{ $d->full_name }}</span>
                                        </div>
                                    @endforeach
                                </div>
                                <input type="hidden" id="filter_dokter" value="{{ request('filter_dokter', 'semua') }}">
                            </div>
                        </div>
                        
                        <div class="reg-input-group">
                            <label>Metode Pembayaran *</label>
                            <div class="reg-custom-select">
                                <div class="reg-select-trigger">
                                    @php
                                        $selectedPaymentName = 'Semua Metode Pembayaran';
                                        if(request('filter_bayar') && request('filter_bayar') !== 'semua') {
                                            $selectedPayment = $paymentMethods->firstWhere('id', request('filter_bayar'));
                                            if($selectedPayment) $selectedPaymentName = $selectedPayment->name;
                                        }
                                    @endphp
                                    <span class="reg-select-text">{{ $selectedPaymentName }}</span>
                                    <svg class="reg-select-icon" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#C58F59" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                                </div>
                                <div class="reg-options">
                                    <div class="reg-option {{ request('filter_bayar', 'semua') === 'semua' ? 'is-selected' : '' }}" data-value="semua">Semua Metode Pembayaran</div>
@foreach($paymentMethods as $pm)
                                        <?php 
                                            $logoMap = [
                                                'Admedika' => asset('images/Admedika 1.svg'),
                                                'Avrist' => asset('images/Avrist 1.svg'),
                                                'Chubb' => asset('images/Chubb 1.svg'),
                                                'Generali' => asset('images/Generali 1.svg'),
                                                'GlobalExcel' => asset('images/GlobalExcel 1.svg'),
                                                'GreatEastern' => asset('images/GreatEastern 1.svg'),
                                                'LippoLife' => asset('images/LippoLife 1.svg'),
                                                'MedikaPlaza' => asset('images/MedikaPlaza 1.svg'),
                                                'Meditap' => asset('images/Meditap 1.svg'),
                                                'PLN' => asset('images/PLN 1.svg'),
                                                'Umum' => asset('images/cashier.svg'),
                                            ];
                                            $logo = $logoMap[$pm->name] ?? asset('images/profile.svg');
                                        ?>
                                        <div class="reg-option {{ request('filter_bayar') == $pm->id ? 'is-selected' : '' }}" data-value="{{ $pm->id }}">
                                            <img src="{{ $logo }}" style="width:28px;height:20px;margin-right:8px;flex-shrink:0;" alt="{{ $pm->name }}">
                                            <span>{{ $pm->name }}</span>
                                        </div>
                                    @endforeach
                                </div>
                                <input type="hidden" id="filter_bayar" value="{{ request('filter_bayar', 'semua') }}">
                            </div>
                        </div>
                        
<div class="reg-input-group" style="flex: 1.5; justify-content: flex-end;">
                            <div class="reg-date-wrapper" style="display: flex; align-items: center; gap: 10px; position: relative;">
                                    <div class="reg-search-box" style="flex: 1; position: relative;">
                                    <input type="text" id="filter_search" placeholder="Nama Pasien, Nomor MR..." value="{{ request('search') }}" 
                                           style="padding-right: 40px;" 
                                           oninput="clientFilterTable();"
                                           onsearch="clientFilterTable();">
                                    <i class="fas fa-search search-icon" style="cursor: pointer; position: absolute; right: 10px; top: 50%; transform: translateY(-50%); color: #C58F59;" onclick="clientFilterTable()"></i>
                                </div>
                                <button type="button" onclick="clearSearchFilter()" title="Hapus Pencarian" 
                                    style="color: #C58F59; background-color: transparent; border: 1px solid #C58F59; border-radius: 4px; width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; cursor: pointer; flex-shrink: 0;">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Wrapper Tabel --}}
                <div class="reg-table-wrapper">
                    <table class="reg-table">
                        <thead>
                            <tr>
    <th>No</th>
                                <th>Status</th>
                                <th>Tanggal<br>Kunjungan</th>
                                <th>Tanggal<br>Dibuat</th>
                                
                                <th>Poli</th>
                                <th>Nama Pasien</th>

                                <th>Rencana<br>Tindakan</th>
                                <th>Dokter Pemeriksa</th>
                                <th>Metode Bayar</th>
                                <th>Catatan Medis</th>
                                <th>Aksi</th>

                            </tr>
                        </thead>
                        <tbody>
                        {{-- Looping data dari variabel $appointments --}}
                        @forelse($appointments as $index => $app)
                            <tr>
                                 <td data-label="No">{{ $appointments->firstItem() + $index }}</td>
                                <td data-label="Status">
                                    <span class="reg-status {{ strtolower($app->status) }}">
                                        {{ ucfirst($app->status) }}
                                    </span>
                                </td>
                                
                                <td data-label="Tanggal Kunjungan">
                                    {{ \Carbon\Carbon::parse($app->appointment_datetime)->format('d/m/Y') }},<br>
                                    {{ \Carbon\Carbon::parse($app->appointment_datetime)->format('H:i') }}
                                </td>
                                
                                <td data-label="Tanggal Dibuat">
                                    @if($app->created_at)
                                        {{ \Carbon\Carbon::parse($app->created_at)->format('d/m/Y') }},<br>
                                        {{ \Carbon\Carbon::parse($app->created_at)->format('H:i') }}
                                    @else
                                        -
                                    @endif
                                </td>
                                
                               
                                
                                <td data-label="Poli">{{ $app->poli->name ?? '-' }}</td>
                                


                                <td data-label="Nama Pasien">
                                    <strong>{{ $app->patient->full_name ?? 'Pasien Baru' }}</strong><br>
                                    {{ $app->patient->medical_record_no ?? '-' }}
                                </td>


                                
                                <td data-label="Rencana Tindakan">{{ $app->procedure_plan ?? '-' }}</td>
                                
                                <td data-label="Dokter Pemeriksa">{{ $app->doctor->full_name ?? '-' }}</td>
                                
                                <td data-label="Metode Bayar">{{ $app->paymentMethod->name ?? 'Umum' }}</td>
                                
                                <td data-label="Catatan Medis">{{ \Illuminate\Support\Str::limit($app->complaint ?? '-', 40) }}</td>
                                
                                <td data-label="Aksi">
                                    <button class="reg-btn-outline detail-btn" style="padding: 4px 8px;" onclick="openAppointmentDetailModal('{{ $app->id }}')">Detail</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" style="text-align: center; padding: 30px; color: #666;">
                                    <i class="fas fa-search" style="font-size: 24px; color: #ccc; margin-bottom: 10px; display: block;"></i>
                                    Data pendaftaran tidak ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    </table>
                </div>

                <div class="reg-pagination">
                    <div class="reg-page-size">
                        <span>Menampilkan {{ $appointments->firstItem() ?? 0 }}-{{ $appointments->lastItem() ?? 0 }} dari {{ $appointments->total() }} Data</span>
                    </div>
                    <div class="reg-page-controls">
                        @if ($appointments->onFirstPage())
                            <button class="reg-page-btn" disabled><i class="fas fa-chevron-left"></i></button>
                        @else
                            <a href="{{ $appointments->previousPageUrl() }}" class="reg-page-btn"><i class="fas fa-chevron-left"></i></a>
                        @endif

                        @if ($appointments->hasMorePages())
                            <a href="{{ $appointments->nextPageUrl() }}" class="reg-page-btn"><i class="fas fa-chevron-right"></i></a>
                        @else
                            <button class="reg-page-btn" disabled><i class="fas fa-chevron-right"></i></button>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const customSelects = document.querySelectorAll('.reg-custom-select');

        customSelects.forEach(dropdown => {
            const trigger = dropdown.querySelector('.reg-select-trigger');
            const options = dropdown.querySelectorAll('.reg-option');
            const textDisplay = dropdown.querySelector('.reg-select-text');
            const hiddenInput = dropdown.querySelector('input[type="hidden"]');

            trigger.addEventListener('click', function(e) {
                e.stopPropagation();
                customSelects.forEach(other => {
                    if (other !== dropdown) other.classList.remove('open');
                });
                dropdown.classList.toggle('open');
            });

            options.forEach(option => {
                option.addEventListener('click', function(e) {
                    e.stopPropagation();
                    options.forEach(opt => opt.classList.remove('is-selected'));
                    this.classList.add('is-selected');
                    
                    // Update trigger dengan img jika ada
                    const img = this.querySelector('img');
                    const spanText = this.querySelector('span')?.textContent || this.textContent;
                    if (img) {
                        textDisplay.innerHTML = `<img src="${img.src}" style="width:20px;height:20px;border-radius:50%;margin-right:6px;object-fit:cover;flex-shrink:0;vertical-align:middle;">${spanText}`;
                    } else {
                        textDisplay.textContent = spanText;
                    }
                    
                    if (hiddenInput) {
                        hiddenInput.value = this.dataset.value;
                        applyFilter(); // PENTING: Panggil filter setelah dipilih
                    }
                    dropdown.classList.remove('open');
                });
            });
        });

        // Update CSS untuk support images in options
        const style = document.createElement('style');
        style.textContent = `
            .reg-option {
                display: flex;
                align-items: center;
                padding: 12px 16px;
            }
            .reg-select-trigger {
                display: flex;
                align-items: center;
            }
            .reg-select-text {
                display: flex;
                align-items: center;
            }
        `;
        document.head.appendChild(style);

        window.addEventListener('click', function(e) {
            customSelects.forEach(dropdown => dropdown.classList.remove('open'));
            
            // Close modals when clicking overlay
            if (e.target.classList.contains('reg-modal-overlay')) {
                if(typeof closeRegModal === "function") closeRegModal(e.target.id);
            }
        });
    });

    // Modal Functions
    function openRegModal(modalId) {
        let modal = document.getElementById(modalId);
        if(modal) {
            modal.classList.add('open');
            document.body.style.overflow = 'hidden'; 
        }
    }
    
    function closeRegModal(modalId) {
        let modal = document.getElementById(modalId);
        if(modal) {
            modal.classList.remove('open');
            document.body.style.overflow = '';
        }
    }

    // Client-side table filtering for search (no page reload)
    function clientFilterTable() {
        const searchInput = document.getElementById('filter_search');
        const searchTerm = searchInput ? searchInput.value.toLowerCase().trim() : '';
        const tableRows = document.querySelectorAll('tbody tr');
        let visibleCount = 0;

        tableRows.forEach(row => {
            const patientCell = row.querySelector('td:nth-child(6)'); // Nama Pasien column
            const textContent = patientCell ? patientCell.textContent.toLowerCase() : '';
            
            if (searchTerm === '' || textContent.includes(searchTerm)) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        // Update pagination info (optional enhancement)
        const pageInfo = document.querySelector('.reg-page-size span');
        if (pageInfo && searchTerm !== '') {
            pageInfo.textContent = `Ditemukan ${visibleCount} hasil pencarian`;
        } else if (pageInfo) {
            // Reset to original when search cleared
            const tbody = document.querySelector('tbody');
            const totalRows = tbody.querySelectorAll('tr:not([style*="display: none"])').length;
            pageInfo.textContent = `Menampilkan 1-${Math.min(totalRows, 10)} dari ${totalRows} Data`;
        }
    }
    
    // FUNGSI UNTUK REFRESH HALAMAN DENGAN FILTER (with loading)
    function applyFilter() {
        // Show loading
        const searchIcon = document.querySelector('.search-icon');
        const clearBtn = document.querySelector('.reg-date-wrapper button[title="Hapus Pencarian"]');
        if (searchIcon) searchIcon.style.opacity = '0.5';
        if (clearBtn) clearBtn.style.opacity = '0.5';
        
        const date = document.getElementById('filter_date') ? document.getElementById('filter_date').value : '';
        const poli = document.getElementById('filter_poli') ? document.getElementById('filter_poli').value : 'semua';
        const dokter = document.getElementById('filter_dokter') ? document.getElementById('filter_dokter').value : 'semua';
        const bayar = document.getElementById('filter_bayar') ? document.getElementById('filter_bayar').value : 'semua';
        const search = document.getElementById('filter_search') ? document.getElementById('filter_search').value : '';

        let url = new URL(window.location.href);
        
        if(date) url.searchParams.set('date', date); else url.searchParams.delete('date');
        if(poli !== 'semua') url.searchParams.set('filter_poli', poli); else url.searchParams.delete('filter_poli');
        if(dokter !== 'semua') url.searchParams.set('filter_dokter', dokter); else url.searchParams.delete('filter_dokter');
        if(bayar !== 'semua') url.searchParams.set('filter_bayar', bayar); else url.searchParams.delete('filter_bayar');
        if(search) url.searchParams.set('search', search); else url.searchParams.delete('search');

        window.location.href = url.toString();
    }
    
    // Clear search filter (client-side only)
    function clearSearchFilter() {
        const searchInput = document.getElementById('filter_search');
        if (searchInput) {
            searchInput.value = '';
            clientFilterTable();
        }
    }
    
    // FUNGSI UNTUK MENGHAPUS KHUSUS FILTER TANGGAL
    function clearDateFilter() {
        const dateInput = document.getElementById('filter_date');
        if (dateInput) {
            dateInput.value = '';
            applyFilter();
        }
    }

    // State untuk edit photo di detail modal
    let editPhotoCropperState = {
        image: null,
        originalWidth: 0,
        originalHeight: 0,
        frameX: undefined,
        frameY: undefined,
        frameSize: 200,
        isDragging: false
    };
    let editPhotoCroppedBase64 = '';

    // Open appointment detail modal
    function openAppointmentDetailModal(appointmentId) {
        // Create modal container jika belum ada
        let modal = document.getElementById('appointmentDetailModal');
        if (!modal) {
            modal = document.createElement('div');
            modal.id = 'appointmentDetailModal';
            modal.style.cssText = `
                position: fixed; top: 0; left: 0; right: 0; bottom: 0; 
                background: rgba(0,0,0,0.5); z-index: 9999; display: none; 
                align-items: center; justify-content: center; overflow-y: auto;
            `;
            modal.onclick = function(e) {
                if (e.target === modal) {
                    closeDetailModal();
                }
            };
            document.body.appendChild(modal);
        }

        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';

        // Fetch appointment data from API
        fetch(`/api/appointments/${appointmentId}`, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            }
        })
        .then(res => res.json())
        .then(response => {
            if (response.success && response.data) {
                const appointment = response.data;
                modal.innerHTML = renderDetailModalContent(appointment);
                setupDetailEventListeners(appointmentId, appointment);
            } else {
                modal.innerHTML = `
                    <div style="background: white; padding: 30px; border-radius: 12px; max-width: 600px; width: 90%;">
                        <p style="color: #e05252;">Error: ${response.message || 'Gagal memuat data'}</p>
                        <button onclick="document.getElementById('appointmentDetailModal').style.display='none'; document.body.style.overflow='';" 
                                style="padding: 8px 16px; background: #C58F59; color: white; border: none; border-radius: 4px; cursor: pointer;">
                            Tutup
                        </button>
                    </div>
                `;
            }
        })
        .catch(err => {
            modal.innerHTML = `
                <div style="background: white; padding: 30px; border-radius: 12px; max-width: 600px; width: 90%;">
                    <p style="color: #e05252;">Error: ${err.message}</p>
                    <button onclick="document.getElementById('appointmentDetailModal').style.display='none'; document.body.style.overflow='';" 
                            style="padding: 8px 16px; background: #C58F59; color: white; border: none; border-radius: 4px; cursor: pointer;">
                        Tutup
                    </button>
                </div>
            `;
        });
    }

    function renderDetailModalContent(appointment) {
        const patientPhotoRaw = appointment.patient?.photo || null;
        const patientPhoto = patientPhotoRaw?.startsWith('data:image') ? patientPhotoRaw : (patientPhotoRaw ? `data:image/png;base64,${patientPhotoRaw}` : null);

        const currentMode = 'view'; // Default mode

        return `
            <div style="background: white; border-radius: 12px; max-width: 700px; width: 95%; max-height: 85vh; overflow-y: auto; box-shadow: 0 20px 60px rgba(0,0,0,0.3); position: relative;">
                
                {{-- Header --}}
                <div style="background: linear-gradient(135deg, #C58F59 0%, #A67C52 100%); padding: 25px; border-radius: 12px 12px 0 0; color: white; display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <h2 style="margin: 0 0 5px 0; font-size: 20px;">Detail Kunjungan</h2>
                        <p style="margin: 0; font-size: 12px; opacity: 0.9;">${appointment.id}</p>
                    </div>
                    <button onclick="closeDetailModal()" style="background: rgba(255,255,255,0.2); border: none; color: white; font-size: 24px; cursor: pointer; width: 35px; height: 35px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        ×
                    </button>
                </div>

                {{-- Content --}}
                <div style="padding: 25px;">
                    {{-- View Mode --}}
                    <div id="detailViewMode" style="display: block;">
                        {{-- Patient Info Card --}}
                        <div style="display: grid; grid-template-columns: 80px 1fr; gap: 15px; margin-bottom: 25px; padding: 15px; background: #f9f7f4; border-radius: 8px;">
                            <div>
                                ${patientPhoto ? 
                                    `<img src="${patientPhoto}" style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; border: 2px solid #C58F59;">` :
                                    `<div style="width: 80px; height: 80px; border-radius: 50%; background: #E5D6C5; display: flex; align-items: center; justify-content: center; border: 2px solid #C58F59;"><i class="fas fa-user" style="font-size: 32px; color: #A67C52;"></i></div>`
                                }
                            </div>
                            <div>
                                <div style="font-weight: 600; color: #2C1810; margin-bottom: 3px; font-size: 16px;">
                                    ${appointment.patient?.full_name || 'N/A'}
                                </div>
                                <div style="font-size: 12px; color: #666; margin-bottom: 8px;">
                                    <strong>MR:</strong> ${appointment.patient?.medical_record_no || 'N/A'}
                                </div>
                                <div style="font-size: 12px; color: #666;">
                                    <strong>Tanggal Lahir:</strong> ${appointment.patient?.date_of_birth ? new Date(appointment.patient.date_of_birth).toLocaleDateString('id-ID') : 'N/A'}
                                </div>
                            </div>
                        </div>

                        {{-- Doctor & Poli Info --}}
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 25px;">
                            <div style="padding: 12px; background: #f9f7f4; border-radius: 6px;">
                                <div style="font-size: 11px; color: #999; text-transform: uppercase; margin-bottom: 5px;">Tenaga Medis</div>
                                <div style="font-weight: 600; color: #2C1810;">
                                    ${appointment.doctor?.full_name || 'N/A'}
                                </div>
                            </div>
                            <div style="padding: 12px; background: #f9f7f4; border-radius: 6px;">
                                <div style="font-size: 11px; color: #999; text-transform: uppercase; margin-bottom: 5px;">Poli</div>
                                <div style="font-weight: 600; color: #2C1810;">
                                    ${appointment.poli?.name || 'N/A'}
                                </div>
                            </div>
                        </div>

                        {{-- Appointment Details --}}
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 25px;">
                            <div>
                                <div style="font-size: 12px; color: #999; margin-bottom: 5px;">Tanggal & Jam</div>
                                <div style="font-size: 14px; font-weight: 600; color: #2C1810;">
                                    ${new Date(appointment.appointment_datetime).toLocaleDateString('id-ID')} ${new Date(appointment.appointment_datetime).toLocaleTimeString('id-ID')}
                                </div>
                            </div>
                            <div>
                                <div style="font-size: 12px; color: #999; margin-bottom: 5px;">Status</div>
                                <div style="font-size: 14px; font-weight: 600; color: #2C1810;">
                                    ${appointment.status || 'N/A'}
                                </div>
                            </div>
                        </div>

                        {{-- Complaint --}}
                        <div style="margin-bottom: 20px;">
                            <div style="font-size: 12px; color: #999; margin-bottom: 5px;">Keluhan</div>
                            <div style="padding: 10px; background: #f9f7f4; border-radius: 6px; font-size: 14px; color: #2C1810; min-height: 50px;">
                                ${appointment.complaint || '(Tidak ada keluhan)'}
                            </div>
                        </div>

                        {{-- Procedure Plan --}}
                        <div style="margin-bottom: 20px;">
                            <div style="font-size: 12px; color: #999; margin-bottom: 5px;">Prosedur Rencana</div>
                            <div style="padding: 10px; background: #f9f7f4; border-radius: 6px; font-size: 14px; color: #2C1810; min-height: 50px;">
                                ${appointment.procedure_plan || '(Tidak ada rencana)'}
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div style="display: flex; gap: 10px; margin-top: 25px; padding-top: 20px; border-top: 1px solid #E5D6C5;">
                            <button onclick="toggleDetailEditMode('${appointment.id}')" style="flex: 1; padding: 12px; background: #C58F59; color: white; border: none; border-radius: 6px; cursor: pointer; font-weight: 600;">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button onclick="closeDetailModal()" style="flex: 1; padding: 12px; background: #E5D6C5; color: #2C1810; border: none; border-radius: 6px; cursor: pointer; font-weight: 600;">
                                Tutup
                            </button>
                        </div>
                    </div>

                    {{-- Edit Mode --}}
                    <div id="detailEditMode" style="display: none;">
                        <form id="detailEditForm" data-appointment-id="${appointment.id}">
                            {{-- Complaint --}}
                            <div style="margin-bottom: 20px;">
                                <label style="display: block; font-size: 12px; color: #999; margin-bottom: 5px; text-transform: uppercase;">Keluhan</label>
                                <textarea name="complaint" style="width: 100%; padding: 10px; border: 1px solid #E5D6C5; border-radius: 6px; font-family: inherit; font-size: 14px;" rows="3">${appointment.complaint || ''}</textarea>
                            </div>

                            {{-- Procedure Plan --}}
                            <div style="margin-bottom: 20px;">
                                <label style="display: block; font-size: 12px; color: #999; margin-bottom: 5px; text-transform: uppercase;">Prosedur Rencana</label>
                                <textarea name="procedure_plan" style="width: 100%; padding: 10px; border: 1px solid #E5D6C5; border-radius: 6px; font-family: inherit; font-size: 14px;" rows="3">${appointment.procedure_plan || ''}</textarea>
                            </div>

                            {{-- Photo Section --}}
                            <div style="margin-bottom: 20px; padding: 15px; background: #f9f7f4; border-radius: 8px;">
                                <div style="font-size: 12px; color: #999; text-transform: uppercase; margin-bottom: 10px;">Foto Profil</div>
                                <div style="display: flex; gap: 15px; align-items: flex-start;">
                                    <div id="editPhotoBox" style="width: 100px; height: 100px; border-radius: 50%; background: #E5D6C5; border: 2px solid #C58F59; display: flex; align-items: center; justify-content: center; overflow: hidden; cursor: pointer; position: relative; flex-shrink: 0;">
                                        ${patientPhoto ? 
                                            `<img src="${patientPhoto}" style="width: 100%; height: 100%; object-fit: cover;" alt="Patient photo">` :
                                            `<i class="fas fa-camera" style="font-size: 28px; color: #A67C52;"></i>`
                                        }
                                    </div>
                                    <div style="flex: 1; display: flex; flex-direction: column; gap: 8px;">
                                        <input type="file" id="editPhotoInput" accept="image/*" style="display: none;">
                                        <button type="button" id="editPhotoBtnUpload" style="padding: 8px 12px; background: #C58F59; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 13px;">
                                            <i class="fas fa-upload"></i> Upload Foto
                                        </button>
                                        ${patientPhoto ? `
                                            <button type="button" id="editPhotoBtnRemove" style="padding: 8px 12px; background: #e05252; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 13px;">
                                                <i class="fas fa-trash"></i> Hapus Foto
                                            </button>
                                        ` : ''}
                                    </div>
                                </div>
                                <input type="hidden" id="editPhotoCroppedBase64" name="photo_base64" value="">
                            </div>

                            {{-- Action Buttons --}}
                            <div style="display: flex; gap: 10px; margin-top: 25px; padding-top: 20px; border-top: 1px solid #E5D6C5;">
                                <button type="button" onclick="toggleDetailEditMode('${appointment.id}')" style="flex: 1; padding: 12px; background: #E5D6C5; color: #2C1810; border: none; border-radius: 6px; cursor: pointer; font-weight: 600;">
                                    <i class="fas fa-times"></i> Batal
                                </button>
                                <button type="submit" style="flex: 1; padding: 12px; background: #2C8659; color: white; border: none; border-radius: 6px; cursor: pointer; font-weight: 600;">
                                    <i class="fas fa-save"></i> Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        `;
    }

    function setupDetailEventListeners(appointmentId, appointment) {
        // Setup edit form submission
        const editForm = document.getElementById('detailEditForm');
        if (editForm) {
            editForm.addEventListener('submit', submitDetailEdit);
        }

        // Setup photo upload
        const editPhotoInput = document.getElementById('editPhotoInput');
        const editPhotoBtnUpload = document.getElementById('editPhotoBtnUpload');
        const editPhotoBox = document.getElementById('editPhotoBox');
        
        if (editPhotoBtnUpload && editPhotoInput) {
            editPhotoBtnUpload.addEventListener('click', () => editPhotoInput.click());
            editPhotoInput.addEventListener('change', handleDetailPhotoSelect);
        }

        if (editPhotoBox && editPhotoInput) {
            editPhotoBox.addEventListener('click', function(e) {
                if (!e.target.closest('button')) {
                    editPhotoInput.click();
                }
            });
        }

        // Setup remove photo button
        const editPhotoBtnRemove = document.getElementById('editPhotoBtnRemove');
        if (editPhotoBtnRemove) {
            editPhotoBtnRemove.addEventListener('click', removeDetailPhoto);
        }
    }

    function toggleDetailEditMode(appointmentId) {
        const viewMode = document.getElementById('detailViewMode');
        const editMode = document.getElementById('detailEditMode');
        
        if (viewMode && editMode) {
            if (viewMode.style.display === 'block') {
                viewMode.style.display = 'none';
                editMode.style.display = 'block';
            } else {
                viewMode.style.display = 'block';
                editMode.style.display = 'none';
                editPhotoCropperState = { image: null, originalWidth: 0, originalHeight: 0, frameX: undefined, frameY: undefined, frameSize: 200, isDragging: false };
                editPhotoCroppedBase64 = '';
            }
        }
    }

    function handleDetailPhotoSelect(e) {
        const file = e.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = (evt) => {
            const img = new Image();
            img.onload = () => {
                editPhotoCropperState.image = img;
                editPhotoCropperState.originalWidth = img.width;
                editPhotoCropperState.originalHeight = img.height;
                // Don't set frameX/Y here - let renderDetailCanvas initialize them
                editPhotoCropperState.frameX = undefined;
                editPhotoCropperState.frameY = undefined;
                openDetailEditCropperModal();
            };
            img.src = evt.target.result;
        };
        reader.readAsDataURL(file);
    }

    function openDetailEditCropperModal() {
        let modal = document.getElementById('detailCropperModal');
        if (!modal) {
            modal = document.createElement('div');
            modal.id = 'detailCropperModal';
            modal.style.cssText = `
                position: fixed; top: 0; left: 0; right: 0; bottom: 0;
                background: rgba(0,0,0,0.7); z-index: 10000; display: flex;
                align-items: center; justify-content: center;
            `;
            document.body.appendChild(modal);
        }

        modal.style.display = 'flex';
        modal.onclick = (e) => { if (e.target === modal) modal.style.display = 'none'; };

        modal.innerHTML = `
            <div style="background: white; padding: 20px; border-radius: 12px; max-width: 500px; width: 90%;">
                <h3 style="margin-top: 0;">Atur Foto Profil</h3>
                <canvas id="detailCropperCanvas" style="border: 1px solid #E5D6C5; width: 100%; max-height: 400px; display: block; margin-bottom: 15px; background: #000;"></canvas>
                <div style="display: flex; gap: 10px;">
                    <button type="button" onclick="document.getElementById('detailCropperModal').style.display='none';" style="flex: 1; padding: 10px; background: #E5D6C5; border: none; border-radius: 4px; cursor: pointer;">
                        Batal
                    </button>
                    <button type="button" onclick="applyDetailCrop()" style="flex: 1; padding: 10px; background: #2C8659; color: white; border: none; border-radius: 4px; cursor: pointer;">
                        Crop
                    </button>
                </div>
            </div>
        `;

        setTimeout(() => {
            renderDetailCanvas();
            attachDetailCanvasEvents();
        }, 100);
    }

    function renderDetailCanvas() {
        const canvas = document.getElementById('detailCropperCanvas');
        if (!canvas || !editPhotoCropperState.image) return;

        const img = editPhotoCropperState.image;
        
        // Set canvas size (max 500px width)
        let displayWidth = Math.min(img.width, 500);
        let displayHeight = (img.height / img.width) * displayWidth;
        
        if (displayHeight > 400) {
            displayHeight = 400;
            displayWidth = (img.width / img.height) * displayHeight;
        }
        
        displayWidth = Math.round(displayWidth);
        displayHeight = Math.round(displayHeight);
        
        canvas.width = displayWidth;
        canvas.height = displayHeight;
        
        // Initialize frame position to center (only once)
        if (editPhotoCropperState.frameX === 0 || editPhotoCropperState.frameX === undefined) {
            editPhotoCropperState.frameX = displayWidth / 2;
            editPhotoCropperState.frameY = displayHeight / 2;
        }
        
        const ctx = canvas.getContext('2d');
        
        // Draw image
        ctx.drawImage(img, 0, 0, displayWidth, displayHeight);
        
        // Draw dark overlay
        ctx.fillStyle = 'rgba(0, 0, 0, 0.5)';
        ctx.fillRect(0, 0, displayWidth, displayHeight);
        
        // Clear frame area (make it visible)
        ctx.clearRect(
            editPhotoCropperState.frameX - editPhotoCropperState.frameSize / 2,
            editPhotoCropperState.frameY - editPhotoCropperState.frameSize / 2,
            editPhotoCropperState.frameSize,
            editPhotoCropperState.frameSize
        );
        
        // Redraw image in frame area only
        ctx.drawImage(img, 0, 0, displayWidth, displayHeight);
        ctx.globalCompositeOperation = 'destination-in';
        ctx.beginPath();
        ctx.arc(
            editPhotoCropperState.frameX,
            editPhotoCropperState.frameY,
            editPhotoCropperState.frameSize / 2,
            0,
            Math.PI * 2
        );
        ctx.fill();
        ctx.globalCompositeOperation = 'source-over';
        
        // Draw circular border
        ctx.strokeStyle = '#C58F59';
        ctx.lineWidth = 3;
        ctx.beginPath();
        ctx.arc(editPhotoCropperState.frameX, editPhotoCropperState.frameY, editPhotoCropperState.frameSize / 2, 0, Math.PI * 2);
        ctx.stroke();
    }

    function attachDetailCanvasEvents() {
        const canvas = document.getElementById('detailCropperCanvas');
        if (!canvas) return;

        canvas.addEventListener('mousedown', (e) => {
            editPhotoCropperState.isDragging = true;
        });

        canvas.addEventListener('mousemove', (e) => {
            if (!editPhotoCropperState.isDragging) return;
            
            const rect = canvas.getBoundingClientRect();
            editPhotoCropperState.frameX = e.clientX - rect.left;
            editPhotoCropperState.frameY = e.clientY - rect.top;
            
            // Constrain to canvas bounds
            const halfSize = editPhotoCropperState.frameSize / 2;
            editPhotoCropperState.frameX = Math.max(halfSize, Math.min(canvas.width - halfSize, editPhotoCropperState.frameX));
            editPhotoCropperState.frameY = Math.max(halfSize, Math.min(canvas.height - halfSize, editPhotoCropperState.frameY));
            
            renderDetailCanvas();
        });

        canvas.addEventListener('mouseup', () => {
            editPhotoCropperState.isDragging = false;
        });
    }

    function applyDetailCrop() {
        const canvas = document.getElementById('detailCropperCanvas');
        if (!canvas || !editPhotoCropperState.image) return;

        // Create circular cropped image
        const size = editPhotoCropperState.frameSize;
        const croppedCanvas = document.createElement('canvas');
        croppedCanvas.width = size;
        croppedCanvas.height = size;

        const ctx = croppedCanvas.getContext('2d');

        // Calculate source coordinates using scale factors
        const scaleX = editPhotoCropperState.originalWidth / canvas.width;
        const scaleY = editPhotoCropperState.originalHeight / canvas.height;

        // Top-left corner of bounding square (frameX/Y is center-based)
        const srcX = (editPhotoCropperState.frameX - size / 2) * scaleX;
        const srcY = (editPhotoCropperState.frameY - size / 2) * scaleY;
        const srcSize = size * scaleX;

        // Draw circular image from original coordinates
        ctx.drawImage(
            editPhotoCropperState.image,
            srcX, srcY, srcSize, srcSize,
            0, 0, size, size
        );

        // Apply circular mask
        ctx.globalCompositeOperation = 'destination-in';
        ctx.beginPath();
        ctx.arc(size / 2, size / 2, size / 2, 0, Math.PI * 2);
        ctx.fill();

        // Convert to base64
        const fullDataUrl = croppedCanvas.toDataURL('image/png');
        // Strip the "data:image/png;base64," prefix - we only want the pure base64
        editPhotoCroppedBase64 = fullDataUrl.split(',')[1];
        document.getElementById('editPhotoCroppedBase64').value = editPhotoCroppedBase64;

        // Update preview - use full data URL for display
        const photoBox = document.getElementById('editPhotoBox');
        if (photoBox) {
            photoBox.innerHTML = `<img src="${fullDataUrl}" style="width: 100%; height: 100%; object-fit: cover;">`;
        }

        document.getElementById('detailCropperModal').style.display = 'none';
    }

    function removeDetailPhoto() {
        const photoBox = document.getElementById('editPhotoBox');
        const photoInput = document.getElementById('editPhotoCroppedBase64');
        const removeBtn = document.getElementById('editPhotoBtnRemove');
        
        if (photoBox) {
            photoBox.innerHTML = `<i class="fas fa-camera" style="font-size: 28px; color: #A67C52;"></i>`;
        }
        if (photoInput) {
            photoInput.value = '';
        }
        if (removeBtn) {
            removeBtn.remove();
        }
        editPhotoCroppedBase64 = '';
    }

    async function submitDetailEdit(e) {
        e.preventDefault();
        const form = e.target;
        const appointmentId = form.dataset.appointmentId;
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;

        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
        submitBtn.disabled = true;

        try {
            // Build payload sebagai JSON (bukan FormData) agar lebih reliable
            const payload = {
                complaint:      form.querySelector('[name="complaint"]').value,
                procedure_plan: form.querySelector('[name="procedure_plan"]').value,
                photo_base64:   form.querySelector('[name="photo_base64"]').value || null,
            };

            console.log('[submitDetailEdit] payload:', payload);

            // 1. PUT update appointment
            const putRes = await fetch(`/api/appointments/${appointmentId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify(payload),
            });

            const putData = await putRes.json();
            if (!putData.success) throw new Error(putData.message || 'Gagal menyimpan');

            // 2. GET fresh data
            const getRes = await fetch(`/api/appointments/${appointmentId}`, {
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                cache: 'no-cache',
            });
            const getData = await getRes.json();
            if (!getData.success || !getData.data) throw new Error('Gagal memuat data terbaru');

            // 3. Re-render modal dengan data baru
            const modal = document.getElementById('appointmentDetailModal');
            if (modal) {
                modal.innerHTML = renderDetailModalContent(getData.data);
                setupDetailEventListeners(appointmentId, getData.data);
                // Paksa kembali ke view mode
                const vm = document.getElementById('detailViewMode');
                const em = document.getElementById('detailEditMode');
                if (vm) vm.style.display = 'block';
                if (em) em.style.display = 'none';
                modal.scrollTop = 0;
            }

            // Reset cropper state
            editPhotoCropperState = { image: null, originalWidth: 0, originalHeight: 0, frameX: undefined, frameY: undefined, frameSize: 200, isDragging: false };
            editPhotoCroppedBase64 = '';

            alert('✓ Detail kunjungan berhasil disimpan');

        } catch (err) {
            console.error('[submitDetailEdit] error:', err);
            alert('✗ Error: ' + err.message);
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }
    }


    function closeDetailModal() {
        const modal = document.getElementById('appointmentDetailModal');
        if (modal) {
            modal.style.display = 'none';
            document.body.style.overflow = '';
        }
    }
</script>

@include('admin.components.pasien-baru')
@include('admin.components.pendaftaran-baru')

@endsection