<?php

namespace App\Http\Controllers;

use App\Models\MasterVisitType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MasterVisitTypeController extends BaseMasterController
{
    public function __construct()
    {
        parent::__construct(MasterVisitType::class, 'Jenis Kunjungan');
    }

    public function index(Request $request)
    {
        $query = MasterVisitType::query();

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->has('is_active')) {
            $query->where('is_active', $request->is_active);
        }

        // FIX: timestamps = false, tidak bisa pakai latest()
        $data = $query->orderBy('name')->paginate(10);

        return response()->json([
            'success' => true,
            'message' => "Data {$this->resourceName} berhasil diambil",
            'data'    => $data
        ]);
    }

    public function show($id)
    {
        $item = MasterVisitType::findOrFail($id);

        return response()->json([
            'success' => true,
            'data'    => $item
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:50',
            'description' => 'nullable|string|max:255',
            'is_active'   => 'nullable|boolean',
        ]);

        $item = MasterVisitType::create([
            'id'          => (string) Str::uuid(),
            'name'        => $validated['name'],
            'description' => $validated['description'] ?? '',
            // FIX: is_active harus cast boolean, bukan pakai ?? true langsung
            // karena dari JSON request bisa datang sebagai false (falsy tapi valid)
            'is_active'   => isset($validated['is_active']) ? (bool) $validated['is_active'] : true,
        ]);

        return response()->json([
            'success' => true,
            'message' => "{$this->resourceName} berhasil ditambahkan",
            'data'    => $item
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $item = MasterVisitType::findOrFail($id);

        $validated = $request->validate([
            'name'        => 'required|string|max:50',
            'description' => 'nullable|string|max:255',
            'is_active'   => 'nullable|boolean',
        ]);

        $item->update([
            'name'        => $validated['name'],
            'description' => $validated['description'] ?? $item->description,
            'is_active'   => isset($validated['is_active']) ? (bool) $validated['is_active'] : $item->is_active,
        ]);

        return response()->json([
            'success' => true,
            'message' => "{$this->resourceName} berhasil diupdate",
            'data'    => $item
        ]);
    }

    public function destroy($id)
    {
        $item = MasterVisitType::findOrFail($id);

        try {
            $item->delete();
            return response()->json([
                'success' => true,
                'message' => "{$this->resourceName} berhasil dihapus"
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() === '23000') {
                return response()->json([
                    'success' => false,
                    'message' => "{$this->resourceName} tidak bisa dihapus karena sudah digunakan di data lain"
                ], 422);
            }
            throw $e;
        }
    }
}