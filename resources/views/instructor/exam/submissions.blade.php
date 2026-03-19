@extends('layouts.account', ['account' => 'instructor'])

@section('content')
<div class="col-xl-9">
    <div class="mb-4">
        <a href="{{ route('instructor.exams.index', $course) }}" class="text-body small d-block mb-1"><i class="bi bi-arrow-left me-1"></i>Back to exams</a>
        <h1 class="h3 mb-1">Submissions: {{ $exam->title }}</h1>
        <p class="mb-0 text-body">Mark student submissions for this offline exam.</p>
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
                            <th>Status</th>
                            <th>Submitted</th>
                            <th>Marks</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($students as $item)
                        @php $sub = $item->submission; $u = $item->user; @endphp
                        <tr>
                            <td>
                                <div>
                                    <h6 class="mb-0">{{ $u->name ?? $u->email }}</h6>
                                    <small class="text-body">{{ $u->email }}</small>
                                </div>
                            </td>
                            <td>
                                @if($sub && $sub->isResultFinalized())
                                    <span class="badge bg-success">Approved</span>
                                @elseif($sub && $sub->status === 'marked')
                                    <span class="badge bg-warning">Marked (awaiting approval)</span>
                                @elseif($sub && $sub->status === 'submitted' && $sub->marks_obtained !== null)
                                    <span class="badge bg-info">MCQ graded (awaiting approval)</span>
                                @elseif($sub && $sub->status === 'submitted')
                                    <span class="badge bg-info">Pending mark</span>
                                @else
                                    <span class="badge bg-secondary">Not submitted</span>
                                @endif
                            </td>
                            <td>{{ $sub?->submitted_at?->format('M d, Y H:i') ?? '—' }}</td>
                            <td>
                                @if($sub && $sub->marks_obtained !== null)
                                    <strong>{{ $sub->marks_obtained }}/{{ $exam->isMcq() ? $exam->total_marks_from_questions : $exam->total_marks }}</strong>
                                @else
                                    —
                                @endif
                            </td>
                            <td>
                                @if($sub && $sub->marks_obtained !== null && !$sub->isResultFinalized())
                                    <form method="post" action="{{ route('instructor.exams.approve-result', [$course, $exam, $u]) }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success">Approve</button>
                                    </form>
                                @endif
                                <a href="{{ route('instructor.exams.mark-form', [$course, $exam, $u]) }}" class="btn btn-sm btn-outline-primary">{{ ($sub && $sub->status === 'marked') ? 'View / Edit' : 'Mark' }}</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-body">No enrolled students in this course.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
