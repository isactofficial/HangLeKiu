@extends('admin.layout.admin')
@section('title', 'Apotek')

@section('navbar')
    @include('admin.components.navbar', ['title' => 'Apotek'])
@endsection

@section('content')

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

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/layout/pharmacy.css') }}">
@endpush

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
                <div class="apt-error-box">
                    Konten menu <strong>{{ $active }}</strong> belum tersedia.
                </div>
            @endif
        </div>

    </div>
</div>

<script>
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
