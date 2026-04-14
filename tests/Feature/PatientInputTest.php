<?php

namespace Tests\Feature;

use App\Models\Patient;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class PatientInputTest extends TestCase
{
    use RefreshDatabase;

    protected $patientUser;
    protected $patient;

    protected function setUp(): void
    {
        parent::setUp();

        // 1. Create PAT role
        $rolePatient = Role::firstOrCreate(['code' => 'PAT'], [
            'id' => (string) Str::uuid(),
            'name' => 'Patient'
        ]);

        // 2. Create Patient User
        $this->patientUser = User::create([
            'id' => (string) Str::uuid(),
            'role_id' => $rolePatient->id,
            'name' => 'Jane Smith',
            'email' => 'janesmith@test.com',
            'password' => bcrypt('password123'),
            'is_active' => true,
            'is_verified' => true
        ]);

        // 3. Create Patient Record linked to user
        $this->patient = Patient::create([
            'id'                => (string) Str::uuid(),
            'user_id'           => $this->patientUser->id,
            'full_name'         => 'Jane Smith',
            'medical_record_no' => 'MRN-P001',
            'date_of_birth'     => '1995-05-15',
            'gender'            => 'Female',
            'email'             => 'janesmith@test.com',
        ]);

        $this->actingAs($this->patientUser);
    }

    public function test_patient_can_update_profile()
    {
        $data = [
            'full_name'       => 'Jane Doe Updated',
            'email'           => 'janeupdated@test.com',
            'phone_number'    => '081299887766',
            'date_of_birth'   => '1995-05-20',
            'gender'          => 'Female',
            'blood_type'      => 'B',
            'rhesus'          => '+',
            'address'         => 'Jl. Testing No. 123',
            'city'            => 'Jakarta Selatan',
            'id_card_number'  => '3171012345678901',
            'allergy_history' => 'Antibiotik Penicillin',
            'religion'        => 'Islam',
            'education'       => 'Sarjana',
            'occupation'      => 'Swasta',
            'marital_status'  => 'Menikah',
        ];

        $response = $this->put(route('user.profile.update'), $data);

        $response->assertRedirect();
        
        // Assert User table
        $this->assertDatabaseHas('user', [
            'id'    => $this->patientUser->id,
            'name'  => 'Jane Doe Updated',
            'email' => 'janeupdated@test.com'
        ]);

        // Assert Patient table
        $this->assertDatabaseHas('patient', [
            'id'             => $this->patient->id,
            'full_name'      => 'Jane Doe Updated',
            'phone_number'   => '081299887766',
            'blood_type'     => 'B',
            'address'        => 'Jl. Testing No. 123',
            'id_card_number' => '3171012345678901'
        ]);
    }

    public function test_patient_can_change_password_while_updating_profile()
    {
        $data = [
            'full_name'             => 'Jane Smith',
            'email'                 => 'janesmith@test.com',
            'date_of_birth'         => '1995-05-15',
            'gender'                => 'Female',
            'password'              => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ];

        $response = $this->put(route('user.profile.update'), $data);

        $response->assertRedirect();
        
        $this->assertTrue(\Hash::check('newpassword123', $this->patientUser->fresh()->password));
    }
}
