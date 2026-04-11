<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\DoctorSchedule;
use App\Models\Article;
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
    public function index(Request $request)
    {
        $menu = $request->query('menu', 'info-tenaga-medis');
        $doctors = Doctor::orderBy('full_name', 'asc')->get();

        $staffRoleFilter = strtoupper((string) $request->query('staff_role', 'ALL'));
        $allowedStaffRoles = ['ADM', 'OWN', 'DCT'];

        $staffAccountsQuery = User::with(['role', 'doctor'])
            ->whereHas('role', function ($query) use ($allowedStaffRoles) {
                $query->whereIn('code', $allowedStaffRoles);
            });

        if (in_array($staffRoleFilter, $allowedStaffRoles, true)) {
            $staffAccountsQuery->whereHas('role', function ($query) use ($staffRoleFilter) {
                $query->where('code', $staffRoleFilter);
            });
        } else {
            $staffRoleFilter = 'ALL';
        }

        $staffAccounts = $staffAccountsQuery
            ->orderBy('name', 'asc')
            ->get();

        $staffCounts = User::query()
            ->join('role', 'role.id', '=', 'user.role_id')
            ->whereIn('role.code', $allowedStaffRoles)
            ->selectRaw('role.code as role_code, COUNT(*) as total')
            ->groupBy('role.code')
            ->pluck('total', 'role_code');

        $availableDoctors = Doctor::query()
            ->whereNull('user_id')
            ->orderBy('full_name', 'asc')
            ->get(['id', 'full_name', 'specialization']);

        $articles = [];
        if ($request->query('submenu') === 'Artikel') {
            $articles = Article::latest()->paginate(10);
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'doctors' => $doctors->map(function ($d) {
                    return [
                        'id' => $d->id,
                        'name' => $d->full_name,
                        'str' => $d->str_number,
                        'spec' => $d->specialization,
                        'exp' => $d->experience,
                        'lulus' => $d->alma_mater,
                        'bio' => $d->bio,
                        'order' => $d->carousel_order ?? 99,
                        'status' => $d->is_active ? 'active' : 'inactive',
                        'ig' => $d->instagram_url,
                        'li' => $d->linkedin_url,
                        'foto' => $d->foto_profil,
                        'shadow' => $d->shadow_image,
                        'badge1' => $d->badge_1,
                        'badge2' => $d->badge_2,
                    ];
                })
            ]);
        }

        return view('admin.layout.settings', [
            'menu' => $menu,
            'doctors' => $doctors,
            'staffAccounts' => $staffAccounts,
            'staffRoleFilter' => $staffRoleFilter,
            'staffCounts' => $staffCounts,
            'availableDoctors' => $availableDoctors,
            'articles' => $articles,
        ]);
    }

    public function storeStaffAccountFromAdmin(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:50', 'unique:user,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'access_type' => ['required', Rule::in(['ADM', 'OWN', 'DCT'])],
            'doctor_id' => ['nullable', 'string', 'exists:doctor,id'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if ($validated['access_type'] === 'DCT') {
            if (empty($validated['doctor_id'])) {
                return redirect()->route('admin.settings', ['menu' => 'manajemen-staff'])
                    ->withErrors(['staff_account_create' => 'Data Dokter wajib dipilih untuk akun Doctor.'])
                    ->withInput();
            }

            $selectedDoctor = Doctor::query()
                ->where('id', $validated['doctor_id'])
                ->whereNull('user_id')
                ->first();

            if (! $selectedDoctor) {
                return redirect()->route('admin.settings', ['menu' => 'manajemen-staff'])
                    ->withErrors(['staff_account_create' => 'Data dokter tidak tersedia atau sudah terhubung akun lain.'])
                    ->withInput();
            }
        }

        $role = Role::where('code', $validated['access_type'])->first();

        if (! $role) {
            return redirect()->route('admin.settings', ['menu' => 'manajemen-staff'])
                ->withErrors(['staff_account_create' => 'Role tidak ditemukan.'])
                ->withInput();
        }

        $user = User::create([
            'id' => (string) Str::uuid(),
            'role_id' => $role->id,
            'name' => $validated['full_name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'is_active' => $request->boolean('is_active', true),
            'is_verified' => true,
        ]);

        if ($validated['access_type'] === 'DCT' && ! empty($validated['doctor_id'])) {
            Doctor::where('id', $validated['doctor_id'])->update([
                'user_id' => $user->id,
            ]);
        }

        return redirect()->route('admin.settings', ['menu' => 'manajemen-staff'])
            ->with('success', 'Akun staff berhasil dibuat.');
    }

    public function toggleStaffAccountStatus($id): JsonResponse
    {
        try {
            $user = User::findOrFail($id);

            if ((string) Auth::id() === (string) $user->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak dapat mengubah status akun sendiri.',
                ], 403);
            }
            
            // Hanya toggle akun dengan role ADM/OWN/DCT
            if (! in_array($user->role?->code, ['ADM', 'OWN', 'DCT'], true)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Hanya akun staff yang dapat di-toggle.'
                ], 403);
            }

            $user->update(['is_active' => ! $user->is_active]);

            return response()->json([
                'success' => true,
                'message' => $user->is_active ? 'Akun diaktifkan.' : 'Akun dinonaktifkan.',
                'is_active' => $user->is_active,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengubah status: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateStaffAccountDoctorLink(Request $request, $id): JsonResponse
    {
        $validated = $request->validate([
            'doctor_id' => ['nullable', 'string', 'exists:doctor,id'],
        ]);

        try {
            $user = User::with(['role', 'doctor'])->findOrFail($id);

            if (($user->role->code ?? null) !== 'DCT') {
                return response()->json([
                    'success' => false,
                    'message' => 'Hanya akun dengan tipe akses Doctor yang dapat dihubungkan ke data dokter.',
                ], 422);
            }

            $targetDoctorId = $validated['doctor_id'] ?? null;

            $updatedDoctor = DB::transaction(function () use ($user, $targetDoctorId) {
                $currentDoctor = Doctor::query()->where('user_id', $user->id)->first();

                if (empty($targetDoctorId)) {
                    if ($currentDoctor) {
                        $currentDoctor->update(['user_id' => null]);
                    }

                    return null;
                }

                $targetDoctor = Doctor::query()->findOrFail($targetDoctorId);

                if (!empty($targetDoctor->user_id) && (string) $targetDoctor->user_id !== (string) $user->id) {
                    throw new \RuntimeException('Data dokter sudah terhubung ke akun lain.');
                }

                if ($currentDoctor && (string) $currentDoctor->id !== (string) $targetDoctor->id) {
                    $currentDoctor->update(['user_id' => null]);
                }

                if ((string) $targetDoctor->user_id !== (string) $user->id) {
                    $targetDoctor->update(['user_id' => $user->id]);
                }

                return $targetDoctor->fresh();
            });

            return response()->json([
                'success' => true,
                'message' => $updatedDoctor ? 'Data dokter berhasil dihubungkan.' : 'Hubungan data dokter berhasil dilepas.',
                'doctor_id' => $updatedDoctor?->id,
                'doctor_name' => $updatedDoctor?->full_name,
                'doctor_specialization' => $updatedDoctor?->specialization,
            ]);
        } catch (\RuntimeException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui hubungan data dokter: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Simpan data baru
     */
    public function storeFromAdmin(Request $request)
    {
        $validated = $this->validateRequest($request);

        try {
            DB::transaction(function () use ($validated, $request) {
                $doctor = Doctor::create(array_merge($validated, [
                    'id' => (string) Str::uuid(),
                    'is_active' => $request->has('is_active') ? (bool)$request->is_active : true,
                    'foto_profil' => $request->hasFile('foto_profil') ? $this->uploadFile($request->file('foto_profil'), 'doctor_profiles') : null,
                    'shadow_image' => $request->hasFile('shadow_image') ? $this->uploadFile($request->file('shadow_image'), 'doctor_profiles') : null,
                    'badge_1' => $request->hasFile('badge_1') ? $this->uploadFile($request->file('badge_1'), 'doctor_profiles') : null,
                    'badge_2' => $request->hasFile('badge_2') ? $this->uploadFile($request->file('badge_2'), 'doctor_profiles') : null,
                    'ttd' => $request->hasFile('ttd') ? $this->uploadFile($request->file('ttd'), 'doctor_signatures') : null,
                ]));

                $this->syncDoctorSchedules($doctor, $this->normalizeSchedules($request->schedules ?? []));
            });

            if ($request->wantsJson()) {
                return response()->json(['success' => true, 'message' => 'Data tenaga medis berhasil disimpan.']);
            }

            return redirect()->route('admin.settings', ['menu' => 'info-tenaga-medis'])
                             ->with('success', 'Data tenaga medis berhasil disimpan.');
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Gagal simpan: ' . $e->getMessage()], 500);
            }
            return redirect()->back()->withErrors(['doctor_create' => 'Gagal simpan: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Update data via AJAX
     */
    public function update(Request $request, $id): JsonResponse
    {
        $doctor = Doctor::findOrFail($id);
        $validated = $this->validateRequest($request, $id);

        try {
            DB::transaction(function () use ($validated, $request, $doctor) {
                // Cek Foto Profil Baru
                if ($request->hasFile('foto_profil')) {
                    if ($doctor->foto_profil) Storage::disk('public')->delete($doctor->foto_profil);
                    $validated['foto_profil'] = $this->uploadFile($request->file('foto_profil'), 'doctor_profiles');
                }
                
                if ($request->hasFile('shadow_image')) {
                    if ($doctor->shadow_image) Storage::disk('public')->delete($doctor->shadow_image);
                    $validated['shadow_image'] = $this->uploadFile($request->file('shadow_image'), 'doctor_profiles');
                }

                if ($request->hasFile('badge_1')) {
                    if ($doctor->badge_1) Storage::disk('public')->delete($doctor->badge_1);
                    $validated['badge_1'] = $this->uploadFile($request->file('badge_1'), 'doctor_profiles');
                }

                if ($request->hasFile('badge_2')) {
                    if ($doctor->badge_2) Storage::disk('public')->delete($doctor->badge_2);
                    $validated['badge_2'] = $this->uploadFile($request->file('badge_2'), 'doctor_profiles');
                }

                // Cek TTD Baru
                if ($request->hasFile('ttd')) {
                    if ($doctor->ttd) Storage::disk('public')->delete($doctor->ttd);
                    $validated['ttd'] = $this->uploadFile($request->file('ttd'), 'doctor_signatures');
                }

                $doctor->update($validated);
                
                // Update Jadwal
                $this->syncDoctorSchedules($doctor, $this->normalizeSchedules($request->schedules ?? []));
            });

            return response()->json(['success' => true, 'message' => 'Data berhasil diperbarui']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Hapus data via AJAX
     */
    public function destroy($id): JsonResponse
    {
        try {
            $doctor = Doctor::findOrFail($id);
            
            // Hapus file fisik
            if ($doctor->foto_profil) Storage::disk('public')->delete($doctor->foto_profil);
            if ($doctor->shadow_image) Storage::disk('public')->delete($doctor->shadow_image);
            if ($doctor->badge_1) Storage::disk('public')->delete($doctor->badge_1);
            if ($doctor->badge_2) Storage::disk('public')->delete($doctor->badge_2);
            if ($doctor->ttd) Storage::disk('public')->delete($doctor->ttd);

            $doctor->delete();

            return response()->json(['success' => true, 'message' => 'Data berhasil dihapus']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function showJson($id): JsonResponse
    {
        $doctor = Doctor::with('schedules')->find($id);
        if (!$doctor) return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 404);

        return response()->json(['success' => true, 'doctor' => $doctor]);
    }

    // ================= HELPER FUNCTIONS =================

    private function validateRequest(Request $request, $id = null)
    {
        return $request->validate([
            'full_name'           => 'required|string|max:100',
            'email'               => 'nullable|email|max:50',
            'phone_number'        => 'nullable|string|max:20',
            'title_prefix'        => 'nullable|string|max:50',
            'job_title'           => 'nullable|string|max:50',
            'specialization'      => 'nullable|string|max:100',
            'subspecialization'   => 'nullable|string|max:100',
            'estimasi_konsultasi' => 'nullable|integer|min:1|max:600',
            'license_no'          => 'nullable|string|max:50',
            'str_number'          => 'nullable|string|max:50',
            'str_institution'     => 'nullable|string|max:50',
            'str_expiry_date'     => 'nullable|date',
            'sip_number'          => 'nullable|string|max:50',
            'sip_institution'     => 'nullable|string|max:50',
            'sip_expiry_date'     => 'nullable|date',
            'foto_profil'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'shadow_image'        => 'nullable|image|mimes:png,webp|max:2048',
            'badge_1'             => 'nullable|image|mimes:jpg,jpeg,png,webp|max:1024',
            'badge_2'             => 'nullable|image|mimes:jpg,jpeg,png,webp|max:1024',
            'ttd'                 => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'experience'          => 'nullable|string|max:50',
            'alma_mater'          => 'nullable|string|max:150',
            'bio'                 => 'nullable|string|max:500',
            'instagram_url'       => 'nullable|url|max:150',
            'linkedin_url'        => 'nullable|url|max:150',
            'carousel_order'      => 'nullable|integer',
        ]);
    }

    private function uploadFile($file, $folder): string
    {
        return $file->store($folder, 'public');
    }

    private function normalizeSchedules(?array $schedules): array
    {
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
        $normalized = [];

        foreach ($days as $day) {
            $row = $schedules[$day] ?? null;
            if ($row && isset($row['is_active']) && ($row['is_active'] == '1' || $row['is_active'] == 'true')) {
                $normalized[] = [
                    'day' => $day,
                    'start_time' => $row['start_time'],
                    'end_time' => $row['end_time'],
                    'is_active' => true
                ];
            }
        }
        return $normalized;
    }

    private function syncDoctorSchedules(Doctor $doctor, array $schedules): void
    {
        DoctorSchedule::where('doctor_id', $doctor->id)->delete();
        foreach ($schedules as $sch) {
            DoctorSchedule::create(array_merge($sch, [
                'id' => (string) Str::uuid(),
                'doctor_id' => $doctor->id
            ]));
        }
    }
}