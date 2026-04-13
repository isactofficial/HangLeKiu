{{-- Navbar Component --}}
{{-- Usage: @include('admin.components.navbarSearch', ['title' => 'Page Title']) --}}

@props(['title' => ''])

<header class="admin-navbar">
    {{-- Left: Search Area & Mobile Toggle --}}
    <div class="navbar-left w-full md:w-auto flex items-center gap-2">
        {{-- Hamburger Menu (Mobile) --}}
        <button class="navbar-hamburger-btn md:hidden" onclick="toggleSidebar()" title="Toggle Menu">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="3" y1="12" x2="21" y2="12"></line>
                <line x1="3" y1="6" x2="21" y2="6"></line>
                <line x1="3" y1="18" x2="21" y2="18"></line>
            </svg>
        </button>

        <div class="navbar-search-group">
            <div class="navbar-search-wrapper">
                {{-- Search Icon --}}
                <svg class="navbar-search-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
                
                <input type="text" class="navbar-search-input" placeholder="Cari Pasien / No MR / No Ktp / No Asuransi...">
                
                {{-- User Icon --}}
                <svg class="navbar-user-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
            </div>
            <button class="navbar-btn-primary">Advance Search</button>
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

        {{-- Help --}}
        <button class="navbar-icon-btn" title="Bantuan" onclick="alert('Halaman bantuan akan segera hadir!')">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 12a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"/>
                <path d="M12 17l0 .01"/>
                <path d="M12 13.5a1.5 1.5 0 0 1 1 -1.5a2.6 2.6 0 1 0 -3 -4"/>
            </svg>
        </button>

        {{-- Notifications --}}
        @php
        $pendingCount = \App\Models\Appointment::where('status','pending')
        ->whereNull('admin_id')
        ->whereHas('patient')
        ->count();
        @endphp
        <a href="{{ route('admin.notifications') }}" style="position:relative; display:inline-flex;">
            <button class="navbar-icon-btn" title="Notifikasi">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M10 5a2 2 0 1 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6"/>
                    <path d="M9 17v1a3 3 0 0 0 6 0v-1"/>
                 </svg>
                    @if($pendingCount > 0)
                        <span style="position:absolute; top:-4px; right:-4px; background:#EF4444; color:white; font-size:10px; font-weight:700; min-width:16px; height:16px; border-radius:20px; display:flex; align-items:center; justify-content:center; padding:0 4px; line-height:1;">
                            {{ $pendingCount > 99 ? '99+' : $pendingCount }}
                        </span>
                    @endif
            </button>
        </a>

        {{-- Profile --}}
        <button class="navbar-icon-btn" title="Profil" onclick="toggleDropdown('profileMenu')">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 13a3 3 0 1 0 0 -6a3 3 0 0 0 0 6"/>
                <path d="M12 3c7.2 0 9 1.8 9 9c0 7.2 -1.8 9 -9 9c-7.2 0 -9 -1.8 -9 -9c0 -7.2 1.8 -9 9 -9"/>
                <path d="M6 20.05v-.05a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v.05"/>
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
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="dropdown-item dropdown-logout">Logout</button>
            </form>
        </div>
    </div>
</header>
<script>
    (function() {
    // Cek setiap 30 detik
    const INTERVAL = 30000;

    async function checkNotifCount() {
        try {
            const res  = await fetch('/admin/notifications/count', {
                headers: { 'Accept': 'application/json' }
            });
            const data = await res.json();
            const count = data.count || 0;

            // Update semua badge notif yang ada di halaman
            document.querySelectorAll('.notif-badge-count').forEach(el => {
                if (count > 0) {
                    el.textContent = count > 99 ? '99+' : count;
                    el.style.display = 'flex';
                } else {
                    el.style.display = 'none';
                }
            });
        } catch (err) {
            console.warn('Notif check failed:', err);
        }
    }

    // Cek pertama saat load
    checkNotifCount();

    // Cek terus tiap 30 detik
    setInterval(checkNotifCount, INTERVAL);
})();
    function toggleDropdown(menuId) {
        const menu = document.getElementById(menuId);
        const allMenus = document.querySelectorAll('.navbar-dropdown-menu');

        allMenus.forEach(m => {
            if (m.id !== menuId) m.classList.remove('show');
        });

        menu.classList.toggle('show');
    }

    document.addEventListener('click', function(e) {
        if (!e.target.closest('.navbar-dropdown') && !e.target.closest('.navbar-icon-btn')) {
            document.querySelectorAll('.navbar-dropdown-menu').forEach(m => m.classList.remove('show'));
        }
    });
</script>