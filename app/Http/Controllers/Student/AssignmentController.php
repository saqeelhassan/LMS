<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\Course;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AssignmentController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();
        $myBatchIds = $user->enrollments()->where('enrollment_status', 'active')->pluck('batch_id')->filter()->unique()->values()->all();
        $enrolledCourseIds = $user->enrollments()->pluck('course_id')->unique()->values()->all();

        $assignments = Assignment::query()
            ->where(function ($q) use ($myBatchIds, $enrolledCourseIds) {
                if (! empty($myBatchIds)) {
                    $q->whereIn('batch_id', $myBatchIds);
                }
                $q->orWhere(function ($q2) use ($enrolledCourseIds) {
                    $q2->whereNull('batch_id')->whereIn('course_id', $enrolledCourseIds);
                });
            })
            ->with('course', 'batch')
            ->latest()
            ->paginate(15);

        $submissionMap = AssignmentSubmission::where('user_id', $user->id)
            ->get()
            ->keyBy('assignment_id');

        return view('student.assignments.index', compact('assignments', 'submissionMap'));
    }

    public function submitForm(Assignment $assignment): View|RedirectResponse
    {
        $assignment->load('course');
        $user = auth()->user();
        $enrollment = $user->enrollments()->where('course_id', $assignment->course_id)->first();
        if (! $enrollment) {
            abort(403);
        }
        if ($assignment->batch_id && $enrollment->batch_id != $assignment->batch_id) {
            abort(403, 'This assignment is not for your batch.');
        }

        $submission = AssignmentSubmission::where('assignment_id', $assignment->id)
            ->where('user_id', $user->id)
            ->first();

        return view('student.assignments.submit', compact('assignment', 'submission'));
    }

    public function submit(Request $request, Assignment $assignment): RedirectResponse
    {
        $user = auth()->user();
        $enrollment = $user->enrollments()->where('course_id', $assignment->course_id)->first();
        if (! $enrollment) {
            abort(403);
        }
        if ($assignment->batch_id && $enrollment->batch_id != $assignment->batch_id) {
            abort(403, 'This assignment is not for your batch.');
        }

        $validated = $request->validate([
            'file' => [
                'required',
                'file',
                'max:20480',
                'mimes:pdf,doc,docx,txt,zip,py,js,html,css,java',
                function ($attribute, $value, $fail) {
                    $ext = strtolower($value->getClientOriginalExtension());
                    if (in_array($ext, ['php', 'phtml', 'phar', 'exe', 'dll'], true)) {
                        $fail('Executable or script file types are not allowed.');
                    }
                },
            ],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $file = $request->file('file');
        $path = $file->store('assignment-submissions/' . $assignment->id, 'public');

        AssignmentSubmission::updateOrCreate(
            ['assignment_id' => $assignment->id, 'user_id' => $user->id],
            [
                'file_path' => $path,
                'file_name' => $file->getClientOriginalName(),
                'notes' => $validated['notes'] ?? null,
                'submitted_at' => now(),
                'status' => 'submitted',
            ]
        );

        return redirect()->route('student.assignments.index')->with('success', 'Submission uploaded.');
    }
}
