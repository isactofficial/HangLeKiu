<?php

namespace App\Http\Controllers;

use App\Models\MasterCareType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MasterCareTypeController extends BaseMasterController
{
    public function __construct()
    {
        parent::__construct(MasterCareType::class, 'Jenis Perawatan');
    }

    public function index(Request $request)
    {
        $query = MasterCareType::query();

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->has('is_active')) {
            $query->where('is_active', $request->is_active);
        }

        $data = $query->orderBy('name')->paginate(10);

        return response()->json([
            'success' => true,
            'message' => "Data {$this->resourceName} berhasil diambil",
            'data'    => $data
        ]);
    }

    public function show($id)
    {
        $item = MasterCareType::findOrFail($id);

        return response()->json([
            'success' => true,
            'data'    => $item
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:50',
            'price'       => 'required|numeric|min:0',
            'description' => 'nullable|string|max:255',
            'is_active'   => 'nullable|boolean',
        ]);

        $item = MasterCareType::create([
            'id'          => (string) Str::uuid(),
            'name'        => $validated['name'],
            'price'       => $validated['price'],
            'description' => $validated['description'] ?? '',
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
        $item = MasterCareType::findOrFail($id);

        $validated = $request->validate([
            'name'        => 'required|string|max:50',
            'price'       => 'required|numeric|min:0',
            'description' => 'nullable|string|max:255',
            'is_active'   => 'nullable|boolean',
        ]);

        $item->update([
            'name'        => $validated['name'],
            'price'       => $validated['price'],
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
        $item = MasterCareType::findOrFail($id);
        $item->delete();

        return response()->json([
            'success' => true,
            'message' => "{$this->resourceName} berhasil dihapus"
        ]);
    }
}