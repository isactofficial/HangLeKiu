{{-- Navbar Component --}}
{{-- Usage: @include('admin.components.navbarPendaftaranBaru', ['title' => 'Page Title']) --}}

@props(['title' => ''])

<header class="admin-navbar">
    {{-- Left: Search Area --}}
    <div class="navbar-left">
        <div class="navbar-search-group">
            <div class="navbar-search-wrapper">
                {{-- Search Icon --}}
                <svg class="navbar-search-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>

                <input type="text" class="navbar-search-input"
                    placeholder="Cari Pasien / No MR / No Ktp / No Asuransi...">

                {{-- User Icon --}}
                <svg class="navbar-user-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
            </div>

            {{-- Tombol Pendaftaran Baru --}}
            <div class="navbar-dropdown" id="pendaftaranDropdown">
                <button class="navbar-btn-primary" onclick="toggleDropdown('pendaftaranMenu')">
                    Pendaftaran Baru
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" style="margin-left: 6px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>
                {{-- Dropdown menu Pendaftaran Baru --}}
                <div class="navbar-dropdown-menu" id="pendaftaranMenu"
                    style="left: 0; right: auto; top: calc(100% + 4px);">
                    <a href="#" class="dropdown-item">Pasien Baru</a>
                    <a href="#" class="dropdown-item">Pasien Lama</a>
                </div>
            </div>
        </div>
    </div>

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
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
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

        {{-- Help --}}
        <button class="navbar-icon-btn" title="Bantuan" onclick="alert('Halaman bantuan akan segera hadir!')">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 12a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                <path d="M12 17l0 .01" />
                <path d="M12 13.5a1.5 1.5 0 0 1 1 -1.5a2.6 2.6 0 1 0 -3 -4" />
            </svg>
        </button>

        {{-- Notifications --}}
        <button class="navbar-icon-btn" title="Notifikasi" onclick="alert('Notifikasi akan segera hadir!')">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M10 5a2 2 0 1 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6" />
                <path d="M9 17v1a3 3 0 0 0 6 0v-1" />
            </svg>
        </button>

        {{-- Profile --}}
        <button class="navbar-icon-btn" title="Profil" onclick="toggleDropdown('profileMenu')">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round">
                <path d="M12 13a3 3 0 1 0 0 -6a3 3 0 0 0 0 6" />
                <path d="M12 3c7.2 0 9 1.8 9 9c0 7.2 -1.8 9 -9 9c-7.2 0 -9 -1.8 -9 -9c0 -7.2 1.8 -9 9 -9" />
                <path d="M6 20.05v-.05a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v.05" />
            </svg>
        </button>

        {{-- Profile Dropdown --}}
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
</header>
<script>
    function toggleDropdown(menuId) {
        const menu = document.getElementById(menuId);
        const allMenus = document.querySelectorAll('.navbar-dropdown-menu');

        allMenus.forEach(m => {
            if (m.id !== menuId) m.classList.remove('show');
        });

        menu.classList.toggle('show');
    }

    document.addEventListener('click', function(e) {
        if (!e.target.closest('.navbar-dropdown') && !e.target.closest('.navbar-icon-btn') && !e.target.closest(
                '.navbar-search-group')) {
            document.querySelectorAll('.navbar-dropdown-menu').forEach(m => m.classList.remove('show'));
        }
    });
</script>
