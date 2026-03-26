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

        $doctors = [
            [
                'id'               => Str::uuid(),
                'user_id'          => null,
                'full_name'        => 'drg. Budi Santoso',
                'email'            => 'budi.santoso@hlds.com',
                'phone_number'     => '081234567801',
                'title_prefix'     => 'drg.',
                'license_no'       => 'LIC-001',
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
            ],
            [
                'id'               => Str::uuid(),
                'user_id'          => null,
                'full_name'        => 'drg. Siti Rahayu, Sp.Ort',
                'email'            => 'siti.rahayu@hlds.com',
                'phone_number'     => '081234567802',
                'title_prefix'     => 'drg.',
                'license_no'       => 'LIC-002',
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
            ],
            [
                'id'               => Str::uuid(),
                'user_id'          => null,
                'full_name'        => 'drg. Ahmad Fauzi, Sp.BM',
                'email'            => 'ahmad.fauzi@hlds.com',
                'phone_number'     => '081234567803',
                'title_prefix'     => 'drg.',
                'license_no'       => 'LIC-003',
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
            ],
        ];

        DB::table('doctor')->insert($doctors);

        // Ambil ID dokter yang baru diinsert
        $doctorIds = DB::table('doctor')->pluck('id', 'full_name');

        $schedules = [];

        // drg. Budi — Senin, Rabu, Jumat
        foreach (['monday', 'wednesday', 'friday'] as $day) {
            $schedules[] = [
                'id'        => Str::uuid(),
                'doctor_id' => $doctorIds['drg. Budi Santoso'],
                'day'       => $day,
                'start_time'=> '08:00:00',
                'end_time'  => '12:00:00',
                'is_active' => 1,
            ];
        }

        // drg. Siti — Selasa, Kamis, Sabtu
        foreach (['tuesday', 'thursday', 'saturday'] as $day) {
            $schedules[] = [
                'id'        => Str::uuid(),
                'doctor_id' => $doctorIds['drg. Siti Rahayu, Sp.Ort'],
                'day'       => $day,
                'start_time'=> '09:00:00',
                'end_time'  => '13:00:00',
                'is_active' => 1,
            ];
        }

        // drg. Ahmad — Senin s/d Jumat
        foreach (['monday', 'tuesday', 'wednesday', 'thursday', 'friday'] as $day) {
            $schedules[] = [
                'id'        => Str::uuid(),
                'doctor_id' => $doctorIds['drg. Ahmad Fauzi, Sp.BM'],
                'day'       => $day,
                'start_time'=> '13:00:00',
                'end_time'  => '17:00:00',
                'is_active' => 1,
            ];
        }

        DB::table('doctor_schedule')->insert($schedules);

        $this->command->info('✅ Data dokter & jadwal berhasil diisi!');
    }
}