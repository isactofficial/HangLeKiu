<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ArticleAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $articles = Article::latest()->paginate(10);
            return response()->json([
                'success' => true,
                'data' => $articles
            ]);
        }
        
        return redirect()->route('admin.settings', ['menu' => 'general-settings', 'submenu' => 'Artikel']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = ['Estetika', 'Spesialis', 'Teknologi', 'Gigi Anak', 'Tips and Trick'];
        return view('admin.components.settings.artikel_create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'description' => 'required|string',
            'content' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/artikel'), $imageName);
            $data['image'] = $imageName;
        }

        $article = Article::create($data);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Artikel berhasil dibuat.',
                'data' => $article
            ], 201);
        }

        return redirect()->route('admin.settings', ['menu' => 'general-settings', 'submenu' => 'Artikel'])->with('success', 'Artikel berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $article = Article::find($id);

        if (!$article) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Artikel tidak ditemukan.'
                ], 404);
            }
            abort(404);
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $article
            ]);
        }

        return view('admin.pages.articles.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $article = Article::findOrFail($id);
        $categories = ['Estetika', 'Spesialis', 'Teknologi', 'Gigi Anak', 'Tips and Trick'];
        return view('admin.components.settings.artikel_edit', compact('article', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $article = Article::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'description' => 'required|string',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($article->image && File::exists(public_path('images/artikel/' . $article->image))) {
                File::delete(public_path('images/artikel/' . $article->image));
            }

            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/artikel'), $imageName);
            $data['image'] = $imageName;
        }

        $article->update($data);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Artikel berhasil diperbarui.',
                'data' => $article
            ]);
        }

        return redirect()->route('admin.settings', ['menu' => 'general-settings', 'submenu' => 'Artikel'])->with('success', 'Artikel berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $article = Article::find($id);

        if (!$article) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Artikel tidak ditemukan.'
                ], 404);
            }
            abort(404);
        }
        
        $article->delete();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Artikel berhasil dihapus.'
            ]);
        }

        return redirect()->route('admin.settings', ['menu' => 'general-settings', 'submenu' => 'Artikel'])->with('success', 'Artikel berhasil dihapus.');
    }
}
