@php
    $instructor = auth()->user();
    $myCourseIds = \App\Models\Course::where('instructor_id', $instructor->id)->pluck('id');
    $instructorCourseCount = $myCourseIds->count();
    $instructorEnrollmentCount = $myCourseIds->isEmpty() ? 0 : \App\Models\Enrollment::whereIn('course_id', $myCourseIds)->count();
    $avatarNum = ($instructor->id % 5) + 1;
@endphp
<div class="container mt-n4">
    <div class="row">
        <!-- Profile banner START -->
        <div class="col-12">
            <div class="card bg-transparent card-body p-0">
                <div class="row d-flex justify-content-between">
                    <!-- Avatar -->
                    <div class="col-auto mt-4 mt-md-0">
                        <div class="avatar avatar-xxl mt-n3">
                            @if($instructor->avatar_url)
                                <img class="avatar-img rounded-circle border border-white border-3 shadow" src="{{ $instructor->avatar_url }}" alt="{{ $instructor->name }}">
                            @else
                                <img class="avatar-img rounded-circle border border-white border-3 shadow" src="/images/avatar/{{ sprintf('%02d', $avatarNum) }}.jpg" alt="{{ $instructor->name }}">
                            @endif
                        </div>
                    </div>
                    <!-- Profile info -->
                    <div class="col d-md-flex justify-content-between align-items-center mt-4">
                        <div>
                            <h1 class="my-1 fs-4">{{ $instructor->name }} <i class="bi bi-patch-check-fill text-info small"></i></h1>
                            <ul class="list-inline mb-0">
                                <li class="list-inline-item h6 fw-light me-3 mb-1 mb-sm-0"><i class="fas fa-user-graduate text-orange me-2"></i>{{ number_format($instructorEnrollmentCount) }} Enrolled Students</li>
                                <li class="list-inline-item h6 fw-light me-3 mb-1 mb-sm-0"><i class="fas fa-book text-purple me-2"></i>{{ $instructorCourseCount }} Courses</li>
                            </ul>
                        </div>
                        <!-- Button -->
                        <div class="d-flex align-items-center mt-2 mt-md-0">
                            <a href="{{ route('instructor.courses.create') }}" class="btn btn-success mb-0">Create a course</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Profile banner END -->

            <!-- Advanced filter responsive toggler START -->
            <!-- Divider -->
            <hr class="d-xl-none">
            <div class="col-12 col-xl-3 d-flex justify-content-between align-items-center">
                <a class="h6 mb-0 fw-bold d-xl-none" href="#">Menu</a>
                <button class="btn btn-primary d-xl-none" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasSidebar" aria-controls="offcanvasSidebar">
                    <i class="fas fa-sliders-h"></i>
                </button>
            </div>
            <!-- Advanced filter responsive toggler END -->
        </div>
    </div>
</div>