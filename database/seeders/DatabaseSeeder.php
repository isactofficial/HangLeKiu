<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $roleAdminId = (string) Str::uuid();
        $rolePatientId = (string) Str::uuid();

        DB::table('role')->insert([
            [
                'id' => $roleAdminId,
                'code' => 'ADM',
                'name' => 'Admin',
                'permissions' => null,
                'created_at' => now(),
            ],
            [
                'id' => $rolePatientId,
                'code' => 'PAT',
                'name' => 'Patient',
                'permissions' => null,
                'created_at' => now(),
            ],
        ]);

        DB::table('user')->insert([
            [
                'id' => (string) Str::uuid(),
                'name' => 'Admin HangLeKiu',
                'email' => 'admin@hanglekiu.com',
                'password' => Hash::make('password'),
                'role_id' => $roleAdminId,
                'avatar_url' => null,
                'is_active' => true,
                'is_verified' => true,
                'last_login_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'id' => (string) Str::uuid(),
                'name' => 'User Pasien',
                'email' => 'user@hanglekiu.com',
                'password' => Hash::make('password'),
                'role_id' => $rolePatientId,
                'avatar_url' => null,
                'is_active' => true,
                'is_verified' => false,
                'last_login_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
        ]);
    }
}
