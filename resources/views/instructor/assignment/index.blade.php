@extends('layouts.account', ['account' => 'instructor'])

@section('content')
<div class="col-xl-9">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <a href="{{ route('instructor.manage-course') }}" class="text-body small d-block mb-1"><i class="bi bi-arrow-left me-1"></i>Back to courses</a>
            <h1 class="h3 mb-1">Assignments: {{ $course->name }}</h1>
            <p class="mb-0 text-body">Create assignments, set deadlines, grade submissions.</p>
        </div>
        <a href="{{ route('instructor.assignments.create', $course) }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>Create assignment</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('warning'))
        <div class="alert alert-warning alert-dismissible fade show">{{ session('warning') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(isset($batches) && $batches->isNotEmpty())
    <form method="get" class="mb-3 d-flex align-items-center gap-2 flex-wrap">
        <label class="mb-0">Filter by batch:</label>
        <select name="batch_id" class="form-select form-select-sm w-auto" onchange="this.form.submit()">
            <option value="">All batches</option>
            @foreach($batches as $b)
                <option value="{{ $b->id }}" {{ request('batch_id') == $b->id ? 'selected' : '' }}>{{ $b->name }}</option>
            @endforeach
        </select>
    </form>
    @endif

    <div class="card border rounded-3">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Assignment</th>
                            <th>Batch</th>
                            <th>Total marks</th>
                            <th>Deadline</th>
                            <th>Submissions</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($assignments as $a)
                        <tr>
                            <td>
                                <h6 class="mb-0">{{ $a->title }}</h6>
                                @if($a->description)<small class="text-body">{{ Str::limit($a->description, 60) }}</small>@endif
                            </td>
                            <td>{{ $a->batch?->name ?? '—' }}</td>
                            <td>{{ $a->total_marks }}</td>
                            <td>{{ $a->due_date?->format('M d, Y H:i') ?? '—' }}</td>
                            <td>{{ $a->submissions_count }}</td>
                            <td>
                                <a href="{{ route('instructor.assignments.submissions', [$course, $a]) }}" class="btn btn-sm btn-outline-primary">Grade submissions</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-body">No assignments yet. <a href="{{ route('instructor.assignments.create', $course) }}">Create one</a>.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($assignments->hasPages())
                <div class="d-flex justify-content-center mt-3">{{ $assignments->links() }}</div>
            @endif
        </div>
    </div>
</div>
@endsection
