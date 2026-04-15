<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\DoctorSchedule;
use App\Models\MasterPoli;
use App\Models\MasterGuarantorType;
use App\Models\MasterPaymentMethod;
use App\Models\MasterVisitType;
use App\Models\MasterCareType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class PublicInputTest extends TestCase
{
    use RefreshDatabase;

    protected $doctor;
    protected $poli;
    protected $guarantor;
    protected $payment;
    protected $visit;
    protected $care;

    protected function setUp(): void
    {
        parent::setUp();

        // 1. Seed Roles
        Role::create(['id' => (string) Str::uuid(), 'code' => 'PAT', 'name' => 'Patient']);
        $roleAdmin  = Role::create(['id' => (string) Str::uuid(), 'code' => 'ADM', 'name' => 'Admin']);
        $roleDoctor = Role::create(['id' => (string) Str::uuid(), 'code' => 'DCT', 'name' => 'Doctor']);

        // 2. Seed Master Data
        $this->poli      = MasterPoli::create(['id' => 'P001', 'name' => 'Poli Gigi', 'is_active' => true]);
        $this->guarantor = MasterGuarantorType::create(['id' => 'G001', 'name' => 'Umum', 'is_active' => true]);
        $this->payment   = MasterPaymentMethod::create(['id' => 'PM001', 'name' => 'Cash', 'is_active' => true]);
        $this->visit     = MasterVisitType::create(['id' => 'VT001', 'name' => 'Konsultasi', 'is_active' => true]);
        $this->care      = MasterCareType::create(['id' => 'CT001', 'name' => 'Rawat Jalan', 'is_active' => true]);

        // 3. Seed Doctor and Schedule
        $doctorUser = User::create([
            'id' => (string) Str::uuid(),
            'role_id' => $roleDoctor->id,
            'name' => 'drg. Test Doctor',
            'email' => 'doctor@test.com',
            'password' => bcrypt('password'),
            'is_active' => true,
            'is_verified' => true
        ]);

        $this->doctor = Doctor::create([
            'id' => (string) Str::uuid(),
            'user_id' => $doctorUser->id,
            'full_name' => 'drg. Test Doctor',
            'is_active' => true,
            'email' => 'doctor@test.com'
        ]);

        // Schedule for Monday (Monday = monday in dayMap)
        DoctorSchedule::create([
            'id' => (string) Str::uuid(),
            'doctor_id' => $this->doctor->id,
            'day' => 'monday',
            'start_time' => '08:00:00',
            'end_time' => '17:00:00',
            'is_active' => true
        ]);

        // 4. Seed Admin
        User::create([
            'id' => (string) Str::uuid(),
            'role_id' => $roleAdmin->id,
            'name' => 'Admin Test',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'is_active' => true,
            'is_verified' => true
        ]);
    }

    // ================= APPOINTMENT REGISTRATION =================

    public function test_can_register_appointment_with_valid_data()
    {
        // Monday date
        $monday = "2026-04-13"; // Known monday

        $data = [
            'patient_name'      => 'John Doe',
            'patient_phone'     => '08123456789',
            'date_of_birth'     => '1990-01-01',
            'gender'            => 'Male',
            'patient_type'      => 'non_rujuk',
            'guarantor_type_id' => $this->guarantor->id,
            'payment_method_id' => $this->payment->id,
            'visit_type_id'     => $this->visit->id,
            'care_type_id'      => $this->care->id,
            'poli_id'           => $this->poli->id,
            'doctor_id'         => $this->doctor->id,
            'appointment_date'  => $monday,
            'appointment_time'  => '10:00',
            'complaint'         => 'Sakit gigi'
        ];

        $response = $this->post(route('appointments.store'), $data);

        $response->assertRedirect(route('appointments.success'));
        $this->assertDatabaseHas('registration', [
            'doctor_id' => $this->doctor->id,
            'status'    => 'pending'
        ]);
        $this->assertDatabaseHas('patient', [
            'full_name'    => 'John Doe',
            'phone_number' => '08123456789'
        ]);
    }

    public function test_appointment_registration_fails_missing_fields()
    {
        $response = $this->post(route('appointments.store'), []);
        $response->assertSessionHasErrors(['patient_name', 'patient_phone', 'doctor_id']);
    }

    public function test_appointment_registration_fails_out_of_schedule()
    {
        $monday = "2026-04-13"; 

        $data = [
            'patient_name'      => 'John Doe',
            'patient_phone'     => '08123456789',
            'date_of_birth'     => '1990-01-01',
            'gender'            => 'Male',
            'patient_type'      => 'non_rujuk',
            'guarantor_type_id' => $this->guarantor->id,
            'payment_method_id' => $this->payment->id,
            'visit_type_id'     => $this->visit->id,
            'care_type_id'      => $this->care->id,
            'poli_id'           => $this->poli->id,
            'doctor_id'         => $this->doctor->id,
            'appointment_date'  => $monday,
            'appointment_time'  => '22:00', // Out of 08:00 - 17:00
            'complaint'         => 'Sakit gigi'
        ];

        $response = $this->post(route('appointments.store'), $data);
        $response->assertSessionHasErrors(['appointment_time']);
    }

    // ================= USER REGISTRATION =================

    public function test_can_register_as_new_user()
    {
        $data = [
            'name'                  => 'New Patient',
            'email'                 => 'patient@test.com',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
            'date_of_birth'         => '1995-05-15',
            'gender'                => 'Female',
            'phone_number'          => '085566778899'
        ];

        $response = $this->post('/register', $data);

        $response->assertRedirect('/user/dashboard');
        $this->assertDatabaseHas('user', ['email' => 'patient@test.com']);
        $this->assertDatabaseHas('patient', ['full_name' => 'New Patient']);
    }

    public function test_user_registration_fails_duplicate_email()
    {
        // Seed first user
        $role = Role::where('code', 'PAT')->first();
        User::create([
            'id' => (string) Str::uuid(),
            'role_id' => $role->id,
            'name' => 'Existing User',
            'email' => 'existing@test.com',
            'password' => bcrypt('password'),
            'is_active' => true
        ]);

        $data = [
            'name'                  => 'New Patient',
            'email'                 => 'existing@test.com', // Duplicate
            'password'              => 'password123',
            'password_confirmation' => 'password123',
            'date_of_birth'         => '1995-05-15',
            'gender'                => 'Female',
            'phone_number'          => '085566778899'
        ];

        $response = $this->post('/register', $data);
        $response->assertSessionHasErrors(['email']);
    }

    // ================= LOGINS =================

    public function test_user_login_success()
    {
        $role = Role::where('code', 'PAT')->first();
        User::create([
            'id' => (string) Str::uuid(),
            'role_id' => $role->id,
            'name' => 'Login User',
            'email' => 'login@test.com',
            'password' => bcrypt('password'),
            'is_active' => true
        ]);

        $response = $this->post('/login', [
            'email'    => 'login@test.com',
            'password' => 'password'
        ]);

        $response->assertRedirect('/user/dashboard');
        $this->assertAuthenticated();
    }

    public function test_admin_login_success()
    {
        $response = $this->post(route('admin.login.post'), [
            'email'    => 'admin@test.com',
            'password' => 'password'
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticated();
    }

    public function test_doctor_login_success()
    {
        $response = $this->post(route('doctor.login.post'), [
            'email'    => 'doctor@test.com',
            'password' => 'password'
        ]);

        $response->assertRedirect(route('doctor.dashboard'));
        $this->assertAuthenticated();
    }

    public function test_login_fails_wrong_credentials()
    {
        $response = $this->post('/login', [
            'email'    => 'admin@test.com',
            'password' => 'wrongpassword'
        ]);

        $response->assertSessionHasErrors(['email']);
        $this->assertGuest();
    }
}
