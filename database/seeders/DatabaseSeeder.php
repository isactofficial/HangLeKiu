<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
$this->call([
            RoleSeeder::class, // harus urutan pertama, karena UserSeeder butuh role_id
            UserSeeder::class,
            MasterDataSeeder::class, // Enabled - fixed code field issue
            DoctorSeeder::class, // Add doctors after master data
            TestimonialSeeder::class,
            PatientDummySeeder::class, // Add dummy patients + appointments
            FinanceSeeder::class, // Finance dummy data last (needs appointments)
        ]);
    }
}