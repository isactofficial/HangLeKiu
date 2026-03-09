{{-- Navbar Welcome/Public --}}
<nav class="w-full bg-white border-b border-[var(--color-background-secondary)] z-50 fixed top-0 left-0">
    <div class="max-w-7xl mx-auto px-6 md:px-10 py-2 flex items-center justify-between">
        {{-- Left: Logo --}}
        <a href="/" class="flex items-center">
            <img src="{{ asset('images/logo-hds.png') }}" alt="HDS" class="h-max">
        </a>

        {{-- Right: Navigation + Masuk --}}
        <div class="flex items-center gap-8">
            <a href="{{ url('/') }}"
                class="text-[var(--fs-md)] font-normal {{ request()->is('/') ? 'text-[var(--font-color-primary)] font-semibold' : 'text-[var(--font-color-secondary)]' }} hover:text-primary transition-colors duration-200">Beranda</a>
            <a href="{{ url('/#pelayanan') }}"
                class="text-[var(--fs-md)] font-normal text-[var(--font-color-secondary)] hover:text-primary transition-colors duration-200">Pelayanan</a>
            <a href="{{ route('klinik') }}"
                class="text-[var(--fs-md)] font-normal {{ request()->routeIs('klinik') ? 'text-[var(--font-color-primary)] font-semibold' : 'text-[var(--font-color-secondary)]' }} hover:text-primary transition-colors duration-200">Klinik</a>
            
            {{-- Menu Artikel Baru Ditambahkan --}}
            <a href="{{ route('artikel') }}"
                class="text-[var(--fs-md)] font-normal {{ request()->routeIs('artikel') ? 'text-[var(--font-color-primary)] font-semibold' : 'text-[var(--font-color-secondary)]' }} hover:text-primary transition-colors duration-200">Artikel</a>

            {{-- Auth Section --}}
            @auth
                <a href="{{ route('user.dashboard') }}" class="ml-2 flex items-center justify-center w-10 h-10 bg-gray-200 text-gray-600 hover:bg-gray-300 rounded-full transition-colors duration-200">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                </a>
            @else
                <a href="{{ route('login') }}"
                    class="ml-2 px-6 py-2.5 bg-primary hover:bg-primary/90 text-white text-[var(--fs-md)] font-normal rounded-full transition-all duration-200 hover:shadow-lg">
                    Masuk
                </a>
            @endauth
        </div>
    </div>
</nav>