<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenInvalidException;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * Cara pakai di routes:
     *   middleware('jwt.auth')           → semua role boleh
     *   middleware('jwt.auth:OWN,ADM')   → hanya Owner & Admin
     *   middleware('jwt.auth:DCT')        → hanya Doctor
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            if (! $user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User tidak ditemukan.',
                ], 401);
            }

            // Cek is_active (soft ban)
            if (! $user->is_active) {
                return response()->json([
                    'success' => false,
                    'message' => 'Akun Anda dinonaktifkan. Hubungi administrator.',
                ], 403);
            }

            // Cek role jika ada parameter
            // Contoh: middleware('jwt.auth:OWN,ADM')
            if (! empty($roles)) {
                $userRole = $user->role?->code;
                if (! in_array($userRole, $roles)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Akses ditolak. Anda tidak memiliki izin.',
                    ], 403);
                }
            }

        } catch (TokenExpiredException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Token sudah kadaluarsa. Silakan login kembali.',
            ], 401);

        } catch (TokenInvalidException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Token tidak valid.',
            ], 401);

        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Token tidak ditemukan. Silakan login.',
            ], 401);
        }

        return $next($request);
    }
}