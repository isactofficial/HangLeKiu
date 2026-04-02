<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MasterCareTypeController extends BaseMasterController
{
    public function __construct()
    {
        parent::__construct('App\Models\MasterCareType', 'Care Type');
        $this->validationRules = [
            'name'        => 'required|string|max:50',
            'price'       => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'is_active'   => 'nullable|boolean',
        ];
    }

    public function store(Request $request)
    {
        $request->validate($this->validationRules);

        $item = $this->model::create([
            'id'          => (string) Str::uuid(),
            'name'        => $request->name,
            'price'       => $request->price,
            'description' => $request->description,
            'is_active'   => $request->is_active ?? true,
        ]);

        return response()->json([
            'success' => true,
            'message' => "{$this->resourceName} berhasil ditambahkan",
            'data'    => $item
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $item = $this->model::findOrFail($id);
        $request->validate($this->validationRules);

        $item->update([
            'name'        => $request->name,
            'price'       => $request->price,
            'description' => $request->description,
            'is_active'   => $request->is_active ?? $item->is_active,
        ]);

        return response()->json([
            'success' => true,
            'message' => "{$this->resourceName} berhasil diupdate",
            'data'    => $item
        ]);
    }
}