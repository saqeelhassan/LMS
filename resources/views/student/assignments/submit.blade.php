@extends('layouts.student')

@section('content')
<div>
    <div class="mb-4">
        <a href="{{ route('student.assignments.index') }}" class="small d-block mb-1">Back to assignments</a>
        <h1 class="h3 mb-1">{{ $assignment->title }}</h1>
        <p class="mb-0">{{ $assignment->course->name ?? '-' }} — Total: {{ $assignment->total_marks }} marks</p>
    </div>

    @if($assignment->description)
        <div class="card border rounded-3 mb-4">
            <div class="card-header bg-light">
                <h5 class="mb-0">Description</h5>
            </div>
            <div class="card-body">
                <div style="white-space: pre-wrap;">{{ $assignment->description }}</div>
                @if($assignment->problem_file_path)
                    <p class="mt-3 mb-0"><a href="{{ asset('storage/' . $assignment->problem_file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">Download problem statement</a></p>
                @endif
            </div>
        </div>
    @endif

    @if($submission && $submission->status === 'graded')
        <div class="card border rounded-3 mb-4 border-success">
            <div class="card-header bg-success bg-opacity-10">
                <h5 class="mb-0 text-success">Result: {{ $submission->marks_obtained }}/{{ $assignment->total_marks }}</h5>
            </div>
            <div class="card-body">
                @if($submission->feedback)
                    <p class="mb-0"><strong>Feedback:</strong><br>{{ $submission->feedback }}</p>
                @endif
                <p class="mb-0 mt-2 small">Graded on {{ $submission->marked_at ? $submission->marked_at->format('M d, Y H:i') : '-' }}</p>
            </div>
        </div>
    @else
    <div class="card border rounded-3">
        <div class="card-body p-4">
            @if($submission && $submission->file_path)
                <p class="mb-3"><strong>Your submitted file:</strong> <a href="{{ asset('storage/' . $submission->file_path) }}" target="_blank">{{ $submission->file_name ?? 'Download' }}</a></p>
            @endif
            <form method="post" action="{{ route('student.assignments.submit', $assignment) }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="file" class="form-label">{{ $submission && $submission->file_path ? 'Replace file (resubmit)' : 'Upload file *' }}</label>
                    <input type="file" name="file" id="file" class="form-control @error('file') is-invalid @enderror" accept=".pdf,.doc,.docx,.txt,.zip,.py,.js,.html,.css,.java" {{ !$submission || !$submission->file_path ? 'required' : '' }}>
                    @error('file')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <small class="text-muted">PDF, DOC, TXT, ZIP, or code files. Max 20MB.</small>
                </div>
                <div class="mb-4">
                    <label for="notes" class="form-label">Notes (optional)</label>
                    <textarea name="notes" id="notes" class="form-control" rows="2" maxlength="1000">{{ old('notes', $submission?->notes ?? '') }}</textarea>
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">{{ $submission && $submission->file_path ? 'Resubmit' : 'Submit' }}</button>
                    <a href="{{ route('student.assignments.index') }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>
@endsection
