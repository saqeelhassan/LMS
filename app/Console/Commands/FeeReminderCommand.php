<?php

namespace App\Console\Commands;

use App\Models\Invoice;
use App\Services\FeeReminderService;
use Carbon\Carbon;
use Illuminate\Console\Command;

/**
 * Send fee reminders for unpaid invoices.
 * When WhatsApp/SMS is configured, uses that; otherwise logs.
 * Run daily (e.g. 8am) for recurring "again & again" follow-ups.
 */
class FeeReminderCommand extends Command
{
    protected $signature = 'fees:remind {--overdue-only : Only overdue invoices} {--dry-run : Show what would be reminded}';
    protected $description = 'Send fee reminders for unpaid invoices (WhatsApp/SMS or log)';

    public function handle(): int
    {
        $validityDay = \App\Helpers\FeeConfig::validityDay();
        $today = Carbon::today();
        $cutoff = $today->copy()->startOfMonth()->addDays($validityDay - 1);
        if ($today->day < $validityDay) {
            $cutoff = $today->copy()->subMonth()->startOfMonth()->addDays($validityDay - 1);
        }

        $query = Invoice::whereRaw('(amount - COALESCE(discount_amount,0) - amount_paid) > 0')
            ->whereNotNull('user_id')
            ->with('user.userDetail');

        if ($this->option('overdue-only')) {
            $query->where('due_date', '<', $today);
        } else {
            // Remind those past validity day
            $query->where('due_date', '<', $cutoff);
        }

        $invoices = $query->get();
        $service = app(FeeReminderService::class);
        $sent = 0;

        foreach ($invoices as $inv) {
            if ($this->option('dry-run')) {
                $this->line("Would remind: Invoice #{$inv->invoice_no} — {$inv->user?->email}");
                $sent++;
                continue;
            }
            if ($service->sendReminder($inv)) {
                $sent++;
                $this->line("Reminder sent: Invoice #{$inv->invoice_no}");
            }
        }

        $this->info($this->option('dry-run') ? "Would send {$sent} reminder(s)." : "Sent {$sent} reminder(s).");
        return 0;
    }
}
