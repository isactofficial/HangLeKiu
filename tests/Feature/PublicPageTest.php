<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Doctor;
use App\Models\DoctorSchedule;
use App\Models\MasterCareType;
use App\Models\MasterGuarantorType;
use App\Models\MasterPaymentMethod;
use App\Models\MasterPoli;
use App\Models\MasterVisitType;
use App\Models\Treatment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPageTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Create necessary data for pages that depend on them
        
        // Article
        Article::create([
            'id' => 'ART001',
            'title' => 'Tips Kesehatan Gigi',
            'category' => 'Tips and Trick',
            'description' => 'Deskripsi artikel tips kesehatan gigi',
            'content' => 'Konten lengkap artikel tips kesehatan gigi',
            'is_active' => true,
        ]);

        // Doctor
        $doctor = Doctor::create([
            'id' => 'D001',
            'full_name' => 'drg. Jane Doe',
            'specialization' => 'Sp.Ortho',
            'is_active' => true,
            'email' => 'jane@example.com'
        ]);

        // Doctor Schedule (Registration page might need it)
        DoctorSchedule::create([
            'id' => 'SCH001',
            'doctor_id' => $doctor->id,
            'day' => 'monday',
            'start_time' => '08:00:00',
            'end_time' => '12:00:00',
            'is_active' => true
        ]);

        // Master Data for Registration Page
        MasterPoli::create(['id' => 'POL001', 'name' => 'Poli Gigi', 'is_active' => true]);
        MasterGuarantorType::create(['id' => 'GUA001', 'name' => 'Umum', 'is_active' => true]);
        MasterPaymentMethod::create(['id' => 'PAY001', 'name' => 'Cash', 'is_active' => true]);
        MasterVisitType::create(['id' => 'VIS001', 'name' => 'Konsultasi', 'is_active' => true]);
        MasterCareType::create(['id' => 'CAR001', 'name' => 'Rawat Jalan', 'is_active' => true]);
        
        // Treatment
        Treatment::create([
            'id' => 'TRT001',
            'procedure_name' => 'Scaling',
            'is_active' => true
        ]);
    }

    public function test_home_page_is_accessible()
    {
        $response = $this->get(route('home'));
        $response->assertStatus(200);
    }

    public function test_klinik_page_is_accessible()
    {
        $response = $this->get(route('klinik'));
        $response->assertStatus(200);
    }

    public function test_article_index_page_is_accessible()
    {
        $response = $this->get(route('artikel'));
        $response->assertStatus(200);
    }

    public function test_article_detail_page_is_accessible()
    {
        $article = Article::first();
        $response = $this->get(route('artikel.show', ['slug' => $article->slug]));
        $response->assertStatus(200);
    }

    public function test_registration_form_page_is_accessible()
    {
        $response = $this->get(route('registration.form'));
        $response->assertStatus(200);
    }

    public function test_daftar_page_is_accessible()
    {
        $response = $this->get(route('appointments.create'));
        $response->assertStatus(200);
    }

    public function test_check_slot_endpoint_is_accessible()
    {
        $response = $this->get(route('appointments.checkSlot'));
        $response->assertStatus(200);
    }

    public function test_registration_success_page_is_accessible()
    {
        $response = $this->get(route('appointments.success'));
        $response->assertStatus(200);
    }

    public function test_treatment_page_is_accessible()
    {
        $response = $this->get(route('perawatan'));
        $response->assertStatus(200);
    }

    public function test_doctor_profile_page_is_accessible()
    {
        $response = $this->get(route('dokter.profile'));
        $response->assertStatus(200);
    }

    public function test_guest_login_page_is_accessible()
    {
        $response = $this->get(route('login'));
        $response->assertStatus(200);
    }

    public function test_guest_register_page_is_accessible()
    {
        $response = $this->get(route('register'));
        $response->assertStatus(200);
    }

    public function test_admin_login_page_is_accessible()
    {
        $response = $this->get(route('admin.login'));
        $response->assertStatus(200);
    }

    public function test_admin_register_page_is_accessible()
    {
        $response = $this->get(route('admin.register'));
        $response->assertStatus(200);
    }

    public function test_doctor_login_page_is_accessible()
    {
        $response = $this->get(route('doctor.login'));
        $response->assertStatus(200);
    }
}
