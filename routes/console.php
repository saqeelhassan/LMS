<?php

use App\Models\Enrollment;
use App\Models\Invoice;
use App\Services\FeeVoucherService;
use Carbon\Carbon;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('fees:generate-vouchers {month?}', function (?string $month = null) {
    $date = $month ? Carbon::parse($month) : Carbon::now();
    $service = app(FeeVoucherService::class);
    $result = $service->generateForMonth($date);
    $this->info("Fee vouchers for {$date->format('F Y')}: created {$result['created']}, skipped {$result['skipped']}.");
    if (! empty($result['errors'])) {
        foreach ($result['errors'] as $enrollmentId => $msg) {
            $this->error("Enrollment {$enrollmentId}: {$msg}");
        }
    }
})->purpose('Generate monthly fee vouchers for active enrollments (run on 1st of each month)');

Artisan::command('fees:sync-access-expiry', function () {
    $updated = 0;
    foreach (Enrollment::where('enrollment_status', 'active')->get() as $enrollment) {
        $paidInvoices = Invoice::where('enrollment_id', $enrollment->id)
            ->whereRaw('amount_paid >= (amount - COALESCE(discount_amount, 0))')
            ->get();
        if ($paidInvoices->isEmpty()) {
            continue;
        }
        $maxExpiry = null;
        foreach ($paidInvoices as $inv) {
            $date = $inv->billing_month ?? $inv->due_date ?? now();
            $end = Carbon::parse($date)->endOfMonth()->toDateString();
            if ($maxExpiry === null || $end > $maxExpiry) {
                $maxExpiry = $end;
            }
        }
        $current = $enrollment->access_expiry_date?->format('Y-m-d');
        if ($maxExpiry && (! $current || $maxExpiry > $current)) {
            $enrollment->access_expiry_date = $maxExpiry;
            $enrollment->save();
            $updated++;
        }
    }
    $this->info("Synced access_expiry_date for {$updated} enrollment(s).");
})->purpose('Set enrollment access_expiry_date from paid invoices (fix locked portal after manual payment)');

Artisan::command('attendance:process-deductions {month?}', function (?string $month = null) {
    $date = $month ? \Carbon\Carbon::parse($month) : \Carbon\Carbon::now()->subMonth();
    $service = app(\App\Services\AttendanceDeductionService::class);
    $result = $service->processForMonth($date);
    $this->info("Attendance deductions for {$date->format('F Y')}: processed {$result['processed']}, skipped {$result['skipped']}, total {$result['total_amount']}.");
    if (! empty($result['errors'])) {
        foreach ($result['errors'] as $enrollmentId => $msg) {
            $this->error("Enrollment {$enrollmentId}: {$msg}");
        }
    }
})->purpose('Apply attendance fines (Absent/Late) to enrollments for a month; run on 2nd of each month for previous month');

Artisan::command('fees:mark-overdue', function () {
    $today = Carbon::today()->toDateString();
    $invoices = Invoice::where('due_date', '<', $today)
        ->whereIn('status', ['pending', 'partial'])
        ->get();
    $updated = 0;
    foreach ($invoices as $inv) {
        if ($inv->balance > 0) {
            $inv->update(['status' => 'overdue']);
            $updated++;
        }
    }
    $this->info("Marked {$updated} invoice(s) as overdue.");
})->purpose('Mark unpaid invoices past due date as overdue (run daily)');

// Automatic voucher generation: every night at 12:00 AM (current month; on 1st, next month vouchers created)
Schedule::command('fees:generate-vouchers')->dailyAt('00:00');
Schedule::command('fees:mark-overdue')->dailyAt('01:00');
Schedule::command('fees:auto-block')->dailyAt('02:00');
Schedule::command('fees:remind')->dailyAt('08:00');
Schedule::command('attendance:upgrade-online')->everyFiveMinutes();
Schedule::command('biometric:pull-zkteco', ['--process' => true])->everyFiveMinutes();
Schedule::command('attendance:process-deductions')->monthlyOn(2, '03:00');
