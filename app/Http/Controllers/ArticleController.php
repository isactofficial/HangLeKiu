<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Menampilkan halaman daftar artikel.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('user.pages.artikel');
    }
}