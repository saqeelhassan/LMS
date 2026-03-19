@extends('layouts.admin')

@section('content')
<!-- Title -->
<div class="row mb-3">
    <div class="col-12 d-sm-flex justify-content-between align-items-center">
        <h1 class="h3 mb-2 mb-sm-0">Courses by Category <span class="badge bg-orange bg-opacity-10 text-orange">{{ $courses->total() }}</span></h1>
        @if(auth()->user()->role?->name === 'SuperAdmin' || auth()->user()->hasAdminPermission('courses.create'))
        <a href="{{ route('admin.courses.create') }}" class="btn btn-sm btn-primary mb-0">Add course</a>
        @endif
    </div>
</div>

<!-- Card START -->
<div class="card bg-transparent border">
    <!-- Card header START -->
    <div class="card-header bg-light border-bottom">
        <div class="row g-3 align-items-center justify-content-between">
            <div class="col-md-6">
                <form class="rounded position-relative d-flex gap-2" method="get" action="{{ route('admin.courses.index') }}">
                    <input type="hidden" name="mode" value="{{ request('mode') }}">
                    <input class="form-control bg-body" type="search" name="q" placeholder="Search courses" value="{{ request('q') }}">
                    <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                </form>
            </div>
            <div class="col-md-4">
                <form method="get" action="{{ route('admin.courses.index') }}" id="categoryFilterForm">
                    <input type="hidden" name="q" value="{{ request('q') }}">
                    <select name="mode" class="form-select border-0 z-index-9" aria-label="Category" onchange="this.form.submit()">
                        <option value="">All categories</option>
                        @foreach($courseModes as $mode)
                        <option value="{{ $mode->id }}" {{ (string) request('mode') === (string) $mode->id ? 'selected' : '' }}>{{ $mode->name }} ({{ $mode->courses_count }})</option>
                        @endforeach
                    </select>
                </form>
            </div>
        </div>
    </div>
    <!-- Card header END -->

    <!-- Card body START -->
    <div class="card-body">
        <div class="table-responsive border-0 rounded-3">
            <table class="table table-dark-gray align-middle p-4 mb-0 table-hover">
                <thead>
                    <tr>
                        <th scope="col" class="border-0 rounded-start">Course Name</th>
                        <th scope="col" class="border-0">Category</th>
                        <th scope="col" class="border-0">Instructor</th>
                        <th scope="col" class="border-0">Enrolled</th>
                        <th scope="col" class="border-0 rounded-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($courses as $course)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center position-relative">
                                <div class="w-60px">
                                    <img src="{{ $course->image_url }}" class="rounded" alt="">
                                </div>
                                <h6 class="table-responsive-title mb-0 ms-2">
                                    <a href="{{ route('admin.courses.show', $course) }}" class="stretched-link">{{ $course->name }}</a>
                                </h6>
                            </div>
                        </td>
                        <td><span class="badge bg-primary bg-opacity-10 text-primary">{{ $course->courseMode?->name ?? '—' }}</span></td>
                        <td>
                            @if($course->instructor)
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-xs flex-shrink-0">
                                    @if($course->instructor->avatar_url)
                                        <img class="avatar-img rounded-circle" src="{{ $course->instructor->avatar_url }}" alt="">
                                    @else
                                        <div class="avatar-img rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center w-100 h-100 small">{{ substr($course->instructor->name ?? 'I', 0, 1) }}</div>
                                    @endif
                                </div>
                                <div class="ms-2"><h6 class="mb-0 fw-light">{{ $course->instructor->name ?? $course->instructor->email }}</h6></div>
                            </div>
                            @else
                            <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>{{ number_format($course->enrollments_count ?? 0) }}</td>
                        <td>
                            @if(auth()->user()->role?->name === 'SuperAdmin' || auth()->user()->hasAdminPermission('courses.create'))
                            <a href="{{ route('admin.courses.edit', $course) }}" class="btn btn-sm btn-success me-1 mb-1 mb-md-0">Edit</a>
                            @endif
                            <a href="{{ route('admin.courses.show', $course) }}" class="btn btn-sm btn-dark mb-0">View</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">No courses found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <!-- Card body END -->

    @if($courses->hasPages())
    <div class="card-footer bg-transparent pt-0">
        <div class="d-sm-flex justify-content-sm-between align-items-sm-center">
            <p class="mb-0 text-center text-sm-start">Showing {{ $courses->firstItem() ?? 0 }} to {{ $courses->lastItem() ?? 0 }} of {{ $courses->total() }} entries</p>
            <nav class="d-flex justify-content-center mb-0">{{ $courses->links() }}</nav>
        </div>
    </div>
    @endif
</div>
<!-- Card END -->
@endsection
