@extends('admin.layout.admin')
@section('title', 'Settings')

@section('navbar')
    @include('admin.components.navbar', ['title' => 'Settings'])
@endsection

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

    <style>
        .stg-wrap,
        .stg-wrap * {
            font-size: 13px;
            box-sizing: border-box;
        }

        .stg-wrap {
            padding: 0;
        }

        .stg-header {
            padding: 0 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .stg-page-title {
            font-size: 30px;
            font-weight: 700;
            color: #582C0C;
            line-height: 1.2;
        }

        .stg-page-subtitle {
            font-size: 18.75px;
            color: #C58F59;
        }

        .stg-refresh-btn {
            width: 34px;
            height: 34px;
            border: 1.5px solid #E5D6C5;
            border-radius: 6px;
            background: #fff;
            color: #C58F59;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all .2s;
        }

        .stg-refresh-btn:hover {
            border-color: #C58F59;
            background: rgba(197, 143, 89, .05);
        }

        .stg-body {
            display: flex;
            gap: 20px;
            align-items: flex-start;
        }

        /* Sidebar */
        .stg-sidebar {
            width: 200px;
            flex-shrink: 0;
            background: #fff;
            border: 1px solid #E5D6C5;
            border-radius: 8px;
            overflow: hidden;
        }

        .stg-menu-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 16px;
            font-size: 13px;
            color: #6B513E;
            text-decoration: none;
            border-bottom: 1px solid #E5D6C5;
            transition: background .15s;
        }

        .stg-menu-item:last-child {
            border-bottom: none;
        }

        .stg-menu-item:hover {
            background: rgba(197, 143, 89, .05);
            color: #582C0C;
        }

        .stg-menu-item.active {
            background: #C58F59;
            color: #fff;
            font-weight: 600;
        }

        .stg-menu-badge {
            background: #EF4444;
            color: #fff;
            font-size: 11px;
            font-weight: 700;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .stg-menu-item.active .stg-menu-badge {
            background: #fff;
            color: #EF4444;
        }

        /* Main */
        .stg-main {
            flex: 1;
            min-width: 0;
        }
    </style>

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
                    <div style="background:#fff;border:1px solid #E5D6C5;border-radius:8px;padding:16px;color:#6B513E;">
                        Menu settings <strong>{{ $active }}</strong> belum tersedia.
                    </div>
                @endif
            </div>

        </div>
    </div>

@endsection
