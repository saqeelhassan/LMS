@extends('layouts.admin')

@section('content')
@php
    $currency = \App\Models\Setting::get('currency', 'PKR');
@endphp

<div class="row page-titles mx-0">
    <div class="col-sm-6 p-md-0">
        <div class="welcome-text">
            <h4>Defaulter List</h4>
        </div>
    </div>
    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex align-items-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.fee-management.index') }}">Fees Collection</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0);">Defaulter List</a></li>
        </ol>
        <a href="{{ route('admin.fee-management.index') }}" class="btn btn-sm btn-primary ms-3">Fees Collection</a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success mb-3 rounded">{{ session('success') }}</div>
@endif

<div class="row">
    <div class="col-xl-12 col-xxl-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Defaulters</h5>
            </div>
            <div class="card-body">
                <p class="text-body mb-4">Students with unpaid dues. You can disable their LMS access.</p>
                <div class="table-responsive">
                    <table class="table header-border table-hover verticle-middle">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Student</th>
                                <th scope="col">Email</th>
                                <th scope="col">Course</th>
                                <th scope="col" class="text-end">Total Due</th>
                                <th scope="col">LMS access</th>
                                <th scope="col" class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($defaulters as $inv)
                                @php $user = $inv->user; @endphp
                                <tr>
                                    <th>{{ $loop->iteration }}</th>
                                    <td>{{ $user?->name ?? '—' }}</td>
                                    <td>{{ $user?->email ?? '—' }}</td>
                                    <td>{{ $inv->enrollment?->course?->name ?? '—' }}</td>
                                    <td class="text-end text-danger fw-bold">{{ $currency }} {{ number_format($inv->balance, 0) }}</td>
                                    <td>
                                        @if($user?->is_active)
                                            <span class="badge badge-rounded badge-success">Active</span>
                                        @else
                                            <span class="badge badge-rounded badge-secondary">Disabled</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.invoices.show', $inv) }}" class="btn btn-sm btn-outline-primary">View invoice</a>
                                        @if($user?->is_active)
                                            <form method="post" action="{{ route('admin.defaulters.disable', $user) }}" class="d-inline" onsubmit="return confirm('Disable LMS access for this student?');">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-danger">Disable access</button>
                                            </form>
                                        @else
                                            <form method="post" action="{{ route('admin.defaulters.enable', $user) }}" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-success">Enable access</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="7" class="text-center text-muted py-4">No defaulters.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
