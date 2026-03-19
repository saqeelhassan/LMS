@extends('layouts.admin')

@section('content')
<div class="row page-titles mx-0">
    <div class="col-sm-6 p-md-0">
        <div class="welcome-text">
            <h4>Batch Management</h4>
        </div>
    </div>
    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.batches.index') }}">Batches</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0);">Batch Management</a></li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-xl-12 col-xxl-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Manage Batches & Instructors</h5>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success mb-3 rounded">{{ session('success') }}</div>
                @endif

                <form method="get" action="{{ route('admin.batch-management.index') }}" class="row g-2 align-items-end mb-4">
                    <div class="col-md-4">
                        <label class="form-label small mb-0">Course</label>
                        <select name="course" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="">All courses</option>
                            @foreach($courses as $c)
                                <option value="{{ $c->id }}" {{ request('course') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small mb-0">Status</label>
                        <select name="active" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="">All batches</option>
                            <option value="1" {{ request('active') === '1' ? 'selected' : '' }}>Active only</option>
                            <option value="0" {{ request('active') === '0' ? 'selected' : '' }}>Inactive only</option>
                        </select>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table header-border table-hover verticle-middle">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Batch ID</th>
                                <th scope="col">Course Name</th>
                                <th scope="col">Current Instructor</th>
                                <th scope="col">Schedule</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($batches as $batch)
                                <tr>
                                    <th>{{ $loop->iteration + ($batches->currentPage() - 1) * $batches->perPage() }}</th>
                                    <td><strong>B-{{ $batch->id }}</strong></td>
                                    <td>{{ $batch->course?->name ?? '—' }}</td>
                                    <td>{{ $batch->instructor?->name ?? '— Unassigned —' }}</td>
                                    <td>{{ $batch->schedule_display }}</td>
                                    <td>
                                        @if($batch->instructor_id)
                                            <button type="button" class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="modal" data-bs-target="#modalSwap{{ $batch->id }}">Swap</button>
                                            <form method="post" action="{{ route('admin.batch-management.remove', $batch) }}" class="d-inline" onsubmit="return confirm('Remove this instructor from the batch? The batch will become vacant.');">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-danger">Remove</button>
                                            </form>
                                        @else
                                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalAssign{{ $batch->id }}">Assign</button>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="text-center text-muted py-4">No batches found.</td></tr>
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

@foreach($batches as $batch)
    @if(!$batch->instructor_id)
    <div class="modal fade" id="modalAssign{{ $batch->id }}" tabindex="-1" aria-labelledby="modalAssignLabel{{ $batch->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="{{ route('admin.batch-management.assign', $batch) }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalAssignLabel{{ $batch->id }}">Assign instructor — B-{{ $batch->id }} ({{ $batch->course?->name ?? 'Batch' }})</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <label for="assign_instructor_{{ $batch->id }}" class="form-label">Instructor</label>
                        <select name="instructor_id" id="assign_instructor_{{ $batch->id }}" class="form-select form-control" required>
                            <option value="">Select instructor</option>
                            @foreach($instructors as $inst)
                                <option value="{{ $inst->id }}">{{ $inst->name }} ({{ $inst->email }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Assign</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @else
    <div class="modal fade" id="modalSwap{{ $batch->id }}" tabindex="-1" aria-labelledby="modalSwapLabel{{ $batch->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="{{ route('admin.batch-management.swap', $batch) }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalSwapLabel{{ $batch->id }}">Swap instructor — B-{{ $batch->id }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="mb-2">Current: <strong>{{ $batch->instructor?->name }}</strong>. Select new instructor (current will lose access immediately).</p>
                        <label for="swap_instructor_{{ $batch->id }}" class="form-label">New instructor</label>
                        <select name="instructor_id" id="swap_instructor_{{ $batch->id }}" class="form-select form-control" required>
                            <option value="">Select instructor</option>
                            @foreach($instructors as $inst)
                                @if($inst->id != $batch->instructor_id)
                                    <option value="{{ $inst->id }}">{{ $inst->name }} ({{ $inst->email }})</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Swap</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
@endforeach
@endsection
