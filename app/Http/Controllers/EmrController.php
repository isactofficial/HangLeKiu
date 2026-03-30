<?php

namespace App\Http\Controllers;

use App\Models\Appointment; 
use Illuminate\Http\Request;
use Carbon\Carbon;

class EmrController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil input pencarian jika ada
        $search = $request->get('search');

        // 2. Data Pasien HARI INI (Untuk Sidebar Atas)
        $todayPatients = Appointment::with(['patient', 'doctor'])
            ->whereDate('appointment_datetime', Carbon::today())
            ->when($search, function($query) use ($search) {
                $query->whereHas('patient', function($q) use ($search) {
                    $q->where('full_name', 'like', "%{$search}%");
                });
            })
            ->orderBy('appointment_datetime', 'asc')
            ->get();

        // 3. SEMUA Data Pasien (Untuk Sidebar Bawah)
        $allPatients = Appointment::with(['patient', 'doctor'])
            ->when($search, function($query) use ($search) {
                $query->whereHas('patient', function($q) use ($search) {
                    $q->where('full_name', 'like', "%{$search}%")
                      ->orWhere('medical_record_no', 'like', "%{$search}%");
                });
            })
            ->orderBy('appointment_datetime', 'desc')
            ->paginate(15);

        // 4. Kirim ke View
        return view('admin.pages.emr', compact('todayPatients', 'allPatients', 'search'));
    }

    // Fungsi untuk melihat detail EMR (nanti kita isi isinya)
    public function show(Request $request, $id)
{
    // Ambil data pendaftaran beserta relasi pasien dan dokternya
    $appointment = \App\Models\Appointment::with(['patient', 'doctor'])->findOrFail($id);

    // Jika request datang dari AJAX (klik sidebar), kirimkan isi tengah saja
    if ($request->ajax()) {
        return view('admin.components.emr.patient-detail-partial', compact('appointment'))->render();
    }

    // Fallback jika diakses manual lewat URL (opsional)
    return redirect()->route('admin.emr');
}

public function indexCashier()
{
    // Ambil semua janji temu yang statusnya 'succeed' (siap bayar) 
    // atau yang sudah ada record di tabel medical_procedures (asumsi kita simpan pembayaran di sana)
    // Coba panggil relasi satu per satu
    $appointments = \App\Models\Appointment::with(['patient', 'doctor', 'medicalProcedures'])
        ->whereIn('status', ['succeed', 'finished'])
        ->orderBy('appointment_datetime', 'desc')
        ->get();

    return view('admin.pages.cashier', compact('appointments'));
}

}