@extends('layouts.account', ['account' => 'instructor'])

@section('content')
<div class="col-xl-9">
    <div class="mb-4">
        <a href="{{ route('instructor.assignments.index', $course) }}" class="text-body small d-block mb-1">Back to assignments</a>
        <h1 class="h3 mb-1">Submissions: {{ $assignment->title }}</h1>
        <p class="mb-0 text-body">Grade student uploads.</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border rounded-3">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Submitted</th>
                            <th>File</th>
                            <th>Marks</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $s)
                        <tr>
                            <td>
                                <h6 class="mb-0">{{ $s->user ? $s->user->name : ($s->user ? $s->user->email : '-') }}</h6>
                                <small class="text-body">{{ $s->user ? $s->user->email : '-' }}</small>
                            </td>
                            <td>
                                @if($s->submission)
                                    {{ $s->submission->submitted_at ? $s->submission->submitted_at->format('M d, Y H:i') : '-' }}
                                @else
                                    <span class="text-muted">Not submitted</span>
                                @endif
                            </td>
                            <td>
                                @if($s->submission && $s->submission->file_path)
                                    <a href="{{ asset('storage/' . $s->submission->file_path) }}" target="_blank">{{ $s->submission->file_name ?? 'Download' }}</a>
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if($s->submission && $s->submission->status === 'graded')
                                    <strong>{{ $s->submission->marks_obtained }}/{{ $assignment->total_marks }}</strong>
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if($s->submission && $s->submission->file_path)
                                    <a href="{{ route('instructor.assignments.grade-form', [$course, $assignment, $s->user]) }}" class="btn btn-sm btn-outline-primary">{{ $s->submission->status === 'graded' ? 'Edit' : 'Grade' }}</a>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
