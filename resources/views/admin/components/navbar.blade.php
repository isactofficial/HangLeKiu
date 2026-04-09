{{-- Navbar Component --}}
{{-- Usage: @include('admin.components.navbar', ['title' => 'Page Title']) --}}

@props(['title' => ''])

<header class="admin-navbar">
    {{-- Main Navbar Content --}}

    {{-- Right: Actions --}}
    <div class="navbar-right w-full flex items-center justify-between md:justify-end">
        
        {{-- Left Items (Mobile) --}}
        <div class="navbar-left flex items-center md:hidden">
            <button class="navbar-hamburger-btn" onclick="toggleSidebar()" title="Toggle Menu">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="18" x2="21" y2="18"></line>
                </svg>
            </button>
        </div>

        {{-- Right Items --}}
        <div class="navbar-actions flex items-center gap-2">
            {{-- HDS Logo --}}
            <div class="navbar-hds-logo hidden md:flex">
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
        <a href="{{ route('admin.notifications') }}">
            <button class="navbar-icon-btn" title="Notifikasi">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"             
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M10 5a2 2 0 1 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6"/>
                <path d="M9 17v1a3 3 0 0 0 6 0v-1"/>
            </svg>
        </button>
    </a>

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
    </div>
</header>
<script>
    function toggleDropdown(menuId) {
        const menu = document.getElementById(menuId);
        const allMenus = document.querySelectorAll('.navbar-dropdown-menu');
        allMenus.forEach(m => { if (m.id !== menuId) m.classList.remove('show'); });
        menu.classList.toggle('show');
    }

    document.addEventListener('click', function(e) {
        if (!e.target.closest('.navbar-dropdown') && !e.target.closest('.navbar-icon-btn')) {
            document.querySelectorAll('.navbar-dropdown-menu').forEach(m => m.classList.remove('show'));
        }
    });
</script>