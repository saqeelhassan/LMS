@extends('layouts.account', ['account' => 'instructor'])

@section('content')
<div class="col-xl-9">
    <div class="mb-4">
        <a href="{{ route('instructor.assignments.index', $course) }}" class="text-body small d-block mb-1">Back to assignments</a>
        <h1 class="h3 mb-1">Create assignment</h1>
        <p class="mb-0 text-body">Set deadline and upload problem statement.</p>
    </div>

    <div class="card border rounded-3">
        <div class="card-body p-4">
            @if($errors->any())
                <div class="alert alert-danger mb-4"><ul class="mb-0 list-unstyled small">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
            @endif
            <form method="post" action="{{ route('instructor.assignments.store', $course) }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="batch_id" class="form-label">Batch *</label>
                    <select name="batch_id" id="batch_id" class="form-select" required>
                        <option value="">Select batch</option>
                        @foreach($batches as $b)
                            <option value="{{ $b->id }}" {{ old('batch_id') == $b->id ? 'selected' : '' }}>{{ $b->name }}</option>
                        @endforeach
                    </select>
                    <small class="text-muted">Only students in this batch will see this assignment.</small>
                </div>
                <div class="mb-3">
                    <label for="title" class="form-label">Title *</label>
                    <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required maxlength="255">
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" class="form-control" rows="3" maxlength="5000">{{ old('description') }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="problem_file" class="form-label">Problem statement (PDF, DOC, TXT)</label>
                    <input type="file" name="problem_file" id="problem_file" class="form-control" accept=".pdf,.doc,.docx,.txt">
                </div>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label for="total_marks" class="form-label">Total marks *</label>
                        <input type="number" name="total_marks" id="total_marks" class="form-control" value="{{ old('total_marks', 100) }}" min="1" max="1000" required>
                    </div>
                    <div class="col-md-6">
                        <label for="due_date" class="form-label">Due date</label>
                        <input type="date" name="due_date" id="due_date" class="form-control" value="{{ old('due_date') }}">
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Create</button>
                    <a href="{{ route('instructor.assignments.index', $course) }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
