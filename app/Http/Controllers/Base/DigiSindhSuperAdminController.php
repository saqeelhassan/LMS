<?php

namespace App\Http\Controllers\Base;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\UsesFeeVoucherService;

/**
 * Base controller for Super Admin controllers with Digi Sindh fee/approval logic.
 * Extend this for super-admin controllers that use FeeVoucherService or course approval.
 */
abstract class DigiSindhSuperAdminController extends Controller
{
    use UsesFeeVoucherService;
}
