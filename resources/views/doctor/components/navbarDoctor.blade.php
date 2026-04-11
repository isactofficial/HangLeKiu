{{-- Navbar Doctor --}}
<nav class="w-full bg-white border-b border-[var(--color-background-secondary)] z-50 fixed top-0 left-0 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-6 md:px-10 py-3 flex items-center justify-between">
        
        {{-- Left: Logo --}}
        <a href="/" class="flex items-center">
            <img src="{{ asset('images/logo-hds.png') }}" alt="HDS" class="h-10 md:h-12 object-contain">
        </a>

        {{-- Hamburger Button --}}
        <button id="mobile-menu-btn" class="md:hidden p-2 text-white rounded-[8px] bg-[#582C0C] transition-colors " style="display:none;">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>

        {{-- Right: Navigation + Profile --}}
        <div class="flex items-center gap-8">
            <a href="{{ route('doctor.dashboard') }}"
               class="text-[15px] font-normal {{ request()->routeIs('doctor.dashboard') ? 'text-[var(--font-color-primary)] font-semibold' : 'text-[var(--font-color-secondary)]' }} hover:text-primary transition-colors duration-200">
                Dashboard
            </a>

            {{-- ── LINK EMR (baru) ── --}}
            <a href="{{ route('doctor.emr') }}"
               class="text-[15px] font-normal flex items-center gap-1.5
                      {{ request()->routeIs('doctor.emr*') ? 'text-[var(--font-color-primary)] font-semibold' : 'text-[var(--font-color-secondary)]' }}
                      hover:text-primary transition-colors duration-200">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                EMR
            </a>

            {{-- Auth Section --}}
            @auth
                @php
                    $navbarUser  = Auth::user();
                    $navbarPhoto = ($navbarUser->doctor && $navbarUser->doctor->foto_profil) ? $navbarUser->doctor->foto_profil : null;
                @endphp
                <div class="flex items-center gap-4 border-l border-gray-200 pl-8">
                    <div class="text-right">
                        <p class="text-xs font-bold text-[var(--font-color-primary)] leading-none mb-1">{{ $navbarUser->name }}</p>
                        <p class="text-[10px] font-medium text-[var(--font-color-secondary)] tracking-wider uppercase">Dokter Spesialis</p>
                    </div>
                    <div class="relative group">
                        <button class="flex items-center justify-center w-10 h-10 rounded-full overflow-hidden border border-[#D9C3AE] bg-[#F4E9DF] text-[var(--font-color-primary)] hover:brightness-95 transition-all duration-200">
                            @if($navbarPhoto)
                                <img src="{{ str_starts_with($navbarPhoto, 'http') ? $navbarPhoto : asset('storage/' . $navbarPhoto) }}" alt="{{ $navbarUser->name }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-sm font-semibold">{{ substr($navbarUser->name, 0, 1) }}</span>
                            @endif
                        </button>
                        <div class="absolute right-0 mt-2 w-48 bg-white border border-gray-100 rounded-xl shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50 py-2">
                             <form method="POST" action="{{ route('logout') }}" class="w-full">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 flex items-center gap-2 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                    </svg>
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endauth
        </div>
    </div>

    {{-- Mobile Dropdown Menu --}}
    <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-gray-100 absolute w-full shadow-lg flex-col">
        <a href="{{ route('doctor.dashboard') }}"
           class="px-6 py-4 text-[24px] font-medium border-b border-gray-50 text-[var(--font-color-primary)]">
            Dashboard
        </a>

        {{-- ── LINK EMR mobile (baru) ── --}}
        <a href="{{ route('doctor.emr') }}"
           class="px-6 py-4 text-[24px] font-medium border-b border-gray-50
                  {{ request()->routeIs('doctor.emr*') ? 'text-[#582C0C] font-semibold' : 'text-[var(--font-color-primary)]' }}
                  flex items-center gap-3">
            <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            EMR
        </a>

        @auth
            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <button type="submit" class="w-full text-left px-6 py-4 text-[24px] font-medium text-red-600">Keluar</button>
            </form>
        @endauth
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const btn  = document.getElementById('mobile-menu-btn');
        const menu = document.getElementById('mobile-menu');
        if (btn && menu) {
            btn.addEventListener('click', () => {
                menu.classList.toggle('hidden');
                menu.classList.toggle('flex');
            });
        }
    });
</script>