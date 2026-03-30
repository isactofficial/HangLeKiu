<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PatientController extends Controller
{
	/**
     * POST /admin/patients
     * Simpan pasien baru dari admin (tidak wajib email/password).
     */
    public function storeFromAdmin(Request $request): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validate([
            'full_name'      => 'required|string|max:100',
            'date_of_birth'  => 'required|date',
            'gender'         => 'required|in:Male,Female',
            'blood_type'     => 'nullable|in:A,B,AB,O,unknown',
            'rhesus'         => 'nullable|in:+,-,unknown',
            'address'        => 'nullable|string|max:200',
            'phone_number'   => 'nullable|string|max:20',
            'city'           => 'nullable|string|max:50',
            'id_card_number' => 'nullable|string|max:20',
            'email'          => 'nullable|email|max:50|unique:patient,email', // Pastikan nama tabelnya benar 'patient'
            'religion'       => 'nullable|string|max:50',
            'education'      => 'nullable|string|max:50',
            'occupation'     => 'nullable|string|max:50',
            'marital_status' => 'nullable|string|max:50',
            'first_chat_date'=> 'nullable|date',
        ]);

        try {
            $patient = Patient::create([
                'id'               => (string) \Illuminate\Support\Str::uuid(),
                'full_name'        => $validated['full_name'],
                'date_of_birth'    => $validated['date_of_birth'],
                'gender'           => $validated['gender'],
                'blood_type'       => $validated['blood_type'] ?? null,
                'rhesus'           => $validated['rhesus'] ?? null,
                'address'          => $validated['address'] ?? null,
                'phone_number'     => $validated['phone_number'] ?? null,
                'city'             => $validated['city'] ?? null,
                'id_card_number'   => $validated['id_card_number'] ?? null,
                'email'            => $validated['email'] ?? null,
                'religion'         => $validated['religion'] ?? null,
                'education'        => $validated['education'] ?? null,
                'occupation'       => $validated['occupation'] ?? null,
                'marital_status'   => $validated['marital_status'] ?? null,
                'first_chat_date'  => $validated['first_chat_date'] ?? null,
                // --------------------------------------
                
                'medical_record_no'=> $this->generateMrn(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Pasien baru berhasil ditambahkan.',
                'data'    => $patient,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan data pasien.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

	/**
	 * GET /admin/patients/search?q=...
	 * Cari pasien berdasarkan nama atau MR no (untuk AJAX di modal Pendaftaran Baru).
	 */
	public function search(Request $request): JsonResponse
	{
		$q = $request->get('q', '');
		$patients = Patient::where('full_name', 'like', "%{$q}%")
			->orWhere('medical_record_no', 'like', "%{$q}%")
			->orderBy('full_name')
			->limit(10)
			->get(['id', 'full_name', 'medical_record_no', 'date_of_birth', 'gender', 'address', 'phone_number', 'id_card_number']);

		return response()->json([
			'success' => true,
			'data' => $patients,
		]);
	}

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
			'phone_number' => 'nullable|string|max:20',
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
				'password' => Hash::make($validated['password']),
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
				'phone_number' => $validated['phone_number'] ?? null,
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

	public function update(Request $request, string $id): JsonResponse
	{
		$patient = Patient::find($id);

		if (! $patient) {
			return response()->json([
				'success' => false,
				'message' => 'Data pasien tidak ditemukan',
			], 404);
		}

		$emailRule = Rule::unique('user', 'email');
		if ($patient->user_id) {
			$emailRule = $emailRule->ignore($patient->user_id, 'id');
		}

		$validated = $request->validate([
			'full_name' => 'sometimes|required|string|max:100',
			'email' => ['sometimes', 'required', 'email', 'max:50', $emailRule],
			'password' => 'sometimes|nullable|string|min:6',
			'date_of_birth' => 'sometimes|required|date',
			'gender' => 'sometimes|required|in:Male,Female',
			'blood_type' => 'sometimes|nullable|in:A,B,AB,O,unknown',
			'rhesus' => 'sometimes|nullable|in:+,-,unknown',
			'address' => 'sometimes|nullable|string|max:50',
			'phone_number' => 'sometimes|nullable|string|max:20',
			'city' => 'sometimes|nullable|string|max:50',
			'id_card_number' => 'sometimes|nullable|string|max:20',
			'allergy_history' => 'sometimes|nullable|string',
		]);

		try {
			$result = DB::transaction(function () use ($patient, $validated) {
				$user = null;
				if ($patient->user_id) {
					$user = User::find($patient->user_id);
				}

				if ($user) {
					$userPayload = [];
					if (array_key_exists('full_name', $validated)) {
						$userPayload['name'] = $validated['full_name'];
					}
					if (array_key_exists('email', $validated)) {
						$userPayload['email'] = $validated['email'];
					}
					if (array_key_exists('password', $validated) && ! empty($validated['password'])) {
						$userPayload['password'] = Hash::make($validated['password']);
					}

					if (! empty($userPayload)) {
						$user->update($userPayload);
					}
				}

				$patientPayload = $validated;
				unset($patientPayload['password']);
				$patient->update($patientPayload);

				$patient->refresh();
				if ($user) {
					$user->refresh();
				}

				return [
					'user' => $user,
					'patient' => $patient,
				];
			});

			return response()->json([
				'success' => true,
				'message' => 'Data pasien berhasil diperbarui',
				'data' => $result,
			], 200);
		} catch (\Exception $e) {
			return response()->json([
				'success' => false,
				'message' => 'Gagal memperbarui data pasien',
				'error' => $e->getMessage(),
			], 500);
		}
	}

	public function destroy(string $id): JsonResponse
	{
		$patient = Patient::find($id);

		if (! $patient) {
			return response()->json([
				'success' => false,
				'message' => 'Data pasien tidak ditemukan',
			], 404);
		}

		try {
			DB::transaction(function () use ($patient) {
				if ($patient->user_id) {
					$user = User::find($patient->user_id);
					if ($user) {
						$user->delete();
					}
				}

				$patient->delete();
			});

			return response()->json([
				'success' => true,
				'message' => 'Data pasien berhasil dihapus (soft delete)',
			], 200);
		} catch (\Exception $e) {
			return response()->json([
				'success' => false,
				'message' => 'Gagal menghapus data pasien',
				'error' => $e->getMessage(),
			], 500);
		}
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
