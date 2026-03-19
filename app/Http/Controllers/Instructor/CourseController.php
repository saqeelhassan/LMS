<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseMode;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class CourseController extends Controller
{
    public function index(): View
    {
        $courses = Course::where('instructor_id', auth()->id())
            ->with('courseMode')
            ->withCount('enrollments')
            ->latest()
            ->paginate(10);

        return view('instructor.course.index', compact('courses'));
    }

    public function create(): View
    {
        $courseModes = CourseMode::where('is_active', true)->orderBy('name')->get();

        return view('instructor.course.create', compact('courseModes'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'course_mode_id' => ['required', 'integer', 'exists:course_modes,id'],
            'description' => ['nullable', 'string', 'max:5000'],
            'thumbnail' => ['nullable', 'image', 'max:2048', 'mimes:jpeg,png,jpg,webp,gif'],
            'release_date' => ['nullable', 'date'],
            'total_hours' => ['nullable', 'string', 'max:50'],
            'certificate' => ['nullable', 'boolean'],
            'skills' => ['nullable', 'string', 'max:255'],
            'total_lectures' => ['nullable', 'integer', 'min:0'],
            'language' => ['nullable', 'string', 'max:100'],
            'live_class_url' => ['nullable', 'string', 'max:500'],
        ]);

        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('course-thumbnails', 'public');
        }

        Course::create([
            ...$validated,
            'thumbnail' => $thumbnailPath,
            'certificate' => $request->boolean('certificate'),
            'instructor_id' => auth()->id(),
            'publication_status' => Course::PUBLICATION_DRAFT,
        ]);

        return redirect()->route('instructor.manage-course')->with('success', 'Course created successfully.');
    }

    public function edit(Course $course): View|RedirectResponse
    {
        $this->authorizeInstructorCourse($course);
        $courseModes = CourseMode::where('is_active', true)->orderBy('name')->get();

        return view('instructor.course.edit', compact('course', 'courseModes'));
    }

    public function update(Request $request, Course $course): RedirectResponse
    {
        $this->authorizeInstructorCourse($course);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'course_mode_id' => ['required', 'integer', 'exists:course_modes,id'],
            'description' => ['nullable', 'string', 'max:5000'],
            'thumbnail' => ['nullable', 'image', 'max:2048', 'mimes:jpeg,png,jpg,webp,gif'],
            'release_date' => ['nullable', 'date'],
            'total_hours' => ['nullable', 'string', 'max:50'],
            'certificate' => ['nullable', 'boolean'],
            'skills' => ['nullable', 'string', 'max:255'],
            'total_lectures' => ['nullable', 'integer', 'min:0'],
            'language' => ['nullable', 'string', 'max:100'],
            'live_class_url' => ['nullable', 'string', 'max:500'],
        ]);

        $thumbnailPath = $course->thumbnail;
        if ($request->hasFile('thumbnail')) {
            if ($course->thumbnail && Storage::disk('public')->exists($course->thumbnail)) {
                Storage::disk('public')->delete($course->thumbnail);
            }
            $thumbnailPath = $request->file('thumbnail')->store('course-thumbnails', 'public');
        }

        $course->update([
            ...$validated,
            'thumbnail' => $thumbnailPath,
            'certificate' => $request->boolean('certificate'),
        ]);

        return redirect()->route('instructor.manage-course')->with('success', 'Course updated successfully.');
    }

    public function destroy(Course $course): RedirectResponse
    {
        $this->authorizeInstructorCourse($course);
        $course->delete();

        return redirect()->route('instructor.manage-course')->with('success', 'Course deleted.');
    }

    private function authorizeInstructorCourse(Course $course): void
    {
        $user = auth()->user();
        if ($course->instructor_id !== $user->id && $user->role?->name !== 'SuperAdmin') {
            abort(403, 'You can only edit your own courses.');
        }
    }
}
