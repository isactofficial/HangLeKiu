<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorPageController extends Controller
{
    /**
     * Display the public doctor profile page.
     */
    public function index()
    {
        // Fetch all active doctors along with their schedules
        $doctors = Doctor::with('schedules')
            ->where('is_active', true)
            ->orderBy('full_name')
            ->get();

        return view('user.pages.profileDokter', compact('doctors'));
    }
}
