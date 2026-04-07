<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hanglekiu Dental — Pelayanan Perawatan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-brown: #582C0C;
            --secondary-brown: #C18B51;
            --accent-brown: #4D2303;
            --bg-cream: #FAF9F6;
        }
        body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--bg-cream);
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(193, 139, 81, 0.2);
        }
        .text-gradient {
            background: linear-gradient(135deg, #582C0C 0%, #C18B51 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>

<body class="text-[var(--font-color-primary)] m-0 min-h-screen flex flex-col relative">

    {{-- Navbar --}}
    @include('user.components.navbarWelcome')

    {{-- Content --}}
    <main class="flex-grow">
        {{-- Hero Section --}}
        <section id="hero-section" class="relative w-full h-[60vh] flex items-center overflow-hidden" style="margin-top: 60px;">
            {{-- Background Image --}}
            <div class="absolute inset-0 z-0">
                <img src="{{ asset('images/klinik/bg-artikel.png') }}" alt="Hanglekiu Dental Specialist - Perawatan"
                    class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
            </div>

            {{-- Hero Content --}}
            <div class="relative z-10 w-full max-w-7xl mx-auto px-6 md:px-10 lg:px-16">
                <div class="inline-block px-4 py-1.5 bg-[var(--secondary-brown)]/80 backdrop-blur-sm text-white text-xs md:text-sm font-semibold rounded-full mb-6 tracking-wider uppercase">
                    Pelayanan Kami
                </div>
                <h1 class="text-4xl md:text-6xl font-bold text-white leading-tight mb-6">
                    Perawatan Gigi <br><span class="text-[var(--secondary-brown)]">Profesional & Terpercaya</span>
                </h1>
                <p class="text-lg md:text-xl font-medium text-white/90 max-w-2xl leading-relaxed">
                    Kami menghadirkan berbagai solusi perawatan gigi komprehensif dengan teknologi terkini dan tim dokter spesialis berpengalaman untuk senyum sehat Anda.
                </p>
            </div>
        </section>

        {{-- Services Section --}}
        <section class="py-24 px-6 md:px-10 lg:px-16 w-full max-w-7xl mx-auto">
            @if(isset($groupedProcedures) && count($groupedProcedures) > 0)
                @foreach($groupedProcedures as $categoryName => $procedures)
                    <div class="mb-20 last:mb-0">
                        <div class="flex items-center gap-4 mb-10">
                            <h2 class="text-3xl md:text-4xl font-bold text-[var(--primary-brown)] shrink-0">
                                {{ $categoryName }}
                            </h2>
                            <div class="h-[2px] w-full bg-gradient-to-r from-[var(--secondary-brown)]/50 to-transparent"></div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                            @foreach($procedures as $procedure)
                                <div class="glass-card p-8 rounded-3xl hover:shadow-xl transition-all duration-300 group hover:-translate-y-1">
                                    <div class="w-12 h-12 bg-[var(--secondary-brown)]/10 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-[var(--secondary-brown)] transition-colors duration-300">
                                        <svg class="w-6 h-6 text-[var(--secondary-brown)] group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-bold text-[var(--primary-brown)] mb-3 leading-tight">
                                        {{ $procedure->name ?: $procedure->procedure_name }}
                                    </h3>
                                    <p class="text-[var(--font-color-secondary)] text-sm md:text-base leading-relaxed opacity-80">
                                        {{ $procedure->description ?: 'Layanan perawatan gigi berkualitas tinggi yang ditangani langsung oleh tim medis profesional kami.' }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            @else
                <div class="text-center py-20">
                    <p class="text-xl text-[var(--primary-brown)] font-medium">Data perawatan sedang diperbarui. Silakan hubungi kami untuk informasi lebih lanjut.</p>
                </div>
            @endif
        </section>

        {{-- Call to Action Section --}}
        <section class="mb-24 px-6 md:px-10 lg:px-16 w-full max-w-7xl mx-auto">
            <div class="bg-[var(--accent-brown)] rounded-[40px] p-10 md:p-16 text-center shadow-2xl relative overflow-hidden">
                {{-- Decorative circles --}}
                <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full -mr-32 -mt-32"></div>
                <div class="absolute bottom-0 left-0 w-64 h-64 bg-white/5 rounded-full -ml-32 -mb-32"></div>
                
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-6 relative z-10">Siap Mendapatkan Senyum Impian Anda?</h2>
                <p class="text-white/80 text-lg mb-10 max-w-2xl mx-auto relative z-10">
                    Jadwalkan konsultasi dengan tim dokter spesialis kami hari ini dan mulai perjalanan menuju senyum sehat yang Anda inginkan.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center relative z-10">
                    <a href="{{ route('appointments.create') }}" class="px-8 py-4 bg-[var(--secondary-brown)] hover:bg-[var(--secondary-brown)]/90 text-white font-bold rounded-2xl transition-all duration-300 shadow-lg hover:shadow-xl">
                        Buat Janji Temu
                    </a>
                    <a href="https://wa.me/6285211888621" target="_blank" class="px-8 py-4 bg-white hover:bg-white/90 text-[var(--accent-brown)] font-bold rounded-2xl transition-all duration-300 shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
                        WhatsApp Kami
                    </a>
                </div>
            </div>
        </section>
    </main>

    {{-- Footer --}}
    @include('user.components.footerWelcome')

    <script>
        (function() {
            const nav = document.querySelector('nav');
            const hero = document.getElementById('hero-section');
            if (nav && hero) {
                const navH = nav.offsetHeight;
                hero.style.marginTop = navH + 'px';
            }
        })();
    </script>
</body>
</html>
