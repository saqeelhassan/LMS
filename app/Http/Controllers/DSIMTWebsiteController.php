<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\CareerApplication;
use App\Models\ContactMessage;
use App\Models\Course;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DSIMTWebsiteController extends Controller
{
    public function index()
    {
        $courses = Course::publishedOnWebsite()
            ->with(['instructor', 'courseMode'])
            ->withCount('enrollments')
            ->latest()
            ->take(6)
            ->get();
        return view('DSIMT-Webiste.index', compact('courses'));
    }

    public function about()
    {
        return view('DSIMT-Webiste.about');
    }

    public function contact()
    {
        return view('DSIMT-Webiste.contact');
    }

    /**
     * Store contact form submission from the website (saved for admin to view/delete).
     */
    public function storeContact(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        ContactMessage::create($validated);

        return redirect()->route('dsimt.contact')->with('success', 'Thank you. Your message has been sent.');
    }

    /**
     * Career page: show job application form.
     */
    public function career()
    {
        return view('DSIMT-Webiste.career');
    }

    /**
     * Store job application from the website (saved for admin in Website Operations).
     */
    public function storeCareer(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'position' => ['nullable', 'string', 'max:255'],
            'message' => ['nullable', 'string', 'max:5000'],
            'resume' => ['required', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
        ], [
            'resume.required' => 'Please upload your resume (PDF or DOC).',
            'resume.mimes' => 'Resume must be PDF, DOC or DOCX.',
            'resume.max' => 'Resume must not exceed 5 MB.',
        ]);

        $path = $request->file('resume')->store('career-resumes', 'public');

        CareerApplication::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'position' => $validated['position'] ?? null,
            'message' => $validated['message'] ?? null,
            'resume_path' => $path,
        ]);

        return redirect()->route('dsimt.career')->with('success', 'Your application has been submitted. We will get back to you soon.');
    }

    /**
     * Public website Courses page: fetch courses visible on website (approved + draft).
     * Instructor-created courses start as draft; this scope shows them so the list is not empty.
     * Eager load instructor and courseMode so the page stays fast as course count grows.
     */
    public function allCourses()
    {
        $courses = Course::visibleOnWebsite()
            ->with(['instructor.userDetail', 'courseMode'])
            ->withCount('enrollments')
            ->latest()
            ->get();

        return view('DSIMT-Webiste.courses', compact('courses'));
    }

    /**
     * DSIMT prefix: same course list (delegates to allCourses for consistency).
     * Pass useDsimtDetailUrl so course links go to /dsimt/course/{id} and work correctly.
     */
    public function course()
    {
        $courses = Course::visibleOnWebsite()
            ->with(['instructor.userDetail', 'courseMode'])
            ->withCount('enrollments')
            ->latest()
            ->get();

        return view('DSIMT-Webiste.courses', compact('courses'))->with('useDsimtDetailUrl', true);
    }

    public function courseDetail(Course $course)
    {
        if (! $course->isVisibleOnWebsite()) {
            abort(404);
        }
        $course->load(['courseMode', 'instructor.userDetail', 'contents' => fn ($q) => $q->orderBy('sort_order')])
            ->loadCount('enrollments');
        $relatedCourses = Course::visibleOnWebsite()
            ->where('id', '!=', $course->id)
            ->with(['courseMode', 'instructor.userDetail'])
            ->withCount('enrollments')
            ->latest()
            ->take(3)
            ->get();
        $useDsimtDetailUrl = request()->is('dsimt/course*');
        return view('DSIMT-Webiste.course-detail', compact('course', 'relatedCourses', 'useDsimtDetailUrl'));
    }

    public function event()
    {
        $events = Event::published()->latest('event_date')->paginate(9)->withQueryString();
        return view('DSIMT-Webiste.event', compact('events'));
    }

    public function eventDetail(Event $event)
    {
        return view('DSIMT-Webiste.event-detail', compact('event'));
    }

    /**
     * Fetching all published blogs for the public blog listing.
     */
    public function blogList()
    {
        $blogs = Blog::published()->with('author.userDetail')->latest()->paginate(9)->withQueryString();
        return view('DSIMT-Webiste.blog.index', compact('blogs'));
    }

    /**
     * Single blog article (resolved by slug from route).
     */
    public function blogShow(Blog $blog)
    {
        if ($blog->status !== Blog::STATUS_PUBLISHED) {
            abort(404);
        }
        $blog->load('author.userDetail');
        return view('DSIMT-Webiste.blog.show', compact('blog'));
    }

    /**
     * Government-funded program page (PITP, NAVTTC, BBSHRRDA). Public info page per program.
     */
    public function govtFunded(string $program)
    {
        $programs = [
            'pitp' => ['name' => 'PITP', 'title' => 'PITP – Government Funded Program'],
            'navttc' => ['name' => 'NAVTTC', 'title' => 'NAVTTC – Government Funded Program'],
            'bbshrrda' => ['name' => 'BBSHRRDA', 'title' => 'BBSHRRDA – Government Funded Program'],
        ];
        $current = $programs[$program] ?? null;
        if (! $current) {
            abort(404);
        }
        return view('DSIMT-Webiste.govt-funded', compact('program', 'current', 'programs'));
    }

    public function gallery()
    {
        return view('DSIMT-Webiste.gallery');
    }

    /**
     * Our Team: Instructors and Admins from LMS (active only).
     * New users with these roles appear automatically.
     */
    public function instructors()
    {
        $team = User::whereHas('role', fn ($q) => $q->whereIn('name', ['Instructor', 'Admin']))
            ->where('is_active', true)
            ->with(['userDetail', 'role'])
            ->get();

        $order = ['Admin' => 0, 'Instructor' => 1];
        $team = $team->sort(function ($a, $b) use ($order) {
            $aOrder = $order[$a->role->name ?? ''] ?? 3;
            $bOrder = $order[$b->role->name ?? ''] ?? 3;
            if ($aOrder !== $bOrder) {
                return $aOrder <=> $bOrder;
            }
            return strcasecmp($a->name, $b->name);
        })->values();

        return view('DSIMT-Webiste.instructors', compact('team'));
    }

    public function pricing()
    {
        return view('DSIMT-Webiste.pricing');
    }

    public function testimonial()
    {
        return view('DSIMT-Webiste.testimonial');
    }

    public function faq()
    {
        return view('DSIMT-Webiste.faq');
    }

    public function search()
    {
        $query = request('q', '');
        $courses = Course::where('name', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->with('courseMode')->latest()->paginate(12)->withQueryString();
        return view('DSIMT-Webiste.search', compact('courses', 'query'));
    }


    public function searchDetail()
    {
        return view('DSIMT-Webiste.search-detail');
    }

    public function commingSoon()
    {
        return view('DSIMT-Webiste.comming');
    }

    public function error404()
    {
        return view('DSIMT-Webiste.404');
    }
}
