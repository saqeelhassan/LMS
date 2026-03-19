@extends('layouts.student')

@section('content')
<div>
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('student.events.index') }}">Events</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($event->title, 40) }}</li>
        </ol>
    </nav>

    <div class="card border rounded-3 mb-4 overflow-hidden">
        @if($event->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($event->image))
        <img src="{{ asset('storage/' . $event->image) }}" class="card-img-top" alt="{{ $event->title }}" style="max-height:320px;object-fit:cover;">
        @endif
        <div class="card-body p-4">
            <h1 class="h3 mb-3">{{ $event->title }}</h1>
            <div class="d-flex flex-wrap gap-3 text-muted mb-3">
                @if($event->event_date)
                <span><i class="bi bi-calendar3 me-1"></i>{{ $event->event_date->format('l, F j, Y') }} @if($event->event_date->format('H:i') !== '00:00'){{ $event->event_date->format('g:i A') }}@endif</span>
                @endif
                @if($event->location)
                <span><i class="bi bi-geo-alt me-1"></i>{{ $event->location }}</span>
                @endif
            </div>
            @if($event->description)
            <div class="event-description">
                {!! nl2br(e($event->description)) !!}
            </div>
            @endif
        </div>
    </div>

    @if($related->isNotEmpty())
    <div class="card border rounded-3">
        <div class="card-header bg-transparent border-bottom">
            <h5 class="mb-0">Related Events</h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                @foreach($related as $r)
                <div class="col-md-4">
                    <div class="d-flex gap-3 align-items-start">
                        @if($r->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($r->image))
                        <img src="{{ asset('storage/' . $r->image) }}" alt="" class="rounded" style="width:80px;height:60px;object-fit:cover;">
                        @else
                        <div class="bg-primary bg-opacity-10 rounded d-flex align-items-center justify-content-center" style="width:80px;height:60px;">
                            <i class="bi bi-calendar-event text-primary"></i>
                        </div>
                        @endif
                        <div class="flex-grow-1 min-w-0">
                            <a href="{{ route('student.events.show', $r) }}" class="text-dark text-decoration-none fw-medium">{{ Str::limit($r->title, 50) }}</a>
                            <div class="small text-muted">
                                @if($r->event_date){{ $r->event_date->format('M d, Y') }}@endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
