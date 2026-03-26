<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\MedicineStockLog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MedicineController extends Controller
{
    // ✅ GET semua data + search + pagination
    public function index(Request $request)
    {
        $query = Medicine::query();

        if ($request->search) {
            $query->where('medicine_name', 'like', '%' . $request->search . '%');
        }

        $data = $query->paginate(10);

        return response()->json([
            'success' => true,
            'message' => 'Data obat berhasil diambil',
            'data' => $data
        ]);
    }

    // ✅ STORE (create)
    public function store(Request $request)
    {
        $request->validate([
            'medicine_name' => 'required|string|max:150',
            'category' => 'nullable|string|max:100',
            'unit' => 'nullable|string|max:50',
            'current_stock' => 'nullable|integer|min:0',
            'minimum_stock' => 'nullable|integer|min:0',
            'notes' => 'nullable|string'
        ]);

        $medicine = Medicine::create([
            'id' => Str::uuid(),
            'medicine_name' => $request->medicine_name,
            'category' => $request->category,
            'unit' => $request->unit,
            'current_stock' => $request->current_stock ?? 0,
            'minimum_stock' => $request->minimum_stock ?? 0,
            'notes' => $request->notes,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data obat berhasil ditambahkan',
            'data' => $medicine
        ]);
    }

    // ✅ SHOW (detail)
    public function show($id)
    {
        $medicine = Medicine::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $medicine,
            'is_low_stock' => $medicine->current_stock <= $medicine->minimum_stock
        ]);
    }

    // ✅ UPDATE (tanpa ubah stok langsung ❗)
    public function update(Request $request, $id)
    {
        $medicine = Medicine::findOrFail($id);

        $request->validate([
            'medicine_name' => 'required|string|max:150',
            'category' => 'nullable|string|max:100',
            'unit' => 'nullable|string|max:50',
            'minimum_stock' => 'nullable|integer|min:0',
            'notes' => 'nullable|string'
        ]);

        $medicine->update([
            'medicine_name' => $request->medicine_name,
            'category' => $request->category,
            'unit' => $request->unit,
            'minimum_stock' => $request->minimum_stock,
            'notes' => $request->notes,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data obat berhasil diupdate',
            'data' => $medicine
        ]);
    }

    // ✅ DELETE
    public function destroy($id)
    {
        $medicine = Medicine::findOrFail($id);
        $medicine->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data obat berhasil dihapus'
        ]);
    }

    // 🔥 STOCK IN (tambah stok)
    public function stockIn(Request $request, $id)
    {
        $request->validate([
            'qty' => 'required|integer|min:1',
            'note' => 'nullable|string'
        ]);

        $medicine = Medicine::findOrFail($id);

        // simpan log
        MedicineStockLog::create([
            'medicine_id' => $id,
            'type' => 'IN',
            'qty' => $request->qty,
            'note' => $request->note
        ]);

        // update stok
        $medicine->increment('current_stock', $request->qty);

        return response()->json([
            'success' => true,
            'message' => 'Stok berhasil ditambahkan',
            'current_stock' => $medicine->current_stock
        ]);
    }

    // 🔥 STOCK OUT (kurangi stok)
    public function stockOut(Request $request, $id)
    {
        $request->validate([
            'qty' => 'required|integer|min:1',
            'note' => 'nullable|string'
        ]);

        $medicine = Medicine::findOrFail($id);

        if ($medicine->current_stock < $request->qty) {
            return response()->json([
                'success' => false,
                'message' => 'Stok tidak cukup'
            ], 400);
        }

        // simpan log
        MedicineStockLog::create([
            'medicine_id' => $id,
            'type' => 'OUT',
            'qty' => $request->qty,
            'note' => $request->note
        ]);

        // update stok
        $medicine->decrement('current_stock', $request->qty);

        return response()->json([
            'success' => true,
            'message' => 'Stok berhasil dikurangi',
            'current_stock' => $medicine->current_stock
        ]);
    }

    // 🔥 HISTORY LOG STOK
    public function stockHistory($id)
    {
        $medicine = Medicine::findOrFail($id);

        $logs = MedicineStockLog::where('medicine_id', $id)
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'medicine' => $medicine->medicine_name,
            'data' => $logs
        ]);
    }
}