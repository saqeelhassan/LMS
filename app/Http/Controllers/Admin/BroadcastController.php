<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Broadcast;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BroadcastController extends Controller
{
    public function index(): View
    {
        $broadcasts = Broadcast::with('creator')->latest()->paginate(15);

        return view('admin.broadcasts.index', compact('broadcasts'));
    }

    public function create(): View
    {
        return view('admin.broadcasts.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:1000'],
            'channel' => ['required', 'string', 'in:sms,whatsapp'],
            'target' => ['required', 'string', 'in:all_students'],
        ]);

        $broadcast = Broadcast::create([
            ...$validated,
            'target_id' => null,
            'created_by' => auth()->id(),
        ]);

        // Placeholder: actual SMS/WhatsApp API integration would go here
        // For now, we just store the broadcast and mark as "sent" (or leave scheduled)
        // $broadcast->update(['sent_at' => now()]);

        return redirect()->route('admin.broadcasts.index')->with('success', 'Broadcast created. (SMS/WhatsApp API integration required for actual delivery.)');
    }
}
