<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            [
                'name'       => 'Raffi Ahmad',
                'profession' => 'Artis',
                'comment'    => 'Sebagai orang yang sangat sibuk, saya butuh layanan yang serba cepat namun tetap privat dan profesional. Tim dokter di sini benar-benar ahli dalam merancang senyum yang natural dengan teknologi paling modern. Sekarang saya jauh lebih percaya diri saat tampil.',
                'order'      => 0,
                'is_active'  => true,
                'photo'      => null, // null = frontend pakai avatar fallback
            ],
            [
                'name'       => 'Sari Lestari',
                'profession' => 'Entrepreneur',
                'comment'    => 'Pengalaman veneer di sini luar biasa! Dokter sangat teliti menyesuaikan bentuk dan warna sesuai wajah saya. Hasilnya natural banget dan nyaman, recommended untuk yang ingin senyum sempurna.',
                'order'      => 1,
                'is_active'  => true,
                'photo'      => null,
            ],
            [
                'name'       => 'Budi Santoso',
                'profession' => 'Professional',
                'comment'    => 'Pemasangan behel yang sangat nyaman, dokter menjelaskan setiap tahap dengan sabar. Hasilnya jauh melampaui ekspektasi, gigi rapi dan oklusi sempurna. Layanan VIP yang pantas harganya.',
                'order'      => 2,
                'is_active'  => true,
                'photo'      => null,
            ],
        ];

        foreach ($testimonials as $data) {
            // firstOrCreate by name agar tidak duplikat saat re-seed
            if (!Testimonial::where('name', $data['name'])->exists()) {
                Testimonial::create(array_merge($data, ['id' => (string) Str::uuid()]));
            }
        }
    }
}