<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenggunaanObatController extends Controller
{
    public function index(Request $request)
    {
        $dari    = $request->dari    ?? now()->startOfMonth()->toDateString();
        $sampai  = $request->sampai  ?? now()->toDateString();
        $search  = $request->search  ?? '';
        $perPage = $request->per_page ?? 10;

        // ID guarantor BPJS dari master_guarantor_type
        $bpjsId = DB::table('master_guarantor_type')
            ->where('name', 'like', '%BPJS%')
            ->value('id');

        $query = DB::table('procedure_medicine as pm')
            ->join('medicine as m', 'm.id', '=', 'pm.medicine_id')
            ->join('medical_procedure as mp', 'mp.id', '=', 'pm.procedure_id')
            ->join('registration as r', 'r.id', '=', 'mp.registration_id')
            ->whereBetween(DB::raw('DATE(mp.created_at)'), [$dari, $sampai])
            ->when($search, fn($q) => $q->where('m.medicine_name', 'like', "%$search%"))
            ->groupBy('m.id', 'm.medicine_name', 'm.current_stock', 'm.selling_price_general')
            ->select([
                'm.id',
                'm.medicine_name',
                'm.current_stock',
                'm.selling_price_general',

                // Penggunaan Umum = semua guarantor BPJS
                DB::raw("SUM(CASE WHEN r.guarantor_type_id != '$bpjsId' OR r.guarantor_type_id IS NULL 
                          THEN pm.quantity_used ELSE 0 END) as qty_umum"),

                // Penggunaan BPJS
                DB::raw("SUM(CASE WHEN r.guarantor_type_id = '$bpjsId' 
                          THEN pm.quantity_used ELSE 0 END) as qty_bpjs"),
            ]);

        $data = $query->paginate($perPage);

        // Hitung nominal per row
        $data->getCollection()->transform(function ($item) {
            $harga             = $item->selling_price_general ?? 0;
            $item->nominal_umum  = $item->qty_umum * $harga;
            $item->nominal_bpjs  = $item->qty_bpjs * $harga;
            return $item;
        });

        return response()->json([
            'success' => true,
            'data'    => $data,
            'filter'  => ['dari' => $dari, 'sampai' => $sampai],
        ]);
    }
}