@extends('layouts.student')

@section('content')
<div>
    <div class="mb-4">
        <h1 class="h3 mb-1">Events</h1>
        <p class="mb-0">Upcoming and past institute events.</p>
    </div>

    @if($events->isEmpty())
    <div class="card border rounded-3">
        <div class="card-body text-center py-5">
            <i class="bi bi-calendar-event display-4 text-muted mb-3"></i>
            <h5 class="mb-2">No events yet</h5>
            <p class="text-muted mb-0">Check back later for upcoming events.</p>
        </div>
    </div>
    @else
    <div class="row g-4">
        @foreach($events as $event)
        <div class="col-md-6 col-lg-4">
            <div class="card border rounded-3 h-100 overflow-hidden shadow-sm">
                @if($event->image)
                <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->exists($event->image) ? asset('storage/' . $event->image) : asset('images/courses/4by3/01.jpg') }}" class="card-img-top" alt="{{ $event->title }}" style="height:180px;object-fit:cover;">
                @else
                <div class="bg-primary bg-opacity-10 d-flex align-items-center justify-content-center" style="height:180px;">
                    <i class="bi bi-calendar-event display-4 text-primary opacity-50"></i>
                </div>
                @endif
                <div class="card-body">
                    <h5 class="card-title">
                        <a href="{{ route('student.events.show', $event) }}" class="text-dark text-decoration-none stretched-link">{{ $event->title }}</a>
                    </h5>
                    <div class="d-flex flex-wrap gap-2 small text-muted mb-2">
                        @if($event->event_date)
                        <span><i class="bi bi-calendar3 me-1"></i>{{ $event->event_date->format('M d, Y') }}</span>
                        @endif
                        @if($event->location)
                        <span><i class="bi bi-geo-alt me-1"></i>{{ Str::limit($event->location, 30) }}</span>
                        @endif
                    </div>
                    @if($event->description)
                    <p class="card-text small text-muted mb-0">{{ Str::limit(strip_tags($event->description), 100) }}</p>
                    @endif
                </div>
                <div class="card-footer bg-transparent border-top-0 pt-0">
                    <a href="{{ route('student.events.show', $event) }}" class="btn btn-sm btn-primary-soft">View details <i class="bi bi-arrow-right ms-1"></i></a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $events->links() }}
    </div>
    @endif
</div>
@endsection
