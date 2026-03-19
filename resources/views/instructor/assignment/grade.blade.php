@extends('layouts.account', ['account' => 'instructor'])

@section('content')
<div class="col-xl-9">
    <div class="mb-4">
        <a href="{{ route('instructor.assignments.submissions', [$course, $assignment]) }}" class="text-body small d-block mb-1"><i class="bi bi-arrow-left me-1"></i>Back to submissions</a>
        <h1 class="h3 mb-1">Grade: {{ $submission->user?->name }} — {{ $assignment->title }}</h1>
    </div>

    <div class="card border rounded-3 mb-4">
        <div class="card-body p-4">
            <p class="mb-2"><strong>Student:</strong> {{ $submission->user?->name }} ({{ $submission->user?->email }})</p>
            <p class="mb-2"><strong>Submitted:</strong> {{ $submission->submitted_at?->format('M d, Y H:i') }}</p>
            <p class="mb-0"><strong>File:</strong> <a href="{{ asset('storage/' . $submission->file_path) }}" target="_blank">{{ $submission->file_name ?? 'Download' }}</a></p>
        </div>
    </div>

    <div class="card border rounded-3">
        <div class="card-body p-4">
            @if($errors->any())
                <div class="alert alert-danger mb-4"><ul class="mb-0 list-unstyled small">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
            @endif
            <form method="post" action="{{ route('instructor.assignments.grade', [$course, $assignment, $submission->user]) }}">
                @csrf
                <div class="mb-3">
                    <label for="marks_obtained" class="form-label">Marks (out of {{ $assignment->total_marks }}) *</label>
                    <input type="number" name="marks_obtained" id="marks_obtained" class="form-control" value="{{ old('marks_obtained', $submission->marks_obtained) }}" min="0" max="{{ $assignment->total_marks }}" step="0.5" required>
                </div>
                <div class="mb-4">
                    <label for="feedback" class="form-label">Feedback</label>
                    <textarea name="feedback" id="feedback" class="form-control" rows="4" maxlength="2000">{{ old('feedback', $submission->feedback) }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary">Save grade</button>
            </form>
        </div>
    </div>
</div>
@endsection
