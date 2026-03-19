@extends('layouts.base')

@section('content')
<div class="container py-5">
    @if(session('info'))
        <div class="alert alert-info alert-dismissible fade show mb-4">{{ session('info') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
    @endif
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow border-0">
                <div class="card-body text-center py-5">
                    <div class="mb-4">
                        <i class="bi bi-fingerprint display-4 text-primary"></i>
                    </div>
                    <h2 class="mb-3">Attendance is only recorded via Biometric Scanner at the Institute</h2>
                    <p class="text-body-secondary mb-4">
                        Manual check-in/check-out and QR-based attendance have been decommissioned.
                        Please use the physical biometric scanner at the institute to record your attendance.
                    </p>
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn btn-primary">Return to Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary">Go to Login</a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
