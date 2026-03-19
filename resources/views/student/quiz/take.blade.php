@extends('layouts.student')

@section('content')
<div>
    <div class="mb-4">
        <a href="{{ route('student.quiz') }}" class="btn btn-sm btn-outline-secondary mb-2">&larr; Back to Quizzes</a>
        <h1 class="h3 mb-1">{{ $quiz->title }}</h1>
        <p class="mb-0">{{ $quiz->course->name ?? 'Course' }} &middot; Passing: {{ $quiz->passing_percent }}%</p>
    </div>

    <form action="{{ route('student.quiz.submit', ['quiz' => $quiz]) }}" method="POST" class="card border rounded-3">
        @csrf
        <div class="card-body">
            @foreach($quiz->questions as $index => $q)
            <div class="mb-4 pb-3 border-bottom">
                <p class="fw-semibold mb-2">{{ $index + 1 }}. {{ $q->question_text }}</p>
                @php $opts = is_array($q->options) ? $q->options : (array) $q->options; @endphp
                @foreach($opts as $i => $label)
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="answers[{{ $q->id }}]" id="q_{{ $q->id }}_{{ $i }}" value="{{ $i }}">
                    <label class="form-check-label" for="q_{{ $q->id }}_{{ $i }}">{{ $label }}</label>
                </div>
                @endforeach
            </div>
            @endforeach

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('student.quiz') }}" class="btn btn-outline-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Submit Quiz</button>
            </div>
        </div>
    </form>
</div>
@endsection
