@extends('layouts.admin')

@section('css')
<style>
    /* Prevent theme from stretching cards (height: calc(100% - 30px)) which causes extra blank space */
    .invoice-show-page .card { height: auto !important; margin-bottom: 1rem !important; }
    .invoice-show-page .card-body { min-height: 0 !important; }
    .invoice-show-page #record-payment-card { margin-top: 0 !important; }
</style>
@endsection

@section('content')
<div class="invoice-show-page">
<div class="row page-titles mx-0">
    <div class="col-sm-6 p-md-0">
        <div class="welcome-text">
            <h4>Invoice {{ $invoice->invoice_no }}</h4>
        </div>
    </div>
    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex align-items-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.fee-management.index') }}">Fees Collection</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.invoices.index') }}">Fees Receipt</a></li>
            <li class="breadcrumb-item active">Invoice {{ $invoice->invoice_no }}</li>
        </ol>
        <a href="{{ route('admin.invoices.index') }}" class="btn btn-sm btn-primary ms-2">Back to list</a>
    </div>
</div>

<div class="row">
    <div class="col-xl-12 col-xxl-12 col-sm-12">
        <div class="card invoice-details-card">
            <div class="card-header">
                <h5 class="card-title mb-0">Details</h5>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success mb-4">{{ session('success') }}</div>
                @endif
                <table class="table header-border table-borderless mb-0">
                    <tr><th width="140">Student</th><td>{{ $invoice->user?->name ?? '—' }} ({{ $invoice->user?->email ?? '—' }})</td></tr>
                    <tr><th>Course</th><td>{{ $invoice->enrollment?->course?->name ?? '—' }}</td></tr>
                    <tr><th>Amount</th><td>Rs {{ number_format($invoice->amount, 0) }}</td></tr>
                    @if(($invoice->discount_amount ?? 0) > 0)
                    <tr><th>Discount</th><td class="text-success">- Rs {{ number_format($invoice->discount_amount, 0) }}</td></tr>
                    <tr><th>Amount after discount</th><td>Rs {{ number_format($invoice->amount_after_discount, 0) }}</td></tr>
                    @endif
                    <tr><th>Amount paid</th><td>Rs {{ number_format($invoice->amount_paid, 0) }}</td></tr>
                    <tr><th>Balance</th><td class="fw-bold">Rs {{ number_format($invoice->balance, 0) }}</td></tr>
                    <tr><th>Due date</th><td>{{ $invoice->due_date?->format('M j, Y') ?? '—' }}</td></tr>
                    <tr><th>Status</th>
                        <td>@if($invoice->status === 'paid')
                            <span class="badge bg-success">Paid</span>
                        @elseif($invoice->status === 'partial')
                            <span class="badge bg-warning">Partial</span>
                        @else
                            <span class="badge bg-secondary">Pending</span>
                        @endif</td>
                    </tr>
                    @if($invoice->description)
                        <tr><th>Description</th><td>{{ $invoice->description }}</td></tr>
                    @endif
                </table>
                @if($invoice->balance > 0 && $invoice->status !== 'paid')
                <hr class="my-3">
                <form method="post" action="{{ route('admin.invoices.apply-discount', $invoice) }}" class="row g-2 align-items-end mt-2">
                    @csrf
                    <div class="col-auto">
                        <label for="discount_amount" class="form-label small mb-0">Apply discount (Rs)</label>
                        <input type="number" name="discount_amount" id="discount_amount" class="form-control form-control-sm" min="0" max="{{ $invoice->amount }}" step="0.01" value="{{ $invoice->discount_amount ?? 0 }}" style="width:120px">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-sm btn-outline-secondary">Apply</button>
                    </div>
                </form>
                @endif
            </div>
        </div>

        @if($invoice->status !== 'paid')
        <div class="card mb-3" id="record-payment-card">
            <div class="card-header">
                <h5 class="card-title mb-0">Record payment</h5>
            </div>
            <div class="card-body">
                @if(isset($balanceDue) && $balanceDue <= 0)
                    <p class="text-muted mb-0">No balance due. Amount to pay: Rs 0.</p>
                @else
                    @if($errors->any())
                        <div class="alert alert-danger mb-4">
                            <ul class="mb-0 list-unstyled small">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                        </div>
                    @endif
                    <form method="post" action="{{ route('admin.invoices.record-payment', $invoice) }}">
                        @csrf
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="amount" class="form-label">Amount (Rs) * <small class="text-muted">Max: {{ number_format($balanceDue ?? $invoice->balance ?? 0, 0) }}</small></label>
                                <input type="number" name="amount" id="amount" class="form-control" min="0.01" max="{{ ($balanceDue ?? $invoice->balance ?? 0) > 0 ? ($balanceDue ?? $invoice->balance) : 999999999 }}" step="0.01" value="" required placeholder="Enter amount">
                            </div>
                            <div class="col-md-6">
                                <label for="paid_at" class="form-label">Paid date *</label>
                                <input type="date" name="paid_at" id="paid_at" class="form-control" value="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="payment_method_id" class="form-label">Payment method</label>
                                <select name="payment_method_id" id="payment_method_id" class="form-select">
                                    <option value="">— Select —</option>
                                    @foreach($paymentMethods ?? [] as $pm)
                                        <option value="{{ $pm->id }}">{{ $pm->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="method_note" class="form-label">Method note (e.g. Cash, Online)</label>
                                <input type="text" name="method_note" id="method_note" class="form-control" value="Cash" maxlength="100">
                            </div>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="reference" class="form-label">Reference (optional)</label>
                                <input type="text" name="reference" id="reference" class="form-control" maxlength="100">
                            </div>
                            <div class="col-md-6">
                                <label for="bank_reference" class="form-label">Bank reference (optional)</label>
                                <input type="text" name="bank_reference" id="bank_reference" class="form-control" maxlength="100" placeholder="Deposit/transfer ref">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="bank_deposit_date" class="form-label">Bank deposit date (optional)</label>
                            <input type="date" name="bank_deposit_date" id="bank_deposit_date" class="form-control" style="max-width:200px">
                        </div>
                        <button type="submit" class="btn btn-success">Record payment</button>
                    </form>
                @endif
            </div>
        </div>
        @endif

        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Payment history</h5>
            </div>
            <div class="card-body p-0">
                @if($invoice->payments->isEmpty())
                    <p class="mb-0 p-4 text-body">No payments recorded.</p>
                @else
                    <div class="table-responsive">
                        <table class="table header-border table-hover verticle-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Method</th>
                                    <th>Reference</th>
                                    <th>Bank ref / Deposit</th>
                                    <th>Status</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($invoice->payments as $p)
                                    <tr>
                                        <td>{{ $p->paid_at?->format('M j, Y H:i') ?? '—' }}</td>
                                        <td>Rs {{ number_format($p->amount, 0) }}</td>
                                        <td>{{ $p->method_note ?? $p->paymentMethod?->name ?? '—' }}</td>
                                        <td>{{ $p->reference ?? '—' }}</td>
                                        <td>{{ $p->bank_reference ?? '—' }}@if($p->bank_deposit_date) <small class="text-muted">({{ $p->bank_deposit_date->format('M j') }})</small>@endif</td>
                                        <td>
                                            @if(($p->status ?? 'approved') === 'pending_approval')
                                                <span class="badge bg-warning">Pending</span>
                                            @elseif(($p->status ?? 'approved') === 'rejected')
                                                <span class="badge bg-danger">Rejected</span>
                                            @else
                                                <span class="badge bg-success">Approved</span>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            @if(($p->status ?? 'approved') === 'pending_approval')
                                                <form method="post" action="{{ route('admin.invoices.approve-payment', [$invoice, $p]) }}" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-success">Approve</button>
                                                </form>
                                                <form method="post" action="{{ route('admin.invoices.reject-payment', [$invoice, $p]) }}" class="d-inline" onsubmit="return confirm('Reject this payment?');">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">Reject</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
</div>
@endsection
