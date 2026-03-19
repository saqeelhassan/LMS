@extends('layouts.student')

@section('content')
<div>
    <div class="mb-4">
        <a href="{{ route('student.exams.index') }}" class="small d-block mb-1"><i class="bi bi-arrow-left me-1"></i>Back to exams</a>
        <h1 class="h3 mb-1">{{ $exam->title }}</h1>
        <p class="mb-0">
            {{ $exam->course->name ?? '—' }}
            — Total: {{ $exam->isMcq() ? $exam->total_marks_from_questions : $exam->total_marks }} marks
            @if($exam->duration_minutes)
                — Duration: {{ $exam->duration_minutes }} min
            @endif
        </p>
    </div>

    @if($exam->description)
        <div class="card border rounded-3 mb-4">
            <div class="card-header bg-light">
                <h5 class="mb-0">Instructions</h5>
            </div>
            <div class="card-body">
                <div style="white-space: pre-wrap;">{{ $exam->description }}</div>
            </div>
        </div>
    @endif

    @if($submission->isResultFinalized())
        <div class="card border rounded-3 mb-4 border-success">
            <div class="card-header bg-success bg-opacity-10">
                <h5 class="mb-0 text-success">Result: {{ $submission->marks_obtained }}/{{ $exam->isMcq() ? $exam->total_marks_from_questions : $exam->total_marks }}</h5>
            </div>
            <div class="card-body">
                @if($submission->feedback)
                    <p class="mb-0"><strong>Feedback:</strong><br>{{ $submission->feedback }}</p>
                @endif
                <p class="mb-0 mt-2 small">Approved on {{ $submission->result_approved_at?->format('M d, Y H:i') }}</p>
            </div>
        </div>
    @elseif(in_array($submission->status, ['submitted', 'marked']))
        <div class="card border rounded-3 border-info">
            <div class="card-header bg-info bg-opacity-10">
                <h5 class="mb-0">Submitted</h5>
            </div>
            <div class="card-body">
                <p class="mb-0">Your exam has been submitted. Your result will be available after the instructor approves it.</p>
                <a href="{{ route('student.exams.index') }}" class="btn btn-outline-primary mt-3">Back to exams</a>
            </div>
        </div>
    @else
        @php
            $hasTimer = $exam->duration_minutes && $exam->start_datetime;
            $endTs = $hasTimer ? $exam->start_datetime->copy()->addMinutes($exam->duration_minutes)->timestamp * 1000 : null;
        @endphp
        @if($hasTimer)
            <div class="alert alert-warning mb-4 d-flex align-items-center justify-content-between flex-wrap gap-2">
                <span>Time remaining: <strong id="exam-timer">--:--</strong></span>
                <span class="small">Started {{ $exam->start_datetime->format('M d, H:i') }} — {{ $exam->duration_minutes }} min</span>
            </div>
        @endif

        @if($exam->isMcq())
            <div class="card border rounded-3">
                <div class="card-body p-4">
                    <form method="post" action="{{ route('student.exams.submit', $exam) }}" id="exam-mcq-form">
                        @csrf
                        @foreach($exam->questions as $q)
                            @php $saved = $existingAnswers->get($q->id); @endphp
                            <div class="mb-4 pb-4 border-bottom">
                                <p class="fw-bold mb-2">{{ $loop->iteration }}. {{ $q->question_text }} <span class="text-muted small">({{ $q->marks }} marks)</span></p>
                                <div class="ms-3">
                                    @foreach(['a' => $q->option_a, 'b' => $q->option_b, 'c' => $q->option_c, 'd' => $q->option_d] as $key => $label)
                                        @if($label !== null && $label !== '')
                                            <div class="form-check mb-1">
                                                <input class="form-check-input" type="radio" name="answers[{{ $q->id }}]" id="q{{ $q->id }}_{{ $key }}" value="{{ $key }}" {{ ($saved && $saved->selected_option === $key) || old('answers.'.$q->id) === $key ? 'checked' : '' }} required>
                                                <label class="form-check-label" for="q{{ $q->id }}_{{ $key }}">{{ strtoupper($key) }}) {{ $label }}</label>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                        <div class="d-flex gap-2 mt-4">
                            <button type="submit" class="btn btn-primary" id="exam-submit-btn">Submit exam</button>
                            <a href="{{ route('student.exams.index') }}" class="btn btn-outline-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        @else
            <div class="card border rounded-3">
                <div class="card-body p-4">
                    <form method="post" action="{{ route('student.exams.submit', $exam) }}">
                        @csrf
                        <div class="mb-3">
                            <label for="answer_content" class="form-label">Your answer *</label>
                            <textarea name="answer_content" id="answer_content" class="form-control @error('answer_content') is-invalid @enderror" rows="10" required maxlength="50000">{{ old('answer_content', $submission->answer_content) }}</textarea>
                            @error('answer_content')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">{{ $submission->status === 'submitted' ? 'Update submission' : 'Submit exam' }}</button>
                            <a href="{{ route('student.exams.index') }}" class="btn btn-outline-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        @endif

        @if($hasTimer && $endTs)
            <script>
            (function() {
                var endTs = {{ $endTs }};
                function pad(n) { return n < 10 ? '0' + n : n; }
                function update() {
                    var now = Date.now();
                    if (now >= endTs) {
                        document.getElementById('exam-timer').textContent = '0:00';
                        var form = document.getElementById('exam-mcq-form');
                        if (form) {
                            form.submit();
                        }
                        return;
                    }
                    var left = Math.floor((endTs - now) / 1000);
                    var m = Math.floor(left / 60);
                    var s = left % 60;
                    document.getElementById('exam-timer').textContent = m + ':' + pad(s);
                    setTimeout(update, 1000);
                }
                update();
            })();
            </script>
        @endif
    @endif
</div>
@endsection
