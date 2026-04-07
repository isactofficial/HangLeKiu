<?php

namespace App\Http\Controllers;

use App\Models\MasterCareType;
use App\Models\MasterProcedure;
use Illuminate\Http\Request;

class TreatmentPageController extends Controller
{
    /**
     * Display the public treatment services page.
     */
    public function index()
    {
        $procedures = MasterProcedure::with('careType')
            ->where('is_active', true)
            ->orderBy('name')
            ->orderBy('procedure_name')
            ->get();

        $groupedProcedures = $procedures->groupBy(function($item) {
            return $item->careType ? $item->careType->name : 'Layanan Umum';
        });

        return view('user.pages.perawatan', compact('groupedProcedures'));
    }
}
