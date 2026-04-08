<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hanglekiu Dental — Artikel</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-[var(--font-color-primary)] m-0 min-h-screen flex flex-col relative bg-[#FAF9F6]">

    {{-- Navbar --}}
    @include('user.components.navbarWelcome')

    {{-- Content --}}
    <main class="flex-grow pt-[100px]"> {{-- Padding top untuk kompensasi navbar fixed --}}
        
        {{-- Header Section --}}
        <div class="max-w-7xl mx-auto px-6 md:px-10 py-10 text-center">
            <h1 class="text-3xl md:text-[48px] font-bold text-[#582C0C] mb-2 leading-tight">
                Artikel
            </h1>
            <p class="text-[#6B513E] text-[18.75px] max-w-2xl mx-auto leading-relaxed">
                Wawasan eksklusif seputar kesehatan gigi
            </p>
        </div>

        {{-- Filter Section --}}
        <div class="max-w-7xl mx-auto px-6 md:px-10 mb-10 flex flex-col lg:flex-row justify-between items-center gap-6">
            <div class="flex flex-wrap justify-center lg:justify-start gap-2">
                @php
                    $filters = ['Semua', 'Estetika', 'Spesialis', 'Teknologi', 'Gigi Anak', 'Tips and Trick'];
                @endphp
                @foreach ($filters as $filter)
                    <a href="{{ request()->fullUrlWithQuery(['category' => $filter, 'page' => 1]) }}" class="px-4 py-3 rounded-full border-2 border-[#C58F59] font-medium text-[18.75px] transition-colors duration-300 {{ $filter === $activeFilter ? 'bg-[#C58F59] text-white' : 'text-[#C58F59] hover:bg-[#C58F59] hover:text-white' }}">
                        {{ $filter }}
                    </a>
                @endforeach
            </div>

            {{-- Search Bar --}}
            <form method="GET" action="{{ route('artikel') }}" class="flex items-center px-6 py-3 bg-[#E5D6C5] border-2 border-[#C58F59] rounded-full w-full lg:w-auto overflow-hidden">
                @if(request('category') && request('category') !== 'Semua')
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                <input type="text" name="search" value="{{ $searchQuery ?? '' }}" placeholder="Cari Artikel" class="text-[#6B513E] font-medium text-[18.75px] bg-transparent border-none outline-none focus:ring-0 w-full lg:w-[150px] placeholder-[#6B513E]">
                <button type="submit" class="ml-2 focus:outline-none shrink-0">
                    <svg class="w-6 h-6 text-[#C58F59]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>
            </form>
        </div>

        {{-- Grid Artikel --}}
        <div class="max-w-7xl mx-auto px-6 md:px-10 pb-24">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-[40px]">
                
                @forelse ($articles as $article)
                <article class="flex flex-col h-full bg-transparent">
                    {{-- Image with Cutout Label --}}
                    <div class="relative w-full aspect-[4/3] rounded-t-[24px] overflow-hidden group">
                        <img src="{{ asset('images/artikel/' . ($article->image ?: 'placeholder.png')) }}" alt="{{ $article->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                        
                        {{-- Keterangan di pojok kiri bawah (Overlap) + Rating --}}
                        <div class="absolute bottom-0 left-0 bg-[#FAF9F6] rounded-tr-[16px] flex items-center pr-4 shadow-sm">
                            <span class="inline-block px-[14px] py-[10px] text-[#C58F59] font-bold text-[16px]">{{ $article->category }}</span>
                            <div class="flex items-center gap-1.5 text-[#FFB800] border-l border-[#C58F59]/20 pl-3">
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                </svg>
                                <span class="text-[15px] font-bold">{{ number_format($article->rating, 1) }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Content --}}
                    <div class="flex flex-col flex-grow mt-[20px]">
                        <h3 class="font-bold text-[20px] text-[#582C0C] leading-tight group-hover:text-[#C58F59] transition-colors">
                            {{ $article->title }}
                        </h3>
                        <p class="font-medium text-[14px] text-[#6B513E] leading-relaxed mt-[10px] flex-grow line-clamp-3 opacity-80">
                            {{ $article->description }}
                        </p>
                        
                        {{-- Button Selengkapnya --}}
                        <a href="{{ route('artikel.show', $article->slug) }}" class="inline-flex items-center justify-center font-bold text-[16px] text-[#F7F7F7] bg-[#C58F59] rounded-xl px-[20px] py-[10px] mt-[24px] self-start transition-all hover:bg-[#B37E4A] hover:shadow-lg hover:-translate-y-0.5">
                            Selengkapnya 
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M12 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </article>
                @empty
                <div class="col-span-full py-20 text-center flex flex-col items-center justify-center">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-6">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-[#582C0C] mb-2">Belum Ada Artikel</h3>
                    <p class="text-[#6B513E]">Konten menarik sedang disiapkan untuk Anda.</p>
                </div>
                @endforelse
            </div>
            
            {{-- Pagination / Halaman --}}
            @if ($articles->hasPages())
            <div class="flex justify-center items-center gap-[10px] mt-[60px]">
                {{-- Arrow Kiri --}}
                @if ($articles->onFirstPage())
                    <span class="inline-flex items-center justify-center w-[44px] h-[44px] rounded-full border border-[#C58F59]/20 text-[#582C0C]/30 bg-transparent cursor-not-allowed">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </span>
                @else
                    <a href="{{ $articles->previousPageUrl() }}" class="inline-flex items-center justify-center w-[44px] h-[44px] rounded-full border border-[#C58F59] text-[#582C0C] bg-transparent hover:bg-[#E5D6C5] transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </a>
                @endif
                
                {{-- Angka Halaman --}}
                @foreach ($articles->getUrlRange(1, $articles->lastPage()) as $page => $url)
                    @if ($page == $articles->currentPage())
                        <span class="inline-flex items-center justify-center min-w-[44px] h-[44px] rounded-full bg-[#C58F59] text-[#F7F7F7] font-bold text-[18.75px] px-[10px] shadow-md">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}" class="inline-flex items-center justify-center min-w-[44px] h-[44px] rounded-full border border-[#C58F59] bg-transparent text-[#582C0C] font-bold text-[18.75px] px-[10px] hover:bg-[#E5D6C5] transition-colors">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach
                
                {{-- Arrow Kanan --}}
                @if ($articles->hasMorePages())
                    <a href="{{ $articles->nextPageUrl() }}" class="inline-flex items-center justify-center w-[44px] h-[44px] rounded-full border border-[#C58F59] text-[#582C0C] bg-transparent hover:bg-[#E5D6C5] transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                @else
                    <span class="inline-flex items-center justify-center w-[44px] h-[44px] rounded-full border border-[#C58F59]/20 text-[#582C0C]/30 bg-transparent cursor-not-allowed">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </span>
                @endif
            </div>
            @endif

        </div>
    </main>

    {{-- Footer --}}
    @include('user.components.footerWelcome')

    {{-- Script untuk auto-reset pencarian --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.querySelector('input[name="search"]');
            let resetTimer;

            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    clearTimeout(resetTimer);
                    if (this.value.trim() === '') {
                        resetTimer = setTimeout(() => {
                            window.location.href = "{{ route('artikel') }}";
                        }, 800);
                    }
                });
            }
        });
    </script>
</body>
</html>