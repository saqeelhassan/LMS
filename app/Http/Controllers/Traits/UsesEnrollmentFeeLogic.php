<?php

namespace App\Http\Controllers\Traits;

use App\Models\Enrollment;
use App\Services\FeeVoucherService;
use Illuminate\Http\Request;

/**
 * Trait for controllers that handle enrollment approval with fee/discount logic.
 * Keeps Digi Sindh enrollment + voucher logic isolated from core LMS.
 */
trait UsesEnrollmentFeeLogic
{
    protected function applyEnrollmentApprovalLogic(Enrollment $enrollment, Request $request): array
    {
        $enrollment->load('batch');
        $enrollment->enrollment_status = 'active';

        if ($enrollment->monthly_fee === null && $enrollment->batch?->monthly_fee !== null) {
            $enrollment->monthly_fee = $enrollment->batch->monthly_fee;
        }

        $discountType = $request->input('discount_type', 'None');
        $discountValue = $request->input('discount_value');
        if (in_array($discountType, ['Percentage', 'Fixed'], true) && $discountValue !== null && $discountValue !== '') {
            $enrollment->discount_type = $discountType;
            $enrollment->discount_value = $discountValue;
        } else {
            $enrollment->discount_type = 'None';
            $enrollment->discount_value = null;
        }

        if (! $enrollment->start_date) {
            $enrollment->start_date = now()->startOfMonth();
        }
        $enrollment->save();

        $voucherService = app(FeeVoucherService::class);
        $voucher = $voucherService->generateFirstMonthForEnrollment($enrollment);

        return [
            'message' => $this->buildEnrollmentApprovalMessage($enrollment, $voucher),
            'voucher' => $voucher,
        ];
    }

    protected function buildEnrollmentApprovalMessage(Enrollment $enrollment, $voucher): string
    {
        $msg = 'Enrollment approved.';
        if ($enrollment->discount_type !== 'None') {
            $msg .= ' Permanent discount applied: ' . $enrollment->discount_type . ' ' . $enrollment->discount_value . '.';
        }
        if ($voucher) {
            $msg .= ' Voucher #' . $voucher->invoice_no . ' created. Student can pay to get access.';
        } else {
            $msg .= ' No voucher created (set batch/monthly fee to generate one).';
        }

        return $msg;
    }
}
