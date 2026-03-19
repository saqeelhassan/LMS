@extends('layouts.admin')

@section('css')
<link href="{{ asset('css/custom-dsimt.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<div class="row mb-3">
    <div class="col-12">
        <h1 class="h3 mb-2 mb-sm-0">Government program monthly report</h1>
        <p class="mb-0 text-body">Attendance for {{ $program }} students only. Select month and export PDF for records.</p>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card shadow mb-4">
    <div class="card-body">
        <form method="get" action="{{ route('admin.attendance.government-report') }}" class="row g-2 align-items-end mb-4">
            <div class="col-auto">
                <label for="month" class="form-label mb-0">Month</label>
                <input type="month" name="month" id="month" class="form-control" value="{{ $month }}" aria-label="Select month">
            </div>
            <input type="hidden" name="program" value="{{ $program }}">
            <div class="col-auto">
                <button type="submit" class="btn btn-primary btn-dsimt">Show report</button>
            </div>
        </form>

        <div class="mb-3 d-flex flex-wrap align-items-center gap-2">
            <a href="{{ route('admin.attendance.export-pdf', ['month' => $month, 'program' => $program]) }}" class="btn btn-outline-danger btn-dsimt" target="_blank" rel="noopener">
                <i class="bi bi-file-pdf me-1" aria-hidden="true"></i>Export PDF ({{ $dateLabel }})
            </a>
            <a href="{{ route('admin.attendance.index') }}" class="btn btn-outline-secondary btn-sm">Back to attendance</a>
        </div>

        <h2 class="h6 text-body-secondary mb-2">{{ $program }} — {{ $dateLabel }}</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-sm">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Name</th>
                        <th>Check-in</th>
                        <th>Check-out</th>
                        <th>Status</th>
                        <th>Hours</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($records as $i => $r)
                    @php $mins = $r->check_in_time && $r->check_out_time ? (int) $r->check_in_time->diffInMinutes($r->check_out_time) : 0; @endphp
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $r->date ? $r->date->format('M j, Y') : '—' }}</td>
                        <td>{{ $r->user->name ?? $r->user->email }}</td>
                        <td>{{ $r->check_in_time ? $r->check_in_time->format('h:i A') : '—' }}</td>
                        <td>{{ $r->check_out_time ? $r->check_out_time->format('h:i A') : '—' }}</td>
                        <td><span class="badge bg-{{ $r->status === 'Late' ? 'warning' : ($r->status === 'Invalid' ? 'danger' : 'success') }}">{{ $r->status ?? 'Present' }}</span></td>
                        <td>{{ $mins ? floor($mins / 60) . 'h ' . ($mins % 60) . 'm' : '—' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-body-secondary">No {{ $program }} attendance records for this month.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
