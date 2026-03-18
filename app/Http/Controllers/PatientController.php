<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PatientController extends Controller
{
	public function store(Request $request): JsonResponse
	{
		$validated = $request->validate([
			'full_name' => 'required|string|max:100',
			'email' => 'required|email|max:50|unique:user,email',
			'password' => 'required|string|min:6',
			'date_of_birth' => 'required|date',
			'gender' => 'required|in:Male,Female',
			'blood_type' => 'nullable|in:A,B,AB,O,unknown',
			'rhesus' => 'nullable|in:+,-,unknown',
			'address' => 'nullable|string|max:50',
			'city' => 'nullable|string|max:50',
			'id_card_number' => 'nullable|string|max:20',
			'allergy_history' => 'nullable|string',
		]);

		try {
			$rolePatient = Role::where('code', 'PAT')->first();

			if (! $rolePatient) {
				return response()->json([
					'success' => false,
					'message' => 'Role PAT tidak ditemukan. Jalankan seeder terlebih dahulu.',
				], 422);
			}

			$user = User::create([
				'id' => (string) Str::uuid(),
				'role_id' => $rolePatient->id,
				'name' => $validated['full_name'],
				'email' => $validated['email'],
				'password' => $validated['password'],
				'is_active' => true,
				'is_verified' => false,
			]);

			$patient = Patient::create([
				'id' => (string) Str::uuid(),
				'user_id' => $user->id,
				'full_name' => $validated['full_name'],
				'email' => $validated['email'],
				'medical_record_no' => $this->generateMrn(),
				'date_of_birth' => $validated['date_of_birth'],
				'gender' => $validated['gender'],
				'blood_type' => $validated['blood_type'] ?? null,
				'rhesus' => $validated['rhesus'] ?? null,
				'address' => $validated['address'] ?? null,
				'city' => $validated['city'] ?? null,
				'id_card_number' => $validated['id_card_number'] ?? null,
				'allergy_history' => $validated['allergy_history'] ?? null,
			]);

			return response()->json([
				'success' => true,
				'message' => 'User pasien dan data pasien berhasil dibuat',
				'data' => [
					'user' => $user,
					'patient' => $patient,
				],
			], 201);
		} catch (\Exception $e) {
			return response()->json([
				'success' => false,
				'message' => 'Gagal membuat user pasien',
				'error' => $e->getMessage(),
			], 500);
		}
	}

	public function index(): JsonResponse
	{
		$patients = Patient::orderByDesc('created_at')->get();

		return response()->json([
			'success' => true,
			'message' => 'Data pasien berhasil diambil',
			'data' => $patients,
			'count' => $patients->count(),
		], 200);
	}

	public function show(string $id): JsonResponse
	{
		$patient = Patient::find($id);

		if (! $patient) {
			return response()->json([
				'success' => false,
				'message' => 'Data pasien tidak ditemukan',
			], 404);
		}

		return response()->json([
			'success' => true,
			'message' => 'Data pasien berhasil diambil',
			'data' => $patient,
		], 200);
	}

	private function generateMrn(): string
	{
		$prefix = 'MR' . now()->format('Ymd');
		$counter = 1;
		$mrn = $prefix . str_pad((string) $counter, 4, '0', STR_PAD_LEFT);

		while (Patient::where('medical_record_no', $mrn)->exists()) {
			$counter++;
			$mrn = $prefix . str_pad((string) $counter, 4, '0', STR_PAD_LEFT);
		}

		return $mrn;
	}
}
