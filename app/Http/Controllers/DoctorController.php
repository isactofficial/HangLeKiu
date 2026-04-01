<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\DoctorSchedule;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DoctorController extends Controller
{
    public function index(Request $request)
    {
        $menu = $request->query('menu', 'info-tenaga-medis');
        $doctors = Doctor::orderBy('full_name', 'asc')->get();

        return view('admin.layout.settings', [
            'menu' => $menu,
            'doctors' => $doctors
        ]);
    }

    /**
     * Simpan data baru
     */
    public function storeFromAdmin(Request $request): RedirectResponse
    {
        $validated = $this->validateRequest($request);

        try {
            DB::transaction(function () use ($validated, $request) {
                $doctor = Doctor::create(array_merge($validated, [
                    'id' => (string) Str::uuid(),
                    'is_active' => $request->has('is_active') ? (bool)$request->is_active : true,
                    'foto_profil' => $request->hasFile('foto_profil') ? $this->uploadFile($request->file('foto_profil'), 'doctor_profiles') : null,
                    'ttd' => $request->hasFile('ttd') ? $this->uploadFile($request->file('ttd'), 'doctor_signatures') : null,
                ]));

                $this->syncDoctorSchedules($doctor, $this->normalizeSchedules($request->schedules ?? []));
            });

            return redirect()->route('admin.settings', ['menu' => 'info-tenaga-medis'])
                             ->with('success', 'Data tenaga medis berhasil disimpan.');
        } catch (\Exception $e) {
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
            'ttd'                 => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
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