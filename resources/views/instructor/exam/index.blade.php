@extends('layouts.account', ['account' => 'instructor'])

@section('content')
<div class="col-xl-9">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <a href="{{ route('instructor.manage-course') }}" class="text-body small d-block mb-1"><i class="bi bi-arrow-left me-1"></i>Back to courses</a>
            <h1 class="h3 mb-1">Exams: {{ $course->name }}</h1>
            <p class="mb-0 text-body">Create offline exams and mark student submissions.</p>
        </div>
        <a href="{{ route('instructor.exams.create', $course) }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>Add exam</a>
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
                            <th>Exam</th>
                            <th>Batch</th>
                            <th>Total marks</th>
                            <th>Start / Due</th>
                            <th>Status</th>
                            <th>Submissions</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($exams as $exam)
                        <tr>
                            <td>
                                <h6 class="mb-0">{{ $exam->title }}</h6>
                                @if($exam->description)<small class="text-body">{{ Str::limit($exam->description, 60) }}</small>@endif
                            </td>
                            <td>{{ $exam->batch?->name ?? '—' }}</td>
                            <td>{{ $exam->isMcq() ? $exam->total_marks_from_questions : $exam->total_marks }}</td>
                            <td>{{ $exam->start_datetime?->format('M d, H:i') ?? $exam->due_date?->format('M d, Y') ?? '—' }}</td>
                            <td><span class="badge bg-secondary">{{ $exam->status ?? 'draft' }}</span></td>
                            <td>{{ $exam->submissions_count }}</td>
                            <td>
                                <a href="{{ route('instructor.exams.questions.index', [$course, $exam]) }}" class="btn btn-sm btn-outline-secondary me-1">MCQ</a>
                                <a href="{{ route('instructor.exams.submissions', [$course, $exam]) }}" class="btn btn-sm btn-outline-primary">View & mark</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-body">No exams yet. <a href="{{ route('instructor.exams.create', $course) }}">Create an exam</a>.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($exams->hasPages())
                <div class="d-flex justify-content-center mt-3">{{ $exams->links() }}</div>
            @endif
        </div>
    </div>
</div>
@endsection
