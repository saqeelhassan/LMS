<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Branch;
use App\Models\Course;
use App\Models\TimetableSlot;
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

        return view('admin.batches.index', compact('batches', 'courses'));
    }

    public function create(): View
    {
        $courses = Course::orderBy('name')->get();
        $instructors = User::whereHas('role', fn ($q) => $q->where('name', 'Instructor'))->where('is_active', true)->with('userDetail')->orderBy('email')->get();
        $branches = Branch::where('is_active', true)->orderBy('name')->get();

        return view('admin.batches.create', compact('courses', 'instructors', 'branches'));
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
            'is_government_funded' => ['boolean'],
            'government_program' => ['nullable', 'string', 'in:PITP,NAVTTC,BBSHRRDA'],
        ]);

        Batch::create([
            ...$validated,
            'monthly_fee' => $request->filled('monthly_fee') ? $validated['monthly_fee'] : null,
            'is_government_funded' => $request->boolean('is_government_funded'),
            'government_program' => $request->boolean('is_government_funded') ? ($validated['government_program'] ?? null) : null,
        ]);

        return redirect()->route('admin.batches.index')->with('success', 'Batch created.');
    }

    public function edit(Batch $batch): View
    {
        $batch->load('timetableSlots');
        $courses = Course::orderBy('name')->get();
        $instructors = User::whereHas('role', fn ($q) => $q->where('name', 'Instructor'))->where('is_active', true)->with('userDetail')->orderBy('email')->get();
        $branches = Branch::where('is_active', true)->orderBy('name')->get();

        return view('admin.batches.edit', compact('batch', 'courses', 'instructors', 'branches'));
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
            'is_government_funded' => ['boolean'],
            'government_program' => ['nullable', 'string', 'in:PITP,NAVTTC,BBSHRRDA'],
        ]);

        $batch->update([
            ...$validated,
            'is_active' => $request->boolean('is_active'),
            'monthly_fee' => $request->filled('monthly_fee') ? $validated['monthly_fee'] : null,
            'is_government_funded' => $request->boolean('is_government_funded'),
            'government_program' => $request->boolean('is_government_funded') ? ($validated['government_program'] ?? null) : null,
        ]);

        return redirect()->route('admin.batches.index')->with('success', 'Batch updated.');
    }

    public function destroy(Batch $batch): RedirectResponse
    {
        $batch->delete();
        return redirect()->route('admin.batches.index')->with('success', 'Batch removed.');
    }

    public function timetable(Request $request, Batch $batch): View|RedirectResponse
    {
        if ($request->isMethod('post')) {
            $validated = $request->validate([
                'slots' => ['required', 'array'],
                'slots.*.day_of_week' => ['required', 'integer', 'min:0', 'max:6'],
                'slots.*.start_time' => ['required', 'string'],
                'slots.*.end_time' => ['required', 'string'],
                'slots.*.room' => ['nullable', 'string', 'max:100'],
            ]);

            $batch->timetableSlots()->delete();
            foreach ($validated['slots'] as $slot) {
                if (!empty($slot['start_time']) && !empty($slot['end_time'])) {
                    $batch->timetableSlots()->create([
                        'day_of_week' => $slot['day_of_week'],
                        'start_time' => $slot['start_time'],
                        'end_time' => $slot['end_time'],
                        'room' => $slot['room'] ?? null,
                    ]);
                }
            }

            return redirect()->route('admin.batches.edit', $batch)->with('success', 'Timetable saved.');
        }

        $batch->load('timetableSlots');

        return view('admin.batches.timetable', compact('batch'));
    }
}
