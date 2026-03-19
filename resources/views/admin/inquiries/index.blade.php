@extends('layouts.admin')

@section('content')
<div class="row page-titles mx-0">
    <div class="col-sm-6 p-md-0">
        <div class="welcome-text">
            <h4>Inquiries</h4>
        </div>
    </div>
    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex align-items-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0);">Inquiries</a></li>
        </ol>
        <a href="{{ route('admin.inquiries.create') }}" class="btn btn-sm btn-primary ms-3">Add inquiry</a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success mb-3 rounded">{{ session('success') }}</div>
@endif

<div class="row">
    <div class="col-xl-12 col-xxl-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Inquiry list</h5>
            </div>
            <div class="card-body">
                <form method="get" action="{{ route('admin.inquiries.index') }}" class="row g-2 align-items-end mb-4">
                    <div class="col-md-4">
                        <label for="status" class="form-label small mb-0">Filter by status</label>
                        <select name="status" id="status" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="">All statuses</option>
                            <option value="new" {{ request('status') === 'new' ? 'selected' : '' }}>New</option>
                            <option value="contacted" {{ request('status') === 'contacted' ? 'selected' : '' }}>Contacted</option>
                            <option value="converted" {{ request('status') === 'converted' ? 'selected' : '' }}>Converted</option>
                            <option value="lost" {{ request('status') === 'lost' ? 'selected' : '' }}>Lost</option>
                        </select>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('admin.inquiries.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table header-border table-hover verticle-middle">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Email</th>
                                <th scope="col">Course interest</th>
                                <th scope="col">Status</th>
                                <th scope="col">Assigned to</th>
                                <th scope="col" class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($inquiries as $inq)
                                <tr>
                                    <th>{{ $loop->iteration }}</th>
                                    <td>{{ $inq->name }}</td>
                                    <td>{{ $inq->phone ?? '—' }}</td>
                                    <td>{{ $inq->email ?? '—' }}</td>
                                    <td>{{ $inq->course_interest ?? '—' }}</td>
                                    <td>
                                        @if($inq->status === 'converted')
                                            <span class="badge badge-rounded badge-success">Converted</span>
                                        @elseif($inq->status === 'contacted')
                                            <span class="badge badge-rounded badge-info">Contacted</span>
                                        @elseif($inq->status === 'lost')
                                            <span class="badge badge-rounded badge-secondary">Lost</span>
                                        @else
                                            <span class="badge badge-rounded badge-warning">New</span>
                                        @endif
                                    </td>
                                    <td>{{ $inq->assignee?->name ?? '—' }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.inquiries.edit', $inq) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                        @if($inq->status !== 'converted')
                                            <a href="{{ route('admin.inquiries.convert', $inq) }}" class="btn btn-sm btn-outline-success">Convert</a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="8" class="text-center text-muted py-4">No inquiries yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($inquiries->hasPages())
                    <div class="d-flex justify-content-center mt-3">{{ $inquiries->withQueryString()->links() }}</div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
