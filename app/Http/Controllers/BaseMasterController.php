<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

abstract class BaseMasterController extends Controller
{
    protected $model;
    protected $resourceName = 'Data';
    protected $validationRules = [
        'name'      => 'required|string|max:50',
        'is_active' => 'nullable|boolean',
    ];

    public function __construct($model, $resourceName = 'Data')
    {
        $this->model = $model;
        $this->resourceName = $resourceName;
    }

    public function index(Request $request)
    {
        $query = $this->model::query();

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
        $item = $this->model::findOrFail($id);

        return response()->json([
            'success' => true,
            'data'    => $item
        ]);
    }

    public function store(Request $request)
    {
        $request->validate($this->validationRules);

        $item = $this->model::create([
            'id'        => (string) Str::uuid(),
            'name'      => $request->name,
            'is_active' => isset($request->is_active) ? (bool) $request->is_active : true,
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
            'name'      => $request->name,
            'is_active' => isset($request->is_active) ? (bool) $request->is_active : $item->is_active,
        ]);

        return response()->json([
            'success' => true,
            'message' => "{$this->resourceName} berhasil diupdate",
            'data'    => $item
        ]);
    }

    public function destroy($id)
    {
        $item = $this->model::findOrFail($id);

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