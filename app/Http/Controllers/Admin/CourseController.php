<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Course;
use App\Models\CourseMode;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $courses = Course::with('courseMode', 'instructor.userDetail')
            ->withCount('enrollments')
            ->when($request->filled('q'), fn ($q) => $q->where('name', 'like', '%' . $request->q . '%'))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $totalCourses = Course::count();

        return view('admin.course.course-list', compact('courses', 'totalCourses'));
    }

    public function about(): View
    {
        $totalCourses = Course::count();
        $totalEnrollments = \App\Models\Enrollment::count();
        $totalBatches = \App\Models\Batch::count();
        $courses = Course::with('courseMode', 'instructor.userDetail')->latest()->take(6)->get();

        return view('admin.course.course-about', compact('totalCourses', 'totalEnrollments', 'totalBatches', 'courses'));
    }

    public function create(): RedirectResponse
    {
        return redirect()->route('instructor.courses.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'course_mode_id' => ['required', 'integer', 'exists:course_modes,id'],
            'description' => ['nullable', 'string', 'max:5000'],
            'release_date' => ['nullable', 'date'],
            'total_hours' => ['nullable', 'string', 'max:50'],
            'certificate' => ['nullable', 'boolean'],
            'skills' => ['nullable', 'string', 'max:255'],
            'total_lectures' => ['nullable', 'integer', 'min:0'],
            'language' => ['nullable', 'string', 'max:100'],
            'instructor_id' => ['nullable', 'integer', 'exists:users,id'],
        ]);

        $course = Course::create([
            'name' => $validated['name'],
            'course_mode_id' => $validated['course_mode_id'],
            'description' => $validated['description'] ?? null,
            'release_date' => $validated['release_date'] ?? null,
            'total_hours' => $validated['total_hours'] ?? null,
            'certificate' => $request->boolean('certificate'),
            'skills' => $validated['skills'] ?? null,
            'total_lectures' => $validated['total_lectures'] ?? null,
            'language' => $validated['language'] ?? null,
            'instructor_id' => $validated['instructor_id'] ?? null,
        ]);
        AuditLog::log('course_created', Course::class, $course->id, auth()->user()->name . " created course: {$course->name}");

        return redirect()->route('admin.courses.index')->with('success', 'Course created successfully.');
    }

    public function edit(Course $course): View
    {
        $courseModes = CourseMode::where('is_active', true)->orderBy('name')->get();
        $instructors = User::whereHas('role', fn ($q) => $q->where('name', 'Instructor'))
            ->where('is_active', true)
            ->with('userDetail')
            ->orderBy('email')
            ->get();

        return view('admin.course.course-edit', compact('course', 'courseModes', 'instructors'));
    }

    public function update(Request $request, Course $course): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'course_mode_id' => ['required', 'integer', 'exists:course_modes,id'],
            'description' => ['nullable', 'string', 'max:5000'],
            'release_date' => ['nullable', 'date'],
            'total_hours' => ['nullable', 'string', 'max:50'],
            'certificate' => ['nullable', 'boolean'],
            'skills' => ['nullable', 'string', 'max:255'],
            'total_lectures' => ['nullable', 'integer', 'min:0'],
            'language' => ['nullable', 'string', 'max:100'],
            'instructor_id' => ['nullable', 'integer', 'exists:users,id'],
            'thumbnail' => ['nullable', 'image', 'max:2048', 'mimes:jpeg,png,jpg,webp,gif'],
        ]);

        $thumbnailPath = $course->thumbnail;
        if ($request->hasFile('thumbnail')) {
            if ($course->thumbnail && Storage::disk('public')->exists($course->thumbnail)) {
                Storage::disk('public')->delete($course->thumbnail);
            }
            $thumbnailPath = $request->file('thumbnail')->store('course-thumbnails', 'public');
        }

        $course->update([
            'name' => $validated['name'],
            'course_mode_id' => $validated['course_mode_id'],
            'description' => $validated['description'] ?? null,
            'release_date' => $validated['release_date'] ?? null,
            'total_hours' => $validated['total_hours'] ?? null,
            'certificate' => $request->boolean('certificate'),
            'skills' => $validated['skills'] ?? null,
            'total_lectures' => $validated['total_lectures'] ?? null,
            'language' => $validated['language'] ?? null,
            'instructor_id' => $validated['instructor_id'] ?? null,
            'thumbnail' => $thumbnailPath,
        ]);
        AuditLog::log('course_updated', Course::class, $course->id, auth()->user()->name . " updated course: {$course->name}");

        return redirect()->route('admin.courses.index')->with('success', 'Course updated successfully.');
    }

    public function show(Course $course)
    {
        $course->load('courseMode', 'instructor.userDetail')->loadCount('enrollments');

        $totalEarnings = $course->enrollments()->sum('fees_collected');
        $enrollmentsThisMonth = $course->enrollments()
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        return view('admin.course.course-detail', compact('course', 'totalEarnings', 'enrollmentsThisMonth'));
    }

    /**
     * Delete a course. Available to Super Admin and Admin (courses.manage). Cascades to enrollments, batches, etc.
     */
    public function destroy(Course $course): RedirectResponse
    {
        $name = $course->name;
        $course->delete();
        AuditLog::log('course_deleted', Course::class, $course->id, auth()->user()->name . " deleted course: {$name}");

        return redirect()->route('admin.courses.index')->with('success', 'Course deleted.');
    }
}
