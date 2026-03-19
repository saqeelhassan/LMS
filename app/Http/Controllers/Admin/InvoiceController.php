<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Base\DigiSindhAdminController;
use App\Models\Enrollment;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class InvoiceController extends DigiSindhAdminController
{
    public function index(Request $request): View
    {
        $invoices = Invoice::with(['user.userDetail', 'enrollment.course'])
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.invoices.index', compact('invoices'));
    }

    public function create(): View
    {
        $students = User::whereHas('role', fn ($q) => $q->where('name', 'Student'))->where('is_active', true)->with('userDetail')->orderBy('email')->get();
        $enrollments = Enrollment::with('course', 'user.userDetail')->where('enrollment_status', 'active')->get();

        return view('admin.invoices.create', compact('students', 'enrollments'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'enrollment_id' => ['nullable', 'integer', 'exists:enrollments,id'],
            'amount' => ['required', 'numeric', 'min:0'],
            'due_date' => ['required', 'date'],
            'description' => ['nullable', 'string', 'max:500'],
            'fee_type' => ['nullable', 'string', 'max:50'],
            'payment_type' => ['nullable', 'string', 'max:50'],
            'payment_reference' => ['nullable', 'string', 'max:100'],
        ]);

        $parts = array_filter([
            $validated['fee_type'] ?? null ? 'Fee type: ' . $validated['fee_type'] : null,
            $validated['payment_type'] ?? null ? 'Payment type: ' . $validated['payment_type'] : null,
            $validated['payment_reference'] ?? null ? 'Ref: ' . $validated['payment_reference'] : null,
            $validated['description'] ?? null,
        ]);
        $description = $parts ? implode("\n", $parts) : null;
        if ($description && strlen($description) > 500) {
            $description = substr($description, 0, 497) . '...';
        }

        $invoiceNo = 'INV-' . str_pad((string) (Invoice::max('id') + 1), 6, '0', STR_PAD_LEFT);
        Invoice::create([
            'invoice_no' => $invoiceNo,
            'user_id' => $validated['user_id'],
            'enrollment_id' => $validated['enrollment_id'] ?? null,
            'amount' => $validated['amount'],
            'amount_paid' => 0,
            'due_date' => $validated['due_date'],
            'status' => 'pending',
            'description' => $description,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('admin.invoices.index')->with('success', 'Invoice created.');
    }

    public function show(Invoice $invoice): View
    {
        $invoice->load(['user.userDetail', 'enrollment.course', 'payments']);
        $paymentMethods = \App\Models\PaymentMethod::orderBy('name')->get();
        $balanceDue = (float) max(0, ($invoice->amount ?? 0) - ($invoice->discount_amount ?? 0) - ($invoice->amount_paid ?? 0));

        return view('admin.invoices.show', compact('invoice', 'paymentMethods', 'balanceDue'));
    }

    public function recordPayment(Request $request, Invoice $invoice): RedirectResponse
    {
        $balance = $invoice->balance;
        $validated = $request->validate([
            'amount' => ['required', 'numeric', 'min:0.01', 'max:' . max(0.01, $balance)],
            'payment_method_id' => ['nullable', 'integer', 'exists:payment_methods,id'],
            'method_note' => ['nullable', 'string', 'max:100'],
            'paid_at' => ['required', 'date'],
            'reference' => ['nullable', 'string', 'max:100'],
            'bank_reference' => ['nullable', 'string', 'max:100'],
            'bank_deposit_date' => ['nullable', 'date'],
        ]);

        $requireApproval = $this->requirePaymentApproval();
        $paymentStatus = $requireApproval ? 'pending_approval' : 'approved';

        DB::transaction(function () use ($invoice, $validated, $paymentStatus, $requireApproval) {
            $payment = Payment::create([
                'invoice_id' => $invoice->id,
                'amount' => $validated['amount'],
                'payment_method_id' => $validated['payment_method_id'] ?? null,
                'method_note' => $validated['method_note'] ?? 'Cash',
                'paid_at' => $validated['paid_at'],
                'reference' => $validated['reference'] ?? null,
                'bank_reference' => $validated['bank_reference'] ?? null,
                'bank_deposit_date' => $validated['bank_deposit_date'] ?? null,
                'recorded_by' => auth()->id(),
                'status' => $paymentStatus,
                'approved_at' => $requireApproval ? null : now(),
                'approved_by' => $requireApproval ? null : auth()->id(),
            ]);

            if (! $requireApproval) {
                $this->applyPaymentToInvoice($invoice, (float) $validated['amount']);
            }
        });

        $msg = $requireApproval
            ? 'Payment recorded. Awaiting approval before it is applied to the invoice.'
            : 'Payment recorded.';
        return redirect()->route('admin.invoices.show', $invoice)->with('success', $msg);
    }

    /** Apply approved payment to invoice (amount_paid, status, enrollment access). */
    protected function applyPaymentToInvoice(Invoice $invoice, float $amount): void
    {
        if ($invoice->enrollment_id && ! $invoice->relationLoaded('enrollment')) {
            $invoice->load('enrollment');
        }
        $totalPaid = $invoice->amount_paid + $amount;
        $amountDue = (float) max(0, $invoice->amount - ($invoice->discount_amount ?? 0));
        $status = $totalPaid >= $amountDue ? 'paid' : 'partial';
        $invoice->update([
            'amount_paid' => $totalPaid,
            'status' => $status,
        ]);

        if ($invoice->enrollment_id) {
            $enrollment = $invoice->enrollment;
            $enrollment->fees_collected = ($enrollment->fees_collected ?? 0) + $amount;
            if ($status === 'paid') {
                $newExpiry = $invoice->billing_month
                    ? Carbon::parse($invoice->billing_month)->endOfMonth()->toDateString()
                    : ($invoice->due_date
                        ? Carbon::parse($invoice->due_date)->endOfMonth()->toDateString()
                        : Carbon::now()->endOfMonth()->toDateString());
                $current = $enrollment->access_expiry_date?->format('Y-m-d');
                if (! $current || $newExpiry > $current) {
                    $enrollment->access_expiry_date = $newExpiry;
                }
            }
            $enrollment->save();
        }
    }

    public function approvePayment(Request $request, Invoice $invoice, Payment $payment): RedirectResponse
    {
        if ($payment->invoice_id !== $invoice->id) {
            abort(404);
        }
        if ($payment->status !== 'pending_approval') {
            return redirect()->back()->with('info', 'Payment is already ' . $payment->status . '.');
        }

        DB::transaction(function () use ($invoice, $payment) {
            $payment->update([
                'status' => 'approved',
                'approved_at' => now(),
                'approved_by' => auth()->id(),
            ]);
            $this->applyPaymentToInvoice($invoice, (float) $payment->amount);
        });

        return redirect()->route('admin.invoices.show', $invoice)->with('success', 'Payment approved and applied.');
    }

    public function rejectPayment(Request $request, Invoice $invoice, Payment $payment): RedirectResponse
    {
        if ($payment->invoice_id !== $invoice->id) {
            abort(404);
        }
        if ($payment->status !== 'pending_approval') {
            return redirect()->back()->with('info', 'Payment is already ' . $payment->status . '.');
        }

        $payment->update(['status' => 'rejected']);
        return redirect()->route('admin.invoices.show', $invoice)->with('success', 'Payment rejected.');
    }

    public function applyDiscount(Request $request, Invoice $invoice): RedirectResponse
    {
        $maxDiscount = (float) $invoice->amount;
        $validated = $request->validate([
            'discount_amount' => ['required', 'numeric', 'min:0', 'max:' . $maxDiscount],
        ]);
        $invoice->update(['discount_amount' => $validated['discount_amount']]);
        return redirect()->route('admin.invoices.show', $invoice)->with('success', 'Discount applied.');
    }

    /** Send fee reminder (SMS/WhatsApp or log) to student. */
    public function remind(Invoice $invoice): RedirectResponse
    {
        if ($invoice->balance <= 0) {
            return redirect()->back()->with('info', 'Voucher is already paid.');
        }
        $this->feeReminderService()->sendReminder($invoice);
        return redirect()->back()->with('success', 'Reminder sent to student.');
    }

    /** Generate monthly fee vouchers for the current month (or optional month). */
    public function generateVouchers(Request $request): RedirectResponse
    {
        $month = $request->filled('month') ? Carbon::parse($request->month) : Carbon::now();
        $result = $this->feeVoucherService()->generateForMonth($month);

        $msg = "Generated {$result['created']} voucher(s) for {$month->format('F Y')}. Skipped {$result['skipped']} (already exist).";
        if (! empty($result['errors'])) {
            $msg .= ' ' . count($result['errors']) . ' error(s).';
        }

        return redirect()->route('admin.invoices.index')->with('success', $msg);
    }
}
