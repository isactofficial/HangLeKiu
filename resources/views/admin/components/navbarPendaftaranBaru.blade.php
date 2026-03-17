{{-- Navbar Component --}}
@props(['title' => ''])

<header class="admin-navbar">

    {{-- DESKTOP & MOBILE BARIS 1: Search + Daftar --}}
    <div class="navbar-left">

        {{-- Hamburger — hanya tampil di mobile, inline dalam navbar --}}
        <button id="sidebarToggle" class="sidebar-hamburger" type="button" aria-label="Toggle menu">
            <span></span><span></span><span></span>
        </button>

        <div class="navbar-search-wrapper">
            <svg class="navbar-search-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"></circle>
                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
            </svg>
            <input type="text" class="navbar-search-input" placeholder="Cari Pasien / No MR / No Ktp / No Asuransi...">
            <svg class="navbar-user-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                <circle cx="12" cy="7" r="4"></circle>
            </svg>
        </div>

        <div class="navbar-dropdown" id="pendaftaranDropdown">
            <button class="navbar-btn-primary" onclick="toggleDropdown('pendaftaranMenu')">
                <span class="btn-text-desktop">Pendaftaran Baru</span>
                <span class="btn-text-mobile">Daftar</span>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-left:6px;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                </svg>
            </button>
            <div class="navbar-dropdown-menu" id="pendaftaranMenu" style="left:0;right:auto;top:calc(100% + 4px);">
                <a href="#" class="dropdown-item">Pasien Baru</a>
                <a href="#" class="dropdown-item">Pasien Lama</a>
            </div>
        </div>
    </div>

    {{-- DESKTOP: Right icons (selalu tampil di desktop) --}}
    {{-- MOBILE: disembunyikan, muncul lewat tombol "more" --}}
    <div class="navbar-right">

        {{-- Grup yang bisa di-collapse di mobile --}}
        <div class="navbar-collapsible" id="navbarIconGroup">
            <div class="navbar-hds-logo">
                <img src="/images/logo-hds.png" alt="HDS">
            </div>

            <div class="navbar-dropdown" id="clinicDropdown">
                <button class="navbar-dropdown-btn" onclick="toggleDropdown('clinicMenu')">
                    <span>hanglekiu dent...</span>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>
                <div class="navbar-dropdown-menu" id="clinicMenu">
                    <a href="#" class="dropdown-item active">Hanglekiu Dental Clinic</a>
                    <a href="#" class="dropdown-item">Cabang Kemang</a>
                    <a href="#" class="dropdown-item">Cabang Sudirman</a>
                </div>
            </div>

            <div class="navbar-divider"></div>

            <button class="navbar-icon-btn" title="Bantuan">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 12a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                    <path d="M12 17l0 .01" />
                    <path d="M12 13.5a1.5 1.5 0 0 1 1 -1.5a2.6 2.6 0 1 0 -3 -4" />
                </svg>
            </button>

            <button class="navbar-icon-btn" title="Notifikasi">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M10 5a2 2 0 1 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6" />
                    <path d="M9 17v1a3 3 0 0 0 6 0v-1" />
                </svg>
            </button>

            <button class="navbar-icon-btn" title="Profil" onclick="toggleDropdown('profileMenu')">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 13a3 3 0 1 0 0 -6a3 3 0 0 0 0 6" />
                    <path d="M12 3c7.2 0 9 1.8 9 9c0 7.2 -1.8 9 -9 9c-7.2 0 -9 -1.8 -9 -9c0 -7.2 1.8 -9 9 -9" />
                    <path d="M6 20.05v-.05a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v.05" />
                </svg>
            </button>

            <div class="navbar-dropdown-menu navbar-profile-menu" id="profileMenu">
                <div class="dropdown-header">
                    <strong>{{ Auth::check() ? Auth::user()->name : 'Admin' }}</strong>
                    <small>{{ Auth::check() ? Auth::user()->email : 'admin@hds.com' }}</small>
                </div>
                <a href="#" class="dropdown-item">Pengaturan Profil</a>
                <div class="dropdown-divider"></div>
                <form method="POST" action="#">
                    @csrf
                    <button type="submit" class="dropdown-item dropdown-logout">Logout</button>
                </form>
            </div>
        </div>

        {{-- Tombol MORE — hanya tampil di mobile --}}
        <button class="navbar-more-btn" id="navbarMoreBtn" onclick="toggleNavbarMore()">
            more
            <svg id="navbarMoreChevron" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
            </svg>
        </button>

    </div>
</header>

<style>
    /* ===================================================
       BASE — Desktop
    =================================================== */
    .admin-navbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 24px 32px;
        margin: -28px -32px 24px -32px;
        background: white;
        box-shadow: 0 1px 4px rgba(88, 44, 12, 0.06);
        border-bottom: 1px solid #E5D6C5;
        font-family: 'Instrument Sans', sans-serif;
        position: relative;
        z-index: 50;
    }

    /* Left */
    .navbar-left {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .navbar-search-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }

    .navbar-search-icon {
        position: absolute; left: 14px;
        width: 16px; height: 16px;
        color: #C58F59;
    }
    .navbar-user-icon {
        position: absolute; right: 14px;
        width: 16px; height: 16px;
        color: #C58F59;
    }

    .navbar-search-input {
        width: 340px;
        padding: 10px 38px;
        border: 1px solid #E5D6C5;
        border-radius: 24px;
        font-size: 13px;
        color: #582C0C;
        outline: none;
        transition: border-color 0.2s;
        font-family: 'Instrument Sans', sans-serif;
    }
    .navbar-search-input:focus { border-color: #C58F59; }
    .navbar-search-input::placeholder { color: #A38C7A; }

    .navbar-btn-primary {
        background-color: #C58F59;
        color: white;
        border: none;
        padding: 10px 18px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        font-family: 'Instrument Sans', sans-serif;
        display: flex;
        align-items: center;
        white-space: nowrap;
    }
    .navbar-btn-primary:hover { background-color: #b07d4a; }

    /* Right */
    .navbar-right {
        display: flex;
        align-items: center;
        gap: 6px;
        position: relative;
    }

    .navbar-collapsible {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .navbar-hds-logo {
        width: 36px; height: 36px;
        border-radius: 50%; background: #582C0C;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .navbar-hds-logo img { width: 20px; filter: brightness(0) invert(1); }

    .navbar-dropdown { position: relative; }

    .navbar-dropdown-btn {
        display: flex; align-items: center; gap: 8px;
        padding: 8px 16px; background: #582C0C; color: #F7F7F7;
        border: none; border-radius: 20px; font-size: 13px; font-weight: 600;
        font-family: 'Instrument Sans', sans-serif;
        cursor: pointer; transition: all 0.2s; white-space: nowrap;
    }
    .navbar-dropdown-btn:hover { box-shadow: 0 4px 12px rgba(197,143,89,0.3); }

    .navbar-divider { width: 1px; height: 24px; background: #E5D6C5; margin: 0 4px; }

    .navbar-icon-btn {
        width: 36px; height: 36px; border-radius: 8px; border: none;
        background: none; cursor: pointer; display: flex;
        align-items: center; justify-content: center;
        color: #6B513E; transition: all 0.2s;
    }
    .navbar-icon-btn:hover { background: rgba(197,143,89,0.1); color: #582C0C; }
    .navbar-icon-btn svg { width: 20px; height: 20px; }

    .navbar-dropdown-menu {
        position: absolute; top: calc(100% + 8px); right: 0;
        background: white; border-radius: 12px;
        box-shadow: 0 8px 30px rgba(88,44,12,0.15);
        min-width: 220px; padding: 6px; z-index: 100;
        display: none; border: 1px solid #E5D6C5;
    }
    .navbar-dropdown-menu.show { display: block; animation: dropdownFade 0.15s ease; }

    @keyframes dropdownFade {
        from { opacity: 0; transform: translateY(-4px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .dropdown-item {
        display: block; width: 100%; padding: 10px 14px; font-size: 13px;
        font-family: 'Instrument Sans', sans-serif; color: #6B513E;
        text-decoration: none; border-radius: 8px; border: none;
        background: none; cursor: pointer; text-align: left; transition: background 0.15s;
    }
    .dropdown-item:hover { background: rgba(197,143,89,0.1); }
    .dropdown-item.active { background: rgba(197,143,89,0.15); color: #582C0C; font-weight: 600; }

    .dropdown-header { padding: 12px 14px; border-bottom: 1px solid #E5D6C5; margin-bottom: 4px; }
    .dropdown-header strong { display: block; font-size: 14px; color: #582C0C; }
    .dropdown-header small { display: block; font-size: 12px; color: #C58F59; margin-top: 2px; }
    .dropdown-divider { height: 1px; background: #E5D6C5; margin: 4px 0; }
    .dropdown-logout { color: #dc2626 !important; }
    .dropdown-logout:hover { background: rgba(220,38,38,0.08) !important; }

    .navbar-profile-menu { top: 48px; right: 0; }

    /* Hamburger — inline dalam navbar, hanya mobile */
    .sidebar-hamburger {
        display: none;
        flex-direction: column;
        gap: 5px;
        cursor: pointer;
        background: white;
        border: 1px solid #E5D6C5;
        border-radius: 8px;
        padding: 7px;
        width: 36px;
        height: 36px;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        box-shadow: 0 1px 4px rgba(88,44,12,0.10);
        transition: opacity 0.2s;
    }
    .sidebar-hamburger span {
        display: block;
        width: 18px;
        height: 2px;
        background: #582C0C;
        border-radius: 2px;
    }
    @media (max-width: 768px) {
        .sidebar-hamburger { display: flex; }
    }

    /* Tombol MORE — hidden di desktop */
    .navbar-more-btn { display: none; }

    /* Teks tombol pendaftaran */
    .btn-text-mobile { display: none; }
    .btn-text-desktop { display: inline; }

    /* ===================================================
       MOBILE ≤ 768px
       Baris 1 (atas) : [☰] [search input] [Daftar▾]
       Baris 2 (bawah): [more ▾]  →  expand: [HDS] [clinic] | [?] [🔔] [👤]
    =================================================== */
    @media (max-width: 768px) {
        .admin-navbar {
            /* SATU BARIS: ☰ [search] [Daftar▾] [more▾] */
            flex-direction: row;
            flex-wrap: nowrap;
            align-items: center;
            padding: 10px 12px;
            margin: -16px -16px 16px -16px;
            gap: 8px;
        }

        /* Search + Daftar ambil sisa ruang */
        .navbar-left {
            flex: 1;
            min-width: 0;
            gap: 8px;
        }

        .navbar-search-wrapper { flex: 1; min-width: 0; }

        .navbar-search-input {
            width: 100%;
            font-size: 13px;
            padding: 9px 32px;
        }
        .navbar-search-icon { left: 10px; }
        .navbar-user-icon  { right: 10px; }

        .navbar-btn-primary {
            padding: 9px 12px;
            font-size: 12px;
            flex-shrink: 0;
        }
        .btn-text-desktop { display: none; }
        .btn-text-mobile  { display: inline; }

        /* Right: hanya tombol more, icons tersembunyi */
        .navbar-right {
            flex-shrink: 0;
            gap: 6px;
            position: relative;
        }

        /* Icons grup — hidden by default, muncul saat open sebagai dropdown */
        .navbar-collapsible {
            display: none;
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            background: white;
            border: 1px solid #E5D6C5;
            border-radius: 14px;
            box-shadow: 0 8px 24px rgba(88,44,12,0.12);
            padding: 10px 12px;
            gap: 6px;
            flex-direction: row;
            align-items: center;
            z-index: 200;
            white-space: nowrap;
        }

        .navbar-collapsible.open {
            display: flex;
        }

        /* Ukuran icons compact di dalam dropdown */
        .navbar-hds-logo { width: 28px; height: 28px; }
        .navbar-hds-logo img { width: 15px; }
        .navbar-dropdown-btn { padding: 5px 10px; font-size: 11px; }
        .navbar-dropdown-btn span { max-width: 70px; overflow: hidden; text-overflow: ellipsis; }
        .navbar-icon-btn { width: 30px; height: 30px; }
        .navbar-icon-btn svg { width: 17px; height: 17px; }
        .navbar-divider { margin: 0 2px; }
        .navbar-dropdown-menu { right: 0; }
        .navbar-profile-menu { top: 40px; right: 0; }

        /* Tombol MORE tampil di mobile */
        .navbar-more-btn {
            display: flex;
            align-items: center;
            gap: 4px;
            padding: 7px 12px;
            border: 1px solid #E5D6C5;
            border-radius: 14px;
            background: white;
            color: #582C0C;
            font-size: 12px;
            font-weight: 600;
            font-family: 'Instrument Sans', sans-serif;
            cursor: pointer;
            flex-shrink: 0;
            white-space: nowrap;
        }

        #navbarMoreChevron { transition: transform 0.25s ease; }
    }
</style>

<script>
    function toggleNavbarMore() {
        const group   = document.getElementById('navbarIconGroup');
        const chevron = document.getElementById('navbarMoreChevron');
        const isOpen  = group.classList.toggle('open');
        chevron.style.transform = isOpen ? 'rotate(180deg)' : 'rotate(0deg)';
    }

    function toggleDropdown(menuId) {
        const menu = document.getElementById(menuId);
        document.querySelectorAll('.navbar-dropdown-menu').forEach(m => {
            if (m.id !== menuId) m.classList.remove('show');
        });
        menu.classList.toggle('show');
    }

    document.addEventListener('click', function(e) {
        if (!e.target.closest('.navbar-dropdown') &&
            !e.target.closest('.navbar-icon-btn') &&
            !e.target.closest('.navbar-more-btn')) {
            document.querySelectorAll('.navbar-dropdown-menu').forEach(m => m.classList.remove('show'));
        }
    });
</script>