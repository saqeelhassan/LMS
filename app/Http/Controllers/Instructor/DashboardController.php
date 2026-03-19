<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $instructorId = auth()->id();
        $myCourseIds = Course::where('instructor_id', $instructorId)->pluck('id');

        $totalCourses = $myCourseIds->count();
        $totalEnrollments = Enrollment::whereIn('course_id', $myCourseIds)->count();
        $distinctStudents = $myCourseIds->isEmpty()
            ? 0
            : (int) DB::table('enrollments')->whereIn('course_id', $myCourseIds)->count(DB::raw('DISTINCT user_id'));

        $courses = Course::where('instructor_id', $instructorId)
            ->with('courseMode')
            ->withCount('enrollments')
            ->latest()
            ->limit(10)
            ->get();

        $recentEnrollments = $myCourseIds->isEmpty()
            ? collect()
            : Enrollment::whereIn('course_id', $myCourseIds)
                ->with(['user.userDetail', 'course'])
                ->latest('created_at')
                ->limit(15)
                ->get();

        $enrollmentsThisMonth = Enrollment::whereIn('course_id', $myCourseIds)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        $enrollmentsLastMonth = Enrollment::whereIn('course_id', $myCourseIds)
            ->whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();
        $lastMonthPercent = $enrollmentsLastMonth > 0
            ? round((($enrollmentsThisMonth - $enrollmentsLastMonth) / $enrollmentsLastMonth) * 100, 2)
            : ($enrollmentsThisMonth > 0 ? 100 : 0);

        return view('instructor.dashboard', compact(
            'totalCourses',
            'totalEnrollments',
            'distinctStudents',
            'courses',
            'recentEnrollments',
            'enrollmentsThisMonth',
            'enrollmentsLastMonth',
            'lastMonthPercent'
        ));
    }
}
