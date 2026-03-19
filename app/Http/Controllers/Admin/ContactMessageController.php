<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * Website Operations: View and delete contact form messages.
 */
class ContactMessageController extends Controller
{
    /**
     * Fetching all contact messages for admin list (latest first).
     */
    public function index(): View
    {
        $messages = ContactMessage::latest()->paginate(20);

        return view('admin.contact-messages.index', compact('messages'));
    }

    public function destroy(ContactMessage $contact_message): RedirectResponse
    {
        $contact_message->delete();
        return redirect()->route('admin.contact-messages.index')->with('success', 'Message deleted.');
    }
}
