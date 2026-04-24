<?php

namespace App\Http\Controllers;

use App\Mail\VerifyEmailMail;
use App\Models\Patient;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;

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

    public function showDoctorLogin()
    {
        return view('doctor.pages.login');
    }

    public function showDokterLogin()
    {
        return view('dokter.pages.login');
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
    public function showDoctorForgotPassword()
    {
        return view('doctor.pages.forgot-password');
    }

    public function sendDoctorResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        
        // Validasi: Pastikan email terdaftar dan memiliki role DCT (Doctor)
        $user = User::with('role')->where('email', $request->email)->first();
        if (!$user || $user->role?->code !== 'DCT') {
            return back()->withErrors(['email' => 'Email tidak ditemukan atau bukan akun dokter.']);
        }

        $status = Password::broker()->sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => 'Link reset password telah dikirim ke email Anda.'])
            : back()->withErrors(['email' => 'Gagal mengirim link reset password.']);
    }

    public function showDoctorResetPassword(Request $request, $token)
    {
        return view('doctor.pages.reset-password', ['token' => $token, 'email' => $request->email]);
    }

    public function doctorResetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::broker()->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill(['password' => Hash::make($password)])->setRememberToken(Str::random(60));
                $user->save();
                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('doctor.login')->with('status', 'Password berhasil diperbarui! Silakan login.')
            : back()->withErrors(['email' => 'Token tidak valid atau sudah kadaluwarsa.']);
    }

    // ── ADMIN LOGIN ───────────────────────────────────────────

    public function adminLogin(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        $adminUser = User::with('role')
            ->where('email', $credentials['email'])
            ->first();

        // Prevent non-admin accounts from attempting admin authentication.
        if (! $adminUser || $adminUser->role?->code !== 'ADM') {
            return back()->withErrors([
                'email' => 'Akun ini bukan akun admin.',
            ])->onlyInput('email');
        }

        if (! $adminUser->is_active) {
            return back()->withErrors([
                'email' => 'Akun telah dinonaktifkan.',
            ])->onlyInput('email');
        }

        $attempted = $this->attemptWithLegacyFallback(
            $credentials['email'],
            $credentials['password'],
            'ADM',
            $request->boolean('remember')
        );

        if ($attempted) {
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
            'name'          => ['required', 'string', 'max:255'],
            'email'         => ['required', 'email', 'max:255', 'unique:user,email'],
            'password'      => ['required', 'string', 'min:8', 'confirmed'],
            'date_of_birth' => ['required', 'date', 'before:today'],
            'gender'        => ['required', 'in:Male,Female'],
            'phone_number'  => ['required', 'string', 'max:20'],
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

        $verificationToken = Str::random(64);

        $user = DB::transaction(function () use ($validated, $userRole, $verificationToken) {
            $user = User::create([
                'id'                       => (string) Str::uuid(),
                'role_id'                  => $userRole->id,
                'name'                     => $validated['name'],
                'email'                    => $validated['email'],
                'password'                 => Hash::make($validated['password']),
                'is_active'                => true,
                'is_verified'              => false,
                'email_verification_token' => $verificationToken,
            ]);

            Patient::create([
                'id'                => (string) Str::ulid(),
                'user_id'           => $user->id,
                'full_name'         => $validated['name'],
                'email'             => $validated['email'],
                'medical_record_no' => $this->generateMedicalRecordNumber(),
                'date_of_birth'     => $validated['date_of_birth'],
                'gender'            => $validated['gender'],
                'phone_number'      => $validated['phone_number'],
            ]);

            return $user;
        });

        try {
            $verificationUrl = url('/api/auth/verify/' . $verificationToken);
            Mail::to($user->email)->send(new VerifyEmailMail($verificationUrl, $user->name));
        } catch (\Exception $e) {
            Log::warning('Failed to send verification email after web registration.', [
                'user_id' => $user->id,
                'email' => $user->email,
                'message' => $e->getMessage(),
            ]);
        }

        Auth::login($user);
        $request->session()->regenerate();

        return redirect('/user/dashboard')->with('success', 'Registrasi berhasil. Data pasien sudah terhubung, dan email verifikasi telah dikirim.');
    }

    private function generateMedicalRecordNumber(): string
    {
        do {
            $number = 'MR' . str_pad((string) random_int(1, 999999), 6, '0', STR_PAD_LEFT);
        } while (Patient::where('medical_record_no', $number)->exists());

        return $number;
    }

    // ── LOGOUT ────────────────────────────────────────────────

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    // ── GOOGLE OAUTH ──────────────────────────────────────────

    public function redirectToGoogle()
    {
        session()->save();
        return Socialite::driver('google')->stateless()->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            Log::info('Memulai Socialite Google callback');
            $googleUser = Socialite::driver('google')->stateless()->user();
            Log::info('Data Google User berhasil didapat', ['email' => $googleUser->getEmail()]);

            // 1. Cari berdasarkan google_id
            $user = User::where('google_id', $googleUser->getId())->first();

            if ($user) {
                Log::info('User ditemukan berdasarkan google_id', ['id' => $user->id]);
                return $this->loginSocialUser($user);
            }

            // 2. Cari berdasarkan email (jika google_id tidak ada)
            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                Log::info('User ditemukan berdasarkan email, melakukan linking...', ['id' => $user->id]);
                $user->update([
                    'google_id'   => $googleUser->getId(),
                    'avatar_url'  => $user->avatar_url ?? $googleUser->getAvatar(),
                    'is_verified' => true,
                ]);
                return $this->loginSocialUser($user);
            }

            // 3. User baru -> Registrasi otomatis sebagai Pasien
            Log::info('Mendaftarkan user baru via Google');
            $userRole = Role::where('code', 'PAT')->first();
            if (! $userRole) {
                Log::info('Role PAT belum ada, membuat baru...');
                $userRole = Role::create([
                    'code' => 'PAT',
                    'name' => 'Patient',
                    'permissions' => null,
                    'created_at' => now(),
                ]);
            }

            $user = DB::transaction(function () use ($googleUser, $userRole) {
                $newUser = User::create([
                    'id'          => (string) \Illuminate\Support\Str::uuid(),
                    'role_id'     => $userRole->id,
                    'name'        => $googleUser->getName(),
                    'email'       => $googleUser->getEmail(),
                    'google_id'   => $googleUser->getId(),
                    'social_type' => 'google',
                    'avatar_url'  => $googleUser->getAvatar(),
                    'is_active'   => true,
                    'is_verified' => true,
                ]);

                Patient::create([
                    'id'                => (string) \Illuminate\Support\Str::ulid(),
                    'user_id'           => $newUser->id,
                    'full_name'         => $googleUser->getName(),
                    'email'             => $googleUser->getEmail(),
                    'medical_record_no' => $this->generateMedicalRecordNumber(),
                    'date_of_birth'     => '1900-01-01',
                    'gender'            => 'Male', 
                ]);

                return $newUser;
            });

            Log::info('Registrasi user baru berhasil', ['id' => $user->id]);
            return $this->loginSocialUser($user);

        } catch (\Exception $e) {
            Log::error('Gagal saat proses login/callback Google: ' . $e->getMessage(), [
                'exception' => $e,
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            
            $errorMsg = empty($e->getMessage()) ? get_class($e) : $e->getMessage();
            return redirect('/login')->withErrors(['email' => 'Gagal login via Google. Error detail: ' . $errorMsg]);
        }
    }

    private function loginSocialUser($user)
    {
        if (! $user->is_active) {
            return redirect('/login')->withErrors(['email' => 'Akun Anda telah dinonaktifkan.']);
        }

        Auth::login($user);
        request()->session()->regenerate();

        return redirect()->intended('/user/dashboard');
    }

    /**
     * Try normal Auth::attempt first. If legacy plain-text passwords exist,
     * verify once, upgrade to bcrypt, and login the user.
     */
    private function attemptWithLegacyFallback(string $email, string $plainPassword, string $expectedRoleCode, bool $remember): bool
    {
        try {
            if (Auth::attempt(['email' => $email, 'password' => $plainPassword, 'is_active' => true], $remember)) {
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
            ->where('is_active', true)
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
