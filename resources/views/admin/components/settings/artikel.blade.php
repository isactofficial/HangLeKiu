<div class="article-settings-wrap">
    <div class="gs-header">
        <div>
            <h2 class="gs-title">Manajemen Artikel</h2>
            <p class="gs-subtitle">Kelola konten wawasan kesehatan gigi Anda</p>
        </div>
        <a href="{{ route('admin.articles.create') }}" class="gs-add-btn">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <path d="M12 5v14M5 12h14"/>
            </svg>
            <span>Artikel Baru</span>
        </a>
    </div>

    @if(session('success'))
        <div class="gs-alert gs-alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="article-grid">
        @forelse($articles as $article)
            <div class="article-card">
                <div class="article-img-wrap">
                    <img src="{{ asset('images/artikel/' . ($article->image ?: 'placeholder.png')) }}" alt="{{ $article->title }}" class="article-img">
                    <span class="article-badge">{{ $article->category }}</span>
                </div>
                <div class="article-body">
                    <h3 class="article-h">{{ $article->title }}</h3>
                    <p class="article-p">{{ Str::limit($article->description, 80) }}</p>
                    
                    <div class="article-footer">
                        <div class="article-rating">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" style="color: #FFB800;">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                            <span>{{ number_format($article->rating, 1) }}</span>
                        </div>
                        <div class="article-actions">
                            <a href="{{ route('admin.articles.edit', $article->id) }}" class="art-btn art-btn-edit" title="Edit">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                </svg>
                            </a>
                            <form action="{{ route('admin.articles.destroy', $article->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus artikel ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="art-btn art-btn-delete" title="Hapus">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M3 6h18M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2M10 11v6M14 11v6"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="gs-empty">
                <p>Belum ada artikel. Silakan buat artikel pertama Anda!</p>
            </div>
        @endforelse
    </div>

    <div class="gs-pagination">
        {{ $articles->links() }}
    </div>
</div>

<style>
    .article-settings-wrap {
        padding: 10px;
    }
    .gs-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }
    .gs-title {
        font-size: 20px;
        font-weight: 700;
        color: var(--font-color-primary);
        margin-bottom: 4px;
    }
    .gs-subtitle {
        font-size: 13px;
        color: #666;
    }
    .gs-add-btn {
        background: var(--color-primary);
        color: white;
        padding: 10px 18px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
    }
    .gs-add-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    .gs-alert {
        padding: 12px 16px;
        border-radius: 10px;
        margin-bottom: 20px;
        font-size: 14px;
    }
    .gs-alert-success {
        background: #E8F5E9;
        color: #2E7D32;
        border: 1px solid #C8E6C9;
    }
    .article-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        gap: 20px;
    }
    .article-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid #eee;
        transition: all 0.3s ease;
    }
    .article-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.06);
    }
    .article-img-wrap {
        position: relative;
        height: 140px;
    }
    .article-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .article-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        background: rgba(255,255,255,0.9);
        color: var(--color-primary);
        padding: 4px 8px;
        border-radius: 6px;
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
    }
    .article-body {
        padding: 15px;
    }
    .article-h {
        font-size: 15px;
        font-weight: 700;
        margin-bottom: 8px;
        color: var(--font-color-primary);
        line-height: 1.4;
    }
    .article-p {
        font-size: 12px;
        color: #666;
        line-height: 1.5;
        margin-bottom: 12px;
    }
    .article-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 12px;
        border-top: 1px solid #f5f5f5;
    }
    .article-rating {
        display: flex;
        align-items: center;
        gap: 4px;
        font-size: 12px;
        font-weight: 700;
        color: #FFB800;
    }
    .article-actions {
        display: flex;
        gap: 8px;
    }
    .art-btn {
        width: 30px;
        height: 30px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
    }
    .art-btn-edit { background: #E3F2FD; color: #1976D2; }
    .art-btn-delete { background: #FFEBEE; color: #D32F2F; border: none; cursor: pointer; }
    .art-btn:hover { transform: scale(1.1); }
    .gs-empty {
        grid-column: 1 / -1;
        text-align: center;
        padding: 40px;
        color: #999;
        background: #fdfdfd;
        border-radius: 16px;
        border: 2px dashed #eee;
    }
</style>
