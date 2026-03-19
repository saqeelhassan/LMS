<?php

namespace App\Services;

use App\Models\Enrollment;
use App\Models\Invoice;
use Illuminate\Support\Collection;

/**
 * Student Ledger: Actual Fees, Arrears, Paid, Remaining per enrollment.
 */
class StudentLedgerService
{
    /**
     * Ledger summary for an enrollment.
     */
    public function ledgerForEnrollment(Enrollment $enrollment): array
    {
        $invoices = Invoice::where('enrollment_id', $enrollment->id)->get();
        $actualFees = (float) $invoices->sum(fn ($i) => (float) $i->amount - ($i->discount_amount ?? 0));
        $paidAmount = (float) $invoices->sum('amount_paid');
        $arrears = (float) ($enrollment->arrears ?? 0);
        $totalDue = $actualFees + $arrears;
        $remaining = max(0, $totalDue - $paidAmount);

        return [
            'actual_fees' => round($actualFees, 2),
            'arrears' => round($arrears, 2),
            'paid_amount' => round($paidAmount, 2),
            'remaining' => round($remaining, 2),
            'invoices' => $invoices,
        ];
    }

    /**
     * Ledgers for all active enrollments for a user.
     */
    public function ledgersForUser(int $userId): Collection
    {
        return Enrollment::where('user_id', $userId)
            ->where('enrollment_status', 'active')
            ->with(['course', 'batch', 'user.userDetail'])
            ->get()
            ->map(fn ($e) => [
                'enrollment' => $e,
                'ledger' => $this->ledgerForEnrollment($e),
            ]);
    }
}
