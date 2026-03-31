<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OfficeController extends Controller
{
    public function index(Request $request)
    {
        $activeTab = $request->get('tab', 'summary');
        $activeMenu = $request->get('menu', 'dashboard-harian');

        if ($activeMenu === 'pasien') {
            return $this->handlePasienMenu($request);
        }

        return view('admin.layout.office');
    }

    private function handlePasienMenu(Request $request)
    {
        $tab = $request->get('tab', 'summary');
        
        // 1. Stats
        $totalPatients = Patient::count();
        $newPatientsThisMonth = Patient::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        $walkInToday = Appointment::whereDate('appointment_datetime', now()->toDateString())->count();

        // 2. Trend Data (Last 14 Days)
        $trendDates = collect();
        for ($i = 13; $i >= 0; $i--) {
            $trendDates->put(now()->subDays($i)->toDateString(), 0);
        }

        $registrations = Patient::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
            ->where('created_at', '>=', now()->subDays(13)->startOfDay())
            ->groupBy('date')
            ->get()
            ->pluck('total', 'date');
        
        $trendData = $trendDates->merge($registrations);

        // 3. Upcoming Birthdays (Next 7 Days)
        $upcomingBirthdays = Patient::whereRaw("DATE_FORMAT(date_of_birth, '%m-%d') BETWEEN ? AND ?", [
            now()->format('m-d'),
            now()->addDays(7)->format('m-d')
        ])->get();

        // 3. Chart Data (Blood Type & Education)
        $bloodTypeStats = Patient::select('blood_type', DB::raw('count(*) as total'))
            ->groupBy('blood_type')
            ->get()
            ->pluck('total', 'blood_type')
            ->toArray();

        $educationStats = Patient::select('education', DB::raw('count(*) as total'))
            ->groupBy('education')
            ->get()
            ->pluck('total', 'education')
            ->toArray();

        // 4. Patient Table with Social Search
        $search = $request->get('search');
        $patients = Patient::with(['latestAppointment.guarantorType'])
            ->when($search, function($query) use ($search) {
                $query->where('full_name', 'like', "%{$search}%")
                      ->orWhere('medical_record_no', 'like', "%{$search}%")
                      ->orWhere('id_card_number', 'like', "%{$search}%");
            })
            ->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();

        return view('admin.layout.office', compact(
            'totalPatients',
            'newPatientsThisMonth',
            'walkInToday',
            'trendData',
            'upcomingBirthdays',
            'bloodTypeStats',
            'educationStats',
            'patients'
        ));
    }
}
