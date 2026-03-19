<?php

namespace App\Http\Controllers\Base;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\UsesFeeVoucherService;

/**
 * Base controller for Student controllers with Digi Sindh fee/payment logic.
 * Extend this for payment-required, profile fee status, etc.
 */
abstract class DigiSindhStudentController extends Controller
{
    use UsesFeeVoucherService;
}
