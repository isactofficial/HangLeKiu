<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use App\Models\Patient;
use App\Models\Article;
use App\Models\Medicine;
use App\Models\Appointment;
use App\Models\MasterPoli;
use App\Models\Doctor;
use App\Models\DoctorNote;
use App\Models\ConsumableItem;
use App\Models\ConsumableRestock;
use App\Models\MasterGuarantorType;
use App\Models\InsurancePartner;
use App\Models\OdontogramRecord;
use App\Models\OdontogramTooth;
use App\Models\Invoice;
use App\Models\MasterPaymentMethod;
use App\Models\MasterVisitType;
use App\Models\MasterCareType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Tests\TestCase;

class AdminInputTest extends TestCase
{
    use RefreshDatabase;

    protected $adminUser;

    protected function setUp(): void
    {
        parent::setUp();

        // 1. Create ADM role
        $roleAdmin = Role::create([
            'id' => (string) Str::uuid(),
            'code' => 'ADM',
            'name' => 'Admin'
        ]);

        // 2. Create Admin User
        $this->adminUser = User::create([
            'id' => (string) Str::uuid(),
            'role_id' => $roleAdmin->id,
            'name' => 'Super Admin',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'is_active' => true,
            'is_verified' => true
        ]);

        // 3. Authenticate
        $this->actingAs($this->adminUser);
        
        // Ensure API calls use the session driver during tests and are authenticated
        config(['auth.guards.api.driver' => 'session']);
        $this->actingAs($this->adminUser, 'api');
    }

    // ================= PATIENT MANAGEMENT =================

    public function test_admin_can_create_patient()
    {
        $data = [
            'full_name'     => 'Admin Patient',
            'date_of_birth' => '1990-01-01',
            'gender'        => 'Male',
            'phone_number'  => '089988776655',
            'address'       => 'Jl. Admin No. 1'
        ];

        $response = $this->post(route('admin.patients.store'), $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('patient', [
            'full_name' => 'Admin Patient',
            'phone_number' => '089988776655'
        ]);
    }

    // ================= ARTICLE MANAGEMENT =================

    public function test_admin_can_create_article()
    {
        $file = UploadedFile::fake()->image('test-article.jpg');

        $data = [
            'title'       => 'Tips Gigi Sehat',
            'category'    => 'Tips and Trick',
            'description' => 'Ini adalah deskripsi pendek artikel.',
            'content'     => 'Ini adalah konten lengkap artikel edukasi gigi.',
            'image'       => $file
        ];

        $response = $this->post(route('admin.articles.store'), $data);

        $response->assertRedirect();
        $this->assertDatabaseHas('articles', [
            'title' => 'Tips Gigi Sehat'
        ]);
    }

    // ================= PHARMACY MANAGEMENT =================

    public function test_admin_can_create_medicine()
    {
        $data = [
            'medicine_code' => 'OBT-001',
            'medicine_name' => 'Paracetamol 500mg',
            'medicine_type' => 'Tablet',
            'unit'          => 'Strip',
            'purchase_price' => 5000,
            'selling_price_general' => 7500
        ];

        $response = $this->post(route('admin.pharmacy.medicine.store'), $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('medicine', [
            'medicine_name' => 'Paracetamol 500mg'
        ]);
    }

    public function test_admin_can_add_medicine_stock()
    {
        $medicine = Medicine::create([
            'id' => (string) Str::uuid(),
            'medicine_name' => 'Amoxicillin',
            'current_stock' => 10,
            'purchase_price' => 1000,
            'avg_hpp' => 1000
        ]);

        $data = [
            'qty' => 50,
            'unit_price' => 1200,
            'note' => 'Restock bulanan'
        ];

        $response = $this->post(route('admin.pharmacy.medicine.stockIn', $medicine->id), $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('medicine', [
            'id' => $medicine->fresh()->id,
            'current_stock' => 60
        ]);
        $this->assertDatabaseHas('stock_mutation', [
            'medicine_id' => $medicine->id,
            'quantity' => 50,
            'type' => 'in'
        ]);
    }

    // ================= NOTIFICATION ACTIONS =================

    public function test_admin_can_confirm_appointment()
    {
        // Setup dependensi appointment
        $poli = MasterPoli::create(['id' => 'P001', 'name' => 'Poli Umum']);
        $doctor = Doctor::create(['id' => 'D001', 'full_name' => 'drg. Test']);
        $patient = Patient::create([
            'id' => 'P-0016812d1e4',
            'full_name' => 'Patient Test',
            'medical_record_no' => 'MR001',
            'date_of_birth' => '2000-01-01',
            'gender' => 'Male'
        ]);

        $appointment = Appointment::create([
            'id' => (string) Str::uuid(),
            'patient_id' => $patient->id,
            'doctor_id' => $doctor->id,
            'poli_id' => $poli->id,
            'appointment_datetime' => now()->addDays(1),
            'status' => 'pending'
        ]);

        $response = $this->post(route('admin.notifications.confirm', $appointment->id));

        $response->assertStatus(200);
        $this->assertDatabaseHas('registration', [
            'id' => $appointment->id,
            'status' => 'confirmed',
            'admin_id' => $this->adminUser->id
        ]);
    }

    // ================= DOCTOR & STAFF MANAGEMENT =================

    public function test_admin_can_create_doctor_via_web()
    {
        $data = [
            'full_name'      => 'drg. Baru di-Web',
            'specialization' => 'Gigi Umum',
            'phone_number'   => '081234567890',
            'email'          => 'doctorweb@test.com',
            'is_active'      => 1,
            'experience'     => '5 Tahun',
            'alma_mater'     => 'Universitas Gadjah Mada',
            'bio'            => 'Dokter gigi ramah tamah.'
        ];

        $response = $this->post(route('admin.settings.staff.doctor.store'), $data);

        $response->assertStatus(302); // Redirect back to settings index
        $this->assertDatabaseHas('doctor', [
            'full_name' => 'drg. Baru di-Web'
        ]);
    }

    public function test_admin_can_create_doctor_via_api()
    {
        $data = [
            'full_name'      => 'drg. Baru di-API',
            'specialization' => 'Gigi Anak',
            'is_active'      => true
        ];

        $response = $this->postJson('/api/doctors', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('doctor', [
            'full_name' => 'drg. Baru di-API'
        ]);
    }

    public function test_admin_can_create_staff_account_via_web()
    {
        $data = [
            'full_name'             => 'Staff Baru',
            'email'                 => 'staffbaru@test.com',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
            'access_type'           => 'ADM'
        ];

        $response = $this->post(route('admin.settings.staff.account.store'), $data);

        $response->assertStatus(302);
        $this->assertDatabaseHas('user', [
            'email' => 'staffbaru@test.com'
        ]);
    }

    // ================= BHP MANAGEMENT =================

    public function test_admin_can_create_bhp_item_via_web()
    {
        $data = [
            'item_code'      => 'BHP-' . Str::random(5),
            'item_name'      => 'Masker Bedah',
            'brand'          => 'Sensi',
            'unit'           => 'Box',
            'initial_stock'  => 20,
            'purchase_price' => 50000,
            'general_price'  => 60000,
            'otc_price'      => 65000,
            'min_stock'      => 5
        ];

        $response = $this->post('/admin/pharmacy/bhp/items', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('consumable_items', [
            'item_name' => 'Masker Bedah'
        ]);
    }

    public function test_admin_can_restock_bhp_via_api()
    {
        $item = ConsumableItem::create([
            'id'             => (string) Str::uuid(),
            'item_code'      => 'BHP-TEST-01',
            'item_name'      => 'Sarung Tangan S',
            'initial_stock'  => 10,
            'current_stock'  => 10,
            'purchase_price' => 5000,
            'general_price'  => 6000,
            'otc_price'      => 7000,
            'min_stock'      => 2
        ]);

        $data = [
            'bhp_id'         => $item->id,
            'restock_type'   => 'restock',
            'quantity_added' => 50,
            'purchase_price' => 50000,
            'note'           => 'Restock API'
        ];

        $response = $this->postJson('/api/bhp/restock', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('consumable_items', [
            'id' => $item->id,
            'current_stock' => 60
        ]);
    }

    // ================= REGISTRATION & EMR =================

    public function test_admin_can_register_new_patient_via_api()
    {
        $doctor = Doctor::create(['id' => (string) Str::uuid(), 'full_name' => 'drg. Test Registration']);

        $data = [
            'doctor_id'    => $doctor->id,
            'patient_type' => 'new',
            'date'         => now()->toDateString(),
            'time'         => '10:00',
            'full_name'    => 'New API Patient',
            'date_of_birth' => '1995-05-05',
            'gender'       => 'Female'
        ];

        config(['auth.guards.api.driver' => 'session']);
        $response = $this->postJson('/api/registration', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('patient', [
            'full_name' => 'New API Patient'
        ]);
        $this->assertDatabaseHas('registration', [
            'doctor_id' => $doctor->id,
            'status'    => 'pending'
        ]);
    }

    public function test_admin_can_store_doctor_note_via_web()
    {
        $patient = Patient::create([
            'id' => (string) Str::uuid(),
            'full_name' => 'EMR Patient',
            'medical_record_no' => 'MR-EMR-01',
            'date_of_birth' => '1990-01-01',
            'gender' => 'Male'
        ]);
        $doctor = Doctor::create(['id' => (string) Str::uuid(), 'full_name' => 'drg. EMR']);
        $appointment = Appointment::create([
            'id' => (string) Str::uuid(),
            'patient_id' => $patient->id,
            'doctor_id' => $doctor->id,
            'status' => 'engaged',
            'appointment_datetime' => now()
        ]);

        $data = [
            'subjective' => 'Sakit gigi kiri bawah',
            'objective'  => 'Karies pada gigi 36',
            'plan'       => 'Scaling dan Tambalan'
        ];

        $response = $this->post(route('admin.emr.doctor-note.store', $appointment->id), $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('doctor_note', [
            'notes' => "Subjective:\nSakit gigi kiri bawah\n\nObjective:\nKaries pada gigi 36\n\nPlan:\nScaling dan Tambalan"
        ]);
    }

    public function test_admin_can_store_odontogram_via_api()
    {
        $patient = Patient::create([
            'id' => (string) Str::uuid(),
            'full_name' => 'Odonto Patient',
            'medical_record_no' => 'MR-OD-01',
            'date_of_birth' => '1990-01-01',
            'gender' => 'Male'
        ]);

        $data = [
            'patient_id'  => $patient->id,
            'examined_by' => 'drg. Odonto',
            'notes'       => 'Kondisi awal',
            'teeth' => [
                [
                    'tooth_number'    => 11,
                    'condition_code'  => 'sou',
                    'condition_label' => 'Sound'
                ]
            ]
        ];

        $response = $this->postJson('/api/odontogram', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('odontogram_records', [
            'patient_id' => $patient->id
        ]);
        $this->assertDatabaseHas('odontogram_teeth', [
            'tooth_number' => 11,
            'condition_code' => 'sou'
        ]);
    }

    // ================= MASTER SETTINGS & CASHIER =================

    public function test_admin_can_create_master_poli_via_api()
    {
        $data = [
            'id'   => 'POLI-NEW',
            'name' => 'Poli Spesialis Baru'
        ];

        $response = $this->postJson('/api/master-poli', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('master_poli', [
            'name' => 'Poli Spesialis Baru'
        ]);
    }

    public function test_admin_can_create_insurance_partner_via_api()
    {
        $file = UploadedFile::fake()->image('partner-logo.png');

        $data = [
            'name' => 'Asuransi Test',
            'logo' => $file
        ];

        $response = $this->postJson('/api/insurance-partners', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('insurance_partners', [
            'name' => 'Asuransi Test'
        ]);
    }

    public function test_admin_can_store_payment_via_web()
    {
        $appointment = Appointment::create([
            'id' => (string) Str::uuid(),
            'patient_id' => Patient::create([
                'id' => (string) Str::uuid(),
                'full_name' => 'Cash Patient',
                'medical_record_no' => 'MR-CSH-01',
                'date_of_birth' => '1990-01-01',
                'gender' => 'Male'
            ])->id,
            'doctor_id' => Doctor::create(['id' => (string) Str::uuid(), 'full_name' => 'drg. Cashier'])->id,
            'status' => 'succeed',
            'appointment_datetime' => now()
        ]);

        $data = [
            'registration_id' => $appointment->id,
            'payment_method'  => 'Tunai',
            'amount_paid'     => 100000,
            'change_amount'   => 0,
            'debt_amount'     => 0,
            'status'          => 'paid'
        ];

        $response = $this->post(route('admin.cashier.storePayment'), $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('invoices', [
            'registration_id' => $appointment->id,
            'payment_method'  => 'Tunai',
            'status'          => 'paid'
        ]);
    }
}
