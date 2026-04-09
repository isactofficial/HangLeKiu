<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class MasterTestimonialController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Testimonial::query();

            // ✅ FIXED: Always filter active=1 for home page, use scope for consistency
            if ($request->filled('active') && (bool)(int) $request->active) {
                $query->active(); // Uses model scopeActive()
            }

            // Log for debugging
            \Log::info('Testimonial index called', [
                'active_param' => $request->get('active'),
                'total_before_filter' => $query->count(),
            ]);

            if ($request->filled('search')) {
                $keyword = $request->search;
                $query->where(function ($q) use ($keyword) {
                    $q->where('name', 'like', "%{$keyword}%")
                      ->orWhere('profession', 'like', "%{$keyword}%");
                });
            }

            $perPage = max(1, (int)($request->per_page ?? 10));
            $data    = $query->paginate($perPage);

            return response()->json(['success' => true, 'data' => $data]);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $item = Testimonial::findOrFail($id);
            return response()->json(['success' => true, 'data' => $item]);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'message' => 'Tidak ditemukan'], 404);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name'          => 'required|string|max:100',
                'profession'    => 'nullable|string|max:100',
                'comment'       => 'required|string',
                'order'         => 'nullable|integer|min:0|max:999',
                'cropped_photo' => 'nullable|string',
                'photo'         => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
                'is_active'     => 'nullable',
            ]);

            $photoPath = null;
            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->store('testimonials', 'public');
            } elseif ($request->filled('cropped_photo')) {
                $photoPath = $this->saveCroppedPhoto($request->input('cropped_photo'));
            }

            $item = Testimonial::create([
                'id'         => (string) Str::uuid(),
                'name'       => $request->name,
                'profession' => $request->profession,
                'comment'    => $request->comment,
                'order'      => (int)($request->order ?? 0),
                'is_active'  => filter_var($request->input('is_active', true), FILTER_VALIDATE_BOOLEAN),
                'photo'      => $photoPath,
            ]);

            return response()->json(['success' => true, 'message' => 'Testimonial berhasil ditambahkan', 'data' => $item], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['success' => false, 'message' => 'Validasi gagal', 'errors' => $e->errors()], 422);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $item = Testimonial::findOrFail($id);

            $request->validate([
                'name'          => 'required|string|max:100',
                'profession'    => 'nullable|string|max:100',
                'comment'       => 'required|string',
                'order'         => 'nullable|integer|min:0|max:999',
                'cropped_photo' => 'nullable|string',
                'photo'         => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
                'is_active'     => 'nullable',
            ]);

            $photoPath = $item->photo;
            if ($request->hasFile('photo')) {
                $this->deletePhoto($item->photo);
                $photoPath = $request->file('photo')->store('testimonials', 'public');
            } elseif ($request->filled('cropped_photo')) {
                $this->deletePhoto($item->photo);
                $photoPath = $this->saveCroppedPhoto($request->input('cropped_photo'));
            }

            $item->update([
                'name'       => $request->name,
                'profession' => $request->profession,
                'comment'    => $request->comment,
                'order'      => (int)($request->order ?? 0),
                'is_active'  => filter_var($request->input('is_active', $item->is_active), FILTER_VALIDATE_BOOLEAN),
                'photo'      => $photoPath,
            ]);

            return response()->json(['success' => true, 'message' => 'Testimonial berhasil diupdate', 'data' => $item->fresh()]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['success' => false, 'message' => 'Validasi gagal', 'errors' => $e->errors()], 422);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['success' => false, 'message' => 'Tidak ditemukan'], 404);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $item = Testimonial::findOrFail($id);
            $this->deletePhoto($item->photo);
            $item->delete();
            return response()->json(['success' => true, 'message' => 'Testimonial berhasil dihapus']);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['success' => false, 'message' => 'Tidak ditemukan'], 404);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    private function saveCroppedPhoto(string $base64): string
    {
        $clean     = preg_replace('/^data:image\/[a-z]+;base64,/', '', $base64);
        $imageData = base64_decode($clean);
        if ($imageData === false || strlen($imageData) < 100) {
            throw new \RuntimeException('Data foto tidak valid');
        }
        $filename = 'testimonials/cropped_' . Str::uuid() . '.jpg';
        Storage::disk('public')->put($filename, $imageData);
        return $filename;
    }

    private function deletePhoto(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}