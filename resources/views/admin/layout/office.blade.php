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

        .ofc-wrap { padding: 0; }
        .ofc-header { padding: 0px 0 20px; }
        .ofc-page-title { font-size: 30px; font-weight: 700; color: #582C0C; line-height: 1.2; }
        .ofc-page-subtitle { font-size: 18.75px; color: #C58F59; }

        .ofc-body {
            display: flex;
            gap: 20px;
            align-items: flex-start;
        }

        /* ── Sidebar ── */
        .ofc-sidebar {
            width: 200px;
            flex-shrink: 0;
            background: #fff;
            border: 1px solid #E5D6C5;
            border-radius: 8px;
            overflow: hidden;
        }

        /* Desktop: list vertikal */
        .ofc-menu-item {
            display: block;
            padding: 12px 16px;
            font-size: 13px;
            color: #6B513E;
            text-decoration: none;
            border-bottom: 1px solid #E5D6C5;
            transition: background .15s;
        }
        .ofc-menu-item:last-child { border-bottom: none; }
        .ofc-menu-item:hover { background: rgba(197,143,89,.05); color: #582C0C; }
        .ofc-menu-item.active { background: #C58F59; color: #fff; font-weight: 600; }

        /* Select dropdown — hidden di desktop */
        .ofc-select { display: none; position: relative; width: 100%; }

        .ofc-select-trigger {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 14px;
            background: #fff;
            border: 1px solid #E5D6C5;
            border-radius: 8px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 600;
            color: #582C0C;
            transition: border-color .15s, box-shadow .15s;
            user-select: none;
        }
        .ofc-select-trigger:hover { border-color: #C58F59; }
        .ofc-select-trigger.open { border-color: #C58F59; box-shadow: 0 0 0 3px rgba(197,143,89,.15); border-radius: 8px 8px 0 0; }
        .ofc-select-trigger svg { flex-shrink: 0; transition: transform .2s; color: #C58F59; }
        .ofc-select-trigger.open svg { transform: rotate(180deg); }

        .ofc-select-options {
            display: none;
            position: absolute;
            top: 100%; left: 0; right: 0;
            background: #fff;
            border: 1px solid #C58F59;
            border-top: none;
            border-radius: 0 0 8px 8px;
            z-index: 50;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(88,44,12,.10);
        }
        .ofc-select-options.show { display: block; }

        .ofc-select-option {
            display: block;
            padding: 10px 14px;
            font-size: 13px;
            color: #6B513E;
            text-decoration: none;
            border-bottom: 1px solid #F3EDE6;
            transition: background .15s;
        }
        .ofc-select-option:last-child { border-bottom: none; }
        .ofc-select-option:hover { background: rgba(197,143,89,.08); color: #582C0C; }
        .ofc-select-option.active { background: #FDF3E8; color: #582C0C; font-weight: 600; }

        /* ── Main ── */
        .ofc-main { flex: 1; min-width: 0; padding-top: 12px; }

        /* Mobile */
        @media (max-width: 768px) {
            .ofc-page-title { font-size: 30px; }
            .ofc-page-subtitle { font-size: 18.75px; }
            .ofc-header { padding-bottom: 14px; }
            .ofc-body { flex-direction: column; gap: 14px; }
            .ofc-main { padding-top: 0; }
            .ofc-sidebar {
                width: 100%;
                background: none;
                border: none;
                border-radius: 0;
                overflow: visible;
            }
            .ofc-menu-item { display: none; }
            .ofc-select { display: block; }
        }
    </style>

    <div class="ofc-wrap">

        <div class="ofc-header">
            <h1 class="ofc-page-title">Office</h1>
            <p class="ofc-page-subtitle">hanglekiu dental specialist</p>
        </div>

        <div class="ofc-body">

            {{-- Sidebar: desktop = list, mobile = select --}}
            <div class="ofc-sidebar">
                {{-- Desktop list --}}
                @foreach ($menuItems as $key => $label)
                    <a href="?menu={{ $key }}" class="ofc-menu-item {{ $active === $key ? 'active' : '' }}">
                        {{ $label }}
                    </a>
                @endforeach

                {{-- Mobile select --}}
                <div class="ofc-select" id="ofcSelect">
                    <div class="ofc-select-trigger" onclick="toggleOfcSelect()">
                        <span>{{ $menuItems[$active] }}</span>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                        </svg>
                    </div>
                    <div class="ofc-select-options" id="ofcSelectOptions">
                        @foreach ($menuItems as $key => $label)
                            <a href="?menu={{ $key }}" class="ofc-select-option {{ $active === $key ? 'active' : '' }}">
                                {{ $label }}
                            </a>
                        @endforeach
                    </div>
                </div>
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

<script>
    function toggleOfcSelect() {
        const trigger = document.querySelector('.ofc-select-trigger');
        const options = document.getElementById('ofcSelectOptions');
        trigger.classList.toggle('open');
        options.classList.toggle('show');
    }

    document.addEventListener('click', function(e) {
        if (!e.target.closest('#ofcSelect')) {
            document.querySelector('.ofc-select-trigger')?.classList.remove('open');
            document.getElementById('ofcSelectOptions')?.classList.remove('show');
        }
    });
</script>

@endsection