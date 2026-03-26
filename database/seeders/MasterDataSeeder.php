<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class MasterDataSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // Master Poli
        DB::table('master_poli')->insert([
            ['id' => Str::uuid(), 'name' => 'Poli Gigi Umum',     'is_active' => 1, 'created_at' => $now],
            ['id' => Str::uuid(), 'name' => 'Poli Orthodonti',     'is_active' => 1, 'created_at' => $now],
            ['id' => Str::uuid(), 'name' => 'Poli Bedah Mulut',    'is_active' => 1, 'created_at' => $now],
            ['id' => Str::uuid(), 'name' => 'Poli Anak',           'is_active' => 1, 'created_at' => $now],
            ['id' => Str::uuid(), 'name' => 'Poli Periodonti',     'is_active' => 1, 'created_at' => $now],
        ]);

        // Master Guarantor Type
        DB::table('master_guarantor_type')->insert([
            ['id' => Str::uuid(), 'name' => 'Umum',                'is_active' => 1, 'created_at' => $now],
            ['id' => Str::uuid(), 'name' => 'BPJS',                'is_active' => 1, 'created_at' => $now],
            ['id' => Str::uuid(), 'name' => 'Asuransi Swasta',     'is_active' => 1, 'created_at' => $now],
            ['id' => Str::uuid(), 'name' => 'Perusahaan',          'is_active' => 1, 'created_at' => $now],
        ]);

        // Master Payment Method
        DB::table('master_payment_method')->insert([
            ['id' => Str::uuid(), 'name' => 'Tunai',               'is_active' => 1, 'created_at' => $now],
            ['id' => Str::uuid(), 'name' => 'Transfer Bank',       'is_active' => 1, 'created_at' => $now],
            ['id' => Str::uuid(), 'name' => 'QRIS',                'is_active' => 1, 'created_at' => $now],
            ['id' => Str::uuid(), 'name' => 'Kartu Debit',         'is_active' => 1, 'created_at' => $now],
            ['id' => Str::uuid(), 'name' => 'Kartu Kredit',        'is_active' => 1, 'created_at' => $now],
        ]);

        // Master Visit Type
        DB::table('master_visit_type')->insert([
            ['id' => Str::uuid(), 'name' => 'Kunjungan Baru',      'is_active' => 1, 'created_at' => $now],
            ['id' => Str::uuid(), 'name' => 'Kunjungan Lama',      'is_active' => 1, 'created_at' => $now],
            ['id' => Str::uuid(), 'name' => 'Kontrol',             'is_active' => 1, 'created_at' => $now],
            ['id' => Str::uuid(), 'name' => 'Emergency',           'is_active' => 1, 'created_at' => $now],
        ]);

        // Master Care Type
        DB::table('master_care_type')->insert([
            ['id' => Str::uuid(), 'name' => 'Rawat Jalan',         'is_active' => 1, 'created_at' => $now],
            ['id' => Str::uuid(), 'name' => 'Rawat Inap',          'is_active' => 1, 'created_at' => $now],
            ['id' => Str::uuid(), 'name' => 'Tindakan',            'is_active' => 1, 'created_at' => $now],
            ['id' => Str::uuid(), 'name' => 'Konsultasi',          'is_active' => 1, 'created_at' => $now],
        ]);

        $this->command->info('✅ Master data berhasil diisi!');
    }
}