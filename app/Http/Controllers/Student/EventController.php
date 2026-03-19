<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EventController extends Controller
{
    /**
     * List published events for students.
     */
    public function index(Request $request): View
    {
        $events = Event::published()
            ->latest('event_date')
            ->paginate(12)
            ->withQueryString();

        return view('student.events.index', compact('events'));
    }

    /**
     * Show a single event.
     */
    public function show(Event $event): View
    {
        if (! $event->is_published) {
            abort(404);
        }

        $related = Event::published()
            ->where('id', '!=', $event->id)
            ->latest('event_date')
            ->take(3)
            ->get();

        return view('student.events.show', compact('event', 'related'));
    }
}
