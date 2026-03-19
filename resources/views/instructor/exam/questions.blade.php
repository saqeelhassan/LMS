@extends('layouts.account', ['account' => 'instructor'])

@section('content')
<div class="col-xl-9">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <a href="{{ route('instructor.exams.index', $course) }}" class="text-body small d-block mb-1"><i class="bi bi-arrow-left me-1"></i>Back to exams</a>
            <h1 class="h3 mb-1">MCQ Questions: {{ $exam->title }}</h1>
            <p class="mb-0 text-body">Add or edit multiple-choice questions. Total marks from questions: <strong>{{ $exam->total_marks_from_questions }}</strong></p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border rounded-3 mb-4">
        <div class="card-header bg-light">
            <h5 class="mb-0">Add question</h5>
        </div>
        <div class="card-body p-4">
            <form method="post" action="{{ route('instructor.exams.questions.store', [$course, $exam]) }}">
                @csrf
                <div class="mb-3">
                    <label for="question_text" class="form-label">Question text *</label>
                    <textarea name="question_text" id="question_text" class="form-control @error('question_text') is-invalid @enderror" rows="2" required maxlength="2000">{{ old('question_text') }}</textarea>
                    @error('question_text')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="row g-2 mb-2">
                    <div class="col-md-6">
                        <label class="form-label small">Option A *</label>
                        <input type="text" name="option_a" class="form-control form-control-sm" value="{{ old('option_a') }}" required maxlength="500" placeholder="Option A">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small">Option B *</label>
                        <input type="text" name="option_b" class="form-control form-control-sm" value="{{ old('option_b') }}" required maxlength="500" placeholder="Option B">
                    </div>
                </div>
                <div class="row g-2 mb-2">
                    <div class="col-md-6">
                        <label class="form-label small">Option C (optional)</label>
                        <input type="text" name="option_c" class="form-control form-control-sm" value="{{ old('option_c') }}" maxlength="500" placeholder="Option C">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small">Option D (optional)</label>
                        <input type="text" name="option_d" class="form-control form-control-sm" value="{{ old('option_d') }}" maxlength="500" placeholder="Option D">
                    </div>
                </div>
                <div class="row g-2 mb-3 align-items-end">
                    <div class="col-md-6">
                        <label for="correct_option" class="form-label small">Correct option *</label>
                        <select name="correct_option" id="correct_option" class="form-select form-select-sm" required>
                            <option value="a" {{ old('correct_option') === 'a' ? 'selected' : '' }}>A</option>
                            <option value="b" {{ old('correct_option') === 'b' ? 'selected' : '' }}>B</option>
                            <option value="c" {{ old('correct_option') === 'c' ? 'selected' : '' }}>C</option>
                            <option value="d" {{ old('correct_option') === 'd' ? 'selected' : '' }}>D</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="marks" class="form-label small">Marks *</label>
                        <input type="number" name="marks" id="marks" class="form-control form-control-sm" value="{{ old('marks', 1) }}" min="1" max="100" required>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary btn-sm w-100">Add</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card border rounded-3">
        <div class="card-header bg-light d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Questions ({{ $exam->questions->count() }})</h5>
            <a href="{{ route('instructor.exams.submissions', [$course, $exam]) }}" class="btn btn-sm btn-outline-primary">View submissions</a>
        </div>
        <div class="card-body p-0">
            @forelse($exam->questions as $q)
            <div class="border-bottom p-3 d-flex justify-content-between align-items-start">
                <div class="flex-grow-1">
                    <span class="badge bg-secondary me-2">#{{ $loop->iteration }}</span>
                    <strong>{{ $q->question_text }}</strong>
                    <div class="mt-2 small text-muted">
                        A) {{ $q->option_a }} &nbsp; B) {{ $q->option_b }}
                        @if($q->option_c) &nbsp; C) {{ $q->option_c }} @endif
                        @if($q->option_d) &nbsp; D) {{ $q->option_d }} @endif
                        — Correct: <strong>{{ strtoupper($q->correct_option) }}</strong> ({{ $q->marks }} marks)
                    </div>
                </div>
                <div class="d-flex gap-1 flex-shrink-0">
                    <a href="{{ route('instructor.exams.questions.edit', [$course, $exam, $q]) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                    <form method="post" action="{{ route('instructor.exams.questions.destroy', [$course, $exam, $q]) }}" class="d-inline" onsubmit="return confirm('Remove this question?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                    </form>
                </div>
            </div>
            @empty
            <div class="p-4 text-center text-body">No questions yet. Add one above to make this an MCQ exam.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
