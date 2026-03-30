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
            'is_active'   => $validated['is_active'] ?? true,
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
            'is_active'   => $validated['is_active'] ?? $item->is_active,
        ]);

        return response()->json([
            'success' => true,
            'message' => "{$this->resourceName} berhasil diupdate",
            'data'    => $item
        ]);
    }
}

