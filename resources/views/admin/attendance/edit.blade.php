@extends('layouts.admin')

@section('content')
<div class="row mb-3">
    <div class="col-12">
        <a href="{{ route('admin.attendance.index', ['date' => $attendance->date->format('Y-m-d')]) }}" class="text-body small d-block mb-1"><i class="bi bi-arrow-left me-1"></i>Back to attendance</a>
        <h1 class="h3 mb-1">Edit attendance</h1>
        <p class="mb-0 text-body">{{ $attendance->user->name ?? $attendance->user->email }} — {{ $attendance->date->format('l, M d, Y') }}</p>
    </div>
</div>

<div class="card shadow">
    <div class="card-body p-4">
        <form method="post" action="{{ route('admin.attendance.update', $attendance) }}">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="check_in_time" class="form-label">Check-in time</label>
                    <input type="datetime-local" name="check_in_time" id="check_in_time" class="form-control" value="{{ $attendance->check_in_time ? $attendance->check_in_time->format('Y-m-d\TH:i') : '' }}">
                </div>
                <div class="col-md-6">
                    <label for="check_out_time" class="form-label">Check-out time</label>
                    <input type="datetime-local" name="check_out_time" id="check_out_time" class="form-control" value="{{ $attendance->check_out_time ? $attendance->check_out_time->format('Y-m-d\TH:i') : '' }}">
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ route('admin.attendance.index', ['date' => $attendance->date->format('Y-m-d')]) }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
