<?php

namespace App\Http\Controllers;

use App\Models\ConsumableUsage;
use App\Models\ConsumableItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ConsumableUsageController extends Controller
{
    // GET /api/admin/bhp/usage
    public function index(Request $request)
    {
        $query = ConsumableUsage::with('item:id,item_code,item_name,current_stock');

        if ($request->filled('bhp_id')) {
            $query->where('bhp_id', $request->bhp_id);
        }

        if ($request->filled('usage_type')) {
            $query->where('usage_type', $request->usage_type);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('usage_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('usage_date', '<=', $request->date_to);
        }

        $usages = $query->orderByDesc('usage_date')->get();

        return response()->json(['success' => true, 'data' => $usages]);
    }

    // GET /api/admin/bhp/usage/{id}
    public function show($id)
    {
        $usage = ConsumableUsage::with('item:id,item_code,item_name,current_stock')->find($id);

        if (!$usage) {
            return response()->json(['success' => false, 'message' => 'Data usage tidak ditemukan'], 404);
        }

        return response()->json(['success' => true, 'data' => $usage]);
    }

    // POST /api/admin/bhp/usage
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bhp_id'        => 'required|string|exists:consumable_items,id',
            'treatment_id'  => 'nullable|string',
            'usage_type'    => 'required|in:umum,bpjs',
            'quantity_used' => 'required|integer|min:1',
            'unit_price'    => 'required|numeric|min:0',
            'usage_date'    => 'required|date',
            'notes'         => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        // Cek stok cukup
        $item = ConsumableItem::find($request->bhp_id);
        if ($item->current_stock < $request->quantity_used) {
            return response()->json([
                'success' => false,
                'message' => "Stok tidak cukup. Stok saat ini: {$item->current_stock}",
            ], 422);
        }

        $usage = ConsumableUsage::create($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Penggunaan BHP berhasil dicatat',
            'data'    => $usage->load('item:id,item_code,item_name,current_stock'),
        ], 201);
    }

    // DELETE /api/admin/bhp/usage/{id}
    public function destroy($id)
    {
        $usage = ConsumableUsage::find($id);

        if (!$usage) {
            return response()->json(['success' => false, 'message' => 'Data usage tidak ditemukan'], 404);
        }

        $usage->delete();

        return response()->json(['success' => true, 'message' => 'Data penggunaan BHP berhasil dihapus']);
    }
}