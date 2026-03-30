<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\StockMutation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MedicineController extends Controller
{
    // ✅ GET semua data + search + pagination
    public function index(Request $request)
    {
        $query = Medicine::query();

        if ($request->search) {
            $query->where('medicine_name', 'like', '%' . $request->search . '%')
                  ->orWhere('medicine_code', 'like', '%' . $request->search . '%')
                  ->orWhere('category', 'like', '%' . $request->search . '%');
        }

        $data = $query->paginate(10);

        // Tambahkan margin_profit_percent ke tiap item
        $data->getCollection()->transform(function ($item) {
            $item->margin_profit_percent = $this->hitungMargin($item);
            return $item;
        });

        return response()->json([
            'success' => true,
            'message' => 'Data obat berhasil diambil',
            'data'    => $data
        ]);
    }

    // ✅ STORE (create)
    public function store(Request $request)
    {
        $request->validate([
            'medicine_code'         => 'nullable|string|max:20|unique:medicine,medicine_code',
            'medicine_name'         => 'required|string|max:150',
            'manufacturer'          => 'nullable|string|max:100',
            'medicine_type'         => 'nullable|in:Tablet,Kapsul,Cairan,Injeksi,Salep,Lainnya',
            'category'              => 'nullable|string|max:100',
            'unit'                  => 'nullable|string|max:50',
            'current_stock'         => 'nullable|integer|min:0',
            'minimum_stock'         => 'nullable|integer|min:0',
            'purchase_price'        => 'nullable|numeric|min:0',
            'selling_price_general' => 'nullable|numeric|min:0',
            'selling_price_otc'     => 'nullable|numeric|min:0',
            'notes'                 => 'nullable|string',
        ]);

        $medicine = Medicine::create([
            'id'                    => Str::uuid(),
            'medicine_code'         => $request->medicine_code,
            'medicine_name'         => $request->medicine_name,
            'manufacturer'          => $request->manufacturer,
            'medicine_type'         => $request->medicine_type,
            'category'              => $request->category,
            'unit'                  => $request->unit,
            'current_stock'         => $request->current_stock ?? 0,
            'minimum_stock'         => $request->minimum_stock ?? 0,
            'purchase_price'        => $request->purchase_price,
            'selling_price_general' => $request->selling_price_general,
            'selling_price_otc'     => $request->selling_price_otc,
            // avg_hpp awal = purchase_price saat pertama input
            'avg_hpp'               => $request->purchase_price,
            'notes'                 => $request->notes,
        ]);

        $medicine->margin_profit_percent = $this->hitungMargin($medicine);

        return response()->json([
            'success' => true,
            'message' => 'Data obat berhasil ditambahkan',
            'data'    => $medicine
        ], 201);
    }

    // ✅ SHOW (detail)
    public function show($id)
    {
        $medicine = Medicine::findOrFail($id);
        $medicine->margin_profit_percent = $this->hitungMargin($medicine);

        return response()->json([
            'success'       => true,
            'data'          => $medicine,
            'is_low_stock'  => $medicine->current_stock <= $medicine->minimum_stock
        ]);
    }

    // ✅ UPDATE (tanpa ubah stok langsung)
    public function update(Request $request, $id)
    {
        $medicine = Medicine::findOrFail($id);

        $request->validate([
            'medicine_code'         => 'nullable|string|max:20|unique:medicine,medicine_code,' . $id,
            'medicine_name'         => 'required|string|max:150',
            'manufacturer'          => 'nullable|string|max:100',
            'medicine_type'         => 'nullable|in:Tablet,Kapsul,Cairan,Injeksi,Salep,Lainnya',
            'category'              => 'nullable|string|max:100',
            'unit'                  => 'nullable|string|max:50',
            'minimum_stock'         => 'nullable|integer|min:0',
            'purchase_price'        => 'nullable|numeric|min:0',
            'selling_price_general' => 'nullable|numeric|min:0',
            'selling_price_otc'     => 'nullable|numeric|min:0',
            'notes'                 => 'nullable|string',
        ]);

        $medicine->update([
            'medicine_code'         => $request->medicine_code,
            'medicine_name'         => $request->medicine_name,
            'manufacturer'          => $request->manufacturer,
            'medicine_type'         => $request->medicine_type,
            'category'              => $request->category,
            'unit'                  => $request->unit,
            'minimum_stock'         => $request->minimum_stock,
            'purchase_price'        => $request->purchase_price,
            'selling_price_general' => $request->selling_price_general,
            'selling_price_otc'     => $request->selling_price_otc,
            'notes'                 => $request->notes,
            'avg_hpp'               => $request->avg_hpp ?? $medicine->avg_hpp,
        ]);

        $medicine->margin_profit_percent = $this->hitungMargin($medicine);

        return response()->json([
            'success' => true,
            'message' => 'Data obat berhasil diupdate',
            'data'    => $medicine
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

    // 🔥 STOCK IN (tambah stok + hitung ulang avg_hpp)
    public function stockIn(Request $request, $id)
    {
        $request->validate([
            'qty'        => 'required|integer|min:1',
            'unit_price' => 'nullable|numeric|min:0',
            'note'       => 'nullable|string',
            'avg_hpp' => 'nullable|numeric|min:0',
        ]);

        $medicine     = Medicine::findOrFail($id);
        $stockBefore  = $medicine->current_stock;
        $qty          = $request->qty;
        $unitPrice    = $request->unit_price ?? $medicine->purchase_price ?? 0;

        // Hitung avg_hpp baru pakai weighted average
        $avgHppBaru = 0;
        if (($stockBefore + $qty) > 0) {
            $avgHppBaru = (($stockBefore * ($medicine->avg_hpp ?? 0)) + ($qty * $unitPrice))
                          / ($stockBefore + $qty);
        }

        // Simpan ke stock_mutation
        StockMutation::create([
            'id'           => Str::uuid(),
            'medicine_id'  => $id,
            'user_id'      => null,
            'type'         => 'in',
            'quantity'     => $qty,
            'stock_before' => $stockBefore,
            'stock_after'  => $stockBefore + $qty,
            'unit_price'   => $unitPrice,
            'notes'        => $request->note,
        ]);

        // Update stok + avg_hpp
        $medicine->update([
            'current_stock' => $stockBefore + $qty,
            'avg_hpp'       => round($avgHppBaru, 2),
            'purchase_price'=> $unitPrice,
        ]);

        return response()->json([
            'success'       => true,
            'message'       => 'Stok berhasil ditambahkan',
            'current_stock' => $medicine->current_stock,
            'avg_hpp'       => $medicine->avg_hpp,
        ]);
    }

    // 🔥 STOCK OUT (kurangi stok)
    public function stockOut(Request $request, $id)
    {
        $request->validate([
            'qty'  => 'required|integer|min:1',
            'note' => 'nullable|string',
        ]);

        $medicine    = Medicine::findOrFail($id);
        $stockBefore = $medicine->current_stock;

        if ($stockBefore < $request->qty) {
            return response()->json([
                'success' => false,
                'message' => 'Stok tidak cukup'
            ], 400);
        }

        // Simpan ke stock_mutation
        StockMutation::create([
            'id'           => Str::uuid(),
            'medicine_id'  => $id,
            'user_id'      => null,
            'type'         => 'out',
            'quantity'     => $request->qty,
            'stock_before' => $stockBefore,
            'stock_after'  => $stockBefore - $request->qty,
            'unit_price'   => null,
            'notes'        => $request->note,
        ]);

        // Update stok
        $medicine->decrement('current_stock', $request->qty);

        return response()->json([
            'success'       => true,
            'message'       => 'Stok berhasil dikurangi',
            'current_stock' => $medicine->fresh()->current_stock,
        ]);
    }

    // 🔥 HISTORY LOG STOK
    public function stockHistory($id)
    {
        $medicine = Medicine::findOrFail($id);

        $logs = StockMutation::where('medicine_id', $id)
            ->latest()
            ->get();

        return response()->json([
            'success'  => true,
            'medicine' => $medicine->medicine_name,
            'data'     => $logs
        ]);
    }

    // ── PRIVATE HELPER ───────────────────────────────────────
    private function hitungMargin(Medicine $medicine): float|null
    {
        if (!$medicine->selling_price_general || !$medicine->avg_hpp) return null;
        if ($medicine->selling_price_general == 0) return null;

        return round(
            (($medicine->selling_price_general - $medicine->avg_hpp) / $medicine->selling_price_general) * 100,
            2
        );
    }
    
}