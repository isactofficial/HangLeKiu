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
        <div class="max-w-7xl mx-auto px-6 md:px-10 lg:px-16 py-10 text-center">
            <h1 class="text-3xl md:text-[48px] font-bold text-[#582C0C] mb-2 leading-tight">
                Artikel
            </h1>
            <p class="text-[#6B513E] text-[18.75px] max-w-2xl mx-auto leading-relaxed">
                Wawasan eksklusif seputar kesehatan gigi
            </p>
        </div>

        {{-- Filter Section --}}
        <div class="max-w-7xl mx-auto px-6 md:px-10 lg:px-16 mb-10 flex flex-col lg:flex-row justify-between items-center gap-6">
            <div class="flex flex-wrap justify-center lg:justify-start gap-2">
                @php
                    $filters = ['Semua', 'Estetika', 'Spesialis', 'Teknologi', 'Gigi Anak', 'Tips and Trick'];
                    $activeFilter = 'Semua';
                @endphp
                @foreach ($filters as $filter)
                    <a href="#" class="px-4 py-3 rounded-full border-2 border-[#C58F59] font-medium text-[18.75px] transition-colors duration-300 {{ $filter === $activeFilter ? 'bg-[#C58F59] text-white' : 'text-[#C58F59] hover:bg-[#C58F59] hover:text-white' }}">
                        {{ $filter }}
                    </a>
                @endforeach
            </div>

            {{-- Search Bar --}}
            <div class="flex items-center px-6 py-3 bg-[#E5D6C5] border-2 border-[#C58F59] rounded-full cursor-pointer">
                <span class="text-[#6B513E] font-medium text-[18.75px]">Cari Artikel</span>
                <svg class="w-6 h-6 text-[#C58F59] ml-[120px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
        </div>

        {{-- Grid Artikel --}}
        <div class="max-w-7xl mx-auto px-6 md:px-10 lg:px-16 pb-24">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-[40px]">
                
                @php
                    $artikelImages = [
                        'Gemini_Generated_Image_5gzzya5gzzya5gzz 1.png',
                        'Gemini_Generated_Image_cbmdtkcbmdtkcbmd 1.png',
                        'Gemini_Generated_Image_ea77ekea77ekea77 1.png',
                        'Gemini_Generated_Image_eabpqpeabpqpeabp 1.png',
                        'Gemini_Generated_Image_vs0bfkvs0bfkvs0b 1.png',
                        'Gemini_Generated_Image_z3m7mrz3m7mrz3m7 1.png'
                    ];
                    $artikelLabels = ['Spesialis', 'Estetika', 'Teknologi', 'Gigi Anak', 'Tips and Trick', 'Spesialis'];
                @endphp

                @foreach ($artikelImages as $index => $image)
                <article class="flex flex-col h-full bg-transparent">
                    {{-- Image with Cutout Label --}}
                    <div class="relative w-full aspect-[4/3] rounded-t-[16px] overflow-hidden">
                        <img src="{{ asset('images/artikel/' . $image) }}" alt="Artikel image" class="w-full h-full object-cover">
                        
                        {{-- Keterangan di pojok kiri atas/bawah (Overlap) --}}
                        <div class="absolute bottom-0 left-0 bg-[#FAF9F6] rounded-tr-[16px]">
                            <span class="inline-block px-[8px] py-[8px] text-[#C58F59] font-medium text-[18.75px]">{{ $artikelLabels[$index] }}</span>
                        </div>
                    </div>

                    {{-- Content --}}
                    <div class="flex flex-col flex-grow mt-[16px]">
                        <h3 class="font-bold text-[18.75px] text-[#582C0C] leading-snug">
                            Mengapa Penanganan Spesialis Itu Krusial?
                        </h3>
                        <p class="font-medium text-[12px] text-[#6B513E] leading-relaxed mt-[8px] flex-grow line-clamp-3">
                            Mengenal lebih dekat dedikasi tim spesialis di Hanglekiu Dental Specialist dalam memastikan setiap prosedur medis dilakukan dengan tingkat presisi dan akurasi tertinggi...
                        </p>
                        
                        {{-- Button Selengkapnya --}}
                        <a href="#" class="inline-flex items-center justify-center font-normal text-[18.75px] text-[#F7F7F7] bg-[#C58F59] rounded-xl px-[12px] py-[8px] mt-[20px] self-start transition-colors hover:bg-[#B37E4A]">
                            Selengkapnya 
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M12 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </article>
                @endforeach
            </div>
            
            {{-- Pagination / Halaman --}}
            <div class="flex justify-center items-center gap-[10px] mt-[60px]">
                {{-- Arrow Kiri (Inactive) --}}
                <a href="#" class="inline-flex items-center justify-center w-[44px] h-[44px] rounded-full border border-[#C58F59] text-[#582C0C] bg-transparent hover:bg-[#E5D6C5] transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                
                {{-- Angka Aktif --}}
                <a href="#" class="inline-flex items-center justify-center min-w-[44px] h-[44px] rounded-full bg-[#C58F59] text-[#F7F7F7] font-bold text-[18.75px] px-[10px] py-[10px]">
                    1
                </a>
                
                {{-- Angka Inactive --}}
                <a href="#" class="inline-flex items-center justify-center min-w-[44px] h-[44px] rounded-full border border-[#C58F59] bg-transparent text-[#582C0C] font-bold text-[18.75px] px-[10px] py-[10px] hover:bg-[#E5D6C5] transition-colors">
                    2
                </a>
                
                <a href="#" class="inline-flex items-center justify-center min-w-[44px] h-[44px] rounded-full border border-[#C58F59] bg-transparent text-[#582C0C] font-bold text-[18.75px] px-[10px] py-[10px] hover:bg-[#E5D6C5] transition-colors">
                    3
                </a>
                
                {{-- Arrow Kanan --}}
                <a href="#" class="inline-flex items-center justify-center w-[44px] h-[44px] rounded-full border border-[#C58F59] text-[#582C0C] bg-transparent hover:bg-[#E5D6C5] transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>

        </div>
        </div>
    </main>

    {{-- Footer --}}
    @include('user.components.footerWelcome')

</body>
</html>