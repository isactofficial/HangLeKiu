<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        ]);

        try {
            $this->createDoctorUserAndProfile($validated);

            return redirect()
                ->route('admin.settings', ['menu' => 'manajemen-staff'])
                ->with('success', 'Akun dokter berhasil dibuat.');
        } catch (\RuntimeException $e) {
            return redirect()
                ->route('admin.settings', ['menu' => 'manajemen-staff'])
                ->withErrors(['doctor_create' => $e->getMessage()])
                ->withInput();
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.settings', ['menu' => 'manajemen-staff'])
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

        if (strtolower((string) (Auth::user()->role ?? '')) !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki akses untuk membuat akun dokter',
            ], 403);
        }

        $validated = $request->validate([
            'full_name' => 'required|string|max:100',
            'email' => 'required|email|max:50|unique:user,email',
            'password' => 'required|string|min:8',
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
        ]);

        try {
            $result = $this->createDoctorUserAndProfile($validated);

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
        ]);

        try {
            $result = DB::transaction(function () use ($doctor, $validated) {
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
                        $userPayload['password'] = $validated['password'];
                    }

                    if (! empty($userPayload)) {
                        $user->update($userPayload);
                    }
                }

                $doctorPayload = $validated;
                unset($doctorPayload['password']);
                $doctor->update($doctorPayload);

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
        $role = strtolower((string) ($currentUser->role ?? ''));

        if ($role === 'admin') {
            return null;
        }

        if ($role === 'doctor' && (string) $currentUser->id === (string) $doctor->user_id) {
            return null;
        }

        return response()->json([
            'success' => false,
            'message' => 'Anda tidak memiliki akses untuk mengubah data dokter ini',
        ], 403);
    }

    /**
     * Shared creator used by API and admin settings form.
     *
     * @throws \RuntimeException
     */
    private function createDoctorUserAndProfile(array $validated): array
    {
        $roleDoctor = Role::where('code', 'DCT')->first();

        if (! $roleDoctor) {
            throw new \RuntimeException('Role DCT tidak ditemukan. Jalankan seeder terlebih dahulu.');
        }

        return DB::transaction(function () use ($validated, $roleDoctor) {
            $user = User::create([
                'id' => (string) Str::uuid(),
                'role_id' => $roleDoctor->id,
                'name' => $validated['full_name'],
                'email' => $validated['email'],
                'password' => $validated['password'],
                'is_active' => true,
                'is_verified' => true,
            ]);

            $doctor = Doctor::create([
                'id' => (string) Str::uuid(),
                'user_id' => $user->id,
                'full_name' => $validated['full_name'],
                'email' => $validated['email'],
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

            return [
                'user' => $user,
                'doctor' => $doctor,
            ];
        });
    }
}
