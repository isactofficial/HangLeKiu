<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hanglekiu Dental — {{ $article['title'] }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-[var(--font-color-primary)] m-0 min-h-screen flex flex-col relative bg-[#FAF9F6]">

    {{-- Navbar --}}
    @include('user.components.navbarWelcome')

    {{-- Content --}}
    <main class="flex-grow pt-[70px] -mt-[1px] mb-24">
        
        {{-- Custom Header Banner --}}
        <div class="w-full min-h-[160px] md:min-h-[200px] lg:min-h-[220px] py-[40px] md:py-[60px] relative flex justify-center items-center bg-cover bg-center overflow-hidden" style="background-image: url('{{ asset('images/detailArtikel/bg-header.png') }}');">
            {{-- Dark Overlay if necessary based on your image --}}
            <div class="absolute inset-0 bg-black/40"></div>

            <div class="relative z-10 flex flex-col lg:flex-row items-center justify-center gap-8 md:gap-16 lg:gap-[551px] w-full px-6">
                {{-- Bagian Kiri (Logo & Title) --}}
                <div class="flex flex-col items-center shrink-0">
                    <img src="{{ asset('images/logo-hds.png') }}" alt="Hanglekiu Dental Logo" class="h-[60px] md:h-[80px] w-auto object-contain">
                    <p class="text-white font-medium text-[16px] mt-[-4px]">Hanglekiu dental specialist</p>
                </div>

                {{-- Bagian Kanan (Path Artikel) --}}
                <div class="flex items-center text-white text-[16px] shrink-0 font-medium">
                    <a href="{{ route('artikel') }}" class="transition-colors">Artikel</a> &nbsp; <svg class="w-4 h-4 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg> &nbsp; {{ $article['title'] }}
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-6 md:px-10 mt-[67px] flex flex-col lg:flex-row items-start lg:gap-[36px] pb-24">

            {{-- Bagian Kiri: Detail Artikel Utama --}}
            <div class="w-full lg:flex-1 lg:min-w-0">
                {{-- Judul --}}
                <h1 class="text-[30px] font-bold text-[#582C0C] leading-tight">
                    {{ $article['title'] }}
                </h1>
                
                {{-- Keterangan Penulis --}}
                <p class="text-[16px] font-medium text-[#6B513E] mt-[4px]">
                    Dibuat oleh admin . 25 Februari 2026
                </p>
                
                {{-- Gambar Artikel --}}
                <img src="{{ asset('images/artikel/' . $article['image']) }}" alt="{{ $article['title'] }}" class="w-full md:w-[760px] h-auto md:h-[513px] object-cover mt-[20px] rounded-[16px]">
                
                {{-- Keterangan Artikel --}}
                <div class="text-[18.75px] font-medium text-[#6B513E] mt-[20px] leading-relaxed">
                    {!! $article['content'] !!}
                </div>
                
                {{-- Sub-Judul --}}
                <h2 class="text-[30px] font-bold text-[#582C0C] mt-[20px] leading-tight">
                    Sub-Judul Contoh
                </h2>
                
                {{-- Kalimat Sub-judul --}}
                <p class="text-[18.75px] font-medium text-[#6B513E] mt-[10px] leading-relaxed">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam erat volutpat. Proin eget odio varius, auctor tellus vel.
                </p>

                {{-- 4 Tags "lorem" --}}
                <div class="flex flex-wrap gap-[10px] mt-[15px]">
                    <span class="bg-[#C58F59] text-[#F7F7F7] font-normal text-[18.75px] px-[10px] py-[8px] rounded-md">lorem</span>
                    <span class="bg-[#C58F59] text-[#F7F7F7] font-normal text-[18.75px] px-[10px] py-[8px] rounded-md">lorem</span>
                    <span class="bg-[#C58F59] text-[#F7F7F7] font-normal text-[18.75px] px-[10px] py-[8px] rounded-md">lorem</span>
                    <span class="bg-[#C58F59] text-[#F7F7F7] font-normal text-[18.75px] px-[10px] py-[8px] rounded-md">lorem</span>
                </div>

                {{-- Share --}}
                <div class="flex items-center mt-[40px]">
                    <span class="text-[30px] font-bold text-[#582C0C] mr-[22px]">Bagikan artikel</span>
                    <div class="flex gap-[12px]">
                        {{-- Social --}}
                        <div class="w-[44px] h-[44px] rounded-full flex items-center justify-center bg-[#C58F59] text-white">
                            <svg class="w-5 h-5 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><path d="M576 320C576 178.6 461.4 64 320 64C178.6 64 64 178.6 64 320C64 440 146.7 540.8 258.2 568.5L258.2 398.2L205.4 398.2L205.4 320L258.2 320L258.2 286.3C258.2 199.2 297.6 158.8 383.2 158.8C399.4 158.8 427.4 162 438.9 165.2L438.9 236C432.9 235.4 422.4 235 409.3 235C367.3 235 351.1 250.9 351.1 292.2L351.1 320L434.7 320L420.3 398.2L351 398.2L351 574.1C477.8 558.8 576 450.9 576 320z"/></svg>
                        </div>
                        <div class="w-[44px] h-[44px] rounded-full flex items-center justify-center bg-[#C58F59] text-white">
                            <svg class="w-5 h-5 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><path d="M320.3 205C256.8 204.8 205.2 256.2 205 319.7C204.8 383.2 256.2 434.8 319.7 435C383.2 435.2 434.8 383.8 435 320.3C435.2 256.8 383.8 205.2 320.3 205zM319.7 245.4C360.9 245.2 394.4 278.5 394.6 319.7C394.8 360.9 361.5 394.4 320.3 394.6C279.1 394.8 245.6 361.5 245.4 320.3C245.2 279.1 278.5 245.6 319.7 245.4zM413.1 200.3C413.1 185.5 425.1 173.5 439.9 173.5C454.7 173.5 466.7 185.5 466.7 200.3C466.7 215.1 454.7 227.1 439.9 227.1C425.1 227.1 413.1 215.1 413.1 200.3zM542.8 227.5C541.1 191.6 532.9 159.8 506.6 133.6C480.4 107.4 448.6 99.2 412.7 97.4C375.7 95.3 264.8 95.3 227.8 97.4C192 99.1 160.2 107.3 133.9 133.5C107.6 159.7 99.5 191.5 97.7 227.4C95.6 264.4 95.6 375.3 97.7 412.3C99.4 448.2 107.6 480 133.9 506.2C160.2 532.4 191.9 540.6 227.8 542.4C264.8 544.5 375.7 544.5 412.7 542.4C448.6 540.7 480.4 532.5 506.6 506.2C532.8 480 541 448.2 542.8 412.3C544.9 375.3 544.9 264.5 542.8 227.5zM495 452C487.2 471.6 472.1 486.7 452.4 494.6C422.9 506.3 352.9 503.6 320.3 503.6C287.7 503.6 217.6 506.2 188.2 494.6C168.6 486.8 153.5 471.7 145.6 452C133.9 422.5 136.6 352.5 136.6 319.9C136.6 287.3 134 217.2 145.6 187.8C153.4 168.2 168.5 153.1 188.2 145.2C217.7 133.5 287.7 136.2 320.3 136.2C352.9 136.2 423 133.6 452.4 145.2C472 153 487.1 168.1 495 187.8C506.7 217.3 504 287.3 504 319.9C504 352.5 506.7 422.6 495 452z"/></svg>
                        </div>
                        <div class="w-[44px] h-[44px] rounded-full flex items-center justify-center bg-[#C58F59] text-white">
                            <svg class="w-5 h-5 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><path d="M581.7 188.1C575.5 164.4 556.9 145.8 533.4 139.5C490.9 128 320.1 128 320.1 128C320.1 128 149.3 128 106.7 139.5C83.2 145.8 64.7 164.4 58.4 188.1C47 231 47 320.4 47 320.4C47 320.4 47 409.8 58.4 452.7C64.7 476.3 83.2 494.2 106.7 500.5C149.3 512 320.1 512 320.1 512C320.1 512 490.9 512 533.5 500.5C557 494.2 575.5 476.3 581.8 452.7C593.2 409.8 593.2 320.4 593.2 320.4C593.2 320.4 593.2 231 581.8 188.1zM264.2 401.6L264.2 239.2L406.9 320.4L264.2 401.6z"/></svg>
                        </div>
                        <div class="w-[44px] h-[44px] rounded-full flex items-center justify-center bg-[#C58F59] text-white">
                            <svg class="w-5 h-5 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><path d="M196.3 512L103.4 512L103.4 212.9L196.3 212.9L196.3 512zM149.8 172.1C120.1 172.1 96 147.5 96 117.8C96 103.5 101.7 89.9 111.8 79.8C121.9 69.7 135.6 64 149.8 64C164 64 177.7 69.7 187.8 79.8C197.9 89.9 203.6 103.6 203.6 117.8C203.6 147.5 179.5 172.1 149.8 172.1zM543.9 512L451.2 512L451.2 366.4C451.2 331.7 450.5 287.2 402.9 287.2C354.6 287.2 347.2 324.9 347.2 363.9L347.2 512L254.4 512L254.4 212.9L343.5 212.9L343.5 253.7L344.8 253.7C357.2 230.2 387.5 205.4 432.7 205.4C526.7 205.4 544 267.3 544 347.7L544 512L543.9 512z"/></svg>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Bagian Kanan: Artikel Terkait & Sidebar (memiliki border kiri 3px sebagai separator setinggi dirinya) --}}
            <div class="w-full lg:w-[380px] shrink-0 lg:border-l-[3px] border-[#C58F59]/10 lg:pl-[34px] pt-12 lg:pt-0">
                
                {{-- Artikel Terkait --}}
                <h2 class="text-[30px] font-bold text-[#582C0C] mb-[16px]">Artikel Terkait</h2>
                <div class="flex flex-col gap-[20px]">
                    @foreach ($relatedArticles as $related)
                    <div class="flex items-start">
                        <img src="{{ asset('images/artikel/' . $related['image']) }}" alt="{{ $related['title'] }}" class="w-[140px] h-[100px] object-cover shrink-0 mr-[16px] rounded-[12px]">
                        <div class="flex flex-col flex-1">
                            <h3 class="text-[18.75px] font-bold text-[#582C0C] leading-snug">
                                <a href="{{ route('artikel.show', $related['id']) }}" class="hover:text-[#C58F59] transition">
                                    {{ $related['title'] }}
                                </a>
                            </h3>
                            <p class="text-[14px] font-medium text-[#C58F59] mt-[8px]">{{ $related['category'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- Kategori --}}
                <h2 class="text-[30px] font-bold text-[#582C0C] mt-[32px] mb-[20px]">Kategori</h2>
                <div class="flex flex-col gap-[8px]">
                    @foreach ($categories as $cat)
                        <span class="text-[18.75px] font-semibold text-[#582C0C] hover:text-[#C58F59] cursor-pointer transition">{{ $cat }}</span>
                    @endforeach
                </div>

                {{-- Ikuti Kami --}}
                <h2 class="text-[30px] font-bold text-[#582C0C] mt-[32px] mb-[20px]">Ikuti kami</h2>
                <div class="flex gap-[12px]">
                    <div class="w-[44px] h-[44px] rounded-full flex items-center justify-center bg-[#C58F59] text-white">
                        <svg class="w-5 h-5 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><path d="M576 320C576 178.6 461.4 64 320 64C178.6 64 64 178.6 64 320C64 440 146.7 540.8 258.2 568.5L258.2 398.2L205.4 398.2L205.4 320L258.2 320L258.2 286.3C258.2 199.2 297.6 158.8 383.2 158.8C399.4 158.8 427.4 162 438.9 165.2L438.9 236C432.9 235.4 422.4 235 409.3 235C367.3 235 351.1 250.9 351.1 292.2L351.1 320L434.7 320L420.3 398.2L351 398.2L351 574.1C477.8 558.8 576 450.9 576 320z"/></svg>
                    </div>
                    <div class="w-[44px] h-[44px] rounded-full flex items-center justify-center bg-[#C58F59] text-white">
                        <svg class="w-5 h-5 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><path d="M320.3 205C256.8 204.8 205.2 256.2 205 319.7C204.8 383.2 256.2 434.8 319.7 435C383.2 435.2 434.8 383.8 435 320.3C435.2 256.8 383.8 205.2 320.3 205zM319.7 245.4C360.9 245.2 394.4 278.5 394.6 319.7C394.8 360.9 361.5 394.4 320.3 394.6C279.1 394.8 245.6 361.5 245.4 320.3C245.2 279.1 278.5 245.6 319.7 245.4zM413.1 200.3C413.1 185.5 425.1 173.5 439.9 173.5C454.7 173.5 466.7 185.5 466.7 200.3C466.7 215.1 454.7 227.1 439.9 227.1C425.1 227.1 413.1 215.1 413.1 200.3zM542.8 227.5C541.1 191.6 532.9 159.8 506.6 133.6C480.4 107.4 448.6 99.2 412.7 97.4C375.7 95.3 264.8 95.3 227.8 97.4C192 99.1 160.2 107.3 133.9 133.5C107.6 159.7 99.5 191.5 97.7 227.4C95.6 264.4 95.6 375.3 97.7 412.3C99.4 448.2 107.6 480 133.9 506.2C160.2 532.4 191.9 540.6 227.8 542.4C264.8 544.5 375.7 544.5 412.7 542.4C448.6 540.7 480.4 532.5 506.6 506.2C532.8 480 541 448.2 542.8 412.3C544.9 375.3 544.9 264.5 542.8 227.5zM495 452C487.2 471.6 472.1 486.7 452.4 494.6C422.9 506.3 352.9 503.6 320.3 503.6C287.7 503.6 217.6 506.2 188.2 494.6C168.6 486.8 153.5 471.7 145.6 452C133.9 422.5 136.6 352.5 136.6 319.9C136.6 287.3 134 217.2 145.6 187.8C153.4 168.2 168.5 153.1 188.2 145.2C217.7 133.5 287.7 136.2 320.3 136.2C352.9 136.2 423 133.6 452.4 145.2C472 153 487.1 168.1 495 187.8C506.7 217.3 504 287.3 504 319.9C504 352.5 506.7 422.6 495 452z"/></svg>
                    </div>
                    <div class="w-[44px] h-[44px] rounded-full flex items-center justify-center bg-[#C58F59] text-white">
                        <svg class="w-5 h-5 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><path d="M581.7 188.1C575.5 164.4 556.9 145.8 533.4 139.5C490.9 128 320.1 128 320.1 128C320.1 128 149.3 128 106.7 139.5C83.2 145.8 64.7 164.4 58.4 188.1C47 231 47 320.4 47 320.4C47 320.4 47 409.8 58.4 452.7C64.7 476.3 83.2 494.2 106.7 500.5C149.3 512 320.1 512 320.1 512C320.1 512 490.9 512 533.5 500.5C557 494.2 575.5 476.3 581.8 452.7C593.2 409.8 593.2 320.4 593.2 320.4C593.2 320.4 593.2 231 581.8 188.1zM264.2 401.6L264.2 239.2L406.9 320.4L264.2 401.6z"/></svg>
                    </div>
                    <div class="w-[44px] h-[44px] rounded-full flex items-center justify-center bg-[#C58F59] text-white">
                        <svg class="w-5 h-5 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><path d="M196.3 512L103.4 512L103.4 212.9L196.3 212.9L196.3 512zM149.8 172.1C120.1 172.1 96 147.5 96 117.8C96 103.5 101.7 89.9 111.8 79.8C121.9 69.7 135.6 64 149.8 64C164 64 177.7 69.7 187.8 79.8C197.9 89.9 203.6 103.6 203.6 117.8C203.6 147.5 179.5 172.1 149.8 172.1zM543.9 512L451.2 512L451.2 366.4C451.2 331.7 450.5 287.2 402.9 287.2C354.6 287.2 347.2 324.9 347.2 363.9L347.2 512L254.4 512L254.4 212.9L343.5 212.9L343.5 253.7L344.8 253.7C357.2 230.2 387.5 205.4 432.7 205.4C526.7 205.4 544 267.3 544 347.7L544 512L543.9 512z"/></svg>
                    </div>
                </div>

            </div>

        </div>
    </main>

    {{-- Footer --}}
    @include('user.components.footerWelcome')

</body>
</html>
