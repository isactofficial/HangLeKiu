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
            MasterDataSeeder::class,
            DoctorSeeder::class, // Add doctors after master data
        ]);
    }
}