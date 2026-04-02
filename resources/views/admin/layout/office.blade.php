@extends('admin.layout.admin')
@section('title', 'Office')

@section('navbar')
    @include('admin.components.navbar', ['title' => 'Office'])
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/layout/office.css') }}">
@endpush

@section('content')

    @php
        $menuItems = [
            'dashboard-harian' => 'Dashboard Harian',
            'keuangan' => 'Keuangan',
            'laporan' => 'Laporan',
            'pasien' => 'Pasien',
            'akun' => 'Akun',
        ];
        $active = request('menu', 'dashboard-harian');
    @endphp

    <div class="ofc-wrap">

        <div class="ofc-header">
            <h1 class="ofc-page-title">Office</h1>
            <p class="ofc-page-subtitle">hanglekiu dental specialist</p>
        </div>

        <div class="ofc-body">

            {{-- Sidebar Desktop --}}
            <div class="ofc-sidebar">
                @foreach ($menuItems as $key => $label)
                    <a href="?menu={{ $key }}" class="ofc-menu-item {{ $active === $key ? 'active' : '' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </div>

            {{-- Sub-view --}}
            <div class="ofc-main">
                @php
                    $officeView = 'admin.components.office.' . str_replace('-', '_', $active);
                @endphp

                @if (view()->exists($officeView))
                    @include($officeView)
                @else
                    <div class="ofc-error-box">
                        Menu office tidak ditemukan.
                    </div>
                @endif
            </div>

        </div>
    </div>

@endsection