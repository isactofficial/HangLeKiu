<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\DoctorSchedule;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class DoctorController extends Controller
{
    public function storeFromAdmin(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:100',
            'email' => 'required|email|max:50|unique:user,email',
            'password' => 'required|string|min:8|confirmed',
            'foto_profil' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'ttd' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'estimasi_konsultasi' => 'nullable|integer|min:1|max:600',
            'phone_number' => 'nullable|string|max:20',
            'title_prefix' => 'nullable|string|max:50',
            'license_no' => 'nullable|string|max:50',
            'str_institution' => 'nullable|string|max:50',
            'str_number' => 'nullable|string|max:50',
            'str_expiry_date' => 'nullable|date',
            'sip_institution' => 'nullable|string|max:50',
            'sip_number' => 'nullable|string|max:50',
            'sip_expiry_date' => 'nullable|date',
            'specialization' => 'nullable|string|max:100',
            'subspecialization' => 'nullable|string|max:100',
            'job_title' => 'nullable|string|max:50',
            'is_active' => 'nullable|boolean',
            'schedules' => 'nullable|array',
            'schedules.*.is_active' => 'nullable|in:0,1,true,false',
            'schedules.*.start_time' => 'nullable|date_format:H:i',
            'schedules.*.end_time' => 'nullable|date_format:H:i',
        ]);

        try {
            $this->createDoctorUserAndProfile($validated, $request);

            return redirect()
                ->route('admin.settings', ['menu' => 'info-tenaga-medis'])
                ->with('success', 'Akun dokter berhasil dibuat.');
        } catch (\RuntimeException $e) {
            return redirect()
                ->route('admin.settings', ['menu' => 'info-tenaga-medis'])
                ->withErrors(['doctor_create' => $e->getMessage()])
                ->withInput();
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.settings', ['menu' => 'info-tenaga-medis'])
                ->withErrors(['doctor_create' => 'Gagal membuat akun dokter.'])
                ->withInput();
        }
    }

    public function store(Request $request): JsonResponse
    {
        if (! Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated',
            ], 401);
        }

        if ($this->getCurrentRoleCode() !== 'ADM') {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki akses untuk membuat akun dokter',
            ], 403);
        }

        $validated = $request->validate([
            'full_name' => 'required|string|max:100',
            'email' => 'required|email|max:50|unique:user,email',
            'password' => 'required|string|min:8',
            'foto_profil' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'ttd' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'estimasi_konsultasi' => 'nullable|integer|min:1|max:600',
            'phone_number' => 'nullable|string|max:20',
            'title_prefix' => 'nullable|string|max:50',
            'license_no' => 'nullable|string|max:50',
            'str_institution' => 'nullable|string|max:50',
            'str_number' => 'nullable|string|max:50',
            'str_expiry_date' => 'nullable|date',
            'sip_institution' => 'nullable|string|max:50',
            'sip_number' => 'nullable|string|max:50',
            'sip_expiry_date' => 'nullable|date',
            'specialization' => 'nullable|string|max:100',
            'subspecialization' => 'nullable|string|max:100',
            'job_title' => 'nullable|string|max:50',
            'is_active' => 'nullable|boolean',
            'schedules' => 'nullable|array',
            'schedules.*.is_active' => 'nullable|in:0,1,true,false',
            'schedules.*.start_time' => 'nullable|date_format:H:i',
            'schedules.*.end_time' => 'nullable|date_format:H:i',
        ]);

        try {
            $result = $this->createDoctorUserAndProfile($validated, $request);

            return response()->json([
                'success' => true,
                'message' => 'User dokter dan data dokter berhasil dibuat',
                'data' => $result,
            ], 201);
        } catch (\RuntimeException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat user dokter',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function index(): JsonResponse
    {
        $doctors = Doctor::orderByDesc('created_at')->get();

        return response()->json([
            'success' => true,
            'message' => 'Data dokter berhasil diambil',
            'data' => $doctors,
            'count' => $doctors->count(),
        ], 200);
    }

    public function show(string $id): JsonResponse
    {
        $doctor = Doctor::find($id);

        if (! $doctor) {
            return response()->json([
                'success' => false,
                'message' => 'Data dokter tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data dokter berhasil diambil',
            'data' => $doctor,
        ], 200);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $doctor = Doctor::find($id);

        if (! $doctor) {
            return response()->json([
                'success' => false,
                'message' => 'Data dokter tidak ditemukan',
            ], 404);
        }

        $authResponse = $this->authorizeDoctorWrite($doctor);
        if ($authResponse) {
            return $authResponse;
        }

        $emailRule = Rule::unique('user', 'email');

        if ($doctor->user_id) {
            $emailRule = $emailRule->ignore($doctor->user_id, 'id');
        }

        $validated = $request->validate([
            'full_name' => 'sometimes|required|string|max:100',
            'email' => ['sometimes', 'required', 'email', 'max:50', $emailRule],
            'password' => 'sometimes|nullable|string|min:8',
            'foto_profil' => 'sometimes|nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'ttd' => 'sometimes|nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'estimasi_konsultasi' => 'sometimes|nullable|integer|min:1|max:600',
            'phone_number' => 'sometimes|nullable|string|max:20',
            'title_prefix' => 'sometimes|nullable|string|max:50',
            'license_no' => 'sometimes|nullable|string|max:50',
            'str_institution' => 'sometimes|nullable|string|max:50',
            'str_number' => 'sometimes|nullable|string|max:50',
            'str_expiry_date' => 'sometimes|nullable|date',
            'sip_institution' => 'sometimes|nullable|string|max:50',
            'sip_number' => 'sometimes|nullable|string|max:50',
            'sip_expiry_date' => 'sometimes|nullable|date',
            'specialization' => 'sometimes|nullable|string|max:100',
            'subspecialization' => 'sometimes|nullable|string|max:100',
            'job_title' => 'sometimes|nullable|string|max:50',
            'is_active' => 'sometimes|boolean',
            'schedules' => 'sometimes|array',
            'schedules.*.is_active' => 'nullable|in:0,1,true,false',
            'schedules.*.start_time' => 'nullable|date_format:H:i',
            'schedules.*.end_time' => 'nullable|date_format:H:i',
        ]);

        try {
            $schedulePayload = null;
            if (array_key_exists('schedules', $validated)) {
                $schedulePayload = $this->normalizeSchedules($validated['schedules'] ?? []);
            }

            $result = DB::transaction(function () use ($doctor, $validated, $request, $schedulePayload) {
                $user = null;
                if ($doctor->user_id) {
                    $user = User::find($doctor->user_id);
                }

                if ($user) {
                    $userPayload = [];
                    if (array_key_exists('full_name', $validated)) {
                        $userPayload['name'] = $validated['full_name'];
                    }
                    if (array_key_exists('email', $validated)) {
                        $userPayload['email'] = $validated['email'];
                    }
                    if (array_key_exists('password', $validated) && ! empty($validated['password'])) {
                        $userPayload['password'] = Hash::make($validated['password']);
                    }

                    if (! empty($userPayload)) {
                        $user->update($userPayload);
                    }
                }

                $doctorPayload = $validated;
                unset($doctorPayload['password']);
                unset($doctorPayload['schedules']);
                unset($doctorPayload['foto_profil']);
                unset($doctorPayload['ttd']);

                if (array_key_exists('estimasi_konsultasi', $doctorPayload) && $doctorPayload['estimasi_konsultasi'] === '') {
                    $doctorPayload['estimasi_konsultasi'] = null;
                }

                if ($request->hasFile('foto_profil')) {
                    $doctorPayload['foto_profil'] = $this->storeProfilePhoto($request, $doctor->foto_profil);
                }

                if ($request->hasFile('ttd')) {
                    $doctorPayload['ttd'] = $this->storeSignature($request, $doctor->ttd);
                }

                $doctor->update($doctorPayload);

                if (is_array($schedulePayload)) {
                    $this->syncDoctorSchedules($doctor, $schedulePayload);
                }

                $doctor->refresh();
                if ($user) {
                    $user->refresh();
                }

                return [
                    'user' => $user,
                    'doctor' => $doctor,
                ];
            });

            return response()->json([
                'success' => true,
                'message' => 'Data dokter berhasil diperbarui',
                'data' => $result,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui data dokter',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(string $id): JsonResponse
    {
        $doctor = Doctor::find($id);

        if (! $doctor) {
            return response()->json([
                'success' => false,
                'message' => 'Data dokter tidak ditemukan',
            ], 404);
        }

        $authResponse = $this->authorizeDoctorWrite($doctor);
        if ($authResponse) {
            return $authResponse;
        }

        try {
            DB::transaction(function () use ($doctor) {
                if ($doctor->user_id) {
                    $user = User::find($doctor->user_id);
                    if ($user) {
                        $user->delete();
                    }
                }

                $doctor->delete();
            });

            return response()->json([
                'success' => true,
                'message' => 'Data dokter berhasil dihapus',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data dokter',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    private function authorizeDoctorWrite(Doctor $doctor): ?JsonResponse
    {
        if (! Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated',
            ], 401);
        }

        $currentUser = Auth::user();
        $roleCode = $this->getCurrentRoleCode();

        if ($roleCode === 'ADM') {
            return null;
        }

        if ($roleCode === 'DCT' && (string) $currentUser->id === (string) $doctor->user_id) {
            return null;
        }

        return response()->json([
            'success' => false,
            'message' => 'Anda tidak memiliki akses untuk mengubah data dokter ini',
        ], 403);
    }

    private function getCurrentRoleCode(): ?string
    {
        $role = Auth::user()?->role;

        if (is_object($role) && isset($role->code)) {
            return (string) $role->code;
        }

        if (is_string($role)) {
            $role = strtoupper($role);
            if (in_array($role, ['ADM', 'DCT', 'PAT', 'ADMIN', 'DOCTOR', 'PATIENT'], true)) {
                return match ($role) {
                    'ADMIN' => 'ADM',
                    'DOCTOR' => 'DCT',
                    'PATIENT' => 'PAT',
                    default => $role,
                };
            }
        }

        return null;
    }

    /**
     * Shared creator used by API and admin settings form.
     *
     * @throws \RuntimeException
     */
    private function createDoctorUserAndProfile(array $validated, Request $request): array
    {
        $roleDoctor = Role::where('code', 'DCT')->first();

        if (! $roleDoctor) {
            throw new \RuntimeException('Role DCT tidak ditemukan. Jalankan seeder terlebih dahulu.');
        }

        $schedulePayload = $this->normalizeSchedules($validated['schedules'] ?? []);

        return DB::transaction(function () use ($validated, $roleDoctor, $request, $schedulePayload) {
            $user = User::create([
                'id' => (string) Str::uuid(),
                'role_id' => $roleDoctor->id,
                'name' => $validated['full_name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'is_active' => true,
                'is_verified' => true,
            ]);

            $doctor = Doctor::create([
                'id' => (string) Str::uuid(),
                'user_id' => $user->id,
                'full_name' => $validated['full_name'],
                'email' => $validated['email'],
                'foto_profil' => $request->hasFile('foto_profil') ? $this->storeProfilePhoto($request) : null,
                'ttd' => $request->hasFile('ttd') ? $this->storeSignature($request) : null,
                'estimasi_konsultasi' => $validated['estimasi_konsultasi'] ?? null,
                'phone_number' => $validated['phone_number'] ?? null,
                'title_prefix' => $validated['title_prefix'] ?? null,
                'license_no' => $validated['license_no'] ?? null,
                'str_institution' => $validated['str_institution'] ?? null,
                'str_number' => $validated['str_number'] ?? null,
                'str_expiry_date' => $validated['str_expiry_date'] ?? null,
                'sip_institution' => $validated['sip_institution'] ?? null,
                'sip_number' => $validated['sip_number'] ?? null,
                'sip_expiry_date' => $validated['sip_expiry_date'] ?? null,
                'specialization' => $validated['specialization'] ?? null,
                'subspecialization' => $validated['subspecialization'] ?? null,
                'job_title' => $validated['job_title'] ?? null,
                'is_active' => $validated['is_active'] ?? true,
            ]);

            $this->syncDoctorSchedules($doctor, $schedulePayload);

            return [
                'user' => $user,
                'doctor' => $doctor,
            ];
        });
    }

    private function storeProfilePhoto(Request $request, ?string $oldPath = null): string
    {
        $newPath = $request->file('foto_profil')->store('doctor_profiles', 'public');

        if ($oldPath) {
            Storage::disk('public')->delete($oldPath);
        }

        return $newPath;
    }

    private function storeSignature(Request $request, ?string $oldPath = null): string
    {
        $newPath = $request->file('ttd')->store('doctor_signatures', 'public');

        if ($oldPath) {
            Storage::disk('public')->delete($oldPath);
        }

        return $newPath;
    }

    private function normalizeSchedules(?array $schedules): array
    {
        $allowedDays = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
        $normalized = [];

        if (! is_array($schedules)) {
            return $normalized;
        }

        foreach ($allowedDays as $day) {
            $row = $schedules[$day] ?? null;

            if (! is_array($row)) {
                continue;
            }

            $isActive = in_array((string) ($row['is_active'] ?? '0'), ['1', 'true'], true);
            $startTime = trim((string) ($row['start_time'] ?? ''));
            $endTime = trim((string) ($row['end_time'] ?? ''));

            if (! $isActive && $startTime === '' && $endTime === '') {
                continue;
            }

            if ($startTime === '' || $endTime === '') {
                throw new \RuntimeException("Jadwal {$day} harus diisi jam mulai dan jam selesai.");
            }

            if (strtotime($endTime) <= strtotime($startTime)) {
                throw new \RuntimeException("Jam selesai jadwal {$day} harus lebih besar dari jam mulai.");
            }

            $normalized[] = [
                'day' => $day,
                'start_time' => $startTime,
                'end_time' => $endTime,
                'is_active' => $isActive,
            ];
        }

        return $normalized;
    }

    private function syncDoctorSchedules(Doctor $doctor, array $schedules): void
    {
        DoctorSchedule::where('doctor_id', $doctor->id)->delete();

        foreach ($schedules as $schedule) {
            DoctorSchedule::create([
                'id' => (string) Str::uuid(),
                'doctor_id' => $doctor->id,
                'day' => $schedule['day'],
                'start_time' => $schedule['start_time'],
                'end_time' => $schedule['end_time'],
                'is_active' => $schedule['is_active'],
            ]);
        }
    }
}
