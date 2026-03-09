@extends('admin.layout.admin')
@section('title', 'Office')

@section('navbar')
    @include('admin.components.navbar', ['title' => 'Office'])
@endsection

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

    <style>
        .ofc-wrap,
        .ofc-wrap * {
            font-family: 'Instrument Sans', sans-serif;
            font-size: 13px;
            box-sizing: border-box;
        }

        .ofc-wrap {
            padding: 0;
        }

        .ofc-header {
            padding: 0px 0 20px;
        }

        .ofc-page-title {
            font-size: 30px;
            font-weight: 700;
            color: #582C0C;
            line-height: 1.2;
        }

        .ofc-page-subtitle {
            font-size: 18.75px;
            color: #C58F59;
        }

        .ofc-body {
            display: flex;
            gap: 20px;
            align-items: flex-start;
        }

        /* Sidebar */
        .ofc-sidebar {
            width: 200px;
            flex-shrink: 0;
            background: #fff;
            border: 1px solid #E5D6C5;
            border-radius: 8px;
            overflow: hidden;
        }

        .ofc-menu-item {
            display: block;
            padding: 12px 16px;
            font-size: 13px;
            color: #6B513E;
            text-decoration: none;
            border-bottom: 1px solid #E5D6C5;
            transition: background .15s;
        }

        .ofc-menu-item:last-child {
            border-bottom: none;
        }

        .ofc-menu-item:hover {
            background: rgba(197, 143, 89, .05);
            color: #582C0C;
        }

        .ofc-menu-item.active {
            background: #C58F59;
            color: #fff;
            font-weight: 600;
        }

        /* Main */
        .ofc-main {
            flex: 1;
            min-width: 0;
        }
    </style>

    <div class="ofc-wrap">

        <div class="ofc-header">
            <h1 class="ofc-page-title">Office</h1>
            <p class="ofc-page-subtitle">hanglekiu dental specialist</p>
        </div>

        <div class="ofc-body">

            {{-- Sidebar --}}
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
                    <div style="background:#fff; border:1px solid #E5D6C5; border-radius:8px; padding:16px; color:#6B513E;">
                        Menu office tidak ditemukan.
                    </div>
                @endif
            </div>

        </div>
    </div>

@endsection
