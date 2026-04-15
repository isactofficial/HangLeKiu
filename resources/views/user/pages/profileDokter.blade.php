<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hanglekiu Dental — Profil Dokter</title>
    <meta name="description" content="Kenali tim dokter spesialis Hanglekiu Dental Clinic yang berpengalaman dan berdedikasi untuk kesehatan gigi Anda.">
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
    </style>
</head>

<body class="text-[var(--font-color-primary)] m-0 min-h-screen flex flex-col relative bg-white">

    @include('user.components.navbarWelcome')

    {{-- Doctors Section --}}
    <section class="w-full bg-[#FAF6F2] py-20 md:py-28">
        <div class="max-w-7xl mx-auto px-6 md:px-10 lg:px-16">

            {{-- Section Header --}}
            <div class="bg-[#E5D6C5] rounded-3xl text-center px-8 py-12 md:px-14 md:py-16 mb-20">
                <h2 class="text-[24px] md:text-[48px] font-bold text-[#582C0C] mb-4">
                    Para Ahli Di Balik Senyum Anda
                </h2>
                <p class="text-[15px] md:text-[18.75px] font-normal text-[#582C0C] max-w-3xl mx-auto leading-relaxed">
                    Setiap dokter kami memiliki keahlian spesifik dan komitmen tinggi untuk memberikan perawatan gigi berkualitas terbaik pada setiap kunjungan Anda.
                </p>
            </div>

            @php
                $dayMap = [
                    'monday'    => 'Senin',
                    'tuesday'   => 'Selasa',
                    'wednesday' => 'Rabu',
                    'thursday'  => 'Kamis',
                    'friday'    => 'Jumat',
                    'saturday'  => 'Sabtu',
                    'sunday'    => 'Minggu',
                ];
            @endphp

            @if(isset($doctors) && $doctors->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($doctors as $doctor)
                        <div class="bg-[#FDF8F4] rounded-2xl shadow-md hover:shadow-xl transition-shadow duration-300 overflow-hidden flex flex-col border border-[#EDE0D0]">

                            {{-- Foto --}}
                            <div class="w-full h-52 overflow-hidden bg-[#F5EDE3] flex items-center justify-content">
                                @if($doctor->foto_profil)
                                    <img src="{{ \Illuminate\Support\Facades\Storage::url($doctor->foto_profil) }}"
                                         alt="{{ $doctor->full_name }}"
                                         class="w-full h-full object-cover object-top">
                                @else
                                    <svg class="w-24 h-24 text-[#C58F59] opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                @endif
                            </div>

                            {{-- Info --}}
                            <div class="p-5 flex flex-col flex-grow">

                                {{-- Nama & Spesialisasi --}}
                                <h3 class="text-[20px] md:text-[24px] font-bold text-[#582C0C] leading-tight mb-1">
                                    {{ ($doctor->title_prefix ? $doctor->title_prefix . ' ' : '') . $doctor->full_name }}
                                </h3>

                                @if($doctor->specialization)
                                    <p class="text-[15px] md:text-[16px] font-medium text-[#C58F59] mb-1">
                                        Sp. {{ $doctor->specialization }}
                                    </p>
                                @endif

                                @if($doctor->subspecialization)
                                    <p class="text-[13px] text-[#6B513E] italic mb-4">
                                        {{ $doctor->subspecialization }}
                                    </p>
                                @else
                                    <div class="mb-4"></div>
                                @endif

                                {{-- Jadwal --}}
                                <div class="mt-auto pt-5 border-t border-[#E5D6C5]">
                                    <p class="text-[11px] font-bold text-[#C58F59] tracking-widest uppercase mb-3">
                                        Jadwal Praktik
                                    </p>

                                    @php $activeSchedules = $doctor->schedules->where('is_active', true); @endphp

                                    @if($activeSchedules->count() > 0)
                                        <div class="flex flex-col gap-2">
                                            @foreach($activeSchedules as $sch)
                                                <div class="flex justify-between items-center text-[14px]">
                                                    <span class="font-semibold text-[#582C0C]">
                                                        {{ $dayMap[$sch->day] ?? ucfirst($sch->day) }}
                                                    </span>
                                                    <span class="text-[#6B513E]">
                                                        {{ \Carbon\Carbon::parse($sch->start_time)->format('H:i') }}
                                                        &ndash;
                                                        {{ \Carbon\Carbon::parse($sch->end_time)->format('H:i') }} WIB
                                                    </span>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="text-[13px] text-[#9ca3af] italic">Jadwal belum tersedia.</p>
                                    @endif
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-20">
                    <p class="text-[18px] font-medium text-[#582C0C]">
                        Data dokter sedang diperbarui. Silakan hubungi kami untuk informasi lebih lanjut.
                    </p>
                </div>
            @endif

        </div>
    </section>

    {{-- Call to Action Section --}}
    <section class="mb-24 px-6 md:px-10 lg:px-16 w-full max-w-7xl mx-auto">
        <div class="bg-[var(--accent-brown)] rounded-[40px] p-10 md:p-16 text-center shadow-2xl relative overflow-hidden">
            {{-- Decorative circles --}}
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full -mr-32 -mt-32"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-white/5 rounded-full -ml-32 -mb-32"></div>
            
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-6 relative z-10">Siap Berkonsultasi?</h2>
            <p class="text-white/80 text-lg mb-10 max-w-2xl mx-auto relative z-10">
                Jadwalkan pertemuan dengan salah satu dokter spesialis kami hari ini dan mulai perjalanan menuju senyum sehat yang Anda inginkan.
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

    @include('user.components.footerWelcome')

    <script>
        (function () {
            // no-op: hero section removed
        })();
    </script>
</body>
</html>
