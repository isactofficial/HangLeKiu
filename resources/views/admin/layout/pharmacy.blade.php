@extends('admin.layout.admin')
@section('title', 'Apotek')

@php
    $menuList = [
        'antrian'          => 'Antrian Hari Ini',
        'obat'             => 'Obat',
        'penggunaan-obat'  => 'Penggunaan Obat',
        'kedaluwarsa-obat' => 'Kedaluwarsa Obat',
        'bhp'              => 'Bahan Habis Pakai',
        'penggunaan-bhp'   => 'Penggunaan BHP',
        'kedaluwarsa-bhp'  => 'Kedaluwarsa Bahan Habis Pakai',
        'resep'            => 'Resep Obat',
        'restock'          => 'Restock / Return',
        'depot'            => 'Depot',
        'pesanan'          => 'Pesanan & Stok Masuk',
    ];
    $active = request('menu', 'antrian');
@endphp

@section('navbar')
    @include('admin.components.navbar', ['title' => 'Apotek'])
@endsection

@section('content')

<style>
    .apt-container, .apt-container * { font-family: 'Instrument Sans', sans-serif; font-size: 13px; box-sizing: border-box; }
    .apt-date-full { font-size: 18.75px; font-weight: 700; }
    .apt-stat-number { font-size: 30px; font-weight: 700; }
    .apt-container { padding: 0 0 24px 0px; }

    /* Header */
    .apt-header { display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 20px; padding-top: 4px; }
    .apt-title    { color: #582C0C; margin: 0; line-height: 1; font-size: 30px; font-weight: 700}
    .apt-subtitle { font-size: 18.75px; color: #C58F59; margin: 4px 0 0 0; }
    .apt-container { padding: 0 0 24px 0px; }

    /* Header */
    .apt-header { display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 20px; padding-top: 4px; }
    .apt-title    { color: #582C0C; margin: 0; line-height: 1; font-size: 30px; font-weight: 700}
    .apt-subtitle { font-size: 18.75px; color: #C58F59; margin: 4px 0 0 0; }
    .apt-header-actions { display: flex; align-items: center; gap: 16px; }
    .apt-date-nav  { display: flex; align-items: center; gap: 10px; }
    .apt-date-text { display: flex; flex-direction: column; align-items: center; line-height: 1.2; }
    .apt-date-day  { font-weight: 700; color: #C58F59; }
    .apt-date-full { color: #582C0C; }
    .apt-icon-btn  { background: none; border: none; color: #C58F59; cursor: pointer; padding: 4px; line-height: 0; display: inline-flex; align-items: center; text-decoration: none; }
    .apt-icon-btn:hover { color: #582C0C; }
    .apt-refresh-btn { border: 1px solid #E5D6C5; border-radius: 6px; width: 34px; height: 34px; justify-content: center; background: #fff; }
    .apt-refresh-btn:hover { background: rgba(197,143,89,.06); border-color: #C58F59; }

    /* Layout */
    .apt-layout { display: flex; gap: 20px; align-items: flex-start; }
    .apt-main    { flex: 1; min-width: 0; }

    /* Sidebar */
    .apt-sidebar-wrapper { width: 232px; flex-shrink: 0; display: flex; flex-direction: column; gap: 14px; }
    .apt-sidebar { background: #fff; border: 1px solid #E5D6C5; border-radius: 8px; overflow: hidden; }
    .apt-menu { list-style: none; padding: 0; margin: 0; }
    .apt-menu-item { padding: 12px 18px; color: #6B513E; border-bottom: 1px solid #E5D6C5; cursor: pointer; transition: background .15s; display: block; text-decoration: none; }
    .apt-menu-item:last-child { border-bottom: none; }
    .apt-menu-item:hover  { background: rgba(197,143,89,.05); }
    .apt-menu-item.active { background: #C58F59; color: #fff; font-weight: 600; }

    /* Stat card */
    .apt-stat-card { background: #fff; border: 1px solid #E5D6C5; border-radius: 8px; padding: 14px; }
    .apt-stat-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 6px; }
    .apt-stat-number   { color: #582C0C; line-height: 1; }
    .apt-stat-title    { color: #582C0C; font-weight: 600; margin: 0 0 2px; }
    .apt-stat-subtitle { color: #10B981; margin: 0 0 10px; }
    .apt-progress-bar  { height: 10px; background: #E5D6C5; border-radius: 5px; overflow: hidden; }
    .apt-progress-fill { height: 100%; background: #C58F59; }

    /* Alert card */
    .apt-alert-card { background: #fff; border: 1px solid #E5D6C5; border-radius: 8px; overflow: hidden; }
    .apt-alert-header { background: #FEF2F2; padding: 10px 14px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #FEE2E2; }
    .apt-alert-title { font-weight: 600; color: #582C0C; }
    .apt-alert-link  { display: block; padding: 10px 14px; color: #C58F59; text-decoration: none; font-weight: 500; }
    .apt-alert-link:hover { text-decoration: underline; }
</style>

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
                    <span class="apt-date-day">Kamis</span>
                    <span class="apt-date-full">5 Maret 2026</span>
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
                <div style="background:#fff;border:1px solid #E5D6C5;border-radius:8px;padding:20px;color:#6B513E;">
                    Konten menu <strong>{{ $active }}</strong> belum tersedia.
                </div>
            @endif
        </div>

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
</script>

@endsection
