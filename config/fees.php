<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Fee Validity Day (Strict Enforcement)
    |--------------------------------------------------------------------------
    | Fees are valid/due by this day of the month (e.g. 10 = 10th).
    | If not paid by this date, student portal access is auto-blocked.
    */
    'validity_day' => env('FEES_VALIDITY_DAY', 10),
    'voucher_due_day' => env('FEES_VOUCHER_DUE_DAY', 10),

    /*
    |--------------------------------------------------------------------------
    | Auto-Block Defaulters
    |--------------------------------------------------------------------------
    | When true, daily cron will block students with unpaid fees past validity day.
    */
    'auto_block_enabled' => env('FEES_AUTO_BLOCK', true),

    /*
    |--------------------------------------------------------------------------
    | Payment Approval
    |--------------------------------------------------------------------------
    | When true, payments require manual approval before unlocking student access.
    | When false, payments are approved automatically.
    */
    'require_payment_approval' => env('FEES_REQUIRE_APPROVAL', false),

    /*
    |--------------------------------------------------------------------------
    | Fee reminder driver
    |--------------------------------------------------------------------------
    | 'log' = log only. 'whatsapp' = WhatsApp (requires config). 'sms' = SMS gateway.
    */
    'reminder_driver' => env('FEE_REMINDER_DRIVER', 'log'),

    /*
    |--------------------------------------------------------------------------
    | WhatsApp integration (for reminders)
    |--------------------------------------------------------------------------
    */
    'whatsapp_enabled' => env('WHATSAPP_ENABLED', false),

    /*
    |--------------------------------------------------------------------------
    | Attendance Deduction / Fines
    |--------------------------------------------------------------------------
    | When enabled, absences (and optionally Late) incur a fine added to arrears.
    | Processed monthly via ProcessAttendanceDeductionsCommand.
    */
    'attendance_fine_enabled' => env('ATTENDANCE_FINE_ENABLED', false),
    'attendance_fine_per_absence' => env('ATTENDANCE_FINE_PER_ABSENCE', 0),
    'attendance_fine_per_late' => env('ATTENDANCE_FINE_PER_LATE', 0),
];
