@extends('layouts.admin')

@section('content')
<div class="row page-titles mx-0">
    <div class="col-sm-6 p-md-0">
        <div class="welcome-text">
            <h4>Student Ledger</h4>
        </div>
    </div>
    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex align-items-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.fee-management.index') }}">Fees Collection</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0);">Student Ledger</a></li>
        </ol>
        <a href="{{ route('admin.fee-management.index') }}" class="btn btn-sm btn-primary ms-3">Fees Collection</a>
    </div>
</div>

<div class="row">
    <div class="col-xl-12 col-xxl-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Student Ledger</h5>
            </div>
            <div class="card-body">
                <form method="get" action="{{ route('admin.fee-management.ledger') }}" class="row g-2 align-items-end mb-4">
                    <div class="col-md-4">
                        <label for="user_id" class="form-label small mb-0">Filter by student</label>
                        <select name="user_id" id="user_id" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="">— All students —</option>
                            @foreach($users ?? [] as $u)
                                <option value="{{ $u->id }}" {{ (request('user_id') == $u->id) ? 'selected' : '' }}>{{ $u->name }} ({{ $u->email }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('admin.fee-management.ledger') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table header-border table-hover verticle-middle">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Student / Course</th>
                                <th scope="col" class="text-end">Actual Fees</th>
                                <th scope="col" class="text-end">Arrears</th>
                                <th scope="col" class="text-end">Paid</th>
                                <th scope="col" class="text-end">Remaining</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($ledgers ?? [] as $item)
                                <tr>
                                    <th>{{ $loop->iteration }}</th>
                                    <td>
                                        <strong>{{ $item['enrollment']->user?->name ?? $item['enrollment']->user?->email ?? '—' }}</strong><br>
                                        <small class="text-muted">{{ $item['enrollment']->course?->name ?? '—' }} @if($item['enrollment']->batch)({{ $item['enrollment']->batch->name }})@endif</small>
                                    </td>
                                    <td class="text-end">{{ $currency }} {{ number_format($item['ledger']['actual_fees'], 0) }}</td>
                                    <td class="text-end {{ ($item['ledger']['arrears'] ?? 0) > 0 ? 'text-danger' : '' }}">{{ $currency }} {{ number_format($item['ledger']['arrears'] ?? 0, 0) }}</td>
                                    <td class="text-end text-success">{{ $currency }} {{ number_format($item['ledger']['paid_amount'] ?? 0, 0) }}</td>
                                    <td class="text-end fw-bold {{ ($item['ledger']['remaining'] ?? 0) > 0 ? 'text-warning' : '' }}">{{ $currency }} {{ number_format($item['ledger']['remaining'] ?? 0, 0) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="text-center text-muted py-4">No enrollments found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if(isset($enrollments) && $enrollments->hasPages())
                    <div class="d-flex justify-content-center mt-3">{{ $enrollments->withQueryString()->links() }}</div>
                @endif

                <div class="mt-3">
                    <a href="{{ route('admin.fee-management.index') }}" class="btn btn-outline-secondary btn-sm">← Back to Fees Collection</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
