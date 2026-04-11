<?php

namespace Database\Seeders;

use App\Models\InsurancePartner;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class InsurancePartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $partners = [
            ['name' => 'AdMedika', 'logo' => 'Admedika 1.svg'],
            ['name' => 'Avrist', 'logo' => 'Avrist 1.svg'],
            ['name' => 'Chubb', 'logo' => 'Chubb 1.svg'],
            ['name' => 'Fullerton Health Indonesia', 'logo' => 'Fullerton 2.svg'],
            ['name' => 'Generali', 'logo' => 'Generali 1.svg'],
            ['name' => 'GlobalExcel', 'logo' => 'GlobalExcel 1.svg'],
            ['name' => 'Great Eastern', 'logo' => 'GreatEastern 1.svg'],
            ['name' => 'Lippo Life', 'logo' => 'LippoLife 1.svg'],
            ['name' => 'Garda Medika', 'logo' => 'copy-of-copy-of-garda-medika-01-melinda-nitbani-1200x480 1.svg'],
            ['name' => 'Medika Plaza', 'logo' => 'MedikaPlaza 1.svg'],
            ['name' => 'Meditap', 'logo' => 'Meditap 1.svg'],
        ];

        // Ensure directory exists in storage
        if (!Storage::disk('public')->exists('insurance_partners')) {
            Storage::disk('public')->makeDirectory('insurance_partners');
        }

        foreach ($partners as $index => $data) {
            $sourcePath = public_path('images/' . $data['logo']);
            $targetFilename = 'insurance_partners/' . Str::slug($data['name']) . '_' . Str::random(5) . '.' . File::extension($sourcePath);
            
            if (File::exists($sourcePath)) {
                Storage::disk('public')->put($targetFilename, File::get($sourcePath));
                
                InsurancePartner::create([
                    'id' => (string) Str::uuid(),
                    'name' => $data['name'],
                    'logo' => $targetFilename,
                    'is_active' => true,
                    'order' => $index,
                ]);
            } else {
                // Fallback if file doesn't exist in public/images
                InsurancePartner::create([
                    'id' => (string) Str::uuid(),
                    'name' => $data['name'],
                    'logo' => null,
                    'is_active' => true,
                    'order' => $index,
                ]);
            }
        }
    }
}
