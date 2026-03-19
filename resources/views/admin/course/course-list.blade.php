@extends('layouts.admin')

@section('content')
<div class="row page-titles mx-0 mb-3">
    <div class="col-sm-6 p-md-0">
        <div class="welcome-text">
            <h4>All Courses</h4>
        </div>
    </div>
    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.courses.index') }}">Courses</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0);">All Courses</a></li>
            </ol>
        </nav>
        @if(auth()->user()->role?->name === 'SuperAdmin' || auth()->user()->hasAdminPermission('courses.create'))
        <a href="{{ route('admin.courses.create') }}" class="btn btn-primary btn-sm ms-3">+ Add new</a>
        @endif
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success mb-3">{{ session('success') }}</div>
@endif

<!-- Search -->
<div class="row mb-3">
    <div class="col-md-6">
        <form method="get" action="{{ route('admin.courses.index') }}" class="d-flex">
            <input class="form-control" type="search" name="q" placeholder="Search courses..." value="{{ request('q') }}">
            <button class="btn btn-primary ms-2" type="submit"><i class="fa fa-search"></i></button>
        </form>
    </div>
</div>

<div class="row">
    @forelse($courses as $course)
    <div class="col-xl-3 col-xxl-4 col-lg-4 col-md-6 col-sm-6">
        <div class="card">
            <img class="img-fluid rounded-top" src="{{ $course->image_url }}" alt="{{ $course->name }}" style="object-fit:cover;height:180px;">
            <div class="card-body">
                <h4 class="card-title">{{ $course->name }}</h4>
                <ul class="list-group mb-3 list-group-flush">
                    <li class="list-group-item px-0 border-top-0 d-flex justify-content-between">
                        <span class="mb-0">{{ $course->release_date ? $course->release_date->format('d M Y') : ($course->created_at?->format('d M Y') ?? '—') }}</span>
                        <span class="text-muted">{{ $course->enrollments_count ?? 0 }} enrolled</span>
                    </li>
                    <li class="list-group-item px-0 d-flex justify-content-between">
                        <span class="mb-0">Duration :</span>
                        <strong>{{ $course->total_hours ?? '—' }}</strong>
                    </li>
                    <li class="list-group-item px-0 d-flex justify-content-between">
                        <span class="mb-0">Professor :</span>
                        <strong>{{ $course->instructor?->name ?? '—' }}</strong>
                    </li>
                    <li class="list-group-item px-0 d-flex justify-content-between">
                        <span><i class="fa fa-graduation-cap text-primary me-2"></i>Students</span>
                        <strong>{{ $course->enrollments_count ?? 0 }}</strong>
                    </li>
                </ul>
                <div class="d-flex flex-wrap gap-1">
                    <a href="{{ route('admin.courses.show', $course) }}" class="btn btn-primary btn-sm">Read More</a>
                    @if(auth()->user()->role?->name === 'SuperAdmin' || auth()->user()->hasAdminPermission('courses.create'))
                    <a href="{{ route('admin.courses.edit', $course) }}" class="btn btn-outline-primary btn-sm">Edit</a>
                    @endif
                    @if(auth()->user()->role?->name === 'SuperAdmin' || auth()->user()->hasAdminPermission('courses.manage'))
                    <form action="{{ route('admin.courses.destroy', $course) }}" method="post" class="d-inline" onsubmit="return confirm('Delete this course? This will remove enrollments, batches, and related data.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="card">
            <div class="card-body text-center py-5 text-muted">
                <p class="mb-0">No courses found.</p>
                @if(auth()->user()->role?->name === 'SuperAdmin' || auth()->user()->hasAdminPermission('courses.create'))
                <a href="{{ route('admin.courses.create') }}" class="btn btn-primary mt-3">Add course</a>
                @endif
            </div>
        </div>
    </div>
    @endforelse
</div>

@if($courses->hasPages())
<div class="d-flex justify-content-center mt-4">
    {{ $courses->withQueryString()->links() }}
</div>
@endif
@endsection
