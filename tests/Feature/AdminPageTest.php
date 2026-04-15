<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use App\Models\Doctor;
use App\Models\MasterPoli;
use App\Models\MasterGuarantorType;
use App\Models\MasterPaymentMethod;
use App\Models\MasterVisitType;
use App\Models\MasterCareType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPageTest extends TestCase
{
    use RefreshDatabase;

    protected $adminUser;

    protected function setUp(): void
    {
        parent::setUp();

        // 1. Create ADM role
        $roleAdmin = Role::create([
            'id' => 'role-admin-uuid',
            'code' => 'ADM',
            'name' => 'Admin'
        ]);

        // 2. Create Admin User
        $this->adminUser = User::create([
            'id' => 'admin-user-uuid',
            'role_id' => $roleAdmin->id,
            'name' => 'Super Admin',
            'email' => 'admin@hanglekiu.com',
            'password' => bcrypt('password'),
            'is_active' => true,
            'is_verified' => true
        ]);

        // 3. Seed Master Data (to avoid crashes on some admin pages)
        MasterPoli::create(['id' => 'P001', 'name' => 'Poli Umum', 'is_active' => true]);
        MasterGuarantorType::create(['id' => 'G001', 'name' => 'Umum', 'is_active' => true]);
        MasterPaymentMethod::create(['id' => 'PM001', 'name' => 'Cash', 'is_active' => true]);
        MasterVisitType::create(['id' => 'VT001', 'name' => 'Konsultasi', 'is_active' => true]);
        MasterCareType::create(['id' => 'CT001', 'name' => 'Rawat Jalan', 'is_active' => true]);

        // 4. Create a Doctor (needed for some modules)
        Doctor::create([
            'id' => 'D001',
            'full_name' => 'drg. Budi',
            'is_active' => true,
            'email' => 'budi@example.com'
        ]);

        // 5. Authenticate as Admin
        $this->actingAs($this->adminUser);
    }

    public function test_admin_dashboard_is_accessible()
    {
        $response = $this->get(route('admin.dashboard'));
        $response->assertStatus(200);
    }

    public function test_admin_outpatient_is_accessible()
    {
        $response = $this->get(route('admin.outpatient'));
        $response->assertStatus(200);
    }

    public function test_admin_registration_index_is_accessible()
    {
        $response = $this->get(route('admin.registration.index'));
        $response->assertStatus(200);
    }

    public function test_admin_notifications_is_accessible()
    {
        $response = $this->get(route('admin.notifications'));
        $response->assertStatus(200);
    }

    public function test_admin_emr_is_accessible()
    {
        $response = $this->get(route('admin.emr'));
        $response->assertStatus(200);
    }

    public function test_admin_pharmacy_page_is_accessible()
    {
        $response = $this->get(route('admin.pharmacy'));
        $response->assertStatus(200);
    }

    public function test_admin_profile_is_accessible()
    {
        $response = $this->get(route('admin.profile'));
        $response->assertStatus(200);
    }

    public function test_admin_messages_is_accessible()
    {
        $response = $this->get(route('admin.messages'));
        $response->assertStatus(200);
    }

    public function test_admin_office_is_accessible()
    {
        $response = $this->get(route('admin.office'));
        $response->assertStatus(200);
    }

    public function test_admin_settings_is_accessible()
    {
        $response = $this->get(route('admin.settings'));
        $response->assertStatus(200);
    }

    public function test_admin_cashier_is_accessible()
    {
        $response = $this->get(route('admin.cashier'));
        $response->assertStatus(200);
    }

    public function test_admin_articles_resource_redirects_to_settings()
    {
        // ArticleAdminController@index redirects to admin.settings
        $response = $this->get(route('admin.articles.index'));
        $response->assertStatus(302);
        $response->assertRedirect(route('admin.settings', ['menu' => 'beranda-settings', 'submenu' => 'Artikel']));
    }

    public function test_admin_pharmacy_medicine_is_accessible()
    {
        $response = $this->get(route('admin.pharmacy.medicine.index'));
        $response->assertStatus(200);
    }

    public function test_admin_pharmacy_usage_is_accessible()
    {
        $response = $this->get(route('admin.pharmacy.penggunaan-obat.index'));
        $response->assertStatus(200);
    }

    public function test_admin_bhp_items_is_accessible()
    {
        $response = $this->get('/admin/pharmacy/bhp/items');
        $response->assertStatus(200);
    }

    public function test_admin_bhp_usage_is_accessible()
    {
        $response = $this->get('/admin/pharmacy/bhp/usage');
        $response->assertStatus(200);
    }
}
