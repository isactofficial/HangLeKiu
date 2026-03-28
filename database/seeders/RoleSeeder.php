<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('role')->insertOrIgnore([
            [
                'id'          => (string) Str::uuid(),
                'code'        => 'OWN',
                'name'        => 'Owner',
                'permissions' => null,
                'created_at'  => now(),
            ],
            [
                'id'          => (string) Str::uuid(),
                'code'        => 'ADM',
                'name'        => 'Admin',
                'permissions' => null,
                'created_at'  => now(),
            ],
            [
                'id'          => (string) Str::uuid(),
                'code'        => 'DCT',
                'name'        => 'Doctor',
                'permissions' => null,
                'created_at'  => now(),
            ],
            [
                'id'          => (string) Str::uuid(),
                'code'        => 'PAT',
                'name'        => 'Patient',
                'permissions' => null,
                'created_at'  => now(),
            ],
        ]);
    }
}