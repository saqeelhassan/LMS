<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Inquiry;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InquiryController extends Controller
{
    public function index(Request $request): View
    {
        $inquiries = Inquiry::with('assignee.userDetail', 'branch')
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.inquiries.index', compact('inquiries'));
    }

    public function create(): View
    {
        $branches = Branch::where('is_active', true)->orderBy('name')->get();
        $courses = \App\Models\Course::orderBy('name')->pluck('name')->toArray();
        $staff = User::whereHas('role', fn ($q) => $q->whereIn('name', ['Admin', 'Staff']))->where('is_active', true)->with('userDetail')->orderBy('email')->get();

        return view('admin.inquiries.create', compact('branches', 'courses', 'staff'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'course_interest' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string', 'max:1000'],
            'branch_id' => ['nullable', 'integer', 'exists:branches,id'],
            'assigned_to' => ['nullable', 'integer', 'exists:users,id'],
        ]);

        Inquiry::create([...$validated, 'status' => 'new']);

        return redirect()->route('admin.inquiries.index')->with('success', 'Inquiry added.');
    }

    public function edit(Inquiry $inquiry): View
    {
        $branches = Branch::where('is_active', true)->orderBy('name')->get();
        $courses = \App\Models\Course::orderBy('name')->pluck('name')->toArray();
        $staff = User::whereHas('role', fn ($q) => $q->whereIn('name', ['Admin', 'Staff']))->where('is_active', true)->with('userDetail')->orderBy('email')->get();

        return view('admin.inquiries.edit', compact('inquiry', 'branches', 'courses', 'staff'));
    }

    public function update(Request $request, Inquiry $inquiry): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'course_interest' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'string', 'in:new,contacted,converted,lost'],
            'notes' => ['nullable', 'string', 'max:1000'],
            'branch_id' => ['nullable', 'integer', 'exists:branches,id'],
            'assigned_to' => ['nullable', 'integer', 'exists:users,id'],
        ]);

        $inquiry->update($validated);

        return redirect()->route('admin.inquiries.index')->with('success', 'Inquiry updated.');
    }

    public function convertForm(Inquiry $inquiry): View
    {
        $students = User::whereHas('role', fn ($q) => $q->where('name', 'Student'))->where('is_active', true)->with('userDetail')->orderBy('email')->get();

        return view('admin.inquiries.convert', compact('inquiry', 'students'));
    }

    public function convert(Inquiry $inquiry, Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'user_id' => ['required', 'integer', 'exists:users,id'],
        ]);

        $user = User::findOrFail($validated['user_id']);
        $inquiry->update([
            'status' => 'converted',
            'converted_to_user_id' => $user->id,
            'converted_at' => now(),
        ]);

        return redirect()->route('admin.inquiries.index')->with('success', "Inquiry converted to student: {$user->email}");
    }
}
