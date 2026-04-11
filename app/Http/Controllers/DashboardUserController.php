<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\OdontogramRecord;
use App\Models\Treatment;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DashboardUserController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $patient = $user->patient;

        $totalVisits = 0;
        $upcomingAppointment = null;
        $activeRegistrations = $this->emptyPaginator('active_page');
        $recentAppointments = collect();
        $medicalHistoryRows = $this->emptyPaginator('history_page');
        $doctorNotesRows = $this->emptyPaginator('notes_page');
        $odontogramRows = $this->emptyPaginator('odontogram_page');

        $doctors = Doctor::active()
            ->orderBy('full_name')
            ->get(['id', 'full_name']);

        $treatments = Treatment::active()
            ->orderBy('procedure_name')
            ->get(['id', 'procedure_name']);

        if ($patient) {
            $totalVisits = Appointment::where('patient_id', $patient->id)
                ->where('status', 'succeed')
                ->count();

            $upcomingAppointment = Appointment::where('patient_id', $patient->id)
                ->whereIn('status', ['pending', 'confirmed', 'waiting', 'engaged'])
                ->with(['doctor', 'poli'])
                ->orderBy('appointment_datetime')
                ->first();

            $activeRegistrations = Appointment::where('patient_id', $patient->id)
                ->whereIn('status', ['pending', 'confirmed', 'waiting', 'engaged'])
                ->with(['doctor', 'poli', 'paymentMethod'])
                ->latest('appointment_datetime')
                ->paginate(7, ['*'], 'active_page');

            $recentAppointments = Appointment::where('patient_id', $patient->id)
                ->where('status', 'succeed')
                ->with(['doctor', 'medicalProcedures.doctorNotes.user'])
                ->latest('appointment_datetime')
                ->take(5)
                ->get();

            $medicalHistoryRows = Appointment::where('patient_id', $patient->id)
                ->where('status', 'succeed')
                ->with([
                    'doctor',
                    'poli',
                    'medicalProcedures' => function($q) {
                        $q->with([
                            'doctor',
                            'items.masterProcedure',
                            'medicines.medicine',
                            'assistants.doctor',
                            'bhpUsages.item'
                        ]);
                    }
                ])
                ->latest('appointment_datetime')
                ->paginate(7, ['*'], 'history_page');

            $doctorNotesCollection = collect();
            $completedAppointments = Appointment::where('patient_id', $patient->id)
                ->where('status', 'succeed')
                ->with([
                    'doctor',
                    'medicalProcedures' => function($q) {
                        $q->with([
                            'doctor',
                            'assistants.doctor',
                            'doctorNotes.user'
                        ]);
                    }
                ])
                ->latest('appointment_datetime')
                ->get();

            foreach ($completedAppointments as $appointment) {
                foreach ($appointment->medicalProcedures as $procedure) {
                    foreach ($procedure->doctorNotes as $note) {
                        $doctorNotesCollection->push((object) [
                            'id' => $note->id,
                            'appointment_datetime' => $appointment->appointment_datetime,
                            'doctor' => $procedure->doctor,
                            'assistants' => $procedure->assistants,
                            'notes' => $note->notes,
                        ]);
                    }
                }
            }

            $doctorNotesRows = $this->paginateCollection($doctorNotesCollection, 7, 'notes_page');

            $odontogramRows = OdontogramRecord::where('patient_id', $patient->id)
                ->with(['teeth', 'patient'])
                ->latest('examined_at')
                ->paginate(7, ['*'], 'odontogram_page');
        }

        return view('user.pages.dashboard', compact(
            'user',
            'patient',
            'totalVisits',
            'upcomingAppointment',
            'activeRegistrations',
            'recentAppointments',
            'medicalHistoryRows',
            'doctorNotesRows',
            'odontogramRows',
            'doctors',
            'treatments'
        ));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $patient = $user->patient;

        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:user,email,' . $user->id . ',id',
            'phone_number' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:Male,Female',
            'blood_type' => 'nullable|in:A,B,AB,O,unknown',
            'rhesus' => 'nullable|in:+,-,unknown',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'id_card_number' => 'nullable|string|max:20',
            'allergy_history' => 'nullable|string',
            'religion' => 'nullable|string|max:50',
            'education' => 'nullable|string|max:50',
            'occupation' => 'nullable|string|max:50',
            'marital_status' => 'nullable|string|max:50',
            'first_chat_date' => 'nullable|date',
            'photo_base64' => 'nullable|string',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->name = $validated['full_name'];
        $user->email = $validated['email'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        if ($patient) {
            $patient->update([
                'full_name' => $validated['full_name'],
                'email' => $validated['email'],
                'phone_number' => $validated['phone_number'] ?? null,
                'date_of_birth' => $validated['date_of_birth'] ?? null,
                'gender' => $validated['gender'] ?? null,
                'blood_type' => $validated['blood_type'] ?? null,
                'rhesus' => $validated['rhesus'] ?? null,
                'address' => $validated['address'] ?? null,
                'city' => $validated['city'] ?? null,
                'id_card_number' => $validated['id_card_number'] ?? null,
                'allergy_history' => $validated['allergy_history'] ?? null,
                'religion' => $validated['religion'] ?? null,
                'education' => $validated['education'] ?? null,
                'occupation' => $validated['occupation'] ?? null,
                'marital_status' => $validated['marital_status'] ?? null,
                'first_chat_date' => $validated['first_chat_date'] ?? null,
                'photo' => $request->filled('photo_base64') ? $request->photo_base64 : $patient->photo,
            ]);
        }

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }

    public function medicalHistory()
    {
        $patient = Auth::user()->patient;

        $appointments = $patient
            ? Appointment::where('patient_id', $patient->id)
                ->where('status', 'succeed')
                ->with(['doctor', 'medicalProcedures.doctorNotes.user'])
                ->latest('appointment_datetime')
                ->paginate(10)
            : collect();

        return view('user.pages.medical-history', compact('appointments'));
    }

    public function medicalHistoryDetail(string $appointmentId)
    {
        $patient = Auth::user()->patient;

        $appointment = Appointment::where('patient_id', $patient?->id)
            ->where('status', 'succeed')
            ->with(['doctor', 'medicalProcedures.doctorNotes.user'])
            ->findOrFail($appointmentId);

        return view('user.pages.medical-history-detail', compact('appointment'));
    }

    public function odontogramHistory()
    {
        $patient = Auth::user()->patient;

        $odontogramRecords = $patient
            ? OdontogramRecord::where('patient_id', $patient->id)
                ->with('teeth')
                ->latest('examined_at')
                ->paginate(10)
            : collect();

        return view('user.pages.odontogram-history', compact('odontogramRecords'));
    }

    public function odontogramDetail(string $recordId)
    {
        $patient = Auth::user()->patient;

        $record = OdontogramRecord::where('patient_id', $patient?->id)
            ->with('teeth')
            ->findOrFail($recordId);

        return view('user.pages.odontogram-detail', compact('record'));
    }

    private function paginateCollection(Collection $items, int $perPage, string $pageName): LengthAwarePaginator
    {
        $currentPage = LengthAwarePaginator::resolveCurrentPage($pageName);
        $currentItems = $items->forPage($currentPage, $perPage)->values();

        return new LengthAwarePaginator(
            $currentItems,
            $items->count(),
            $perPage,
            $currentPage,
            [
                'path' => request()->url(),
                'query' => request()->query(),
                'pageName' => $pageName,
            ]
        );
    }

    private function emptyPaginator(string $pageName): LengthAwarePaginator
    {
        return $this->paginateCollection(collect(), 7, $pageName);
    }
}