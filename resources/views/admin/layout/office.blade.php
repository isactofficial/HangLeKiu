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
                    <div class="ofc-error-box">
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