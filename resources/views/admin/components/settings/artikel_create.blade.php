@extends('admin.layout.admin')
@section('title', 'Tambah Artikel - Settings')

@section('navbar')
    @include('admin.components.navbar', ['title' => 'Settings - Tambah Artikel'])
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/layout/settings.css') }}">
    <style>
        .form-card {
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        }
        .form-group { margin-bottom: 20px; }
        .form-label {
            display: block;
            font-weight: 700;
            color: var(--font-color-primary);
            margin-bottom: 8px;
            font-size: 14px;
        }
        .form-input {
            width: 100%;
            padding: 12px 16px;
            border: 1.5px solid #eee;
            border-radius: 12px;
            transition: all 0.3s ease;
        }
        .form-input:focus {
            border-color: var(--color-primary);
            outline: none;
            box-shadow: 0 0 0 4px rgba(193, 139, 81, 0.1);
        }
        .image-preview {
            width: 100%;
            max-height: 250px;
            object-fit: cover;
            border-radius: 12px;
            margin-top: 10px;
            display: none;
            border: 1px solid #eee;
        }
        .btn-save {
            background: var(--color-primary);
            color: white;
            padding: 12px 24px;
            border-radius: 12px;
            font-weight: 700;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .btn-back {
            color: #666;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 20px;
        }
    </style>
@endpush

@section('content')
<div class="stg-wrap">
    <div class="stg-header">
        <div>
            <h1 class="stg-page-title">Settings</h1>
            <p class="stg-page-subtitle">Tambah Artikel Baru</p>
        </div>
    </div>

    <div class="stg-body">
        {{-- Sidebar --}}
        <div class="stg-sidebar">
            <a href="{{ route('admin.settings', ['menu' => 'general-settings']) }}" class="stg-menu-item active">
                <span>General Settings</span>
            </a>
            <a href="{{ route('admin.settings', ['menu' => 'manajemen-staff']) }}" class="stg-menu-item">
                <span>Manajemen Staff</span>
            </a>
            <a href="{{ route('admin.settings', ['menu' => 'hak-akses']) }}" class="stg-menu-item">
                <span>Hak Akses</span>
            </a>
            <a href="{{ route('admin.settings', ['menu' => 'info-tenaga-medis']) }}" class="stg-menu-item">
                <span>Info Tenaga Medis</span>
            </a>
        </div>

        <div class="stg-main">
            <a href="{{ route('admin.settings', ['menu' => 'general-settings', 'submenu' => 'Artikel']) }}" class="btn-back">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M19 12H5M12 19l-7-7 7-7"/>
                </svg>
                Kembali
            </a>

            <div class="form-card">
                <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div class="form-group" style="grid-column: span 2;">
                            <label class="form-label">Judul Artikel</label>
                            <input type="text" name="title" class="form-input" placeholder="Masukkan judul..." required value="{{ old('title') }}">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Kategori</label>
                            <select name="category" class="form-input" required>
                                <option value="" disabled selected>Pilih Kategori</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat }}" {{ old('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group" style="grid-column: span 2;">
                            <label class="form-label">Ringkasan</label>
                            <textarea name="description" class="form-input" rows="2" required placeholder="Tampilkan di card...">{{ old('description') }}</textarea>
                        </div>

                        <div class="form-group" style="grid-column: span 2;">
                            <label class="form-label">Isi Konten</label>
                            <textarea name="content" class="form-input" rows="8" required placeholder="Konten artikel lengkap...">{{ old('content') }}</textarea>
                        </div>

                        <div class="form-group" style="grid-column: span 2;">
                            <label class="form-label">Gambar Thumbnail</label>
                            <input type="file" name="image" id="imageInput" class="form-input" accept="image/*" required>
                            <img id="imagePreview" class="image-preview" src="#" alt="Preview">
                        </div>
                    </div>

                    <div style="margin-top: 30px; display: flex; gap: 15px;">
                        <button type="submit" class="btn-save">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/>
                                <path d="M17 21v-8H7v8M7 3v5h8"/>
                            </svg>
                            Simpan Artikel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('imageInput').onchange = function (evt) {
        const [file] = this.files;
        if (file) {
            const preview = document.getElementById('imagePreview');
            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
        }
    }
</script>
@endsection
