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
    @vite([
        'resources/css/app.css',
        'resources/css/topbar.css',
        'resources/css/sidebar-mobile.css',
        'resources/css/pharmacy-mobile.css',
        'resources/js/app.js'
    ])
    
    @stack('styles')
    
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

        /* ── TAMBAHAN MOBILE ── */
        @media (max-width: 768px) {
            .admin-content {        
                margin-left: 0 !important;        
                padding: 16px;        
                overflow-x: hidden;    
            }
        }
    </style>
</head>
<body>
    
    @include('admin.components.sidebar')

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

    {{-- Admin Sidebar Overlay for Mobile --}}
    <div class="admin-sidebar-overlay" id="adminSidebarOverlay" onclick="toggleAdminSidebar()"></div>

    <script>
        // Toggle Admin Sidebar (Mobile)
        function toggleAdminSidebar() {
            const sidebar = document.querySelector('.sidebar');
            const overlay = document.getElementById('adminSidebarOverlay');
            
            if (sidebar && overlay) {
                sidebar.classList.toggle('show');
                overlay.classList.toggle('show');
                
                // Prevent body scroll when sidebar is open
                if (sidebar.classList.contains('show')) {
                    document.body.style.overflow = 'hidden';
                } else {
                    document.body.style.overflow = '';
                }
            }
        }

        // Close sidebar when clicking menu item (mobile only)
        if (window.innerWidth <= 768) {
            document.addEventListener('DOMContentLoaded', function() {
                const sidebarItems = document.querySelectorAll('.sidebar-item');
                
                sidebarItems.forEach(item => {
                    item.addEventListener('click', function() {
                        const sidebar = document.querySelector('.sidebar');
                        const overlay = document.getElementById('adminSidebarOverlay');
                        
                        if (sidebar && overlay && sidebar.classList.contains('show')) {
                            sidebar.classList.remove('show');
                            overlay.classList.remove('show');
                            document.body.style.overflow = '';
                        }
                    });
                });
            });
        }
    </script>

</body>
</html>