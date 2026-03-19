<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Enrollment;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Setting;
use App\Services\StudentLedgerService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Fee Management Dashboard: 4 sections.
 * A: Quick Stats (KPIs)  B: Enrollment Requests  C: Fee Vouchers  D: Quick actions.
 */
class FeeManagementController extends Controller
{
    public function index(Request $request): View
    {
        $currency = Setting::get('currency', 'PKR');
        $today = Carbon::today();
        $thisMonthStart = $today->copy()->startOfMonth();
        $defaulterCutoff = $today->copy()->subDays(10);

        // Section A: KPIs
        $totalRevenueThisMonth = (float) Payment::where('paid_at', '>=', $thisMonthStart)
            ->where(function ($q) {
                $q->where('status', 'approved')->orWhereNull('status');
            })
            ->sum('amount');
        $pendingApprovalsCount = Enrollment::where('enrollment_status', 'pending_approval')->count();
        $pendingPaymentApprovalsCount = Payment::where('status', 'pending_approval')->count();
        $unverifiedPaymentsCount = Invoice::whereNotNull('proof_image_path')
            ->whereRaw('(amount - COALESCE(discount_amount,0) - amount_paid) > 0')
            ->count();
        $defaultersCount = Invoice::where('due_date', '<', $defaulterCutoff)
            ->whereRaw('(amount - COALESCE(discount_amount,0) - amount_paid) > 0')
            ->count();

        // Section B: Enrollment Requests (filter: New | Approved | Rejected)
        $enrollmentFilter = $request->get('enrollment_filter', 'New');
        $enrollmentsQuery = Enrollment::with(['user.userDetail', 'course', 'batch'])->latest('created_at');
        if ($enrollmentFilter === 'New') {
            $enrollmentsQuery->where('enrollment_status', 'pending_approval');
        } elseif ($enrollmentFilter === 'Approved') {
            $enrollmentsQuery->where('enrollment_status', 'active');
        } elseif ($enrollmentFilter === 'Rejected') {
            $enrollmentsQuery->where('enrollment_status', 'rejected');
        }
        $enrollments = $enrollmentsQuery->paginate(15, ['*'], 'enrollment_page')->withQueryString();

        // Section C: Fee Vouchers (filter: Unpaid | Verification Pending | Paid)
        $voucherFilter = $request->get('voucher_filter', 'Unpaid');
        $vouchersQuery = Invoice::whereNotNull('billing_month')
            ->with(['user.userDetail', 'enrollment.course'])
            ->latest('created_at');
        if ($voucherFilter === 'Unpaid') {
            $vouchersQuery->whereIn('status', ['pending', 'partial', 'overdue'])
                ->whereRaw('(amount - COALESCE(discount_amount,0) - amount_paid) > 0')
                ->whereNull('proof_image_path');
        } elseif ($voucherFilter === 'Verification Pending') {
            $vouchersQuery->whereNotNull('proof_image_path')
                ->whereRaw('(amount - COALESCE(discount_amount,0) - amount_paid) > 0');
        } else {
            $vouchersQuery->whereRaw('amount_paid >= (amount - COALESCE(discount_amount,0))');
        }
        $vouchers = $vouchersQuery->paginate(15, ['*'], 'voucher_page')->withQueryString();
        $batchesForTransfer = Batch::with('course')->where('is_active', true)->orderBy('course_id')->get()->groupBy('course_id');

        return view('admin.fee-management.index', compact(
            'currency',
            'totalRevenueThisMonth',
            'pendingApprovalsCount',
            'pendingPaymentApprovalsCount',
            'unverifiedPaymentsCount',
            'defaultersCount',
            'enrollmentFilter',
            'enrollments',
            'voucherFilter',
            'vouchers',
            'batchesForTransfer'
        ));
    }

    /** Student Ledger: Actual, Arrears, Paid, Remaining per enrollment. */
    public function ledger(Request $request): View
    {
        $currency = Setting::get('currency', 'Rs');
        $service = app(StudentLedgerService::class);
        $userFilter = $request->get('user_id');

        $enrollments = Enrollment::with(['user.userDetail', 'course', 'batch'])
            ->where('enrollment_status', 'active')
            ->when($userFilter, fn ($q) => $q->where('user_id', $userFilter))
            ->latest('created_at')
            ->paginate(20)
            ->withQueryString();

        $ledgers = collect();
        foreach ($enrollments as $e) {
            $ledgers->push([
                'enrollment' => $e,
                'ledger' => $service->ledgerForEnrollment($e),
            ]);
        }

        $users = \App\Models\User::with('userDetail')
            ->whereHas('role', fn ($q) => $q->where('name', 'Student'))
            ->whereHas('enrollments', fn ($q) => $q->where('enrollment_status', 'active'))
            ->orderBy('email')
            ->get(['id', 'email']);

        return view('admin.fee-management.ledger', compact('currency', 'enrollments', 'ledgers', 'users', 'userFilter'));
    }

    /**
     * Toggle manual access (enroll for free) for a student enrollment. Super Admin only.
     * When enabled, the student can access the portal without paying fee.
     */
    public function toggleManualAccess(Enrollment $enrollment): RedirectResponse
    {
        if (auth()->user()->role?->name !== 'SuperAdmin') {
            abort(403, 'Only Super Admin can grant or revoke manual access.');
        }

        $enrollment->manual_access = ! $enrollment->manual_access;
        $enrollment->save();

        $studentName = $enrollment->user->name ?? $enrollment->user->email ?? 'Student';
        if ($enrollment->manual_access) {
            return redirect()
                ->route('admin.fee-management.index', request()->only(['enrollment_filter', 'enrollment_page', 'voucher_filter', 'voucher_page']))
                ->with('success', "Manual access granted for {$studentName}. Portal unlocked without fee payment.");
        }

        return redirect()
            ->route('admin.fee-management.index', request()->only(['enrollment_filter', 'enrollment_page', 'voucher_filter', 'voucher_page']))
            ->with('info', "Manual access revoked for {$studentName}. Access will depend on fee payment.");
    }
}
