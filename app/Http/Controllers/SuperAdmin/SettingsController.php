<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function index(): View
    {
        return view('super-admin.settings.index');
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'academic_year' => ['nullable', 'string', 'max:50'],
            'currency' => ['nullable', 'string', 'max:10'],
            'institute_name' => ['nullable', 'string', 'max:255'],
            'logo' => ['nullable', 'image', 'max:2048'],
            'attendance_allowed_ips' => ['nullable', 'string', 'max:500'],
            'fees_validity_day' => ['nullable', 'integer', 'min:1', 'max:28'],
            'fees_auto_block' => ['nullable', 'in:0,1'],
            'fees_require_approval' => ['nullable', 'in:0,1'],
            'attendance_fine_enabled' => ['nullable', 'in:0,1'],
            'attendance_fine_per_absence' => ['nullable', 'numeric', 'min:0'],
            'attendance_fine_per_late' => ['nullable', 'numeric', 'min:0'],
        ]);

        if (!empty($validated['academic_year'])) {
            Setting::set('academic_year', $validated['academic_year']);
        }
        if (!empty($validated['currency'])) {
            Setting::set('currency', $validated['currency']);
        }
        if (!empty($validated['institute_name'])) {
            Setting::set('institute_name', $validated['institute_name']);
        }
        if (array_key_exists('attendance_allowed_ips', $validated)) {
            Setting::set('attendance_allowed_ips', $validated['attendance_allowed_ips'] ?? '');
        }
        if (array_key_exists('fees_validity_day', $validated) && $validated['fees_validity_day'] !== null && $validated['fees_validity_day'] !== '') {
            Setting::set('fees_validity_day', (string) $validated['fees_validity_day']);
        }
        if (array_key_exists('fees_auto_block', $validated)) {
            Setting::set('fees_auto_block', $request->boolean('fees_auto_block') ? '1' : '0');
        }
        if (array_key_exists('fees_require_approval', $validated)) {
            Setting::set('fees_require_approval', $request->boolean('fees_require_approval') ? '1' : '0');
        }
        if (array_key_exists('attendance_fine_enabled', $validated)) {
            Setting::set('attendance_fine_enabled', $request->boolean('attendance_fine_enabled') ? '1' : '0');
        }
        if (array_key_exists('attendance_fine_per_absence', $validated) && $validated['attendance_fine_per_absence'] !== null) {
            Setting::set('attendance_fine_per_absence', (string) $validated['attendance_fine_per_absence']);
        }
        if (array_key_exists('attendance_fine_per_late', $validated) && $validated['attendance_fine_per_late'] !== null) {
            Setting::set('attendance_fine_per_late', (string) $validated['attendance_fine_per_late']);
        }

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('logos', 'public');
            Setting::set('logo', $path);
        }

        return redirect()->route('super-admin.settings.index')->with('success', 'Settings saved.');
    }
}
