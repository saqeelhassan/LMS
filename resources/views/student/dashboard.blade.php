@extends('layouts.student')

@section('content')
<!-- Main content START -->
<div>

    <!-- Counter boxes START -->
    <div class="row mb-4">
        <!-- Counter item -->
        <div class="col-sm-6 col-lg-4 mb-3 mb-lg-0">
            <div class="d-flex justify-content-center align-items-center p-4 bg-orange bg-opacity-15 rounded-3">
                <span class="display-6 lh-1 text-orange mb-0"><i class="fas fa-tv fa-fw"></i></span>
                <div class="ms-4">
                    <div class="d-flex">
                        <h5 class="mb-0 fw-bold">{{ $enrollmentsCount ?? 0 }}</h5>
                    </div>
                    <p class="mb-0 h6 fw-light">My Enrolled Courses</p>
                </div>
            </div>
        </div>
        <!-- Counter item -->
        <div class="col-sm-6 col-lg-4 mb-3 mb-lg-0">
            <div class="d-flex justify-content-center align-items-center p-4 bg-purple bg-opacity-15 rounded-3">
                <span class="display-6 lh-1 text-purple mb-0"><i class="fas fa-clipboard-check fa-fw"></i></span>
                <div class="ms-4">
                    <div class="d-flex">
                        <h5 class="mb-0 fw-bold">{{ $completedLessonsCount ?? 0 }}</h5>
                    </div>
                    <p class="mb-0 h6 fw-light">Complete lessons</p>
                </div>
            </div>
        </div>
        <!-- Counter item -->
        <div class="col-sm-6 col-lg-4 mb-3 mb-lg-0">
            <div class="d-flex justify-content-center align-items-center p-4 bg-success bg-opacity-10 rounded-3">
                <span class="display-6 lh-1 text-success mb-0"><i class="fas fa-medal fa-fw"></i></span>
                <div class="ms-4">
                    <div class="d-flex">
                        <h5 class="mb-0 fw-bold">{{ $certificatesCount ?? 0 }}</h5>
                    </div>
                    <p class="mb-0 h6 fw-light">Achieved Certificates</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Counter boxes END -->

    @php $rejectedEnrollmentsForReapply = collect($enrollments ?? [])->where('enrollment_status', 'rejected')->filter(fn($e) => $e->isEligibleForReapplication()); @endphp
    @if($rejectedEnrollmentsForReapply->isNotEmpty())
    <div class="card bg-danger bg-opacity-10 border border-danger rounded-3 mb-4">
        <div class="card-body">
            <h5 class="mb-3"><i class="bi bi-arrow-repeat me-2"></i>Re-apply for enrollment</h5>
            <p class="mb-3">Your application was not approved for the following. You can submit again for admin review.</p>
            <div class="list-group list-group-flush">
                @foreach($rejectedEnrollmentsForReapply as $enrollment)
                    @php $course = $enrollment->course; @endphp
                    <div class="list-group-item d-flex justify-content-between align-items-center flex-wrap gap-2 border-0 px-0">
                        <div>
                            <strong>{{ $course->name ?? 'Course' }}</strong>
                            @if($enrollment->rejection_note)
                                <br><small class="text-muted">{{ Str::limit($enrollment->rejection_note, 60) }}</small>
                            @endif
                        </div>
                        <form method="post" action="{{ route('enrollments.reapply', $enrollment) }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-sm">Apply Again</button>
                        </form>
                    </div>
                @endforeach
            </div>
            <a href="{{ route('student.courses') }}" class="btn btn-outline-secondary btn-sm mt-2">View all in My Courses</a>
        </div>
    </div>
    @endif

    @if(isset($resumeLearning) && $resumeLearning)
    <div class="card bg-primary bg-opacity-10 border border-primary rounded-3 mb-4">
        <div class="card-body d-flex flex-sm-row align-items-center justify-content-between gap-3">
            <div>
                <h5 class="mb-1">Resume Learning</h5>
                <p class="mb-0">{{ $resumeLearning->course->name }} — {{ $resumeLearning->content->title }}</p>
            </div>
            <a href="{{ route('student.classroom.show', $resumeLearning->course) }}" class="btn btn-primary">Continue <i class="bi bi-play-fill ms-1"></i></a>
        </div>
    </div>
    @endif

    @if(isset($todaySchedule) && $todaySchedule->isNotEmpty())
    <div class="card bg-transparent border rounded-3 mb-4">
        <div class="card-header bg-transparent border-bottom">
            <h3 class="mb-0">My Schedule — Today</h3>
        </div>
        <div class="card-body">
            <div class="list-group list-group-flush">
                @foreach($todaySchedule as $item)
                <div class="list-group-item d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div>
                        <strong>{{ $item->course->name }}</strong>
                        <span> — {{ $item->batch->name ?? 'Batch' }}</span>
                        <br>
                        <small class="text-muted">
                            {{ \Carbon\Carbon::parse($item->slot->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($item->slot->end_time)->format('g:i A') }}
                            @if($item->slot->room)
                                · {{ $item->slot->room }}
                            @endif
                        </small>
                    </div>
                    @if($item->course->live_class_url)
                        <a href="{{ $item->course->live_class_url }}" target="_blank" class="btn btn-sm btn-success">Join Online <i class="bi bi-camera-video ms-1"></i></a>
                    @else
                        <span class="badge bg-secondary">In-person</span>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <div class="card bg-transparent border rounded-3">
        <!-- Card header START -->
        <div class="card-header bg-transparent border-bottom">
            <h3 class="mb-0">My Courses List</h3>
        </div>
        <!-- Card header END -->

        <!-- Card body START -->
        <div class="card-body">

            <!-- Search and select START -->
            <div class="row g-3 align-items-center justify-content-between mb-4">
                <!-- Content -->
                <div class="col-md-8">
                    <form class="rounded position-relative">
                        <input class="form-control pe-5 bg-transparent" type="search" placeholder="Search"
                            aria-label="Search">
                        <button
                            class="bg-transparent p-2 position-absolute top-50 end-0 translate-middle-y border-0 text-primary-hover text-reset"
                            type="submit">
                            <i class="fas fa-search fs-6 "></i>
                        </button>
                    </form>
                </div>

                <!-- Select option -->
                <div class="col-md-3">
                    <!-- Short by filter -->
                    <form>
                        <select class="form-select js-choice border-0 z-index-9 bg-transparent"
                            aria-label=".form-select-sm">
                            <option value="">Sort by</option>
                            <option>Free</option>
                            <option>Newest</option>
                            <option>Most popular</option>
                            <option>Most Viewed</option>
                        </select>
                    </form>
                </div>
            </div>
            <!-- Search and select END -->

            <!-- Course list table START -->
            <div class="table-responsive border-0">
                <table class="table table-dark-gray align-middle p-4 mb-0 table-hover">
                    <!-- Table head -->
                    <thead>
                        <tr>
                            <th scope="col" class="border-0 rounded-start">Course Title</th>
                            <th scope="col" class="border-0">Status</th>
                            <th scope="col" class="border-0">Total Lectures</th>
                            <th scope="col" class="border-0">Completed Lecture</th>
                            <th scope="col" class="border-0 rounded-end">Action</th>
                        </tr>
                    </thead>

                    <!-- Table body START -->
                    <tbody>
                        @forelse($enrollments ?? [] as $enrollment)
                            @php $course = $enrollment->course; @endphp
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0 rounded overflow-hidden" style="width:80px;height:60px;">
                                            <img src="{{ $course->image_url ?? '/images/courses/4by3/01.jpg' }}" class="rounded w-100 h-100" style="object-fit:cover;" alt="{{ $course->name }}">
                                        </div>
                                        <div class="mb-0 ms-2">
                                            <h6><a href="{{ route('student.classroom.show', $course) }}">{{ $course->name }}</a></h6>
                                            <div class="overflow-hidden">
                                                <h6 class="mb-0 text-end">0%</h6>
                                                <div class="progress progress-sm bg-primary bg-opacity-10">
                                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($enrollment->enrollment_status === 'rejected')
                                        <span class="badge bg-danger" title="{{ $enrollment->rejection_note ?? 'Rejected' }}">Rejected</span>
                                        @if($enrollment->rejection_note)
                                            <small class="d-block text-muted mt-1" style="max-width:200px;">{{ Str::limit($enrollment->rejection_note, 50) }}</small>
                                        @endif
                                    @elseif($enrollment->enrollment_status === 'pending_approval')
                                        <span class="badge bg-warning text-dark">Pending approval</span>
                                    @else
                                        <span class="badge bg-success">Active</span>
                                    @endif
                                </td>
                                <td>—</td>
                                <td>0</td>
                                <td>
                                    @if($enrollment->enrollment_status === 'rejected' && $enrollment->isEligibleForReapplication())
                                        <form method="post" action="{{ route('enrollments.reapply', $enrollment) }}" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-primary me-1 mb-1 mb-md-0">Apply Again</button>
                                        </form>
                                    @elseif($enrollment->enrollment_status === 'active')
                                        <a href="{{ route('student.classroom.show', $course) }}" class="btn btn-sm btn-primary-soft me-1 mb-1 mb-md-0"><i class="bi bi-play-circle me-1"></i>Classroom</a>
                                    @else
                                        <a href="{{ route('courses.detail', $course) }}" class="btn btn-sm btn-outline-secondary me-1 mb-1 mb-md-0">View course</a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">You have not enrolled in any courses yet. <a href="{{ route('courses.index') }}">Browse courses</a></td>
                            </tr>
                        @endforelse
                    </tbody>
                    <!-- Table body END -->
                </table>
            </div>
            <!-- Course list table END -->

            @if(isset($enrollments) && $enrollments->count() > 0)
            <div class="d-sm-flex justify-content-sm-between align-items-sm-center mt-4 mt-sm-3">
                <p class="mb-0 text-center text-sm-start">Showing {{ $enrollments->count() }} enrolled course(s)</p>
            </div>
            @endif
        </div>
        <!-- Card body START -->
    </div>
    <!-- Main content END -->
</div>
@endsection
