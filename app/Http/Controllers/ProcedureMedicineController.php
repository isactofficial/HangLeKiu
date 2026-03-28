<?php

namespace App\Http\Controllers;

use App\Models\ProcedureMedicine;
use App\Models\Medicine;
use App\Models\StockMutation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ProcedureMedicineController extends Controller
{
    // ✅ GET semua data per procedure
    public function index(Request $request)
    {
        $query = ProcedureMedicine::with(['medicine']);

        if ($request->procedure_id) {
            $query->where('procedure_id', $request->procedure_id);
        }

        $data = $query->get();

        return response()->json([
            'success' => true,
            'message' => 'Data obat prosedur berhasil diambil',
            'data' => $data
        ]);
    }

    // ✅ SHOW detail
    public function show($id)
    {
        $procedureMedicine = ProcedureMedicine::with(['medicine'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $procedureMedicine
        ]);
    }

    // ✅ STORE
    public function store(Request $request)
    {
        $request->validate([
            'procedure_id'  => 'required|string|exists:medical_procedure,id',
            'medicine_id'   => 'required|string|exists:medicine,id',
            'quantity_used' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();

        try {
            $medicine = Medicine::findOrFail($request->medicine_id);

            // Cek stok cukup
            if ($medicine->current_stock < $request->quantity_used) {
                return response()->json([
                    'success' => false,
                    'message' => "Stok obat {$medicine->medicine_name} tidak cukup"
                ], 400);
            }

            // Simpan procedure medicine
            $procedureMedicine = ProcedureMedicine::create([
                'id'            => Str::uuid(),
                'procedure_id'  => $request->procedure_id,
                'medicine_id'   => $request->medicine_id,
                'quantity_used' => $request->quantity_used,
            ]);

            // Kurangi stok
            $medicine->decrement('current_stock', $request->quantity_used);

            // Catat ke stock_mutation
            StockMutation::create([
                'id'          => Str::uuid(),
                'medicine_id' => $request->medicine_id,
                'user_id'     => null,
                'type'        => 'out',
                'quantity'    => $request->quantity_used,
                'notes'       => 'Digunakan untuk prosedur ID: ' . $request->procedure_id,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Obat prosedur berhasil ditambahkan',
                'data'    => $procedureMedicine->load('medicine')
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    // ✅ DELETE
    public function destroy($id)
    {
        $procedureMedicine = ProcedureMedicine::findOrFail($id);

        DB::beginTransaction();

        try {
            $medicine = Medicine::find($procedureMedicine->medicine_id);

            // Kembalikan stok
            if ($medicine) {
                $medicine->increment('current_stock', $procedureMedicine->quantity_used);

                StockMutation::create([
                    'id'          => Str::uuid(),
                    'medicine_id' => $procedureMedicine->medicine_id,
                    'user_id'     => null,
                    'type'        => 'in',
                    'quantity'    => $procedureMedicine->quantity_used,
                    'notes'       => 'Rollback dari hapus obat prosedur ID: ' . $id,
                ]);
            }

            $procedureMedicine->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Obat prosedur berhasil dihapus'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}