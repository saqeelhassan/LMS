@extends('layouts.super-admin')

@section('content')
<div class="row page-titles mx-0">
    <div class="col-sm-6 p-md-0">
        <div class="welcome-text">
            <h4>Add Batch</h4>
        </div>
    </div>
    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex align-items-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('super-admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('super-admin.batches.index') }}">Batches</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0);">Add Batch</a></li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-xl-12 col-xxl-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Create batch</h5>
            </div>
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger mb-4 rounded">
                        <ul class="mb-0 list-unstyled small">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                    </div>
                @endif
                <form method="post" action="{{ route('super-admin.batches.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="course_id" class="form-label">Course *</label>
                        <select name="course_id" id="course_id" class="form-select" required>
                            <option value="">Select course</option>
                            @foreach($courses as $c)
                                <option value="{{ $c->id }}" {{ (int) old('course_id') === $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Batch name *</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required maxlength="255">
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="instructor_id" class="form-label">Instructor</label>
                            <select name="instructor_id" id="instructor_id" class="form-select">
                                <option value="">No instructor</option>
                                @foreach($instructors as $i)
                                    <option value="{{ $i->id }}" {{ (int) old('instructor_id') === $i->id ? 'selected' : '' }}>{{ $i->name ?? $i->email }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="branch_id" class="form-label">Branch</label>
                            <select name="branch_id" id="branch_id" class="form-select">
                                <option value="">No branch</option>
                                @foreach($branches as $b)
                                    <option value="{{ $b->id }}" {{ (int) old('branch_id') === $b->id ? 'selected' : '' }}>{{ $b->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="start_date" class="form-label">Start date</label>
                            <input type="date" name="start_date" id="start_date" class="form-control" value="{{ old('start_date') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="end_date" class="form-label">End date</label>
                            <input type="date" name="end_date" id="end_date" class="form-control" value="{{ old('end_date') }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="schedule_note" class="form-label">Schedule note</label>
                        <input type="text" name="schedule_note" id="schedule_note" class="form-control" value="{{ old('schedule_note') }}">
                    </div>
                    <div class="mb-4">
                        <label for="monthly_fee" class="form-label">Monthly fee (PKR)</label>
                        <input type="number" name="monthly_fee" id="monthly_fee" class="form-control" step="0.01" min="0" value="{{ old('monthly_fee') }}">
                    </div>
                    <button type="submit" class="btn btn-primary">Create batch</button>
                    <a href="{{ route('super-admin.batches.index') }}" class="btn btn-outline-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
