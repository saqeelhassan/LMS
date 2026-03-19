@extends('layouts.account', ['account' => 'instructor'])

@section('content')
<div class="col-xl-9">
    <div class="mb-4">
        <a href="{{ route('instructor.exams.index', $course) }}" class="text-body small d-block mb-1"><i class="bi bi-arrow-left me-1"></i>Back to exams</a>
        <h1 class="h3 mb-1">Create exam</h1>
        <p class="mb-0 text-body">Add an offline exam for {{ $course->name }}.</p>
    </div>

    <div class="card border rounded-3">
        <div class="card-body p-4">
            @if($errors->any())
                <div class="alert alert-danger mb-4">
                    <ul class="mb-0 list-unstyled small">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                </div>
            @endif

            <form method="post" action="{{ route('instructor.exams.store', $course) }}">
                @csrf
                <div class="mb-3">
                    <label for="batch_id" class="form-label">Batch *</label>
                    <select name="batch_id" id="batch_id" class="form-select" required>
                        <option value="">Select batch</option>
                        @foreach($batches as $b)
                            <option value="{{ $b->id }}" {{ old('batch_id') == $b->id ? 'selected' : '' }}>{{ $b->name }}</option>
                        @endforeach
                    </select>
                    <small class="text-muted">Only students in this batch will see this exam.</small>
                </div>
                <div class="mb-3">
                    <label for="title" class="form-label">Exam title *</label>
                    <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required maxlength="255">
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Instructions / description (optional)</label>
                    <textarea name="description" id="description" class="form-control" rows="4" maxlength="2000">{{ old('description') }}</textarea>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="total_marks" class="form-label">Total marks *</label>
                        <input type="number" name="total_marks" id="total_marks" class="form-control" value="{{ old('total_marks', 100) }}" min="1" max="1000" required>
                    </div>
                    <div class="col-md-6">
                        <label for="passing_marks" class="form-label">Passing marks (optional)</label>
                        <input type="number" name="passing_marks" id="passing_marks" class="form-control" value="{{ old('passing_marks') }}" min="0">
                    </div>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="duration_minutes" class="form-label">Duration (minutes, optional)</label>
                        <input type="number" name="duration_minutes" id="duration_minutes" class="form-control" value="{{ old('duration_minutes') }}" min="1" max="480" placeholder="e.g. 60">
                    </div>
                    <div class="col-md-6">
                        <label for="start_datetime" class="form-label">Start date & time (optional)</label>
                        <input type="datetime-local" name="start_datetime" id="start_datetime" class="form-control" value="{{ old('start_datetime') }}">
                    </div>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="due_date" class="form-label">Due date (optional)</label>
                        <input type="date" name="due_date" id="due_date" class="form-control" value="{{ old('due_date') }}">
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
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Create exam</button>
                    <a href="{{ route('instructor.exams.index', $course) }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
