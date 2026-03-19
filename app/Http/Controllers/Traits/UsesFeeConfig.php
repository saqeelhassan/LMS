<?php

namespace App\Http\Controllers\Traits;

use App\Helpers\FeeConfig;

/**
 * Trait for controllers that use FeeConfig.
 * Keeps Digi Sindh fee logic isolated from core LMS.
 */
trait UsesFeeConfig
{
    protected function requirePaymentApproval(): bool
    {
        return FeeConfig::requirePaymentApproval();
    }

    protected function autoBlockEnabled(): bool
    {
        return FeeConfig::autoBlockEnabled();
    }

    protected function feeValidityDay(): int
    {
        return FeeConfig::validityDay();
    }
}
