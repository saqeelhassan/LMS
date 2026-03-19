<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AssignmentController extends Controller
{
    public function index(Course $course, \Illuminate\Http\Request $request): View|RedirectResponse
    {
        $this->authorizeInstructorCourse($course);
        $query = $course->assignments()->with(['batch', 'course'])->withCount('submissions')->latest();
        if ($request->filled('batch_id')) {
            $query->where('batch_id', $request->batch_id);
        }
        $assignments = $query->paginate(10)->withQueryString();
        $batches = $course->batches()->where('is_active', true)->orderBy('name')->get();

        return view('instructor.assignment.index', compact('course', 'assignments', 'batches'));
    }

    public function create(Course $course): View|RedirectResponse
    {
        $this->authorizeInstructorCourse($course);
        $batches = $course->batches()->where('is_active', true)->orderBy('name')->get();
        if ($batches->isEmpty()) {
            return redirect()->route('instructor.assignments.index', $course)
                ->with('warning', 'Create at least one batch for this course before adding assignments.');
        }

        return view('instructor.assignment.create', compact('course', 'batches'));
    }

    public function store(Request $request, Course $course): RedirectResponse
    {
        $this->authorizeInstructorCourse($course);
        $batches = $course->batches()->pluck('id')->toArray();
        $validated = $request->validate([
            'batch_id' => ['required', 'integer', 'in:' . implode(',', $batches)],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:5000'],
            'problem_file' => ['nullable', 'file', 'max:10240', 'mimes:pdf,doc,docx,txt,zip'],
            'total_marks' => ['required', 'integer', 'min:1', 'max:1000'],
            'due_date' => ['nullable', 'date'],
        ]);

        $filePath = null;
        $fileName = null;
        if ($request->hasFile('problem_file')) {
            $file = $request->file('problem_file');
            $path = $file->store('assignments/' . $course->id, 'public');
            $filePath = $path;
            $fileName = $file->getClientOriginalName();
        }

        $course->assignments()->create([
            'batch_id' => $validated['batch_id'],
            'instructor_id' => auth()->id(),
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'problem_file_path' => $filePath,
            'problem_file_name' => $fileName,
            'total_marks' => $validated['total_marks'],
            'due_date' => $validated['due_date'] ?? null,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('instructor.assignments.index', $course)->with('success', 'Assignment created.');
    }

    public function submissions(Course $course, Assignment $assignment): View|RedirectResponse
    {
        $this->authorizeInstructorCourse($course);
        if ($assignment->course_id !== $course->id) {
            abort(404);
        }

        $enrollments = $assignment->batch_id
            ? $assignment->batch->enrollments()->where('enrollment_status', 'active')->with('user.userDetail')->get()
            : $course->enrollments()->with('user.userDetail')->get();
        $enrolledUserIds = $enrollments->pluck('user_id');
        $subs = AssignmentSubmission::where('assignment_id', $assignment->id)
            ->whereIn('user_id', $enrolledUserIds)
            ->with('user.userDetail')
            ->get()
            ->keyBy('user_id');

        $students = $enrollments->map(function ($e) use ($subs) {
            return (object) [
                'user' => $e->user,
                'submission' => $subs->get($e->user_id),
            ];
        });

        return view('instructor.assignment.submissions', compact('course', 'assignment', 'students'));
    }

    public function gradeForm(Course $course, Assignment $assignment, User $user): View|RedirectResponse
    {
        $this->authorizeInstructorCourse($course);
        if ($assignment->course_id !== $course->id) {
            abort(404);
        }
        $allowed = $assignment->batch_id
            ? $assignment->batch->enrollments()->where('user_id', $user->id)->where('enrollment_status', 'active')->exists()
            : $course->enrollments()->where('user_id', $user->id)->exists();
        if (! $allowed) {
            abort(403, 'Student is not in this assignment\'s batch.');
        }

        $submission = AssignmentSubmission::where('assignment_id', $assignment->id)->where('user_id', $user->id)->first();
        if (! $submission) {
            abort(404);
        }
        $submission->load('user.userDetail');

        return view('instructor.assignment.grade', compact('course', 'assignment', 'submission'));
    }

    public function grade(Request $request, Course $course, Assignment $assignment, User $user): RedirectResponse
    {
        $this->authorizeInstructorCourse($course);
        if ($assignment->course_id !== $course->id) {
            abort(404);
        }
        $allowed = $assignment->batch_id
            ? $assignment->batch->enrollments()->where('user_id', $user->id)->where('enrollment_status', 'active')->exists()
            : $course->enrollments()->where('user_id', $user->id)->exists();
        if (! $allowed) {
            abort(403, 'Student is not in this assignment\'s batch.');
        }

        $submission = AssignmentSubmission::where('assignment_id', $assignment->id)->where('user_id', $user->id)->firstOrFail();

        $validated = $request->validate([
            'marks_obtained' => ['required', 'numeric', 'min:0', 'max:' . $assignment->total_marks],
            'feedback' => ['nullable', 'string', 'max:2000'],
        ]);

        $submission->update([
            'marks_obtained' => $validated['marks_obtained'],
            'feedback' => $validated['feedback'] ?? null,
            'marked_at' => now(),
            'marked_by' => auth()->id(),
            'status' => 'graded',
        ]);

        return redirect()->route('instructor.assignments.submissions', [$course, $assignment])
            ->with('success', 'Submission graded.');
    }

    private function authorizeInstructorCourse(Course $course): void
    {
        $user = auth()->user();
        if ($course->instructor_id !== $user->id && $user->role?->name !== 'SuperAdmin') {
            abort(403, 'You can only manage assignments for your own courses.');
        }
    }
}
