<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RegistrationController;

// PUBLIC
Route::get('/', fn() => view('welcome'))->name('home');
Route::get('/klinik', fn() => view('user.pages.klinik'))->name('klinik');
Route::get('/artikel', [ArticleController::class, 'index'])->name('artikel');
Route::get('/artikel/{id}', [ArticleController::class, 'show'])->name('artikel.show');

Route::get('/registration',  [AppointmentController::class, 'create'])->name('registration.form');
Route::get('/daftar',        [AppointmentController::class, 'create'])->name('appointments.create');
Route::post('/daftar',       [AppointmentController::class, 'store'])->name('appointments.store');
Route::get('/daftar/sukses', [AppointmentController::class, 'success'])->name('appointments.success');

// ADMIN AUTH
Route::get('/admin/login',    [AuthController::class, 'showAdminLogin'])->name('admin.login');
Route::post('/admin/login',   [AuthController::class, 'adminLogin'])->name('admin.login.post');
Route::get('/admin/register', [AuthController::class, 'showAdminRegister'])->name('admin.register');
Route::post('/admin/register',[AuthController::class, 'adminRegister'])->name('admin.register.post');
Route::get('/doctor/login', [AuthController::class, 'showDoctorLogin'])->name('doctor.login');
Route::post('/doctor/login', [AuthController::class, 'doctorLogin'])->name('doctor.login.post');

// GUEST ONLY
Route::middleware('guest')->group(function () {
    Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',   [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register',[AuthController::class, 'register']);
});

// AUTH
Route::middleware('auth')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // ================= ADMIN =================
    Route::middleware('role:ADM')->prefix('admin')->name('admin.')->group(function () {

        Route::get('/dashboard',    fn() => view('admin.pages.dashboard'))->name('dashboard');
        Route::get('/outpatient',   [AppointmentController::class, 'schedule'])->name('outpatient');
<<<<<<< HEAD
<<<<<<< Updated upstream
        Route::get('/registration', fn() => view('admin.pages.registration'))->name('registration');
=======
        // Legacy compatibility for older blade references.
        Route::get('/rawat-jalan',  [AppointmentController::class, 'schedule'])->name('rawat-jalan');
        Route::get('/registration', [AppointmentController::class, 'registrationIndex'])->name('registration');
        Route::get('/registration/pendaftaran-baru', fn() => view('admin.pages.pendaftaran-baru'))->name('registration.pendaftaran-baru');
        Route::get('/registration/pasien-baru', fn() => view('admin.pages.pasien-baru'))->name('registration.pasien-baru');
>>>>>>> Stashed changes
=======
        Route::get('/registration', [AppointmentController::class, 'registrationIndex'])->name('registration');
        Route::get('/registration/pendaftaran-baru', fn() => view('admin.pages.pendaftaran-baru'))->name('registration.pendaftaran-baru');
        Route::get('/registration/pasien-baru', fn() => view('admin.pages.pasien-baru'))->name('registration.pasien-baru');
>>>>>>> origin/main
        Route::get('/emr',          fn() => view('admin.pages.emr'))->name('emr');
        Route::get('/pharmacy',     fn() => view('admin.layout.pharmacy'))->name('pharmacy');
        Route::get('/cashier',      fn() => view('admin.pages.cashier'))->name('cashier');
        Route::get('/profile',      fn() => view('admin.pages.profile'))->name('profile');
        Route::get('/messages',     fn() => view('admin.pages.messages'))->name('messages');
        Route::get('/office',       fn() => view('admin.layout.office'))->name('office');
        Route::get('/settings',     fn() => view('admin.layout.settings'))->name('settings');

        // Tambahan Yusmia (PENDAFTARAN BACKEND)
        Route::get('/appointments/create', [AppointmentController::class, 'createFromSchedule'])
            ->name('appointments.create');
        Route::post('/appointments/store', [AppointmentController::class, 'storeAdmin'])
            ->name('appointments.store');
        Route::patch('/appointments/{appointment}/status', [AppointmentController::class, 'updateStatus'])
             ->name('appointments.updateStatus');
<<<<<<< HEAD
<<<<<<< Updated upstream
=======
           Route::get('/appointments/{appointment}/detail', [AppointmentController::class, 'detail'])
               ->name('appointments.detail');
        Route::post('/appointments/{appointment}/diagnosis', [AppointmentController::class, 'addDiagnosis'])
             ->name('appointments.addDiagnosis');

        // EMR API endpoints (session auth)
        Route::get('/api/emr/patient-data', [AppointmentController::class, 'emrPatientData'])
            ->name('emr.patientData');

        Route::get('/api/registration/appointments', [AppointmentController::class, 'getAppointmentsApi'])
            ->name('api.appointments');
        Route::get('/api/registration/appointments-emr', [RegistrationController::class, 'listAppointmentsEmr'])
            ->name('api.appointments.emr');
=======
>>>>>>> origin/main

        // Create akun dokter hanya dari menu settings admin.
        Route::post('/settings/manajemen-staff/doctor', [DoctorController::class, 'storeFromAdmin'])
            ->name('settings.staff.doctor.store');

        // Patient routes (admin)
        Route::get('/patients/search',  [PatientController::class, 'search'])->name('patients.search');
        Route::post('/patients',        [PatientController::class, 'storeFromAdmin'])->name('patients.store');
<<<<<<< HEAD
>>>>>>> Stashed changes
=======
>>>>>>> origin/main
    });

    // ================= USER =================
    Route::middleware('role:PAT')->prefix('user')->name('user.')->group(function () {
        Route::get('/dashboard', fn() => view('user.pages.dashboard'))->name('dashboard');
    });

    // DOCTOR
    Route::middleware('role:DCT')->prefix('doctor')->name('doctor.')->group(function () {
        Route::get('/dashboard', fn() => view('doctor.pages.dashboard'))->name('dashboard');
    });
});
