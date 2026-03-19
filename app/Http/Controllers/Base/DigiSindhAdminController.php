<?php

namespace App\Http\Controllers\Base;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\UsesFeeConfig;
use App\Http\Controllers\Traits\UsesFeeReminderService;
use App\Http\Controllers\Traits\UsesFeeVoucherService;

/**
 * Base controller for Admin controllers with Digi Sindh fee logic.
 * Extend this for fee-related admin controllers so custom logic stays in one place.
 */
abstract class DigiSindhAdminController extends Controller
{
    use UsesFeeConfig;
    use UsesFeeReminderService;
    use UsesFeeVoucherService;
}
