<?php

namespace App\Http\Controllers;

use App\Models\ClinicProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ClinicProfileController extends Controller
{
    public function edit()
    {
        $profile = ClinicProfile::first();
        if (!$profile) {
            // Create a default if not exists (should be handled by seeder, but for safety)
            $profile = ClinicProfile::create([
                'id' => (string) Str::uuid(),
                'name' => 'Hanglekiu Dental Specialist',
                'operational_hours' => [
                    'monday' => '10.00 - 19.00',
                    'tuesday' => '10.00 - 19.00',
                    'wednesday' => '10.00 - 19.00',
                    'thursday' => '10.00 - 19.00',
                    'friday' => '10.00 - 19.00',
                    'saturday' => '10.00 - 13.00',
                    'sunday' => '10.00 - 13.00',
                ],
            ]);
        }

        return view('admin.pages.profile', compact('profile'));
    }

    public function update(Request $request)
    {
        $profile = ClinicProfile::first();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'operational_summary' => 'nullable|string',
            'operational_hours' => 'nullable|array',
        ]);

        if ($request->hasFile('logo')) {
            if ($profile->logo) {
                Storage::disk('public')->delete($profile->logo);
            }
            $validated['logo'] = $request->file('logo')->store('clinic', 'public');
        }

        $profile->update($validated);

        return redirect()->back()->with('success', 'Profil klinik berhasil diperbarui.');
    }
}
