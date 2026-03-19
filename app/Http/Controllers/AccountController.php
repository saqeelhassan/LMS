<?php

namespace App\Http\Controllers;

use App\Models\UserDetail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class AccountController extends Controller
{
    /**
     * Layout to use for account pages (Super Admin sees super-admin layout, others see admin).
     */
    protected function accountLayout(): string
    {
        return auth()->user()->role?->name === 'SuperAdmin'
            ? 'layouts.super-admin'
            : 'layouts.admin';
    }

    public function editProfile(): View
    {
        $user = auth()->user();
        $user->load('userDetail');

        return view('account.profile-edit', [
            'user' => $user,
            'layout' => $this->accountLayout(),
        ]);
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $user = auth()->user();

        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'mobile' => ['nullable', 'string', 'max:20'],
            'profile_picture' => ['nullable', 'image', 'mimes:jpeg,jpg,png,gif,webp', 'max:2048'],
        ], [
            'profile_picture.image' => 'The file must be an image.',
            'profile_picture.max' => 'The profile picture must not be larger than 2 MB.',
        ]);

        $detailData = [
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'mobile' => $validated['mobile'] ?? null,
        ];

        if ($request->hasFile('profile_picture')) {
            $detail = UserDetail::firstOrNew(['user_id' => $user->id]);
            if ($detail->profile_picture && Storage::disk('public')->exists($detail->profile_picture)) {
                Storage::disk('public')->delete($detail->profile_picture);
            }
            $path = $request->file('profile_picture')->store('profile-pictures', 'public');
            $detailData['profile_picture'] = $path;
        }

        UserDetail::updateOrCreate(
            ['user_id' => $user->id],
            $detailData
        );

        return back()->with('success', 'Profile updated successfully.');
    }

    public function accountSettings(): View
    {
        return view('account.settings', ['layout' => $this->accountLayout()]);
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        auth()->user()->update(['password' => $validated['password']]);

        return back()->with('success', 'Password changed successfully.');
    }

    public function help(): View
    {
        return view('account.help', ['layout' => $this->accountLayout()]);
    }
}
