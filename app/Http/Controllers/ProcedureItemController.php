<?php

namespace App\Http\Controllers;

use App\Models\ProcedureItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ProcedureItemController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'procedure_id' => 'nullable|string|max:50|exists:medical_procedure,id',
            'master_procedure_id' => 'nullable|string|max:50|exists:master_procedure,id',
            'quantity' => 'nullable|integer|min:1',
            'unit_price' => 'nullable|numeric|min:0',
            'discount_type' => 'nullable|in:fix,percentage,none',
            'discount_value' => 'nullable|numeric|min:0',
            'subtotal' => 'nullable|numeric|min:0',
        ]);

        try {
            $procedureItem = ProcedureItem::create([
                'id' => (string) Str::uuid(),
                'procedure_id' => $validated['procedure_id'] ?? null,
                'master_procedure_id' => $validated['master_procedure_id'] ?? null,
                'quantity' => $validated['quantity'] ?? null,
                'unit_price' => $validated['unit_price'] ?? null,
                'discount_type' => $validated['discount_type'] ?? null,
                'discount_value' => $validated['discount_value'] ?? null,
                'subtotal' => $validated['subtotal'] ?? null,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data procedure item berhasil dibuat',
                'data' => $procedureItem,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat data procedure item',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show(string $id): JsonResponse
    {
        $procedureItem = ProcedureItem::with(['medicalProcedure', 'masterProcedure'])->find($id);

        if (! $procedureItem) {
            return response()->json([
                'success' => false,
                'message' => 'Data procedure item tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data procedure item berhasil diambil',
            'data' => $procedureItem,
        ], 200);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $procedureItem = ProcedureItem::find($id);

        if (! $procedureItem) {
            return response()->json([
                'success' => false,
                'message' => 'Data procedure item tidak ditemukan',
            ], 404);
        }

        $validated = $request->validate([
            'procedure_id' => 'sometimes|nullable|string|max:50|exists:medical_procedure,id',
            'master_procedure_id' => 'sometimes|nullable|string|max:50|exists:master_procedure,id',
            'quantity' => 'sometimes|nullable|integer|min:1',
            'unit_price' => 'sometimes|nullable|numeric|min:0',
            'discount_type' => 'sometimes|nullable|in:fix,percentage,none',
            'discount_value' => 'sometimes|nullable|numeric|min:0',
            'subtotal' => 'sometimes|nullable|numeric|min:0',
        ]);

        try {
            $procedureItem->update($validated);
            $procedureItem->refresh();

            return response()->json([
                'success' => true,
                'message' => 'Data procedure item berhasil diperbarui',
                'data' => $procedureItem,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui data procedure item',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(string $id): JsonResponse
    {
        $procedureItem = ProcedureItem::find($id);

        if (! $procedureItem) {
            return response()->json([
                'success' => false,
                'message' => 'Data procedure item tidak ditemukan',
            ], 404);
        }

        try {
            $procedureItem->delete();

            return response()->json([
                'success' => true,
                'message' => 'Data procedure item berhasil dihapus (soft delete)',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data procedure item',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
