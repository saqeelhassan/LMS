@extends('layouts.admin')

@section('content')
<div class="row mb-3">
    <div class="col-12 d-sm-flex justify-content-between align-items-center">
        <h1 class="h3 mb-2 mb-sm-0">Edit Batch</h1>
        <a href="{{ route('admin.batches.timetable', $batch) }}" class="btn btn-sm btn-outline-primary mb-0">Edit Timetable</a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow">
            <div class="card-body p-4">
                @if($errors->any())
                    <div class="alert alert-danger mb-4">
                        <ul class="mb-0 list-unstyled small">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                    </div>
                @endif
                <form method="post" action="{{ route('admin.batches.update', $batch) }}">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="course_id" class="form-label">Course *</label>
                        <select name="course_id" id="course_id" class="form-select @error('course_id') is-invalid @enderror" required>
                            <option value="">— Select course —</option>
                            @foreach($courses as $c)
                                <option value="{{ $c->id }}" {{ (int) old('course_id', $batch->course_id) === $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                            @endforeach
                        </select>
                        @error('course_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Batch name *</label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $batch->name) }}" required maxlength="255">
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="instructor_id" class="form-label">Instructor</label>
                            <select name="instructor_id" id="instructor_id" class="form-select">
                                <option value="">— No instructor —</option>
                                @foreach($instructors as $i)
                                    <option value="{{ $i->id }}" {{ (int) old('instructor_id', $batch->instructor_id) === $i->id ? 'selected' : '' }}>{{ $i->name }}</option>
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
                            <input type="date" name="start_date" id="start_date" class="form-control"
                                value="{{ old('start_date', $batch->start_date?->format('Y-m-d')) }}">
                        </div>
                        <div class="col-md-6">
                            <label for="end_date" class="form-label">End date</label>
                            <input type="date" name="end_date" id="end_date" class="form-control"
                                value="{{ old('end_date', $batch->end_date?->format('Y-m-d')) }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="schedule_note" class="form-label">Schedule note</label>
                        <input type="text" name="schedule_note" id="schedule_note" class="form-control"
                            value="{{ old('schedule_note', $batch->schedule_note) }}">
                    </div>
                    <div class="mb-3">
                        <label for="monthly_fee" class="form-label">Monthly fee (PKR)</label>
                        <input type="number" name="monthly_fee" id="monthly_fee" class="form-control" step="0.01" min="0" placeholder="Leave empty if not applicable"
                            value="{{ old('monthly_fee', $batch->monthly_fee) }}">
                        <small class="text-muted">Students in this batch receive a monthly fee voucher for this amount. Pay each voucher to continue classes.</small>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1"
                                {{ old('is_active', $batch->is_active) ? 'checked' : '' }}>
                            <label for="is_active" class="form-check-label">Active</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-check mb-2">
                            <input type="checkbox" name="is_government_funded" id="is_government_funded" class="form-check-input" value="1" {{ old('is_government_funded', $batch->is_government_funded) ? 'checked' : '' }}>
                            <label for="is_government_funded" class="form-check-label">Government funded</label>
                        </div>
                        <div id="government_program_wrap" style="display: {{ old('is_government_funded', $batch->is_government_funded) ? 'block' : 'none' }};">
                            <label for="government_program" class="form-label">Program</label>
                            <select name="government_program" id="government_program" class="form-select @error('government_program') is-invalid @enderror">
                                <option value="">— Select program —</option>
                                @foreach(\App\Models\Batch::governmentProgramOptions() as $value => $label)
                                    <option value="{{ $value }}" {{ old('government_program', $batch->government_program) === $value ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('government_program')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="d-flex gap-2 flex-wrap align-items-center">
                        <button type="submit" class="btn btn-primary">Update batch</button>
                        <a href="{{ route('admin.batches.index') }}" class="btn btn-outline-secondary">Cancel</a>
                        <a href="{{ route('admin.batches.timetable', $batch) }}" class="btn btn-outline-info">Timetable</a>
                        <form method="post" action="{{ route('admin.batches.destroy', $batch) }}" class="d-inline ms-auto" onsubmit="return confirm('Remove this batch?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger">Delete batch</button>
                        </form>
                    </div>
                </form>
                <script>
                    document.getElementById('is_government_funded').addEventListener('change', function() {
                        document.getElementById('government_program_wrap').style.display = this.checked ? 'block' : 'none';
                    });
                </script>
            </div>
        </div>
    </div>
</div>
@endsection
