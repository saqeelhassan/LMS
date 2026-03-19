<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseContent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ContentController extends Controller
{
    public function index(Course $course): View|RedirectResponse
    {
        $this->authorizeInstructorCourse($course);
        $contents = $course->contents()->orderBy('sort_order')->get();

        return view('instructor.content.index', compact('course', 'contents'));
    }

    public function create(Course $course): View|RedirectResponse
    {
        $this->authorizeInstructorCourse($course);
        return view('instructor.content.create', compact('course'));
    }

    public function store(Request $request, Course $course): RedirectResponse
    {
        $this->authorizeInstructorCourse($course);
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'in:video,pdf,code'],
            'url' => ['nullable', 'string', 'max:500'],
            'file' => [
                'nullable',
                'file',
                'max:51200',
                'mimes:pdf,zip,txt,py,js,html,css,java',
                function ($attribute, $value, $fail) {
                    $ext = strtolower($value->getClientOriginalExtension());
                    if (in_array($ext, ['php', 'phtml', 'phar', 'exe', 'dll'], true)) {
                        $fail('Executable or script file types are not allowed.');
                    }
                },
            ],
        ]);

        $filePath = null;
        $fileName = null;
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('course-contents/' . $course->id, 'public');
            $filePath = $path;
            $fileName = $request->file('file')->getClientOriginalName();
        }

        if ($validated['type'] === 'video' && empty($validated['url']) && ! $filePath) {
            return back()->withErrors(['url' => 'Video requires URL or file.'])->withInput();
        }
        if (in_array($validated['type'], ['pdf', 'code']) && ! $filePath && empty($validated['url'] ?? null)) {
            return back()->withErrors(['file' => 'PDF/Code requires file or URL.'])->withInput();
        }

        $course->contents()->create([
            'title' => $validated['title'],
            'type' => $validated['type'],
            'url' => $validated['url'] ?? null,
            'file_path' => $filePath,
            'file_name' => $fileName,
            'sort_order' => $course->contents()->max('sort_order') + 1,
        ]);

        return redirect()->route('instructor.content.index', $course)->with('success', 'Content added.');
    }

    /** Submit course outline for Super Admin approval (before it appears on the website). */
    public function submitForApproval(Course $course): RedirectResponse
    {
        $this->authorizeInstructorCourse($course);
        if ($course->publication_status === \App\Models\Course::PUBLICATION_APPROVED) {
            return redirect()->back()->with('info', 'Course is already approved and published.');
        }
        if ($course->publication_status === \App\Models\Course::PUBLICATION_PENDING) {
            return redirect()->back()->with('info', 'Course is already pending approval.');
        }
        // Rejected courses can be resubmitted

        $course->update([
            'publication_status' => \App\Models\Course::PUBLICATION_PENDING,
            'submitted_for_approval_at' => now(),
        ]);

        return redirect()->route('instructor.content.index', $course)
            ->with('success', 'Course outline submitted for Super Admin approval. It will appear on the website after approval.');
    }

    public function edit(Course $course, CourseContent $content): View|RedirectResponse
    {
        $this->authorizeInstructorCourse($course);
        if ($content->course_id !== $course->id) {
            abort(404);
        }
        return view('instructor.content.edit', compact('course', 'content'));
    }

    public function update(Request $request, Course $course, CourseContent $content): RedirectResponse
    {
        $this->authorizeInstructorCourse($course);
        if ($content->course_id !== $course->id) {
            abort(404);
        }
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'in:video,pdf,code'],
            'url' => ['nullable', 'string', 'max:500'],
            'file' => [
                'nullable',
                'file',
                'max:51200',
                'mimes:pdf,zip,txt,py,js,html,css,java',
                function ($attribute, $value, $fail) {
                    $ext = strtolower($value->getClientOriginalExtension());
                    if (in_array($ext, ['php', 'phtml', 'phar', 'exe', 'dll'], true)) {
                        $fail('Executable or script file types are not allowed.');
                    }
                },
            ],
        ]);

        $filePath = $content->file_path;
        $fileName = $content->file_name;
        if ($request->hasFile('file')) {
            if ($content->file_path && Storage::disk('public')->exists($content->file_path)) {
                Storage::disk('public')->delete($content->file_path);
            }
            $path = $request->file('file')->store('course-contents/' . $course->id, 'public');
            $filePath = $path;
            $fileName = $request->file('file')->getClientOriginalName();
        }

        $content->update([
            'title' => $validated['title'],
            'type' => $validated['type'],
            'url' => $validated['url'] ?? null,
            'file_path' => $filePath,
            'file_name' => $fileName,
        ]);

        return redirect()->route('instructor.content.index', $course)->with('success', 'Content updated.');
    }

    public function destroy(Course $course, CourseContent $content): RedirectResponse
    {
        $this->authorizeInstructorCourse($course);
        if ($content->course_id !== $course->id) {
            abort(404);
        }
        if ($content->file_path && Storage::disk('public')->exists($content->file_path)) {
            Storage::disk('public')->delete($content->file_path);
        }
        $content->delete();
        return redirect()->route('instructor.content.index', $course)->with('success', 'Content deleted.');
    }

    private function authorizeInstructorCourse(Course $course): void
    {
        $user = auth()->user();
        if ($course->instructor_id !== $user->id && $user->role?->name !== 'SuperAdmin') {
            abort(403, 'You can only manage content for your own courses.');
        }
    }
}
