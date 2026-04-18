@extends('admin.layout.admin')
@section('title', 'Profil Klinik')

@section('navbar')
    @include('admin.components.navbar', ['title' => 'Profil Klinik'])
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/pages/profile.css') }}">
    <style>
        .form-section { background: white; padding: 2rem; border-radius: 1rem; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); margin-bottom: 2rem; }
        .form-group { margin-bottom: 1.5rem; }
        .form-label { display: block; font-weight: 600; color: #374151; margin-bottom: 0.5rem; }
        .form-control { width: 100%; padding: 0.75rem; border: 1px solid #D1D5DB; border-radius: 0.5rem; font-size: 0.875rem; }
        .form-control:focus { outline: none; border-color: #C18B51; ring: 2px ring-color: #C18B51; }
        .grid-hours { display: grid; grid-template-columns: 1fr 2fr; gap: 1rem; align-items: center; margin-bottom: 0.5rem; }
        .btn-submit { background: #582C0C; color: white; padding: 0.75rem 2rem; border-radius: 0.5rem; font-weight: 600; cursor: pointer; border: none; transition: background 0.2s; }
        .btn-submit:hover { background: #3d1f08; }
        .alert-success { background: #DEF7EC; color: #03543F; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem; transition: all 0.5s ease; border-left: 4px solid #059669; }
        .logo-preview { width: 150px; height: 150px; object-fit: contain; border: 1px solid #E5E7EB; border-radius: 0.5rem; margin-bottom: 1rem; background: white; transition: all 0.3s ease; }
        .logo-preview:hover { transform: scale(1.02); }
    </style>
@endpush

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="profile-header mb-8">
        <h1 class="text-3xl font-bold text-[#582C0C]">Pengaturan Profil Klinik</h1>
        <p class="text-gray-600">Kelola informasi publik klinik Anda</p>
    </div>

    @if(session('success'))
        <div id="success-alert" class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Bagian Kiri: Identitas Klinik --}}
            <div class="lg:col-span-2">
                <div class="form-section">
                    <h2 class="text-xl font-semibold mb-6 border-b pb-2">Informasi Umum</h2>
                    
                    <div class="form-group">
                        <label class="form-label">Nama Klinik</label>
                        <input type="text" name="name" class="form-control" value="{{ $profile->name }}" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Alamat Lengkap</label>
                        <textarea name="address" rows="3" class="form-control">{{ $profile->address }}</textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Nomor Telepon / WhatsApp</label>
                        <input type="text" name="phone" class="form-control" value="{{ $profile->phone }}">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Ringkasan Jam Operasional (Public)</label>
                        <textarea name="operational_summary" rows="2" class="form-control" placeholder="Contoh: Senin - Jumat: 10.00 - 19.00">{{ $profile->operational_summary }}</textarea>
                    </div>
                </div>

                <div class="form-section">
                    <h2 class="text-xl font-semibold mb-6 border-b pb-2">Detail Jam Operasional Mingguan</h2>
                    
                    @php
                        $days = [
                            'monday' => 'Senin',
                            'tuesday' => 'Selasa',
                            'wednesday' => 'Rabu',
                            'thursday' => 'Kamis',
                            'friday' => 'Jumat',
                            'saturday' => 'Sabtu',
                            'sunday' => 'Minggu'
                        ];
                    @endphp

                    @foreach($days as $key => $label)
                        <div class="grid-hours">
                            <span class="font-medium text-gray-700">{{ $label }}</span>
                            <input type="text" name="operational_hours[{{ $key }}]" class="form-control" 
                                   value="{{ $profile->operational_hours[$key] ?? '' }}" placeholder="Contoh: 10.00 - 19.00 atau Tutup">
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Bagian Kanan: Logo --}}
            <div class="lg:col-span-1">
                <div class="form-section flex flex-col items-center">
                    <h2 class="text-xl font-semibold mb-6 border-b pb-2 w-full text-center">Logo Klinik</h2>
                    
                    <div id="logo-container" class="flex flex-col items-center">
                        @if($profile->logo)
                            <img id="logo-preview-img" src="{{ asset('storage/' . $profile->logo) }}" alt="Logo Klinik" class="logo-preview">
                        @else
                            <div id="logo-preview-placeholder" class="logo-preview flex items-center justify-center text-gray-400 bg-gray-50">
                                <span class="text-xs">No Logo</span>
                            </div>
                        @endif
                        
                        <div class="mt-4 w-full">
                            <label class="form-label text-center">Upload Logo Baru</label>
                            <input type="file" name="logo" id="logo-input" class="form-control text-sm" accept="image/*">
                            <p class="text-xs text-center text-gray-500 mt-2">Format: PNG, JPG, WebP (Maks 2MB)</p>
                        </div>
                    </div>
                </div>

                <div class="mt-6">
                    <button type="submit" class="btn-submit w-full shadow-lg">Simpan Perubahan</button>
                    <p class="text-center text-xs text-gray-500 mt-4">Terakhir diperbarui: {{ $profile->updated_at->format('d M Y H:i') }}</p>
                </div>
            </div>
        </div>
    </form>
</div>
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-hide alert after 2 seconds
        const successAlert = document.getElementById('success-alert');
        if (successAlert) {
            setTimeout(() => {
                successAlert.style.opacity = '0';
                successAlert.style.transform = 'translateY(-10px)';
                setTimeout(() => {
                    successAlert.remove();
                }, 500);
            }, 2000); // 2 seconds instead of 3
        }

        // Logo instant preview
        const logoInput = document.getElementById('logo-input');
        if (logoInput) {
            logoInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const placeholder = document.getElementById('logo-preview-placeholder');
                        const currentImg = document.getElementById('logo-preview-img');

                        if (placeholder) {
                            const img = document.createElement('img');
                            img.id = 'logo-preview-img';
                            img.src = e.target.result;
                            img.alt = 'Logo Klinik';
                            img.className = 'logo-preview';
                            img.style.opacity = '0';
                            placeholder.parentNode.replaceChild(img, placeholder);
                            setTimeout(() => img.style.opacity = '1', 10);
                        } else if (currentImg) {
                            currentImg.style.opacity = '0.5';
                            setTimeout(() => {
                                currentImg.src = e.target.result;
                                currentImg.style.opacity = '1';
                            }, 150);
                        }
                    }
                    reader.readAsDataURL(file);
                }
            });
        }
    });
</script>
@endpush
@endsection
