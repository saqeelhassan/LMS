<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\View\View;

/**
 * Pay-wall: shown when student has no valid access (all enrollments expired or no access_expiry_date).
 */
class PaymentRequiredController extends Controller
{
    public function __invoke(): View
    {
        $user = auth()->user();
        $enrollments = $user->enrollments()
            ->where('enrollment_status', 'active')
            ->with('course')
            ->get();

        $expiredEnrollments = $enrollments->filter(function ($e) {
            if (! $e->access_expiry_date) {
                return true;
            }

            return $e->access_expiry_date->format('Y-m-d') < now()->toDateString();
        });

        $latestExpiry = $enrollments
            ->filter(fn ($e) => $e->access_expiry_date)
            ->max(fn ($e) => $e->access_expiry_date?->format('Y-m-d'));
        $expiredOn = $latestExpiry ? Carbon::parse($latestExpiry)->format('M j, Y') : null;

        $nextMonth = now()->format('F Y');
        $currency = \App\Models\Setting::get('currency', 'PKR');

        $pendingInvoices = Invoice::where('user_id', $user->id)
            ->whereRaw('(amount - COALESCE(discount_amount,0) - amount_paid) > 0')
            ->with('enrollment.course')
            ->get();
        $totalDue = $pendingInvoices->sum(fn ($i) => $i->balance);

        return view('student.payment-required', compact(
            'expiredOn',
            'nextMonth',
            'currency',
            'totalDue',
            'pendingInvoices',
            'expiredEnrollments'
        ));
    }
}
