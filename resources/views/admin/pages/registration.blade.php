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
                    <div class="reg-card-actions">
                        <button class="reg-icon-btn" title="Informasi"><i class="fas fa-info-circle"></i></button>
                        <button class="reg-btn-outline">EXPORT</button>
                        <button class="reg-icon-btn" title="Print">
                            <svg xmlns="http://www.w3.org/2000/svg" style="width: 20px; height: 20px; color: currentColor;" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18.25 7.034V3.375" /></svg>
                        </button>
                    </div>
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
                                        <div class="reg-option {{ request('filter_dokter') == $d->id ? 'is-selected' : '' }}" data-value="{{ $d->id }}">{{ $d->full_name }}</div>
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
                                        <div class="reg-option {{ request('filter_bayar') == $pm->id ? 'is-selected' : '' }}" data-value="{{ $pm->id }}">{{ $pm->name }}</div>
                                    @endforeach
                                </div>
                                <input type="hidden" id="filter_bayar" value="{{ request('filter_bayar', 'semua') }}">
                            </div>
                        </div>
                        
                        <div class="reg-input-group" style="flex: 1.5; justify-content: flex-end;">
                            <div class="reg-search-box">
                                <input type="text" id="filter_search" placeholder="Nama Pasien, Nomor MR" value="{{ request('search') }}" onkeypress="if(event.key === 'Enter') applyFilter()">
                                <i class="fas fa-search" style="cursor: pointer;" onclick="applyFilter()"></i>
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
                                    <button class="reg-btn-outline" style="padding: 4px 8px;" onclick="openDetail('{{ $app->id }}')">Detail</button>
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
                    textDisplay.textContent = this.textContent;
                    
                    if (hiddenInput) {
                        hiddenInput.value = this.dataset.value;
                        applyFilter(); // PENTING: Panggil filter setelah dipilih
                    }
                    dropdown.classList.remove('open');
                });
            });
        });

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

    // FUNGSI UNTUK REFRESH HALAMAN DENGAN FILTER
    function applyFilter() {
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
    // FUNGSI UNTUK MENGHAPUS KHUSUS FILTER TANGGAL
    function clearDateFilter() {
        const dateInput = document.getElementById('filter_date');
        if (dateInput) {
            dateInput.value = ''; // Kosongkan kotak tanggal
            applyFilter();        // Refresh halaman dengan tanggal kosong
        }
    }
</script>

@include('admin.components.pasien-baru')
@include('admin.components.pendaftaran-baru')

@endsection