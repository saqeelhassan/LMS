<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\ContentProgress;
use App\Models\Course;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClassroomController extends Controller
{
    public function show(Course $course): View|RedirectResponse
    {
        $user = auth()->user();
        if (! $user->enrollments()->where('course_id', $course->id)->exists()) {
            abort(403, 'You are not enrolled in this course.');
        }

        $course->load('contents');
        $progressMap = ContentProgress::where('user_id', $user->id)
            ->whereIn('course_content_id', $course->contents->pluck('id'))
            ->get()
            ->keyBy('course_content_id');

        $enrollmentWithBatch = $user->enrollments()
            ->where('course_id', $course->id)
            ->whereNotNull('batch_id')
            ->with('batch')
            ->first();
        $primaryBatch = $enrollmentWithBatch?->batch;

        return view('student.classroom.show', compact('course', 'progressMap', 'primaryBatch'));
    }

    public function recordProgress(Request $request): \Illuminate\Http\JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'course_content_id' => ['required', 'integer', 'exists:course_contents,id'],
            'last_position_seconds' => ['nullable', 'integer', 'min:0'],
            'completed' => ['nullable', 'boolean'],
        ]);

        $content = \App\Models\CourseContent::findOrFail($validated['course_content_id']);
        $user = auth()->user();
        if (! $user->enrollments()->where('course_id', $content->course_id)->exists()) {
            abort(403);
        }

        ContentProgress::updateOrCreate(
            [
                'user_id' => $user->id,
                'course_content_id' => $content->id,
            ],
            [
                'last_position_seconds' => $validated['last_position_seconds'] ?? null,
                'last_watched_at' => now(),
                'completed' => $validated['completed'] ?? false,
            ]
        );

        if ($request->wantsJson()) {
            return response()->json(['ok' => true]);
        }

        return back();
    }
}
