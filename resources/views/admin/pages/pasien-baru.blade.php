@extends('admin.layout.admin')

@section('title', 'Pasien Baru')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/pages/registration-shared.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/pages/pasien-baru.css') }}">
@endpush

@section('navbar')
    @include('admin.components.navbarPendaftaranBaru', ['title' => 'Pasien Baru'])
@endsection

@section('content')
<div class="page-wrapper">

    <h1 class="page-title">Tambah Pasien Baru</h1>

    <div class="form-card">
        
        <div class="section-header">
            Informasi Dasar
        </div>

        <div class="form-body">
            
            {{-- Top Section: Photo & Notice --}}
            <div class="top-section">
                <div class="photo-box">
                    <div class="photo-btn">Pilih Foto</div>
                    <svg class="photo-icon" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
                    </svg>
                </div>
                <div class="info-texts">
                    <div class="req-notice">Tanda <span>*</span> wajib diisi!</div>
                    <div class="last-rm-notice">Nomor RM terakhir yang dimasukan MR000099</div>
                </div>
            </div>

            {{-- Row 1 --}}
            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label">Nama Lengkap <span class="req">*</span></label>
                    <input type="text" class="input-line">
                </div>
                <div class="form-group">
                    <label class="form-label">Nomor Medical Record</label>
                    <input type="text" class="input-line" placeholder="MR000100">
                </div>
            </div>

            {{-- Row 2 --}}
            <div class="grid-3">
                <div class="form-group">
                    <label class="form-label">Kota Tempat Lahir</label>
                    <input type="text" class="input-line">
                </div>
                <div class="form-group">
                    <label class="form-label">Tanggal Lahir <span class="req">*</span></label>
                    <div class="input-icon-wrapper">
                        <input type="date" class="input-line">
                        <svg class="icon-right" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                        </svg>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Nomor KTP</label>
                    <input type="text" class="input-line">
                </div>
            </div>

            {{-- Row 3 --}}
            <div class="grid-3">
                <div class="form-group">
                    <label class="form-label">Jenis Kelamin <span class="req">*</span></label>
                    <select class="input-pill">
                        <option>Laki - laki</option>
                        <option>Perempuan</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Agama <span class="req">*</span></label>
                    <select class="input-pill">
                        <option>Tidak Tahu</option>
                        <option>Islam</option>
                        <option>Kristen</option>
                        <option>Katolik</option>
                        <option>Hindu</option>
                        <option>Buddha</option>
                        <option>Konghucu</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Status <span class="req">*</span></label>
                    <select class="input-pill">
                        <option>Lainnya</option>
                        <option>Belum Kawin</option>
                        <option>Kawin</option>
                        <option>Cerai Hidup</option>
                        <option>Cerai Mati</option>
                    </select>
                </div>
            </div>

            {{-- Row 4 --}}
            <div class="grid-3">
                <div class="form-group">
                    <label class="form-label">Golongan Darah <span class="req">*</span></label>
                    <select class="input-pill">
                        <option>Tidak Tahu</option>
                        <option>A</option>
                        <option>B</option>
                        <option>AB</option>
                        <option>O</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Pendidikan Terakhir <span class="req">*</span></label>
                    <select class="input-pill">
                        <option>Lainnya</option>
                        <option>SD/Sederajat</option>
                        <option>SMP/Sederajat</option>
                        <option>SMA/Sederajat</option>
                        <option>D3</option>
                        <option>S1/D4</option>
                        <option>S2</option>
                        <option>S3</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Pekerjaan <span class="req">*</span></label>
                    <select class="input-pill">
                        <option>Lainnya</option>
                        <option>PNS</option>
                        <option>Wiraswasta</option>
                        <option>Karyawan Swasta</option>
                        <option>Pelajar/Mahasiswa</option>
                        <option>Belum Bekerja</option>
                    </select>
                </div>
            </div>

            {{-- Row 5 --}}
            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label">Nomor HP</label>
                    <div class="input-icon-wrapper">
                        <svg class="icon-left" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        <input type="text" class="input-line">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" class="input-line">
                </div>
            </div>

            {{-- Row 6 --}}
            <div class="grid-3" style="margin-bottom: 40px;">
                <div class="form-group">
                    <label class="form-label">Tanggal Pertama Chat</label>
                    <div class="input-icon-wrapper">
                        <input type="date" class="input-line">
                        <svg class="icon-right" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Tag Button --}}
            <button type="button" class="btn-add-tag">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                TAMBAH TAG
            </button>

        </div>
    </div>
</div>
@endsection