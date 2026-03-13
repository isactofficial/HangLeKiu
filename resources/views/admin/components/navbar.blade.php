{{-- Navbar Component --}}
{{-- Usage: @include('admin.components.navbar', ['title' => 'Page Title']) --}}

@props(['title' => ''])

<header class="admin-navbar">
    {{-- Hamburger Button (Mobile Only) --}}
    <button class="navbar-hamburger" onclick="toggleAdminSidebar()" aria-label="Toggle Menu">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
    </button>

    {{-- Right: Actions --}}
    <div class="navbar-right">
        {{-- HDS Logo --}}
        <div class="navbar-hds-logo">
            <img src="/images/logo-hds.png" alt="HDS">
        </div>

        {{-- Clinic Dropdown --}}
        <div class="navbar-dropdown" id="clinicDropdown">
            <button class="navbar-dropdown-btn" onclick="toggleDropdown('clinicMenu')">
                <span>hanglekiu dent...</span>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                </svg>
            </button>
            {{-- Dropdown menu --}}
            <div class="navbar-dropdown-menu" id="clinicMenu">
                <a href="#" class="dropdown-item active">Hanglekiu Dental Clinic</a>
                <a href="#" class="dropdown-item">Cabang Kemang</a>
                <a href="#" class="dropdown-item">Cabang Sudirman</a>
            </div>
        </div>

        {{-- Divider --}}
        <div class="navbar-divider"></div>

        {{-- Mobile Divider (before icons) --}}
        <div class="navbar-divider-mobile"></div>

        {{-- Help --}}
        <button class="navbar-icon-btn" title="Bantuan" onclick="alert('Halaman bantuan akan segera hadir!')">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 12a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"/>
                <path d="M12 17l0 .01"/>
                <path d="M12 13.5a1.5 1.5 0 0 1 1 -1.5a2.6 2.6 0 1 0 -3 -4"/>
            </svg>
        </button>

        {{-- Notifications --}}
        <button class="navbar-icon-btn" title="Notifikasi" onclick="alert('Notifikasi akan segera hadir!')">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M10 5a2 2 0 1 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6"/>
                <path d="M9 17v1a3 3 0 0 0 6 0v-1"/>
            </svg>
        </button>

        {{-- Profile --}}
        <button class="navbar-icon-btn" title="Profil" onclick="toggleDropdown('profileMenu')">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 13a3 3 0 1 0 0 -6a3 3 0 0 0 0 6"/>
                <path d="M12 3c7.2 0 9 1.8 9 9c0 7.2 -1.8 9 -9 9c-7.2 0 -9 -1.8 -9 -9c0 -7.2 1.8 -9 9 -9"/>
                <path d="M6 20.05v-.05a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v.05"/>
            </svg>
        </button>

        {{-- Profile Dropdown --}}
        <div class="navbar-dropdown-menu navbar-profile-menu" id="profileMenu">
            <div class="dropdown-header">
                <strong>{{ Auth::user()->name }}</strong>
                <small>{{ Auth::user()->email }}</small>
            </div>
            <a href="{{ route('admin.profile') }}" class="dropdown-item">Pengaturan Profil</a>
            <div class="dropdown-divider"></div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="dropdown-item dropdown-logout">Logout</button>
            </form>
        </div>
    </div>
</header>

<style>
    /* ===== NAVBAR ===== */
    .admin-navbar {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        padding: 20px 32px;
        margin: -28px -32px 24px -32px;
        background: white;
        box-shadow: 0 1px 4px rgba(88, 44, 12, 0.06);
        border-bottom: 1px solid #E5D6C5;
    }

    .navbar-title {
        font-size: 22px;
        font-weight: 700;
        color: #582C0C;
        margin: 0;
    }

    .navbar-right {
        display: flex;
        align-items: center;
        gap: 8px;
        position: relative;
    }

    /* HDS Logo */
    .navbar-hds-logo {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: #582C0C;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .navbar-hds-logo img {
        width: 20px;
        height: auto;
        filter: brightness(0) invert(1);
    }

    /* Dropdown button */
    .navbar-dropdown {
        position: relative;
    }

    .navbar-dropdown-btn {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        background: #582C0C;
        color: #F7F7F7;
        border: none;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
        font-family: 'Instrument Sans', sans-serif;
        cursor: pointer;
        transition: all 0.2s;
        white-space: nowrap;
    }

    .navbar-dropdown-btn:hover {
        box-shadow: 0 4px 12px rgba(197, 143, 89, 0.3);
    }

    .navbar-dropdown-btn svg {
        flex-shrink: 0;
    }

    /* Dropdown menu */
    .navbar-dropdown-menu {
        position: absolute;
        top: calc(100% + 8px);
        right: 0;
        background: white;
        border-radius: 12px;
        box-shadow: 0 8px 30px rgba(88, 44, 12, 0.15);
        min-width: 220px;
        padding: 6px;
        z-index: 100;
        display: none;
        border: 1px solid #E5D6C5;
    }

    .navbar-dropdown-menu.show {
        display: block;
        animation: dropdownFade 0.15s ease;
    }

    @keyframes dropdownFade {
        from { opacity: 0; transform: translateY(-4px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .dropdown-item {
        display: block;
        width: 100%;
        padding: 10px 14px;
        font-size: 13px;
        font-family: 'Instrument Sans', sans-serif;
        color: #6B513E;
        text-decoration: none;
        border-radius: 8px;
        border: none;
        background: none;
        cursor: pointer;
        text-align: left;
        transition: background 0.15s;
    }

    .dropdown-item:hover {
        background: rgba(197, 143, 89, 0.1);
    }

    .dropdown-item.active {
        background: rgba(197, 143, 89, 0.15);
        color: #582C0C;
        font-weight: 600;
    }

    .dropdown-header {
        padding: 12px 14px;
        border-bottom: 1px solid #E5D6C5;
        margin-bottom: 4px;
    }

    .dropdown-header strong {
        display: block;
        font-size: 14px;
        color: #582C0C;
    }

    .dropdown-header small {
        display: block;
        font-size: 12px;
        color: #C58F59;
        margin-top: 2px;
    }

    .dropdown-divider {
        height: 1px;
        background: #E5D6C5;
        margin: 4px 0;
    }

    .dropdown-logout {
        color: #dc2626 !important;
    }

    .dropdown-logout:hover {
        background: rgba(220, 38, 38, 0.08) !important;
    }

    /* Divider */
    .navbar-divider {
        width: 1px;
        height: 24px;
        background: #E5D6C5;
        margin: 0 4px;
    }

    /* Icon buttons */
    .navbar-icon-btn {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        border: none;
        background: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6B513E;
        transition: all 0.2s;
    }

    .navbar-icon-btn:hover {
        background: rgba(197, 143, 89, 0.1);
        color: #582C0C;
    }

    .navbar-icon-btn svg {
        width: 20px;
        height: 20px;
    }

    /* Profile menu positioning */
    .navbar-profile-menu {
        top: 48px;
        right: 0;
    }

    /* ===== RESPONSIVE: Mobile ===== */
    @media (max-width: 768px) {
        .admin-navbar {
            padding: 16px;
            margin: -72px -16px 20px -16px;
            padding-left: 64px;
        }

        .navbar-right {
            gap: 4px;
        }

        .navbar-dropdown-btn {
            padding: 6px 10px;
            font-size: 11px;
            border-radius: 16px;
        }

        .navbar-dropdown-btn span {
            max-width: 60px;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .navbar-dropdown-btn svg {
            width: 12px;
            height: 12px;
        }

        .navbar-divider {
            margin: 0 2px;
        }

        .navbar-icon-btn {
            width: 32px;
            height: 32px;
        }

        .navbar-icon-btn svg {
            width: 18px;
            height: 18px;
        }

        .navbar-hds-logo {
            width: 32px;
            height: 32px;
        }

        .navbar-dropdown-menu {
            right: -16px;
        }
    }
</style>

<script>
    function toggleDropdown(menuId) {
        const menu = document.getElementById(menuId);
        const allMenus = document.querySelectorAll('.navbar-dropdown-menu');

        // Close all other menus
        allMenus.forEach(m => {
            if (m.id !== menuId) m.classList.remove('show');
        });

        menu.classList.toggle('show');
    }

    // Close dropdowns when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.navbar-dropdown') && !e.target.closest('.navbar-icon-btn')) {
            document.querySelectorAll('.navbar-dropdown-menu').forEach(m => m.classList.remove('show'));
        }
    });
</script>
