@extends('layouts.admin')

@section('content')
<div class="row page-titles mx-0 mb-3">
    <div class="col-sm-6 p-md-0">
        <div class="welcome-text">
            <h4>About Courses</h4>
        </div>
    </div>
    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.courses.index') }}">Courses</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0);">About Courses</a></li>
            </ol>
        </nav>
    </div>
</div>

<div class="row">
    <div class="col-xl-3 col-xxl-4 col-lg-4">
        <div class="row">
            @if($courses->isNotEmpty())
            <div class="col-lg-12">
                <div class="card">
                    @if($courses->first()->thumbnail)
                        <img class="img-fluid" src="{{ asset('storage/' . $courses->first()->thumbnail) }}" alt="">
                    @else
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height:180px;"><i class="la la-graduation-cap fa-4x text-muted"></i></div>
                    @endif
                    <div class="card-body">
                        <h4 class="mb-0">{{ $courses->first()->name }}</h4>
                    </div>
                </div>
            </div>
            @endif
            <div class="col-lg-12">
                <div class="card overflow-hidden">
                    <div class="card-header">
                        <h2 class="card-title">About Course</h2>
                    </div>
                    <div class="card-body pb-0">
                        <p class="mb-3">Overview of your course program and statistics.</p>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex px-0 justify-content-between">
                                <strong>Total Courses</strong>
                                <span class="mb-0">{{ $totalCourses }}</span>
                            </li>
                            <li class="list-group-item d-flex px-0 justify-content-between">
                                <strong>Enrollments</strong>
                                <span class="mb-0">{{ $totalEnrollments }}</span>
                            </li>
                            <li class="list-group-item d-flex px-0 justify-content-between">
                                <strong>Batches</strong>
                                <span class="mb-0">{{ $totalBatches }}</span>
                            </li>
                        </ul>
                    </div>
                    <div class="card-footer pt-0 pb-0 text-center">
                        <div class="row">
                            <div class="col-4 pt-3 pb-3 border-end">
                                <h3 class="mb-1 text-primary">{{ $totalCourses }}</h3>
                                <span>Courses</span>
                            </div>
                            <div class="col-4 pt-3 pb-3 border-end">
                                <h3 class="mb-1 text-primary">{{ $totalEnrollments }}</h3>
                                <span>Students</span>
                            </div>
                            <div class="col-4 pt-3 pb-3">
                                <h3 class="mb-1 text-primary">{{ $totalBatches }}</h3>
                                <span>Batches</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-9 col-xxl-8 col-lg-8">
        <div class="card">
            <div class="card-body">
                <p>Manage all your courses from this panel. You can add new courses, edit existing ones, view course details, and track enrollments and batches.</p>
                <p>Use <strong>All Courses</strong> to see the full list and search. Use <strong>Add Course</strong> to create a new course, and <strong>Edit Course</strong> from the list to update any course.</p>
                <h4 class="text-primary mt-4">Our Courses</h4>
                <div class="profile-skills pt-2 border-bottom-1 pb-2">
                    @forelse($courses as $c)
                    <a href="{{ route('admin.courses.show', $c) }}" class="btn btn-outline-dark btn-rounded px-4 my-3 my-sm-0 me-3 m-b-10">{{ $c->name }}</a>
                    @empty
                    <span class="text-muted">No courses yet. <a href="{{ route('admin.courses.create') }}">Add a course</a>.</span>
                    @endforelse
                </div>
                <div class="pt-4">
                    <a href="{{ route('admin.courses.index') }}" class="btn btn-primary">View All Courses</a>
                    @if(auth()->user()->role?->name === 'SuperAdmin' || auth()->user()->hasAdminPermission('courses.create'))
                    <a href="{{ route('admin.courses.create') }}" class="btn btn-outline-primary ms-2">Add Course</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
