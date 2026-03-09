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
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        * { 
            margin: 0; 
            padding: 0; 
            box-sizing: border-box; 
        }

        body {
            font-family: 'Instrument Sans', sans-serif;
            background-color: var(--color-background-primary, #F7F7F7);
            color: var(--font-color-primary, #582C0C);
            min-height: 100vh;
        }


        .admin-content {
            margin-left: 72px; 
            min-height: 100vh;
            padding: 28px 32px;
            transition: margin-left 0.3s ease;
        }

        /* Sidebar Overlay */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background-color: rgba(0, 0, 0, 0.4);
            z-index: 99;
            backdrop-filter: blur(2px);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .sidebar-overlay.show {
            display: block;
            opacity: 1;
        }

        @media (max-width: 768px) {
            .admin-content {
                margin-left: 0;
                padding: 16px;
                padding-top: 24px;
            }
        }

        .admin-topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 28px;
        }

        .admin-topbar h1 {
            font-size: 24px;
            font-weight: 700;
        }

        .admin-topbar .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .admin-topbar .user-info span {
            font-weight: 500;
        }

        .admin-topbar .avatar {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background-color: var(--color-primary, #C58F59);
            color: var(--color-background-primary, #FFF);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
        }

        .admin-card {
            background-color: white;
            border-radius: 16px;
            padding: 28px;
            box-shadow: 0 1px 3px rgba(88, 44, 12, 0.06);
        }

    </style>
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