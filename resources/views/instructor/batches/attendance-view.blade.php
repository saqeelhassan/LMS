@extends('layouts.super-admin')

@section('title', 'Attendance View')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Attendance View</h4>
                    <p class="card-text mb-0">{{ $batch->name }} — {{ $sessionDate->format('l, M d, Y') }}</p>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Student</th>
                                    <th>Status</th>
                                    <th>Check-in</th>
                                    <th>Check-out</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($attendances as $a)
                                <tr>
                                    <td>
                                        <div>
                                            <h6 class="mb-0">{{ $a->user->name ?? $a->user->email }}</h6>
                                            <small class="text-muted">{{ $a->user->email }}</small>
                                        </div>
                                    </td>
                                    <td><span class="badge bg-{{ $a->status === 'Present' ? 'success' : ($a->status === 'Late' ? 'warning' : ($a->status === 'Invalid' ? 'danger' : 'secondary')) }}">{{ $a->status }}</span></td>
                                    <td>{{ $a->check_in_time ? $a->check_in_time->format('g:i A') : '—' }}</td>
                                    <td>{{ $a->check_out_time ? $a->check_out_time->format('g:i A') : '—' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-body">No attendance recorded for this date.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
