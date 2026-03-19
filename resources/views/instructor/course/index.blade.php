@extends('layouts.super-admin')

@section('title', 'My Courses')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">My Courses</h4>
                    <a href="{{ route('instructor.courses.create') }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-plus"></i> Add New Course
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Course</th>
                                    <th>Mode</th>
                                    <th>Status</th>
                                    <th>Enrolled</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($courses as $course)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $course->image_url }}" alt="{{ $course->name }}" class="rounded me-3" width="50" height="50" style="object-fit: cover;">
                                            <div>
                                                <h6 class="mb-0">{{ $course->name }}</h6>
                                                <small class="text-muted">{{ $course->total_lectures ?? 0 }} lectures</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="badge bg-primary">{{ $course->courseMode?->name ?? '—' }}</span></td>
                                    <td>
                                        @php $ps = $course->publication_status ?? 'approved'; @endphp
                                        @if($ps === 'approved')
                                            <span class="badge bg-success" title="Published on website">Approved</span>
                                        @elseif($ps === 'pending_approval')
                                            <span class="badge bg-warning" title="Awaiting Super Admin approval">Pending</span>
                                        @elseif($ps === 'rejected')
                                            <span class="badge bg-danger" title="Rejected – resubmit from Content">Rejected</span>
                                        @else
                                            <span class="badge bg-secondary" title="Draft – submit from Content">Draft</span>
                                        @endif
                                    </td>
                                    <td>{{ number_format($course->enrollments_count) }}</td>
                                    <td>
                                        <div class="d-flex gap-1 flex-wrap">
                                            @if($course->live_class_url)
                                                <a href="{{ $course->live_class_url }}" target="_blank" class="btn btn-sm btn-danger" title="Start Zoom/Meet Class"><i class="bi bi-camera-video"></i> Live</a>
                                            @endif
                                            <a href="{{ route('instructor.courses.edit', $course) }}" class="btn btn-sm btn-outline-primary" title="Edit"><i class="far fa-edit"></i></a>
                                            <a href="{{ route('instructor.content.index', $course) }}" class="btn btn-sm btn-outline-secondary" title="Content"><i class="bi bi-file-earmark"></i></a>
                                            <a href="{{ route('instructor.assignments.index', $course) }}" class="btn btn-sm btn-outline-primary" title="Assignments"><i class="bi bi-journal-check"></i></a>
                                            <a href="{{ route('instructor.exams.index', $course) }}" class="btn btn-sm btn-outline-info" title="Exams"><i class="bi bi-journal-text"></i></a>
                                            <a href="{{ route('instructor.attendance.index', $course) }}" class="btn btn-sm btn-outline-success" title="Attendance"><i class="bi bi-person-check"></i></a>
                                            <a href="{{ route('instructor.progress.index', $course) }}" class="btn btn-sm btn-outline-warning" title="Progress"><i class="bi bi-graph-up"></i></a>
                                            <form method="post" action="{{ route('instructor.courses.destroy', $course) }}" class="d-inline" onsubmit="return confirm('Delete this course?');">@csrf @method('DELETE')<button type="submit" class="btn btn-sm btn-outline-danger" title="Delete"><i class="far fa-trash-alt"></i></button></form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-body">No courses yet. <a href="{{ route('instructor.courses.create') }}">Create your first course</a>.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($courses->hasPages())
                        <div class="d-flex justify-content-center mt-3">{{ $courses->links() }}</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
