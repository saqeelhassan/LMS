@extends('layouts.admin')

@section('content')
<div class="row page-titles mx-0">
    <div class="col-sm-6 p-md-0">
        <div class="welcome-text">
            <h4>Batches</h4>
        </div>
    </div>
    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex align-items-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0);">Batches</a></li>
        </ol>
        <a href="{{ route('admin.batches.create') }}" class="btn btn-sm btn-primary ms-3">Add Batch</a>
    </div>
</div>

<div class="row">
    <div class="col-xl-12 col-xxl-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Batches</h5>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success mb-3 rounded">{{ session('success') }}</div>
                @endif

                <form method="get" action="{{ route('admin.batches.index') }}" class="row g-2 align-items-end mb-4">
                    <div class="col-md-4">
                        <label class="form-label small mb-0">Course</label>
                        <select name="course" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="">All Courses</option>
                            @foreach($courses as $c)
                                <option value="{{ $c->id }}" {{ request('course') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                            @endforeach
                        </select>
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
                                <th scope="col">Schedule</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($batches as $batch)
                                <tr>
                                    <th>{{ $loop->iteration + ($batches->currentPage() - 1) * $batches->perPage() }}</th>
                                    <td>{{ $batch->name }}</td>
                                    <td>{{ $batch->course?->name ?? '—' }}</td>
                                    <td>{{ $batch->instructor?->name ?? '—' }}</td>
                                    <td>{{ $batch->branch?->name ?? '—' }}</td>
                                    <td>{{ $batch->schedule_note ?? '—' }}</td>
                                    <td>
                                        <a href="{{ route('admin.batches.edit', $batch) }}" class="btn btn-sm btn-outline-primary me-1">Edit</a>
                                        <a href="{{ route('admin.batches.timetable', $batch) }}" class="btn btn-sm btn-outline-secondary me-1">Timetable</a>
                                        <form method="post" action="{{ route('admin.batches.destroy', $batch) }}" class="d-inline" onsubmit="return confirm('Remove this batch?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="7" class="text-center text-muted py-4">No batches yet.</td></tr>
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
