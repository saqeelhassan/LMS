<?php

namespace App\Services;

use App\Models\Invoice;
use Illuminate\Support\Facades\Log;

/**
 * Sends fee reminder to student (SMS/WhatsApp). Driver: config('fees.reminder_driver') = 'log' | 'sms'.
 */
class FeeReminderService
{
    public function sendReminder(Invoice $invoice): bool
    {
        $invoice->load('user.userDetail');
        $name = $invoice->user->userDetail->first_name ?? $invoice->user->name ?? 'Student';
        $month = $invoice->billing_month
            ? $invoice->billing_month->format('F Y')
            : ($invoice->due_date ? $invoice->due_date->format('F Y') : 'this month');
        $message = "Dear {$name}, your fee for {$month} is pending. Please pay or upload your receipt to continue.";

        $driver = config('fees.reminder_driver', 'log');
        $whatsappEnabled = config('fees.whatsapp_enabled', false);

        if ($whatsappEnabled || $driver === 'whatsapp') {
            return $this->sendWhatsApp($invoice, $message);
        }
        if ($driver === 'sms') {
            return $this->sendSms($invoice, $message);
        }

        // Default: log (for testing; replace with SMS/WhatsApp when gateway is configured)
        Log::channel('single')->info('Fee reminder (log driver)', [
            'invoice_id' => $invoice->id,
            'invoice_no' => $invoice->invoice_no,
            'user_id' => $invoice->user_id,
            'phone' => $invoice->user->userDetail->mobile ?? $invoice->user->userDetail->whatsapp ?? null,
            'message' => $message,
        ]);

        return true;
    }

    protected function sendWhatsApp(Invoice $invoice, string $message): bool
    {
        $phone = $invoice->user->userDetail->whatsapp
            ?? $invoice->user->userDetail->mobile
            ?? $invoice->user->userDetail->contact_no
            ?? null;

        if (! $phone) {
            Log::warning('WhatsApp reminder skipped: no phone for user ' . $invoice->user_id);
            return false;
        }

        // TODO: Integrate WhatsApp Business API (e.g. Twilio, WhatsApp Cloud API).
        Log::channel('single')->info('Fee reminder (WhatsApp driver)', [
            'invoice_id' => $invoice->id,
            'phone' => $phone,
            'message' => $message,
        ]);
        return true;
    }

    protected function sendSms(Invoice $invoice, string $message): bool
    {
        $phone = $invoice->user->userDetail->mobile
            ?? $invoice->user->userDetail->whatsapp
            ?? $invoice->user->userDetail->contact_no
            ?? null;

        if (! $phone) {
            Log::warning('Fee reminder skipped: no phone for user ' . $invoice->user_id);

            return false;
        }

        // TODO: Integrate your SMS/WhatsApp gateway (e.g. Twilio, Jazz, Telenor).
        // Example: Http::post(config('services.sms.url'), ['to' => $phone, 'message' => $message]);
        Log::channel('single')->info('Fee reminder (SMS driver)', [
            'invoice_id' => $invoice->id,
            'phone' => $phone,
            'message' => $message,
        ]);

        return true;
    }
}
