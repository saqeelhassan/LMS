@extends('layouts.super-admin')

@section('content')
@php
    $currency = \App\Models\Setting::get('currency', 'PKR');
@endphp

<div class="row page-titles mx-0">
    <div class="col-sm-6 p-md-0">
        <div class="welcome-text">
            <h4>Expenses</h4>
        </div>
    </div>
    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex align-items-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('super-admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0);">Expenses</a></li>
        </ol>
        <a href="{{ route('super-admin.expenses.create') }}" class="btn btn-sm btn-primary ms-3">Record Expense</a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success mb-3 rounded">{{ session('success') }}</div>
@endif

<div class="row">
    <div class="col-xl-12 col-xxl-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Expenses</h5>
            </div>
            <div class="card-body">
                <p class="text-body mb-4">Salaries, lab maintenance, server costs.</p>
                <form method="get" action="{{ route('super-admin.expenses.index') }}" class="row g-2 align-items-end mb-4">
                    <div class="col-md-3">
                        <label for="type" class="form-label small mb-0">Type</label>
                        <select name="type" id="type" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="">All types</option>
                            <option value="salary" {{ request('type') === 'salary' ? 'selected' : '' }}>Salary</option>
                            <option value="lab_maintenance" {{ request('type') === 'lab_maintenance' ? 'selected' : '' }}>Lab Maintenance</option>
                            <option value="server" {{ request('type') === 'server' ? 'selected' : '' }}>Server</option>
                            <option value="other" {{ request('type') === 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="branch" class="form-label small mb-0">Branch</label>
                        <select name="branch" id="branch" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="">All branches</option>
                            @foreach($branches as $b)
                                <option value="{{ $b->id }}" {{ request('branch') == $b->id ? 'selected' : '' }}>{{ $b->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('super-admin.expenses.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table header-border table-hover verticle-middle">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Date</th>
                                <th scope="col">Type</th>
                                <th scope="col">Name</th>
                                <th scope="col">Description</th>
                                <th scope="col">Branch</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Recorded By</th>
                                @if(auth()->user()->role?->name === 'SuperAdmin')
                                <th scope="col" class="text-end">Actions</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($expenses as $e)
                            <tr>
                                <th>{{ $loop->iteration }}</th>
                                <td>{{ $e->expense_date->format('M d, Y') }}</td>
                                <td><span class="badge badge-rounded badge-secondary">{{ str_replace('_', ' ', ucfirst($e->type)) }}</span></td>
                                <td>{{ $e->payee_name ?? '—' }}</td>
                                <td>{{ Str::limit($e->description ?? '—', 40) }}</td>
                                <td>{{ $e->branch?->name ?? '—' }}</td>
                                <td><strong>{{ number_format($e->amount) }} {{ $currency }}</strong></td>
                                <td>{{ $e->recorder?->name ?? '—' }}</td>
                                @if(auth()->user()->role?->name === 'SuperAdmin')
                                <td class="text-end">
                                    <a href="{{ route('super-admin.expenses.edit', $e) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                    <form method="post" action="{{ route('super-admin.expenses.destroy', $e) }}" class="d-inline" onsubmit="return confirm('Delete this expense?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                    </form>
                                </td>
                                @endif
                            </tr>
                            @empty
                            <tr><td colspan="{{ auth()->user()->role?->name === 'SuperAdmin' ? 9 : 8 }}" class="text-center text-muted py-4">No expenses recorded. <a href="{{ route('super-admin.expenses.create') }}">Record one</a>.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($expenses->hasPages())
                    <div class="d-flex justify-content-center mt-3">{{ $expenses->withQueryString()->links() }}</div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
