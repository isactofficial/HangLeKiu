<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Treatment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PatientPageTest extends TestCase
{
    use RefreshDatabase;

    protected $patientUser;

    protected function setUp(): void
    {
        parent::setUp();

        // 1. Create PAT role
        $rolePatient = Role::create([
            'id' => 'role-patient-uuid',
            'code' => 'PAT',
            'name' => 'Patient'
        ]);

        // 2. Create Patient User
        $this->patientUser = User::create([
            'id' => 'patient-user-uuid',
            'role_id' => $rolePatient->id,
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'password' => bcrypt('password'),
            'is_active' => true,
            'is_verified' => true
        ]);

        // 3. Create Patient Record linked to user
        Patient::create([
            'id' => 'PAT-0016812d1e4',
            'user_id' => $this->patientUser->id,
            'full_name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'medical_record_no' => 'MR000001',
            'date_of_birth' => '1995-01-01',
            'gender' => 'Female'
        ]);

        // 4. Seed basic data (Dashboard needs them)
        Doctor::create([
            'id' => 'D001',
            'full_name' => 'drg. Budi',
            'is_active' => true,
            'email' => 'budi@example.com'
        ]);

        Treatment::create([
            'id' => 'T001',
            'procedure_name' => 'Scalling',
            'is_active' => true,
            'category' => 'Gigi'
        ]);

        // 5. Authenticate
        $this->actingAs($this->patientUser);
    }

    public function test_patient_dashboard_is_accessible()
    {
        $response = $this->get(route('user.dashboard'));
        $response->assertStatus(200);
    }

    public function test_patient_medical_history_is_accessible()
    {
        $response = $this->get(route('user.medical-history'));
        $response->assertStatus(200);
    }

    public function test_patient_odontogram_history_is_accessible()
    {
        $response = $this->get(route('user.odontogram-history'));
        $response->assertStatus(200);
    }
}
