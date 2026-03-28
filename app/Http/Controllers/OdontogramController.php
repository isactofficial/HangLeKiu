<?php

namespace App\Http\Controllers;

use App\Models\OdontogramRecord;
use App\Models\OdontogramTooth;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class OdontogramController extends Controller
{
    // ----------------------------------------------------------------
    // GET /api/odontogram/patient/{patientId}
    // ----------------------------------------------------------------
    public function indexByPatient(string $patientId): JsonResponse
    {
        $records = OdontogramRecord::with('teeth')
            ->where('patient_id', $patientId)
            ->orderByDesc('examined_at')
            ->get();

        return response()->json(['status' => 'success', 'data' => $records]);
    }

    // ----------------------------------------------------------------
    // GET /api/odontogram/{recordId}
    // ----------------------------------------------------------------
    public function show(string $recordId): JsonResponse
    {
        $record = OdontogramRecord::with('teeth')->findOrFail($recordId);

        // Group per nomor gigi → { "11": [{...}], "21": [{...}] }
        $toothMap = $record->teeth
            ->groupBy('tooth_number')
            ->map(fn($items) => $items->values());

        return response()->json([
            'status' => 'success',
            'data'   => [
                'record'    => $record,
                'tooth_map' => $toothMap,
            ],
        ]);
    }

    // ----------------------------------------------------------------
    // POST /api/odontogram
    // Buat record baru + opsional langsung simpan kondisi gigi
    // ----------------------------------------------------------------
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'patient_id'              => 'required|string|exists:patient,id',
            'visit_id'                => 'nullable|string|exists:registration,id',
            'examined_by'             => 'nullable|string|max:100',
            'notes'                   => 'nullable|string',
            'examined_at'             => 'nullable|date',
            'teeth'                   => 'nullable|array',
            'teeth.*.tooth_number'    => 'required|integer|min:11|max:85',
            'teeth.*.surfaces'        => 'nullable|string|max:30',
            'teeth.*.condition_code'  => 'nullable|string|max:10',
            'teeth.*.condition_label' => 'nullable|string|max:100',
            'teeth.*.color_code'      => 'nullable|string|max:10',
            'teeth.*.notes'           => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $record = OdontogramRecord::create([
                'patient_id'  => $request->patient_id,
                'visit_id'    => $request->visit_id,
                'examined_by' => $request->examined_by,
                'notes'       => $request->notes,
                'examined_at' => $request->examined_at ?? now(),
            ]);

            foreach ($request->teeth ?? [] as $tooth) {
                OdontogramTooth::create([
                    'odontogram_record_id' => $record->id,
                    'tooth_number'         => $tooth['tooth_number'],
                    'surfaces'             => $tooth['surfaces']        ?? null,
                    'condition_code'       => $tooth['condition_code']  ?? null,
                    'condition_label'      => $tooth['condition_label'] ?? null,
                    'color_code'           => $tooth['color_code']      ?? null,
                    'notes'                => $tooth['notes']           ?? null,
                ]);
            }

            DB::commit();

            return response()->json([
                'status'  => 'success',
                'message' => 'Odontogram berhasil disimpan',
                'data'    => $record->load('teeth'),
            ], 201);

        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    // ----------------------------------------------------------------
    // PATCH /api/odontogram/{recordId}   ← BARU
    // Update header record (examined_by, notes, examined_at)
    // ----------------------------------------------------------------
    public function update(string $recordId, Request $request): JsonResponse
    {
        $record = OdontogramRecord::findOrFail($recordId);

        $request->validate([
            'examined_by' => 'nullable|string|max:100',
            'notes'       => 'nullable|string',
            'examined_at' => 'nullable|date',
        ]);

        $record->update($request->only(['examined_by', 'notes', 'examined_at']));

        return response()->json([
            'status' => 'success',
            'data'   => $record->load('teeth'),
        ]);
    }

    // ----------------------------------------------------------------
    // DELETE /api/odontogram/{recordId}   ← BARU
    // Hapus seluruh record (teeth ikut terhapus via cascadeOnDelete)
    // ----------------------------------------------------------------
    public function destroy(string $recordId): JsonResponse
    {
        OdontogramRecord::findOrFail($recordId)->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Odontogram record dihapus',
        ]);
    }

    // ----------------------------------------------------------------
    // POST /api/odontogram/{recordId}/teeth
    // Tambah 1 kondisi gigi ke record yang sudah ada
    // ----------------------------------------------------------------
    public function addTooth(string $recordId, Request $request): JsonResponse
    {
        OdontogramRecord::findOrFail($recordId);   // 404 kalau record tidak ada

        $request->validate([
            'tooth_number'    => 'required|integer|min:11|max:85',
            'surfaces'        => 'nullable|string|max:30',
            'condition_code'  => 'nullable|string|max:10',
            'condition_label' => 'nullable|string|max:100',
            'color_code'      => 'nullable|string|max:10',
            'notes'           => 'nullable|string',
        ]);

        $tooth = OdontogramTooth::create([
            'odontogram_record_id' => $recordId,
            ...$request->only([
                'tooth_number', 'surfaces',
                'condition_code', 'condition_label',
                'color_code', 'notes',
            ]),
        ]);

        return response()->json(['status' => 'success', 'data' => $tooth], 201);
    }

    // ----------------------------------------------------------------
    // DELETE /api/odontogram/teeth/{toothId}
    // Hapus 1 kondisi gigi saja
    // ----------------------------------------------------------------
    public function deleteTooth(string $toothId): JsonResponse
    {
        OdontogramTooth::findOrFail($toothId)->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Kondisi gigi dihapus',
        ]);
    }
}