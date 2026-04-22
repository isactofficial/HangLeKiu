<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hanglekiu Dental — Selamat Datang</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
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
                {{ $clinicProfile->name ?? 'Hanglekiu Dental Specialist' }}
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

                <a href="https://wa.me/{{ ($clinicProfile->phone ?? null) ? preg_replace('/[^0-9]/', '', $clinicProfile->phone) : '6281234567890' }}" target="_blank" rel="noopener"
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
                            <!-- Doctor name will be loaded here -->
                        </h2>
                        <p id="doctor-subtitle"
                            class="text-[15px] md:text-[18.75px] italic font-medium text-[var(--font-color-secondary)] mb-6">
                            <!-- Doctor specialization & STR will be loaded here -->
                        </p>

                        <p id="doctor-bio"
                            class="text-[15px] md:text-[var(--fs-md)] font-normal text-[var(--font-color-secondary)] leading-relaxed mb-5 text-justify">
                            <!-- Doctor bio will be loaded here -->
                        </p>

                        <div class="flex flex-row justify-between items-center md:flex-col md:items-start w-full">

                            {{-- Social Media Dinamis --}}
                            <div id="doctor-social-media" class="flex items-center gap-3 mb-0 md:mb-16"></div>

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
            <div id="partner-container" class="flex flex-wrap justify-center gap-4">
                <!-- Dynamic partners loaded here -->
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
                <div id="testimonial-container" class="testimonial-track flex gap-6 overflow-x-auto scrollbar-hide snap-x snap-mandatory scroll-smooth pb-6 px-4">
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
            height: auto;
            align-self: stretch;
            display: flex;
            flex-direction: column;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
            border: 1px solid #f0ece8;
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
        .testimonial-section {
            overflow: visible;
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

        async function loadInsurancePartners() {
            try {
                const response = await fetch('/api/insurance-partners?active=1&per_page=50&t=' + Date.now());
                const result = await response.json();
                const partners = result.data?.data || [];
                const container = document.getElementById('partner-container');
                
                if (partners.length === 0) {
                    container.closest('section').classList.add('hidden');
                    return;
                }

                container.innerHTML = partners.map(partner => `
                    <div class="flex items-center justify-center px-3 py-2 bg-white rounded-lg shadow-sm">
                            <img src="${partner.logo ? '/storage/' + partner.logo : '/images/gigi.svg'}" 
                                alt="${partner.name}" 
                                class="w-24 h-24 md:w-32 md:h-32 object-contain">
                    </div>
                `).join('');
            } catch (error) {
                console.error('Failed to load insurance partners:', error);
            }
        }

        // Auto-scroll carousel (no manual buttons needed)
        document.addEventListener('DOMContentLoaded', function() {
            loadTestimonials();
            loadInsurancePartners();
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

        // ========== Doctor carousel logic is in the database-driven section below ==========

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
    // ========== DOCTOR CAROUSEL (DATABASE-DRIVEN) ==========
        (function() {
            const storageBase = "{{ asset('storage') }}";
            const doctors = @json($doctors);

            // Badges container
            const badgeContainer = document.getElementById('doctor-badges-container');
            const badge1El = document.getElementById('doctor-badge-1');
            const badge2El = document.getElementById('doctor-badge-2');

            if (!doctors || doctors.length === 0) {
                // Show fallback message if no doctors
                const nameEl = document.getElementById('doctor-name');
                const subtitleEl = document.getElementById('doctor-subtitle');
                const bioEl = document.getElementById('doctor-bio');
                if (nameEl) nameEl.textContent = 'Segera Hadir';
                if (subtitleEl) subtitleEl.textContent = 'Informasi dokter sedang diperbarui';
                if (bioEl) bioEl.textContent = '';
                return;
            }

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

            const placeholderImg = "{{ asset('images/user-placeholder.jpg') }}";

            function getDoctorImageUrl(doctor, useShadow) {
                if (!doctor) return placeholderImg;
                
                const imgPath = useShadow && doctor.shadow_image ? doctor.shadow_image : doctor.foto_profil;
                if (!imgPath) return placeholderImg;

                if (imgPath.startsWith('http')) return imgPath;
                return storageBase + '/' + imgPath;
            }

            function updateDoctorInfo(docIdx) {
                const doc = doctors[docIdx];
                if (!doc) return;
                nameEl.textContent = doc.full_name || '';
                const parts = [];
                if (doc.specialization) parts.push(doc.specialization);
                if (doc.str_number) parts.push('No. STR: ' + doc.str_number);
                subtitleEl.innerHTML = parts.join(' &nbsp;|&nbsp; ') || '';
                
                let bioText = doc.bio || '';
                if (!bioText) {
                    bioText = (doc.specialization || 'Dokter spesialis') + ' dengan pengalaman dalam memberikan perawatan dental terbaik.';
                }
                bioEl.textContent = bioText;

                // Social Media
                const socialDiv = document.getElementById('doctor-social-media');
                if (socialDiv) {
                    let html = '';
                    if (doc.instagram_url) {
                        html += `<a href="${doc.instagram_url}" target="_blank" rel="noopener" title="Instagram" class="hover:opacity-80 transition"><svg width="22" height="22" fill="none" viewBox="0 0 24 24"><rect width="20" height="20" x="2" y="2" rx="6" stroke="#C58F59" stroke-width="2"/><path d="M16.5 12A4.5 4.5 0 1 1 7.5 12a4.5 4.5 0 0 1 9 0Z" stroke="#C58F59" stroke-width="2"/><circle cx="17.5" cy="6.5" r="1" fill="#C58F59"/></svg></a>`;
                    }
                    if (doc.linkedin_url) {
                        html += `<a href="${doc.linkedin_url}" target="_blank" rel="noopener" title="LinkedIn" class="hover:opacity-80 transition"><svg width="22" height="22" fill="none" viewBox="0 0 24 24"><rect x="2" y="2" width="20" height="20" rx="6" stroke="#C58F59" stroke-width="2"/><path d="M7.75 9.5v5m0 0v-5m0 5h0m0 0h0m4.25-5v5m0 0v-2.5c0-.828.672-1.5 1.5-1.5s1.5.672 1.5 1.5V14.5m0-5v5" stroke="#C58F59" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><circle cx="7.75" cy="7.75" r="1" fill="#C58F59"/></svg></a>`;
                    }
                    socialDiv.innerHTML = html;
                }

                // Update Badges with fade transition
                if (badge1El) badge1El.style.opacity = '0';
                if (badge2El) badge2El.style.opacity = '0';

                setTimeout(() => {
                    if (doc.badge_1 && badge1El) {
                        badge1El.src = storageBase + '/' + doc.badge_1;
                        badge1El.style.display = 'block';
                        // Force reflow
                        void badge1El.offsetWidth;
                        badge1El.style.opacity = '1';
                    } else if (badge1El) {
                        badge1El.style.display = 'none';
                    }

                    if (doc.badge_2 && badge2El) {
                        badge2El.src = storageBase + '/' + doc.badge_2;
                        badge2El.style.display = 'block';
                        // Force reflow
                        void badge2El.offsetWidth;
                        badge2El.style.opacity = '1';
                    } else if (badge2El) {
                        badge2El.style.display = 'none';
                    }
                }, 180); // matches transition-opacity duration-[180ms]
            }

            // 7 positions: [hidden-left, far-left, left, center, right, far-right, hidden-right]
            const positions = [
                { left: -39, width: 42, zIndex: 0, opacity: 0, blur: 2 },
                { left: -8,  width: 44, zIndex: 1, opacity: 0.3, blur: 1 },
                { left: 4,   width: 52, zIndex: 2, opacity: 0.5, blur: 0.5 },
                { left: 19,  width: 66, zIndex: 5, opacity: 1, blur: 0 },
                { left: 48,  width: 52, zIndex: 2, opacity: 0.5, blur: 0.5 },
                { left: 66,  width: 44, zIndex: 1, opacity: 0.3, blur: 1 },
                { left: 97,  width: 42, zIndex: 0, opacity: 0, blur: 2 }
            ];

            const transitionCSS = 'left 700ms cubic-bezier(0.25,0.1,0.25,1), width 700ms cubic-bezier(0.25,0.1,0.25,1), opacity 700ms cubic-bezier(0.25,0.1,0.25,1), filter 700ms cubic-bezier(0.25,0.1,0.25,1)';

            function applyPos(slot, pos, withTransition) {
                slot.style.transition = withTransition ? transitionCSS : 'none';
                slot.style.left = pos.left + '%';
                slot.style.width = pos.width + '%';
                slot.style.zIndex = pos.zIndex;
                slot.style.opacity = pos.opacity;
                slot.style.filter = 'blur(' + pos.blur + 'px)';
            }

            function setAllImages() {
                for (let i = 0; i < 7; i++) {
                    const docIdx = ci(currentIndex + (i - 3));
                    const doc = doctors[docIdx];
                    const img = slots[i].querySelector('img');
                    
                    const isCenter = (i === 3);
                    const url = getDoctorImageUrl(doc, !isCenter);
                    
                    img.src = url;
                    img.alt = doc ? (doc.full_name || '') : '';
                    
                    if (isCenter) {
                        img.style.filter = '';
                    } else {
                        img.className = "w-full h-auto object-contain scale-[1.3] origin-bottom md:scale-100 transition-transform duration-300"; // Ensure standard classes
                        // Note: If you want grayscale strictly on shadow images as well, uncomment below:
                        // img.style.filter = 'grayscale(30%)';
                        img.style.filter = '';
                    }
                }
            }

            function renderInitial() {
                setAllImages();
                for (let i = 0; i < 7; i++) {
                    applyPos(slots[i], positions[i], false);
                }
                void slots[0].offsetHeight;
                updateDoctorInfo(currentIndex);
            }

            function animateTo(direction) {
                if (isAnimating) return;
                isAnimating = true;

                if (direction > 0) {
                    const newDocIdx = ci(currentIndex + 4);
                    const doc = doctors[newDocIdx];
                    const img = slots[6].querySelector('img');
                    img.src = getDoctorImageUrl(doc, true);
                    img.alt = doc ? (doc.full_name || '') : '';
                    applyPos(slots[6], positions[6], false);
                } else {
                    const newDocIdx = ci(currentIndex - 4);
                    const doc = doctors[newDocIdx];
                    const img = slots[0].querySelector('img');
                    img.src = getDoctorImageUrl(doc, true);
                    img.alt = doc ? (doc.full_name || '') : '';
                    applyPos(slots[0], positions[0], false);
                }
                void slots[0].offsetHeight;

                for (let i = 0; i < 7; i++) {
                    const targetPosIdx = i - direction;
                    if (targetPosIdx >= 0 && targetPosIdx < 7) {
                        applyPos(slots[i], positions[targetPosIdx], true);
                    } else if (targetPosIdx < 0) {
                        applyPos(slots[i], positions[0], true);
                    } else {
                        applyPos(slots[i], positions[6], true);
                    }
                }

                // Swap center image mid-transition
                setTimeout(() => {
                    const newCenterSlot = direction > 0 ? slots[4] : slots[2];
                    const newCenterDocIdx = ci(currentIndex + direction);
                    const img = newCenterSlot.querySelector('img');
                    img.src = getDoctorImageUrl(doctors[newCenterDocIdx], false);
                    img.style.filter = '';
                }, 200);

                setTimeout(() => {
                    currentIndex = ci(currentIndex + direction);
                    setAllImages();
                    updateDoctorInfo(currentIndex);
                    for (let i = 0; i < 7; i++) {
                        applyPos(slots[i], positions[i], false);
                    }
                    void slots[0].offsetHeight;
                    for (let i = 0; i < 7; i++) {
                        slots[i].style.transition = transitionCSS;
                    }
                    isAnimating = false;
                }, 720);
            }

            prevBtn.addEventListener('click', () => animateTo(-1));
            nextBtn.addEventListener('click', () => animateTo(1));

            document.addEventListener('keydown', (e) => {
                if (e.key === 'ArrowLeft') animateTo(-1);
                if (e.key === 'ArrowRight') animateTo(1);
            });

            renderInitial();
        })();
    </script>

</body>

</html>
