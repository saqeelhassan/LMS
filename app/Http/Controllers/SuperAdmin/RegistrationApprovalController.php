<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\RegistrationApproved;
use App\Notifications\RegistrationRejected;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RegistrationApprovalController extends Controller
{
    public function index(): View
    {
        $pendingRegistrations = User::with(['role', 'userDetail'])
            ->where('is_active', false)
            ->whereHas('role', fn ($q) => $q->whereIn('name', ['Student', 'Staff']))
            ->orderBy('created_at', 'desc')
            ->get();

        return view('super-admin.registrations.index', compact('pendingRegistrations'));
    }

    public function approve(Request $request, User $user): RedirectResponse
    {
        $this->authorizePending($user);

        $user->update(['is_active' => true]);

        $user->notify(new RegistrationApproved($user->role->name));

        return redirect()
            ->route('super-admin.registrations.index')
            ->with('success', "Registration approved: {$user->email}. User has been notified.");
    }

    public function reject(Request $request, User $user): RedirectResponse
    {
        $this->authorizePending($user);

        $email = $user->email;
        $roleName = $user->role->name;

        $user->notify(new RegistrationRejected($roleName));

        $user->userDetail?->delete();
        $user->forceDelete();

        return redirect()
            ->route('super-admin.registrations.index')
            ->with('success', "Registration rejected and removed: {$email}. User has been notified.");
    }

    private function authorizePending(User $user): void
    {
        $user->loadMissing('role');
        if (! $user->role || ! in_array($user->role->name, ['Student', 'Staff'], true)) {
            abort(403, 'Only pending Student or Staff registrations can be approved or rejected.');
        }
        if ($user->is_active) {
            abort(403, 'This registration is already approved.');
        }
    }
}
