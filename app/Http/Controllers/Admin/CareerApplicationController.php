<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CareerApplication;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

/**
 * Website Operations: View and delete job applications from the career form.
 */
class CareerApplicationController extends Controller
{
    /**
     * Fetching all career applications for admin list (latest first).
     */
    public function index(): View
    {
        $applications = CareerApplication::latest()->paginate(20);

        return view('admin.career-applications.index', compact('applications'));
    }

    public function destroy(CareerApplication $career_application): RedirectResponse
    {
        if ($career_application->resume_path && Storage::disk('public')->exists($career_application->resume_path)) {
            Storage::disk('public')->delete($career_application->resume_path);
        }
        $career_application->delete();

        return redirect()->route('admin.career-applications.index')->with('success', 'Application deleted.');
    }
}
