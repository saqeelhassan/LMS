@extends('layouts.account', ['account' => 'instructor'])

@section('content')
<div class="col-xl-9">
    <div class="mb-4">
        <a href="{{ route('instructor.exams.questions.index', [$course, $exam]) }}" class="text-body small d-block mb-1"><i class="bi bi-arrow-left me-1"></i>Back to questions</a>
        <h1 class="h3 mb-1">Edit question</h1>
        <p class="mb-0 text-body">{{ $exam->title }}</p>
    </div>

    <div class="card border rounded-3">
        <div class="card-body p-4">
            @if($errors->any())
                <div class="alert alert-danger mb-4"><ul class="mb-0 list-unstyled small">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
            @endif
            <form method="post" action="{{ route('instructor.exams.questions.update', [$course, $exam, $question]) }}">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="question_text" class="form-label">Question text *</label>
                    <textarea name="question_text" id="question_text" class="form-control" rows="2" required maxlength="2000">{{ old('question_text', $question->question_text) }}</textarea>
                </div>
                <div class="row g-2 mb-2">
                    <div class="col-md-6">
                        <label class="form-label small">Option A *</label>
                        <input type="text" name="option_a" class="form-control" value="{{ old('option_a', $question->option_a) }}" required maxlength="500">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small">Option B *</label>
                        <input type="text" name="option_b" class="form-control" value="{{ old('option_b', $question->option_b) }}" required maxlength="500">
                    </div>
                </div>
                <div class="row g-2 mb-2">
                    <div class="col-md-6">
                        <label class="form-label small">Option C (optional)</label>
                        <input type="text" name="option_c" class="form-control" value="{{ old('option_c', $question->option_c) }}" maxlength="500">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small">Option D (optional)</label>
                        <input type="text" name="option_d" class="form-control" value="{{ old('option_d', $question->option_d) }}" maxlength="500">
                    </div>
                </div>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label for="correct_option" class="form-label">Correct option *</label>
                        <select name="correct_option" id="correct_option" class="form-select" required>
                            @foreach(['a','b','c','d'] as $opt)
                                <option value="{{ $opt }}" {{ old('correct_option', $question->correct_option) === $opt ? 'selected' : '' }}>{{ strtoupper($opt) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="marks" class="form-label">Marks *</label>
                        <input type="number" name="marks" id="marks" class="form-control" value="{{ old('marks', $question->marks) }}" min="1" max="100" required>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('instructor.exams.questions.index', [$course, $exam]) }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
