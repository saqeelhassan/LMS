<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Super Admin: Approve or reject course outlines before they appear on the website.
 */
class CourseApprovalController extends Controller
{
    public function index(Request $request): View
    {
        $filter = $request->get('filter', 'pending');
        $query = Course::with(['instructor.userDetail', 'courseMode', 'contents']);

        if ($filter === 'pending') {
            $query->where('publication_status', Course::PUBLICATION_PENDING);
        } elseif ($filter === 'approved') {
            $query->where('publication_status', Course::PUBLICATION_APPROVED);
        } elseif ($filter === 'rejected') {
            $query->where('publication_status', Course::PUBLICATION_REJECTED);
        } else {
            $query->whereIn('publication_status', [Course::PUBLICATION_PENDING, Course::PUBLICATION_REJECTED]);
        }

        $courses = $query->latest('submitted_for_approval_at')->paginate(15)->withQueryString();
        $pendingCount = Course::where('publication_status', Course::PUBLICATION_PENDING)->count();

        return view('super-admin.course-approval.index', compact('courses', 'filter', 'pendingCount'));
    }

    public function approve(Course $course): RedirectResponse
    {
        if ($course->publication_status !== Course::PUBLICATION_PENDING) {
            return redirect()->route('super-admin.course-approval.index')
                ->with('info', 'Course is not pending approval.');
        }

        $course->update([
            'publication_status' => Course::PUBLICATION_APPROVED,
            'approved_at' => now(),
            'approved_by' => auth()->id(),
            'rejected_at' => null,
            'rejected_by' => null,
        ]);

        return redirect()->route('super-admin.course-approval.index')
            ->with('success', "Course \"{$course->name}\" approved and published to the website.");
    }

    public function reject(Request $request, Course $course): RedirectResponse
    {
        if ($course->publication_status !== Course::PUBLICATION_PENDING) {
            return redirect()->route('super-admin.course-approval.index')
                ->with('info', 'Course is not pending approval.');
        }

        $course->update([
            'publication_status' => Course::PUBLICATION_REJECTED,
            'rejected_at' => now(),
            'rejected_by' => auth()->id(),
            'approved_at' => null,
            'approved_by' => null,
        ]);

        return redirect()->route('super-admin.course-approval.index')
            ->with('success', "Course \"{$course->name}\" rejected.");
    }
}
