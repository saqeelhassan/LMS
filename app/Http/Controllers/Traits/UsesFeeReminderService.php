<?php

namespace App\Http\Controllers\Traits;

use App\Services\FeeReminderService;

/**
 * Trait for controllers that send fee reminders.
 * Keeps Digi Sindh fee logic isolated from core LMS.
 */
trait UsesFeeReminderService
{
    protected function feeReminderService(): FeeReminderService
    {
        return app(FeeReminderService::class);
    }
}
