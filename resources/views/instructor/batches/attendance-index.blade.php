@extends('layouts.super-admin')

@section('title', 'Attendance: ' . $batch->name)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Attendance: {{ $batch->name }}</h4>
                    <p class="card-text mb-0">{{ $batch->course->name ?? '—' }} — View attendance by date (biometric only)</p>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="alert alert-info">
                        <i class="bi bi-fingerprint me-2"></i>
                        <strong>Biometric-only attendance.</strong> Students and staff are recorded via the physical biometric scanner at the institute. Use the date links below to view who punched in.
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Recent attendance sessions</h5>
                        </div>
                        <div class="card-body">
                            @if($dates->isNotEmpty())
                                <div class="list-group list-group-flush">
                                    @foreach($dates as $d)
                                    <a href="{{ route('instructor.batches.attendance.view', [$batch, $d]) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                        <span><i class="bi bi-calendar3 me-2"></i>{{ \Carbon\Carbon::parse($d)->format('l, M d, Y') }}</span>
                                        <i class="bi bi-chevron-right"></i>
                                    </a>
                                    @endforeach
                                </div>
                            @else
                                <p class="mb-0 text-body">No biometric attendance recorded yet for this batch. Attendance is recorded via the institute scanner.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
