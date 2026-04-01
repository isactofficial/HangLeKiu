<?php

namespace Database\Seeders;

use App\Models\Patient;
use App\Models\Appointment;
use App\Models\MasterPoli;
use App\Models\MasterGuarantorType;
use App\Models\MasterVisitType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Faker\Factory as Faker;

class PatientDummySeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        
        $bloodTypes = ['A', 'B', 'AB', 'O'];
        $religions = ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Budha', 'Konghucu'];
        $educations = ['SD', 'SMP', 'SMA', 'D3', 'S1', 'S2', 'S3'];
        $occupations = ['PNS', 'Swasta', 'Wiraswasta', 'Mahasiswa', 'Ibu Rumah Tangga', 'Guru'];
        $maritalStatuses = ['Lajang', 'Menikah', 'Cerai'];

        $polis = MasterPoli::all();
        $guarantors = MasterGuarantorType::all();
        $visitTypes = MasterVisitType::all();

        if ($polis->isEmpty() || $guarantors->isEmpty() || $visitTypes->isEmpty()) {
            $this->command->info('⚠️ Master data masih kosong. Jalankan MasterDataSeeder terlebih dahulu!');
            return;
        }

        $this->command->info('Sedang membuat 50 data pasien dummy...');

        for ($i = 0; $i < 50; $i++) {
            $firstName = $faker->firstName;
            $lastName = $faker->lastName;
            $fullName = $firstName . ' ' . $lastName;
            
            // Random DOB (18 - 60 years old)
            $dob = Carbon::now()->subYears(rand(18, 60))->subDays(rand(0, 365));

            $patient = Patient::create([
                'id' => (string) Str::uuid(),
                'full_name' => $fullName,
                'email' => strtolower($firstName . '.' . $lastName . '@example.com'),
                'medical_record_no' => 'MR-' . $faker->unique()->numberBetween(10000, 99999),
                'date_of_birth' => $dob,
                'gender' => $faker->randomElement(['Male', 'Female']),
                'blood_type' => $faker->randomElement($bloodTypes),
                'rhesus' => '+',
                'address' => substr($faker->address, 0, 50),
                'phone_number' => $faker->phoneNumber,
                'city' => $faker->city,
                'id_card_number' => $faker->nik(),
                'religion' => $faker->randomElement($religions),
                'education' => $faker->randomElement($educations),
                'occupation' => $faker->randomElement($occupations),
                'marital_status' => $faker->randomElement($maritalStatuses),
                'created_at' => Carbon::now()->subDays(rand(0, 60)), // Ada yang baru (bulan ini), ada yang lama
            ]);

            // Buat 1-2 appointment untuk setiap pasien
            $numAppointments = rand(1, 2);
            for ($j = 0; $j < $numAppointments; $j++) {
                // Ada yang hari ini (walk-in), ada yang masa lalu
                $date = rand(0, 5) === 0 ? Carbon::now() : Carbon::now()->subDays(rand(1, 10));
                
                Appointment::create([
                    'id' => (string) Str::uuid(),
                    'patient_id' => $patient->id,
                    'poli_id' => $polis->random()->id,
                    'guarantor_type_id' => $guarantors->random()->id,
                    'visit_type_id' => $visitTypes->random()->id,
                    'registration_date' => $date->toDateString(),
                    'appointment_datetime' => $date->setTime(rand(8, 16), 0),
                    'status' => 'succeed',
                    'complaint' => 'Pemeriksaan rutin gigi.',
                ]);
            }
        }

        $this->command->info('✅ Berhasil membuat 50 data pasien dummy!');
    }
}
