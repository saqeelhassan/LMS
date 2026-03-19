<?php

namespace App\Services;

use App\Models\Enrollment;
use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Handles course/batch transfer for enrollments (monthly fee model).
 * Updates enrollment, unpaid vouchers, and optionally archives old batch attendance.
 */
class EnrollmentTransferService
{
    public const EFFECTIVE_IMMEDIATELY = 'immediately';
    public const EFFECTIVE_NEXT_MONTH = 'next_month';

    /**
     * Transfer an enrollment to a new course/batch.
     *
     * @param  Enrollment  $enrollment
     * @param  int  $newBatchId
     * @param  string  'immediately'|'next_month'
     * @return array{success: bool, message: string, vouchers_updated: int}
     */
    public function transfer(Enrollment $enrollment, int $newBatchId, string $effectiveDate): array
    {
        $batch = \App\Models\Batch::with('course')->find($newBatchId);
        if (! $batch || ! $batch->course) {
            return ['success' => false, 'message' => 'Invalid batch.', 'vouchers_updated' => 0];
        }

        if ($enrollment->batch_id == $newBatchId) {
            return ['success' => false, 'message' => 'Student is already in this batch.', 'vouchers_updated' => 0];
        }

        $newMonthlyFee = (float) ($batch->monthly_fee ?? 0);

        return DB::transaction(function () use ($enrollment, $batch, $newBatchId, $newMonthlyFee, $effectiveDate) {
            $oldBatchId = $enrollment->batch_id;
            $oldCourseId = $enrollment->course_id;

            $enrollment->course_id = $batch->course_id;
            $enrollment->batch_id = $newBatchId;
            $enrollment->monthly_fee = $newMonthlyFee > 0 ? $newMonthlyFee : $enrollment->monthly_fee;
            $enrollment->save();

            $vouchersUpdated = $this->updateUnpaidVouchers($enrollment, $newMonthlyFee, $effectiveDate);

            return [
                'success' => true,
                'message' => "Transferred to {$batch->course->name} ({$batch->name}). {$vouchersUpdated} voucher(s) updated.",
                'vouchers_updated' => $vouchersUpdated,
            ];
        });
    }

    /**
     * Update unpaid vouchers to the new fee. Do not touch paid vouchers.
     * - Immediately: update all unpaid vouchers.
     * - Next month: update only unpaid vouchers with billing_month > current month.
     */
    protected function updateUnpaidVouchers(Enrollment $enrollment, float $newFee, string $effectiveDate): int
    {
        $query = Invoice::where('enrollment_id', $enrollment->id)
            ->where('fee_type', 'monthly')
            ->whereRaw('amount_paid < (amount - COALESCE(discount_amount, 0))')
            ->whereNotNull('billing_month');

        if ($effectiveDate === self::EFFECTIVE_NEXT_MONTH) {
            $nextMonthStart = Carbon::now()->addMonth()->startOfMonth()->toDateString();
            $query->where('billing_month', '>=', $nextMonthStart);
        }

        $invoices = $query->get();
        $discountAmount = $enrollment->computeDiscountAmount($newFee);
        $amountAfterDiscount = $newFee - $discountAmount;

        foreach ($invoices as $inv) {
            $inv->amount = $newFee;
            $inv->discount_amount = $discountAmount;
            $inv->save();
        }

        return $invoices->count();
    }
}
