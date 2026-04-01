<?php

namespace App\Http\Controllers;

use App\Models\ConsumableExpiryLog;
use App\Models\ConsumableItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ConsumableExpiryLogController extends Controller
{
    // GET /api/admin/bhp/expiry
    public function index(Request $request)
    {
        $query = ConsumableExpiryLog::with('item:id,item_code,item_name');

        if ($request->filled('bhp_id')) {
            $query->where('bhp_id', $request->bhp_id);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('expiry_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('expiry_date', '<=', $request->date_to);
        }

        $logs = $query->orderByDesc('expiry_date')->get();

        return response()->json(['success' => true, 'data' => $logs]);
    }

    // GET /api/admin/bhp/expiry/{id}
    public function show($id)
    {
        $log = ConsumableExpiryLog::with('item')->find($id);

        if (!$log) {
            return response()->json(['success' => false, 'message' => 'Log kadaluarsa tidak ditemukan'], 404);
        }

        return response()->json(['success' => true, 'data' => $log]);
    }

    // POST /api/admin/bhp/expiry
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bhp_id'           => 'required|string|exists:consumable_items,id',
            'quantity_expired' => 'required|integer|min:1',
            'expiry_date'      => 'required|date',
            'notes'            => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        // Cek stok cukup untuk dicatat kadaluarsa
        $item = ConsumableItem::find($request->bhp_id);
        if ($item->current_stock < $request->quantity_expired) {
            return response()->json([
                'success' => false,
                'message' => "Jumlah kadaluarsa melebihi stok saat ini ({$item->current_stock}).",
            ], 422);
        }

        $log = ConsumableExpiryLog::create($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Log kadaluarsa BHP berhasil dicatat',
            'data'    => $log->load('item:id,item_code,item_name,current_stock'),
        ], 201);
    }

    // DELETE /api/admin/bhp/expiry/{id}
    public function destroy($id)
    {
        $log = ConsumableExpiryLog::find($id);

        if (!$log) {
            return response()->json(['success' => false, 'message' => 'Log kadaluarsa tidak ditemukan'], 404);
        }

        $log->delete();

        return response()->json(['success' => true, 'message' => 'Log kadaluarsa BHP berhasil dihapus']);
    }
}