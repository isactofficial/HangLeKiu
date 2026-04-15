<?php

namespace Tests\Feature;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\DoctorNote;
use App\Models\MasterCareType;
use App\Models\MasterGuarantorType;
use App\Models\MasterPaymentMethod;
use App\Models\MasterPoli;
use App\Models\MasterVisitType;
use App\Models\Patient;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class DoctorInputTest extends TestCase
{
    use RefreshDatabase;

    protected $doctorUser;
    protected $doctor;

    protected function setUp(): void
    {
        parent::setUp();

        // 1. Create DCT role
        $roleDoctor = Role::firstOrCreate(['code' => 'DCT'], [
            'id' => (string) Str::uuid(),
            'name' => 'Doctor'
        ]);

        // 2. Create Doctor User
        $this->doctorUser = User::create([
            'id' => (string) Str::uuid(),
            'role_id' => $roleDoctor->id,
            'name' => 'dr. John Doe',
            'email' => 'johndoe@test.com',
            'password' => bcrypt('password123'),
            'is_active' => true,
            'is_verified' => true
        ]);

        // 3. Create Doctor Record linked to user
        $this->doctor = Doctor::create([
            'id' => (string) Str::uuid(),
            'user_id' => $this->doctorUser->id,
            'full_name' => 'dr. John Doe',
            'is_active' => true,
            'email' => 'johndoe@test.com',
            'default_fee_percentage' => 20.00
        ]);

        // 4. Seed Master Data
        MasterPoli::create(['id' => 'POLI-01', 'name' => 'Poli Gigi', 'is_active' => true]);
        MasterGuarantorType::create(['id' => 'G-01', 'name' => 'Umum', 'is_active' => true]);
        MasterPaymentMethod::create(['id' => 'PM-01', 'name' => 'Cash', 'is_active' => true]);
        MasterVisitType::create(['id' => 'VT-01', 'name' => 'Konsultasi', 'is_active' => true]);
        MasterCareType::create(['id' => 'CT-01', 'name' => 'Rawat Jalan', 'is_active' => true]);

        $this->actingAs($this->doctorUser);
    }

    public function test_doctor_can_update_profile()
    {
        $data = [
            'name'         => 'dr. John Smith Updated',
            'email'        => 'johnupdated@test.com',
            'phone_number' => '081234567890',
            'sip_number'   => 'SIP-123456',
            'license_no'   => 'LIC-7890',
        ];

        $response = $this->put(route('doctor.profile.update'), $data);

        $response->assertRedirect();
        $this->assertDatabaseHas('user', [
            'id'    => $this->doctorUser->id,
            'name'  => 'dr. John Smith Updated',
            'email' => 'johnupdated@test.com'
        ]);

        $this->assertDatabaseHas('doctor', [
            'id'         => $this->doctor->id,
            'full_name'  => 'dr. John Smith Updated',
            'sip_number' => 'SIP-123456'
        ]);
    }

    public function test_doctor_can_store_emr_note()
    {
        // 1. Setup Patient and Appointment
        $patient = Patient::create([
            'id' => (string) Str::uuid(),
            'medical_record_no' => 'MRN-001',
            'full_name' => 'Patient One',
            'date_of_birth' => '1990-01-01',
            'gender' => 'Male'
        ]);

        $appointment = Appointment::create([
            'id' => (string) Str::uuid(),
            'patient_id' => $patient->id,
            'doctor_id' => $this->doctor->id,
            'status' => 'engaged',
            'appointment_datetime' => now()
        ]);

        $data = [
            'subjective' => 'Pasien mengeluh sakit gigi.',
            'objective'  => 'Karies pada gigi 46.',
            'plan'       => 'Pencabutan gigi.'
        ];

        $response = $this->post(route('doctor.emr.storeDoctorNote', $appointment->id), $data);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $this->assertDatabaseHas('doctor_note', [
            'user_id' => $this->doctorUser->id,
            'notes' => "Subjective:\nPasien mengeluh sakit gigi.\n\nObjective:\nKaries pada gigi 46.\n\nPlan:\nPencabutan gigi."
        ]);
    }

    public function test_doctor_can_update_appointment_status()
    {
        $patient = Patient::create([
            'id' => (string) Str::uuid(),
            'medical_record_no' => 'MRN-002',
            'full_name' => 'Patient Two',
            'date_of_birth' => '1990-01-01',
            'gender' => 'Female'
        ]);

        $appointment = Appointment::create([
            'id' => (string) Str::uuid(),
            'patient_id' => $patient->id,
            'doctor_id' => $this->doctor->id,
            'status' => 'engaged',
            'appointment_datetime' => now()
        ]);

        $response = $this->patch(route('doctor.emr.updateStatus', $appointment->id), [
            'status' => 'succeed'
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('registration', [
            'id' => $appointment->id,
            'status' => 'succeed'
        ]);
    }
}
