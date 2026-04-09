@extends('admin.layout.admin')
@section('title', 'Settings')

@section('navbar')
    @include('admin.components.navbar', ['title' => 'Settings'])
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/layout/settings.css') }}">
@endpush

@section('content')

    @php
$menuItems = [
            'general-settings' => 'General Settings',
            'manajemen-staff' => 'Manajemen Staff',
            'hak-akses' => 'Hak Akses',
            'info-tenaga-medis' => 'Info Tenaga Medis',
        ];
        $active = request('menu', 'general-settings');
    @endphp

    <div class="stg-wrap">

        <div class="stg-header">
            <div>
                <h1 class="stg-page-title">Settings</h1>
                <p class="stg-page-subtitle">hanglekiu dental specialist</p>
            </div>
            <button class="stg-refresh-btn" title="Refresh">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182" />
                </svg>
            </button>
        </div>

        <div class="stg-body">

            {{-- Sidebar --}}
            <div class="stg-sidebar">
                @foreach ($menuItems as $key => $label)
                    <a href="?menu={{ $key }}" class="stg-menu-item {{ $active === $key ? 'active' : '' }}">
                        <span>{{ $label }}</span>
                        @if ($key === 'billing')
                            <span class="stg-menu-badge">1</span>
                        @endif
                    </a>
                @endforeach
            </div>

            {{-- Sub-view --}}
            <div class="stg-main">
                @php
                    $settingsView = 'admin.components.settings.' . str_replace('-', '_', $active);
                @endphp

                @if (view()->exists($settingsView))
                    @include($settingsView)
                @else
                    <div class="stg-error-box">
                        Menu settings <strong>{{ $active }}</strong> belum tersedia.
                    </div>
                @endif
            </div>

        </div>
    </div>

@endsection
