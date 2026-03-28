@extends('admin.layout.admin')
@section('title', 'Rawat Jalan')

@section('navbar')
    @include('admin.components.navbarSearch', ['title' => 'Rawat Jalan'])
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/pages/rawat-jalan.css') }}">
@endpush

@section('content')
    <div class="rawat-jalan-container">
        
        <!-- Header -->
        <div class="rawat-jalan-header">
            <h1 class="rawat-jalan-title">Rawat Jalan</h1>
            <p class="rawat-jalan-subtitle">Manajemen Jadwal Pasien & Status Layanan</p>
        </div>

        <!-- Filters -->
        <div class="filter-box">
            <div class="filter-group">
                <label for="dateInput">Tanggal</label>
                <input type="date" id="dateInput" name="date">
            </div>

            <div class="filter-group">
                <label for="doctorFilter">Dokter</label>
                <select id="doctorFilter" name="doctor_id">
                    <option value="">-- Semua Dokter --</option>
                    @foreach($doctors as $doctor)
                        <option value="{{ $doctor->id }}">{{ $doctor->full_title }}</option>
                    @endforeach
                </select>
            </div>

            <div class="filter-group">
                <label for="statusFilter">Status</label>
                <select id="statusFilter" name="status">
                    <option value="">-- Semua Status --</option>
                    <option value="pending">Menunggu Konfirmasi</option>
                    <option value="confirmed">Terkonfirmasi</option>
                    <option value="waiting">Menunggu Dipanggil</option>
                    <option value="engaged">Sedang Dilayani</option>
                    <option value="succeed">Selesai</option>
                </select>
            </div>

            <div class="filter-group">
                <label for="searchInput">Cari Pasien</label>
                <input type="text" id="searchInput" name="search" placeholder="Nama atau Nomor RM...">
            </div>

            <div class="filter-actions">
                <button id="todayBtn" class="btn btn-secondary">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>
                    Hari Ini
                </button>
            </div>
        </div>

        <!-- Table -->
        <div class="table-wrapper">
            <table class="appointment-table" id="appointmentTable">
                <thead>
                    <tr>
                        <th class="col-no">No</th>
                        <th class="col-time">Jam</th>
                        <th class="col-patient">Pasien</th>
                        <th class="col-doctor">Dokter</th>
                        <th class="col-age">Umur</th>
                        <th class="col-status">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="6" class="text-center empty-state">
                            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <circle cx="12" cy="12" r="10"/>
                                <line x1="12" y1="16" x2="12" y2="12"/>
                                <line x1="12" y1="8" x2="12.01" y2="8"/>
                            </svg>
                            <p>Memuat data...</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Appointment Detail -->
    <div id="appointmentModal" class="modal-overlay"></div>

@endsection

@push('scripts')
    <script src="{{ asset('js/admin/rawat-jalan.js') }}"></script>
@endpush
