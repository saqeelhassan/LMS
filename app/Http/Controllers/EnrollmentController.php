<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnrollmentController extends Controller
{
    /**
     * Enroll the current user in a course.
     */
    public function store(Request $request, Course $course): RedirectResponse
    {
        $user = Auth::user();

        if (Enrollment::where('user_id', $user->id)->where('course_id', $course->id)->exists()) {
            return redirect()->back()->with('info', 'You are already enrolled in this course.');
        }

        $validated = $request->validate([
            'payment_method_id' => ['nullable', 'integer', 'exists:payment_methods,id'],
            'payment_status' => ['nullable', 'string', 'max:50'],
        ]);

        Enrollment::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'payment_method_id' => $validated['payment_method_id'] ?? null,
            'payment_status' => $validated['payment_status'] ?? 'pending',
            'enrollment_status' => 'pending_approval',
        ]);

        return redirect()
            ->back()
            ->with('success', 'You have been enrolled in this course. View it in <a href="' . route('student.courses') . '" class="alert-link">My Courses</a>.');
    }

    /**
     * Re-apply for a previously rejected enrollment. Updates the existing row to pending_approval
     * so the student can be reviewed again. Only allowed when enrollment is rejected and
     * is_eligible_for_reapplication is true.
     */
    public function reapply(Enrollment $enrollment): RedirectResponse
    {
        $user = Auth::user();

        if ($enrollment->user_id !== $user->id) {
            abort(403, 'This enrollment does not belong to you.');
        }

        if (! $enrollment->isEligibleForReapplication()) {
            return redirect()->back()->with('error', 'This application cannot be resubmitted.');
        }

        $enrollment->update([
            'enrollment_status' => 'pending_approval',
            'rejection_note' => null,
        ]);

        return redirect()
            ->route('student.courses')
            ->with('success', 'Your application has been resubmitted for approval. You will be notified once reviewed.');
    }
}
