<?php

namespace App\Http\Controllers;

use App\Models\Course;

class HomeController extends Controller
{
    public function index()
    {
        $courses = Course::with('courseMode')
            ->withCount('enrollments')
            ->latest()
            ->take(8)
            ->get();

        return view('index', compact('courses'));
    }
}
