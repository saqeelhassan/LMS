@extends('layouts.super-admin')

@section('content')
@php
    $currency = \App\Models\Setting::get('currency', 'PKR');
@endphp

@if(session('success'))
<div class="row mb-4">
    <div class="col-12">
        <div class="alert alert-success border-0 d-flex align-items-center justify-content-between flex-wrap gap-3 mb-0 py-3">
            <div class="min-w-0 flex-grow-1">
                <strong><i class="fas fa-check-circle me-2"></i>Success</strong>
                <span class="ms-2">{{ session('success') }}</span>
            </div>
        </div>
    </div>
</div>
@endif

@if(session('error'))
<div class="row mb-4">
    <div class="col-12">
        <div class="alert alert-danger border-0 d-flex align-items-center justify-content-between flex-wrap gap-3 mb-0 py-3">
            <div class="min-w-0 flex-grow-1">
                <strong><i class="fas fa-exclamation-triangle me-2"></i>Error</strong>
                <span class="ms-2">{{ session('error') }}</span>
            </div>
        </div>
    </div>
</div>
@endif

{{-- Overview & Quick Links (top) --}}
<div class="row mb-4">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Instructor Overview & Quick Links</h4>
            </div>
            <div class="card-body pt-2">
                <div class="row g-3">
                    <div class="col-md-4 col-lg-3">
                        <div class="card card-body bg-primary bg-opacity-10 text-dark p-3 text-center">
                            <h4 class="mb-0">{{ $totalCourses }}</h4>
                            <small>My Courses</small>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-3">
                        <div class="card card-body bg-success bg-opacity-10 text-dark p-3 text-center">
                            <h4 class="mb-0">{{ number_format($distinctStudents) }}</h4>
                            <small>Total Students</small>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-3">
                        <div class="card card-body bg-warning bg-opacity-10 text-dark p-3 text-center">
                            <h4 class="mb-0">{{ number_format($totalEnrollments) }}</h4>
                            <small>Total Enrollments</small>
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-3">
                        <div class="card card-body bg-info bg-opacity-10 text-dark p-3 text-center">
                            <h4 class="mb-0">{{ number_format($enrollmentsThisMonth) }}</h4>
                            <small>This Month</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Exams, Quizzes & Assignments quick access --}}
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body p-4">
                <h5 class="card-title mb-2"><i class="bi bi-journal-check me-2"></i>Exams, Quizzes & Assignments</h5>
                <p class="text-body small mb-3">Add <strong>exams (MCQ/quiz)</strong> or <strong>assignments</strong> for your students. Choose a course in the table below and click <strong>Exams</strong> to create quizzes or <strong>Assignments</strong> to add homework.</p>
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('instructor.manage-course') }}" class="btn btn-primary"><i class="bi bi-journal-text me-1"></i>Exams / Quiz</a>
                    <a href="{{ route('instructor.manage-course') }}" class="btn btn-outline-primary"><i class="bi bi-journal-plus me-1"></i>Assignments</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    {{-- Instructor stat cards --}}
    <div class="col-sm-6 col-xl-4">
        <div class="widget-stat card bg-primary overflow-hidden">
            <div class="card-header border-opacity">
                <h3 class="card-title text-white">My Courses</h3>
                <h5 class="text-white mb-0"><i class="fa fa-caret-up"></i> {{ $totalCourses }}</h5>
            </div>
            <div class="card-body text-center mt-3">
                <div class="ico-sparkline"><div id="sparkline12"></div></div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-4">
        <div class="widget-stat card bg-success overflow-hidden">
            <div class="card-header border-opacity">
                <h3 class="card-title text-white">Total Students</h3>
                <h5 class="text-white mb-0"><i class="fa fa-caret-up"></i> {{ number_format($distinctStudents) }}</h5>
            </div>
            <div class="card-body text-center mt-4 p-0">
                <div class="ico-sparkline"><div id="spark-bar-2"></div></div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-4">
        <div class="widget-stat card bg-secondary overflow-hidden">
            <div class="card-header border-opacity pb-3">
                <h3 class="card-title text-white">Enrollments</h3>
                <h5 class="text-white mb-0"><i class="fa fa-caret-up"></i> {{ number_format($totalEnrollments) }}</h5>
            </div>
            <div class="card-body p-0 mt-2">
                <div class="px-4"><span class="bar1" data-peity='{ "fill": ["rgb(0, 0, 128)", "rgb(7, 135, 234)"]}'>6,2,8,4,-3,8,1,-3,6,-5,9,2,-8,1,4,8,9,8,2,1</span></div>
            </div>
        </div>
    </div>

    {{-- Enrollments overview --}}
    <div class="col-xl-6 col-xxl-6 col-sm-6">
        <div class="card">
            <div class="card-header"><h3 class="card-title">Enrollment Trends</h3></div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-sm-6">
                        <span class="badge text-bg-dark">This Month</span>
                        <h4 class="text-primary my-2">{{ number_format($enrollmentsThisMonth) }}</h4>
                        <p class="mb-0">New enrollments</p>
                    </div>
                    <div class="col-sm-6">
                        <span class="badge text-bg-dark">Last Month</span>
                        <h4 class="my-2">{{ number_format($enrollmentsLastMonth) }}</h4>
                        <p class="mb-0">
                            @if($lastMonthPercent >= 0)
                                <span class="text-success me-1">{{ $lastMonthPercent }}%<i class="bi bi-arrow-up"></i></span>
                            @else
                                <span class="text-danger me-1">{{ abs($lastMonthPercent) }}%<i class="bi bi-arrow-down"></i></span>
                            @endif
                            vs last month
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- My Courses table --}}
    <div class="col-xl-12 col-xxl-12 col-lg-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">My Courses</h5>
                @if($courses->isNotEmpty())
                    <span class="badge badge-rounded badge-primary ms-2">{{ $courses->count() }} courses</span>
                @endif
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table header-border table-hover verticle-middle">
                        <thead>
                            <tr>
                                <th scope="col">Course Name</th>
                                <th scope="col">Mode</th>
                                <th scope="col">Enrollments</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($courses as $course)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $course->image_url }}" class="rounded-circle me-3" width="40" height="40" alt="">
                                            <div>
                                                <h6 class="mb-0">{{ $course->name }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="badge badge-light">{{ $course->courseMode?->name ?? '—' }}</span></td>
                                    <td>{{ number_format($course->enrollments_count) }}</td>
                                    <td>
                                        <a href="{{ route('instructor.courses.edit', $course) }}" class="btn btn-sm btn-primary me-1">Edit</a>
                                        <a href="{{ route('instructor.exams.index', $course) }}" class="btn btn-sm btn-success me-1">Exams</a>
                                        <a href="{{ route('instructor.assignments.index', $course) }}" class="btn btn-sm btn-warning me-1">Assignments</a>
                                        <a href="{{ route('instructor.attendance.index', $course) }}" class="btn btn-sm btn-info">Attendance</a>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center text-muted py-4">You have no courses assigned yet. Courses are assigned by Admin from the course edit page.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($courses->isNotEmpty())
                <p class="mb-0 mt-3 small text-body">Showing {{ $courses->count() }} of your courses. <a href="{{ route('instructor.manage-course') }}">Manage courses</a></p>
                @endif
            </div>
        </div>
    </div>

    {{-- Enrolled Students (Recent Enrollments) --}}
    <div class="col-xl-12 col-xxl-12 col-lg-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Recent Enrollments</h5>
                <span class="badge bg-primary-soft text-primary">Recent enrollments in your courses</span>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table header-border table-hover verticle-middle">
                        <thead>
                            <tr>
                                <th scope="col">Student</th>
                                <th scope="col">Course</th>
                                <th scope="col">Enrolled at</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentEnrollments ?? [] as $enrollment)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm flex-shrink-0 me-3">
                                                <span class="avatar-title bg-primary bg-opacity-10 text-primary rounded-circle">{{ strtoupper(substr($enrollment->user->name ?? '?', 0, 1)) }}</span>
                                            </div>
                                            <div>
                                                <h6 class="mb-0">{{ $enrollment->user->name ?? $enrollment->user->email }}</h6>
                                                <small class="text-body">{{ $enrollment->user->email }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="fw-medium">{{ $enrollment->course->name ?? '—' }}</span>
                                    </td>
                                    <td>
                                        <span class="text-body">{{ $enrollment->created_at->format('M d, Y H:i') }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-success bg-opacity-10 text-success">{{ $enrollment->payment_status ?? 'Enrolled' }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center text-muted py-4">No enrollments yet. When students enroll in your courses, they will appear here.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if(isset($recentEnrollments) && $recentEnrollments->isNotEmpty())
                <p class="mb-0 mt-3 small text-body">Showing latest {{ $recentEnrollments->count() }} enrollments in your courses.</p>
                @endif
            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script src="{{ asset('Dsimt-lms-assets/vendor/svganimation/vivus.min.js') }}"></script>
<script src="{{ asset('Dsimt-lms-assets/vendor/svganimation/svg.animation.js') }}"></script>
<script src="{{ asset('Dsimt-lms-assets/js/dashboard/dashboard-3.js') }}"></script>
@endsection
