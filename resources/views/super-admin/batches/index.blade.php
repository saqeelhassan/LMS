@extends('layouts.super-admin')

@section('content')
<div class="row page-titles mx-0">
    <div class="col-sm-6 p-md-0">
        <div class="welcome-text">
            <h4>Batch Management</h4>
        </div>
    </div>
    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex align-items-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('super-admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0);">Batches</a></li>
        </ol>
        <a href="{{ route('super-admin.batches.create') }}" class="btn btn-sm btn-primary ms-3">Add Batch</a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success mb-3 rounded">{{ session('success') }}</div>
@endif

<div class="row">
    <div class="col-xl-12 col-xxl-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Batches</h5>
            </div>
            <div class="card-body">
                <p class="text-body mb-4">Add, edit or remove batches for courses.</p>
                <form method="get" action="{{ route('super-admin.batches.index') }}" class="row g-2 align-items-end mb-4">
                    <div class="col-md-4">
                        <label for="course" class="form-label small mb-0">Filter by course</label>
                        <select name="course" id="course" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="">All courses</option>
                            @foreach($courses as $c)
                                <option value="{{ $c->id }}" {{ request('course') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('super-admin.batches.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table header-border table-hover verticle-middle">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Batch</th>
                                <th scope="col">Course</th>
                                <th scope="col">Instructor</th>
                                <th scope="col">Branch</th>
                                <th scope="col">Status</th>
                                <th scope="col" class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($batches as $batch)
                                <tr>
                                    <th>{{ $loop->iteration }}</th>
                                    <td>{{ $batch->name }}</td>
                                    <td>{{ $batch->course?->name ?? '—' }}</td>
                                    <td>{{ $batch->instructor?->name ?? '—' }}</td>
                                    <td>{{ $batch->branch?->name ?? '—' }}</td>
                                    <td>
                                        @if($batch->is_active)
                                            <span class="badge badge-rounded badge-success">Active</span>
                                        @else
                                            <span class="badge badge-rounded badge-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('super-admin.batches.edit', $batch) }}" class="btn btn-sm btn-outline-primary me-1">Edit</a>
                                        <form method="post" action="{{ route('super-admin.batches.destroy', $batch) }}" class="d-inline" onsubmit="return confirm('Remove this batch?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="7" class="text-center text-muted py-4">No batches yet. <a href="{{ route('super-admin.batches.create') }}">Add one</a>.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($batches->hasPages())
                    <div class="d-flex justify-content-center mt-3">{{ $batches->withQueryString()->links() }}</div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
