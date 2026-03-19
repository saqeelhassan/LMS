<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseMode;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $courses = Course::with('courseMode')
            ->withCount('enrollments')
            ->when($request->filled('q'), fn ($q) => $q->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->q . '%')
                    ->orWhere('description', 'like', '%' . $request->q . '%');
            }))
            ->when($request->filled('mode'), fn ($q) => $q->where('course_mode_id', $request->mode))
            ->when($request->filled('language'), fn ($q) => $q->where('language', $request->language))
            ->when($request->filled('sort') && $request->sort === 'popular', fn ($q) => $q->orderByDesc('enrollments_count'), fn ($q) => $q->latest())
            ->paginate(12)
            ->withQueryString();

        $courseModes = CourseMode::where('is_active', true)
            ->withCount('courses')
            ->orderBy('name')
            ->get();

        $languages = Course::whereNotNull('language')
            ->where('language', '!=', '')
            ->distinct()
            ->pluck('language')
            ->sort()
            ->values();

        $totalCourseCount = Course::count();

        return view('pages.course.grid', compact('courses', 'courseModes', 'languages', 'totalCourseCount'));
    }

    public function detail(Course $course)
    {
        $course->load(['courseMode', 'instructor', 'contents'])->loadCount('enrollments');

        $isEnrolled = Auth::check()
            && $course->enrollments()->where('user_id', Auth::id())->where('enrollment_status', 'active')->exists();

        $rejectedEnrollment = Auth::check()
            ? $course->enrollments()->where('user_id', Auth::id())->where('enrollment_status', 'rejected')->first()
            : null;
        $canReapply = $rejectedEnrollment && $rejectedEnrollment->isEligibleForReapplication();
        $rejectedNoReapply = $rejectedEnrollment && ! $canReapply;

        $paymentMethods = PaymentMethod::orderBy('name')->get();

        return view('pages.course.detail', compact('course', 'isEnrolled', 'rejectedEnrollment', 'canReapply', 'rejectedNoReapply', 'paymentMethods'));
    }

    public function detailAdv(?Course $course = null)
    {
        $course = $course ?? Course::with('courseMode')->withCount('enrollments')->first();
        if (! $course) {
            return redirect()->route('courses.index');
        }
        $course->load('courseMode')->loadCount('enrollments');

        return view('pages.course.detail-adv', compact('course'));
    }

    public function detailMin(?Course $course = null)
    {
        $course = $course ?? Course::with('courseMode')->withCount('enrollments')->first();
        if (! $course) {
            return redirect()->route('courses.index');
        }
        $course->load('courseMode')->loadCount('enrollments');

        return view('pages.course.detail-min', compact('course'));
    }

    public function detailModule(?Course $course = null)
    {
        $course = $course ?? Course::with('courseMode')->withCount('enrollments')->first();
        if (! $course) {
            return redirect()->route('courses.index');
        }
        $course->load('courseMode')->loadCount('enrollments');

        return view('pages.course.detail-module', compact('course'));
    }

    public function videoPlayer()
    {
        return view('pages.course.video-player');
    }

    public function added()
    {
        return view('pages.course.added');
    }
}
