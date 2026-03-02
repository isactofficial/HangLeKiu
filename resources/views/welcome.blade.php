<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hanglekiu Dental — Selamat Datang</title>
    <meta name="description" content="Hanglekiu Dental — Klinik gigi terpercaya. Login atau daftar untuk mengakses layanan kami.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Instrument Sans', sans-serif; }
    </style>
</head>
<body class="bg-surface font-sans text-dark m-0 min-h-screen flex flex-col relative">

    {{-- Decorative background --}}
    <div class="fixed inset-0 overflow-hidden pointer-events-none -z-10 bg-amber-50">
        <div class="absolute -top-32 -right-32 w-96 h-96 rounded-full bg-amber-700/10 blur-3xl"></div>
        <div class="absolute top-1/2 -left-48 w-[600px] h-[600px] rounded-full bg-amber-600/5 blur-3xl"></div>
    </div>

    {{-- Navbar --}}
    <nav class="w-full px-6 md:px-10 py-5 flex items-center justify-between z-10 relative">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 rounded-xl bg-orange-900 flex items-center justify-center text-xl shadow-md">
                <span class="text-white">🦷</span>
            </div>
            <span class="text-2xl font-bold text-orange-950 tracking-tight">Hanglekiu Dental</span>
        </div>
    </nav>

    {{-- Main Content --}}
    <main class="flex-1 flex flex-col items-center justify-center px-6 pb-20 relative z-10">
        <div class="w-full max-w-2xl text-center">
            <a href="{{ route('registration.form') }}"
                class="bg-amber-600 hover:bg-amber-700 text-white font-semibold py-2.5 px-6 rounded-lg transition duration-300 inline-block">
                + Daftar Kunjungan
            </a>
            
            <div class="mb-12">
                <div class="inline-flex items-center gap-2 bg-white/80 text-orange-950 text-xs font-bold px-5 py-2.5 rounded-full mb-8 backdrop-blur-sm border border-orange-900/10 shadow-sm">
                    <span class="w-2.5 h-2.5 rounded-full bg-orange-600 animate-pulse"></span>
                    Klinik Gigi Terpercaya & Profesional
                </div>
                
            

                <h1 class="text-5xl md:text-6xl font-extrabold text-orange-950 leading-tight mb-6">
                    Senyum Sehat,<br>
                    <span class="text-orange-700">Hidup Bahagia</span>
                </h1>
                
                <p class="text-orange-900/80 text-lg md:text-xl max-w-lg mx-auto leading-relaxed mb-10 font-medium">
                    Selamat datang di Hanglekiu Dental. Mulai perjalanan perawatan gigi terbaik Anda bersama tim spesialis kami hari ini.
                </p>

                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="{{ route('login') }}" class="w-full sm:w-auto px-8 py-4 bg-orange-900 hover:bg-orange-950 text-white rounded-xl font-bold text-lg shadow-lg shadow-orange-900/20 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl flex items-center justify-center gap-2">
                        Masuk sebagai Pasien
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                        </svg>
                    </a>
                </div>
            </div>

        </div>
    </main>

    {{-- Footer --}}
    <footer class="pb-8 text-center relative z-10 w-full px-6">
        <p class="text-sm font-medium text-orange-900/50">&copy; {{ date('Y') }} Hanglekiu Dental. All rights reserved.</p>
    </footer>

</body>
</html>
