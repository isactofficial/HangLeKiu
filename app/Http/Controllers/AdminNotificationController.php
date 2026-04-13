<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AdminNotificationController extends Controller
{
    public function index()
    {
        $todayNotifs = Appointment::with(['patient','doctor','poli','paymentMethod'])
            ->where('status', 'pending')
            ->whereNull('admin_id')
            ->whereHas('patient')
            ->whereDate('created_at', today())
            ->orderByDesc('created_at')
            ->get();

        $upcomingNotifs = Appointment::with(['patient','doctor','poli','paymentMethod'])
            ->where('status', 'pending')
            ->whereNull('admin_id')
            ->whereHas('patient')
            ->whereDate('created_at', '<', today())
            ->orderByDesc('created_at')
            ->get();

        // 30 hari ke depan — tidak hilang walau ganti hari
        // whereHas('patient') — fix bug null patient
        $sistemNotifs = Appointment::with(['patient','doctor','poli','paymentMethod','admin'])
            ->whereNotNull('admin_id')
            ->whereHas('patient')
            ->where('appointment_datetime', '>=', now()->startOfDay())
            ->where('appointment_datetime', '<=', now()->addDays(30))
            ->orderByDesc('created_at')
            ->get();

        return view('admin.pages.notifications', compact(
            'todayNotifs',
            'upcomingNotifs',
            'sistemNotifs'
        ));
    }

    public function confirm(Appointment $appointment)
    {
        if ($appointment->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Hanya appointment pending yang bisa dikonfirmasi.',
            ], 422);
        }

        $appointment->update([
            'status'       => 'confirmed',
            'admin_id'     => auth()->id(),
            'confirmed_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Appointment berhasil dikonfirmasi.',
        ]);
    }

    public function reschedule(Request $request, Appointment $appointment)
    {
        $request->validate([
            'appointment_datetime' => 'required|date',
        ]);

        $appointment->update([
            'appointment_datetime' => $request->appointment_datetime,
            'admin_id'             => auth()->id(),
        ]);

        return response()->json([
            'success'      => true,
            'message'      => 'Jadwal berhasil diubah.',
            'new_datetime' => $appointment->appointment_datetime,
        ]);
    }

    public function markAllRead()
    {
        return response()->json(['success' => true]);
    }

    // NotificationController.php — tambah method
    public function count()
    {
        $count = Appointment::where('status', 'pending')
            ->whereNull('admin_id')
            ->whereHas('patient')
            ->count();
        return response()->json(['count' => $count]);
    }
}