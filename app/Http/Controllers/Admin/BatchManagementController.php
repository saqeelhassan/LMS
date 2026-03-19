<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BatchManagementController extends Controller
{
    public function index(Request $request): View
    {
        $batches = Batch::with(['course', 'instructor', 'branch', 'timetableSlots'])
            ->when($request->filled('course'), fn ($q) => $q->where('course_id', $request->course))
            ->when($request->filled('active'), function ($q) use ($request) {
                if ($request->active === '1') {
                    $q->where('is_active', true);
                } elseif ($request->active === '0') {
                    $q->where('is_active', false);
                }
            })
            ->orderBy('name')
            ->paginate(20)
            ->withQueryString();

        $instructors = User::with('userDetail')
            ->whereHas('role', fn ($q) => $q->where('name', 'Instructor'))
            ->where('is_active', true)
            ->orderBy('email')
            ->get();

        $courses = Course::orderBy('name')->get();

        return view('admin.batch-management.index', compact('batches', 'instructors', 'courses'));
    }

    public function assign(Request $request, Batch $batch): RedirectResponse
    {
        $request->validate([
            'instructor_id' => ['required', 'integer', 'exists:users,id'],
        ]);

        $batch->update(['instructor_id' => $request->instructor_id]);

        return redirect()
            ->route('admin.batch-management.index')
            ->with('success', 'Instructor assigned to batch.');
    }

    public function swap(Request $request, Batch $batch): RedirectResponse
    {
        $request->validate([
            'instructor_id' => ['required', 'integer', 'exists:users,id'],
        ]);

        $batch->update(['instructor_id' => $request->instructor_id]);

        return redirect()
            ->route('admin.batch-management.index')
            ->with('success', 'Instructor swapped. New instructor has access to the batch.');
    }

    public function remove(Batch $batch): RedirectResponse
    {
        $batch->update(['instructor_id' => null]);

        return redirect()
            ->route('admin.batch-management.index')
            ->with('success', 'Instructor removed. Batch is now vacant.');
    }
}
