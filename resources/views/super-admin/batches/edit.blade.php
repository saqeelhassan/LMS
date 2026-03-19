@extends('layouts.super-admin')

@section('content')
<div class="row mb-3">
    <div class="col-12 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <a href="{{ route('super-admin.batches.index') }}" class="text-body small d-block mb-1"><i class="bi bi-arrow-left me-1"></i>Back to batches</a>
            <h1 class="h3 mb-2 mb-sm-0">Edit Batch</h1>
            <p class="mb-0 text-body">{{ $batch->name }}</p>
        </div>
    </div>
</div>

<div class="card shadow">
    <div class="card-body p-4">
        @if($errors->any())
            <div class="alert alert-danger mb-4"><ul class="mb-0 list-unstyled small">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
        @endif
        <form method="post" action="{{ route('super-admin.batches.update', $batch) }}">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="course_id" class="form-label">Course *</label>
                <select name="course_id" id="course_id" class="form-select" required>
                    <option value="">— Select course —</option>
                    @foreach($courses as $c)
                        <option value="{{ $c->id }}" {{ (int) old('course_id', $batch->course_id) === $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Batch name *</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $batch->name) }}" required maxlength="255">
            </div>
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label for="instructor_id" class="form-label">Instructor</label>
                    <select name="instructor_id" id="instructor_id" class="form-select">
                        <option value="">— No instructor —</option>
                        @foreach($instructors as $i)
                            <option value="{{ $i->id }}" {{ (int) old('instructor_id', $batch->instructor_id) === $i->id ? 'selected' : '' }}>{{ $i->name ?? $i->email }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="branch_id" class="form-label">Branch</label>
                    <select name="branch_id" id="branch_id" class="form-select">
                        <option value="">— No branch —</option>
                        @foreach($branches as $b)
                            <option value="{{ $b->id }}" {{ (int) old('branch_id', $batch->branch_id) === $b->id ? 'selected' : '' }}>{{ $b->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label for="start_date" class="form-label">Start date</label>
                    <input type="date" name="start_date" id="start_date" class="form-control" value="{{ old('start_date', $batch->start_date?->format('Y-m-d')) }}">
                </div>
                <div class="col-md-6">
                    <label for="end_date" class="form-label">End date</label>
                    <input type="date" name="end_date" id="end_date" class="form-control" value="{{ old('end_date', $batch->end_date?->format('Y-m-d')) }}">
                </div>
            </div>
            <div class="mb-3">
                <label for="schedule_note" class="form-label">Schedule note</label>
                <input type="text" name="schedule_note" id="schedule_note" class="form-control" value="{{ old('schedule_note', $batch->schedule_note) }}">
            </div>
            <div class="mb-3">
                <label for="monthly_fee" class="form-label">Monthly fee (PKR)</label>
                <input type="number" name="monthly_fee" id="monthly_fee" class="form-control" step="0.01" min="0" value="{{ old('monthly_fee', $batch->monthly_fee) }}" placeholder="Optional">
            </div>
            <div class="mb-4">
                <div class="form-check">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" {{ old('is_active', $batch->is_active) ? 'checked' : '' }}>
                    <label for="is_active" class="form-check-label">Active (batch visible for enrollment)</label>
                </div>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Update batch</button>
                <a href="{{ route('super-admin.batches.index') }}" class="btn btn-outline-secondary">Cancel</a>
                <form method="post" action="{{ route('super-admin.batches.destroy', $batch) }}" class="d-inline ms-auto" onsubmit="return confirm('Remove this batch?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger">Delete batch</button>
                </form>
            </div>
        </form>
    </div>
</div>
@endsection
