<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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

    // ── USER LOGIN ────────────────────────────────────────────

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            // Kalau yang login ternyata admin, tolak
            if (Auth::user()->role === 'admin') {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Akun admin harus login lewat halaman admin.',
                ])->onlyInput('email');
            }

            $request->session()->regenerate();
            return redirect()->intended('/user/dashboard');
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

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            // Kalau yang login ternyata bukan admin, tolak
            if (Auth::user()->role !== 'admin') {
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
}
