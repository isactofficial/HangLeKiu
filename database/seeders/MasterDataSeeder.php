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
            ['id' => Str::uuid(), 'code' => 'VT001', 'name' => 'Kunjungan Baru', 'description' => 'Pasien baru yang pertama kali mengunjungi', 'is_active' => 1, 'created_at' => $now],
            ['id' => Str::uuid(), 'code' => 'VT002', 'name' => 'Kontrol', 'description' => 'Follow-up perawatan sebelumnya', 'is_active' => 1, 'created_at' => $now],
            ['id' => Str::uuid(), 'code' => 'VT003', 'name' => 'Darurat', 'description' => 'Kasus yang membutuhkan penanganan segera', 'is_active' => 1, 'created_at' => $now],
            ['id' => Str::uuid(), 'code' => 'VT004', 'name' => 'Konsultasi', 'description' => 'Konsultasi tanpa tindakan medis', 'is_active' => 1, 'created_at' => $now],
        ]);

        // Master Care Type
        DB::table('master_care_type')->insert([
            ['id' => Str::uuid(), 'code' => 'CT001', 'name' => 'Tambal Gigi', 'price' => 300000, 'description' => 'Perawatan tambal gigi dengan resin', 'is_active' => 1, 'created_at' => $now],
            ['id' => Str::uuid(), 'code' => 'CT002', 'name' => 'Scaling', 'price' => 500000, 'description' => 'Pembersihan karang gigi profesional', 'is_active' => 1, 'created_at' => $now],
            ['id' => Str::uuid(), 'code' => 'CT003', 'name' => 'Cabut Gigi', 'price' => 400000, 'description' => 'Ekstraksi gigi dengan teknik modern', 'is_active' => 1, 'created_at' => $now],
            ['id' => Str::uuid(), 'code' => 'CT004', 'name' => 'Bleaching', 'price' => 1000000, 'description' => 'Pemutihan gigi profesional', 'is_active' => 1, 'created_at' => $now],
        ]);

        // Get care type IDs for procedures
        $tambalId = DB::table('master_care_type')->where('name', 'Tambal Gigi')->value('id');
        $scalingId = DB::table('master_care_type')->where('name', 'Scaling')->value('id');
        $cabutId = DB::table('master_care_type')->where('name', 'Cabut Gigi')->value('id');

        // Master Procedure
        if ($tambalId && $scalingId && $cabutId) {
            DB::table('master_procedure')->insert([
                ['id' => Str::uuid(), 'code' => 'PR001', 'name' => 'Tambal Resin', 'care_type_id' => $tambalId, 'price' => 300000, 'description' => 'Penambalan dengan resin komposit', 'procedure_name' => 'Tambal Resin', 'base_price' => 300000, 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
                ['id' => Str::uuid(), 'code' => 'PR002', 'name' => 'Rontgen', 'care_type_id' => $tambalId, 'price' => 150000, 'description' => 'Pemeriksaan rontgen gigi', 'procedure_name' => 'Rontgen', 'base_price' => 150000, 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
                ['id' => Str::uuid(), 'code' => 'PR003', 'name' => 'Pembersihan Karang', 'care_type_id' => $scalingId, 'price' => 500000, 'description' => 'Pembersihan karang gigi dengan ultrasonic', 'procedure_name' => 'Pembersihan Karang', 'base_price' => 500000, 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
                ['id' => Str::uuid(), 'code' => 'PR004', 'name' => 'Anestesi', 'care_type_id' => $cabutId, 'price' => 100000, 'description' => 'Injeksi anestesi lokal', 'procedure_name' => 'Anestesi', 'base_price' => 100000, 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ]);
        }

        $this->command->info('✅ Master data berhasil diisi!');
    }
}