{{-- Course card partial - expects $course (App\Models\Course) --}}
<div class="col-sm-6 col-lg-3">
    <div class="card shadow h-100">
        <img src="{{ $course->image_url }}" class="card-img-top" alt="{{ $course->name }}">
        <div class="card-body pb-0">
            <div class="d-flex justify-content-between mb-2">
                <a href="{{ route('courses.detail', $course) }}" class="badge bg-primary">{{ $course->courseMode?->name ?? '—' }}</a>
                <a href="#" class="h6 fw-light mb-0"><i class="far fa-heart"></i></a>
            </div>
            <h5 class="card-title">
                <a href="{{ route('courses.detail', $course) }}">{{ $course->name }}</a>
            </h5>
            <p class="mb-2 text-truncate-2">{{ Str::limit($course->description, 80) ?: 'No description.' }}</p>
            <ul class="list-inline mb-0">
                <li class="list-inline-item me-0 small"><i class="fas fa-star text-warning"></i></li>
                <li class="list-inline-item me-0 small"><i class="fas fa-star text-warning"></i></li>
                <li class="list-inline-item me-0 small"><i class="fas fa-star text-warning"></i></li>
                <li class="list-inline-item me-0 small"><i class="fas fa-star text-warning"></i></li>
                <li class="list-inline-item me-0 small"><i class="far fa-star text-warning"></i></li>
                <li class="list-inline-item ms-2 h6 fw-light mb-0">{{ $course->enrollments_count ?? 0 }} enrolled</li>
            </ul>
        </div>
        <div class="card-footer pt-0 pb-3">
            <hr>
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    @if($course->total_lectures || $course->total_hours)
                        @if($course->total_lectures)
                            <span class="h6 fw-light me-3"><i class="fas fa-play-circle text-info me-1"></i>{{ $course->total_lectures }} lectures</span>
                        @endif
                        @if($course->total_hours)
                            <span class="h6 fw-light"><i class="far fa-clock text-danger me-1"></i>{{ $course->total_hours }}</span>
                        @endif
                    @else
                        <span class="h6 fw-light text-muted">Course details</span>
                    @endif
                </div>
                <a href="{{ route('courses.detail', $course) }}" class="btn btn-sm btn-primary">View Details</a>
            </div>
        </div>
    </div>
</div>
