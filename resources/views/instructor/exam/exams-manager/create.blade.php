@extends('layouts.super-admin')

@section('content')
@if($errors->any())
<div class="row mb-4">
    <div class="col-12">
        <div class="alert alert-danger border-0 d-flex align-items-center justify-content-between flex-wrap gap-3 mb-0 py-3">
            <div class="min-w-0 flex-grow-1">
                <strong><i class="fas fa-exclamation-triangle me-2"></i>Validation Errors</strong>
                <ul class="mb-0 ms-2">
                    @foreach($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
@endif

<div class="row mb-4">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <a href="{{ route('instructor.exams-manager.index') }}" class="btn btn-sm btn-outline-secondary me-3">
                        <i class="fas fa-arrow-left me-1"></i>Back to Exams Manager
                    </a>
                    <div>
                        <h4 class="card-title mb-0">Create Exam</h4>
                        <p class="text-muted mb-0">Select a course, set title and duration, then add MCQ questions</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<form method="post" action="{{ route('instructor.exams-manager.store') }}" id="exam-form">
    @csrf

    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Exam Details</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="course_id" class="form-label">Select course *</label>
                            <select name="course_id" id="course_id" class="form-select" required>
                                <option value="">Choose course</option>
                                @foreach($courses as $c)
                                    <option value="{{ $c->id }}" {{ old('course_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="batch_id" class="form-label">Batch (optional)</label>
                            <select name="batch_id" id="batch_id" class="form-select">
                                <option value="">All batches</option>
                                @foreach($courses as $c)
                                    @foreach($c->batches ?? [] as $b)
                                        <option value="{{ $b->id }}" data-course="{{ $c->id }}" {{ old('batch_id') == $b->id ? 'selected' : '' }}>{{ $c->name }} — {{ $b->name }}</option>
                                    @endforeach
                                @endforeach
                            </select>
                            <small class="text-muted">Leave as "All batches" to show exam to entire course.</small>
                        </div>
                        <div class="col-md-6">
                            <label for="title" class="form-label">Exam title *</label>
                            <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required maxlength="255" placeholder="e.g. HTML Basics Mid-Term">
                        </div>
                        <div class="col-md-6">
                            <label for="duration_minutes" class="form-label">Duration (minutes) *</label>
                            <input type="number" name="duration_minutes" id="duration_minutes" class="form-control" value="{{ old('duration_minutes', 45) }}" min="1" max="480" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Total marks</label>
                            <div class="form-control-plaintext fw-bold" id="total-marks-display">0</div>
                            <small class="text-muted">Auto-calculated from questions below.</small>
                        </div>
                        <div class="col-md-6">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-select">
                                <option value="draft" {{ old('status', 'draft') === 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Published</option>
                                <option value="completed" {{ old('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Question Builder</h5>
                    <button type="button" class="btn btn-primary btn-sm" id="add-question-btn">
                        <i class="fas fa-plus me-1"></i>Add Question
                    </button>
                </div>
                <div class="card-body">
                    <div id="questions-container">
                        {{-- Question blocks appended by JS --}}
                    </div>
                    <p class="text-muted small mb-0" id="no-questions-hint">Click "Add question" to add your first question. At least one question is required.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary" id="submit-exam-btn" disabled>
                            <i class="fas fa-save me-1"></i>Create Exam
                        </button>
                        <a href="{{ route('instructor.exams-manager.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-1"></i>Cancel
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<template id="question-block-tpl">
    <div class="question-block border rounded-3 p-3 mb-3 bg-light" data-index="">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <span class="fw-bold text-secondary question-number">Question #1</span>
            <button type="button" class="btn btn-sm btn-outline-danger remove-question" aria-label="Remove question">
                <i class="fas fa-trash me-1"></i>Remove
            </button>
        </div>
        <div class="mb-2">
            <label class="form-label small">Question text *</label>
            <textarea class="form-control question-text" name="questions[__INDEX__][question_text]" rows="2" maxlength="2000" required placeholder="Enter the question"></textarea>
        </div>
        <div class="row g-2 mb-2">
            <div class="col-md-6">
                <label class="form-label small">Option A *</label>
                <input type="text" class="form-control form-control-sm" name="questions[__INDEX__][option_a]" maxlength="500" required placeholder="Option A">
            </div>
            <div class="col-md-6">
                <label class="form-label small">Option B *</label>
                <input type="text" class="form-control form-control-sm" name="questions[__INDEX__][option_b]" maxlength="500" required placeholder="Option B">
            </div>
        </div>
        <div class="row g-2 mb-2">
            <div class="col-md-6">
                <label class="form-label small">Option C (optional)</label>
                <input type="text" class="form-control form-control-sm" name="questions[__INDEX__][option_c]" maxlength="500" placeholder="Option C">
            </div>
            <div class="col-md-6">
                <label class="form-label small">Option D (optional)</label>
                <input type="text" class="form-control form-control-sm" name="questions[__INDEX__][option_d]" maxlength="500" placeholder="Option D">
            </div>
        </div>
        <div class="row g-2 align-items-end">
            <div class="col-md-4">
                <label class="form-label small">Correct answer *</label>
                <div class="d-flex gap-3 pt-1">
                    <label class="form-check form-check-inline mb-0"><input type="radio" class="form-check-input correct-option" name="questions[__INDEX__][correct_option]" value="a" required> A</label>
                    <label class="form-check form-check-inline mb-0"><input type="radio" class="form-check-input correct-option" name="questions[__INDEX__][correct_option]" value="b"> B</label>
                    <label class="form-check form-check-inline mb-0"><input type="radio" class="form-check-input correct-option" name="questions[__INDEX__][correct_option]" value="c"> C</label>
                    <label class="form-check form-check-inline mb-0"><input type="radio" class="form-check-input correct-option" name="questions[__INDEX__][correct_option]" value="d"> D</label>
                </div>
            </div>
            <div class="col-md-2">
                <label class="form-label small">Marks *</label>
                <input type="number" class="form-control form-control-sm question-marks" name="questions[__INDEX__][marks]" value="1" min="1" max="100" required>
            </div>
        </div>
    </div>
</template>
@endsection

@section('scripts')
<script>
(function () {
    const container = document.getElementById('questions-container');
    const tpl = document.getElementById('question-block-tpl');
    const addBtn = document.getElementById('add-question-btn');
    const totalMarksEl = document.getElementById('total-marks-display');
    const submitBtn = document.getElementById('submit-exam-btn');
    const noQuestionsHint = document.getElementById('no-questions-hint');
    let questionIndex = 0;

    function updateBatchOptions() {
        const courseId = document.getElementById('course_id').value;
        document.querySelectorAll('#batch_id option[data-course]').forEach(function (opt) {
            opt.hidden = opt.getAttribute('data-course') !== courseId;
        });
        const firstVisible = document.querySelector('#batch_id option[data-course]:not([hidden])');
        document.getElementById('batch_id').value = firstVisible ? firstVisible.value : '';
    }

    document.getElementById('course_id').addEventListener('change', updateBatchOptions);
    updateBatchOptions();

    function recalcTotalMarks() {
        let total = 0;
        container.querySelectorAll('.question-marks').forEach(function (input) {
            total += parseInt(input.value, 10) || 0;
        });
        totalMarksEl.textContent = total;
        const count = container.querySelectorAll('.question-block').length;
        submitBtn.disabled = count === 0;
        noQuestionsHint.style.display = count === 0 ? 'block' : 'none';
    }

    function reindexQuestions() {
        container.querySelectorAll('.question-block').forEach(function (block, i) {
            block.setAttribute('data-index', i);
            block.querySelector('.question-number').textContent = 'Question #' + (i + 1);
            block.querySelectorAll('input, textarea').forEach(function (input) {
                if (!input.name) return;
                input.name = input.name.replace(/questions\[\d+\]/, 'questions[' + i + ']');
            });
        });
        recalcTotalMarks();
    }

    container.addEventListener('input', function (e) {
        if (e.target.classList.contains('question-marks')) recalcTotalMarks();
    });
    container.addEventListener('change', function (e) {
        if (e.target.classList.contains('question-marks')) recalcTotalMarks();
    });

    addBtn.addEventListener('click', function () {
        const html = tpl.innerHTML.replace(/__INDEX__/g, questionIndex);
        const wrap = document.createElement('div');
        wrap.innerHTML = html.trim();
        const block = wrap.firstChild;
        block.setAttribute('data-index', questionIndex);
        block.querySelector('.question-number').textContent = 'Question #' + (container.querySelectorAll('.question-block').length + 1);
        container.appendChild(block);
        questionIndex++;
        reindexQuestions();
    });

    container.addEventListener('click', function (e) {
        if (e.target.closest('.remove-question')) {
            e.target.closest('.question-block').remove();
            reindexQuestions();
        }
    });

    // Add one empty question on load so user can start typing
    addBtn.click();
})();
</script>
@endsection
