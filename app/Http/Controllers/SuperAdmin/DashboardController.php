<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Expense;
use App\Models\Invoice;
use App\Models\Role;
use App\Models\User;
use App\Services\FeeVoucherService;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalCourses = Course::count();
        $totalEnrollments = Enrollment::count();
        $totalUsers = User::count();

        // Run daily overdue check: mark unpaid past-due invoices as overdue
        $markedOverdue = app(FeeVoucherService::class)->markOverdue();
        $overdueCount = Invoice::where('status', 'overdue')->count();

        $studentsCount = User::whereHas('role', fn ($q) => $q->where('name', 'Student'))->where('is_active', true)->count();
        $instructorsCount = User::whereHas('role', fn ($q) => $q->where('name', 'Instructor'))->where('is_active', true)->count();
        $adminsCount = User::whereHas('role', fn ($q) => $q->where('name', 'Admin'))->where('is_active', true)->count();

        $admins = User::with('userDetail')->whereHas('role', fn ($q) => $q->where('name', 'Admin'))->orderBy('email')->get();
        $instructors = User::with('userDetail')->whereHas('role', fn ($q) => $q->where('name', 'Instructor'))->orderBy('email')->get();
        $students = User::with('userDetail')->whereHas('role', fn ($q) => $q->where('name', 'Student'))->orderBy('email')->get();

        $pendingRegistrations = User::with(['role', 'userDetail'])
            ->where('is_active', false)
            ->whereHas('role', fn ($q) => $q->whereIn('name', ['Student', 'Staff']))
            ->orderBy('created_at', 'desc')
            ->get();

        // Executive: Revenue (fees collected vs pending dues)
        $feesCollectedToday = Enrollment::whereDate('updated_at', today())->sum('fees_collected');
        $feesCollectedMonth = Enrollment::whereMonth('updated_at', now()->month)->whereYear('updated_at', now()->year)->sum('fees_collected');
        $feesCollectedYear = Enrollment::whereYear('updated_at', now()->year)->sum('fees_collected');
        $feesCollectedTotal = Enrollment::sum('fees_collected');
        $feesPendingTotal = Enrollment::sum('fees_due');

        // Enrollment: Active vs Dropouts
        $activeEnrollments = Enrollment::where('enrollment_status', 'active')->count();
        $dropoutCount = Enrollment::where('enrollment_status', 'dropped')->count();

        // Expenses
        $expensesThisMonth = Expense::whereMonth('expense_date', now()->month)->whereYear('expense_date', now()->year)->sum('amount');
        $expensesThisYear = Expense::whereYear('expense_date', now()->year)->sum('amount');

        return view('super-admin.dashboard', compact(
            'totalCourses',
            'totalEnrollments',
            'totalUsers',
            'studentsCount',
            'instructorsCount',
            'adminsCount',
            'admins',
            'instructors',
            'students',
            'pendingRegistrations',
            'feesCollectedToday',
            'feesCollectedMonth',
            'feesCollectedYear',
            'feesCollectedTotal',
            'feesPendingTotal',
            'activeEnrollments',
            'dropoutCount',
            'expensesThisMonth',
            'expensesThisYear',
            'overdueCount',
            'markedOverdue'
        ));
    }
}
