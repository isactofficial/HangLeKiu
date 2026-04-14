<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use App\Models\Doctor;
use App\Models\MasterGuarantorType;
use App\Models\MasterPaymentMethod;
use App\Models\MasterVisitType;
use App\Models\MasterCareType;
use App\Models\MasterPoli;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DoctorPageTest extends TestCase
{
    use RefreshDatabase;

    protected $doctorUser;

    protected function setUp(): void
    {
        parent::setUp();

        // 1. Create DCT role
        $roleDoctor = Role::create([
            'id' => 'role-doctor-uuid',
            'code' => 'DCT',
            'name' => 'Doctor'
        ]);

        // 2. Create Doctor User
        $this->doctorUser = User::create([
            'id' => 'doctor-user-uuid',
            'role_id' => $roleDoctor->id,
            'name' => 'dr. John Smith',
            'email' => 'john@hanglekiu.com',
            'password' => bcrypt('password'),
            'is_active' => true,
            'is_verified' => true
        ]);

        // 3. Create Doctor Record linked to user
        Doctor::create([
            'id' => 'DOC-001',
            'user_id' => $this->doctorUser->id,
            'full_name' => 'dr. John Smith',
            'is_active' => true,
            'email' => 'john@hanglekiu.com',
            'default_fee_percentage' => 20.00
        ]);

        // 4. Seed Master Data (Dashboard needs them)
        MasterPoli::create(['id' => 'P001', 'name' => 'Poli Gigi', 'is_active' => true]);
        MasterGuarantorType::create(['id' => 'G001', 'name' => 'Umum', 'is_active' => true]);
        MasterPaymentMethod::create(['id' => 'PM001', 'name' => 'Cash', 'is_active' => true]);
        MasterVisitType::create(['id' => 'VT001', 'name' => 'Konsultasi', 'is_active' => true]);
        MasterCareType::create(['id' => 'CT001', 'name' => 'Rawat Jalan', 'is_active' => true]);

        // 5. Authenticate
        $this->actingAs($this->doctorUser);
    }

    public function test_doctor_dashboard_is_accessible()
    {
        $response = $this->get(route('doctor.dashboard'));
        $response->assertStatus(200);
    }

    public function test_doctor_emr_is_accessible()
    {
        $response = $this->get(route('doctor.emr'));
        $response->assertStatus(200);
    }
}
