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
        $query = ConsumableRestock::with('item:id,item_code,item_name');

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
        $restock = ConsumableRestock::with('item')->find($id);

        if (!$restock) {
            return response()->json(['success' => false, 'message' => 'Data restock tidak ditemukan'], 404);
        }

        return response()->json(['success' => true, 'data' => $restock]);
    }

    // POST /api/admin/bhp/restock
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bhp_id'         => 'required|string|exists:consumable_items,id',
            'restock_type'   => 'required|in:restock,return',
            'quantity_added' => 'required|integer|min:1',
            'purchase_price' => 'required|numeric|min:0',
            'expiry_date'    => 'nullable|date',
            'batch_number'   => 'nullable|string|max:100',
            'notes'          => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $restock = ConsumableRestock::create($validator->validated());

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

        // Cek stok tidak jadi minus setelah dibatalkan
        $item = ConsumableItem::find($restock->bhp_id);
        if ($item->current_stock < $restock->quantity_added) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak bisa membatalkan restock. Stok saat ini lebih kecil dari jumlah restock.',
            ], 422);
        }

        $restock->delete();

        return response()->json(['success' => true, 'message' => 'Data restock BHP berhasil dihapus']);
    }
}