<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Data mockartikel.
     * 
     * @return array
     */
    private function getMockArticles()
    {
        return [
            [
                'id' => 1,
                'title' => 'Mengapa Penanganan Spesialis Itu Krusial?',
                'description' => 'Mengenal lebih dekat dedikasi tim spesialis di Hanglekiu Dental Specialist dalam memastikan setiap prosedur medis dilakukan dengan tingkat presisi dan akurasi tertinggi...',
                'category' => 'Spesialis',
                'image' => 'Gemini_Generated_Image_5gzzya5gzzya5gzz 1.png'
            ],
            [
                'id' => 2,
                'title' => 'Pentingnya Menjaga Estetika Gigi',
                'description' => 'Estetika gigi tidak hanya tentang penampilan, tetapi juga tentang kesehatan dan kepercayaan diri Anda secara keseluruhan dalam kehidupan sehari-hari.',
                'category' => 'Estetika',
                'image' => 'Gemini_Generated_Image_cbmdtkcbmdtkcbmd 1.png'
            ],
            [
                'id' => 3,
                'title' => 'Teknologi Terbaru dalam Perawatan Gigi',
                'description' => 'Inovasi teknologi terkini yang digunakan di klinik kami untuk memberikan perawatan yang efektif, efisien, nyaman, dan hasil yang optimal.',
                'category' => 'Teknologi',
                'image' => 'Gemini_Generated_Image_ea77ekea77ekea77 1.png'
            ],
            [
                'id' => 4,
                'title' => 'Panduan Merawat Gigi Anak Sejak Dini',
                'description' => 'Tips dan panduan komprehensif bagi orang tua untuk menjaga kesehatan gigi dan mulut anak sejak gigi susu pertama mereka tumbuh.',
                'category' => 'Gigi Anak',
                'image' => 'Gemini_Generated_Image_eabpqpeabpqpeabp 1.png'
            ],
            [
                'id' => 5,
                'title' => 'Tips & Trik Menyikat Gigi yang Benar',
                'description' => 'Teknik menyikat gigi yang direkomendasikan dokter untuk memastikan kebersihan maksimal tanpa merusak enamel gigi Anda dalam jangka panjang.',
                'category' => 'Tips and Trick',
                'image' => 'Gemini_Generated_Image_vs0bfkvs0bfkvs0b 1.png'
            ],
            [
                'id' => 6,
                'title' => 'Kapan Harus Mengunjungi Dokter Spesialis bedah Mulut?',
                'description' => 'Kenali tanda-tanda dan kondisi tertentu yang mengharuskan Anda untuk segera berkonsultasi dengan dokter gigi spesialis bedah mulut.',
                'category' => 'Spesialis',
                'image' => 'Gemini_Generated_Image_z3m7mrz3m7mrz3m7 1.png'
            ]
        ];
    }

    /**
     * Menampilkan halaman daftar artikel dengan simulasi Data, Search, Filter & Pagination.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $articles = $this->getMockArticles();

        // Retrieve query parameters
        $activeFilter = $request->query('category', 'Semua');
        $searchQuery = $request->query('search', '');

        // Generate Collection
        $collection = collect($articles);

        // Filter by category
        if ($activeFilter !== 'Semua') {
            $collection = $collection->where('category', $activeFilter);
        }

        // Filter by search query
        if (!empty($searchQuery)) {
            $collection = $collection->filter(function ($item) use ($searchQuery) {
                return str_contains(strtolower($item['title']), strtolower($searchQuery)) ||
                       str_contains(strtolower($item['description']), strtolower($searchQuery));
            });
        }

        // Pagination setup
        $perPage = 6;
        $currentPage = \Illuminate\Pagination\Paginator::resolveCurrentPage() ?: 1;
        $paginatedArticles = new \Illuminate\Pagination\LengthAwarePaginator(
            $collection->forPage($currentPage, $perPage),
            $collection->count(),
            $perPage,
            $currentPage,
            ['path' => \Illuminate\Pagination\Paginator::resolveCurrentPath()]
        );
        $paginatedArticles->appends($request->all());

        return view('user.pages.artikel', [
            'articles' => $paginatedArticles,
            'activeFilter' => $activeFilter,
            'searchQuery' => $searchQuery
        ]);
    }

    /**
     * Menampilkan halaman detail artikel berdasarkan ID.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $articles = collect($this->getMockArticles());
        $article = $articles->firstWhere('id', (int) $id);

        if (!$article) {
            abort(404, 'Artikel tidak ditemukan');
        }

        // Simulate a longer content body for the detail page based on description
        $article['content'] = $article['description'] . '<br><br>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.';

        $relatedArticles = $articles->where('id', '!=', (int) $id)->take(4);
        $categories = ['Semua', 'Estetika', 'Spesialis', 'Teknologi', 'Gigi Anak', 'Tips and Trick'];

        return view('user.pages.detailArtikel', compact('article', 'relatedArticles', 'categories'));
    }
}