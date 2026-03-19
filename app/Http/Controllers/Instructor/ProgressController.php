<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\AssignmentSubmission;
use App\Models\Attendance;
use App\Models\Course;
use App\Models\ExamSubmission;
use Illuminate\View\View;

class ProgressController extends Controller
{
    public function index(Course $course): View|\Illuminate\Http\RedirectResponse
    {
        $this->authorizeInstructorCourse($course);

        $totalSessions = Attendance::where('course_id', $course->id)->distinct('session_date')->count('session_date');
        $course->load('exams', 'assignments');

        $students = $course->enrollments()->with('user.userDetail')->get()->map(function ($enrollment) use ($course, $totalSessions) {
            $user = $enrollment->user;

            $examSubs = ExamSubmission::whereIn('exam_id', $course->exams->pluck('id'))
                ->where('user_id', $user->id)->get();
            $examMarks = $examSubs->sum('marks_obtained');
            $examMax = $course->exams->sum('total_marks') ?: 1;
            $examPercent = $examMax > 0 ? round(100 * $examMarks / $examMax, 1) : 0;

            $assignSubs = AssignmentSubmission::whereIn('assignment_id', $course->assignments->pluck('id'))
                ->where('user_id', $user->id)->get();
            $assignMarks = $assignSubs->sum('marks_obtained');
            $assignMax = $course->assignments->sum('total_marks') ?: 1;
            $assignPercent = $assignMax > 0 ? round(100 * $assignMarks / $assignMax, 1) : 0;

            $presentCount = Attendance::where('course_id', $course->id)->where('user_id', $user->id)
                ->whereIn('status', ['present', 'late'])->count();
            $attendancePercent = $totalSessions > 0 ? round(100 * $presentCount / $totalSessions, 1) : 0;

            $overallPercent = round(($examPercent + $assignPercent + $attendancePercent) / 3, 1);

            return (object) [
                'user' => $user,
                'exam_percent' => $examPercent,
                'assign_percent' => $assignPercent,
                'attendance_percent' => $attendancePercent,
                'overall_percent' => $overallPercent,
                'exam_submissions' => $examSubs->count(),
                'assign_submissions' => $assignSubs->count(),
                'present_sessions' => $presentCount,
                'total_sessions' => $totalSessions,
            ];
        });

        $chartLabels = $students->pluck('user.name')->toArray();
        $chartData = $students->pluck('overall_percent')->toArray();

        return view('instructor.progress.index', compact('course', 'students', 'chartLabels', 'chartData'));
    }

    private function authorizeInstructorCourse(Course $course): void
    {
        $user = auth()->user();
        if ($course->instructor_id !== $user->id && $user->role?->name !== 'SuperAdmin') {
            abort(403, 'You can only view progress for your own courses.');
        }
    }
}
