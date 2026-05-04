<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hanglekiu Dental — Klinik</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-[var(--font-color-primary)] m-0 min-h-screen flex flex-col relative bg-[#FAF9F6]">

    {{-- Navbar --}}
    @include('user.components.navbarWelcome')

    {{-- Content --}}
    <main class="flex-grow">
       {{-- Hero Section --}}
       <section id="hero-section" class="relative w-full h-[calc(100vh-60px)] flex items-end overflow-hidden">
            {{-- Background Image --}}
            <div class="absolute inset-0 z-0">
                <img src="{{ asset('images/klinik/bg-artikel.png') }}" alt="Hanglekiu Dental Specialist - Artikel"
                    class="w-full h-full object-cover">
                {{-- Gradient overlay dari bawah ke atas agar teks di bawah terbaca sangat jelas --}}
                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent"></div>
            </div>

            {{-- Hero Content --}}
            <div class="relative z-10 w-full max-w-7xl mx-auto px-6 md:px-10 lg:px-16 pb-16 md:pb-24 text-left">
                <div class="inline-block px-4 py-1.5 bg-[#C18B51] text-white text-sm md:text-base font-semibold rounded-full mb-5 shadow-sm">
                    Tentang Kami
                </div>
                
                <h1 class="text-3xl md:text-5xl lg:text-6xl font-bold text-white leading-tight mb-5 max-w-4xl drop-shadow-md">
                    {{ $profile->name ?? 'Klinik Utama Hanglekiu Dental Specialist' }}
                </h1>

                <p class="text-base md:text-xl font-medium text-white/90 max-w-3xl leading-relaxed drop-shadow-sm">
                    Wujudkan Senyum Ideal Anda Melalui Dedikasi Tim Profesional Kami Yang Menghadirkan
                    Standar Perawatan Gigi Dengan Keahlian Dan Presisi Medis Terbaik.
                </p>
            </div>
        </section>

        {{-- Deskripsi & Filosofi --}}
        <section class="py-20">
            <div class="max-w-7xl mx-auto px-6 md:px-10 lg:px-16">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                    <div class="lg:col-span-7">
                        <div class="space-y-6 text-lg text-[#582C0C]/80 leading-relaxed text-justify">
                            <p>
                                <strong>Klinik Utama Hanglekiu Dental Specialist (HDS)</strong> adalah klinik gigi spesialis di Jakarta Selatan yang menyediakan pelayanan perawatan gigi dan mulut umum serta spesialistik. 
                            </p>
                            <p>
                               Klinik Utama Hanglekiu Dental Specialist merupakan klinik gigi yang menawarkan fasilitas yang ramah  untuk keluarga dari berbagai usia. Mengutamakan kebersihan yang sangat baik dengan ruangan bertekanan negative, sinar uv, ekstraoral sucktion, lantai vinyl berstandard rumah sakit. Di desain  dengan  konsep  yang modern simple,  dan menjanjikan kenyamanan bagi pasien  yang datang. 
                            <p>
                                Saat ini Klinik Utama Hanglekiu Dental Specialist memiliki 2 Dokter gigi Spesialis Orthodonti dan 1 Dokter gigi umum. Dilengkapi dengan tim manajemen yang handal dan pelayanan front liner yang ramah,  menjadikan Klinik Utama Dental Hanglekiu Specialist menjadi pilihan terbaik  bagi kesehatan gigi dan mulut keluarga.
                            </p>
                        </div>
                    </div>
                    <div class="lg:col-span-5">
                        <div class="bg-[#582C0C] rounded-[40px] p-10 text-white shadow-2xl relative overflow-hidden group">
                            <div class="absolute -right-10 -top-10 h-40 w-40 rounded-full bg-[#C18B51]/20 transition-transform group-hover:scale-110"></div>
                            <h3 class="text-xl font-semibold text-[#C18B51] mb-4 tracking-widest uppercase italic">Filosofi Kami</h3>
                            <p class="text-2xl font-bold leading-tight">
                                "Filosofi Klinik Utama Hanglekiu Dental Specialist, ingin menjadi  klinik gigi yang nyaman, bersih dengan hasil perawatan yang terbaik sehingga pasien tidak takut melakukan perawatn gigi dan memperlakukan pasien seperti keluarga."
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section> 

                <section class="bg-white">

            <div class="max-w-7xl mx-auto px-6 md:px-10 lg:px-16 py-16 md:py-20">

                <div class="text-center max-w-3xl mx-auto mb-12">

                    <h2 class="text-3xl md:text-[40px] font-bold text-[#582C0C] mb-3">Visi, Misi, dan Nilai</h2>

                    <p class="text-[#582C0C]/65 leading-relaxed">Struktur kerja klinik yang mengutamakan kualitas pelayanan, kenyamanan pasien, dan kebersihan sebagai dasar utama.</p>

                </div>



                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                    <div class="rounded-[28px] border border-[#C18B51]/10 bg-[#FAF9F6] p-8 shadow-sm text-center">

                        <h3 class="text-2xl font-bold text-[#582C0C] mb-3">Visi</h3>

                        <p class="text-[#582C0C]/80 leading-relaxed">

                            Menjadi klinik gigi yang memberikan kualitas pelayanan terbaik dengan hasil terbaik untuk senyum sehat.

                        </p>

                    </div>



                    <div class="rounded-[28px] border border-[#C18B51]/10 bg-[#FAF9F6] p-8 shadow-sm text-center">

                        <h3 class="text-2xl font-bold text-[#582C0C] mb-3">Misi</h3>

                        <div class="space-y-3 text-[#582C0C]/80 leading-relaxed text-justify">

                            <p class="flex items-start gap-2">
                                <span class="w-4 flex-shrink-0 font-semibold text-[#C18B51] text-left">1.</span>
                                <span class="flex-1">Menyediakan pelayanan kesehatan gigi dan mulut untuk keluarga Indonesia dengan suasana klinik yang nyaman didukung dengan fasilitas yang lengkap serta pelayanan yang professional.</span>
                            </p>

                            <p class="flex items-start gap-2">
                                <span class="w-4 flex-shrink-0 font-semibold text-[#C18B51] text-left">2.</span>
                                <span class="flex-1">Menyediakan kebersihan yang sangat baik.</span>
                            </p>

                        </div>

                    </div>



                    <div class="rounded-[28px] bg-[#582C0C] p-8 text-white shadow-lg relative overflow-hidden text-center">

                        <div class="absolute -right-8 -top-8 h-28 w-28 rounded-full bg-[#C18B51]/20"></div>

                        <h3 class="text-2xl font-bold mb-3">Nilai</h3>

                        <h3 class="text-2xl font-bold mb-3">BERBAGI</h3>

                        <ul class="space-y-3 text-sm text-white/85 leading-relaxed text-left">

                            <li class="flex items-start justify-start gap-2">
                                <span class="w-10 flex-shrink-0 font-bold text-[#E9C08C] text-left">BER -</span>
                                <span class="flex-1 text-left">BERikan yang terbaik dalam setiap tindakan dan pekerjaan</span>
                            </li>

                            <li class="flex items-start justify-between flex-row-reverse gap-2">
                                <span class="w-10 flex-shrink-0 font-bold text-[#E9C08C] text-right">B -</span>
                                <span class="flex-1 text-left">Bekerjasama dalam team</span>
                            </li>

                            <li class="flex items-start justify-start gap-2">
                                <span class="w-10 flex-shrink-0 font-bold text-[#E9C08C] text-right">A -</span>
                                <span class="flex-1 text-left">Antusias dalam bekerja</span>
                            </li>

                            <li class="flex items-start justify-start gap-2">
                                <span class="w-10 flex-shrink-0 font-bold text-[#E9C08C] text-right">G -</span>
                                <span class="flex-1 text-left">Giat belajar terus menerus untuk meng-update ilmu yang dimiliki</span>
                            </li>

                            <li class="flex items-start justify-start gap-2">
                                <span class="w-10 flex-shrink-0 font-bold text-[#E9C08C] text-right">I -</span>
                                <span class="flex-1 text-left">Ibadah dalam bekerja</span>
                            </li>

                        </ul>

                    </div>

                </div>

            </div>

        </section>

        {{-- Lorem Ipsum Gallery Section --}}
        <section class="w-full bg-[#FAF9F6]">
            {{-- Padding Atas = 100px (Jarak Hero ke Gallery) --}}
            {{-- Padding Bawah = 40px (Bagian dari jarak Gallery ke Lokasi yang totalnya 80px) --}}
            <div class="max-w-7xl mx-auto w-full px-6 md:px-10 lg:px-16 pt-[100px] pb-[40px]">
                <h2 class="text-3xl md:text-[40px] font-bold text-[#582C0C] text-center">
                    Fasilitas
                </h2>

                 <p class="text-sm text-[#582C0C]/60 text-center">Fasilitas yang dimiliki Klinik Utama Hanglekiu Dental Specialist</p>




                {{-- Jarak 62px antara tulisan dan Grid --}}
                {{-- Membungkus grid dengan max-width lebih kecil (max-w-5xl = 1024px) agar keseluruhan gambar mengecil proporsional tanpa merusak layout vertikal --}}
                <div class="max-w-5xl mx-auto mt-[62px] pb-[62px]">
                    <div class="grid grid-cols-1 md:grid-cols-[1fr_2fr_1.5fr] gap-4 md:gap-5">
                        
                        {{-- Left Column (Spans 1 col) --}}
                        <div class="flex flex-col gap-4 md:gap-5 col-span-1">
                            <img src="{{ asset('images/klinik/artikel-left-top.png') }}" alt="Artikel Gallery" 
                                 class="w-full aspect-square md:aspect-auto md:flex-1 object-cover rounded-2xl shadow-sm">
                            <img src="{{ asset('images/klinik/artikel-left-bot.png') }}" alt="Artikel Gallery" 
                                 class="w-full aspect-square md:aspect-auto md:flex-1 object-cover rounded-2xl shadow-sm">
                        </div>

                        {{-- Middle Column --}}
                        <div class="col-span-1 relative min-h-[250px] md:min-h-0">
                            <img src="{{ asset('images/klinik/artikel-mid.png') }}" alt="Artikel Gallery" 
                                 class="absolute inset-0 w-full h-full object-cover rounded-2xl shadow-sm">
                        </div>

                        {{-- Right Column (Spans 1 col) --}}
                        <div class="flex flex-col gap-4 md:gap-5 col-span-1">
                            <img src="{{ asset('images/klinik/artikel-right-top.png') }}" alt="Artikel Gallery" 
                                 class="w-full aspect-square md:aspect-auto md:flex-1 object-cover rounded-2xl shadow-sm">
                            <img src="{{ asset('images/klinik/artikel-right-bot.png') }}" alt="Artikel Gallery" 
                                 class="w-full aspect-square md:aspect-auto md:flex-1 object-cover rounded-2xl shadow-sm">
                        </div>

                    </div>
                </div>
            </div>
        </section>

        {{-- Lokasi & Jam Operasional Section --}}
        <section class="w-full bg-[#FAF9F6]">
            {{-- Padding Atas = 40px (Sisa dari jarak Gallery ke Lokasi yang totalnya 80px) --}}
            <div class="max-w-7xl mx-auto w-full px-6 md:px-10 lg:px-16 pt-[40px] pb-24 text-[#582C0C]">
                <h2 class="text-3xl md:text-[40px] font-bold text-center mb-[62px]">
                    Lokasi & Jam Operasional
                </h2>

            

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                    
                    {{-- Left Side: Info Card & Contact Button (Spans 4/12 cols) --}}
                    <div class="lg:col-span-5 flex flex-col gap-4">
                       

                        {{-- Info Card --}}
                        <div class="bg-[#C18B51] rounded-[20px] p-6 lg:p-7 text-[#582C0C] shadow-sm">
                            <h3 class="text-[20px] lg:text-[22px] font-bold mb-2">{{ $profile->name ?? 'Hanglekiu Dental Specialist' }}</h3>
                            <p class="text-[14px] lg:text-[15px] font-medium opacity-90 mb-4 leading-normal pr-4">
                                {{ $profile->address ?? 'Jl. Hang Lekiu V No.8, Gunung, Kec. Kby. Baru, Kota Jakarta Selatan, 12120' }}
                            </p>

                            @php
                                $scheduleItems = collect($profile->operational_hours ?? [])->filter(function ($value) {
                                    return filled($value) && $value !== '-';
                                });
                            @endphp
                            
                            <div class="mb-4">
                                <p class="text-[14px] lg:text-[15px] opacity-90 mb-1">Operasional</p>
                                <ul class="space-y-1 text-[14px] lg:text-[15px] font-medium opacity-90">
                                    @foreach(explode("\n", $profile->operational_summary) as $summaryLine)
                                        <li class="flex items-center gap-2">
                                            <span class="w-1.5 h-1.5 rounded-full bg-[#582C0C] opacity-70"></span> 
                                            {{ $summaryLine }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            

                            @if($scheduleItems->isNotEmpty())
                                <button id="toggle-schedule" class="inline-flex text-white hover:text-white/80 transition-all items-center gap-1.5 text-[14px] font-medium w-max group outline-none">
                                    <span>Info Lengkapnya</span>
                                    <svg id="toggle-icon" class="w-4 h-4 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>

                                {{-- Full Schedule (Initially Hidden) --}}
                                <div id="full-schedule" class="max-h-0 overflow-hidden transition-all duration-500 ease-in-out opacity-0">
                                    <div class="mt-4 pt-4 border-t border-[#582C0C]/10">
                                        <ul class="space-y-2 text-[13px] lg:text-[14px] font-medium opacity-90">
                                            @php
                                                $days = [
                                                    'monday' => 'Senin',
                                                    'tuesday' => 'Selasa',
                                                    'wednesday' => 'Rabu',
                                                    'thursday' => 'Kamis',
                                                    'friday' => 'Jumat',
                                                    'saturday' => 'Sabtu',
                                                    'sunday' => 'Minggu'
                                                ];
                                            @endphp
                                            @foreach($days as $key => $label)
                                                @if(filled($profile->operational_hours[$key] ?? null))
                                                    <li class="flex justify-between items-center">
                                                        <span>{{ $label }}</span>
                                                        <span>{{ $profile->operational_hours[$key] }}</span>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endif
                        </div>

                        {{-- Contact Button --}}
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $profile->phone) }}" target="_blank" 
                           class="bg-[#4D2303] hover:bg-[#321402] text-white py-3.5 lg:py-4 rounded-[20px] font-medium text-[14px] lg:text-[15px] shadow-sm transition-colors flex items-center justify-center gap-2 w-full shrink-0">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            Hubungi Kami
                        </a>
                    </div>

                    {{-- Right Side: Map (Spans 7/12 cols) --}}
                    <div class="lg:col-span-7 h-[350px] lg:h-[450px] rounded-[20px] overflow-hidden border border-[#C18B51]/30 shadow-sm relative">
                        <iframe 
                            src="https://www.google.com/maps?q={{ urlencode($profile->address ?? 'Hanglekiu Dental Specialist') }}&output=embed" 
                            class="absolute inset-0 w-full h-full"
                            style="border:0;" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                    
                </div>
            </div>
        </section>

    </main>

    {{-- Footer --}}
    @include('user.components.footerWelcome')

    <script>
        (function() {
            // Navbar Margin adjustment
            const nav = document.querySelector('nav');
            const hero = document.getElementById('hero-section');
            if (nav && hero) {
                const navH = nav.offsetHeight;
                hero.style.marginTop = navH + 'px';
            }

            // Schedule Toggle functionality
            const toggleBtn = document.getElementById('toggle-schedule');
            const fullSchedule = document.getElementById('full-schedule');
            const toggleIcon = document.getElementById('toggle-icon');

            if (toggleBtn && fullSchedule && toggleIcon) {
                toggleBtn.addEventListener('click', function() {
                    const isExpanded = fullSchedule.style.maxHeight && fullSchedule.style.maxHeight !== '0px';
                    
                    if (!isExpanded) {
                        // Expand
                        fullSchedule.style.maxHeight = fullSchedule.scrollHeight + "px";
                        fullSchedule.style.opacity = "1";
                        toggleIcon.style.transform = "rotate(180deg)";
                    } else {
                        // Collapse
                        fullSchedule.style.maxHeight = "0px";
                        fullSchedule.style.opacity = "0";
                        toggleIcon.style.transform = "rotate(0deg)";
                    }
                });
            }
        })();
    </script>
</body>
</html>
