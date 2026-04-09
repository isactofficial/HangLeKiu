<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hanglekiu Dental — Selamat Datang</title>
    <meta name="description"
        content="Hanglekiu Dental — Klinik gigi terpercaya. Login atau daftar untuk mengakses layanan kami.">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-[var(--font-color-primary)] m-0 min-h-screen flex flex-col relative bg-white">

    {{-- Navbar --}}
    @include('user.components.navbarWelcome')

    {{-- Hero Section --}}
    <section id="hero-section" class="relative w-full h-[calc(100vh-60px)] flex items-end overflow-hidden">
        {{-- Background Image --}}
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('images/bg-homepage.png') }}" alt="Hanglekiu Dental Specialist"
                class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent"></div>
        </div>

        <div class="relative z-10 w-full max-w-7xl mx-auto px-6 md:px-10 lg:px-9 pb-16 md:pb-20">
            <h1 class="text-[38px] md:text-[42px] font-bold text-white leading-tight mb-4">
                Hanglekiu Dental Specialist
            </h1>

            <p class="text-[15px] md:text-xl font-medium text-white/90 max-w-4xl leading-relaxed mb-8">
                Wujudkan Senyum Ideal Anda Melalui Dedikasi Tim Profesional Kami Yang Menghadirkan<br>
                Standar Perawatan Gigi Dengan Keahlian Dan Presisi Medis Terbaik.
            </p>

            <div class="flex flex-wrap items-center gap-4">
                <a href="{{ route('registration.form') }}"
                    class="px-[18px] py-[12px] bg-primary hover:bg-primary/90 text-white text-[15px] md:text-lg font-medium rounded-full transition-all duration-200 hover:shadow-lg">
                    Buat Janji Temu
                </a>

                <a href="https://wa.me/6281234567890" target="_blank" rel="noopener"
                    class="px-[18px] py-[12px] bg-primary hover:bg-primary/90 text-white text-[15px] md:text-lg font-medium rounded-full transition-all duration-200 hover:shadow-lg flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                    Hubungi Kami
                </a>
            </div>
        </div>
    </section>

    {{-- Section: Pelayanan & Profil Dokter --}}
    <section id="pelayanan" class="w-full bg-white flex flex-col overflow-hidden py-10">

        <div class="w-full py-6">
            <div class="max-w-7xl mx-auto px-6 md:px-10 lg:px-16">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                    <div class="text-center">
                        <div
                            class="w-14 h-14 mx-auto mb-3 bg-[#C58F59] rounded-lg flex items-center justify-center overflow-hidden p-2.5">
                            <img src="{{ asset('images/indah.svg') }}" alt="Indah Alami"
                                class="w-full h-full object-cover">
                        </div>
                        <h3 class="text-[24px] md:text-2xl font-bold text-[var(--font-color-primary)] mb-2">Indah Alami
                        </h3>
                        <p
                            class="text-[15px] md:text-base font-normal text-[var(--font-color-secondary)] leading-tight">
                            Perpaduan kedokteran mutakhir dan sentuhan seni untuk hasil restorasi yang fungsional serta
                            indah alami.
                        </p>
                    </div>

                    <div class="text-center">
                        <div
                            class="w-14 h-14 mx-auto mb-3 bg-[#C58F59] rounded-lg flex items-center justify-center overflow-hidden p-2.5">
                            <img src="{{ asset('images/ramah.svg') }}" alt="Ramah Terstandarisasi"
                                class="w-full h-full object-cover">
                        </div>
                        <h3 class="text-[24px] md:text-2xl font-bold text-[var(--font-color-primary)] mb-2">Ramah
                            Terstandarisasi</h3>
                        <p
                            class="text-[15px] md:text-base font-normal text-[var(--font-color-secondary)] leading-tight">
                            Pengalaman dental menenangkan melalui layanan personal dan privasi mutlak guna menghargai
                            waktu berharga Anda.
                        </p>
                    </div>

                    <div class="text-center">
                        <div
                            class="w-14 h-14 mx-auto mb-3 bg-[#C58F59] rounded-lg flex items-center justify-center overflow-hidden p-2.5">
                            <img src="{{ asset('images/teknologi.svg') }}" alt="Teknologi Mutakhir"
                                class="w-full h-full object-cover">
                        </div>
                        <h3 class="text-[24px] md:text-2xl font-bold text-[var(--font-color-primary)] mb-2">Teknologi
                            Mutakhir</h3>
                        <p
                            class="text-[15px] md:text-base font-normal text-[var(--font-color-secondary)] leading-tight">
                            Pemanfaatan teknologi dental kelas dunia guna memastikan hasil perawatan yang akurat, aman,
                            dan tanpa trauma.
                        </p>
                    </div>

                </div>
            </div>
        </div>

        {{-- Profil Dokter — 3/4 --}}
        <div id="klinik" class="w-full flex-1 mt-4 md:mt-16">
            <div class="max-w-7xl mx-auto px-6 md:px-10 lg:px-16 h-full">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-center h-full">

                    {{-- Left: Doctor Image Carousel --}}
                    <div class="relative flex justify-center items-end h-[400px] md:h-[640px]">

                        {{-- Carousel Container --}}
                        <div id="doctor-carousel"
                            class="relative w-full flex justify-center items-end overflow-hidden h-[500px] md:h-[640px]">
                            {{-- 7 slots: hidden-left, far-left, left, center, right, far-right, hidden-right --}}
                            <div class="doctor-slot absolute bottom-8 md:bottom-24"
                                style="left:-39%; width:42%; z-index:0; opacity:0; filter:blur(2px); transition: left 700ms cubic-bezier(0.25,0.1,0.25,1), width 700ms cubic-bezier(0.25,0.1,0.25,1), opacity 700ms cubic-bezier(0.25,0.1,0.25,1), filter 700ms cubic-bezier(0.25,0.1,0.25,1);">
                                <img src="" alt=""
                                    class="w-full h-auto object-contain scale-[1.3] origin-bottom md:scale-100 transition-transform duration-300">
                            </div>
                            <div class="doctor-slot absolute bottom-8 md:bottom-24"
                                style="left:-8%; width:44%; z-index:1; opacity:0.3; filter:blur(1px); transition: left 700ms cubic-bezier(0.25,0.1,0.25,1), width 700ms cubic-bezier(0.25,0.1,0.25,1), opacity 700ms cubic-bezier(0.25,0.1,0.25,1), filter 700ms cubic-bezier(0.25,0.1,0.25,1);">
                                <img src="" alt=""
                                    class="w-full h-auto object-contain scale-[1.3] origin-bottom md:scale-100 transition-transform duration-300">
                            </div>
                            <div class="doctor-slot absolute bottom-8 md:bottom-24"
                                style="left:4%; width:52%; z-index:2; opacity:0.5; filter:blur(0.5px); transition: left 700ms cubic-bezier(0.25,0.1,0.25,1), width 700ms cubic-bezier(0.25,0.1,0.25,1), opacity 700ms cubic-bezier(0.25,0.1,0.25,1), filter 700ms cubic-bezier(0.25,0.1,0.25,1);">
                                <img src="" alt=""
                                    class="w-full h-auto object-contain scale-[1.3] origin-bottom md:scale-100 transition-transform duration-300">
                            </div>
                            <div class="doctor-slot absolute bottom-8 md:bottom-24"
                                style="left:19%; width:66%; z-index:5; opacity:1; filter:blur(0px); transition: left 700ms cubic-bezier(0.25,0.1,0.25,1), width 700ms cubic-bezier(0.25,0.1,0.25,1), opacity 700ms cubic-bezier(0.25,0.1,0.25,1), filter 700ms cubic-bezier(0.25,0.1,0.25,1);">
                                <img src="" alt=""
                                    class="w-full h-auto object-contain drop-shadow-2xl scale-[1.3] origin-bottom md:scale-100 transition-transform duration-300">
                            </div>
                            <div class="doctor-slot absolute bottom-8 md:bottom-24"
                                style="left:48%; width:52%; z-index:2; opacity:0.5; filter:blur(0.5px); transition: left 700ms cubic-bezier(0.25,0.1,0.25,1), width 700ms cubic-bezier(0.25,0.1,0.25,1), opacity 700ms cubic-bezier(0.25,0.1,0.25,1), filter 700ms cubic-bezier(0.25,0.1,0.25,1);">
                                <img src="" alt=""
                                    class="w-full h-auto object-contain scale-[1.3] origin-bottom md:scale-100 transition-transform duration-300">
                            </div>
                            <div class="doctor-slot absolute bottom-8 md:bottom-24"
                                style="left:66%; width:44%; z-index:1; opacity:0.3; filter:blur(1px); transition: left 700ms cubic-bezier(0.25,0.1,0.25,1), width 700ms cubic-bezier(0.25,0.1,0.25,1), opacity 700ms cubic-bezier(0.25,0.1,0.25,1), filter 700ms cubic-bezier(0.25,0.1,0.25,1);">
                                <img src="" alt=""
                                    class="w-full h-auto object-contain scale-[1.3] origin-bottom md:scale-100 transition-transform duration-300">
                            </div>
                            <div class="doctor-slot absolute bottom-8 md:bottom-24"
                                style="left:97%; width:42%; z-index:0; opacity:0; filter:blur(2px); transition: left 700ms cubic-bezier(0.25,0.1,0.25,1), width 700ms cubic-bezier(0.25,0.1,0.25,1), opacity 700ms cubic-bezier(0.25,0.1,0.25,1), filter 700ms cubic-bezier(0.25,0.1,0.25,1);">
                                <img src="" alt=""
                                    class="w-full h-auto object-contain scale-[1.3] origin-bottom md:scale-100 transition-transform duration-300">
                            </div>


                            {{-- Graduation Badges — kanan, berdampingan, lurus --}}
                            <div id="doctor-badges-container"
                                class="absolute right-[10px] md:right-[16px] bottom-[0px] md:bottom-[110px] z-10 flex flex-row gap-1 items-center pointer-events-none">
                                <img id="doctor-badge-1" src="{{ asset('images/dokter_animate/lulusan1.png') }}"
                                    alt="Lulusan 1"
                                    class="w-[90px] h-[90px] md:w-[110px] md:h-[110px] object-contain object-center opacity-100 transition-opacity duration-[180ms] block" />
                                <img id="doctor-badge-2" src="{{ asset('images/dokter_animate/lulusan2.png') }}"
                                    alt="Lulusan 2"
                                    class="w-[90px] h-[90px] md:w-[110px] md:h-[110px] object-contain object-center opacity-100 transition-opacity duration-[180ms] block" />
                            </div>
                        </div>
                    </div>

                    {{-- Right: Doctor Info --}}
                    <div>
                        <h2 id="doctor-name"
                            class="text-[35px] md:text-48 font-bold text-[var(--font-color-primary)] leading-tight mb-1">
                            Jenny Wilson Sp.Ort
                        </h2>
                        <p id="doctor-subtitle"
                            class="text-[15px] md:text-[18.75px] italic font-medium text-[var(--font-color-secondary)] mb-6">
                            Spesialis Orthodonti &nbsp;|&nbsp; No. STR: 3122100318012345
                        </p>

                        <p id="doctor-bio"
                            class="text-[15px] md:text-[var(--fs-md)] font-normal text-[var(--font-color-secondary)] leading-relaxed mb-5 text-justify">
                            Lulusan Universitas Indonesia & University of Adelaide. 12+ tahun pengalaman ortodonti,
                            fokus pada maloklusi kompleks dan teknologi ortodonti modern.
                        </p>

                        <div class="flex flex-row justify-between items-center md:flex-col md:items-start w-full">

                            {{-- Social Media --}}
                            <div class="flex items-center gap-3 mb-0 md:mb-16">
                                <a href="https://www.instagram.com/"
                                    class="w-7 h-7 bg-[var(--font-color-primary)] rounded-full flex items-center justify-center hover:opacity-80 transition-opacity">
                                    <svg class="w-3.5 h-3.5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z" />
                                    </svg>
                                </a>
                                <a href="https://www.linkedin.com/"
                                    class="w-7 h-7 bg-[var(--font-color-primary)] rounded-full flex items-center justify-center hover:opacity-80 transition-opacity">
                                    <svg class="w-3.5 h-3.5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                                    </svg>
                                </a>
                            </div>

                            {{-- Navigation Arrows --}}
                            <div class="flex items-center gap-3">
                                <button id="doctor-prev"
                                    class="px-8 py-2 bg-primary hover:bg-primary/90 rounded-full flex items-center justify-center transition-all duration-200 text-white">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                                    </svg>
                                </button>
                                <button id="doctor-next"
                                    class="px-8 py-2 bg-primary hover:bg-primary/90 rounded-full flex items-center justify-center transition-all duration-200 text-white">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                    </svg>
                                </button>
                            </div>

                        </div>


                    </div>

                </div>
            </div>
        </div>

    </section>

    {{-- Section: Layanan & Perawatan --}}
    <section class="w-full bg-white min-h-screen flex flex-col justify-center py-8 md:py-20">
        <div class="max-w-7xl mx-auto px-6 md:px-10 lg:px-16 w-full">
            <div class="bg-[#E5D6C5] rounded-3xl px-4 md:px-10 py-11 md:px-14 md:py-11">

                {{-- Section Header --}}
                <div class="text-center mb-10">
                    <h2 class="text-[24px] md:text-[48px] font-bold text-[#582C0C] mb-[12px]">
                        Layanan & Perawatan
                    </h2>
                    <p
                        class="text-[15px] md:text-[18.75px] font-normal text-[#582C0C] max-w-3xl mx-auto leading-relaxed">
                        Layanan dental menyeluruh yang ditangani oleh tim klinis dan dokter spesialis secara
                        terintegrasi untuk memberikan standar perawatan tertinggi pada setiap kunjungan Anda.
                    </p>
                </div>

                {{-- Cards Grid --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 mb-10">

                    {{-- Card 1: Scaling & Polishing --}}
                    <div
                        class="bg-white rounded-2xl p-8 shadow-md hover:shadow-lg transition-shadow duration-300 flex flex-col min-h-[340px]">
                        <div class="mb-4 mx-auto">
                            <img src="{{ asset('images/gigi.svg') }}" alt="Icon"
                                class="w-20 h-20 object-contain">
                        </div>
                        <h3 class="text-[24px] md:text-[30px] font-bold text-[#C58F59] mb-3 text-center">Scaling &
                            Polishing</h3>
                        <p
                            class="text-[15px] md:text-[18.75px] font-normal text-[#582C0C] leading-relaxed mb-5 flex-1 text-center">
                            Pembersihan karang gigi profesional untuk menjaga kesehatan gusi dan gigi.
                        </p>
                        <button data-treatment="0"
                            class="treatment-detail-btn text-[15px] md:text-[18.75px] font-medium text-[#C58F59] flex items-center gap-1.5 hover:opacity-75 transition-opacity ml-auto cursor-pointer"
                            onclick="openTreatmentModal(0)">
                            Info Selengkapnya
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                            </svg>
                        </button>
                    </div>

                    {{-- Card 2: Tambal Gigi --}}
                    <div
                        class="bg-white rounded-2xl p-8 shadow-md hover:shadow-lg transition-shadow duration-300 flex flex-col min-h-[340px]">
                        <div class="mb-4 mx-auto">
                            <img src="{{ asset('images/gigi.svg') }}" alt="Icon"
                                class="w-20 h-20 object-contain">
                        </div>
                        <h3 class="text-[24px] md:text-[30px] font-bold text-[#C58F59] mb-3 text-center">Tambal Gigi
                        </h3>
                        <p
                            class="text-[15px] md:text-[18.75px] font-normal text-[#582C0C] leading-relaxed mb-5 flex-1 text-center">
                            Perawatan restorasi gigi berlubang dengan bahan berkualitas tinggi.
                        </p>
                        <button data-treatment="1"
                            class="treatment-detail-btn text-[15px] md:text-[18.75px] font-medium text-[#C58F59] flex items-center gap-1.5 hover:opacity-75 transition-opacity ml-auto cursor-pointer"
                            onclick="openTreatmentModal(1)">
                            Info Selengkapnya
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                            </svg>
                        </button>
                    </div>

                    {{-- Card 3: Cabut Gigi --}}
                    <div
                        class="bg-white rounded-2xl p-8 shadow-md hover:shadow-lg transition-shadow duration-300 flex flex-col min-h-[340px]">
                        <div class="mb-4 mx-auto">
                            <img src="{{ asset('images/gigi.svg') }}" alt="Icon"
                                class="w-20 h-20 object-contain">
                        </div>
                        <h3 class="text-[24px] md:text-[30px] font-bold text-[#C58F59] mb-3 text-center">Cabut Gigi
                        </h3>
                        <p
                            class="text-[15px] md:text-[18.75px] font-normal text-[#582C0C] leading-relaxed mb-5 flex-1 text-center">
                            Prosedur pencabutan gigi yang aman dan minim rasa sakit.
                        </p>
                        <button data-treatment="2"
                            class="treatment-detail-btn text-[15px] md:text-[18.75px] font-medium text-[#C58F59] flex items-center gap-1.5 hover:opacity-75 transition-opacity ml-auto cursor-pointer"
                            onclick="openTreatmentModal(2)">
                            Info Selengkapnya
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                            </svg>
                        </button>
                    </div>

                    {{-- Card 4: Pemasangan Behel --}}
                    <div
                        class="bg-white rounded-2xl p-8 shadow-md hover:shadow-lg transition-shadow duration-300 flex flex-col min-h-[340px]">
                        <div class="mb-4 mx-auto">
                            <img src="{{ asset('images/gigi.svg') }}" alt="Icon"
                                class="w-20 h-20 object-contain">
                        </div>
                        <h3 class="text-[24px] md:text-[30px] font-bold text-[#C58F59] mb-3 text-center">Pemasangan
                            Behel</h3>
                        <p
                            class="text-[15px] md:text-[18.75px] font-normal text-[#582C0C] leading-relaxed mb-5 flex-1 text-center">
                            Ortodonti untuk merapikan susunan gigi dengan hasil optimal.
                        </p>
                        <button data-treatment="3"
                            class="treatment-detail-btn text-[15px] md:text-[18.75px] font-medium text-[#C58F59] flex items-center gap-1.5 hover:opacity-75 transition-opacity ml-auto cursor-pointer"
                            onclick="openTreatmentModal(3)">
                            Info Selengkapnya
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                            </svg>
                        </button>
                    </div>

                    {{-- Card 5: Veneer Gigi --}}
                    <div
                        class="bg-white rounded-2xl p-8 shadow-md hover:shadow-lg transition-shadow duration-300 flex flex-col min-h-[340px]">
                        <div class="mb-4 mx-auto">
                            <img src="{{ asset('images/gigi.svg') }}" alt="Icon"
                                class="w-20 h-20 object-contain">
                        </div>
                        <h3 class="text-[24px] md:text-[30px] font-bold text-[#C58F59] mb-3 text-center">Veneer Gigi
                        </h3>
                        <p
                            class="text-[15px] md:text-[18.75px] font-normal text-[#582C0C] leading-relaxed mb-5 flex-1 text-center">
                            Lapisan tipis untuk mempercantik tampilan gigi Anda.
                        </p>
                        <button data-treatment="4"
                            class="treatment-detail-btn text-[15px] md:text-[18.75px] font-medium text-[#C58F59] flex items-center gap-1.5 hover:opacity-75 transition-opacity ml-auto cursor-pointer"
                            onclick="openTreatmentModal(4)">
                            Info Selengkapnya
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                            </svg>
                        </button>
                    </div>

                    {{-- Card 6: Crown & Bridge --}}
                    <div
                        class="bg-white rounded-2xl p-8 shadow-md hover:shadow-lg transition-shadow duration-300 flex flex-col min-h-[340px]">
                        <div class="mb-4 mx-auto">
                            <img src="{{ asset('images/gigi.svg') }}" alt="Icon"
                                class="w-20 h-20 object-contain">
                        </div>
                        <h3 class="text-[24px] md:text-[30px] font-bold text-[#C58F59] mb-3 text-center">Crown & Bridge
                        </h3>
                        <p
                            class="text-[15px] md:text-[18.75px] font-normal text-[#582C0C] leading-relaxed mb-5 flex-1 text-center">
                            Restorasi gigi permanen dengan mahkota dan jembatan gigi.
                        </p>
                        <button data-treatment="5"
                            class="treatment-detail-btn text-[15px] md:text-[18.75px] font-medium text-[#C58F59] flex items-center gap-1.5 hover:opacity-75 transition-opacity ml-auto cursor-pointer"
                            onclick="openTreatmentModal(5)">
                            Info Selengkapnya
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                            </svg>
                        </button>
                    </div>

                </div>

                {{-- Button Layanan Lainnya --}}
                <div class="flex justify-center">
                    <a href="/pelayanan/perawatan"
                        class="px-8 py-3 bg-[#C58F59] hover:bg-[#A0703E] text-white text-[15px] md:text-[18.75px] font-normal rounded-full transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5 inline-block">
                        Layanan Lainnya
                    </a>
                </div>

            </div>
        </div>
    </section>

    {{-- Section: Partner Asuransi --}}
    <section class="w-full py-8 md:py-20">
        <div class="max-w-7xl mx-auto px-6 md:px-10 lg:px-16">

            {{-- Header --}}
            <div class="text-center mb-12">
                <h2 class="text-[24px] md:text-[48px] font-bold text-[#582C0C]">Partner Asuransi</h2>
            </div>

            {{-- Semua logo digabung dalam satu flex-wrap agar nyamping dan otomatis turun --}}
            <div class="flex flex-wrap justify-center gap-4">

                <div class="flex items-center justify-center px-3 py-2 bg-white rounded-lg shadow-sm">
                    <img src="{{ asset('images/Admedika 1.svg') }}" alt="AdMedika"
                        class="w-18 h-18 md:w-24 md:h-24 object-contain">
                </div>
                <div class="flex items-center justify-center px-3 py-2 bg-white rounded-lg shadow-sm">
                    <img src="{{ asset('images/Avrist 1.svg') }}" alt="Avrist"
                        class="w-18 h-18 md:w-24 md:h-24 object-contain">
                </div>
                <div class="flex items-center justify-center px-3 py-2 bg-white rounded-lg shadow-sm">
                    <img src="{{ asset('images/Chubb 1.svg') }}" alt="Chubb"
                        class="w-18 h-18 md:w-24 md:h-24 object-contain">
                </div>
                <div class="flex items-center justify-center px-3 py-2 bg-white rounded-lg shadow-sm">
                    <img src="{{ asset('images/Fullerton 2.svg') }}" alt="Fullerton Health Indonesia"
                        class="w-18 h-18 md:w-24 md:h-24 object-contain">
                </div>
                <div class="flex items-center justify-center px-3 py-2 bg-white rounded-lg shadow-sm">
                    <img src="{{ asset('images/Generali 1.svg') }}" alt="Generali"
                        class="w-18 h-18 md:w-24 md:h-24 object-contain">
                </div>
                <div class="flex items-center justify-center px-3 py-2 bg-white rounded-lg shadow-sm">
                    <img src="{{ asset('images/GlobalExcel 1.svg') }}" alt="GlobalExcel"
                        class="w-18 h-18 md:w-24 md:h-24 object-contain">
                </div>
                <div class="flex items-center justify-center px-3 py-2 bg-white rounded-lg shadow-sm">
                    <img src="{{ asset('images/GreatEastern 1.svg') }}" alt="Great Eastern"
                        class="w-18 h-18 md:w-24 md:h-24 object-contain">
                </div>
                <div class="flex items-center justify-center px-3 py-2 bg-white rounded-lg shadow-sm">
                    <img src="{{ asset('images/LippoLife 1.svg') }}" alt="Lippo Life"
                        class="w-18 h-18 md:w-24 md:h-24 object-contain">
                </div>
                <div class="flex items-center justify-center px-3 py-2 bg-white rounded-lg shadow-sm">
                    <img src="{{ asset('images/copy-of-copy-of-garda-medika-01-melinda-nitbani-1200x480 1.svg') }}"
                        alt="Garda Medika" class="w-18 h-18 md:w-24 md:h-24 object-contain">
                </div>
                <div class="flex items-center justify-center px-3 py-2 bg-white rounded-lg shadow-sm">
                    <img src="{{ asset('images/MedikaPlaza 1.svg') }}" alt="Medika Plaza"
                        class="w-18 h-18 md:w-24 md:h-24 object-contain">
                </div>
                <div class="flex items-center justify-center px-3 py-2 bg-white rounded-lg shadow-sm">
                    <img src="{{ asset('images/Meditap 1.svg') }}" alt="Meditap"
                        class="w-18 h-18 md:w-24 md:h-24 object-contain">
                </div>

            </div>

        </div>
    </section>

    {{-- Section: Apresiasi Pasien --}}
    <section class="w-full bg-white py-8 md:py-20">
        <div class="max-w-7xl mx-auto px-6 md:px-10 lg:px-16">

            {{-- Header --}}
            <div class="text-center mb-12 gap-1 md:gap-2">
                <p class="text-[15px] md:text-[18.75px] font-semibold text-[#C58F59] tracking-wide">APRESIASI
                    PASIEN</p>
                <h2 class="text-[23px] md:text-[48px] font-bold text-[#582C0C] leading-tight">Cerita Di Balik
                    Senyum Mereka</h2>
                <p class="text-[15px] md:text-[18.75px] font-normal text-[#582C0C]">Pengalaman Nyata. Hasil Yang
                    Personal.</p>
            </div>

            {{-- Testimonial Carousel --}}
            <div class="testimonial-section relative">
                {{-- Carousel Container --}}
                <div id="testimonial-container" class="testimonial-track flex gap-6 overflow-x-auto scrollbar-hide snap-x snap-mandatory scroll-smooth pb-4 md:pb-0">
                    <!-- Dynamic testimonials loaded here -->
                </div>
                

            </div>

            <div id="testimonial-empty" class="text-center py-16 opacity-50 hidden">
                <p class="text-lg text-[#582C0C]">Belum ada testimonial pasien</p>
                <p class="text-sm text-[#6B513E] mt-2">Kelola melalui Admin Settings → Testimonial</p>
            </div>

        </div>
    </section>

    {{-- Treatment Modals --}}
    {{-- Single Treatment Detail Modal --}}
    <style>
        /* Testimonial Carousel Styles */
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
        .testimonial-track { scroll-snap-type: x mandatory; }
        .testimonial-card { 
            scroll-snap-align: start; 
            flex: 0 0 90%; 
            max-width: 420px;
            transition: transform 0.3s ease;
        }
        @media (min-width: 768px) {
            .testimonial-card { flex: 0 0 calc(33.333% - 12px); }
        }
        .testimonial-nav { pointer-events: none; }

        /* Treatment Modal Styles */
        #treatmentDetailModal, #allTreatmentsModal {
            backdrop-filter: blur(4px);
        }
        #treatmentDetailModal .bg-white, #allTreatmentsModal .bg-white {
            animation: modalSlideIn 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }
        @keyframes modalSlideIn {
            from { opacity: 0; transform: translateY(-20px) scale(0.95); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }
        #treatmentDetailModal ul li {
            padding-left: 1.5rem;
            position: relative;
        }
        #treatmentDetailModal ul li::before {
            content: "✓";
            position: absolute;
            left: 0;
            color: #C58F59;
            font-weight: bold;
        }
        .treatment-card-mini {
            transition: all 0.3s ease;
            cursor: pointer;
        }
        .treatment-card-mini:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
        @media (max-width: 640px) {
            #treatmentDetailModal .bg-white { 
                width: 100vw !important; height: 95vh !important; 
                margin: 0 !important; border-radius: 24px 24px 0 0 !important;
                max-width: none !important;
            }
        }
    </style>

    <div id="treatmentDetailModal" class="fixed inset-0 bg-black/60 z-[9999] hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl w-full md:max-w-lg lg:max-w-xl h-[95vh] md:h-auto max-h-[95vh] overflow-y-auto shadow-2xl mx-4 md:mx-auto">
            <div class="p-6 md:p-12 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 id="treatmentTitle" class="text-3xl md:text-4xl lg:text-5xl font-bold text-[#582C0C]"></h3>
                    <button onclick="closeTreatmentModal()" class="text-gray-500 hover:text-gray-700 text-2xl font-bold">&times;</button>
                </div>
            </div>
            <div class="p-6 md:p-8">
                <div class="text-center mb-8">
                    <img src="{{ asset('images/gigi.svg') }}" alt="Treatment Icon" class="w-24 h-24 md:w-32 md:h-32 lg:w-40 lg:h-40 mx-auto mb-8 object-contain">
                </div>

                <div class="mb-12 space-y-6">
                    <p id="treatmentShortDesc" class="text-xl md:text-2xl lg:text-3xl text-[#582C0C] leading-relaxed text-center font-medium"></p>
                </div>
                
                <div class="text-center">
                    <button id="bookAppointmentBtn" onclick="goToRegistration()" 
                        class="bg-[#C58F59] hover:bg-[#A0703E] text-white text-lg md:text-xl font-semibold py-4 px-8 rounded-full transition-all duration-300 shadow-lg hover:shadow-xl hover:-translate-y-1">
                        Buat Janji Temu
                    </button>
                </div>
            </div>
        </div>
    </div>



    {{-- Footer --}}
    @include('user.components.footerWelcome')

    <script>
        // Sesuaikan hero: margin-top & tinggi berdasarkan tinggi navbar fixed
        (function() {
            const nav = document.querySelector('nav');
            const hero = document.getElementById('hero-section');
            if (nav && hero) {
                const navH = nav.offsetHeight;
                hero.style.marginTop = navH + 'px';
                hero.style.height = 'calc(100vh - ' + navH + 'px)';
            }
        })();

        // ========== Testimonial Carousel ==========
        async function loadTestimonials() {
            try {
                console.log('🔄 Fetching active testimonials...'); // DEBUG
                const response = await fetch('/api/master-testimonial?active=1&per_page=20&t=' + Date.now()); // Cache bust
                const result = await response.json();
                console.log('📊 Testimonials loaded:', result.data.data?.length || 0, result.data.data); // DEBUG statuses
                const testimonials = (result.data?.data || []).filter(t => t.is_active); // Double-check client-side
                
                const container = document.getElementById('testimonial-container');
                const emptyState = document.getElementById('testimonial-empty');
                if (testimonials.length === 0) {
                    container.innerHTML = '';
                    emptyState.classList.remove('hidden');
                    return;
                }
                
                emptyState.classList.add('hidden');
                
                container.innerHTML = testimonials.map(testimonial => `
                    <div class="testimonial-card bg-white rounded-2xl p-8 shadow-md flex-shrink-0 w-full max-w-sm snap-center text-center md:text-left">
                        <div class="flex flex-col md:flex-row items-center gap-4 mb-5">
                            <img src="${testimonial.photo ? '/storage/' + testimonial.photo : '/images/raffi.png'}" alt="${testimonial.name}" 
                                 class="w-24 h-24 md:w-14 md:h-14 rounded-full object-cover shadow-lg mx-auto md:mx-0">
                            <div>
                                <h4 class="text-[24px] md:text-[20px] font-bold text-[#582C0C]">${testimonial.name}</h4>
                                <p class="text-[15px] md:text-[16px] font-normal text-[#6B513E]">${testimonial.profession || ''}</p>
                            </div>
                        </div>
                        <p class="text-[15px] md:text-[16px] font-normal text-[#582C0C] leading-relaxed italic">"${testimonial.comment}"</p>
                    </div>
                `).join('');
            } catch (error) {
                console.error('Failed to load testimonials:', error);
                document.getElementById('testimonial-empty').innerHTML = '<p class="text-lg text-red-500">Gagal memuat testimonial</p>';
                document.getElementById('testimonial-empty').classList.remove('hidden');
            }
        }

        // Auto-scroll carousel (no manual buttons needed)
        document.addEventListener('DOMContentLoaded', function() {
            loadTestimonials();
            const container = document.getElementById('testimonial-container');

            // Auto-scroll every 5s
            setInterval(() => {
                if (container.scrollLeft < container.scrollWidth - container.clientWidth - 10) {
                    container.scrollBy({ left: container.offsetWidth * 0.8, behavior: 'smooth' });
                } else {
                    container.scrollTo({ left: 0, behavior: 'smooth' });
                }
            }, 5000);
        });

        // ========== Doctor Character-Select Carousel ==========
        (function() {
            // Badge images per doctor (2 badges each)
            const doctorBadges = [
                [ // Jenny Wilson
                    {
                        img: "{{ asset('images/dokter_animate/lulusan1.png') }}",
                        alt: 'Universitas Indonesia'
                    },
                    {
                        img: "{{ asset('images/dokter_animate/lulusan2.png') }}",
                        alt: 'University of Adelaide'
                    }
                ],
                [ // Sarah Mitchell
                    {
                        img: "{{ asset('images/dokter_animate/lulusan3.png') }}",
                        alt: 'Universitas Gadjah Mada'
                    },
                    {
                        img: "{{ asset('images/dokter_animate/lulusan4.png') }}",
                        alt: 'Konservasi Gigi'
                    }
                ],
                [ // Amanda Lee
                    {
                        img: "{{ asset('images/dokter_animate/lulusan3.png') }}",
                        alt: 'Universitas Airlangga'
                    },
                    {
                        img: "{{ asset('images/dokter_animate/lulusan1.png') }}",
                        alt: 'Periodonti'
                    }
                ],
                [ // Michael Tan
                    {
                        img: "{{ asset('images/dokter_animate/lulusan4.png') }}",
                        alt: 'Universitas Padjadjaran'
                    },
                    {
                        img: "{{ asset('images/dokter_animate/lulusan2.png') }}",
                        alt: 'Bedah Mulut'
                    }
                ],
                [ // David Chen
                    {
                        img: "{{ asset('images/dokter_animate/lulusan2.png') }}",
                        alt: 'Universitas Trisakti'
                    },
                    {
                        img: "{{ asset('images/dokter_animate/lulusan4.png') }}",
                        alt: 'Tokyo Medical Dental'
                    }
                ]
            ];

            const badge1El = document.getElementById('doctor-badge-1');
            const badge2El = document.getElementById('doctor-badge-2');

            function updateBadges(docIdx) {
                const badges = doctorBadges[docIdx];
                // Fade out
                badge1El.style.opacity = '0';
                badge2El.style.opacity = '0';
                setTimeout(() => {
                    badge1El.src = badges[0].img;
                    badge1El.alt = badges[0].alt;
                    badge2El.src = badges[1].img;
                    badge2El.alt = badges[1].alt;
                    // Fade in
                    badge1El.style.opacity = '1';
                    badge2El.style.opacity = '1';
                }, 180);
            }

            const doctors = [{
                    image: "{{ asset('images/dokter_animate/budok1.png') }}",
                    shadow: "{{ asset('images/dokter_animate/bayangan_budok1.png') }}",
                    displayName: "Jenny Wilson Sp.Ort",
                    subtitle: 'Spesialis Orthodonti &nbsp;|&nbsp; No. STR: 3122100318012345',
                    bio: "Lulusan Universitas Indonesia yang mendalami spesialisasi di University of Adelaide. Berdedikasi selama 12 tahun menangani kasus maloklusi kompleks dengan teknologi ortodonti terkini."
                },
                {
                    image: "{{ asset('images/dokter_animate/budok2.png') }}",
                    shadow: "{{ asset('images/dokter_animate/bayangan_budok2.png') }}",
                    displayName: "Sarah Mitchell Sp.KG",
                    subtitle: 'Spesialis Konservasi Gigi &nbsp;|&nbsp; No. STR: 3122100318054321',
                    bio: "Alumni Universitas Gadjah Mada dengan pengalaman 10 tahun di bidang konservasi gigi. Ahli dalam perawatan saluran akar dan restorasi estetik."
                },
                {
                    image: "{{ asset('images/dokter_animate/budok3.png') }}",
                    shadow: "{{ asset('images/dokter_animate/bayangan_budok3.png') }}",
                    displayName: "Amanda Lee Sp.Perio",
                    subtitle: 'Spesialis Periodonti &nbsp;|&nbsp; No. STR: 3122100318067890',
                    bio: "Lulusan Universitas Airlangga dengan keahlian khusus periodonti. Berpengalaman 8 tahun menangani penyakit gusi dan bedah periodontal minimal invasif."
                },
                {
                    image: "{{ asset('images/dokter_animate/padok1.png') }}",
                    shadow: "{{ asset('images/dokter_animate/bayangan_padok1.png') }}",
                    displayName: "Michael Tan Sp.BM",
                    subtitle: 'Spesialis Bedah Mulut &nbsp;|&nbsp; No. STR: 3122100318098765',
                    bio: "Alumni Universitas Padjadjaran yang telah menangani lebih dari 3.000 kasus bedah mulut meliputi implantologi dan rekonstruksi rahang dengan teknologi 3D."
                },
                {
                    image: "{{ asset('images/dokter_animate/padok2.png') }}",
                    shadow: "{{ asset('images/dokter_animate/bayangan_padok2.png') }}",
                    displayName: "David Chen Sp.Pros",
                    subtitle: 'Spesialis Prostodonti &nbsp;|&nbsp; No. STR: 3122100318011223',
                    bio: "Lulusan Universitas Trisakti dengan spesialisasi dari Tokyo Medical and Dental University. Berpengalaman 15 tahun dalam pembuatan crown, bridge, dan denture presisi tinggi."
                }
            ];

            let currentIndex = 0;
            let isAnimating = false;
            const slots = document.querySelectorAll('.doctor-slot');
            const prevBtn = document.getElementById('doctor-prev');
            const nextBtn = document.getElementById('doctor-next');

            const nameEl = document.getElementById('doctor-name');
            const subtitleEl = document.getElementById('doctor-subtitle');
            const bioEl = document.getElementById('doctor-bio');

            function ci(idx) {
                return ((idx % doctors.length) + doctors.length) % doctors.length;
            }

            function updateDoctorInfo(docIdx) {
                const doc = doctors[docIdx];
                nameEl.textContent = doc.displayName;
                subtitleEl.innerHTML = doc.subtitle;
                bioEl.textContent = doc.bio;
            }

            // 7 positions: [hidden-left, far-left, left, center, right, far-right, hidden-right]
            const positions = [{
                    left: -39,
                    width: 42,
                    zIndex: 0,
                    opacity: 0,
                    blur: 2
                },
                {
                    left: -8,
                    width: 44,
                    zIndex: 1,
                    opacity: 0.3,
                    blur: 1
                },
                {
                    left: 4,
                    width: 52,
                    zIndex: 2,
                    opacity: 0.5,
                    blur: 0.5
                },
                {
                    left: 19,
                    width: 66,
                    zIndex: 5,
                    opacity: 1,
                    blur: 0
                },
                {
                    left: 48,
                    width: 52,
                    zIndex: 2,
                    opacity: 0.5,
                    blur: 0.5
                },
                {
                    left: 66,
                    width: 44,
                    zIndex: 1,
                    opacity: 0.3,
                    blur: 1
                },
                {
                    left: 97,
                    width: 42,
                    zIndex: 0,
                    opacity: 0,
                    blur: 2
                }
            ];

            function applyPos(slot, pos, withTransition) {
                if (!withTransition) {
                    slot.style.transition = 'none';
                } else {
                    slot.style.transition =
                        'left 700ms cubic-bezier(0.25,0.1,0.25,1), width 700ms cubic-bezier(0.25,0.1,0.25,1), opacity 700ms cubic-bezier(0.25,0.1,0.25,1), filter 700ms cubic-bezier(0.25,0.1,0.25,1)';
                }
                slot.style.left = pos.left + '%';
                slot.style.width = pos.width + '%';
                slot.style.zIndex = pos.zIndex;
                slot.style.opacity = pos.opacity;
                slot.style.filter = 'blur(' + pos.blur + 'px)';
            }

            // Set images for 7 slots based on current index
            // Mapping: slot 0..6 => doctor at currentIndex + (slotIdx - 3)
            function setAllImages() {
                for (let i = 0; i < 7; i++) {
                    const docIdx = ci(currentIndex + (i - 3));
                    const doc = doctors[docIdx];
                    const img = slots[i].querySelector('img:first-child') || slots[i].querySelector('img');
                    // Center slot (index 3) uses main image, others use shadow
                    img.src = (i === 3) ? doc.image : doc.shadow;
                    img.alt = doc.displayName;
                }
            }

            function renderInitial() {
                setAllImages();
                for (let i = 0; i < 7; i++) {
                    applyPos(slots[i], positions[i], false);
                }
                void slots[0].offsetHeight; // force reflow
                updateDoctorInfo(currentIndex);
            }

            function animateTo(direction) {
                if (isAnimating) return;
                isAnimating = true;

                // 1) Pre-position the incoming slot at the hidden edge (no transition)
                //    direction > 0 (next): new element enters from right (slot 6 hidden-right)
                //    direction < 0 (prev): new element enters from left (slot 0 hidden-left)
                // First, update the image of the slot that will enter
                if (direction > 0) {
                    // Slot 6 will slide in from right, set its image to currentIndex+4
                    const newDocIdx = ci(currentIndex + 4);
                    const doc = doctors[newDocIdx];
                    const img = slots[6].querySelector('img:first-child') || slots[6].querySelector('img');
                    img.src = doc.shadow;
                    img.alt = doc.displayName;
                    // Make sure slot 6 is at hidden-right position instantly
                    applyPos(slots[6], positions[6], false);
                } else {
                    // Slot 0 will slide in from left, set its image to currentIndex-4
                    const newDocIdx = ci(currentIndex - 4);
                    const doc = doctors[newDocIdx];
                    const img = slots[0].querySelector('img:first-child') || slots[0].querySelector('img');
                    img.src = doc.shadow;
                    img.alt = doc.displayName;
                    applyPos(slots[0], positions[0], false);
                }
                void slots[0].offsetHeight; // force reflow

                // 2) Animate all 7 slots to shift by one position
                for (let i = 0; i < 7; i++) {
                    const targetPosIdx = i - direction;
                    if (targetPosIdx >= 0 && targetPosIdx < 7) {
                        applyPos(slots[i], positions[targetPosIdx], true);
                    } else if (targetPosIdx < 0) {
                        applyPos(slots[i], positions[0], true); // slide to hidden-left
                    } else {
                        applyPos(slots[i], positions[6], true); // slide to hidden-right
                    }
                }

                // Also update the center slot's image mid-transition to show the actual doctor
                setTimeout(() => {
                    // The slot that becomes center: if direction>0, slot index 4 becomes center
                    // if direction<0, slot index 2 becomes center
                    const newCenterSlot = direction > 0 ? slots[4] : slots[2];
                    const newCenterDocIdx = ci(currentIndex + direction);
                    const img = newCenterSlot.querySelector('img:first-child') || newCenterSlot.querySelector(
                        'img');
                    img.src = doctors[newCenterDocIdx].image;
                }, 200);

                // 3) After animation completes, reset everything
                setTimeout(() => {
                    currentIndex = ci(currentIndex + direction);
                    setAllImages();
                    updateDoctorInfo(currentIndex);
                    for (let i = 0; i < 7; i++) {
                        applyPos(slots[i], positions[i], false);
                    }
                    void slots[0].offsetHeight;
                    // Re-enable transitions
                    for (let i = 0; i < 7; i++) {
                        slots[i].style.transition =
                            'left 700ms cubic-bezier(0.25,0.1,0.25,1), width 700ms cubic-bezier(0.25,0.1,0.25,1), opacity 700ms cubic-bezier(0.25,0.1,0.25,1), filter 700ms cubic-bezier(0.25,0.1,0.25,1)';
                    }
                    isAnimating = false;
                }, 720);
            }

            prevBtn.addEventListener('click', () => {
                updateBadges(ci(currentIndex - 1));
                animateTo(-1);
            });
            nextBtn.addEventListener('click', () => {
                updateBadges(ci(currentIndex + 1));
                animateTo(1);
            });

            document.addEventListener('keydown', (e) => {
                if (e.key === 'ArrowLeft') {
                    updateBadges(ci(currentIndex - 1));
                    animateTo(-1);
                }
                if (e.key === 'ArrowRight') {
                    updateBadges(ci(currentIndex + 1));
                    animateTo(1);
                }
            });

            renderInitial();
        })();

        // ========== TREATMENT MODALS DATA ==========
        const treatmentsData = [
            {
                id: 0,
                title: "Scaling & Polishing",
                shortDesc: "Pembersihan karang gigi profesional untuk menjaga kesehatan gusi dan gigi.",
                price: "Rp 250.000",
                duration: "30 menit",
                benefits: [
                    "Membersihkan karang gigi & plak secara menyeluruh",
                    "Mencegah radang gusi & bau mulut",
                    "Hasil gigi lebih bersih & mengkilap"
                ],
                fullDesc: "Prosedur scaling menggunakan ultrasonic scaler untuk menghilangkan karang gigi dan polishing dengan pasta khusus untuk menghaluskan permukaan gigi. Dilakukan setiap 6 bulan untuk menjaga kesehatan periodontal.",
                doctorRec: "Sarah Mitchell Sp.KG"
            },
            {
                id: 1,
                title: "Tambal Gigi",
                shortDesc: "Perawatan restorasi gigi berlubang dengan bahan berkualitas tinggi.",
                price: "Rp 450.000 - Rp 850.000",
                duration: "45-60 menit",
                benefits: [
                    "Mengembalikan fungsi mengunyah normal",
                    "Mencegah kerusakan lebih lanjut",
                    "Estetika gigi alami & tahan lama"
                ],
                fullDesc: "Restorasi komposit atau amalgam untuk mengisi kavitas karies. Pemilihan bahan disesuaikan dengan lokasi & kebutuhan pasien.",
                doctorRec: "Sarah Mitchell Sp.KG"
            },
            {
                id: 2,
                title: "Cabut Gigi",
                shortDesc: "Prosedur pencabutan gigi yang aman dan minim rasa sakit.",
                price: "Rp 350.000",
                duration: "20-30 menit",
                benefits: [
                    "Prosedur cepat & nyaman dengan anestesi lokal",
                    "Pencegahan infeksi & komplikasi",
                    "Persiapan untuk implan atau protesa"
                ],
                fullDesc: "Ekstraksi gigi dengan teknik atraumatic untuk mengurangi trauma jaringan. Dilengkapi perawatan pasca ekstraksi.",
                doctorRec: "Michael Tan Sp.BM"
            },
            {
                id: 3,
                title: "Pemasangan Behel",
                shortDesc: "Ortodonti untuk merapikan susunan gigi dengan hasil optimal.",
                price: "Rp 15.000.000 - Rp 35.000.000",
                duration: "12-24 bulan",
                benefits: [
                    "Memperbaiki oklusi & fungsi mengunyah",
                    "Meningkatkan estetika senyum",
                    "Pencegahan masalah periodontal masa depan"
                ],
                fullDesc: "Fixed orthodontic appliance dengan bracket metal/self-ligating atau clear aligner sesuai kasus maloklusi.",
                doctorRec: "Jenny Wilson Sp.Ort"
            },
            {
                id: 4,
                title: "Veneer Gigi",
                shortDesc: "Lapisan tipis untuk mempercantik tampilan gigi Anda.",
                price: "Rp 8.000.000 - Rp 12.000.000 per gigi",
                duration: "2 kunjungan",
                benefits: [
                    "Perubahan estetika dramatis dalam 1-2 kunjungan",
                    "Hasil natural & tahan 10-15 tahun",
                    "Minim pengikisan enamel"
                ],
                fullDesc: "Porcelain veneer atau composite veneer untuk menutupi cacat warna/bentuk gigi dengan presisi CAD/CAM.",
                doctorRec: "David Chen Sp.Pros"
            },
            {
                id: 5,
                title: "Crown & Bridge",
                shortDesc: "Restorasi gigi permanen dengan mahkota dan jembatan gigi.",
                price: "Rp 4.500.000 - Rp 18.000.000",
                duration: "2-3 kunjungan",
                benefits: [
                    "Kekuatan & daya tahan maksimal",
                    "Fungsi mengunyah seperti gigi asli",
                    "Solusi permanen untuk gigi hilang"
                ],
                fullDesc: "Full crown zirconia/metal-ceramic atau fixed bridge untuk mengganti 1-3 gigi hilang dengan retensi optimal.",
                doctorRec: "David Chen Sp.Pros"
            }
        ];

        const isLoggedIn = {{ Auth::check() ? 'true' : 'false' }};
        const loginUrl = '{{ route("login") }}';
        const registrationUrl = '{{ route("registration.form") }}';

        // ========== TREATMENT MODAL FUNCTIONS ==========
        function openTreatmentModal(id) {
            const treatment = treatmentsData[id];
            if (!treatment) return;
            
            // Populate modal - enhanced
            document.getElementById('treatmentTitle').textContent = treatment.title;
            document.getElementById('treatmentShortDesc').textContent = treatment.shortDesc;
            
            // Show modal
            document.getElementById('treatmentDetailModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeTreatmentModal() {
            document.getElementById('treatmentDetailModal').classList.add('hidden');
            document.body.style.overflow = '';
        }

        function openAllTreatmentsModal() {
            const grid = document.getElementById('allTreatmentsGrid');
            grid.innerHTML = treatmentsData.map(t => `
                <div class="treatment-card-mini bg-gray-50 rounded-xl p-6 hover:bg-white border border-gray-200" onclick="openTreatmentModal(${t.id})">
                    <img src="{{ asset('images/gigi.svg') }}" alt="${t.title}" class="w-16 h-16 mx-auto mb-4 object-contain">
                    <h4 class="text-xl font-bold text-[#582C0C] mb-2 text-center">${t.title}</h4>
                    <p class="text-[#C58F59] font-semibold text-lg mb-2 text-center">${t.price}</p>
                    <p class="text-sm text-gray-600 text-center">${t.duration}</p>
                </div>
            `).join('');
            
            document.getElementById('allTreatmentsModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function goToRegistration() {
            const url = isLoggedIn ? registrationUrl : loginUrl;
            window.location.href = url;
        }

        // Close modal on overlay click
        document.addEventListener('click', function(e) {
            if (e.target.id === 'treatmentDetailModal') closeTreatmentModal();
        });

        // Close on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeTreatmentModal();
            }
        });
    </script>

</body>

</html>
