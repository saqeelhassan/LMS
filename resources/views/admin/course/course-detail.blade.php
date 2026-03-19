@extends('layouts.admin')

@section('content')
@php
    $currency = \App\Models\Setting::get('currency', 'PKR');
@endphp

<div class="row page-titles mx-0">
    <div class="col-sm-6 p-md-0">
        <div class="welcome-text">
            <h4>Course Details</h4>
        </div>
    </div>
    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex align-items-center flex-wrap">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.courses.index') }}">Courses</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0);">{{ Str::limit($course->name, 28) }}</a></li>
        </ol>
        @if(auth()->user()->role?->name === 'SuperAdmin' || auth()->user()->hasAdminPermission('courses.create'))
        <a href="{{ route('admin.courses.edit', $course) }}" class="btn btn-sm btn-primary ms-3">Edit Course</a>
        @endif
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="row g-4">
            <!-- Course information -->
            <div class="col-12 col-xxl-6">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="card-title mb-0">{{ $course->name }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            <div class="col-md-6">
                                @if($course->image_url)
                                    <img src="{{ $course->image_url }}" class="rounded w-100" alt="{{ $course->name }}" style="object-fit: cover; max-height: 260px;">
                                @else
                                    <div class="rounded bg-light d-flex align-items-center justify-content-center text-muted" style="height: 200px;"><span>No image</span></div>
                                @endif
                            </div>
                            <div class="col-md-6">
                                @if($course->instructor)
                                <div class="d-flex align-items-center mb-3 flex-wrap">
                                    @if($course->instructor->avatar_url)
                                        <img class="rounded-circle flex-shrink-0" src="{{ $course->instructor->avatar_url }}" alt="{{ $course->instructor->name }}" width="50" height="50" style="object-fit: cover;">
                                    @else
                                        <span class="rounded-circle bg-primary bg-opacity-10 text-primary d-inline-flex align-items-center justify-content-center flex-shrink-0 fw-bold" style="width:50px;height:50px;font-size:1.1rem;">{{ strtoupper(substr($course->instructor->name ?? $course->instructor->email ?? 'I', 0, 1)) }}</span>
                                    @endif
                                    <div class="ms-3 min-w-0">
                                        <p class="mb-0 fw-medium text-dark small">Instructor</p>
                                        <h6 class="mb-0 text-truncate" title="{{ $course->instructor->name }}">{{ $course->instructor->name ?? '—' }}</h6>
                                        <p class="mb-0 small text-muted text-truncate" title="{{ $course->instructor->email }}">{{ $course->instructor->email ?? '' }}</p>
                                    </div>
                                </div>
                                @else
                                <p class="text-muted small mb-3">No instructor assigned.</p>
                                @endif
                                <p class="mb-2 small text-muted"><span class="text-dark">{{ $course->courseMode?->name ?? 'Online' }}</span> &middot; {{ $course->enrollments_count ?? 0 }} enrollments</p>
                                <p class="text-body mb-3">{{ $course->description ?? 'No description.' }}</p>
                                <p class="mb-0"><span class="badge badge-rounded badge-primary">{{ $course->courseMode?->name ?? '—' }}</span> &middot; {{ $course->enrollments_count ?? 0 }} enrollments</p>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between px-0 border-top-0 pt-0"><span class="text-muted">Release date</span><span class="fw-medium">{{ $course->release_date ? $course->release_date->format('d M Y') : '—' }}</span></li>
                                    <li class="list-group-item d-flex justify-content-between px-0"><span class="text-muted">Total hour</span><span class="fw-medium">{{ $course->total_hours ?? '—' }}</span></li>
                                    <li class="list-group-item d-flex justify-content-between px-0"><span class="text-muted">Total enrolled</span><span class="fw-medium">{{ number_format($course->enrollments_count ?? 0) }}</span></li>
                                    <li class="list-group-item d-flex justify-content-between px-0"><span class="text-muted">Certificate</span><span class="fw-medium">{{ $course->certificate ? 'Yes' : 'No' }}</span></li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between px-0 border-top-0 pt-0"><span class="text-muted">Skills</span><span class="fw-medium text-end">{{ $course->skills ?? '—' }}</span></li>
                                    <li class="list-group-item d-flex justify-content-between px-0"><span class="text-muted">Total lecture</span><span class="fw-medium">{{ $course->total_lectures ?? '—' }}</span></li>
                                    <li class="list-group-item d-flex justify-content-between px-0"><span class="text-muted">Language</span><span class="fw-medium">{{ $course->language ?? '—' }}</span></li>
                                    <li class="list-group-item d-flex justify-content-between px-0"><span class="text-muted">Review</span><span class="fw-medium">N/A</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats cards -->
            <div class="col-12 col-xxl-6">
                <div class="row g-4">
                    <div class="col-md-6 col-xxl-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Total course earning</h5>
                            </div>
                            <div class="card-body">
                                <h4 class="fw-bold text-primary mb-1">{{ $currency }} {{ number_format($totalEarnings ?? 0, 2) }}</h4>
                                <p class="mb-0 small text-muted">Total fees collected from enrollments</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xxl-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">New enrollment this month</h5>
                            </div>
                            <div class="card-body">
                                <h4 class="fw-bold text-primary mb-1">{{ $enrollmentsThisMonth ?? 0 }}</h4>
                                <p class="mb-0 small text-muted">Enrollments in {{ now()->format('F Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-0 mt-xxl-4">
                    <a href="{{ route('admin.courses.index') }}" class="btn btn-outline-secondary btn-sm">← Back to Courses</a>
                </div>
            </div>

            <!-- Student reviews -->
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Student reviews</h5>
                    </div>
                    <div class="card-body text-center py-5">
                        <p class="text-muted mb-0">No reviews for this course yet.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
