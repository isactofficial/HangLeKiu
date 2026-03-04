<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hanglekiu Dental — Selamat Datang</title>
    <meta name="description" content="Hanglekiu Dental — Klinik gigi terpercaya. Login atau daftar untuk mengakses layanan kami.">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-[var(--font-color-primary)] m-0 min-h-screen flex flex-col relative">

    {{-- Navbar --}}
    @include('components.navbarWelcome')

    {{-- Hero Section --}}
    <section class="relative w-full h-screen flex items-end">
        {{-- Background Image --}}
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('images/bg-homepage.png') }}" alt="Hanglekiu Dental Specialist"
                 class="w-full h-full object-cover">
            {{-- Gradient overlay bottom --}}
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent"></div>
        </div>

        {{-- Hero Content --}}
        <div class="relative z-10 w-full max-w-7xl mx-auto px-6 md:px-10 lg:px-9 pb-36 md:pb-44">
            <h1 class="text-3xl md:text-[42px] font-bold text-white leading-tight mb-4">
                Hanglekiu Dental Specialist
            </h1>

            <p class="text-base md:text-xl font-medium text-white/90 max-w-4xl leading-relaxed mb-8">
                Wujudkan Senyum Ideal Anda Melalui Dedikasi Tim Profesional Kami Yang Menghadirkan<br>
                Standar Perawatan Gigi Dengan Keahlian Dan Presisi Medis Terbaik.
            </p>

            <div class="flex flex-wrap items-center gap-4">
                {{-- Buat Janji Temu → /registration --}}
                <a href="{{ route('registration.form') }}"
                   class="px-8 py-3 bg-primary hover:bg-primary/90 text-white text-base md:text-lg font-medium rounded-full transition-all duration-200 hover:shadow-lg">
                    Buat Janji Temu
                </a>

                {{-- Hubungi Kami --}}
                <a href="https://wa.me/6281234567890" target="_blank" rel="noopener"
                   class="px-8 py-3 bg-primary hover:bg-primary/90 text-white text-base md:text-lg font-medium rounded-full transition-all duration-200 hover:shadow-lg flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                    Hubungi Kami
                </a>
            </div>
        </div>
    </section>

    {{-- Section: Pelayanan & Profil Dokter --}}
    <section id="pelayanan" class="w-full bg-[var(--color-background-primary)] flex flex-col overflow-hidden py-10">

        {{-- Pelayanan — 1/4 --}}
        <div class="w-full py-6">
            <div class="max-w-7xl mx-auto px-6 md:px-10 lg:px-16">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                    {{-- Card 1: Indah Alami --}}
                    <div class="text-center">
                        <div class="w-14 h-14 mx-auto mb-3 bg-[#C58F59] rounded-lg flex items-center justify-center overflow-hidden p-2.5">
                            <img src="{{ asset('images/indah.svg') }}" alt="Indah Alami" class="w-full h-full object-cover">
                        </div>
                        <h3 class="text-2xl font-bold text-[var(--font-color-primary)] mb-2">Indah Alami</h3>
                        <p class="text-base font-normal text-[var(--font-color-secondary)] leading-tight">
                            Perpaduan kedokteran mutakhir dan sentuhan seni untuk hasil restorasi yang fungsional serta indah alami.
                        </p>
                    </div>

                    {{-- Card 2: Ramah Terstandarisasi --}}
                    <div class="text-center">
                        <div class="w-14 h-14 mx-auto mb-3 bg-[#C58F59] rounded-lg flex items-center justify-center overflow-hidden p-2.5">
                            <img src="{{ asset('images/ramah.svg') }}" alt="Ramah Terstandarisasi" class="w-full h-full object-cover">
                        </div>
                        <h3 class="text-2xl font-bold text-[var(--font-color-primary)] mb-2">Ramah Terstandarisasi</h3>
                        <p class="text-base font-normal text-[var(--font-color-secondary)] leading-tight">
                            Pengalaman dental menenangkan melalui layanan personal dan privasi mutlak guna menghargai waktu berharga Anda.
                        </p>
                    </div>

                    {{-- Card 3: Teknologi Mutakhir --}}
                    <div class="text-center">
                        <div class="w-14 h-14 mx-auto mb-3 bg-[#C58F59] rounded-lg flex items-center justify-center overflow-hidden p-2.5">
                            <img src="{{ asset('images/teknologi.svg') }}" alt="Teknologi Mutakhir" class="w-full h-full object-cover">
                        </div>
                        <h3 class="text-2xl font-bold text-[var(--font-color-primary)] mb-2">Teknologi Mutakhir</h3>
                        <p class="text-base font-normal text-[var(--font-color-secondary)] leading-tight">
                            Pemanfaatan teknologi dental kelas dunia guna memastikan hasil perawatan yang akurat, aman, dan tanpa trauma.
                        </p>
                    </div>

                </div>
            </div>
        </div>

        {{-- Profil Dokter — 3/4 --}}
        <div id="klinik" class="w-full flex-1 mt-16">
            <div class="max-w-7xl mx-auto px-6 md:px-10 lg:px-16 h-full">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-center h-full">

                    {{-- Left: Doctor Image --}}
                    <div class="relative flex justify-center items-end h-full">
                        {{-- Background decorative badges --}}
                        <div class="absolute top-8 left-8 w-16 h-16 bg-primary/15 rounded-full flex items-center justify-center">
                            <img src="{{ asset('images/logo-hds.png') }}" alt="Logo" class="w-10 h-10 object-contain">
                        </div>
                        <div class="absolute top-8 right-12 w-16 h-16 bg-[var(--font-color-primary)]/10 rounded-full flex items-center justify-center">
                            <img src="{{ asset('images/logo-hds.png') }}" alt="Badge" class="w-10 h-10 object-contain">
                        </div>

                        {{-- Doctor photo --}}
                        <div class="w-full max-w-4xl">
                            <img src="{{ asset('images/budok.png') }}" alt="Dokter Spesialis"
                                 class="w-full h-auto object-contain scale-110 origin-bottom">
                        </div>
                    </div>

                    {{-- Right: Doctor Info --}}
                    <div>
                        <h2 class="text-4xl md:text-5xl font-bold text-[var(--font-color-primary)] leading-tight mb-1">
                            Jenny Wilson Sp.Ort
                        </h2>
                        <p class="text-base font-medium text-[var(--font-color-secondary)] mb-6">
                            <span class="italic">Spesialis Orthodonti</span> &nbsp;|&nbsp; No. STR: 3122100318012345
                        </p>

                        <p class="text-[var(--fs-md)] font-normal text-[var(--font-color-secondary)] leading-relaxed mb-5 text-justify">
                            Lulusan Universitas Indonesia Yang Kemudian Mendalami Spesialisasi Di University Of Adelaide, Beliau Telah Berdedikasi Selama Lebih Dari 12 Tahun Dalam Menangani Kasus Maloklusi Kompleks. Keahlian Beliau Berfokus Pada Penyelarasan Struktur Wajah Melalui Perpaduan Presisi Medis Dan Teknologi Ortodonti Terkini Untuk Menciptakan Profil Senyum Yang Harmonis Serta Fungsional.
                        </p>

                        {{-- Social Media --}}
                        <div class="flex items-center gap-3 mb-16">
                            <a href="#" class="w-7 h-7 bg-[var(--font-color-primary)] rounded-full flex items-center justify-center hover:opacity-80 transition-opacity">
                                <svg class="w-3.5 h-3.5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
                                </svg>
                            </a>
                            <a href="#" class="w-7 h-7 bg-[var(--font-color-primary)] rounded-full flex items-center justify-center hover:opacity-80 transition-opacity">
                                <svg class="w-3.5 h-3.5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                </svg>
                            </a>
                        </div>

                        {{-- Navigation Arrows --}}
                        <div class="flex items-center gap-3">
                            <button class="px-8 py-2 bg-primary hover:bg-primary/90 rounded-full flex items-center justify-center transition-all duration-200 text-white">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
                                </svg>
                            </button>
                            <button class="px-8 py-2 bg-primary hover:bg-primary/90 rounded-full flex items-center justify-center transition-all duration-200 text-white">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </section>

    {{-- Section: Layanan & Perawatan --}}
    <section class="w-full bg-[#C58F59] min-h-screen flex flex-col justify-center py-14 md:py-20">
        <div class="max-w-7xl mx-auto px-6 md:px-10 lg:px-16">
            
            {{-- Section Header --}}
            <div class="text-center mb-10">
                <span class="inline-block text-[var(--fs-sm)] font-medium tracking-widest uppercase text-white/70 mb-2">Our Services</span>
                <h2 class="text-[var(--fs-xl)] font-semibold text-white mb-3">
                    Layanan & Perawatan
                </h2>
                <p class="text-[var(--fs-md)] font-normal text-white/85 max-w-2xl mx-auto">
                    Layanan dental menyeluruh yang ditangani oleh tim profesional dengan standar medis terbaik.
                </p>
            </div>

            {{-- Cards Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 mb-10">
                
                {{-- Card 1: Scaling & Polishing --}}
                <div class="group bg-white/95 backdrop-blur rounded-2xl p-5 shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col">
                    <div class="w-14 h-14 mb-3 mx-auto bg-[#C58F59]/10 rounded-xl flex items-center justify-center">
                        <img src="{{ asset('images/gigi.svg') }}" alt="Icon" class="w-9 h-9 object-contain">
                    </div>
                    <h3 class="text-[var(--fs-lg)] font-bold text-[#582C0C] mb-2 text-center">Scaling & Polishing</h3>
                    <p class="text-[var(--fs-sm)] font-normal text-[#582C0C]/75 leading-relaxed mb-4 flex-1 text-center">
                        Pembersihan karang gigi profesional untuk menjaga kesehatan gusi dan gigi.
                    </p>
                    <button class="text-[var(--fs-sm)] font-semibold text-[#C58F59] flex items-center gap-1.5 hover:gap-2.5 transition-all mx-auto group-hover:text-[#A0703E]">
                        Selengkapnya
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                        </svg>
                    </button>
                </div>

                {{-- Card 2: Tambal Gigi --}}
                <div class="group bg-white/95 backdrop-blur rounded-2xl p-5 shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col">
                    <div class="w-14 h-14 mb-3 mx-auto bg-[#C58F59]/10 rounded-xl flex items-center justify-center">
                        <img src="{{ asset('images/gigi.svg') }}" alt="Icon" class="w-9 h-9 object-contain">
                    </div>
                    <h3 class="text-[var(--fs-lg)] font-bold text-[#582C0C] mb-2 text-center">Tambal Gigi</h3>
                    <p class="text-[var(--fs-sm)] font-normal text-[#582C0C]/75 leading-relaxed mb-4 flex-1 text-center">
                        Perawatan restorasi gigi berlubang dengan bahan berkualitas tinggi.
                    </p>
                    <button class="text-[var(--fs-sm)] font-semibold text-[#C58F59] flex items-center gap-1.5 hover:gap-2.5 transition-all mx-auto group-hover:text-[#A0703E]">
                        Selengkapnya
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                        </svg>
                    </button>
                </div>

                {{-- Card 3: Cabut Gigi --}}
                <div class="group bg-white/95 backdrop-blur rounded-2xl p-5 shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col">
                    <div class="w-14 h-14 mb-3 mx-auto bg-[#C58F59]/10 rounded-xl flex items-center justify-center">
                        <img src="{{ asset('images/gigi.svg') }}" alt="Icon" class="w-9 h-9 object-contain">
                    </div>
                    <h3 class="text-[var(--fs-lg)] font-bold text-[#582C0C] mb-2 text-center">Cabut Gigi</h3>
                    <p class="text-[var(--fs-sm)] font-normal text-[#582C0C]/75 leading-relaxed mb-4 flex-1 text-center">
                        Prosedur pencabutan gigi yang aman dan minim rasa sakit.
                    </p>
                    <button class="text-[var(--fs-sm)] font-semibold text-[#C58F59] flex items-center gap-1.5 hover:gap-2.5 transition-all mx-auto group-hover:text-[#A0703E]">
                        Selengkapnya
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                        </svg>
                    </button>
                </div>

                {{-- Card 4: Pemasangan Behel --}}
                <div class="group bg-white/95 backdrop-blur rounded-2xl p-5 shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col">
                    <div class="w-14 h-14 mb-3 mx-auto bg-[#C58F59]/10 rounded-xl flex items-center justify-center">
                        <img src="{{ asset('images/gigi.svg') }}" alt="Icon" class="w-9 h-9 object-contain">
                    </div>
                    <h3 class="text-[var(--fs-lg)] font-bold text-[#582C0C] mb-2 text-center">Pemasangan Behel</h3>
                    <p class="text-[var(--fs-sm)] font-normal text-[#582C0C]/75 leading-relaxed mb-4 flex-1 text-center">
                        Ortodonti untuk merapikan susunan gigi dengan hasil optimal.
                    </p>
                    <button class="text-[var(--fs-sm)] font-semibold text-[#C58F59] flex items-center gap-1.5 hover:gap-2.5 transition-all mx-auto group-hover:text-[#A0703E]">
                        Selengkapnya
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                        </svg>
                    </button>
                </div>

                {{-- Card 5: Veneer Gigi --}}
                <div class="group bg-white/95 backdrop-blur rounded-2xl p-5 shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col">
                    <div class="w-14 h-14 mb-3 mx-auto bg-[#C58F59]/10 rounded-xl flex items-center justify-center">
                        <img src="{{ asset('images/gigi.svg') }}" alt="Icon" class="w-9 h-9 object-contain">
                    </div>
                    <h3 class="text-[var(--fs-lg)] font-bold text-[#582C0C] mb-2 text-center">Veneer Gigi</h3>
                    <p class="text-[var(--fs-sm)] font-normal text-[#582C0C]/75 leading-relaxed mb-4 flex-1 text-center">
                        Lapisan tipis untuk mempercantik tampilan gigi Anda.
                    </p>
                    <button class="text-[var(--fs-sm)] font-semibold text-[#C58F59] flex items-center gap-1.5 hover:gap-2.5 transition-all mx-auto group-hover:text-[#A0703E]">
                        Selengkapnya
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                        </svg>
                    </button>
                </div>

                {{-- Card 6: Crown & Bridge --}}
                <div class="group bg-white/95 backdrop-blur rounded-2xl p-5 shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col">
                    <div class="w-14 h-14 mb-3 mx-auto bg-[#C58F59]/10 rounded-xl flex items-center justify-center">
                        <img src="{{ asset('images/gigi.svg') }}" alt="Icon" class="w-9 h-9 object-contain">
                    </div>
                    <h3 class="text-[var(--fs-lg)] font-bold text-[#582C0C] mb-2 text-center">Crown & Bridge</h3>
                    <p class="text-[var(--fs-sm)] font-normal text-[#582C0C]/75 leading-relaxed mb-4 flex-1 text-center">
                        Restorasi gigi permanen dengan mahkota dan jembatan gigi.
                    </p>
                    <button class="text-[var(--fs-sm)] font-semibold text-[#C58F59] flex items-center gap-1.5 hover:gap-2.5 transition-all mx-auto group-hover:text-[#A0703E]">
                        Selengkapnya
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                        </svg>
                    </button>
                </div>

            </div>

            {{-- Button Layanan Lainnya --}}
            <div class="flex justify-center">
                <button class="px-8 py-3 bg-[#582C0C] hover:bg-[#3E1E07] text-white text-[var(--fs-sm)] font-semibold rounded-full transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5">
                    Layanan Lainnya
                </button>
            </div>

        </div>
    </section>

</body>
</html>
