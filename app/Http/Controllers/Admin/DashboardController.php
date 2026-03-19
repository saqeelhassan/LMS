<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\AttendanceReportController;
use App\Models\Batch;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\User;
use App\Services\FeeVoucherService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalCourses = Course::count();
        $totalEnrollments = Enrollment::count();
        $totalUsers = User::count();
        $activeBatches = Batch::where('is_active', true)->count();
        $studentsCount = User::whereHas('role', fn ($q) => $q->where('name', 'Student'))->where('is_active', true)->count();
        $newEnrollmentsCount = Enrollment::where('created_at', '>=', Carbon::now()->subDays(30))->count();
        $feesCollectedTotal = (float) Payment::whereNotNull('paid_at')->sum('amount');
        $instructors = User::with('userDetail')->whereHas('role', fn ($q) => $q->where('name', 'Instructor'))->where('is_active', true)->orderBy('email')->limit(6)->get();
        $recentEnrollmentsForList = Enrollment::with(['user.userDetail', 'course'])->latest('created_at')->limit(10)->get();
        // Run daily overdue check: mark unpaid past-due invoices as overdue
        $markedOverdue = app(FeeVoucherService::class)->markOverdue();
        $overdueCount = Invoice::where('status', 'overdue')->count();

        // Earnings: monthly revenue from payments (last 12 months)
        $earningsData = Payment::query()
            ->select(DB::raw("DATE_FORMAT(paid_at, '%Y-%m') as month"), DB::raw('SUM(amount) as total'))
            ->where('paid_at', '>=', Carbon::now()->subMonths(11)->startOfMonth())
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->all();
        $earningsLabels = [];
        $earningsValues = [];
        for ($i = 11; $i >= 0; $i--) {
            $m = Carbon::now()->subMonths($i)->format('Y-m');
            $earningsLabels[] = Carbon::parse($m . '-01')->format('M Y');
            $earningsValues[] = (float) ($earningsData[$m] ?? 0);
        }

        // Traffic sources: top courses by enrollment count
        $trafficSources = Course::withCount('enrollments')
            ->orderByDesc('enrollments_count')
            ->limit(6)
            ->get()
            ->map(fn ($c) => ['name' => $c->name, 'count' => $c->enrollments_count])
            ->all();

        // Recent activity: enrollments only (no pending registrations)
        $recentEnrollments = Enrollment::with(['user.userDetail', 'course'])
            ->latest('created_at')
            ->limit(8)
            ->get();
        $recentActivity = [];
        foreach ($recentEnrollments as $e) {
            $recentActivity[] = [
                'type' => 'enrollment',
                'title' => 'New enrollment',
                'message' => ($e->user->name ?? $e->user->email) . ' enrolled in ' . ($e->course->name ?? 'a course') . '.',
                'url' => route('courses.index'),
                'time' => $e->created_at->diffForHumans(),
                'sort_at' => $e->created_at->getTimestamp(),
            ];
        }

        $attendanceOverview = AttendanceReportController::todayOverview();

        return view('admin.dashboard', compact(
            'totalCourses', 'totalEnrollments', 'totalUsers', 'activeBatches',
            'studentsCount', 'newEnrollmentsCount', 'feesCollectedTotal', 'instructors', 'recentEnrollmentsForList',
            'recentActivity', 'overdueCount', 'markedOverdue',
            'earningsLabels', 'earningsValues', 'trafficSources',
            'attendanceOverview'
        ));
    }
}
