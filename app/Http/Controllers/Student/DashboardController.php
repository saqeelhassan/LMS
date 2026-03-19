<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\ContentProgress;
use App\Models\Invoice;
use App\Models\Setting;
use App\Models\TimetableSlot;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $enrollmentsCount = $user ? $user->enrollments()->count() : 0;
        $enrollments = $user
            ? $user->enrollments()->with(['course.contents'])->latest()->get()
            : collect();

        $resumeLearning = null;
        if ($user) {
            $lastProgress = ContentProgress::where('user_id', $user->id)
                ->whereNotNull('last_watched_at')
                ->with('courseContent.course')
                ->orderByDesc('last_watched_at')
                ->first();
            if ($lastProgress && $lastProgress->courseContent && $lastProgress->courseContent->course) {
                $course = $lastProgress->courseContent->course;
                if ($user->enrollments()->where('course_id', $course->id)->exists()) {
                    $resumeLearning = (object) [
                        'course' => $course,
                        'content' => $lastProgress->courseContent,
                    ];
                }
            }
        }

        $todaySchedule = collect();
        if ($user && $enrollments->isNotEmpty()) {
            $batchIds = $enrollments->pluck('batch_id')->filter();
            $dayOfWeek = Carbon::now()->dayOfWeek;
            $slots = TimetableSlot::whereIn('batch_id', $batchIds)
                ->where('day_of_week', $dayOfWeek)
                ->with('batch.course')
                ->orderBy('start_time')
                ->get();
            foreach ($slots as $slot) {
                if ($slot->batch && $slot->batch->course) {
                    $todaySchedule->push((object) [
                        'slot' => $slot,
                        'course' => $slot->batch->course,
                        'batch' => $slot->batch,
                    ]);
                }
            }
        }

        $completedLessonsCount = $user
            ? ContentProgress::where('user_id', $user->id)->where('completed', true)->count()
            : 0;
        $certificatesCount = $user
            ? $user->enrollments()->whereNotNull('completed_at')->count()
            : 0;

        return view('student.dashboard', compact(
            'enrollmentsCount',
            'enrollments',
            'completedLessonsCount',
            'certificatesCount',
            'resumeLearning',
            'todaySchedule'
        ));
    }

    public function courseList()
    {
        $user = Auth::user();
        $enrollments = $user
            ? $user->enrollments()->with(['course.contents', 'course.courseMode'])->latest()->paginate(10)
            : new LengthAwarePaginator([], 0, 10);

        // Compute per-enrollment lecture counts and progress for display
        if ($user && $enrollments->count() > 0) {
            $contentProgressByContent = ContentProgress::where('user_id', $user->id)
                ->whereNotNull('course_content_id')
                ->where('completed', true)
                ->get()
                ->groupBy('course_content_id');

            // Transform collection items and reassign
            $items = $enrollments->getCollection()->map(function ($enrollment) use ($contentProgressByContent) {
                $course = $enrollment->course;
                $total = $course && $course->contents ? $course->contents->count() : 0;
                $contentIds = ($course && $course->contents) ? $course->contents->pluck('id')->all() : [];
                $completed = 0;
                if (!empty($contentIds)) {
                    foreach ($contentIds as $cid) {
                        if ($contentProgressByContent->has($cid)) {
                            $completed += $contentProgressByContent->get($cid)->count();
                        }
                    }
                }
                $percent = $total > 0 ? (int) round($completed / $total * 100) : 0;
                $enrollment->setAttribute('total_lectures', $total);
                $enrollment->setAttribute('completed_lectures', $completed);
                $enrollment->setAttribute('progress_percent', $percent);
                return $enrollment;
            });
            $enrollments->setCollection($items);
        }

        return view('student.course-list', compact('enrollments'));
    }

    public function courseResume()
    {
        $user = Auth::user();
        $enrollments = $user
            ? $user->enrollments()
                ->where('enrollment_status', 'active')
                ->with(['course' => fn ($q) => $q->with(['contents' => fn ($q2) => $q2->orderBy('sort_order')], 'courseMode')])
                ->latest()
                ->get()
            : collect();

        $contentIds = $enrollments->pluck('course')->filter()->flatMap(fn ($c) => $c->contents->pluck('id'))->unique()->values()->all();
        $progressByContent = $user && count($contentIds) > 0
            ? ContentProgress::where('user_id', $user->id)->whereIn('course_content_id', $contentIds)->get()->keyBy('course_content_id')
            : collect();

        $coursesWithProgress = $enrollments->map(function ($enrollment) use ($progressByContent) {
            $course = $enrollment->course;
            if (! $course) {
                return null;
            }
            $contents = $course->contents;
            $completed = $contents->filter(fn ($c) => $progressByContent->get($c->id)?->completed ?? false)->count();
            $total = $contents->count();
            $percent = $total > 0 ? (int) round($completed / $total * 100) : 0;
            return (object) [
                'enrollment' => $enrollment,
                'course' => $course,
                'contents' => $contents,
                'completed' => $completed,
                'total' => $total,
                'percent' => $percent,
            ];
        })->filter();

        return view('student.course-resume', compact('coursesWithProgress', 'progressByContent'));
    }


    public function paymentInfo()
    {
        return view('student.payment-info');
    }

    public function quiz()
    {
        return view('student.quiz');
    }

    public function subscription()
    {
        $user = Auth::user();
        $enrollments = $user
            ? $user->enrollments()->where('enrollment_status', 'active')->with('course')->latest()->get()
            : collect();

        $hasAccess = $enrollments->contains(fn ($e) => $e->hasAccessToday());
        $latestExpiry = $enrollments->filter(fn ($e) => $e->access_expiry_date)->max(fn ($e) => $e->access_expiry_date);
        $pendingInvoices = $user
            ? Invoice::where('user_id', $user->id)
                ->whereIn('status', ['pending', 'partial', 'overdue'])
                ->whereRaw('amount - amount_paid > 0')
                ->with('enrollment.course')
                ->latest()
                ->get()
            : collect();
        $totalDue = $pendingInvoices->sum(fn ($i) => (float) $i->amount - (float) $i->amount_paid);
        $monthlyTotal = $enrollments->sum(fn ($e) => (float) ($e->monthly_fee ?? 0));
        $currency = Setting::get('currency', 'PKR');

        return view('student.subscription', compact(
            'enrollments',
            'hasAccess',
            'latestExpiry',
            'pendingInvoices',
            'totalDue',
            'monthlyTotal',
            'currency'
        ));
    }
}
