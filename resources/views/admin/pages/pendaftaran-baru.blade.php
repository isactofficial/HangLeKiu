@extends('admin.layout.admin')

@section('title', 'Daftar Kunjungan')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/pages/registration-shared.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/pages/pendaftaran-baru.css') }}">
@endpush

@section('navbar')
    @include('admin.components.navbarPendaftaranBaru', ['title' => 'Pendaftaran Baru'])
@endsection

@section('content')
<div class="page-wrapper">
    <h1 class="page-title">Daftar Kunjungan</h1>

    <div class="form-card">
        
        {{-- Header Row: Search & Notice --}}
        <div class="search-header-row">
            <div class="search-group-wrapper">
                <div class="search-input-box">
                    <label>Pasien</label>
                    <div class="input-with-clear">
                        {{-- REVISI 1: Value dikosongkan --}}
                        <input type="text" placeholder="Cari nama pasien...">
                        <button type="button" class="btn-clear">
                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                </div>
                <button type="button" class="btn-solid">Adv. Search</button>
            </div>
            <div class="req-notice">Tanda <span>*</span> wajib diisi!</div>
        </div>

        {{-- Patient Info Container --}}
        <div class="patient-info-container" id="patientInfoContainer">
            <div class="patient-info-card">
                <div class="patient-photo">
                    <svg fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                </div>
                <div class="patient-details">
                    <div class="detail-label">Nama Lengkap</div>  <div class="detail-value">Rama Yanti <span style="color:var(--text-gray); font-weight:400;">230749</span></div>
                    <div class="detail-label">Tanggal Lahir</div> <div class="detail-value">01-01-2000, 26 Tahun 2 Bulan 16 Hari</div>
                    <div class="detail-label">Jenis Kelamin</div> <div class="detail-value">Perempuan</div>
                    <div class="detail-label">Alamat</div>        <div class="detail-value">-,,,,</div>
                    <div class="detail-label">Nomor Kartu BPJS</div><div class="detail-value">-</div>
                    <div class="detail-label">PPK Umum</div>      <div class="detail-value">-</div>
                    <div class="detail-label">Nomor KTP</div>     <div class="detail-value">-</div>
                    <div class="detail-label">Tags</div>          <div class="detail-value">-</div>
                </div>
            </div>
        </div>

        {{-- Patient Actions (Toggle & Edit) --}}
        <div class="patient-actions">
            {{-- REVISI 2: Perbaikan fungsional JS dengan ID --}}
            <button type="button" class="btn-outline" onclick="togglePatientInfo()">
                <span id="toggleText">Sembunyikan </span>
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path id="toggleIconPath" stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7"></path>
                </svg>
            </button>
            <button type="button" class="btn-outline">Edit Pasien</button>
        </div>

        {{-- Main Form Sections --}}
        <div class="form-section">
            
            <div class="grid-1">
                <div class="form-group">
                    <label class="form-label">Tipe Pasien</label>
                    <select class="input-pill">
                        <option>Pasien Non Rujuk</option>
                    </select>
                </div>
            </div>

            <div class="grid-2" style="margin-bottom: 40px;">
                <div class="form-group">
                    <label class="form-label">Penjamin <span class="req">*</span></label>
                    <select class="input-pill">
                        <option>Rama Yanti (Pribadi)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Metode Pembayaran <span class="req">*</span></label>
                    <select class="input-pill">
                        <option>Tunai</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Jenis Kunjungan <span class="req">*</span></label>
                    <select class="input-pill">
                        <option>Kunjungan Sakit</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Jenis Perawatan <span class="req">*</span></label>
                    <select class="input-pill">
                        <option>Rawat Jalan</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Nomor HP</label>
                    <input type="text" class="input-line" value="1">
                </div>
                <div class="form-group">
                    <label class="form-label">Alamat Email</label>
                    <input type="email" class="input-line">
                    {{-- REVISI 3: Checkbox tidak lagi disabled --}}
                    <label class="checkbox-wrapper">
                        <input type="checkbox">
                        <span>Notifikasi Email</span>
                    </label>
                </div>

                <div class="form-group">
                    <label class="form-label">Poli <span class="req">*</span></label>
                    <select class="input-pill">
                        <option>Gigi</option>
                    </select>
                    <label class="checkbox-wrapper">
                        <input type="checkbox">
                        <span>Nomor Antrean</span>
                    </label>
                </div>
                <div class="form-group">
                    <label class="form-label">Tenaga Medis <span class="req">*</span></label>
                    <select class="input-pill" disabled>
                        <option>drg. Dinda Tegar Jelita Sp.Ortho</option>
                    </select>
                </div>

                <div class="form-group" style="margin-bottom: 10px;">
                    <label class="form-label">Tanggal <span class="req">*</span></label>
                    {{-- REVISI 4: Input date dengan icon kalender --}}
                    <div class="input-icon-wrapper">
                        <input type="date" class="input-line">
                        <svg class="icon-right" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                        </svg>
                    </div>
                    <span class="sub-text">Dokter praktek hari ini</span>
                </div>
                <div class="form-group" style="margin-bottom: 10px;">
                    <label class="form-label">Slot <span class="req">*</span></label>
                    <select class="input-pill">
                        <option>12:00 - 20:11 WIB</option>
                    </select>
                    <span class="sub-text">Pilih slot jadwal dokter</span>
                </div>

                <div class="form-group" style="margin-bottom: 10px;">
                    <label class="form-label">Jam <span class="req">*</span></label>
                    <div class="input-icon-wrapper">
                        <input type="time" class="input-line" value="13:45">
                        <svg class="icon-right" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                    </div>
                    <span class="sub-text">Harus diisi</span>
                </div>
                <div class="form-group" style="margin-bottom: 10px;">
                    <label class="form-label">Lama Durasi <span class="req">*</span></label>
                    <div class="input-flex-wrapper">
                        <input type="number" class="input-line" value="10">
                        <span class="input-suffix">menit</span>
                    </div>
                    <span class="sub-text">Maks. 386 Menit</span>
                </div>
            </div>

            {{-- Additional Action & Inputs --}}
            <a href="#" class="action-link">+ Rencana Tindakan</a>

            <div class="simple-line-group">
                <label class="simple-line-label">Keluhan</label>
                <input type="text" class="input-line">
            </div>
            
            <div class="simple-line-group">
                <label class="simple-line-label">Prosedur Rencana</label>
                <input type="text" class="input-line">
            </div>

            <div class="simple-line-group">
                <label class="simple-line-label">Informasi Kondisi Pasien</label>
                <input type="text" class="input-line">
            </div>

        </div>
    </div>
</div>

@push('scripts')
<script>
    function togglePatientInfo() {
        const container = document.getElementById('patientInfoContainer');
        const textSpan = document.getElementById('toggleText');
        const iconPath = document.getElementById('toggleIconPath');
        
        if (container.style.display === 'none') {
            container.style.display = 'block';
            textSpan.textContent = 'Sembunyikan ';
            iconPath.setAttribute('d', 'M5 15l7-7 7 7'); // Panah ke atas
        } else {
            container.style.display = 'none';
            textSpan.textContent = 'Tampilkan ';
            iconPath.setAttribute('d', 'M19 9l-7 7-7-7'); // Panah ke bawah
        }
    }
</script>
@endpush
@endsection