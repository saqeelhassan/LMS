<?php

namespace App\Services;

use App\Models\Enrollment;
use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Generates monthly fee vouchers for active enrollments.
 * Students receive one voucher per month and must pay it to continue (traditional college style).
 */
class FeeVoucherService
{
    /**
     * Mark unpaid invoices past due date as overdue. Call from dashboard or daily job.
     *
     * @return int Number of invoices updated to overdue
     */
    public function markOverdue(): int
    {
        $today = Carbon::today()->toDateString();

        return Invoice::where('due_date', '<', $today)
            ->whereColumn('amount_paid', '<', 'amount')
            ->whereIn('status', ['pending', 'partial'])
            ->update(['status' => 'overdue']);
    }
    /** Default day of month for voucher due date (e.g. 10 = 10th). */
    public static function defaultDueDay(): int
    {
        return (int) (config('fees.voucher_due_day', 10));
    }

    /**
     * Generate fee vouchers for the given month for all eligible enrollments.
     * Eligible = active enrollment with monthly_fee > 0 and no existing voucher for that month.
     *
     * @return array{created: int, skipped: int, errors: array<int, string>}
     */
    public function generateForMonth(Carbon $month): array
    {
        $billingMonth = $month->copy()->startOfMonth();
        $dueDate = $billingMonth->copy()->addDays(self::defaultDueDay() - 1);
        if ($dueDate->month !== $billingMonth->month) {
            $dueDate = $billingMonth->copy()->endOfMonth();
        }

        $enrollments = Enrollment::where('enrollment_status', 'active')
            ->with('user', 'course', 'batch')
            ->get()
            ->filter(function (Enrollment $e) use ($billingMonth) {
                $fee = $e->monthly_fee ?? $e->batch?->monthly_fee;
                if ($fee === null || (float) $fee <= 0) {
                    return false;
                }
                if ($e->end_date && $billingMonth->endOfMonth()->gt($e->end_date)) {
                    return false;
                }
                return true;
            });

        $created = 0;
        $skipped = 0;
        $errors = [];

        foreach ($enrollments as $enrollment) {
            $exists = Invoice::where('enrollment_id', $enrollment->id)
                ->where('billing_month', $billingMonth->toDateString())
                ->exists();

            if ($exists) {
                $skipped++;
                continue;
            }

            try {
                DB::transaction(function () use ($enrollment, $billingMonth, $dueDate, &$created) {
                    $baseAmount = (float) ($enrollment->monthly_fee ?? $enrollment->batch?->monthly_fee);
                    $discountAmount = $enrollment->computeDiscountAmount($baseAmount);
                    $invoiceNo = $this->nextVoucherNumber($billingMonth);
                    Invoice::create([
                        'invoice_no' => $invoiceNo,
                        'user_id' => $enrollment->user_id,
                        'enrollment_id' => $enrollment->id,
                        'amount' => $baseAmount,
                        'fee_type' => 'monthly',
                        'discount_amount' => $discountAmount,
                        'amount_paid' => 0,
                        'due_date' => $dueDate,
                        'billing_month' => $billingMonth,
                        'status' => 'pending',
                        'description' => 'Monthly fee for ' . $billingMonth->format('F Y'),
                        'created_by' => null,
                    ]);
                    $created++;
                });
            } catch (\Throwable $e) {
                $errors[$enrollment->id] = $e->getMessage();
            }
        }

        return ['created' => $created, 'skipped' => $skipped, 'errors' => $errors];
    }

    /**
     * Generate Month 1 voucher for a single enrollment (e.g. when admin approves enrollment).
     * Uses given month (typically current month). Idempotent: skips if voucher already exists.
     */
    public function generateFirstMonthForEnrollment(Enrollment $enrollment, ?Carbon $month = null): ?Invoice
    {
        $month = $month ? $month->copy()->startOfMonth() : Carbon::now()->startOfMonth();
        $exists = Invoice::where('enrollment_id', $enrollment->id)
            ->where('billing_month', $month->toDateString())
            ->first();
        if ($exists) {
            return $exists;
        }
        $fee = $enrollment->monthly_fee ?? $enrollment->batch?->monthly_fee;
        if ($fee === null || (float) $fee <= 0) {
            return null;
        }
        $dueDate = $month->copy()->addDays(self::defaultDueDay() - 1);
        if ($dueDate->month !== $month->month) {
            $dueDate = $month->copy()->endOfMonth();
        }
        $baseAmount = (float) $fee;
        $discountAmount = $enrollment->computeDiscountAmount($baseAmount);
        return Invoice::create([
            'invoice_no' => $this->nextVoucherNumber($month),
            'user_id' => $enrollment->user_id,
            'enrollment_id' => $enrollment->id,
            'amount' => $baseAmount,
            'fee_type' => 'monthly',
            'discount_amount' => $discountAmount,
            'amount_paid' => 0,
            'due_date' => $dueDate,
            'billing_month' => $month,
            'status' => 'pending',
            'description' => 'Monthly fee for ' . $month->format('F Y') . ' (Month 1)',
            'created_by' => null,
        ]);
    }

    /** Generate a unique voucher number for the month (e.g. VOU-2025-02-00001). */
    protected function nextVoucherNumber(Carbon $billingMonth): string
    {
        $prefix = 'VOU-' . $billingMonth->format('Y-m') . '-';
        $seq = Invoice::whereNotNull('billing_month')
            ->whereDate('billing_month', $billingMonth->toDateString())
            ->count() + 1;

        return $prefix . str_pad((string) $seq, 5, '0', STR_PAD_LEFT);
    }
}
