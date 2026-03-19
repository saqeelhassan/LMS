<?php

namespace App\Http\Controllers\Traits;

use App\Services\FeeVoucherService;

/**
 * Trait for controllers that use FeeVoucherService (voucher generation, markOverdue).
 * Keeps Digi Sindh fee logic isolated from core LMS.
 */
trait UsesFeeVoucherService
{
    protected function feeVoucherService(): FeeVoucherService
    {
        return app(FeeVoucherService::class);
    }
}
