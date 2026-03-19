@extends('layouts.student')

@section('content')
<div class="row page-titles mx-0">
    <div class="col-sm-6 p-md-0">
        <div class="welcome-text">
            <h4>{{ $course->name }}</h4>
        </div>
    </div>
    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex align-items-center flex-wrap gap-2">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('student.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('student.course-resume') }}">Course Resume</a></li>
            <li class="breadcrumb-item active">{{ $course->name }}</li>
        </ol>
        @if($course->live_class_url)
            @if(isset($primaryBatch) && $primaryBatch)
                <a href="{{ route('student.live-join', $primaryBatch) }}" target="_blank" class="btn btn-sm btn-danger ms-2"><i class="bi bi-camera-video me-1"></i>Join Live Class</a>
            @else
                <a href="{{ $course->live_class_url }}" target="_blank" class="btn btn-sm btn-danger ms-2"><i class="bi bi-camera-video me-1"></i>Join Live Class</a>
            @endif
        @endif
    </div>
</div>

<div class="row">
    <div class="col-xl-12 col-xxl-12 col-sm-12">
        <p class="mb-4">Watch lectures, download notes, join live class.</p>
        @if($course->live_class_url && isset($primaryBatch) && $primaryBatch)
            <p class="small text-muted mb-4">Attendance is recorded; stay 15+ min to be marked Present.</p>
        @endif

        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Recorded lectures & resources</h5>
            </div>
            <div class="card-body">
                @forelse($course->contents as $c)
                @php $progress = $progressMap->get($c->id); @endphp
                <div class="d-flex justify-content-between align-items-center border-bottom py-3">
                    <div class="d-flex align-items-center">
                        @if($c->type === 'video')
                            <span class="btn btn-sm btn-success btn-round me-2"><i class="bi bi-play-fill"></i></span>
                        @elseif($c->type === 'pdf')
                            <span class="btn btn-sm btn-danger btn-round me-2"><i class="bi bi-file-pdf"></i></span>
                        @else
                            <span class="btn btn-sm btn-dark btn-round me-2"><i class="bi bi-code-slash"></i></span>
                        @endif
                        <div>
                            <h6 class="mb-0">{{ $c->title }}</h6>
                            <small class="text-muted">{{ ucfirst($c->type) }}</small>
                            @if($progress && $progress->completed)
                                <span class="badge bg-success ms-2">Done</span>
                            @endif
                        </div>
                    </div>
                    <div>
                        @if($c->url)
                            <a href="{{ $c->url }}" target="_blank" class="btn btn-sm btn-outline-primary me-1">Watch / Open</a>
                        @endif
                        @if($c->file_path)
                            <a href="{{ asset('storage/' . $c->file_path) }}" target="_blank" download class="btn btn-sm btn-outline-secondary">Download</a>
                        @endif
                    </div>
                </div>
                @empty
                <p class="mb-0">No content added yet. Check back later.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
