@extends('layouts.account', ['account' => 'instructor'])

@section('content')
<div class="col-xl-9">
    <div class="mb-4">
        <a href="{{ route('instructor.exams.submissions', [$course, $exam]) }}" class="text-body small d-block mb-1"><i class="bi bi-arrow-left me-1"></i>Back to submissions</a>
        <h1 class="h3 mb-1">Mark submission</h1>
        <p class="mb-0 text-body">{{ $submission->user->name ?? $submission->user->email }} — {{ $exam->title }}</p>
    </div>

    @if($errors->any())
        <div class="alert alert-danger mb-4">
            <ul class="mb-0 list-unstyled small">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <div class="card border rounded-3 mb-4">
        <div class="card-header bg-light">
            <h5 class="mb-0">Student answer</h5>
        </div>
        <div class="card-body">
            @if($exam->isMcq())
                <p class="mb-2"><strong>MCQ — Auto score: {{ $submission->marks_obtained ?? 0 }}/{{ $exam->total_marks_from_questions }}</strong></p>
                @if($submission->answer_content)
                    <div class="border rounded p-3 bg-light bg-opacity-50" style="white-space: pre-wrap;">{{ $submission->answer_content }}</div>
                @endif
            @elseif($submission->answer_content)
                <div class="border rounded p-3 bg-light bg-opacity-50" style="white-space: pre-wrap;">{{ $submission->answer_content }}</div>
            @else
                <p class="mb-0 text-body">No answer submitted yet.</p>
            @endif
        </div>
    </div>

    @php $maxMarks = $exam->isMcq() ? $exam->total_marks_from_questions : $exam->total_marks; @endphp
    <div class="card border rounded-3">
        <div class="card-body p-4">
            <form method="post" action="{{ route('instructor.exams.mark', [$course, $exam, $submission->user]) }}">
                @csrf
                <div class="mb-3">
                    <label for="marks_obtained" class="form-label">Marks obtained * (max {{ $maxMarks }})</label>
                    <input type="number" name="marks_obtained" id="marks_obtained" class="form-control" step="0.01" min="0" max="{{ $maxMarks }}" value="{{ old('marks_obtained', $submission->marks_obtained) }}" required>
                </div>
                <div class="mb-4">
                    <label for="feedback" class="form-label">Feedback (optional)</label>
                    <textarea name="feedback" id="feedback" class="form-control" rows="3" maxlength="2000">{{ old('feedback', $submission->feedback) }}</textarea>
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Save marks</button>
                    <a href="{{ route('instructor.exams.submissions', [$course, $exam]) }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
