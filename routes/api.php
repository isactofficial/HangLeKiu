<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\Api\RegistrationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| Semua route di sini otomatis prefix: /api
| Contoh akses: http://127.0.0.1:8000/api/...
|--------------------------------------------------------------------------
*/

// ================= AUTH =================
Route::prefix('auth')->group(function () {
    Route::post('/login',    [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);

    Route::middleware('auth:api')->group(function () {
        Route::post('/logout',             [AuthController::class, 'logout']);
        Route::get('/me',                  [AuthController::class, 'me']);
        Route::post('/refresh',            [AuthController::class, 'refresh']);
        Route::post('/resend-verification',[AuthController::class, 'resendVerification']);
        Route::get('/verify/{token}',      [AuthController::class, 'verifyEmail']);
    });
});

// ================= PATIENT =================
Route::prefix('patients')->group(function () {
    Route::get('/',       [PatientController::class, 'index']);
    Route::post('/',      [PatientController::class, 'store']);
    Route::get('/{id}',   [PatientController::class, 'show']);
    Route::put('/{id}',   [PatientController::class, 'update']);
    Route::delete('/{id}',[PatientController::class, 'destroy']);
});

// ================= REGISTRATION (ADMIN) =================
Route::prefix('registration')->middleware('auth:api')->group(function () {

    // Dropdown / master data
    Route::get('/master-data',    [RegistrationController::class, 'masterData']);

    // Dokter aktif + jadwal hari ini
    // GET /api/registration/doctors?date=2026-03-26
    Route::get('/doctors',        [RegistrationController::class, 'doctors']);

    // Slot tersedia per dokter per tanggal
    // GET /api/registration/slots?doctor_id=xxx&date=2026-03-26
    Route::get('/slots',          [RegistrationController::class, 'availableSlots']);

    // Cari pasien (autocomplete)
    // GET /api/registration/search-patient?q=budi
    Route::get('/search-patient', [RegistrationController::class, 'searchPatient']);

    // Simpan pendaftaran baru
    // POST /api/registration
    Route::post('/',              [RegistrationController::class, 'store']);
});

// ================= APPOINTMENTS (ADMIN) =================
Route::prefix('admin')->middleware('auth:api')->group(function () {
    Route::patch('/appointments/{appointment}/status', [AppointmentController::class, 'updateStatus']);
});

use App\Http\Controllers\MedicineController;

Route::prefix('medicine')->group(function () {
    Route::get('/', [MedicineController::class, 'index']);
    Route::post('/', [MedicineController::class, 'store']);
    Route::get('/{id}', [MedicineController::class, 'show']);
    Route::put('/{id}', [MedicineController::class, 'update']);
    Route::delete('/{id}', [MedicineController::class, 'destroy']);

     // stok
    Route::post('/{id}/stock-in', [MedicineController::class, 'stockIn']);
    Route::post('/{id}/stock-out', [MedicineController::class, 'stockOut']);
    Route::get('/{id}/stock-history', [MedicineController::class, 'stockHistory']);
});