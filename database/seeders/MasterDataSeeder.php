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
        DB::table('master_poli')->updateOrInsert(['name' => 'Poli Gigi Umum'],     ['id' => Str::uuid(), 'is_active' => 1, 'created_at' => $now]);
        DB::table('master_poli')->updateOrInsert(['name' => 'Poli Orthodonti'],     ['id' => Str::uuid(), 'is_active' => 1, 'created_at' => $now]);
        DB::table('master_poli')->updateOrInsert(['name' => 'Poli Bedah Mulut'],    ['id' => Str::uuid(), 'is_active' => 1, 'created_at' => $now]);
        DB::table('master_poli')->updateOrInsert(['name' => 'Poli Anak'],           ['id' => Str::uuid(), 'is_active' => 1, 'created_at' => $now]);
        DB::table('master_poli')->updateOrInsert(['name' => 'Poli Periodonti'],     ['id' => Str::uuid(), 'is_active' => 1, 'created_at' => $now]);

        // Master Guarantor Type
        DB::table('master_guarantor_type')->updateOrInsert(['name' => 'Umum'],                ['id' => Str::uuid(), 'is_active' => 1, 'created_at' => $now]);
        DB::table('master_guarantor_type')->updateOrInsert(['name' => 'BPJS'],                ['id' => Str::uuid(), 'is_active' => 1, 'created_at' => $now]);
        DB::table('master_guarantor_type')->updateOrInsert(['name' => 'Asuransi Swasta'],     ['id' => Str::uuid(), 'is_active' => 1, 'created_at' => $now]);
        DB::table('master_guarantor_type')->updateOrInsert(['name' => 'Perusahaan'],          ['id' => Str::uuid(), 'is_active' => 1, 'created_at' => $now]);

        // Master Payment Method
        DB::table('master_payment_method')->updateOrInsert(['name' => 'Tunai'],               ['id' => Str::uuid(), 'is_active' => 1, 'created_at' => $now]);
        DB::table('master_payment_method')->updateOrInsert(['name' => 'Transfer Bank'],       ['id' => Str::uuid(), 'is_active' => 1, 'created_at' => $now]);
        DB::table('master_payment_method')->updateOrInsert(['name' => 'QRIS'],                ['id' => Str::uuid(), 'is_active' => 1, 'created_at' => $now]);
        DB::table('master_payment_method')->updateOrInsert(['name' => 'Kartu Debit'],         ['id' => Str::uuid(), 'is_active' => 1, 'created_at' => $now]);
        DB::table('master_payment_method')->updateOrInsert(['name' => 'Kartu Kredit'],        ['id' => Str::uuid(), 'is_active' => 1, 'created_at' => $now]);

        // Master Visit Type
        DB::table('master_visit_type')->updateOrInsert(['code' => 'VT001'], ['id' => Str::uuid(), 'name' => 'Kunjungan Baru', 'description' => 'Pasien baru yang pertama kali mengunjungi', 'is_active' => 1, 'created_at' => $now]);
        DB::table('master_visit_type')->updateOrInsert(['code' => 'VT002'], ['id' => Str::uuid(), 'name' => 'Kontrol', 'description' => 'Follow-up perawatan sebelumnya', 'is_active' => 1, 'created_at' => $now]);
        DB::table('master_visit_type')->updateOrInsert(['code' => 'VT003'], ['id' => Str::uuid(), 'name' => 'Darurat', 'description' => 'Kasus yang membutuhkan penanganan segera', 'is_active' => 1, 'created_at' => $now]);
        DB::table('master_visit_type')->updateOrInsert(['code' => 'VT004'], ['id' => Str::uuid(), 'name' => 'Konsultasi', 'description' => 'Konsultasi tanpa tindakan medis', 'is_active' => 1, 'created_at' => $now]);

        // Master Care Type
        DB::table('master_care_type')->updateOrInsert(['code' => 'CT001'], ['id' => Str::uuid(), 'name' => 'Tambal Gigi', 'price' => 300000, 'description' => 'Perawatan tambal gigi dengan resin', 'is_active' => 1, 'created_at' => $now]);
        DB::table('master_care_type')->updateOrInsert(['code' => 'CT002'], ['id' => Str::uuid(), 'name' => 'Scaling', 'price' => 500000, 'description' => 'Pembersihan karang gigi profesional', 'is_active' => 1, 'created_at' => $now]);
        DB::table('master_care_type')->updateOrInsert(['code' => 'CT003'], ['id' => Str::uuid(), 'name' => 'Cabut Gigi', 'price' => 400000, 'description' => 'Ekstraksi gigi dengan teknik modern', 'is_active' => 1, 'created_at' => $now]);
        DB::table('master_care_type')->updateOrInsert(['code' => 'CT004'], ['id' => Str::uuid(), 'name' => 'Bleaching', 'price' => 1000000, 'description' => 'Pemutihan gigi profesional', 'is_active' => 1, 'created_at' => $now]);

        // Get care type IDs for procedures
        $tambalId = DB::table('master_care_type')->where('name', 'Tambal Gigi')->value('id');
        $scalingId = DB::table('master_care_type')->where('name', 'Scaling')->value('id');
        $cabutId = DB::table('master_care_type')->where('name', 'Cabut Gigi')->value('id');

        // Master Procedure
        if ($tambalId && $scalingId && $cabutId) {
            DB::table('master_procedure')->updateOrInsert(['code' => 'PR001'], ['id' => Str::uuid(), 'name' => 'Tambal Resin', 'care_type_id' => $tambalId, 'price' => 300000, 'description' => 'Penambalan dengan resin komposit', 'procedure_name' => 'Tambal Resin', 'base_price' => 300000, 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now]);
            DB::table('master_procedure')->updateOrInsert(['code' => 'PR002'], ['id' => Str::uuid(), 'name' => 'Rontgen', 'care_type_id' => $tambalId, 'price' => 150000, 'description' => 'Pemeriksaan rontgen gigi', 'procedure_name' => 'Rontgen', 'base_price' => 150000, 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now]);
            DB::table('master_procedure')->updateOrInsert(['code' => 'PR003'], ['id' => Str::uuid(), 'name' => 'Pembersihan Karang', 'care_type_id' => $scalingId, 'price' => 500000, 'description' => 'Pembersihan karang gigi dengan ultrasonic', 'procedure_name' => 'Pembersihan Karang', 'base_price' => 500000, 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now]);
            DB::table('master_procedure')->updateOrInsert(['code' => 'PR004'], ['id' => Str::uuid(), 'name' => 'Anestesi', 'care_type_id' => $cabutId, 'price' => 100000, 'description' => 'Injeksi anestesi lokal', 'procedure_name' => 'Anestesi', 'base_price' => 100000, 'is_active' => 1, 'created_at' => $now, 'updated_at' => $now]);
        }

        $this->command->info('✅ Master data berhasil diisi!');
    }
}