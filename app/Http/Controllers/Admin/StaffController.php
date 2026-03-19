<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StaffController extends Controller
{
    public function index(): View
    {
        $staffRoleId = Role::where('name', 'Staff')->value('id');
        $staff = User::with('userDetail')
            ->where('role_id', $staffRoleId)
            ->orderBy('email')
            ->paginate(20);

        return view('admin.staff.index', compact('staff'));
    }

    public function create(): View
    {
        return view('admin.staff.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'father_name' => ['required', 'string', 'max:100'],
            'cnic' => ['required', 'string', 'max:20'],
            'contact_no' => ['required', 'string', 'max:20'],
            'whatsapp' => ['nullable', 'string', 'max:20'],
            'emergency_contact' => ['nullable', 'string', 'max:20'],
            'gender' => ['required', 'string', 'in:Male,Female,Other'],
            'current_address' => ['required', 'string', 'max:500'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'last_qualification' => ['required', 'string', 'max:255'],
            'domicile_district' => ['required', 'string', 'max:100'],
            'cnic_front' => ['required', 'image', 'mimes:jpeg,jpg,png', 'max:2048'],
            'cnic_back' => ['required', 'image', 'mimes:jpeg,jpg,png', 'max:2048'],
            'last_degree' => ['required', 'file', 'mimes:pdf,jpeg,jpg,png', 'max:5120'],
            'domicile_prc' => ['required', 'file', 'mimes:pdf,jpeg,jpg,png', 'max:5120'],
            'password' => ['required', 'string', 'confirmed', 'min:8'],
        ], [
            'email.unique' => 'An account with this email already exists.',
            'password.confirmed' => 'The password confirmation does not match.',
            'password.min' => 'Password must be at least 8 characters.',
            'cnic_front.required' => 'CNIC front image is required.',
            'cnic_back.required' => 'CNIC back image is required.',
            'last_degree.required' => 'Last degree document is required.',
            'domicile_prc.required' => 'Domicile/PRC document is required.',
        ]);

        $role = Role::where('name', 'Staff')->where('is_active', true)->first();
        if (! $role) {
            return back()->withErrors(['role' => 'Staff role not found.'])->withInput($request->except('password', 'password_confirmation'));
        }

        try {
            $user = User::create([
                'email' => strtolower(trim($validated['email'])),
                'password' => $validated['password'],
                'role_id' => $role->id,
                'is_active' => true,
            ]);

            $cnicFrontPath = $request->file('cnic_front')->store('staff-documents/' . $user->id, 'public');
            $cnicBackPath = $request->file('cnic_back')->store('staff-documents/' . $user->id, 'public');
            $lastDegreePath = $request->file('last_degree')->store('staff-documents/' . $user->id, 'public');
            $domicilePrcPath = $request->file('domicile_prc')->store('staff-documents/' . $user->id, 'public');

            UserDetail::create([
                'user_id' => $user->id,
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'father_name' => $validated['father_name'],
                'cnic' => $validated['cnic'],
                'contact_no' => $validated['contact_no'],
                'whatsapp' => $validated['whatsapp'] ?? null,
                'emergency_contact' => $validated['emergency_contact'] ?? null,
                'gender' => $validated['gender'],
                'current_address' => $validated['current_address'],
                'last_qualification' => $validated['last_qualification'],
                'domicile_district' => $validated['domicile_district'],
                'cnic_front_path' => $cnicFrontPath,
                'cnic_back_path' => $cnicBackPath,
                'last_degree_path' => $lastDegreePath,
                'domicile_prc_path' => $domicilePrcPath,
            ]);

            return redirect()->route('admin.staff.index')->with('success', 'Staff added successfully.');
        } catch (\Throwable $e) {
            report($e);
            if (isset($user) && $user->id) {
                Storage::disk('public')->deleteDirectory('staff-documents/' . $user->id);
                $user->delete();
            }
            return back()->withErrors(['email' => 'Registration failed. Please try again.'])->withInput($request->except('password', 'password_confirmation'));
        }
    }

    public function show(User $staff): View
    {
        if ($staff->role?->name !== 'Staff') {
            abort(404, 'Not a staff member.');
        }
        $staff->load('userDetail', 'role');

        return view('admin.staff.show', compact('staff'));
    }

    public function edit(User $staff): View
    {
        if ($staff->role?->name !== 'Staff') {
            abort(404, 'Not a staff member.');
        }
        $staff->load('userDetail');

        return view('admin.staff.edit', compact('staff'));
    }

    public function update(Request $request, User $staff): RedirectResponse
    {
        if ($staff->role?->name !== 'Staff') {
            abort(404, 'Not a staff member.');
        }

        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'mobile' => ['nullable', 'string', 'max:20'],
            'designation' => ['nullable', 'string', 'max:100'],
            'gender' => ['nullable', 'string', 'in:Male,Female,Other'],
            'address' => ['nullable', 'string', 'max:500'],
            'last_qualification' => ['nullable', 'string', 'max:255'],
            'password' => ['nullable', 'string', 'confirmed', 'min:8'],
        ], [
            'password.confirmed' => 'The password confirmation does not match.',
            'password.min' => 'Password must be at least 8 characters.',
        ]);

        $detailData = [
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'mobile' => $validated['mobile'] ?? null,
            'designation' => $validated['designation'] ?? null,
            'gender' => $validated['gender'] ?? null,
            'address' => $validated['address'] ?? null,
            'last_qualification' => $validated['last_qualification'] ?? null,
        ];

        $detail = $staff->userDetail;
        if (! $detail) {
            $detail = UserDetail::create(array_merge(['user_id' => $staff->id], $detailData));
        } else {
            $detail->update($detailData);
        }

        if (! empty($validated['password'])) {
            $staff->update(['password' => $validated['password']]);
        }

        return redirect()->route('admin.staff.index')->with('success', 'Staff updated successfully.');
    }

    public function destroy(User $staff): RedirectResponse
    {
        if ($staff->role?->name !== 'Staff') {
            abort(404, 'Not a staff member.');
        }

        $staff->delete();

        return redirect()->route('admin.staff.index')->with('success', 'Staff deleted successfully.');
    }
}
