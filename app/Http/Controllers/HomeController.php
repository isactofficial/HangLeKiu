<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\ClinicProfile;
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
                'shadow_image', 'badge_1', 'badge_2', 'bio',
                'instagram_url', 'linkedin_url'
            ]);
            
        return view('welcome', compact('doctors'));
    }

    public function klinik()
    {
        $profile = ClinicProfile::firstOrCreate(
            ['name' => 'Hanglekiu Dental Specialist'],
            [
                'id' => (string) \Illuminate\Support\Str::uuid(),
                'logo' => null,
                'address' => 'Jl. Hang Lekiu V No.8, Gunung, Kec. Kby. Baru, Kota Jakarta Selatan, 12120',
                'phone' => '085211888621',
                'operational_hours' => [
                    'monday' => '10.00 - 19.00',
                    'tuesday' => '10.00 - 19.00',
                    'wednesday' => '10.00 - 19.00',
                    'thursday' => '10.00 - 19.00',
                    'friday' => '10.00 - 19.00',
                    'saturday' => '10.00 - 13.00',
                    'sunday' => '10.00 - 13.00',
                ],
                'operational_summary' => "Senin - Jumat: 10.00 - 19.00\\nSabtu - Minggu: 10.00 - 13.00",
            ]
        );
        return view('user.pages.klinik', compact('profile'));
    }
}
