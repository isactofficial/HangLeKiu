<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    // ── SHOW VIEWS ────────────────────────────────────────────

    public function showLogin()
    {
        return view('user.pages.login');
    }

    public function showRegister()
    {
        return view('user.pages.register');
    }

    public function showAdminLogin()
    {
        return view('admin.pages.admin-login');
    }

    public function showAdminRegister()
    {
        return view('admin.pages.admin-register');
    }

    public function showDoctorLogin()
    {
        return view('doctor.pages.login');
    }

    // ── USER LOGIN ────────────────────────────────────────────

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        $attempted = $this->attemptWithLegacyFallback(
            $credentials['email'],
            $credentials['password'],
            'PAT',
            $request->boolean('remember')
        );

        if ($attempted) {
            // Halaman login user hanya untuk role PAT.
            $roleCode = Auth::user()->role?->code;

            if ($roleCode === 'ADM') {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Akun admin harus login lewat halaman admin.',
                ])->onlyInput('email');
            }

            if ($roleCode === 'DCT') {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Akun dokter harus login lewat halaman dokter.',
                ])->onlyInput('email');
            }

            if ($roleCode !== 'PAT') {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Akun ini bukan akun user.',
                ])->onlyInput('email');
            }

            $request->session()->regenerate();
            return redirect()->intended('/user/dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    // ── DOCTOR LOGIN ───────────────────────────────────────

    public function doctorLogin(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        $attempted = $this->attemptWithLegacyFallback(
            $credentials['email'],
            $credentials['password'],
            'DCT',
            $request->boolean('remember')
        );

        if ($attempted) {
            if (Auth::user()->role?->code !== 'DCT') {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Akun ini bukan akun dokter.',
                ])->onlyInput('email');
            }

            $request->session()->regenerate();
            return redirect()->intended(route('doctor.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    // ── ADMIN LOGIN ───────────────────────────────────────────

    public function adminLogin(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        $attempted = $this->attemptWithLegacyFallback(
            $credentials['email'],
            $credentials['password'],
            'ADM',
            $request->boolean('remember')
        );

        if ($attempted) {
            // Kalau yang login ternyata bukan admin, tolak
            if (Auth::user()->role?->code !== 'ADM') {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Akun ini bukan akun admin.',
                ])->onlyInput('email');
            }

            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    // ── USER REGISTER ─────────────────────────────────────────

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:user,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $userRole = Role::where('code', 'PAT')->first();

        if (! $userRole) {
            $userRole = Role::create([
                'id' => (string) Str::uuid(),
                'code' => 'PAT',
                'name' => 'Patient',
                'permissions' => null,
                'created_at' => now(),
            ]);
        }

        $user = User::create([
            'id' => (string) Str::uuid(),
            'role_id' => $userRole->id,
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'is_active' => true,
            'is_verified' => false,
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect('/user/dashboard');
    }

    // ── ADMIN REGISTER ────────────────────────────────────────

    public function adminRegister(Request $request)
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:user,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $adminRole = Role::where('code', 'ADM')->first();

        if (! $adminRole) {
            $adminRole = Role::create([
                'id' => (string) Str::uuid(),
                'code' => 'ADM',
                'name' => 'Admin',
                'permissions' => null,
                'created_at' => now(),
            ]);
        }

        $user = User::create([
            'id' => (string) Str::uuid(),
            'role_id' => $adminRole->id,
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'is_active' => true,
            'is_verified' => true,
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect(route('admin.dashboard'));
    }

    // ── LOGOUT ────────────────────────────────────────────────

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * Try normal Auth::attempt first. If legacy plain-text passwords exist,
     * verify once, upgrade to bcrypt, and login the user.
     */
    private function attemptWithLegacyFallback(string $email, string $plainPassword, string $expectedRoleCode, bool $remember): bool
    {
        try {
            if (Auth::attempt(['email' => $email, 'password' => $plainPassword], $remember)) {
                return true;
            }
        } catch (\RuntimeException $e) {
            Log::warning('Password hash algorithm mismatch during login.', [
                'email' => $email,
                'expected_role' => $expectedRoleCode,
                'message' => $e->getMessage(),
            ]);
        }

        $legacyUser = User::with('role')
            ->where('email', $email)
            ->first();

        if (! $legacyUser || $legacyUser->role?->code !== $expectedRoleCode) {
            return false;
        }

        if (! is_string($legacyUser->password) || $legacyUser->password === '') {
            return false;
        }

        $storedPassword = $legacyUser->password;
        $passwordInfo = password_get_info($storedPassword);
        $isLegacyHash = ($passwordInfo['algo'] ?? null) !== null;

        $verified = $isLegacyHash
            ? password_verify($plainPassword, $storedPassword)
            : hash_equals($storedPassword, $plainPassword);

        if (! $verified) {
            return false;
        }

        $legacyUser->password = Hash::make($plainPassword);
        $legacyUser->save();

        Auth::login($legacyUser, $remember);

        return true;
    }
}
