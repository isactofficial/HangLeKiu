<?php

namespace App\Http\Controllers;

use App\Models\ConsumableItem;
use App\Models\ConsumableUsage;
use App\Models\Medicine;
use App\Models\MedicalProcedure;
use App\Models\ProcedureItem;
use App\Models\ProcedureMedicine;
use App\Models\StockMutation;
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
            'items' => 'nullable|array',
            'items.*.master_procedure_id' => 'required|string|max:50|exists:master_procedure,id',
            'items.*.tooth_numbers' => 'nullable|string|max:255',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.discount_type' => 'nullable|in:fix,percentage,none',
            'items.*.discount_value' => 'nullable|numeric|min:0',
            'items.*.subtotal' => 'nullable|numeric|min:0',
            'medicines' => 'nullable|array',
            'medicines.*.medicine_id' => 'required|string|max:50|exists:medicine,id',
            'medicines.*.quantity_used' => 'required|integer|min:1',
            'bhps' => 'nullable|array',
            'bhps.*.bhp_id' => 'required|string|max:50|exists:consumable_items,id',
            'bhps.*.quantity_used' => 'required|integer|min:1',
            'bhps.*.unit_price' => 'required|numeric|min:0',
            'bhps.*.usage_type' => 'nullable|in:umum,bpjs',
        ]);

        try {
            $medicalProcedure = DB::transaction(function () use ($validated) {
                $registrationId = $validated['registration_id'] ?? null;
                $medicalProcedure = $registrationId
                    ? MedicalProcedure::where('registration_id', $registrationId)->first()
                    : null;

                if ($medicalProcedure) {
                    $medicalProcedure->update([
                        'patient_id' => $validated['patient_id'] ?? $medicalProcedure->patient_id,
                        'doctor_id' => $validated['doctor_id'] ?? null,
                        'discount_type' => $validated['discount_type'] ?? null,
                        'discount_value' => $validated['discount_value'] ?? null,
                        'total_amount' => $validated['total_amount'] ?? null,
                        'notes' => $validated['notes'] ?? null,
                    ]);
                } else {
                    $medicalProcedure = MedicalProcedure::create([
                        'id' => (string) Str::uuid(),
                        'registration_id' => $registrationId,
                        'patient_id' => $validated['patient_id'] ?? null,
                        'doctor_id' => $validated['doctor_id'] ?? null,
                        'discount_type' => $validated['discount_type'] ?? null,
                        'discount_value' => $validated['discount_value'] ?? null,
                        'total_amount' => $validated['total_amount'] ?? null,
                        'notes' => $validated['notes'] ?? null,
                    ]);
                }

                // Sync assistants: replace all
                $medicalProcedure->assistants()->delete();

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

                // Replace all procedure items
                ProcedureItem::where('procedure_id', $medicalProcedure->id)->delete();
                foreach ($validated['items'] ?? [] as $item) {
                    ProcedureItem::create([
                        'id' => (string) Str::uuid(),
                        'procedure_id' => $medicalProcedure->id,
                        'master_procedure_id' => $item['master_procedure_id'],
                        'tooth_numbers' => $item['tooth_numbers'] ?? null,
                        'quantity' => $item['quantity'],
                        'unit_price' => $item['unit_price'],
                        'discount_type' => $item['discount_type'] ?? 'none',
                        'discount_value' => $item['discount_value'] ?? 0,
                        'subtotal' => $item['subtotal'] ?? 0,
                    ]);
                }

                // Rollback previous medicine stock before replacing medicines
                $oldMedicines = ProcedureMedicine::where('procedure_id', $medicalProcedure->id)->get();
                foreach ($oldMedicines as $old) {
                    $medicine = Medicine::find($old->medicine_id);
                    if ($medicine) {
                        $medicine->increment('current_stock', $old->quantity_used);
                        StockMutation::create([
                            'id' => (string) Str::uuid(),
                            'medicine_id' => $old->medicine_id,
                            'user_id' => null,
                            'type' => 'in',
                            'quantity' => $old->quantity_used,
                            'notes' => 'Rollback edit prosedur ID: ' . $medicalProcedure->id,
                        ]);
                    }
                }
                ProcedureMedicine::where('procedure_id', $medicalProcedure->id)->delete();

                // Save new medicines and reduce stock
                foreach ($validated['medicines'] ?? [] as $med) {
                    $medicine = Medicine::findOrFail($med['medicine_id']);
                    if ($medicine->current_stock < $med['quantity_used']) {
                        throw new \RuntimeException("Stok obat {$medicine->medicine_name} tidak cukup");
                    }

                    ProcedureMedicine::create([
                        'id' => (string) Str::uuid(),
                        'procedure_id' => $medicalProcedure->id,
                        'medicine_id' => $med['medicine_id'],
                        'quantity_used' => $med['quantity_used'],
                    ]);

                    $medicine->decrement('current_stock', $med['quantity_used']);
                    StockMutation::create([
                        'id' => (string) Str::uuid(),
                        'medicine_id' => $med['medicine_id'],
                        'user_id' => null,
                        'type' => 'out',
                        'quantity' => $med['quantity_used'],
                        'notes' => 'Digunakan untuk prosedur ID: ' . $medicalProcedure->id,
                    ]);
                }

                // Rollback previous BHP usage before replacing BHP entries
                $oldBhpUsages = ConsumableUsage::where('treatment_id', $medicalProcedure->id)->get();
                foreach ($oldBhpUsages as $oldUsage) {
                    $oldUsage->delete();
                }

                // Save new BHP usage and reduce stock
                foreach ($validated['bhps'] ?? [] as $bhp) {
                    $item = ConsumableItem::findOrFail($bhp['bhp_id']);
                    if ($item->current_stock < $bhp['quantity_used']) {
                        throw new \RuntimeException("Stok BHP {$item->item_name} tidak cukup");
                    }

                    ConsumableUsage::create([
                        'id' => (string) Str::uuid(),
                        'bhp_id' => $bhp['bhp_id'],
                        'treatment_id' => $medicalProcedure->id,
                        'usage_type' => $bhp['usage_type'] ?? 'umum',
                        'quantity_used' => $bhp['quantity_used'],
                        'unit_price' => $bhp['unit_price'],
                        'usage_date' => now()->toDateString(),
                        'notes' => 'Digunakan untuk prosedur ID: ' . $medicalProcedure->id,
                    ]);
                }

                return $medicalProcedure->load([
                    'assistants.doctor',
                    'items.masterProcedure',
                    'medicines.medicine',
                    'bhpUsages.item',
                ]);
            });

            return response()->json([
                'success' => true,
                'message' => 'Data medical procedure berhasil disimpan',
                'data' => $medicalProcedure,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan data medical procedure',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function checkByRegistration(string $registrationId): JsonResponse
    {
        $medicalProcedure = MedicalProcedure::with([
            'assistants.doctor',
            'items.masterProcedure',
            'medicines.medicine',
            'bhpUsages.item',
        ])->where('registration_id', $registrationId)->first();

        return response()->json([
            'success' => true,
            'message' => $medicalProcedure ? 'Data prosedur ditemukan' : 'Belum ada data prosedur',
            'data' => $medicalProcedure,
        ], 200);
    }

    public function show(string $id): JsonResponse
    {
        $medicalProcedure = MedicalProcedure::with([
            'registration',
            'patient',
            'doctor',
            'bhpUsages.item',
        ])->find($id);

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
