<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    // ── Register ──────────────────────────────────────────────────────────────
    /**
     * POST /api/auth/register
     *
     * Body:
     *  - name                  : string, required, max 50
     *  - email                 : string, required, email, unique
     *  - password              : string, required, min 8
     *  - password_confirmation : string, required, harus sama dengan password
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

        // Default role = PAT (Patient) untuk registrasi publik
        $patientRole = Role::where('code', 'PAT')->first();

        if (! $patientRole) {
            return response()->json([
                'success' => false,
                'message' => 'Role default tidak ditemukan. Hubungi administrator.',
            ], 500);
        }

        $user = User::create([
            'role_id'  => $patientRole->id,
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->load('role');

        return response()->json([
            'success' => true,
            'message' => 'Registrasi berhasil! Silakan login.',
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

    // ── Login ─────────────────────────────────────────────────────────────────
    /**
     * POST /api/auth/login
     *
     * Body:
     *  - email    : string, required
     *  - password : string, required
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

        // Cek user exist (include soft-deleted)
        $user = User::withTrashed()->where('email', $request->email)->first();

        if (! $user) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau password salah.',
            ], 401);
        }

        // Cek akun soft deleted
        if ($user->deleted_at !== null) {
            return response()->json([
                'success' => false,
                'message' => 'Akun ini telah dihapus. Hubungi administrator.',
            ], 403);
        }

        // Cek akun dinonaktifkan (soft ban)
        if (! $user->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Akun Anda dinonaktifkan. Hubungi administrator.',
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

        // Update last_login_at
        $user->update(['last_login_at' => now()]);
        $user->load('role');

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil.',
            'data'    => [
                'token'      => $token,
                'token_type' => 'bearer',
                'expires_in' => config('jwt.ttl') * 60, // dalam detik
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