<?php

namespace Database\Seeders;

use App\Models\ClinicProfile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ClinicProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ClinicProfile::updateOrCreate(
            ['name' => 'Hanglekiu Dental Specialist'],
            [
                'id' => (string) Str::uuid(),
                'logo' => null, // Default can be set via controller or just leave null for now
                'address' => '8, Jl. Hang Lekiu V No.8, RT.6/RW.4, Gunung, Kec. Kby. Baru, Kota Jakarta Selatan, Daerah Khusus Ibukota Jakarta 12120',
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
                'operational_summary' => "Senin - Jumat: 10.00 - 19.00\nSabtu - Minggu: 10.00 - 13.00",
            ]
        );
    }
}
