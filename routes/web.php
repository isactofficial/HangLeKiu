<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardUserController;
use App\Http\Controllers\DashboardDoctorController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\EmrController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\PenggunaanObatController;
use App\Http\Controllers\ConsumableItemController;
use App\Http\Controllers\ConsumableUsageController;
use App\Http\Controllers\TreatmentPageController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\DoctorPageController;
use App\Http\Controllers\ArticleAdminController;
use App\Http\Controllers\DoctorEmrController;
use App\Http\Controllers\AdminNotificationController;
use Illuminate\Support\Facades\Route;

// ================= PUBLIC =================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/klinik', fn() => view('user.pages.klinik'))->name('klinik');
Route::get('/artikel', [ArticleController::class, 'index'])->name('artikel');
Route::get('/artikel/{slug}', [ArticleController::class, 'show'])->name('artikel.show');

Route::get('/registration',  [AppointmentController::class, 'create'])->name('registration.form');
Route::get('/daftar',        [AppointmentController::class, 'create'])->name('appointments.create');
Route::get('/appointments/check-slot', [AppointmentController::class, 'checkSlot'])->name('appointments.checkSlot');
Route::post('/daftar',       [AppointmentController::class, 'store'])->name('appointments.store');
Route::get('/daftar/sukses', [AppointmentController::class, 'success'])->name('appointments.success');
Route::get('/pelayanan/perawatan', [TreatmentPageController::class, 'index'])->name('perawatan');
Route::get('/pelayanan/dokter', [DoctorPageController::class, 'index'])->name('dokter.profile');

// ================= ADMIN & DOCTOR AUTH =================
Route::get('/admin/login',    [AuthController::class, 'showAdminLogin'])->name('admin.login');
Route::post('/admin/login',   [AuthController::class, 'adminLogin'])->name('admin.login.post');
Route::get('/admin/register', [AuthController::class, 'showAdminRegister'])->name('admin.register');
Route::post('/admin/register',[AuthController::class, 'adminRegister'])->name('admin.register.post');
// Dokter login
Route::get('/doctor/login',   [AuthController::class, 'showDoctorLogin'])->name('doctor.login');
Route::post('/doctor/login',  [AuthController::class, 'doctorLogin'])->name('doctor.login.post');

// ================= GUEST ONLY =================
Route::middleware('guest')->group(function () {
    Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',   [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register',[AuthController::class, 'register']);
});

// ================= AUTH REQUIRED =================
Route::middleware('auth')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // ================= ADMIN & SHARED AREA — ALLOW ADM & DCT =================
    Route::middleware('role:ADM,DCT')->prefix('admin')->name('admin.')->group(function () {

        // --- SHARED ROUTES (ADM & DCT) ---
        // Pencarian pasien dan pembuatan pasien
        Route::get('/patients/search',  [PatientController::class, 'search'])->name('patients.search');
        Route::post('/patients',         [PatientController::class, 'storeFromAdmin'])->name('patients.store');
        
        // Simpan pendaftaran baru
        Route::post('/appointments/store', [AppointmentController::class, 'storeAdmin'])->name('appointments.store');
        
        // Jadwal dokter 
        Route::get('/settings/doctor/{id}', [DoctorController::class, 'showJson'])->name('settings.doctor.show_json');

        // --- ADMIN ONLY AREA ---
        Route::middleware('role:ADM')->group(function() {
            Route::get('/dashboard',    fn() => view('admin.pages.dashboard'))->name('dashboard');
            Route::get('/outpatient',   [AppointmentController::class, 'schedule'])->name('outpatient');
            Route::get('/registration', [AppointmentController::class, 'index'])->name('registration.index');
            
            Route::get('/notifications', [AdminNotificationController::class, 'index'])->name('notifications');
            Route::post('/notifications/{appointment}/confirm', [AdminNotificationController::class, 'confirm'])->name('notifications.confirm');
            Route::post('/notifications/{appointment}/reschedule', [AdminNotificationController::class, 'reschedule'])->name('notifications.reschedule');
            Route::post('/notifications/mark-all-read', [AdminNotificationController::class, 'markAllRead'])->name('notifications.markAllRead');
            Route::get('/notifications/count', [AdminNotificationController::class, 'count'])->name('notifications.count');
            // Route EMR Admin
            Route::get('/emr',          [EmrController::class, 'index'])->name('emr');
            Route::get('/emr/{id}',     [EmrController::class, 'show'])->name('emr.show');
            Route::post('/emr/{appointment}/doctor-note', [EmrController::class, 'storeDoctorNote'])->name('emr.doctor-note.store');
            
            // View-only Registration components
            Route::get('/registration/pendaftaran-baru', fn() => view('admin.pages.pendaftaran-baru'))->name('registration.pendaftaran-baru');
            Route::get('/registration/pasien-baru', fn() => view('admin.pages.pasien-baru'))->name('registration.pasien-baru');
            
            Route::get('/pharmacy',     fn() => view('admin.layout.pharmacy'))->name('pharmacy');
            Route::get('/profile',      fn() => view('admin.pages.profile'))->name('profile');
            Route::get('/messages',     fn() => view('admin.pages.messages'))->name('messages');
            Route::get('/office',       [OfficeController::class, 'index'])->name('office');
            
            // Master Settings & Doctor Management
            Route::get('/settings', [DoctorController::class, 'index'])->name('settings');
            Route::put('/settings/doctor/{id}', [DoctorController::class, 'update'])->name('settings.doctor.update');
            Route::delete('/settings/doctor/{id}', [DoctorController::class, 'destroy'])->name('settings.doctor.destroy');
            
            // Cashier
            Route::get('/cashier', [EmrController::class, 'indexCashier'])->name('cashier');
            Route::get('/cashier/export-csv', [CashierController::class, 'exportCsv'])->name('cashier.exportCsv');
            Route::post('/cashier/store-payment', [EmrController::class, 'storePayment'])->name('cashier.storePayment');
            Route::get('/cashier/search-patient', [CashierController::class, 'searchPatient'])->name('cashier.searchPatient');
            Route::get('/cashier/search-item', [CashierController::class, 'searchItem'])->name('cashier.searchItem');
            Route::post('/cashier/store-manual-payment', [CashierController::class, 'storeManualPayment'])->name('cashier.storeManualPayment');
            
            // Appointment Extra Management
            Route::get('/appointments/create', [AppointmentController::class, 'createFromSchedule'])->name('appointments.create');
            Route::get('/appointments/{id}', [AppointmentController::class, 'show'])->name('appointments.show');
            Route::patch('/appointments/{appointment}/status', [AppointmentController::class, 'updateStatus'])->name('appointments.updateStatus');

            // Staff Account Management
            Route::post('/settings/manajemen-staff/account', [DoctorController::class, 'storeStaffAccountFromAdmin'])->name('settings.staff.account.store');
            Route::patch('/settings/manajemen-staff/account/{id}/toggle-status', [DoctorController::class, 'toggleStaffAccountStatus'])->name('settings.staff.account.toggle-status');
            Route::patch('/settings/manajemen-staff/account/{id}/doctor-link', [DoctorController::class, 'updateStaffAccountDoctorLink'])->name('settings.staff.account.doctor.link');
            Route::post('/settings/manajemen-staff/doctor', [DoctorController::class, 'storeFromAdmin'])->name('settings.staff.doctor.store');
            
            // Article Management
            Route::resource('articles', ArticleAdminController::class)->names('articles');
            
            // Pharmacy & BHP
            Route::prefix('pharmacy')->name('pharmacy.')->group(function () {    
                Route::get('/medicine', [MedicineController::class, 'index'])->name('medicine.index');
                Route::post('/medicine', [MedicineController::class, 'store'])->name('medicine.store');   
                Route::get('/medicine/{id}', [MedicineController::class, 'show'])->name('medicine.show');
                Route::put('/medicine/{id}', [MedicineController::class, 'update'])->name('medicine.update');    
                Route::delete('/medicine/{id}', [MedicineController::class, 'destroy'])->name('medicine.destroy');    
                Route::post('/medicine/{id}/stock-in', [MedicineController::class, 'stockIn'])->name('medicine.stockIn');
                Route::delete('/medicine/{medicineId}/stock-mutation/{mutationId}', [MedicineController::class, 'destroyMutation']);            
                Route::get('/penggunaan-obat', [PenggunaanObatController::class, 'index'])->name('penggunaan-obat.index');

                Route::get('/bhp/items', [ConsumableItemController::class, 'index']);    
                Route::post('/bhp/items', [ConsumableItemController::class, 'store']);    
                Route::get('/bhp/items/{id}', [ConsumableItemController::class, 'show']);    
                Route::put('/bhp/items/{id}', [ConsumableItemController::class, 'update']);    
                Route::delete('/bhp/items/{id}', [ConsumableItemController::class, 'destroy']);
                Route::get('/bhp/usage',          [ConsumableUsageController::class, 'index']);
                Route::post('/bhp/usage',         [ConsumableUsageController::class, 'store']);
                Route::get('/bhp/usage/{id}',     [ConsumableUsageController::class, 'show']);
                Route::delete('/bhp/usage/{id}',  [ConsumableUsageController::class, 'destroy']);
            });
        });
    });

    // ================= PATIENT/USER AREA =================
    Route::middleware('role:PAT')->prefix('user')->name('user.')->group(function () {
        Route::get('/dashboard', [DashboardUserController::class, 'index'])->name('dashboard');    
        Route::put('/profile/update', [DashboardUserController::class, 'updateProfile'])->name('profile.update');
        Route::get('/medical-history', [DashboardUserController::class, 'medicalHistory'])->name('medical-history');    
        Route::get('/medical-history/{appointment}', [DashboardUserController::class, 'medicalHistoryDetail']) ->name('medical-history.detail');    
        Route::get('/odontogram-history',[DashboardUserController::class, 'odontogramHistory'])->name('odontogram-history');
        Route::get('/odontogram-history/{record}',[DashboardUserController::class, 'odontogramDetail'])->name('odontogram-history.detail');
    });

    // ================= DOCTOR AREA =================
    Route::middleware('role:DCT')->prefix('doctor')->name('doctor.')->group(function () {
        Route::get('/dashboard', [DashboardDoctorController::class, 'index'])->name('dashboard');
        Route::put('/profile/update', [DashboardDoctorController::class, 'updateProfile'])->name('profile.update');
        
        // EMR & Notes for Doctor
        Route::get('/emr', [DoctorEmrController::class, 'index'])->name('emr');
        Route::get('/emr/{id}', [DoctorEmrController::class, 'show'])->name('emr.show');
        Route::post('/emr/{appointment}/doctor-note', [DoctorEmrController::class, 'storeDoctorNote'])->name('emr.storeDoctorNote');
        Route::patch('/emr/{id}/status', [DoctorEmrController::class, 'updateStatus'])->name('emr.updateStatus');
    });

});