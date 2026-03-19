@extends('layouts.super-admin')

@section('content')
<div class="row page-titles mx-0">
    <div class="col-sm-6 p-md-0">
        <div class="welcome-text">
            <h4>Course Approvals</h4>
        </div>
    </div>
    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('super-admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0);">Course Approvals</a></li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-xl-12 col-xxl-12 col-sm-12">
        <div class="card">
            <div class="card-header d-flex flex-wrap align-items-center gap-2">
                <h5 class="card-title mb-0">Courses</h5>
                @if($pendingCount > 0)
                    <span class="badge badge-rounded badge-warning ms-2">{{ $pendingCount }} pending</span>
                @endif
                <div class="btn-group btn-group-sm ms-auto">
                    <a href="{{ route('super-admin.course-approval.index', ['filter' => 'pending']) }}" class="btn btn-{{ $filter === 'pending' ? 'warning' : 'outline-secondary' }}">Pending</a>
                    <a href="{{ route('super-admin.course-approval.index', ['filter' => 'approved']) }}" class="btn btn-{{ $filter === 'approved' ? 'success' : 'outline-secondary' }}">Approved</a>
                    <a href="{{ route('super-admin.course-approval.index', ['filter' => 'rejected']) }}" class="btn btn-{{ $filter === 'rejected' ? 'danger' : 'outline-secondary' }}">Rejected</a>
                </div>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success mb-3 rounded">{{ session('success') }}</div>
                @endif
                @if(session('info'))
                    <div class="alert alert-info mb-3 rounded">{{ session('info') }}</div>
                @endif
                <div class="table-responsive">
                    <table class="table header-border table-hover verticle-middle">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Course</th>
                                <th scope="col">Instructor</th>
                                <th scope="col">Content</th>
                                <th scope="col">Submitted</th>
                                <th scope="col">Status</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($courses as $course)
                                <tr>
                                    <th>{{ $loop->iteration + ($courses->currentPage() - 1) * $courses->perPage() }}</th>
                                    <td>
                                        <strong>{{ $course->name }}</strong>
                                        @if($course->publication_status === 'rejected')
                                            <br><small class="text-danger">Rejected {{ $course->rejected_at?->format('M j, Y') }}</small>
                                        @endif
                                    </td>
                                    <td>{{ $course->instructor?->name ?? $course->instructor?->email ?? '—' }}</td>
                                    <td>{{ $course->contents->count() }} item(s)</td>
                                    <td>{{ $course->submitted_for_approval_at?->format('M j, Y H:i') ?? '—' }}</td>
                                    <td>
                                        @if($course->publication_status === 'pending_approval')
                                            <span class="badge badge-rounded badge-warning">Pending</span>
                                        @elseif($course->publication_status === 'approved')
                                            <span class="badge badge-rounded badge-success">Approved</span>
                                        @else
                                            <span class="badge badge-rounded badge-danger">Rejected</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($course->publication_status === 'pending_approval')
                                            <form method="post" action="{{ route('super-admin.course-approval.approve', $course) }}" class="d-inline">@csrf<button type="submit" class="btn btn-sm btn-success">Approve</button></form>
                                            <form method="post" action="{{ route('super-admin.course-approval.reject', $course) }}" class="d-inline" onsubmit="return confirm('Reject this course outline?');">@csrf<button type="submit" class="btn btn-sm btn-outline-danger">Reject</button></form>
                                        @else
                                            —
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="7" class="text-center text-muted py-4">No courses in this filter.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($courses->hasPages())
                    <div class="d-flex justify-content-center mt-3">{{ $courses->withQueryString()->links() }}</div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
