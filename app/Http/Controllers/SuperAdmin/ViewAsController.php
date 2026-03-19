<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ViewAsController extends Controller
{
    /**
     * Set "view as" user and redirect to their role dashboard.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'role' => ['required', 'string', 'in:Admin,Instructor,Student'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
        ]);

        $user = User::with('role')->findOrFail($validated['user_id']);

        if ($user->role?->name !== $validated['role']) {
            return back()->withErrors(['user_id' => 'Selected user is not a ' . $validated['role'] . '.']);
        }

        $request->session()->put('view_as_user_id', $user->id);

        $url = match ($validated['role']) {
            'Admin' => route('admin.dashboard'),
            'Instructor' => route('instructor.dashboard'),
            'Student' => route('student.dashboard'),
            default => route('super-admin.dashboard'),
        };

        return redirect()->away($url);
    }

    /**
     * Clear "view as" and return to Super Admin dashboard.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->session()->forget('view_as_user_id');

        return redirect()->route('super-admin.dashboard');
    }
}
