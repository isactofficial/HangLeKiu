<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\PatientController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RegistrationController;
use App\Http\Controllers\MedicineController;

// PUBLIC
Route::get('/', fn() => view('welcome'))->name('home');
Route::get('/klinik', fn() => view('user.pages.klinik'))->name('klinik');
Route::get('/artikel', [ArticleController::class, 'index'])->name('artikel');
Route::get('/artikel/{id}', [ArticleController::class, 'show'])->name('artikel.show');

Route::get('/registration',  [AppointmentController::class, 'create'])->name('registration.form');
Route::get('/daftar',        [AppointmentController::class, 'create'])->name('appointments.create');
Route::post('/daftar',       [AppointmentController::class, 'store'])->name('appointments.store');
Route::get('/daftar/sukses', [AppointmentController::class, 'success'])->name('appointments.success');

Route::prefix('api/patients')->group(function () {
    Route::post('/', [PatientController::class, 'store']);
    Route::get('/', [PatientController::class, 'index']);
    Route::get('/{id}', [PatientController::class, 'show']);
    Route::put('/{id}', [PatientController::class, 'update']);
    Route::delete('/{id}', [PatientController::class, 'destroy']);
});

// ADMIN AUTH
Route::get('/admin/login',    [AuthController::class, 'showAdminLogin'])->name('admin.login');
Route::post('/admin/login',   [AuthController::class, 'adminLogin'])->name('admin.login.post');
Route::get('/admin/register', [AuthController::class, 'showAdminRegister'])->name('admin.register');
Route::post('/admin/register',[AuthController::class, 'adminRegister'])->name('admin.register.post');

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
        Route::get('/registration', fn() => view('admin.pages.registration'))->name('registration');
        Route::get('/registration/pendaftaran-baru', fn() => view('admin.pages.pendaftaran-baru'))->name('registration.pendaftaran-baru');
        Route::get('/registration/pasien-baru', fn() => view('admin.pages.pasien-baru'))->name('registration.pasien-baru');
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

        // ── Registration API (diakses dari Blade via fetch) ──
        Route::prefix('api/registration')->group(function () {
            Route::get('/master-data',    [RegistrationController::class, 'masterData']);
            Route::get('/doctors',        [RegistrationController::class, 'doctors']);
            Route::get('/slots',          [RegistrationController::class, 'availableSlots']);
            Route::get('/search-patient', [RegistrationController::class, 'searchPatient']);
            Route::post('/',              [RegistrationController::class, 'store']);
        });

        // ── Medicine/Stok Obat API (diakses dari Blade via fetch) ──
        Route::prefix('api/medicine')->group(function () {
            Route::get('/',                   [MedicineController::class, 'index']);
            Route::post('/',                  [MedicineController::class, 'store']);
            Route::get('/{id}',               [MedicineController::class, 'show']);
            Route::put('/{id}',               [MedicineController::class, 'update']);
            Route::delete('/{id}',            [MedicineController::class, 'destroy']);
            Route::post('/{id}/stock-in',     [MedicineController::class, 'stockIn']);
            Route::post('/{id}/stock-out',    [MedicineController::class, 'stockOut']);
            Route::get('/{id}/stock-history', [MedicineController::class, 'stockHistory']);
        });
    });

    // ================= USER =================
    Route::middleware('role:PAT')->prefix('user')->name('user.')->group(function () {
        Route::get('/dashboard', fn() => view('user.pages.dashboard'))->name('dashboard');
    });

    // dummy lama
    Route::post('/registration/store', function () {
        return back()->withErrors(['(dummy) Belum disambungkan ke database.']);
    })->name('registration.store');
});