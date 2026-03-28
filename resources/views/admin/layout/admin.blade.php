<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Dashboard') — Hanglekiu Dental</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/admin/layout/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/components/sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/components/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/components/navbarSearch.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/components/navbarPendaftaranBaru.css') }}">
    @stack('styles')
</head>
<body>
    
    @include('admin.components.sidebar')

    {{-- Overlay untuk mode seluler --}}
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    <main class="admin-content">
        
        @hasSection('navbar')
            @yield('navbar')
        @else
            <div class="admin-topbar">
                <h1>@yield('title', 'Dashboard')</h1>
                <div class="user-info">
                    <span>{{ Auth::check() ? Auth::user()->name : 'Admin' }}</span>
                    <div class="avatar">{{ Auth::check() ? strtoupper(substr(Auth::user()->name, 0, 1)) : 'A' }}</div>
                </div>
            </div>
        @endif

        @yield('content')
        
    </main>

    <script>
        function toggleSidebar() {
            document.body.classList.toggle('sidebar-open');
            const overlay = document.getElementById('sidebarOverlay');
            if (document.body.classList.contains('sidebar-open')) {
                overlay.style.display = 'block';
                setTimeout(() => overlay.classList.add('show'), 10);
            } else {
                overlay.classList.remove('show');
                setTimeout(() => overlay.style.display = 'none', 300);
            }
        }
    </script>
</body>
</html>