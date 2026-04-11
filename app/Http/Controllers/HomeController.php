<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $doctors = Doctor::where('is_active', true)->where('show_in_carousel', true)
            ->orderByRaw('carousel_order IS NULL, carousel_order ASC')
            ->orderBy('full_name') // secondary sort
            ->get([
                'id', 'full_name', 'specialization', 'str_number', 'foto_profil', 
                'shadow_image', 'badge_1', 'badge_2', 'bio'
            ]);
            
        return view('welcome', compact('doctors'));
    }
}
