<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\StudentAttendance;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * When student joins the live class via LMS, we record the join time.
 * A scheduled job marks them Present after 15 minutes (see UpgradeOnlineAttendanceCommand).
 */
class LiveClassController extends Controller
{
    public function join(Request $request, Batch $batch): RedirectResponse|\Illuminate\Http\JsonResponse
    {
        $batch->load('course');
        $user = auth()->user();
        $enrolled = $batch->enrollments()->where('user_id', $user->id)->exists();
        if (! $enrolled) {
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'You are not enrolled in this batch.'], 403);
            }
            return redirect()->route('student.dashboard')->with('error', 'You are not enrolled in this batch.');
        }

        $today = now()->toDateString();
        StudentAttendance::updateOrCreate(
            [
                'student_id' => $user->id,
                'batch_id' => $batch->id,
                'date' => $today,
            ],
            [
                'status' => StudentAttendance::STATUS_ABSENT,
                'mode' => StudentAttendance::MODE_ONLINE,
                'login_time' => now(),
                'marked_by' => null,
            ]
        );

        $course = $batch->course;
        $liveUrl = $course->live_class_url ?? '';

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Join recorded. Stay connected at least 15 minutes to be marked Present.',
                'live_class_url' => $liveUrl,
            ]);
        }

        if ($liveUrl !== '') {
            return redirect()->away($liveUrl);
        }

        return redirect()->route('student.dashboard')->with('success', 'Join recorded. Stay at least 15 minutes in the session to be marked Present.');
    }
}
