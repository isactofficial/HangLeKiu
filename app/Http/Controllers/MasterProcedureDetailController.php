<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MasterProcedureDetailController extends BaseMasterController
{
    public function __construct()
    {
        parent::__construct('App\Models\MasterProcedure', 'Procedure');
        $this->validationRules = [
            'name'         => 'required|string|max:150',
            'care_type_id' => 'required|string|exists:master_care_type,id',
            'price'        => 'required|numeric|min:0',
            'description'  => 'nullable|string',
            'is_active'    => 'nullable|boolean',
        ];
    }

    // get and search
    public function index(Request $request)
    {
        $query = $this->model::query()->with('careType');

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->has('is_active')) {
            $query->where('is_active', $request->is_active);
        }

        $data = $query->latest()->paginate(10);

        return response()->json([
            'success' => true,
            'message' => "Data {$this->resourceName} berhasil diambil",
            'data'    => $data
        ]);
    }

    // show detail
    public function show($id)
    {
        $item = $this->model::with('careType')->findOrFail($id);

        return response()->json([
            'success' => true,
            'data'    => $item
        ]);
    }

    public function store(Request $request)
    {
        $request->validate($this->validationRules);

        $item = $this->model::create([
            'id'           => (string) Str::uuid(),
            'name'         => $request->name,
            'care_type_id' => $request->care_type_id,
            'price'        => $request->price,
            'description'  => $request->description,
            'is_active'    => $request->is_active ?? true,
        ]);

        $item->load('careType');

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
            'name'         => $request->name,
            'care_type_id' => $request->care_type_id,
            'price'        => $request->price,
            'description'  => $request->description,
            'is_active'    => $request->is_active ?? $item->is_active,
        ]);

        $item->load('careType');

        return response()->json([
            'success' => true,
            'message' => "{$this->resourceName} berhasil diupdate",
            'data'    => $item
        ]);
    }
}
