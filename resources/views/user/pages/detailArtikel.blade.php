<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hanglekiu Dental — {{ $article->title }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-[var(--font-color-primary)] m-0 min-h-screen flex flex-col relative bg-[#FAF9F6]">

    {{-- Navbar --}}
    @include('user.components.navbarWelcome')

    {{-- Content --}}
    <main class="flex-grow pt-[70px] -mt-[1px] mb-24">
        
        {{-- Custom Header Banner --}}
        <div class="w-full min-h-[160px] md:min-h-[200px] lg:min-h-[220px] py-[40px] md:py-[60px] relative flex justify-center items-center bg-cover bg-center overflow-hidden" style="background-image: url('{{ asset('images/detailArtikel/bg-header.png') }}');">
            {{-- Dark Overlay --}}
            <div class="absolute inset-0 bg-black/40"></div>

            <div class="relative z-10 flex flex-col lg:flex-row items-center justify-between w-full max-w-7xl px-6 md:px-10">
                {{-- Bagian Kiri (Logo & Title) --}}
                <div class="flex flex-col items-center lg:items-start shrink-0">
                    <img src="{{ asset('images/logo-hds.png') }}" alt="Hanglekiu Dental Logo" class="h-[60px] md:h-[80px] w-auto object-contain">
                    <p class="text-white font-medium text-[16px] mt-[-4px]">Hanglekiu dental specialist</p>
                </div>

                {{-- Bagian Kanan (Path Artikel) --}}
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
                {{-- Category & Rating --}}
                <div class="flex items-center gap-4 mb-4">
                    <span class="bg-[#C58F59] text-white px-4 py-1.5 rounded-full text-sm font-bold uppercase tracking-wider">
                        {{ $article->category }}
                    </span>
                    <div class="flex items-center gap-1.5 text-[#FFB800] bg-white px-3 py-1.5 rounded-full shadow-sm border border-gray-100">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                        </svg>
                        <span class="text-[16px] font-bold">{{ number_format($article->rating, 1) }}</span>
                    </div>
                </div>

                {{-- Judul --}}
                <h1 class="text-[36px] md:text-[48px] font-bold text-[#582C0C] leading-tight">
                    {{ $article->title }}
                </h1>
                
                {{-- Keterangan Penulis --}}
                <div class="flex items-center gap-3 mt-4 text-[16px] font-medium text-[#6B513E]">
                    <div class="w-8 h-8 rounded-full bg-[#C58F59] flex items-center justify-center text-white text-xs">A</div>
                    <p>Dibuat oleh <span class="text-[#582C0C] font-bold">Admin HDS</span> • {{ $article->created_at->format('d F Y') }}</p>
                </div>
                
                {{-- Gambar Artikel --}}
                <div class="relative w-full aspect-video md:aspect-[16/9] mt-[40px] rounded-[24px] overflow-hidden shadow-xl">
                    <img src="{{ asset('images/artikel/' . ($article->image ?: 'placeholder.png')) }}" alt="{{ $article->title }}" class="w-full h-full object-cover">
                </div>
                
                {{-- Konten Artikel --}}
                <div class="article-content prose prose-lg max-w-none text-[18px] md:text-[20px] font-medium text-[#6B513E] mt-[40px] leading-relaxed">
                    {!! nl2br($article->content) !!}
                </div>
                
                {{-- Share --}}
                <div class="mt-[60px] pt-[40px] border-t border-gray-200">
                    <h3 class="text-[24px] font-bold text-[#582C0C] mb-6">Bagikan artikel ini</h3>
                    <div class="flex gap-4">
                        {{-- Facebook --}}
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('artikel.show', $article->slug)) }}" 
                           target="_blank" rel="noopener noreferrer"
                           class="w-[50px] h-[50px] rounded-full flex items-center justify-center bg-[#1877F2] text-white hover:scale-110 transition-transform"
                           title="Bagikan ke Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>

                        {{-- Twitter / X --}}
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('artikel.show', $article->slug)) }}&text={{ urlencode($article->title) }}" 
                           target="_blank" rel="noopener noreferrer"
                           class="w-[50px] h-[50px] rounded-full flex items-center justify-center bg-[#1DA1F2] text-white hover:scale-110 transition-transform"
                           title="Bagikan ke Twitter">
                            <i class="fab fa-twitter"></i>
                        </a>

                        {{-- WhatsApp --}}
                        <a href="https://wa.me/?text={{ urlencode($article->title . ' - ' . route('artikel.show', $article->slug)) }}" 
                           target="_blank" rel="noopener noreferrer"
                           class="w-[50px] h-[50px] rounded-full flex items-center justify-center bg-[#25D366] text-white hover:scale-110 transition-transform"
                           title="Bagikan ke WhatsApp">
                            <i class="fab fa-whatsapp"></i>
                        </a>

                        {{-- Copy Link --}}
                        <button onclick="copyArticleLink('{{ route('artikel.show', $article->slug) }}')" 
                                class="w-[50px] h-[50px] rounded-full flex items-center justify-center bg-gray-200 text-[#582C0C] hover:scale-110 transition-transform cursor-pointer"
                                title="Salin Link"
                                id="copyLinkBtn">
                            <i class="fas fa-link"></i>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Bagian Kanan: Artikel Terkait & Sidebar --}}
            <aside class="w-full lg:w-[380px] shrink-0 lg:border-l border-gray-200 lg:pl-[40px] pt-12 lg:pt-0">
                
                {{-- Artikel Terkait --}}
                <div class="mb-12">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="h-8 w-1.5 bg-[#C58F59] rounded-full"></div>
                        <h2 class="text-[24px] font-bold text-[#582C0C]">Artikel Terkait</h2>
                    </div>
                    
                    <div class="flex flex-col gap-6">
                        @foreach ($relatedArticles as $related)
                        <a href="{{ route('artikel.show', $related->slug) }}" class="group flex gap-4">
                            <div class="w-[120px] h-[90px] shrink-0 rounded-xl overflow-hidden shadow-md">
                                <img src="{{ asset('images/artikel/' . ($related->image ?: 'placeholder.png')) }}" alt="{{ $related->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            </div>
                            <div class="flex flex-col justify-center">
                                <h3 class="text-[16px] font-bold text-[#582C0C] leading-snug group-hover:text-[#C58F59] transition-colors line-clamp-2">
                                    {{ $related->title }}
                                </h3>
                                <p class="text-[12px] font-bold text-[#C58F59] mt-2 uppercase">{{ $related->category }}</p>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>

                {{-- Kategori --}}
                <div class="mb-12">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="h-8 w-1.5 bg-[#C58F59] rounded-full"></div>
                        <h2 class="text-[24px] font-bold text-[#582C0C]">Kategori</h2>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($categories as $cat)
                            <a href="{{ route('artikel', ['category' => $cat]) }}" class="px-4 py-2 bg-white border border-gray-200 rounded-lg text-[15px] font-bold text-[#6B513E] hover:bg-[#C58F59] hover:text-white hover:border-[#C58F59] transition-all">
                                {{ $cat }}
                            </a>
                        @endforeach
                    </div>
                </div>

                {{-- Ikuti Kami --}}
                <div class="bg-[#582C0C] rounded-3xl p-8 text-white relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-white/5 rounded-full -mr-12 -mt-12"></div>
                    <h2 class="text-[20px] font-bold mb-4 relative z-10">Ikuti Kami</h2>
                    <p class="text-white/70 text-sm mb-6 relative z-10">Dapatkan update terbaru seputar kesehatan gigi langsung di media sosial Anda.</p>
                    <div class="flex gap-4 relative z-10">
                        <a href="#" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-[#C58F59] transition-colors"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-[#C58F59] transition-colors"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-[#C58F59] transition-colors"><i class="fab fa-tiktok"></i></a>
                    </div>
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
                const originalIcon = btn.innerHTML;
                
                // Feedback visual: ganti icon sementara
                btn.innerHTML = '<i class="fas fa-check"></i>';
                btn.classList.remove('bg-gray-200');
                btn.classList.add('bg-green-500', 'text-white');
                
                setTimeout(() => {
                    btn.innerHTML = originalIcon;
                    btn.classList.remove('bg-green-500', 'text-white');
                    btn.classList.add('bg-gray-200');
                }, 2000);
            }).catch(err => {
                console.error('Gagal menyalin link: ', err);
            });
        }
    </script>
</body>
</html>
