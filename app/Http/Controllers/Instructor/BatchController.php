<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use Illuminate\View\View;

class BatchController extends Controller
{
    /**
     * My Batches: batches where the current user is the instructor.
     */
    public function index(): View
    {
        $batches = Batch::where('instructor_id', auth()->id())
            ->with(['course', 'branch'])
            ->withCount('enrollments')
            ->orderByDesc('is_active')
            ->latest()
            ->get();

        return view('instructor.batches.index', compact('batches'));
    }
}
