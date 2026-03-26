<?php

namespace App\Http\Controllers;

use App\Models\Treatment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProcedureController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'procedure_name' => 'required|string|max:150',
            'base_price' => 'required|numeric|min:0',
            'is_active' => 'sometimes|boolean',
        ]);

        try {
            $procedure = Treatment::create([
                'id' => (string) Str::uuid(),
                'procedure_name' => $validated['procedure_name'],
                'base_price' => $validated['base_price'],
                'is_active' => $validated['is_active'] ?? true,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data prosedur berhasil dibuat',
                'data' => $procedure,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat data prosedur',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function index(): JsonResponse
    {
        $procedures = Treatment::orderByDesc('created_at')->get();

        return response()->json([
            'success' => true,
            'message' => 'Data prosedur berhasil diambil',
            'data' => $procedures,
            'count' => $procedures->count(),
        ], 200);
    }

    public function show(string $id): JsonResponse
    {
        $procedure = Treatment::find($id);

        if (! $procedure) {
            return response()->json([
                'success' => false,
                'message' => 'Data prosedur tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data prosedur berhasil diambil',
            'data' => $procedure,
        ], 200);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $procedure = Treatment::find($id);

        if (! $procedure) {
            return response()->json([
                'success' => false,
                'message' => 'Data prosedur tidak ditemukan',
            ], 404);
        }

        $validated = $request->validate([
            'procedure_name' => 'sometimes|required|string|max:150',
            'base_price' => 'sometimes|required|numeric|min:0',
            'is_active' => 'sometimes|required|boolean',
        ]);

        try {
            $procedure->update($validated);
            $procedure->refresh();

            return response()->json([
                'success' => true,
                'message' => 'Data prosedur berhasil diperbarui',
                'data' => $procedure,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui data prosedur',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(string $id): JsonResponse
    {
        $procedure = Treatment::find($id);

        if (! $procedure) {
            return response()->json([
                'success' => false,
                'message' => 'Data prosedur tidak ditemukan',
            ], 404);
        }

        try {
            $procedure->delete();

            return response()->json([
                'success' => true,
                'message' => 'Data prosedur berhasil dihapus (soft delete)',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data prosedur',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
