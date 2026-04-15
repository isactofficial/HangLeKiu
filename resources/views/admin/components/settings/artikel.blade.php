<div class="article-settings-wrap">
    <div class="gs-header">
        <div style="display: flex; align-items: center; gap: 16px;">
            <a href="?menu=beranda-settings" class="gs-back-icon" title="Kembali ke Beranda Settings">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <path d="M19 12H5M12 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h2 class="gs-title">Manajemen Artikel</h2>
                <p class="gs-subtitle">Kelola konten wawasan kesehatan gigi Anda</p>
            </div>
        </div>
        <a href="{{ route('admin.articles.create') }}" class="gs-add-btn">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <path d="M12 5v14M5 12h14"/>
            </svg>
            <span>Artikel Baru</span>
        </a>
    </div>

    @include('admin.components.settings.partials.flash_success')

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
                    
                    <div class="article-footer" style="justify-content: flex-end;">
                        
                        <div class="article-actions">
                            <a href="{{ route('admin.articles.edit', $article->id) }}" class="art-btn art-btn-edit" title="Edit">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                </svg>
                            </a>
                            <form action="{{ route('admin.articles.destroy', $article->id) }}" method="POST" class="js-article-delete-form" data-article-title="{{ $article->title }}">
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

<div id="article-delete-overlay" class="article-confirm-overlay" style="display:none;">
    <div class="article-confirm-box">
        <div class="article-confirm-title">Konfirmasi Hapus</div>
        <div class="article-confirm-message" id="article-delete-message">Data yang dihapus tidak dapat dikembalikan. Lanjutkan?</div>
        <div class="article-confirm-actions">
            <button type="button" class="article-confirm-btn article-confirm-cancel" id="article-delete-cancel">Batal</button>
            <button type="button" class="article-confirm-btn article-confirm-danger" id="article-delete-ok">Ya, Hapus</button>
        </div>
    </div>
</div>

<script>
    (function () {
        const overlay = document.getElementById('article-delete-overlay');
        const msg = document.getElementById('article-delete-message');
        const btnCancel = document.getElementById('article-delete-cancel');
        const btnOk = document.getElementById('article-delete-ok');
        let pendingForm = null;

        function closeDeletePopup() {
            overlay.style.display = 'none';
            pendingForm = null;
        }

        document.querySelectorAll('.js-article-delete-form').forEach((form) => {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                pendingForm = form;
                const articleTitle = (form.dataset.articleTitle || '').trim();
                msg.textContent = articleTitle
                    ? `Hapus artikel "${articleTitle}"`
                    : 'Data yang dihapus tidak dapat dikembalikan. Lanjutkan?';
                overlay.style.display = 'flex';
            });
        });

        btnCancel.addEventListener('click', closeDeletePopup);
        btnOk.addEventListener('click', function () {
            if (pendingForm) pendingForm.submit();
            closeDeletePopup();
        });
        overlay.addEventListener('click', function (e) {
            if (e.target === overlay) closeDeletePopup();
        });
    })();
</script>

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
    .gs-back-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 10px;
        color: #B09A85;
        transition: all 0.2s ease;
    }
    .gs-back-icon:hover {
        background: #F7F0E6;
        color: var(--color-primary);
        transform: translateX(-3px);
    }
    .gs-title {
        font-size: 20px;
        font-weight: 700;
        color: var(--font-color-primary);
        margin-bottom: 4px;
    }
    .gs-subtitle {
        font-size: 13px;
        color: #B09A85;
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
        color: #B09A85;
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
    .article-confirm-overlay {
        position: fixed;
        inset: 0;
        background: rgba(44, 27, 16, 0.46);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 10000;
        padding: 16px;
        box-sizing: border-box;
    }
    .article-confirm-box {
        width: min(100%, 620px);
        max-height: calc(100vh - 32px);
        overflow: auto;
        background: #FFFDFB;
        border-radius: 18px;
        box-shadow: 0 26px 56px rgba(47, 29, 17, 0.28);
        border: 1px solid #E9D8C8;
        padding: 28px 24px;
        box-sizing: border-box;
        text-align: center;
    }
    .article-confirm-title {
        font-size: 24px;
        font-weight: 700;
        line-height: 1.15;
        color: #2B1609;
        margin-bottom: 14px;
    }
    .article-confirm-message {
        font-size: 20px;
        color: #5E3A24;
        line-height: 1.45;
        max-width: 90%;
        margin: 0 auto;
    }
    .article-confirm-actions {
        display: flex;
        justify-content: center;
        gap: 14px;
        margin-top: 32px;
    }
    .article-confirm-btn {
        border-radius: 12px;
        padding: 13px 22px;
        cursor: pointer;
        font-size: 18px;
        font-weight: 600;
        line-height: 1.2;
        transition: all 0.2s ease;
    }
    .article-confirm-cancel {
        border: 1px solid #D9B69A;
        background: #FFF7F1;
        color: #582C0C;
    }
    .article-confirm-cancel:hover {
        background: #F8E6D8;
        border-color: #C99E7F;
    }
    .article-confirm-danger {
        border: none;
        background: #582C0C;
        color: #fff;
    }
    .article-confirm-danger:hover {
        background: #442108;
    }

    @media (max-width: 768px) {
        .article-confirm-overlay {
            padding: 12px;
        }
        .article-confirm-box {
            width: 100%;
            max-height: calc(100vh - 24px);
            padding: 22px 18px;
        }
        .article-confirm-title {
            font-size: 22px;
        }
        .article-confirm-message {
            font-size: 18px;
        }
        .article-confirm-btn {
            font-size: 16px;
            padding: 11px 18px;
        }
        .article-confirm-actions {
            flex-direction: column;
            align-items: stretch;
        }
    }
</style>
