@extends('layouts.admin')

@section('content')
<div class="row page-titles mx-0">
    <div class="col-sm-6 p-md-0">
        <div class="welcome-text">
            <h4>Add Batch</h4>
        </div>
    </div>
    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.batches.index') }}">Batches</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0);">Add Batch</a></li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-xl-12 col-xxl-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Add Batch</h5>
            </div>
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger mb-4">
                        <ul class="mb-0 list-unstyled small">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                    </div>
                @endif
                <form method="post" action="{{ route('admin.batches.store') }}">
                    @csrf
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group mb-3">
                                <label for="course_id" class="form-label">Course *</label>
                                <select name="course_id" id="course_id" class="form-control form-select @error('course_id') is-invalid @enderror" required>
                                    <option value="">— Select course —</option>
                                    @foreach($courses as $c)
                                        <option value="{{ $c->id }}" {{ (int) old('course_id') === $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                                    @endforeach
                                </select>
                                @error('course_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group mb-3">
                                <label for="name" class="form-label">Batch name *</label>
                                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name') }}" placeholder="e.g. Morning Batch, Evening Batch" required maxlength="255">
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group mb-3">
                                <label for="instructor_id" class="form-label">Instructor</label>
                                <select name="instructor_id" id="instructor_id" class="form-control form-select @error('instructor_id') is-invalid @enderror">
                                    <option value="">— No instructor —</option>
                                    @foreach($instructors as $i)
                                        <option value="{{ $i->id }}" {{ (int) old('instructor_id') === $i->id ? 'selected' : '' }}>{{ $i->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group mb-3">
                                <label for="branch_id" class="form-label">Branch</label>
                                <select name="branch_id" id="branch_id" class="form-control form-select @error('branch_id') is-invalid @enderror">
                                    <option value="">— No branch —</option>
                                    @foreach($branches as $b)
                                        <option value="{{ $b->id }}" {{ (int) old('branch_id') === $b->id ? 'selected' : '' }}>{{ $b->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group mb-3">
                                <label for="start_date" class="form-label">Start date</label>
                                <input type="date" name="start_date" id="start_date" class="form-control" value="{{ old('start_date') }}">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group mb-3">
                                <label for="end_date" class="form-label">End date</label>
                                <input type="date" name="end_date" id="end_date" class="form-control" value="{{ old('end_date') }}">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group mb-3">
                                <label for="schedule_note" class="form-label">Schedule note</label>
                                <input type="text" name="schedule_note" id="schedule_note" class="form-control" value="{{ old('schedule_note') }}"
                                    placeholder="e.g. Mon–Fri 10 AM–12 PM">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group mb-3">
                                <label for="monthly_fee" class="form-label">Monthly fee (PKR)</label>
                                <input type="number" name="monthly_fee" id="monthly_fee" class="form-control" step="0.01" min="0" placeholder="Optional"
                                    value="{{ old('monthly_fee') }}">
                                <small class="text-muted">Students in this batch get a monthly fee voucher for this amount.</small>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group mb-4">
                                <div class="form-check mb-2">
                                    <input type="checkbox" name="is_government_funded" id="is_government_funded" class="form-check-input" value="1" {{ old('is_government_funded') ? 'checked' : '' }}>
                                    <label for="is_government_funded" class="form-check-label">Government funded</label>
                                </div>
                                <div id="government_program_wrap" style="display: {{ old('is_government_funded') ? 'block' : 'none' }};">
                                    <label for="government_program" class="form-label">Program</label>
                                    <select name="government_program" id="government_program" class="form-control form-select @error('government_program') is-invalid @enderror">
                                        <option value="">— Select program —</option>
                                        @foreach(\App\Models\Batch::governmentProgramOptions() as $value => $label)
                                            <option value="{{ $value }}" {{ old('government_program') === $value ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    @error('government_program')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="{{ route('admin.batches.index') }}" class="btn btn-danger light">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('is_government_funded').addEventListener('change', function() {
    document.getElementById('government_program_wrap').style.display = this.checked ? 'block' : 'none';
});
</script>
@endsection
