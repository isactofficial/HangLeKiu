<?php

namespace App\Http\Controllers;

use App\Models\MedicalProcedure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MedicalProcedureController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'registration_id' => 'nullable|string|max:50|exists:registration,id',
            'patient_id' => 'nullable|string|max:50|exists:patient,id',
            'doctor_id' => 'nullable|string|max:50|exists:doctor,id',
            'assistant_doctor_ids' => 'nullable|array',
            'assistant_doctor_ids.*' => 'nullable|string|max:50|exists:doctor,id',
            'discount_type' => 'nullable|in:fix,percentage,none',
            'discount_value' => 'nullable|numeric|min:0',
            'total_amount' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        try {
            $medicalProcedure = DB::transaction(function () use ($validated) {
                $medicalProcedure = MedicalProcedure::create([
                    'id' => (string) Str::uuid(),
                    'registration_id' => $validated['registration_id'] ?? null,
                    'patient_id' => $validated['patient_id'] ?? null,
                    'doctor_id' => $validated['doctor_id'] ?? null,
                    'discount_type' => $validated['discount_type'] ?? null,
                    'discount_value' => $validated['discount_value'] ?? null,
                    'total_amount' => $validated['total_amount'] ?? null,
                    'notes' => $validated['notes'] ?? null,
                ]);

                $assistantIds = collect($validated['assistant_doctor_ids'] ?? [])
                    ->filter()
                    ->unique()
                    ->values();

                if ($assistantIds->isNotEmpty()) {
                    $medicalProcedure->assistants()->createMany(
                        $assistantIds->map(function ($doctorId) {
                            return [
                                'id' => (string) Str::uuid(),
                                'doctor_id' => $doctorId,
                            ];
                        })->all()
                    );
                }

                return $medicalProcedure->load('assistants.doctor');
            });

            return response()->json([
                'success' => true,
                'message' => 'Data medical procedure berhasil dibuat',
                'data' => $medicalProcedure,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat data medical procedure',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show(string $id): JsonResponse
    {
        $medicalProcedure = MedicalProcedure::with(['registration', 'patient', 'doctor'])->find($id);

        if (! $medicalProcedure) {
            return response()->json([
                'success' => false,
                'message' => 'Data medical procedure tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data medical procedure berhasil diambil',
            'data' => $medicalProcedure,
        ], 200);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $medicalProcedure = MedicalProcedure::find($id);

        if (! $medicalProcedure) {
            return response()->json([
                'success' => false,
                'message' => 'Data medical procedure tidak ditemukan',
            ], 404);
        }

        $validated = $request->validate([
            'registration_id' => 'sometimes|nullable|string|max:50|exists:registration,id',
            'patient_id' => 'sometimes|nullable|string|max:50|exists:patient,id',
            'doctor_id' => 'sometimes|nullable|string|max:50|exists:doctor,id',
            'discount_type' => 'sometimes|nullable|in:fix,percentage,none',
            'discount_value' => 'sometimes|nullable|numeric|min:0',
            'total_amount' => 'sometimes|nullable|numeric|min:0',
            'notes' => 'sometimes|nullable|string',
        ]);

        try {
            $medicalProcedure->update($validated);
            $medicalProcedure->refresh();

            return response()->json([
                'success' => true,
                'message' => 'Data medical procedure berhasil diperbarui',
                'data' => $medicalProcedure,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui data medical procedure',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(string $id): JsonResponse
    {
        $medicalProcedure = MedicalProcedure::find($id);

        if (! $medicalProcedure) {
            return response()->json([
                'success' => false,
                'message' => 'Data medical procedure tidak ditemukan',
            ], 404);
        }

        try {
            $medicalProcedure->delete();

            return response()->json([
                'success' => true,
                'message' => 'Data medical procedure berhasil dihapus (soft delete)',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data medical procedure',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
