<?php

namespace App\Http\Controllers;

use App\Models\MasterProcedure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MasterProcedureController extends BaseMasterController
{
    public function __construct()
    {
        parent::__construct(MasterProcedure::class, 'Prosedur');
    }

    public function index(Request $request)
    {
        $query = MasterProcedure::with('careType');

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('procedure_name', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->has('is_active')) {
            $query->where('is_active', $request->is_active);
        }

        if ($request->care_type_id) {
            $query->where('care_type_id', $request->care_type_id);
        }

        // Gunakan fallback agar data lama (name null) tetap terurut rapi.
        $data = $query->orderByRaw('COALESCE(name, procedure_name) asc')->paginate(10);

        return response()->json([
            'success' => true,
            'message' => "Data {$this->resourceName} berhasil diambil",
            'data'    => $data
        ]);
    }

    public function show($id)
    {
        $item = MasterProcedure::with('careType')->findOrFail($id);

        return response()->json([
            'success' => true,
            'data'    => $item
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'         => 'nullable|string|max:100|required_without:procedure_name',
            'procedure_name' => 'nullable|string|max:150|required_without:name',
            'care_type_id' => 'nullable|string|exists:master_care_type,id',
            'price'        => 'nullable|numeric|min:0',
            'base_price'   => 'nullable|numeric|min:0',
            'description'  => 'nullable|string|max:255',
            'is_active'    => 'nullable|boolean',
        ]);

        $procedureName = trim((string) ($validated['name'] ?? $validated['procedure_name'] ?? ''));
        $price = $validated['price'] ?? $validated['base_price'] ?? 0;

        $item = MasterProcedure::create([
            'id'             => (string) Str::uuid(),
            'name'           => $procedureName,
            'procedure_name' => $procedureName,
            'care_type_id'   => $validated['care_type_id'] ?? null,
            'price'          => $price,
            'base_price'     => $price,
            'description'    => $validated['description'] ?? '',
            'is_active'      => isset($validated['is_active']) ? (bool) $validated['is_active'] : true,
        ]);

        return response()->json([
            'success' => true,
            'message' => "{$this->resourceName} berhasil ditambahkan",
            'data'    => $item->load('careType')
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $item = MasterProcedure::findOrFail($id);

        $validated = $request->validate([
            'name'         => 'nullable|string|max:100|required_without:procedure_name',
            'procedure_name' => 'nullable|string|max:150|required_without:name',
            'care_type_id' => 'nullable|string|exists:master_care_type,id',
            'price'        => 'nullable|numeric|min:0',
            'base_price'   => 'nullable|numeric|min:0',
            'description'  => 'nullable|string|max:255',
            'is_active'    => 'nullable|boolean',
        ]);

        $procedureName = trim((string) ($validated['name'] ?? $validated['procedure_name'] ?? $item->name ?? $item->procedure_name ?? ''));
        $price = $validated['price'] ?? $validated['base_price'] ?? $item->price ?? $item->base_price ?? 0;

        $item->update([
            'name'           => $procedureName,
            'procedure_name' => $procedureName,
            'care_type_id'   => $validated['care_type_id'] ?? $item->care_type_id,
            'price'          => $price,
            'base_price'     => $price,
            'description'    => $validated['description'] ?? $item->description,
            'is_active'      => isset($validated['is_active']) ? (bool) $validated['is_active'] : $item->is_active,
        ]);

        return response()->json([
            'success' => true,
            'message' => "{$this->resourceName} berhasil diupdate",
            'data'    => $item->load('careType')
        ]);
    }

    public function destroy($id)
    {
        $item = MasterProcedure::findOrFail($id);
        $item->delete();

        return response()->json([
            'success' => true,
            'message' => "{$this->resourceName} berhasil dihapus"
        ]);
    }
}