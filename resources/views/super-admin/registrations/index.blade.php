@extends('layouts.super-admin')

@section('content')
@php
    $pendingRegistrations = $pendingRegistrations ?? collect();
@endphp

<div class="row page-titles mx-0">
    <div class="col-sm-6 p-md-0">
        <div class="welcome-text">
            <h4>Pending Registrations</h4>
        </div>
    </div>
    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('super-admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0);">Pending Registrations</a></li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-xl-12 col-xxl-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Pending Registrations</h5>
                @if($pendingRegistrations->count() > 0)
                    <span class="badge badge-rounded badge-warning ms-2">{{ $pendingRegistrations->count() }} awaiting</span>
                @endif
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success mb-3 rounded">{{ session('success') }}</div>
                @endif
                <div class="table-responsive">
                    <table class="table header-border table-hover verticle-middle">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email / Role</th>
                                <th scope="col">Mobile</th>
                                <th scope="col">Registered</th>
                                <th scope="col">Status</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pendingRegistrations as $u)
                                <tr>
                                    <th>{{ $loop->iteration }}</th>
                                    <td>{{ $u->name }}</td>
                                    <td>{{ $u->email }} <span class="badge badge-light">{{ $u->role?->name ?? '—' }}</span></td>
                                    <td>{{ $u->userDetail?->mobile ?? '—' }}</td>
                                    <td>{{ $u->created_at?->format('M j, Y H:i') ?? '—' }}</td>
                                    <td><span class="badge badge-rounded badge-warning">Pending</span></td>
                                    <td>
                                        <form method="post" action="{{ route('super-admin.registrations.approve', $u) }}" class="d-inline">@csrf<button type="submit" class="btn btn-sm btn-success">Approve</button></form>
                                        <form method="post" action="{{ route('super-admin.registrations.reject', $u) }}" class="d-inline" onsubmit="return confirm('Reject this registration?');">@csrf<button type="submit" class="btn btn-sm btn-outline-danger">Reject</button></form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="7" class="text-center text-muted py-4">No pending registrations.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
