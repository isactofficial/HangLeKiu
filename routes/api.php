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
use App\Http\Controllers\MasterPoliController;
use App\Http\Controllers\MasterPaymentMethodController;
use App\Http\Controllers\MasterGuarantorTypeController;
use App\Http\Controllers\MasterVisitTypeController;
use App\Http\Controllers\MasterCareTypeController;
use App\Http\Controllers\MasterProcedureDetailController;
use App\Http\Controllers\OdontogramController;
use App\Http\Controllers\ConsumableItemController;
use App\Http\Controllers\ConsumableUsageController;
use App\Http\Controllers\ConsumableRestockController;
use App\Http\Controllers\ConsumableExpiryLogController;
use App\Http\Controllers\DashboardController;

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

// ================= ADMIN MASTER SETTINGS =================
Route::prefix('master-poli')->group(function () {
    Route::get('/', [MasterPoliController::class, 'index']);
    Route::post('/', [MasterPoliController::class, 'store']);
    Route::get('/{id}', [MasterPoliController::class, 'show']);
    Route::put('/{id}', [MasterPoliController::class, 'update']);
    Route::delete('/{id}', [MasterPoliController::class, 'destroy']);
});

Route::prefix('master-guarantor')->group(function () {
    Route::get('/', [MasterGuarantorTypeController::class, 'index']);
    Route::post('/', [MasterGuarantorTypeController::class, 'store']);
    Route::get('/{id}', [MasterGuarantorTypeController::class, 'show']);
    Route::put('/{id}', [MasterGuarantorTypeController::class, 'update']);
    Route::delete('/{id}', [MasterGuarantorTypeController::class, 'destroy']);
});

Route::prefix('master-payment')->group(function () {
    Route::get('/', [MasterPaymentMethodController::class, 'index']);
    Route::post('/', [MasterPaymentMethodController::class, 'store']);
    Route::get('/{id}', [MasterPaymentMethodController::class, 'show']);
    Route::put('/{id}', [MasterPaymentMethodController::class, 'update']);
    Route::delete('/{id}', [MasterPaymentMethodController::class, 'destroy']);
});

Route::prefix('master-visit-type')->group(function () {
    Route::get('/', [MasterVisitTypeController::class, 'index']);
    Route::post('/', [MasterVisitTypeController::class, 'store']);
    Route::get('/{id}', [MasterVisitTypeController::class, 'show']);
    Route::put('/{id}', [MasterVisitTypeController::class, 'update']);
    Route::delete('/{id}', [MasterVisitTypeController::class, 'destroy']);
});

Route::prefix('master-care-type')->group(function () {
    Route::get('/', [MasterCareTypeController::class, 'index']);
    Route::post('/', [MasterCareTypeController::class, 'store']);
    Route::get('/{id}', [MasterCareTypeController::class, 'show']);
    Route::put('/{id}', [MasterCareTypeController::class, 'update']);
    Route::delete('/{id}', [MasterCareTypeController::class, 'destroy']);
});

Route::prefix('master-procedure-detail')->group(function () {
    Route::get('/', [MasterProcedureDetailController::class, 'index']);
    Route::post('/', [MasterProcedureDetailController::class, 'store']);
    Route::get('/{id}', [MasterProcedureDetailController::class, 'show']);
    Route::put('/{id}', [MasterProcedureDetailController::class, 'update']);
    Route::delete('/{id}', [MasterProcedureDetailController::class, 'destroy']);
});

// ================= ODONTOGRAM =================
Route::prefix('odontogram')->group(function () {
    Route::post('/', [OdontogramController::class, 'store']);
    Route::get('/patient/{patientId}', [OdontogramController::class, 'indexByPatient']);
    Route::get('/{recordId}', [OdontogramController::class, 'show']);
    Route::patch('/{recordId}', [OdontogramController::class, 'update']);
    Route::delete('/{recordId}', [OdontogramController::class, 'destroy']);
    Route::post('/{recordId}/teeth', [OdontogramController::class, 'addTooth']);
    Route::delete('/teeth/{toothId}', [OdontogramController::class, 'deleteTooth']);
});

// ================= ADMIN BHP (Bahan Habis Pakai) =================
Route::prefix('bhp')->group(function () {
    Route::get('/items',          [ConsumableItemController::class, 'index']);
    Route::post('/items',         [ConsumableItemController::class, 'store']);
    Route::get('/items/{id}',     [ConsumableItemController::class, 'show']);
    Route::put('/items/{id}',     [ConsumableItemController::class, 'update']);
    Route::delete('/items/{id}',  [ConsumableItemController::class, 'destroy']);

    Route::get('/usage',          [ConsumableUsageController::class, 'index']);
    Route::post('/usage',         [ConsumableUsageController::class, 'store']);
    Route::get('/usage/{id}',     [ConsumableUsageController::class, 'show']);
    Route::delete('/usage/{id}',  [ConsumableUsageController::class, 'destroy']);

    Route::get('/restock',        [ConsumableRestockController::class, 'index']);
    Route::post('/restock',       [ConsumableRestockController::class, 'store']);
    Route::get('/restock/{id}',   [ConsumableRestockController::class, 'show']);
    Route::delete('/restock/{id}',[ConsumableRestockController::class, 'destroy']);

    Route::get('/expiry',         [ConsumableExpiryLogController::class, 'index']);
    Route::post('/expiry',        [ConsumableExpiryLogController::class, 'store']);
    Route::get('/expiry/{id}',    [ConsumableExpiryLogController::class, 'show']);
    Route::delete('/expiry/{id}', [ConsumableExpiryLogController::class, 'destroy']);

});

Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);

    Route::get('/master/visit-types', fn() =>
        response()->json(DB::table('master_visit_type')->select('id', 'name')->get())
    );
    Route::get('/master/poli', fn() =>
        response()->json(DB::table('master_poli')->select('id', 'name')->get())
    );
});



