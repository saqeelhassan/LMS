<?php

namespace App\Helpers;

use App\Models\Setting;

/** Fee settings: reads from Setting (UI) first, falls back to config. */
class FeeConfig
{
    public static function validityDay(): int
    {
        $v = Setting::get('fees_validity_day');
        return $v !== null && $v !== '' ? (int) $v : (int) config('fees.validity_day', 10);
    }

    public static function autoBlockEnabled(): bool
    {
        $v = Setting::get('fees_auto_block');
        if ($v === '0' || $v === 'false') {
            return false;
        }
        if ($v === '1' || $v === 'true') {
            return true;
        }
        return (bool) config('fees.auto_block_enabled', true);
    }

    public static function requirePaymentApproval(): bool
    {
        $v = Setting::get('fees_require_approval');
        if ($v === '0' || $v === 'false') {
            return false;
        }
        if ($v === '1' || $v === 'true') {
            return true;
        }
        return (bool) config('fees.require_payment_approval', false);
    }

    /** Whether attendance-based fines are enabled. */
    public static function attendanceFineEnabled(): bool
    {
        $v = Setting::get('attendance_fine_enabled');
        if ($v === '0' || $v === 'false') {
            return false;
        }
        if ($v === '1' || $v === 'true') {
            return true;
        }
        return (bool) config('fees.attendance_fine_enabled', false);
    }

    /** Fine amount per absence (currency). */
    public static function attendanceFinePerAbsence(): float
    {
        $v = Setting::get('attendance_fine_per_absence');
        return $v !== null && $v !== '' ? (float) $v : (float) config('fees.attendance_fine_per_absence', 0);
    }

    /** Fine amount per Late (optional; 0 = no fine for Late). */
    public static function attendanceFinePerLate(): float
    {
        $v = Setting::get('attendance_fine_per_late');
        return $v !== null && $v !== '' ? (float) $v : (float) config('fees.attendance_fine_per_late', 0);
    }
}
