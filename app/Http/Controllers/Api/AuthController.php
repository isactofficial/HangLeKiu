<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use App\Mail\VerifyEmailMail;

class AuthController extends Controller
{
    // ── Register ──────────────────────────────────────────────────────────────
    /**
     * POST /api/auth/register
     */
    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name'                  => 'required|string|max:50',
            'email'                 => 'required|email|max:50|unique:user,email',
            'password'              => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string',
        ], [
            'name.required'      => 'Nama lengkap wajib diisi.',
            'name.max'           => 'Nama maksimal 50 karakter.',
            'email.required'     => 'Email wajib diisi.',
            'email.email'        => 'Format email tidak valid.',
            'email.unique'       => 'Email sudah terdaftar.',
            'password.required'  => 'Password wajib diisi.',
            'password.min'       => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $patientRole = Role::where('code', 'PAT')->first();

        if (! $patientRole) {
            return response()->json([
                'success' => false,
                'message' => 'Role default tidak ditemukan. Hubungi administrator.',
            ], 500);
        }

        $user = User::create([
            'role_id'                  => $patientRole->id,
            'name'                     => $request->name,
            'email'                    => $request->email,
            'password'                 => Hash::make($request->password),
            'email_verification_token' => Str::random(64),
        ]);

        // Kirim email verifikasi
        try {
            $verificationUrl = url('/api/auth/verify/' . $user->email_verification_token);
            Mail::to($user->email)->send(new VerifyEmailMail($verificationUrl, $user->name));
        } catch (\Exception $e) {
            // Tetap return sukses walau email gagal, tapi beri tahu user
            $user->load('role');
            return response()->json([
                'success' => true,
                'message' => 'Registrasi berhasil, namun email verifikasi gagal dikirim. Hubungi administrator.',
                'data'    => [
                    'id'          => $user->id,
                    'name'        => $user->name,
                    'email'       => $user->email,
                    'role'        => $user->role->code,
                    'is_verified' => $user->is_verified,
                    'created_at'  => $user->created_at,
                ],
            ], 201);
        }

        $user->load('role');

        return response()->json([
            'success' => true,
            'message' => 'Registrasi berhasil! Cek email kamu untuk verifikasi.',
            'data'    => [
                'id'          => $user->id,
                'name'        => $user->name,
                'email'       => $user->email,
                'role'        => $user->role->code,
                'is_verified' => $user->is_verified,
                'created_at'  => $user->created_at,
            ],
        ], 201);
    }

    // ── Verify Email ──────────────────────────────────────────────────────────
    /**
     * GET /api/auth/verify/{token}
     */
    public function verifyEmail(string $token): JsonResponse
    {
        $user = User::where('email_verification_token', $token)->first();

        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'Token verifikasi tidak valid atau sudah digunakan.',
            ], 400);
        }

        $user->update([
            'is_verified'              => true,
            'email_verification_token' => null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Email berhasil diverifikasi! Silakan login.',
        ]);
    }

    // ── Resend Verification Email ─────────────────────────────────────────────
    /**
     * POST /api/auth/resend-verification
     * Body: email
     */
    public function resendVerification(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email'    => 'Format email tidak valid.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $user = User::where('email', $request->email)->first();

        // Selalu return sukses agar tidak bocorkan info email terdaftar atau tidak
        if (! $user || $user->is_verified) {
            return response()->json([
                'success' => true,
                'message' => 'Jika email terdaftar dan belum diverifikasi, link verifikasi telah dikirim.',
            ]);
        }

        // Generate token baru
        $user->update([
            'email_verification_token' => Str::random(64),
        ]);

        try {
            $verificationUrl = url('/api/auth/verify/' . $user->email_verification_token);
            Mail::to($user->email)->send(new VerifyEmailMail($verificationUrl, $user->name));
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengirim email. Coba lagi.',
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Jika email terdaftar dan belum diverifikasi, link verifikasi telah dikirim.',
        ]);
    }

    // ── Login ─────────────────────────────────────────────────────────────────
    /**
     * POST /api/auth/login
     */
    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required|string',
        ], [
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $user = User::withTrashed()->where('email', $request->email)->first();

        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau password salah.',
            ], 401);
        }

        if ($user->deleted_at !== null) {
            return response()->json([
                'success' => false,
                'message' => 'Akun ini telah dihapus. Hubungi administrator.',
            ], 403);
        }

        if (! $user->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Akun Anda dinonaktifkan. Hubungi administrator.',
            ], 403);
        }

        // Cek email sudah diverifikasi
        if (! $user->is_verified) {
            return response()->json([
                'success' => false,
                'message' => 'Email belum diverifikasi. Cek inbox email kamu.',
                'action'  => 'resend_verification', // hint untuk frontend
            ], 403);
        }

        try {
            $credentials = $request->only('email', 'password');

            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email atau password salah.',
                ], 401);
            }
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat token. Coba lagi.',
            ], 500);
        }

        $user->update(['last_login_at' => now()]);
        $user->load('role');

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil.',
            'data'    => [
                'token'      => $token,
                'token_type' => 'bearer',
                'expires_in' => config('jwt.ttl') * 60,
                'user'       => [
                    'id'            => $user->id,
                    'name'          => $user->name,
                    'email'         => $user->email,
                    'role'          => $user->role->code,
                    'role_name'     => $user->role->name,
                    'avatar_url'    => $user->avatar_url,
                    'is_verified'   => $user->is_verified,
                    'last_login_at' => $user->last_login_at,
                ],
            ],
        ]);
    }

    // ── Login with Google (Mobile) ────────────────────────────────────────────
    /**
     * POST /api/auth/google/login
     */
    public function loginWithGoogle(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'google_id' => 'required',
            'email'     => 'required|email',
            'name'      => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors'  => $validator->errors(),
            ], 422);
        }

        // 1. Cari berdasarkan google_id
        $user = User::where('google_id', $request->google_id)->first();

        // 2. Jika tidak ada, cari berdasarkan email
        if (! $user) {
            $user = User::where('email', $request->email)->first();

            if ($user) {
                // Link akun yang sudah ada
                $user->update([
                    'google_id'   => $request->google_id,
                    'is_verified' => true,
                ]);
            } else {
                // 3. Registrasi baru (Role PAT)
                $patientRole = Role::where('code', 'PAT')->first();
                if (! $patientRole) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Role default tidak ditemukan.',
                    ], 500);
                }

                $user = User::create([
                    'id'          => (string) Str::uuid(),
                    'role_id'     => $patientRole->id,
                    'name'        => $request->name,
                    'email'       => $request->email,
                    'google_id'   => $request->google_id,
                    'social_type' => 'google',
                    'avatar_url'  => $request->avatar_url,
                    'is_active'   => true,
                    'is_verified' => true,
                ]);

                // Buat record Patient juga
                \App\Models\Patient::create([
                    'id'                => (string) Str::ulid(),
                    'user_id'           => $user->id,
                    'full_name'         => $user->name,
                    'email'             => $user->email,
                    'medical_record_no' => $this->generateMedicalRecordNumberApi(),
                    'date_of_birth'     => '1900-01-01', // Default value
                    'gender'            => 'Male',
                ]);
            }
        }

        if (! $user->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Akun dinonaktifkan.',
            ], 403);
        }

        // Login sukes -> Return JWT
        try {
            if (! $token = JWTAuth::fromUser($user)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email atau password salah.',
                ], 401);
            }
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat token.',
            ], 500);
        }

        $user->update(['last_login_at' => now()]);
        $user->load('role');

        return response()->json([
            'success' => true,
            'message' => 'Login Google berhasil.',
            'data'    => [
                'token'      => $token,
                'token_type' => 'bearer',
                'expires_in' => config('jwt.ttl') * 60,
                'user'       => [
                    'id'            => $user->id,
                    'name'          => $user->name,
                    'email'         => $user->email,
                    'role'          => $user->role->code,
                    'role_name'     => $user->role->name,
                    'avatar_url'    => $user->avatar_url,
                    'is_verified'   => $user->is_verified,
                    'last_login_at' => $user->last_login_at,
                ],
            ],
        ]);
    }

    private function generateMedicalRecordNumberApi(): string
    {
        do {
            $number = 'MR' . str_pad((string) random_int(1, 999999), 6, '0', STR_PAD_LEFT);
        } while (\App\Models\Patient::where('medical_record_no', $number)->exists());

        return $number;
    }

    // ── Logout ────────────────────────────────────────────────────────────────
    /**
     * POST /api/auth/logout
     * Header: Authorization: Bearer {token}
     */
    public function logout(): JsonResponse
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());

            return response()->json([
                'success' => true,
                'message' => 'Logout berhasil.',
            ]);
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal logout. Token tidak valid.',
            ], 400);
        }
    }

    // ── Refresh Token ─────────────────────────────────────────────────────────
    /**
     * POST /api/auth/refresh
     * Header: Authorization: Bearer {token}
     */
    public function refresh(): JsonResponse
    {
        try {
            $newToken = JWTAuth::refresh(JWTAuth::getToken());

            return response()->json([
                'success'    => true,
                'message'    => 'Token berhasil diperbarui.',
                'token'      => $newToken,
                'token_type' => 'bearer',
                'expires_in' => config('jwt.ttl') * 60,
            ]);
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Token tidak valid atau sudah kadaluarsa.',
            ], 401);
        }
    }

    // ── Me (Profile) ──────────────────────────────────────────────────────────
    /**
     * GET /api/auth/me
     * Header: Authorization: Bearer {token}
     */
    public function me(): JsonResponse
    {
        $user = Auth::user();
        $user->load('role');

        return response()->json([
            'success' => true,
            'data'    => [
                'id'            => $user->id,
                'name'          => $user->name,
                'email'         => $user->email,
                'role'          => $user->role->code,
                'role_name'     => $user->role->name,
                'avatar_url'    => $user->avatar_url,
                'is_active'     => $user->is_active,
                'is_verified'   => $user->is_verified,
                'last_login_at' => $user->last_login_at,
                'created_at'    => $user->created_at,
            ],
        ]);
    }
}