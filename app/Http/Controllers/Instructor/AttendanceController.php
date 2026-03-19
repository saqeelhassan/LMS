<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AttendanceController extends Controller
{
    public function index(Course $course): View|RedirectResponse
    {
        $this->authorizeInstructorCourse($course);

        $records = Attendance::where('course_id', $course->id)
            ->select('session_date', 'session_type')
            ->distinct()
            ->orderByDesc('session_date')
            ->limit(50)
            ->get();

        $dates = $records->map(fn ($r) => (object) ['date' => $r->session_date->format('Y-m-d'), 'type' => $r->session_type ?? 'offline']);

        return view('instructor.attendance.index', compact('course', 'dates'));
    }

    public function take(Course $course, ?string $date = null): View|RedirectResponse
    {
        $this->authorizeInstructorCourse($course);
        $sessionDate = $date ? \Carbon\Carbon::parse($date)->startOfDay() : now()->startOfDay();

        $enrolledStudents = $course->enrollments()
            ->with('user.userDetail')
            ->get()
            ->pluck('user');

        $existing = Attendance::where('course_id', $course->id)
            ->whereDate('session_date', $sessionDate)
            ->get()
            ->keyBy('user_id');

        return view('instructor.attendance.take', compact('course', 'sessionDate', 'enrolledStudents', 'existing'));
    }

    public function store(Request $request, Course $course): RedirectResponse
    {
        $this->authorizeInstructorCourse($course);

        $validated = $request->validate([
            'session_date' => ['required', 'date'],
            'session_type' => ['required', 'string', 'in:offline,online'],
            'attendance' => ['required', 'array'],
            'attendance.*' => ['required', 'string', 'in:present,absent,late,excused'],
        ]);

        $sessionDate = $validated['session_date'];
        $sessionType = $validated['session_type'] ?? 'offline';
        $enrolledUserIds = $course->enrollments()->pluck('user_id');

        DB::transaction(function () use ($course, $sessionDate, $sessionType, $validated, $enrolledUserIds) {
            foreach ($validated['attendance'] as $userId => $status) {
                if (!$enrolledUserIds->contains((int) $userId)) {
                    continue;
                }
                Attendance::updateOrCreate(
                    [
                        'course_id' => $course->id,
                        'user_id' => $userId,
                        'session_date' => $sessionDate,
                    ],
                    [
                        'session_type' => $sessionType,
                        'status' => $status,
                        'recorded_by' => auth()->id(),
                    ]
                );
            }
        });

        return redirect()->route('instructor.attendance.index', $course)
            ->with('success', 'Attendance saved successfully.');
    }

    public function view(Course $course, string $date): View|RedirectResponse
    {
        $this->authorizeInstructorCourse($course);
        $sessionDate = \Carbon\Carbon::parse($date)->startOfDay();

        $attendances = Attendance::where('course_id', $course->id)
            ->whereDate('session_date', $sessionDate)
            ->with('user.userDetail')
            ->get();

        return view('instructor.attendance.view', compact('course', 'sessionDate', 'attendances'));
    }

    private function authorizeInstructorCourse(Course $course): void
    {
        $user = auth()->user();
        if ($course->instructor_id !== $user->id && $user->role?->name !== 'SuperAdmin') {
            abort(403, 'You can only manage attendance for your own courses.');
        }
    }
}
