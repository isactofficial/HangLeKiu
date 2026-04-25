<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hanglekiu Dental — {{ $article->title }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Format Justify & List Custom */
        .article-content {
            text-align: justify;
            text-justify: inter-word;
        }
        /* Style untuk bullet points dari tanda minus (-) */
        .article-content ul {
            list-style-type: disc;
            margin-left: 1.5rem;
            margin-top: 1rem;
            margin-bottom: 1.5rem;
        }
        .article-content li {
            margin-bottom: 0.5rem;
            padding-left: 0.5rem;
        }
        /* Style khusus untuk teks di dalam bintang agar font lebih besar */
        .highlight-bold {
            display: inline-block;
            line-height: 1.2;
            margin-top: 8px;
            margin-bottom: 4px;
        }
    </style>
</head>

<body class="font-sans text-[var(--font-color-primary)] m-0 min-h-screen flex flex-col relative bg-[#FAF9F6]">

    {{-- Navbar --}}
    @include('user.components.navbarWelcome')

    {{-- Content --}}
    <main class="flex-grow pt-[70px] -mt-[1px] mb-24">
        
        {{-- Custom Header Banner --}}
        <div class="w-full min-h-[160px] md:min-h-[200px] lg:min-h-[220px] py-[40px] md:py-[60px] relative flex justify-center items-center bg-cover bg-center overflow-hidden" style="background-image: url('{{ asset('images/detailArtikel/bg-header.png') }}');">
            <div class="absolute inset-0 bg-black/40"></div>
            <div class="relative z-10 flex flex-col lg:flex-row items-center justify-between w-full max-w-7xl px-6 md:px-10">
                <div class="flex flex-col items-center lg:items-start shrink-0">
                    <img src="{{ asset('images/logo-hds.png') }}" alt="Hanglekiu Dental Logo" class="h-[60px] md:h-[80px] w-auto object-contain">
                    <p class="text-white font-medium text-[16px] mt-[-4px]">Hanglekiu dental specialist</p>
                </div>
                <div class="flex items-center text-white text-[16px] shrink-0 font-medium mt-6 lg:mt-0">
                    <a href="{{ route('artikel') }}" class="hover:text-[#C58F59] transition-colors">Artikel</a>
                    <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    <span class="opacity-80 truncate max-w-[200px] md:max-w-md">{{ $article->title }}</span>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-6 md:px-10 mt-[67px] flex flex-col lg:flex-row items-start lg:gap-[48px] pb-24">

            {{-- Bagian Kiri: Detail Artikel Utama --}}
            <div class="w-full lg:flex-1 lg:min-w-0">
                <div class="flex items-center gap-4 mb-4">
                    <span class="bg-[#C58F59] text-white px-4 py-1.5 rounded-full text-sm font-bold uppercase tracking-wider">
                        {{ $article->category }}
                    </span>
                </div>

                <h1 class="text-[32px] md:text-[48px] font-bold text-[#582C0C] leading-tight">
                    {{ $article->title }}
                </h1>
                
                {{-- Keterangan Penulis & Tanggal --}}
                <div class="flex items-center gap-3 mt-6 text-[16px] font-medium text-[#6B513E]">
                    <div class="w-10 h-10 rounded-full bg-[#C58F59] flex items-center justify-center text-white">
                        <i class="fas fa-user-edit text-sm"></i>
                    </div>
                    <div>
                        <p class="text-[14px] leading-tight">Ditulis oleh:</p>
                        <p class="text-[#582C0C] font-bold">
                            {{ $article->author ?? 'Klinik HangLeKiu' }} 
                            <span class="font-medium text-[#6B513E] ml-1 opacity-60">• {{ $article->created_at->format('d F Y') }}</span>
                        </p>
                    </div>
                </div>
                
                {{-- Gambar Artikel --}}
                <div class="relative w-full aspect-video md:aspect-[16/9] mt-[40px] rounded-[24px] overflow-hidden shadow-xl">
                    <img src="{{ asset('images/artikel/' . ($article->image ?: 'placeholder.png')) }}" alt="{{ $article->title }}" class="w-full h-full object-cover">
                </div>
                
                {{-- Konten Artikel --}}
                <div class="article-content text-[18px] md:text-[20px] text-[#6B513E] mt-[40px] leading-relaxed">
                    @php
                        $content = e($article->content); 
                        
                        // 1. Format Bold & Perbesar Font: *teks* -> font lebih besar & extra bold
                        $content = preg_replace('/\*(.*?)\*/', '<strong class="highlight-bold text-[#582C0C] font-extrabold text-[24px] md:text-[28px]">$1</strong>', $content);
                        
                        // 2. Format Bullet Points (-)
                        $lines = explode("\n", $content);
                        $inList = false;
                        $formattedContent = "";

                        foreach ($lines as $line) {
                            if (preg_match('/^\s*-\s+(.*)/', $line, $matches)) {
                                if (!$inList) {
                                    $formattedContent .= '<ul class="my-4">';
                                    $inList = true;
                                }
                                $formattedContent .= '<li>' . $matches[1] . '</li>';
                            } else {
                                if ($inList) {
                                    $formattedContent .= '</ul>';
                                    $inList = false;
                                }
                                $formattedContent .= $line . "<br>";
                            }
                        }
                        if ($inList) $formattedContent .= '</ul>';
                    @endphp
                    
                    {!! $formattedContent !!}

                    @if($article->source)
                        <div class="mt-12 p-5 bg-[#E5D6C5]/30 border-l-4 border-[#C58F59] rounded-r-xl">
                            <p class="text-sm font-bold text-[#582C0C]">Sumber: {{ $article->source }}</p>
                    
                        </div>
                    @endif
                </div>
                
                {{-- Bagian Share --}}
                <div class="mt-[80px] pt-[40px] border-t border-gray-200">
                    <h3 class="text-[22px] font-bold text-[#582C0C] mb-6">Bagikan wawasan ini</h3>
                    <div class="flex gap-4">
                        {{-- Facebook (Ikon Biru, Hover Coklat) --}}
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" target="_blank" 
                           class="group w-[50px] h-[50px] shrink-0 rounded-full flex items-center justify-center bg-transparent border-2 border-[#C58F59] hover:bg-[#C58F59] hover:scale-110 transition-all duration-300">
                            <i class="fab fa-facebook-f text-[#1877F2] text-[20px] group-hover:text-white transition-colors"></i>
                        </a>
                        
                        {{-- WhatsApp (Ikon Hijau, Hover Coklat) --}}
                        <a href="https://wa.me/?text={{ urlencode($article->title . ' ' . request()->fullUrl()) }}" target="_blank" 
                           class="group w-[50px] h-[50px] shrink-0 rounded-full flex items-center justify-center bg-transparent border-2 border-[#C58F59] hover:bg-[#C58F59] hover:scale-110 transition-all duration-300">
                            <i class="fab fa-whatsapp text-[#25D366] text-[22px] group-hover:text-white transition-colors"></i>
                        </a>
                        
                        {{-- Copy Link (Ikon Coklat, Hover Coklat) --}}
                        <button onclick="copyArticleLink('{{ request()->fullUrl() }}')" 
                                class="group w-[50px] h-[50px] shrink-0 rounded-full flex items-center justify-center bg-transparent border-2 border-[#C58F59] hover:bg-[#C58F59] hover:scale-110 transition-all duration-300 cursor-pointer" 
                                id="copyLinkBtn">
                            <i class="fas fa-link text-[#C58F59] text-[18px] group-hover:text-white transition-colors"></i>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Bagian Kanan: Sidebar (Diperbarui) --}}
            <aside class="w-full lg:w-[380px] shrink-0 lg:border-l border-gray-200 lg:pl-[40px] pt-12 lg:pt-0">
                
                {{-- Artikel Terkait --}}
                <div class="mb-14">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="h-8 w-1.5 bg-[#C58F59] rounded-full"></div>
                        <h2 class="text-[24px] font-bold text-[#582C0C]">Artikel Terkait</h2>
                    </div>
                    <div class="flex flex-col gap-6">
                        @foreach ($relatedArticles as $related)
                        <a href="{{ route('artikel.show', $related->slug) }}" class="group flex gap-4 items-start">
                            {{-- Foto Kecil (Thumbnail) --}}
                            <div class="w-[120px] h-[90px] shrink-0 rounded-xl overflow-hidden shadow-md">
                                <img src="{{ asset('images/artikel/' . ($related->image ?: 'placeholder.png')) }}" alt="{{ $related->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            </div>
                            
                            {{-- Detail (Kategori, Judul, Deskripsi Singkat) --}}
                            <div class="flex flex-col flex-1 pt-1">
                                <span class="text-[10px] font-bold text-[#C58F59] uppercase tracking-wider mb-1">
                                    {{ $related->category }}
                                </span>
                                <h3 class="text-[15px] font-bold text-[#582C0C] leading-snug group-hover:text-[#C58F59] transition-colors line-clamp-2">
                                    {{ $related->title }}
                                </h3>
                                <p class="text-[12px] text-[#6B513E] line-clamp-2 mt-1.5 leading-relaxed opacity-80">
                                    {{ $related->description }}
                                </p>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>

                {{-- Kategori (Tombol Rapih) --}}
                <div class="mb-14">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="h-8 w-1.5 bg-[#C58F59] rounded-full"></div>
                        <h2 class="text-[24px] font-bold text-[#582C0C]">Kategori</h2>
                    </div>
                    <div class="flex flex-wrap gap-2.5">
                        @foreach ($categories as $cat)
                            <a href="{{ route('artikel', ['category' => $cat]) }}" class="px-5 py-2.5 bg-white border border-[#E5D6C5] rounded-xl text-[14px] font-bold text-[#6B513E] hover:bg-[#C58F59] hover:text-white hover:border-[#C58F59] hover:shadow-md transition-all duration-300">
                                {{ $cat }}
                            </a>
                        @endforeach
                    </div>
                </div>

                {{-- Box Konsultasi --}}
                <div class="bg-[#582C0C] rounded-3xl p-8 text-white shadow-2xl relative overflow-hidden">
                    <div class="absolute -top-10 -right-10 w-32 h-32 bg-white/5 rounded-full"></div>
                    <h2 class="text-[20px] font-bold mb-3 relative z-10">Butuh Konsultasi?</h2>
                    <p class="text-white/70 text-sm mb-6 relative z-10">Klik tombol di bawah untuk terhubung langsung dengan admin kami via WhatsApp.</p>
                    <a href="https://wa.me/628111111111" target="_blank" class="block text-center bg-[#C58F59] text-white px-6 py-3 rounded-xl font-bold hover:bg-white hover:text-[#582C0C] transition-all shadow-lg relative z-10">Hubungi Sekarang</a>
                </div>
            </aside>

        </div>
    </main>

    {{-- Footer --}}
    @include('user.components.footerWelcome')

    <script>
        function copyArticleLink(url) {
            navigator.clipboard.writeText(url).then(() => {
                const btn = document.getElementById('copyLinkBtn');
                
                // Simpan icon aslinya
                const originalIcon = btn.innerHTML;
                
                // Ubah icon jadi centang (Check)
                btn.innerHTML = '<i class="fas fa-check text-white text-[20px]"></i>';
                
                // Ganti warna background jadi hijau sukses
                btn.classList.remove('bg-transparent', 'border-[#C58F59]', 'hover:bg-[#C58F59]');
                btn.classList.add('bg-[#25D366]', 'border-[#25D366]');
                
                setTimeout(() => {
                    // Kembalikan seperti semula setelah 2 detik
                    btn.innerHTML = originalIcon;
                    btn.classList.remove('bg-[#25D366]', 'border-[#25D366]');
                    btn.classList.add('bg-transparent', 'border-[#C58F59]', 'hover:bg-[#C58F59]');
                }, 2000);
            });
        }
    </script>
</body>
</html>