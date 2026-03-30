<?php

namespace App\Http\Controllers;

use App\Models\MasterProcedure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MasterProcedureController extends Controller
{
    // ✅ GET semua data + search
    public function index(Request $request)
    {
        $query = MasterProcedure::select('id', 'procedure_name', 'base_price', 'is_active', DB::raw('procedure_name as name'));

        if ($request->search) {
            $query->where('procedure_name', 'like', '%' . $request->search . '%');
        }

        if ($request->has('is_active')) {
            $query->where('is_active', $request->is_active);
        }

        $data = $query->latest()->paginate(10);

        return response()->json([
            'success' => true,
            'message' => 'Data master prosedur berhasil diambil',
            'data' => $data
        ]);
    }

    // ✅ SHOW detail
    public function show($id)
    {
        $procedure = MasterProcedure::findOrFail($id);
        $procedure->name = $procedure->procedure_name;

        return response()->json([
            'success' => true,
            'data' => $procedure
        ]);
    }

    // ✅ STORE
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:150',
            'care_type_id'  => 'nullable|exists:master_care_type,id',
            'price'         => 'nullable|numeric|min:0',
            'description'   => 'nullable|string|max:255',
            'is_active'     => 'nullable|boolean',
        ]);

        $procedure = MasterProcedure::create([
            'id'             => Str::uuid(),
            'procedure_name' => $validated['name'],
            'care_type_id'   => $validated['care_type_id'],
            'price'          => $validated['price'] ?? 0,
            'description'    => $validated['description'] ?? '',
            'base_price'     => 0,
            'is_active'      => $validated['is_active'] ?? true,
        ]);
        $procedure->name = $procedure->procedure_name;

        return response()->json([
            'success' => true,
            'message' => 'Master prosedur berhasil ditambahkan',
            'data'    => $procedure
        ], 201);
    }

    // ✅ UPDATE
    public function update(Request $request, $id)
    {
        $procedure = MasterProcedure::findOrFail($id);

        $validated = $request->validate([
            'name'          => 'required|string|max:150',
            'care_type_id'  => 'nullable|exists:master_care_type,id',
            'price'         => 'nullable|numeric|min:0',
            'description'   => 'nullable|string|max:255',
            'is_active'     => 'nullable|boolean',
        ]);

        $procedure->update([
            'procedure_name' => $validated['name'],
            'care_type_id'   => $validated['care_type_id'] ?? $procedure->care_type_id,
            'price'          => $validated['price'] ?? $procedure->price,
            'description'    => $validated['description'] ?? $procedure->description,
            'is_active'      => $validated['is_active'] ?? $procedure->is_active,
        ]);
        $procedure->refresh();
        $procedure->name = $procedure->procedure_name;

        return response()->json([
            'success' => true,
            'message' => 'Master prosedur berhasil diupdate',
            'data'    => $procedure
        ]);
    }

    // ✅ DELETE
    public function destroy($id)
    {
        $procedure = MasterProcedure::findOrFail($id);
        $procedure->delete();

        return response()->json([
            'success' => true,
            'message' => 'Master prosedur berhasil dihapus'
        ]);
    }
}