@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-12 mb-3">
        <h1 class="h3 mb-2 mb-sm-0">Staff Dashboard</h1>
        <p class="mb-0 text-body">Staff area.</p>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-6 col-xl-4">
        <div class="card card-body bg-primary bg-opacity-15 p-4 h-100">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-0 fw-bold"><i class="fas fa-user-friends fa-fw me-2"></i></h2>
                    <span class="mb-0 h6 fw-light">Welcome, Staff</span>
                </div>
            </div>
            <p class="mb-0 mt-2 small text-body">Use the sidebar to access courses and admin features available to your role.</p>
        </div>
    </div>
    <div class="col-md-6 col-xl-4">
        <div class="card card-body bg-success bg-opacity-10 p-4 h-100">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="mb-0 h6 fw-light">Quick links</span>
                </div>
            </div>
            <ul class="mb-0 mt-2 list-unstyled small">
                <li><a href="{{ route('admin.dashboard') }}">Admin dashboard</a></li>
                <li><a href="{{ route('admin.courses.index') }}">Courses</a></li>
                <li><a href="{{ route('courses.index') }}">Public courses</a></li>
            </ul>
        </div>
    </div>
</div>
@endsection
