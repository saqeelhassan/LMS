<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Branch;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BatchController extends Controller
{
    public function index(Request $request): View
    {
        $batches = Batch::with(['course', 'instructor', 'branch'])
            ->when($request->filled('course'), fn ($q) => $q->where('course_id', $request->course))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $courses = Course::orderBy('name')->get();

        return view('super-admin.batches.index', compact('batches', 'courses'));
    }

    public function create(): View
    {
        $courses = Course::orderBy('name')->get();
        $instructors = User::whereHas('role', fn ($q) => $q->where('name', 'Instructor'))->where('is_active', true)->orderBy('email')->get();
        $branches = Branch::where('is_active', true)->orderBy('name')->get();

        return view('super-admin.batches.create', compact('courses', 'instructors', 'branches'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'course_id' => ['required', 'integer', 'exists:courses,id'],
            'name' => ['required', 'string', 'max:255'],
            'instructor_id' => ['nullable', 'integer', 'exists:users,id'],
            'branch_id' => ['nullable', 'integer', 'exists:branches,id'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'schedule_note' => ['nullable', 'string', 'max:500'],
            'monthly_fee' => ['nullable', 'numeric', 'min:0'],
        ]);

        Batch::create([
            ...$validated,
            'monthly_fee' => $request->filled('monthly_fee') ? $validated['monthly_fee'] : null,
        ]);

        return redirect()->route('super-admin.batches.index')->with('success', 'Batch created.');
    }

    public function edit(Batch $batch): View
    {
        $courses = Course::orderBy('name')->get();
        $instructors = User::whereHas('role', fn ($q) => $q->where('name', 'Instructor'))->where('is_active', true)->orderBy('email')->get();
        $branches = Branch::where('is_active', true)->orderBy('name')->get();

        return view('super-admin.batches.edit', compact('batch', 'courses', 'instructors', 'branches'));
    }

    public function update(Request $request, Batch $batch): RedirectResponse
    {
        $validated = $request->validate([
            'course_id' => ['required', 'integer', 'exists:courses,id'],
            'name' => ['required', 'string', 'max:255'],
            'instructor_id' => ['nullable', 'integer', 'exists:users,id'],
            'branch_id' => ['nullable', 'integer', 'exists:branches,id'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date'],
            'schedule_note' => ['nullable', 'string', 'max:500'],
            'monthly_fee' => ['nullable', 'numeric', 'min:0'],
            'is_active' => ['boolean'],
        ]);

        $batch->update([
            ...$validated,
            'is_active' => $request->boolean('is_active'),
            'monthly_fee' => $request->filled('monthly_fee') ? $validated['monthly_fee'] : null,
        ]);

        return redirect()->route('super-admin.batches.index')->with('success', 'Batch updated.');
    }

    public function destroy(Batch $batch): RedirectResponse
    {
        $batch->delete();

        return redirect()->route('super-admin.batches.index')->with('success', 'Batch removed.');
    }
}
