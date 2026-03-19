@extends('layouts.student')

@section('content')
<div>
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="card-title mb-0">Overview</h5>
            </div>
            <div class="card-body">
                <p class="mb-3">Your course enrollments and online access status. Pay your monthly fee to keep access.</p>
                <div class="row g-3 align-items-center">
                    <div class="col-12 col-md-6 col-lg-4">
                        <span class="small d-block text-muted">Access status</span>
                        @if($hasAccess)
                            <h4 class="text-success mb-0"><i class="bi bi-unlock-fill me-2"></i>Active</h4>
                            <p class="small mb-0">
                                @if($enrollments->contains(fn($e) => $e->manual_access))
                                    You have free access (granted by admin). You can access courses and content.
                                @else
                                    You can access courses and content.
                                @endif
                            </p>
                        @else
                            <h4 class="text-danger mb-0"><i class="bi bi-lock-fill me-2"></i>Blocked</h4>
                            <p class="small mb-0">Pay your fee to unlock access.</p>
                        @endif
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <span class="small d-block text-muted">Access until</span>
                        @if($latestExpiry)
                            <h4 class="mb-0">{{ $latestExpiry->format('M j, Y') }}</h4>
                            <p class="small mb-0">Last paid period ends this date.</p>
                        @else
                            <h4 class="mb-0">—</h4>
                            <p class="small mb-0">Pay to get access.</p>
                        @endif
                    </div>
                    <div class="col-12 col-md-6 col-lg-4">
                        <span class="small d-block text-muted">Monthly fee</span>
                        <h4 class="mb-0">{{ $currency }} {{ number_format($monthlyTotal > 0 ? $monthlyTotal : 0, 0) }}</h4>
                        <p class="small mb-0">Total per month (all courses).</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Pay your fee online</h5>
                <a href="{{ route('student.fee-status') }}" class="btn btn-primary btn-sm">Pay online</a>
            </div>
            <div class="card-body">
                @if($totalDue > 0)
                    <p class="mb-0">You have <strong>{{ $currency }} {{ number_format($totalDue, 0) }}</strong> due. Pay now to avoid access being blocked.</p>
                @else
                    <p class="mb-0">View your vouchers or pay when the next fee is generated.</p>
                @endif
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header">
                <h5 class="card-title mb-0">Your enrollments</h5>
            </div>
            <div class="card-body p-0">
                @if($enrollments->isEmpty())
                    <p class="p-4 mb-0">You are not enrolled in any course yet.</p>
                @else
                    <div class="table-responsive">
                        <table class="table header-border table-hover verticle-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Course</th>
                                    <th>Access until</th>
                                    <th>Monthly fee</th>
                                    <th class="text-end">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($enrollments as $e)
                                <tr>
                                    <td>{{ $e->course->name ?? '—' }}</td>
                                    <td>
                                        @if($e->access_expiry_date)
                                            {{ $e->access_expiry_date->format('M j, Y') }}
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td>{{ $currency }} {{ number_format((float)($e->monthly_fee ?? 0), 0) }}</td>
                                    <td class="text-end">
                                        @if($e->hasAccessToday())
                                            @if($e->manual_access)
                                                <span class="badge bg-info">Free access</span>
                                            @else
                                                <span class="badge bg-success">Active</span>
                                            @endif
                                        @else
                                            <span class="badge bg-danger">Pay to unlock</span>
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

        @if($pendingInvoices->isNotEmpty())
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Pending vouchers</h5>
                <a href="{{ route('student.fee-status') }}" class="btn btn-sm btn-primary">Pay online</a>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @foreach($pendingInvoices->take(10) as $inv)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>{{ $inv->invoice_no }} — {{ $inv->billing_month ? $inv->billing_month->format('M Y') : $inv->due_date?->format('M Y') }} ({{ $inv->enrollment->course->name ?? '—' }})</span>
                        <span class="fw-medium">{{ $currency }} {{ number_format((float)$inv->amount - (float)$inv->amount_paid, 0) }}</span>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif
    </div>
@endsection
