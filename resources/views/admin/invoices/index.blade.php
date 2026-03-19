@extends('layouts.admin')

@section('content')
@php
    $currency = \App\Models\Setting::get('currency', 'PKR');
@endphp

<div class="row page-titles mx-0">
    <div class="col-sm-6 p-md-0">
        <div class="welcome-text">
            <h4>Fees Receipt</h4>
        </div>
    </div>
    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex align-items-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.fee-management.index') }}">Fees Collection</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0);">Fees Receipt</a></li>
        </ol>
        <div class="d-flex gap-2 ms-3">
            <form method="post" action="{{ route('admin.invoices.generate-vouchers') }}" class="d-inline" onsubmit="return confirm('Generate monthly fee vouchers for this month for all active enrollments with a monthly fee?');">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-primary">Generate monthly vouchers</button>
            </form>
            <a href="{{ route('admin.invoices.create') }}" class="btn btn-sm btn-primary">Create Invoice</a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-12 col-xxl-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Invoices & Fee Vouchers</h5>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success mb-3 rounded">{{ session('success') }}</div>
                @endif

                <form method="get" action="{{ route('admin.invoices.index') }}" class="row g-2 align-items-end mb-4">
                    <div class="col-md-4">
                        <label class="form-label small mb-0">Status</label>
                        <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="">All statuses</option>
                            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="partial" {{ request('status') === 'partial' ? 'selected' : '' }}>Partial</option>
                            <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="overdue" {{ request('status') === 'overdue' ? 'selected' : '' }}>Overdue</option>
                        </select>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table header-border table-hover verticle-middle">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Invoice #</th>
                                <th scope="col">Month</th>
                                <th scope="col">Student</th>
                                <th scope="col">Course</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Paid</th>
                                <th scope="col">Due date</th>
                                <th scope="col">Status</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($invoices as $inv)
                                <tr>
                                    <th>{{ $loop->iteration + ($invoices->currentPage() - 1) * $invoices->perPage() }}</th>
                                    <td>{{ $inv->invoice_no }}</td>
                                    <td>{{ $inv->billing_month ? $inv->billing_month->format('M Y') : '—' }}</td>
                                    <td>{{ $inv->user?->name ?? '—' }}</td>
                                    <td>{{ $inv->enrollment?->course?->name ?? '—' }}</td>
                                    <td>{{ $currency }} {{ number_format($inv->amount, 0) }}</td>
                                    <td>{{ $currency }} {{ number_format($inv->amount_paid, 0) }}</td>
                                    <td>{{ $inv->due_date?->format('M j, Y') ?? '—' }}</td>
                                    <td>
                                        @if($inv->status === 'paid')
                                            <span class="badge badge-rounded badge-success">Paid</span>
                                        @elseif($inv->status === 'partial')
                                            <span class="badge badge-rounded badge-warning">Partial</span>
                                        @elseif($inv->status === 'overdue')
                                            <span class="badge badge-rounded badge-danger">Overdue</span>
                                        @else
                                            <span class="badge badge-rounded badge-secondary">Pending</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.invoices.show', $inv) }}" class="btn btn-sm btn-outline-primary">View</a>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="10" class="text-center text-muted py-4">No invoices yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($invoices->hasPages())
                    <div class="d-flex justify-content-center mt-3">{{ $invoices->withQueryString()->links() }}</div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
