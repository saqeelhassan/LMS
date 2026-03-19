@extends('layouts.student')

@section('content')
<div>
    <div class="card border border-danger rounded-3 shadow-sm">
        <div class="card-body p-4 p-md-5 text-center">
            <div class="mb-4">
                <span class="display-4 text-danger"><i class="bi bi-lock-fill"></i></span>
                <h1 class="h3 mt-3 mb-2">Payment required</h1>
                <p class="mb-0">Your online access is currently blocked.</p>
            </div>

            @if($expiredOn)
                <p class="lead mb-2">Your subscription expired on <strong>{{ $expiredOn }}</strong>.</p>
            @else
                <p class="lead mb-2">You need to pay your fee to unlock access.</p>
            @endif

            <p class="h4 mb-4">Pay the fee to unlock your portal.</p>

            <div class="d-flex flex-wrap justify-content-center gap-3 mb-4">
                <a href="{{ route('student.fee-status') }}" class="btn btn-primary btn-lg">
                    <i class="bi bi-credit-card me-2"></i>Pay online / View vouchers
                </a>
                <a href="{{ route('student.fee-status') }}#pay" class="btn btn-outline-primary btn-lg">
                    <i class="bi bi-upload me-2"></i>Upload receipt
                </a>
            </div>

            <p class="small text-muted mb-0">
                After paying, ask the admin to record your payment against the fee voucher. Access will be unlocked as soon as the voucher is marked paid.
            </p>
        </div>
    </div>

    @if($pendingInvoices->isNotEmpty())
    <div class="card border rounded-3 mt-4">
        <div class="card-header bg-light">
            <h5 class="mb-0">Your pending vouchers</h5>
        </div>
        <div class="card-body p-0">
            <ul class="list-group list-group-flush">
                @foreach($pendingInvoices->take(5) as $inv)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span>{{ $inv->invoice_no }} — {{ $inv->billing_month ? $inv->billing_month->format('M Y') : $inv->due_date?->format('M Y') }} ({{ $inv->enrollment->course->name ?? '—' }})</span>
                    <span class="fw-medium">{{ $currency }} {{ number_format($inv->balance, 0) }}</span>
                </li>
                @endforeach
            </ul>
        </div>
        <div class="card-footer bg-transparent">
            <a href="{{ route('student.fee-status') }}" class="btn btn-sm btn-outline-primary">View all & pay</a>
        </div>
    </div>
    @endif
</div>
@endsection
