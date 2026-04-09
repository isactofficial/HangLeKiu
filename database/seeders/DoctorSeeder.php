<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DoctorSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        DB::transaction(function () use ($now) {
            // Doctor: drg. Budi Santoso (Fixed UUID)
        DB::table('doctor')->insertOrIgnore([
            'id'               => '550e8400-e29b-41d4-a716-446655440001',
            'full_name'        => 'drg. Budi Santoso',
            'license_no'       => 'LIC-001',
            'user_id'          => null,
            'email'            => 'budi.santoso@hlds.com',
            'phone_number'     => '081234567801',
            'title_prefix'     => 'drg.',
            'str_institution'  => 'PDGI',
            'str_number'       => 'STR-001',
            'str_expiry_date'  => '2027-12-31',
            'sip_institution'  => 'Dinkes Surabaya',
            'sip_number'       => 'SIP-001',
            'sip_expiry_date'  => '2027-12-31',
            'specialization'   => 'Gigi Umum',
            'subspecialization'=> null,
            'job_title'        => 'Dokter Gigi',
            'is_active'        => 1,
            'created_at'       => $now,
            'updated_at'       => $now,
        ]);

        // Doctor: drg. Siti Rahayu, Sp.Ort (Fixed UUID)
        DB::table('doctor')->insertOrIgnore([
            'id'               => '550e8400-e29b-41d4-a716-446655440002',
            'full_name'        => 'drg. Siti Rahayu, Sp.Ort',
            'license_no'       => 'LIC-002',
            'user_id'          => null,
            'email'            => 'siti.rahayu@hlds.com',
            'phone_number'     => '081234567802',
            'title_prefix'     => 'drg.',
            'str_institution'  => 'PDGI',
            'str_number'       => 'STR-002',
            'str_expiry_date'  => '2027-12-31',
            'sip_institution'  => 'Dinkes Surabaya',
            'sip_number'       => 'SIP-002',
            'sip_expiry_date'  => '2027-12-31',
            'specialization'   => 'Orthodonti',
            'subspecialization'=> null,
            'job_title'        => 'Dokter Gigi Spesialis Orthodonti',
            'is_active'        => 1,
            'created_at'       => $now,
            'updated_at'       => $now,
        ]);

        // Doctor: drg. Ahmad Fauzi, Sp.BM (Fixed UUID)
        DB::table('doctor')->insertOrIgnore([
            'id'               => '550e8400-e29b-41d4-a716-446655440003',
            'full_name'        => 'drg. Ahmad Fauzi, Sp.BM',
            'license_no'       => 'LIC-003',
            'user_id'          => null,
            'email'            => 'ahmad.fauzi@hlds.com',
            'phone_number'     => '081234567803',
            'title_prefix'     => 'drg.',
            'str_institution'  => 'PDGI',
            'str_number'       => 'STR-003',
            'str_expiry_date'  => '2027-12-31',
            'sip_institution'  => 'Dinkes Surabaya',
            'sip_number'       => 'SIP-003',
            'sip_expiry_date'  => '2027-12-31',
            'specialization'   => 'Bedah Mulut',
            'subspecialization'=> null,
            'job_title'        => 'Dokter Gigi Spesialis Bedah Mulut',
            'is_active'        => 1,
            'created_at'       => $now,
            'updated_at'       => $now,
        ]);

        // Get consistent FIXED doctor IDs
        $doctorBudiId = DB::table('doctor')->where('full_name', 'drg. Budi Santoso')->first()?->id;
        $doctorSitiId = DB::table('doctor')->where('full_name', 'drg. Siti Rahayu, Sp.Ort')->first()?->id;
        $doctorAhmadId = DB::table('doctor')->where('full_name', 'drg. Ahmad Fauzi, Sp.BM')->first()?->id;

        if (!$doctorBudiId || !$doctorSitiId || !$doctorAhmadId) {
            $this->command->error('❌ Doctor data not found! Skipping schedules.');
            return;
        }

        // Doctor Schedules - idempotent upsert using pre-fetched safe IDs
        // drg. Budi — Senin, Rabu, Jumat (08:00-12:00)
        foreach (['monday', 'wednesday', 'friday'] as $day) {
            DB::table('doctor_schedule')->updateOrInsert(
                ['doctor_id' => $doctorBudiId, 'day' => $day, 'start_time' => '08:00:00'],
                [
                    'id'        => Str::uuid(),
                    'end_time'  => '12:00:00',
                    'is_active' => 1,
                ]
            );
        }

        // drg. Siti — Selasa, Kamis, Sabtu (09:00-13:00)
        foreach (['tuesday', 'thursday', 'saturday'] as $day) {
            DB::table('doctor_schedule')->updateOrInsert(
                ['doctor_id' => $doctorSitiId, 'day' => $day, 'start_time' => '09:00:00'],
                [
                    'id'        => Str::uuid(),
                    'end_time'  => '13:00:00',
                    'is_active' => 1,
                ]
            );
        }

        // drg. Ahmad — Senin s/d Jumat (13:00-17:00)
        foreach (['monday', 'tuesday', 'wednesday', 'thursday', 'friday'] as $day) {
            DB::table('doctor_schedule')->updateOrInsert(
                ['doctor_id' => $doctorAhmadId, 'day' => $day, 'start_time' => '13:00:00'],
                [
                    'id'        => Str::uuid(),
                    'end_time'  => '17:00:00',
                    'is_active' => 1,
                ]
            );
        }
        }); // Close transaction

        $this->command->info('✅ Data dokter & jadwal berhasil diisi!');
    }
}
