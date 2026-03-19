<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DefaulterController extends Controller
{
    public function index(): View
    {
        $defaulters = Invoice::with(['user.userDetail', 'enrollment.course'])
            ->whereIn('status', ['pending', 'partial', 'overdue'])
            ->whereRaw('amount - amount_paid > 0')
            ->get()
            ->unique('user_id')
            ->sortByDesc(fn ($i) => $i->balance)
            ->values();

        return view('admin.defaulters.index', compact('defaulters'));
    }

    public function disableAccess(User $user): RedirectResponse
    {
        $user->update(['is_active' => false]);

        return back()->with('success', "LMS access disabled for {$user->email}");
    }

    public function enableAccess(User $user): RedirectResponse
    {
        $user->update(['is_active' => true]);

        return back()->with('success', "LMS access enabled for {$user->email}");
    }
}
