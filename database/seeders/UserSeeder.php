<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil role_id dari tabel role berdasarkan code
        // RoleSeeder harus dijalankan duluan
        $adminRoleId   = DB::table('role')->where('code', 'ADM')->value('id');
        $patientRoleId = DB::table('role')->where('code', 'PAT')->value('id');

        DB::table('user')->insertOrIgnore([
            [
                'id'            => (string) Str::uuid(),
                'name'          => 'Admin HangLeKiu',
                'email'         => 'admin@hanglekiu.com',
                'password'      => Hash::make('password'),
                'role_id'       => $adminRoleId,
                'avatar_url'    => null,
                'is_active'     => true,
                'is_verified'   => true,
                'last_login_at' => null,
                'created_at'    => now(),
                'updated_at'    => now(),
                'deleted_at'    => null,
            ],
            [
                'id'            => (string) Str::uuid(),
                'name'          => 'User Pasien',
                'email'         => 'user@hanglekiu.com',
                'password'      => Hash::make('password'),
                'role_id'       => $patientRoleId,
                'avatar_url'    => null,
                'is_active'     => true,
                'is_verified'   => false,
                'last_login_at' => null,
                'created_at'    => now(),
                'updated_at'    => now(),
                'deleted_at'    => null,
            ],
        ]);
    }
}