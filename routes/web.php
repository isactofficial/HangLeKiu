<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AppointmentController;
use Illuminate\Support\Facades\Route;

// PUBLIC
Route::get('/', fn() => view('welcome'))->name('home');
Route::get('/artikel', fn() => view('user.pages.artikel'))->name('artikel');

Route::get('/registration',  [AppointmentController::class, 'create'])->name('registration.form');
Route::get('/daftar',        [AppointmentController::class, 'create'])->name('appointments.create');
Route::post('/daftar',       [AppointmentController::class, 'store'])->name('appointments.store');
Route::get('/daftar/sukses', [AppointmentController::class, 'success'])->name('appointments.success');

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

    // ADMIN
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard',    fn() => view('admin.pages.dashboard'))->name('dashboard');
        Route::get('/outpatient',   [AppointmentController::class, 'schedule'])->name('outpatient');
        Route::get('/registration', fn() => view('admin.pages.registration'))->name('registration');
        Route::get('/emr',          fn() => view('admin.pages.emr'))->name('emr');
        Route::get('/pharmacy',     fn() => view('admin.layout.pharmacy'))->name('pharmacy');
        Route::get('/cashier',      fn() => view('admin.pages.cashier'))->name('cashier');
        Route::get('/profile',      fn() => view('admin.pages.profile'))->name('profile');
        Route::get('/messages',     fn() => view('admin.pages.messages'))->name('messages');
        Route::get('/office',       fn() => view('admin.pages.office'))->name('office');

        // Update status appointment (dipanggil dari /admin/appointments/{id}/status)
        Route::patch('/appointments/{appointment}/status', [AppointmentController::class, 'updateStatus'])
             ->name('appointments.updateStatus');
    });

    // USER
    Route::middleware('role:user')->prefix('user')->name('user.')->group(function () {
        Route::get('/dashboard', fn() => view('user.pages.dashboard'))->name('dashboard');
    });

    Route::post('/registration/store', function () {
        return back()->withErrors(['(dummy) Belum disambungkan ke database.']);
    })->name('registration.store');
});