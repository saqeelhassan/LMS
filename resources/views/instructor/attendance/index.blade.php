@extends('layouts.account', ['account' => 'instructor'])

@section('content')
<div class="col-xl-9">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <a href="{{ route('instructor.manage-course') }}" class="text-body small d-block mb-1"><i class="bi bi-arrow-left me-1"></i>Back to courses</a>
            <h1 class="h3 mb-1">Attendance: {{ $course->name }}</h1>
            <p class="mb-0 text-body">Take attendance and view past sessions.</p>
        </div>
        <a href="{{ route('instructor.attendance.take', $course) }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>Take attendance</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border rounded-3">
        <div class="card-header bg-light">
            <h5 class="mb-0">Recent attendance sessions</h5>
        </div>
        <div class="card-body">
            @if($dates->isNotEmpty())
                <div class="list-group list-group-flush">
                    @foreach($dates as $d)
                    <a href="{{ route('instructor.attendance.view', [$course, $d->date]) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-calendar3 me-2"></i>{{ \Carbon\Carbon::parse($d->date)->format('l, M d, Y') }} <span class="badge bg-{{ $d->type === 'online' ? 'info' : 'secondary' }}">{{ ucfirst($d->type) }}</span></span>
                        <i class="bi bi-chevron-right"></i>
                    </a>
                    @endforeach
                </div>
            @else
                <p class="mb-0 text-body">No attendance recorded yet. <a href="{{ route('instructor.attendance.take', $course) }}">Take attendance</a> for today.</p>
            @endif
        </div>
    </div>
</div>
@endsection
