<?php

namespace App\Http\Controllers;

use App\Models\ConsumableItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ConsumableItemController extends Controller
{
    // GET /api/admin/bhp/items
    public function index(Request $request)
    {
        $query = ConsumableItem::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('item_name', 'like', "%{$search}%")
                  ->orWhere('item_code', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%");
            });
        }

        if ($request->boolean('low_stock')) {
            $query->whereColumn('current_stock', '<=', 'min_stock');
        }

        $items = $query->orderBy('item_name')->get();

        return response()->json([
            'success' => true,
            'data'    => $items,
        ]);
    }

    // GET /api/admin/bhp/items/{id}
    public function show($id)
    {
        $item = ConsumableItem::with(['usages', 'restocks', 'expiryLogs'])->find($id);

        if (!$item) {
            return response()->json(['success' => false, 'message' => 'Item tidak ditemukan'], 404);
        }

        return response()->json(['success' => true, 'data' => $item]);
    }

    // POST /api/admin/bhp/items
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'item_code'      => 'required|string|max:50|unique:consumable_items,item_code',
            'item_name'      => 'required|string|max:150',
            'brand'          => 'nullable|string|max:100',
            'initial_stock'  => 'required|integer|min:0',
            'purchase_price' => 'required|numeric|min:0',
            'general_price'  => 'required|numeric|min:0',
            'otc_price'      => 'required|numeric|min:0',
            'avg_hpp'        => 'nullable|numeric|min:0',
            'min_stock'      => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();
        $data['current_stock'] = $data['initial_stock'];
        $data['avg_hpp']       = $data['avg_hpp'] ?? $data['purchase_price'];

        $item = ConsumableItem::create($data);

        return response()->json(['success' => true, 'message' => 'Item BHP berhasil ditambahkan', 'data' => $item], 201);
    }

    // PUT /api/admin/bhp/items/{id}
    public function update(Request $request, $id)
    {
        $item = ConsumableItem::find($id);

        if (!$item) {
            return response()->json(['success' => false, 'message' => 'Item tidak ditemukan'], 404);
        }

        $validator = Validator::make($request->all(), [
            'item_code'      => 'sometimes|string|max:50|unique:consumable_items,item_code,' . $id,
            'item_name'      => 'sometimes|string|max:150',
            'brand'          => 'nullable|string|max:100',
            'initial_stock'  => 'sometimes|integer|min:0',
            'purchase_price' => 'sometimes|numeric|min:0',
            'general_price'  => 'sometimes|numeric|min:0',
            'otc_price'      => 'sometimes|numeric|min:0',
            'avg_hpp'        => 'nullable|numeric|min:0',
            'min_stock'      => 'sometimes|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $item->update($validator->validated());

        return response()->json(['success' => true, 'message' => 'Item BHP berhasil diupdate', 'data' => $item]);
    }

    // DELETE /api/admin/bhp/items/{id}
    public function destroy($id)
    {
        $item = ConsumableItem::find($id);

        if (!$item) {
            return response()->json(['success' => false, 'message' => 'Item tidak ditemukan'], 404);
        }

        $item->delete();

        return response()->json(['success' => true, 'message' => 'Item BHP berhasil dihapus']);
    }

    
}