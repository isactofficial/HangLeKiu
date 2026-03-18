<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes — HDS Auth
|--------------------------------------------------------------------------
*/

Route::prefix('auth')->group(function () {

    // ── Public (tanpa token) ──────────────────────────
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login',    [AuthController::class, 'login']);

    // ── Protected (butuh token JWT) ───────────────────
    Route::middleware('jwt.auth')->group(function () {
        Route::post('/logout',  [AuthController::class, 'logout']);
        Route::post('/refresh', [AuthController::class, 'refresh']);
        Route::get('/me',       [AuthController::class, 'me']);
    });
});

/*
|--------------------------------------------------------------------------
| Contoh penggunaan role-based di routes lain:
|--------------------------------------------------------------------------
|
| // Hanya Owner & Admin
| Route::middleware('jwt.auth:OWN,ADM')->group(function () {
|     Route::get('/dashboard', ...);
| });
|
| // Hanya Doctor
| Route::middleware('jwt.auth:DCT')->group(function () {
|     Route::post('/procedure', ...);
| });
|
| // Semua yang sudah login
| Route::middleware('jwt.auth')->group(function () {
|     Route::get('/profile', ...);
| });
|
*/