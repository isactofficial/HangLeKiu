{{-- Navbar Welcome/Public --}}
<nav class="w-full bg-white border-b border-[var(--color-background-secondary)] z-50 fixed top-0 left-0 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-6 md:px-10 py-3 flex items-center justify-between">
        
        {{-- Left: Logo --}}
        <a href="/" class="flex items-center">
            <img src="{{ asset('images/logo-hds.png') }}" alt="HDS" class="h-10 md:h-12 object-contain">
        </a>

        {{-- Hamburger Button (Mobile Only) --}}
        <button id="mobile-menu-btn" class="md:hidden p-2 text-white rounded-[8px] bg-[#C58F59] transition-colors">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>

        {{-- Right: Navigation + Masuk (Desktop Only) --}}
        <div class="hidden md:flex items-center gap-8">
            <a href="{{ url('/') }}" class="text-[15px] font-normal {{ request()->is('/') ? 'text-[var(--font-color-primary)] font-semibold' : 'text-[var(--font-color-secondary)]' }} hover:text-primary transition-colors duration-200">Beranda</a>
<div class="relative group">
    <button class="text-[15px] font-normal text-[var(--font-color-secondary)] hover:text-primary transition-colors duration-200 inline-flex items-center">
        Pelayanan
        <svg class="w-4 h-4 ml-1 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
    </button>
    <div class="absolute left-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
        <a href="/pelayanan/dokter" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">Dokter</a>
        <a href="/pelayanan/perawatan" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">Perawatan</a>
    </div>
</div>
            <a href="{{ route('klinik') }}" class="text-[15px] font-normal {{ request()->routeIs('klinik') ? 'text-[var(--font-color-primary)] font-semibold' : 'text-[var(--font-color-secondary)]' }} hover:text-primary transition-colors duration-200">Klinik</a>
            <a href="{{ route('artikel') }}" class="text-[15px] font-normal {{ request()->routeIs('artikel') ? 'text-[var(--font-color-primary)] font-semibold' : 'text-[var(--font-color-secondary)]' }} hover:text-primary transition-colors duration-200">Artikel</a>

            {{-- Auth Section --}}
            @auth
                <a href="{{ route('user.dashboard') }}" class="ml-2 flex items-center justify-center w-10 h-10 bg-gray-200 text-gray-600 hover:bg-gray-300 rounded-full transition-colors duration-200">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                </a>
            @else
                <a href="{{ route('login') }}" class="ml-2 px-6 py-2.5 bg-primary hover:bg-primary/90 text-white text-[15px] font-normal rounded-full transition-all duration-200 hover:shadow-lg">
                    Masuk
                </a>
            @endauth
        </div>
    </div>

    {{-- Mobile Dropdown Menu --}}
    <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-gray-100 absolute w-full shadow-lg flex-col">
        <a href="{{ url('/') }}" class="px-6 py-4 text-[24px] font-medium border-b border-gray-50 text-[var(--font-color-primary)]">Beranda</a>
<div class="pelayanan-dropdown">
    <button class="w-full text-left px-6 py-4 text-[24px] font-medium border-b border-gray-50 text-[var(--font-color-secondary)] flex items-center justify-between">
        Pelayanan
        <svg class="w-6 h-6 transition-transform" id="pelayanan-chevron" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
    </button>
    <div class="pelayanan-submenu hidden pl-8 border-l-2 border-[var(--font-color-secondary)] bg-gray-50">
        <a href="/pelayanan/dokter" class="block px-6 py-4 text-[20px] font-normal text-[var(--font-color-secondary)] hover:bg-white transition-colors">Dokter</a>
        <a href="/pelayanan/perawatan" class="block px-6 py-4 text-[20px] font-normal text-[var(--font-color-secondary)] hover:bg-white transition-colors">Perawatan</a>
    </div>
</div>
        <a href="{{ route('klinik') }}" class="px-6 py-4 text-[24px] font-medium border-b border-gray-50 text-[var(--font-color-secondary)]">Klinik</a>
        <a href="{{ route('artikel') }}" class="px-6 py-4 text-[24px] font-medium border-b border-gray-50 text-[var(--font-color-secondary)]">Artikel</a>
        @auth
            <a href="{{ route('user.dashboard') }}" class="px-6 py-4 text-[24px] font-medium text-[var(--font-color-primary)] bg-gray-50">Dashboard Akun</a>
        @else
            <a href="{{ route('login') }}" class="px-6 py-4 text-[24px] font-medium text-white bg-primary text-center">Masuk</a>
        @endauth
    </div>
</nav>

{{-- Script Khusus Navbar Mobile --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const btn = document.getElementById('mobile-menu-btn');
        const menu = document.getElementById('mobile-menu');
        if(btn && menu) {
            btn.addEventListener('click', () => {
                menu.classList.toggle('hidden');
                menu.classList.toggle('flex');
            });
        }

        // Pelayanan mobile dropdown
        const pelayananBtn = document.querySelector('.pelayanan-dropdown button');
        const pelayananSubmenu = document.querySelector('.pelayanan-submenu');
        const chevron = document.getElementById('pelayanan-chevron');
        if (pelayananBtn && pelayananSubmenu) {
            pelayananBtn.addEventListener('click', (e) => {
                e.preventDefault();
                pelayananSubmenu.classList.toggle('hidden');
                if (chevron) {
                    chevron.style.transform = pelayananSubmenu.classList.contains('hidden') ? 'rotate(0deg)' : 'rotate(180deg)';
                }
            });
        }
    });
</script>
