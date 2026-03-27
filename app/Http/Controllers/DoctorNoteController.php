<?php

namespace App\Http\Controllers;

use App\Models\DoctorNote;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DoctorNoteController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'procedure_id' => 'nullable|string|max:50|exists:medical_procedure,id',
            'user_id' => 'nullable|string|max:50|exists:user,id',
            'notes' => 'nullable|string',
        ]);

        try {
            $doctorNote = DoctorNote::create([
                'id' => (string) Str::uuid(),
                'procedure_id' => $validated['procedure_id'] ?? null,
                'user_id' => $validated['user_id'] ?? null,
                'notes' => $validated['notes'] ?? null,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data doctor note berhasil dibuat',
                'data' => $doctorNote,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat data doctor note',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show(string $id): JsonResponse
    {
        $doctorNote = DoctorNote::with(['medicalProcedure', 'user'])->find($id);

        if (! $doctorNote) {
            return response()->json([
                'success' => false,
                'message' => 'Data doctor note tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data doctor note berhasil diambil',
            'data' => $doctorNote,
        ], 200);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $doctorNote = DoctorNote::find($id);

        if (! $doctorNote) {
            return response()->json([
                'success' => false,
                'message' => 'Data doctor note tidak ditemukan',
            ], 404);
        }

        $validated = $request->validate([
            'procedure_id' => 'sometimes|nullable|string|max:50|exists:medical_procedure,id',
            'user_id' => 'sometimes|nullable|string|max:50|exists:user,id',
            'notes' => 'sometimes|nullable|string',
        ]);

        try {
            $doctorNote->update($validated);
            $doctorNote->refresh();

            return response()->json([
                'success' => true,
                'message' => 'Data doctor note berhasil diperbarui',
                'data' => $doctorNote,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui data doctor note',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(string $id): JsonResponse
    {
        $doctorNote = DoctorNote::find($id);

        if (! $doctorNote) {
            return response()->json([
                'success' => false,
                'message' => 'Data doctor note tidak ditemukan',
            ], 404);
        }

        try {
            $doctorNote->delete();

            return response()->json([
                'success' => true,
                'message' => 'Data doctor note berhasil dihapus (soft delete)',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data doctor note',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
