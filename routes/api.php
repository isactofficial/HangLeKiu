<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\Api\RegistrationController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\DoctorNoteController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\MedicalProcedureController;
use App\Http\Controllers\ProcedureController;
use App\Http\Controllers\ProcedureItemController;
use App\Http\Controllers\ProcedureMedicineController;
use App\Http\Controllers\MasterProcedureController;


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

// ================= PROCEDURE =================
Route::prefix('procedures')->group(function () {
    Route::post('/', [ProcedureController::class, 'store']);
    Route::get('/', [ProcedureController::class, 'index']);
    Route::get('/{id}', [ProcedureController::class, 'show']);
    Route::put('/{id}', [ProcedureController::class, 'update']);
    Route::delete('/{id}', [ProcedureController::class, 'destroy']);
});

// ================= DOCTOR =================
Route::prefix('doctors')->group(function () {
    Route::post('/', [DoctorController::class, 'store']);
    Route::get('/', [DoctorController::class, 'index']);
    Route::get('/{id}', [DoctorController::class, 'show']);
    Route::put('/{id}', [DoctorController::class, 'update']);
    Route::delete('/{id}', [DoctorController::class, 'destroy']);
});

// ================= DOCTOR NOTE =================
Route::prefix('doctor-notes')->group(function () {
    Route::post('/', [DoctorNoteController::class, 'store']);
    Route::get('/{id}', [DoctorNoteController::class, 'show']);
    Route::put('/{id}', [DoctorNoteController::class, 'update']);
    Route::delete('/{id}', [DoctorNoteController::class, 'destroy']);
});

// ================= MEDICAL PROCEDURE =================
Route::prefix('medical-procedures')->group(function () {
    Route::post('/', [MedicalProcedureController::class, 'store']);
    Route::get('/{id}', [MedicalProcedureController::class, 'show']);
    Route::put('/{id}', [MedicalProcedureController::class, 'update']);
    Route::delete('/{id}', [MedicalProcedureController::class, 'destroy']);
});

// ================= PROCEDURE ITEM =================
Route::prefix('procedure-items')->group(function () {
    Route::post('/', [ProcedureItemController::class, 'store']);
    Route::get('/{id}', [ProcedureItemController::class, 'show']);
    Route::put('/{id}', [ProcedureItemController::class, 'update']);
    Route::delete('/{id}', [ProcedureItemController::class, 'destroy']);
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

// ================= ADMIN REGISTRATION =================
Route::prefix('admin/registration')->middleware('auth:api')->group(function () {
    Route::get('/master-data',    [RegistrationController::class, 'masterData']);
    Route::get('/doctors',        [RegistrationController::class, 'doctors']);
    Route::get('/slots',          [RegistrationController::class, 'availableSlots']);
    Route::get('/search-patient', [RegistrationController::class, 'searchPatient']);
    Route::post('/',              [RegistrationController::class, 'store']);
});

// ================= ADMIN MEDICINE =================
Route::prefix('admin/medicine')->middleware('auth:api')->group(function () {
    Route::get('/',                   [MedicineController::class, 'index']);
    Route::post('/',                  [MedicineController::class, 'store']);
    Route::get('/{id}',               [MedicineController::class, 'show']);
    Route::put('/{id}',               [MedicineController::class, 'update']);
    Route::delete('/{id}',            [MedicineController::class, 'destroy']);
    Route::post('/{id}/stock-in',     [MedicineController::class, 'stockIn']);
    Route::post('/{id}/stock-out',    [MedicineController::class, 'stockOut']);
    Route::get('/{id}/stock-history', [MedicineController::class, 'stockHistory']);
});

Route::prefix('procedure-medicine')->group(function () {
    Route::get('/', [ProcedureMedicineController::class, 'index']);
    Route::post('/', [ProcedureMedicineController::class, 'store']);
    Route::get('/{id}', [ProcedureMedicineController::class, 'show']);
    Route::delete('/{id}', [ProcedureMedicineController::class, 'destroy']);
});

Route::prefix('master-procedure')->group(function () {
    Route::get('/', [MasterProcedureController::class, 'index']);
    Route::post('/', [MasterProcedureController::class, 'store']);
    Route::get('/{id}', [MasterProcedureController::class, 'show']);
    Route::put('/{id}', [MasterProcedureController::class, 'update']);
    Route::delete('/{id}', [MasterProcedureController::class, 'destroy']);
});