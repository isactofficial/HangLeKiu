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
            <a href="{{ url('/#pelayanan') }}" class="text-[15px] font-normal text-[var(--font-color-secondary)] hover:text-primary transition-colors duration-200">Pelayanan</a>
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
        <a href="{{ url('/#pelayanan') }}" class="px-6 py-4 text-[24px] font-medium border-b border-gray-50 text-[var(--font-color-secondary)]">Pelayanan</a>
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
    });
</script>