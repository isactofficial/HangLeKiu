<?php

namespace App\Http\Controllers;

use App\Models\ConsumableRestock;
use App\Models\ConsumableItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ConsumableRestockController extends Controller
{
    // GET /api/admin/bhp/restock
    public function index(Request $request)
    {
        $query = ConsumableRestock::with('item:id,item_code,item_name,current_stock');

        if ($request->filled('bhp_id')) {
            $query->where('bhp_id', $request->bhp_id);
        }

        if ($request->filled('restock_type')) {
            $query->where('restock_type', $request->restock_type);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $restocks = $query->orderByDesc('created_at')->get();

        return response()->json(['success' => true, 'data' => $restocks]);
    }

    // GET /api/admin/bhp/restock/{id}
    public function show($id)
    {
        $restock = ConsumableRestock::with('item:id,item_code,item_name,current_stock')->find($id);

        if (!$restock) {
            return response()->json(['success' => false, 'message' => 'Data restock tidak ditemukan'], 404);
        }

        return response()->json(['success' => true, 'data' => $restock]);
    }

    // POST /api/admin/bhp/restock
    public function store(Request $request)
    {
        $rules = [
            'bhp_id'       => 'required|string|exists:consumable_items,id',
            'restock_type' => 'required|in:restock,return',
            'batch_number' => 'nullable|string|max:100',
            'supplier_id'  => 'nullable|string',
            'notes'        => 'nullable|string',
        ];

        if ($request->restock_type === 'restock') {
            $rules['quantity_added']    = 'required|integer|min:1';
            $rules['quantity_returned'] = 'nullable|integer|min:0';
            $rules['purchase_price']    = 'required|numeric|min:0';
            $rules['expiry_date']       = 'nullable|date';
        } else {
            // return
            $rules['quantity_returned'] = 'required|integer|min:1';
            $rules['quantity_added']    = 'nullable|integer|min:0';
            $rules['purchase_price']    = 'nullable|numeric|min:0';
            $rules['expiry_date']       = 'nullable|date';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $validated = $validator->validated();

        // Set default value supaya tidak null di database
        $validated['quantity_added']    = $validated['quantity_added'] ?? 0;
        $validated['quantity_returned'] = $validated['quantity_returned'] ?? 0;

        $restock = ConsumableRestock::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Restock BHP berhasil dicatat',
            'data'    => $restock->load('item:id,item_code,item_name,current_stock'),
        ], 201);
    }

    // DELETE /api/admin/bhp/restock/{id}
    public function destroy($id)
    {
        $restock = ConsumableRestock::find($id);

        if (!$restock) {
            return response()->json(['success' => false, 'message' => 'Data restock tidak ditemukan'], 404);
        }

        $item = ConsumableItem::find($restock->bhp_id);

        if (!$item) {
            return response()->json(['success' => false, 'message' => 'Item BHP tidak ditemukan'], 404);
        }

        // Validasi stok sesuai tipe transaksi
        if ($restock->restock_type === 'restock' && $item->current_stock < $restock->quantity_added) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak bisa membatalkan restock. Stok saat ini lebih kecil dari jumlah restock.',
            ], 422);
        }

        if ($restock->restock_type === 'return' && $item->current_stock < $restock->quantity_returned) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak bisa membatalkan return. Stok saat ini lebih kecil dari jumlah return.',
            ], 422);
        }

        $restock->delete();

        return response()->json(['success' => true, 'message' => 'Data restock BHP berhasil dihapus']);
    }
}