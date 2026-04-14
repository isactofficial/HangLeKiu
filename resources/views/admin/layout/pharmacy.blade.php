@extends('admin.layout.admin')
@section('title', 'Apotek')

@section('navbar')
    @include('admin.components.navbar', ['title' => 'Apotek'])
@endsection

@php
    $menuList = [
        'obat'             => 'Obat',
        'penggunaan-obat'  => 'Penggunaan Obat',
        'bhp'              => 'Bahan Habis Pakai',
        'penggunaan-bhp'   => 'Penggunaan BHP',
        'restock'          => 'Restock / Return',
    ];
    $active = request('menu', 'obat');
@endphp

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/layout/pharmacy.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pharmacy-mobile.css') }}">
@endpush

@section('content')

<div class="apt-container">

    <div class="apt-header">
        <div>
            <h1 class="apt-title">Apotek</h1>
            <p class="apt-subtitle">hanglekiu dental specialist</p>
        </div>
        <div class="apt-header-actions">
            <div class="apt-date-nav">
                <a href="#" class="apt-icon-btn">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M15 18l-6-6 6-6"/></svg>
                </a>
                <div class="apt-date-text">
                    <span class="apt-date-day">
                        {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l') }}
                    </span>

                    <span class="apt-date-full">
                    {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('j F Y') }}
                </span>
                </div>
                <a href="#" class="apt-icon-btn">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 18l6-6-6-6"/></svg>
                </a>
            </div>
            <a href="#" class="apt-icon-btn apt-refresh-btn" title="Refresh">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182M21.015 4.353v4.992"/>
                </svg>
            </a>
        </div>
    </div>

    {{-- Mobile Stat Cards Section (visible only in mobile) --}}
    <div class="apt-mobile-stats-section">
        <div class="apt-mobile-stats-scroll">
            <div class="apt-stat-card">
                <div class="apt-stat-header">
                    <span class="apt-stat-number">12</span>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#A38C7A" stroke-width="1.8">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                </div>
                <p class="apt-stat-title">Total Antrian Hari Ini</p>
                <p class="apt-stat-subtitle">8 sudah ditangani</p>
                <div class="apt-progress-bar">
                    <div class="apt-progress-fill" style="width:67%;"></div>
                </div>
            </div>

            <div class="apt-alert-card">
                <div class="apt-alert-header">
                    <span class="apt-alert-title">Peringatan Stok</span>
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="#EF4444"><path d="M12 2L1 21h22L12 2zm0 3.5L20.5 19h-17L12 5.5zM11 10v4h2v-4h-2zm0 6v2h2v-2h-2z"/></svg>
                </div>
                <a href="?menu=restock" class="apt-alert-link">Restock</a>
            </div>
        </div>
    </div>

    {{-- Mobile Menu Section (visible only in mobile) --}}
    <div class="apt-mobile-menu-section">
        <div class="apt-mobile-menu-header">
            <span>{{ $menuList[$active] ?? 'Menu' }}</span>
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
            </svg>
        </div>
        <div class="apt-mobile-menu-dropdown">
            <ul class="apt-mobile-menu-list">
                @foreach ($menuList as $key => $label)
                    <li>
                        <a href="?menu={{ $key }}" class="apt-mobile-menu-item {{ $active === $key ? 'active' : '' }}">
                            {{ $label }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="apt-layout">

        <div class="apt-sidebar-wrapper">
            <div class="apt-sidebar">
                <ul class="apt-menu">
                    @foreach ($menuList as $key => $label)
                        <li>
                            <a href="?menu={{ $key }}" class="apt-menu-item {{ $active === $key ? 'active' : '' }}">
                                {{ $label }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="apt-alert-card">
                <div class="apt-alert-header">
                    <span class="apt-alert-title">Peringatan Stok</span>
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="#EF4444"><path d="M12 2L1 21h22L12 2zm0 3.5L20.5 19h-17L12 5.5zM11 10v4h2v-4h-2zm0 6v2h2v-2h-2z"/></svg>
                </div>
                <a href="?menu=restock" class="apt-alert-link">Restock</a>
            </div>
        </div>

        
        <div class="apt-main">
            @php
                $pharmacyView = 'admin.components.pharmacy.' . $active;
                $legacyView = 'admin.components.' . $active;
            @endphp

            @if (view()->exists($pharmacyView))
                @include($pharmacyView)
            @elseif (view()->exists($legacyView))
                @include($legacyView)
            @else
                <div class="apt-error-box">
                    Konten menu <strong>{{ $active }}</strong> belum tersedia.
                </div>
            @endif
        </div>

    </div>
</div>

{{-- Modal Konfirmasi Hapus (shared) --}}
<div id="modalKonfirmasiHapus" class="modal-overlay" style="z-index:9999;">
    <div style="background:white;border-radius:20px;padding:36px 32px;max-width:360px;width:90%;text-align:center;box-shadow:0 20px 60px rgba(0,0,0,0.15);">
        
        {{-- Icon trash dengan dekorasi --}}
        <div style="position:relative;display:inline-flex;align-items:center;justify-content:center;margin-bottom:20px;">
            <div style="width:72px;height:72px;border-radius:50%;background:#FEE2E2;display:flex;align-items:center;justify-content:center;">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#DC2626" stroke-width="1.8">
                    <polyline points="3 6 5 6 21 6"/>
                    <path d="M19 6l-1 14H6L5 6"/>
                    <path d="M10 11v6M14 11v6"/>
                    <path d="M9 6V4h6v2"/>
                </svg>
            </div>
            {{-- Dekorasi titik-titik --}}
            <span style="position:absolute;top:-4px;left:-4px;color:#FCA5A5;font-size:10px;">✕</span>
            <span style="position:absolute;top:-4px;right:-4px;color:#FCA5A5;font-size:10px;">✕</span>
            <span style="position:absolute;bottom:-4px;right:-8px;color:#FCA5A5;font-size:10px;">✕</span>
        </div>

        {{-- Teks --}}
        <h3 style="font-size:16px;font-weight:700;color:#111827;margin:0 0 8px;font-family:'Instrument Sans',sans-serif;">
            Yakin ingin menghapus?
        </h3>
        <p id="hapusModalPesan" style="font-size:13px;color:#6B7280;margin:0 0 28px;line-height:1.6;font-family:'Instrument Sans',sans-serif;"></p>

        {{-- Tombol --}}
        <button id="hapusModalKonfirm" class="modal-btn" 
            style="width:100%;padding:12px;background:#DC2626;color:white;border:none;border-radius:10px;font-size:14px;font-weight:600;cursor:pointer;margin-bottom:10px;font-family:'Instrument Sans',sans-serif;">
            Ya, Hapus
        </button>
        <button id="hapusModalBatal" 
            style="width:100%;padding:10px;background:none;border:none;color:#6B7280;font-size:13px;cursor:pointer;font-family:'Instrument Sans',sans-serif;font-weight:500;">
            Batal
        </button>
    </div>
</div>

<script>
// Toggle Mobile Menu Dropdown
document.addEventListener('DOMContentLoaded', function() {
    const menuHeader = document.querySelector('.apt-mobile-menu-header');
    const menuDropdown = document.querySelector('.apt-mobile-menu-dropdown');
    
    if (menuHeader && menuDropdown) {
        menuHeader.addEventListener('click', function() {
            menuDropdown.classList.toggle('show');
            
            // Rotate arrow icon
            const arrow = this.querySelector('svg');
            if (menuDropdown.classList.contains('show')) {
                arrow.style.transform = 'rotate(180deg)';
            } else {
                arrow.style.transform = 'rotate(0deg)';
            }
        });

        // Close dropdown when menu item clicked
        const menuItems = document.querySelectorAll('.apt-mobile-menu-item');
        menuItems.forEach(item => {
            item.addEventListener('click', function() {
                menuDropdown.classList.remove('show');
                const arrow = menuHeader.querySelector('svg');
                arrow.style.transform = 'rotate(0deg)';
            });
        });
    }
});

// Dropdown functionality
document.addEventListener('click', function(e) {
    const trigger = e.target.closest('[data-dropdown-trigger]');
    if (trigger) {
        e.stopPropagation();
        const menu = trigger.closest('.apt-dropdown').querySelector('.apt-dropdown-menu');
        document.querySelectorAll('.apt-dropdown-menu.open').forEach(m => { if (m !== menu) m.classList.remove('open'); });
        menu.classList.toggle('open');
        return;
    }
    document.querySelectorAll('.apt-dropdown-menu.open').forEach(m => m.classList.remove('open'));
});

// Modal Hapus 
function konfirmasiHapus(pesan, onKonfirm) {
    const modal      = document.getElementById('modalKonfirmasiHapus');
    const pesanEl    = document.getElementById('hapusModalPesan');
    const btnBatal   = document.getElementById('hapusModalBatal');
    const btnKonfirm = document.getElementById('hapusModalKonfirm');

    pesanEl.textContent = pesan;
    modal.classList.add('open');

    const newKonfirm = btnKonfirm.cloneNode(true);
    btnKonfirm.parentNode.replaceChild(newKonfirm, btnKonfirm);

    const tutup = () => modal.classList.remove('open');
    btnBatal.onclick = tutup;
    modal.onclick = (e) => { if (e.target === modal) tutup(); };
    newKonfirm.onclick = () => { tutup(); onKonfirm(); };
}

</script>

@endsection