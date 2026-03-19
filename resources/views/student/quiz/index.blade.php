@extends('layouts.student')

@section('content')
<div>
    <div class="mb-4">
        <h1 class="h3 mb-1">Take Quiz</h1>
        <p class="mb-0">Online MCQs for your enrolled courses.</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('info'))
        <div class="alert alert-info alert-dismissible fade show">{{ session('info') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border rounded-3">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Quiz</th>
                            <th>Course</th>
                            <th>Passing %</th>
                            <th>Your attempt</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($quizzes as $quiz)
                        @php $attempt = $attemptsMap[$quiz->id] ?? null; @endphp
                        <tr>
                            <td>
                                <h6 class="mb-0">{{ $quiz->title }}</h6>
                                @if($quiz->time_minutes)
                                    <small>{{ $quiz->time_minutes }} min</small>
                                @endif
                            </td>
                            <td>{{ $quiz->course->name ?? '—' }}</td>
                            <td>{{ $quiz->passing_percent }}%</td>
                            <td>
                                @if($attempt)
                                    <span class="badge {{ $attempt->passed ? 'bg-success' : 'bg-warning' }}">
                                        {{ $attempt->score }}/{{ $attempt->total_questions }} ({{ $attempt->percent }}%)
                                    </span>
                                @else
                                    <span>—</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('student.quiz.start', ['quiz' => $quiz]) }}" class="btn btn-sm {{ $attempt ? 'btn-outline-secondary' : 'btn-primary' }}">
                                    {{ $attempt ? 'Retake' : 'Take Quiz' }}
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">No quizzes yet for your enrolled courses.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($quizzes->hasPages())
                <div class="d-flex justify-content-center mt-3">{{ $quizzes->links() }}</div>
            @endif
        </div>
    </div>
</div>
@endsection
