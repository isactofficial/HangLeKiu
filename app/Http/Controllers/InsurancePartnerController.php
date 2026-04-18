<?php

namespace App\Http\Controllers;

use App\Models\InsurancePartner;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class InsurancePartnerController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = InsurancePartner::query();

            if ($request->filled('active') && (bool)(int) $request->active) {
                $query->active();
            }

            if ($request->filled('search')) {
                $keyword = $request->search;
                $query->where('name', 'like', "%{$keyword}%");
            }

            $perPage = max(1, (int)($request->per_page ?? 10));
            $data    = $query->ordered()->paginate($perPage);

            return response()->json(['success' => true, 'data' => $data]);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $item = InsurancePartner::findOrFail($id);
            return response()->json(['success' => true, 'data' => $item]);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'message' => 'Tidak ditemukan'], 404);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name'      => 'required|string|max:100',
                'order'     => 'nullable|integer|min:0|max:999',
                'logo'      => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:5120',
                'is_active' => 'nullable',
            ]);

            $logoPath = null;
            if ($request->hasFile('logo')) {
                $logoPath = $request->file('logo')->store('insurance_partners', 'public');
            }

            $item = InsurancePartner::create([
                'id'        => (string) Str::uuid(),
                'name'      => $request->name,
                'order'     => (int)($request->order ?? 0),
                'is_active' => filter_var($request->input('is_active', true), FILTER_VALIDATE_BOOLEAN),
                'logo'      => $logoPath,
            ]);

            return response()->json(['success' => true, 'message' => 'Partner asuransi berhasil ditambahkan', 'data' => $item], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['success' => false, 'message' => 'Validasi gagal', 'errors' => $e->errors()], 422);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $item = InsurancePartner::findOrFail($id);

            $request->validate([
                'name'      => 'required|string|max:100',
                'order'     => 'nullable|integer|min:0|max:999',
                'logo'      => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:5120',
                'is_active' => 'nullable',
            ]);

            $logoPath = $item->logo;
            if ($request->hasFile('logo')) {
                $this->deleteLogo($item->logo);
                $logoPath = $request->file('logo')->store('insurance_partners', 'public');
            }

            $item->update([
                'name'      => $request->name,
                'order'     => (int)($request->order ?? 0),
                'is_active' => filter_var($request->input('is_active', $item->is_active), FILTER_VALIDATE_BOOLEAN),
                'logo'      => $logoPath,
            ]);

            return response()->json(['success' => true, 'message' => 'Partner asuransi berhasil diupdate', 'data' => $item->fresh()]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['success' => false, 'message' => 'Validasi gagal', 'errors' => $e->errors()], 422);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $item = InsurancePartner::findOrFail($id);
            $this->deleteLogo($item->logo);
            $item->delete();
            return response()->json(['success' => true, 'message' => 'Partner asuransi berhasil dihapus']);
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() === '23000') {
                return response()->json(['success' => false, 'message' => 'Partner asuransi tidak bisa dihapus karena sudah berhubungan dengan data lain'], 422);
            }
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    private function deleteLogo(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
