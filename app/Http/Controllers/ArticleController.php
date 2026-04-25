<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Menampilkan halaman daftar artikel dengan data dari database.
     */
   public function index(Request $request)
    {
        $activeFilter = $request->query('category', 'Semua');
        $searchQuery = $request->query('search', '');

        $query = Article::active();

        // Filter by category
        if ($activeFilter !== 'Semua') {
            $query->where('category', $activeFilter);
        }

        // Filter by search query
        if (!empty($searchQuery)) {
            $query->where(function($q) use ($searchQuery) {
                $q->where('title', 'like', '%' . $searchQuery . '%')
                  ->orWhere('description', 'like', '%' . $searchQuery . '%');
            });
        }

        // UBAH BAGIAN INI MENJADI 12
        $paginatedArticles = $query->latest()->paginate(12);
        $paginatedArticles->appends($request->all());

        return view('user.pages.artikel', [
            'articles' => $paginatedArticles,
            'activeFilter' => $activeFilter,
            'searchQuery' => $searchQuery
        ]);
    }

    /**
     * Menampilkan halaman detail artikel berdasarkan ID atau Slug.
     */
    public function show($id)
    {
        // Try to find by UUID first, then slug
        $article = Article::where('id', $id)->orWhere('slug', $id)->firstOrFail();

        $relatedArticles = Article::active()
            ->where('id', '!=', $article->id)
            ->where('category', $article->category)
            ->latest()
            ->take(4)
            ->get();

        if ($relatedArticles->isEmpty()) {
            $relatedArticles = Article::active()
                ->where('id', '!=', $article->id)
                ->latest()
                ->take(4)
                ->get();
        }

        $categories = [
            'Semua', 'Estetika', 'Spesialis', 'Teknologi', 'Gigi Anak', 
            'Perawatan', 'Penyakit', 'Pencegahan', 'Tips & Trick', 
            'Ortodonti', 'Gaya Hidup', 'Darurat Gigi', 'Nutrisi', 'Berita'
        ];

        return view('user.pages.detailArtikel', compact('article', 'relatedArticles', 'categories'));
    }
}