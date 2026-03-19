<?php

namespace App\Console\Commands;

use App\Models\Enrollment;
use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Console\Command;

/**
 * Auto-block students with unpaid fees past the validity day (default: 10th).
 * Sets access_expiry_date to yesterday so portal access is blocked.
 */
class AutoBlockFeeDefaultersCommand extends Command
{
    protected $signature = 'fees:auto-block {--dry-run : Show what would be blocked without changing}';
    protected $description = 'Block students with unpaid fees past validity day (default 10th of month)';

    public function handle(): int
    {
        if (! \App\Helpers\FeeConfig::autoBlockEnabled()) {
            $this->info('Auto-block is disabled (Settings).');
            return 0;
        }

        $validityDay = \App\Helpers\FeeConfig::validityDay();
        $today = Carbon::today();
        $cutoff = $today->copy()->startOfMonth()->addDays($validityDay - 1);

        if ($today->day < $validityDay) {
            $cutoff = $today->copy()->subMonth()->startOfMonth()->addDays($validityDay - 1);
        }

        $invoices = Invoice::whereNotNull('enrollment_id')
            ->whereRaw('(amount - COALESCE(discount_amount,0) - amount_paid) > 0')
            ->where('due_date', '<', $cutoff)
            ->whereHas('enrollment', fn ($q) => $q->where('enrollment_status', 'active'))
            ->with('enrollment')
            ->get();

        $enrollmentIds = $invoices->pluck('enrollment_id')->unique()->filter()->values();

        $blocked = 0;
        foreach ($enrollmentIds as $eid) {
            $enrollment = Enrollment::find($eid);
            if (! $enrollment || $enrollment->enrollment_status !== 'active') {
                continue;
            }
            $expiry = $enrollment->access_expiry_date?->format('Y-m-d');
            if ($expiry && $expiry >= $today->toDateString()) {
                if (! $this->option('dry-run')) {
                    $enrollment->access_expiry_date = $today->copy()->subDay();
                    $enrollment->save();
                }
                $blocked++;
                $this->line("Blocked enrollment #{$enrollment->id} (user: {$enrollment->user_id})");
            }
        }

        $msg = $this->option('dry-run') ? "Would block {$blocked} enrollment(s)." : "Blocked {$blocked} enrollment(s).";
        $this->info($msg);
        return 0;
    }
}
