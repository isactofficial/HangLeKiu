<?php

namespace App\Http\Controllers;

use App\Models\MasterProcedure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MasterProcedureController extends Controller
{
    // ✅ GET semua data + search
    public function index(Request $request)
    {
        $query = MasterProcedure::query();

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

        return response()->json([
            'success' => true,
            'data' => $procedure
        ]);
    }

    // ✅ STORE
    public function store(Request $request)
    {
        $request->validate([
            'procedure_name' => 'required|string|max:150',
            'base_price'     => 'required|numeric|min:0',
            'is_active'      => 'nullable|boolean',
        ]);

        $procedure = MasterProcedure::create([
            'id'             => Str::uuid(),
            'procedure_name' => $request->procedure_name,
            'base_price'     => $request->base_price,
            'is_active'      => $request->is_active ?? true,
        ]);

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

        $request->validate([
            'procedure_name' => 'required|string|max:150',
            'base_price'     => 'required|numeric|min:0',
            'is_active'      => 'nullable|boolean',
        ]);

        $procedure->update([
            'procedure_name' => $request->procedure_name,
            'base_price'     => $request->base_price,
            'is_active'      => $request->is_active ?? $procedure->is_active,
        ]);

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