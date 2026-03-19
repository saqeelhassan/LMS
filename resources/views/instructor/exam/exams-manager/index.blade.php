@extends('layouts.super-admin')

@section('content')
@if(session('success'))
<div class="row mb-4">
    <div class="col-12">
        <div class="alert alert-success border-0 d-flex align-items-center justify-content-between flex-wrap gap-3 mb-0 py-3">
            <div class="min-w-0 flex-grow-1">
                <strong><i class="fas fa-check-circle me-2"></i>Success</strong>
                <span class="ms-2">{{ session('success') }}</span>
            </div>
        </div>
    </div>
</div>
@endif

@if(session('warning'))
<div class="row mb-4">
    <div class="col-12">
        <div class="alert alert-warning border-0 d-flex align-items-center justify-content-between flex-wrap gap-3 mb-0 py-3">
            <div class="min-w-0 flex-grow-1">
                <strong><i class="fas fa-exclamation-triangle me-2"></i>Warning</strong>
                <span class="ms-2">{{ session('warning') }}</span>
            </div>
        </div>
    </div>
</div>
@endif

<div class="row mb-4">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="card-title mb-0">Exams Manager</h4>
                    <p class="text-muted mb-0">Create and manage exams across all your courses</p>
                </div>
                <a href="{{ route('instructor.exams-manager.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Create Exam
                </a>
            </div>
        </div>
    </div>
</div>

@if($courses->isNotEmpty())
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form method="get" class="d-flex align-items-center gap-3">
                    <label class="mb-0 fw-bold">Filter by course:</label>
                    <select name="course_id" class="form-select w-auto" onchange="this.form.submit()">
                        <option value="">All courses</option>
                        @foreach($courses as $c)
                            <option value="{{ $c->id }}" {{ request('course_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                        @endforeach
                    </select>
                </form>
            </div>
        </div>
    </div>
</div>
@endif

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Your Exams</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table header-border table-hover verticle-middle">
                        <thead>
                            <tr>
                                <th scope="col">Exam</th>
                                <th scope="col">Course</th>
                                <th scope="col">Batch</th>
                                <th scope="col">Total Marks</th>
                                <th scope="col">Duration</th>
                                <th scope="col">Status</th>
                                <th scope="col">Submissions</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($exams as $exam)
                            <tr>
                                <td>
                                    <h6 class="mb-0">{{ $exam->title }}</h6>
                                </td>
                                <td>{{ $exam->course?->name ?? '—' }}</td>
                                <td>{{ $exam->batch?->name ?? 'All batches' }}</td>
                                <td>{{ $exam->isMcq() ? $exam->total_marks_from_questions : $exam->total_marks }}</td>
                                <td>{{ $exam->duration_minutes ? $exam->duration_minutes . ' min' : '—' }}</td>
                                <td><span class="badge badge-light">{{ $exam->status ?? 'draft' }}</span></td>
                                <td>{{ $exam->submissions_count }}</td>
                                <td>
                                    <a href="{{ route('instructor.exams.questions.index', [$exam->course, $exam]) }}" class="btn btn-sm btn-primary me-1">MCQ</a>
                                    <a href="{{ route('instructor.exams.submissions', [$exam->course, $exam]) }}" class="btn btn-sm btn-success">View & Mark</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    No exams yet. <a href="{{ route('instructor.exams-manager.create') }}">Create your first exam</a>.
                                </td>
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
</div>
@endsection
