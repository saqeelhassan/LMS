<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProfessorController extends Controller
{
    public function index(): View
    {
        $instructorRoleId = Role::where('name', 'Instructor')->value('id');
        $professors = User::with('userDetail')
            ->where('role_id', $instructorRoleId)
            ->orderBy('email')
            ->paginate(20);

        return view('admin.professors.index', compact('professors'));
    }

    public function create(): View
    {
        return view('admin.professors.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'confirmed', 'min:8'],
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'mobile' => ['nullable', 'string', 'max:20'],
        ], [
            'email.unique' => 'An account with this email already exists.',
            'password.confirmed' => 'The password confirmation does not match.',
            'password.min' => 'Password must be at least 8 characters.',
        ]);

        $role = Role::where('name', 'Instructor')->where('is_active', true)->first();
        if (! $role) {
            return back()->withErrors(['role' => 'Instructor role not found.'])->withInput();
        }

        $user = User::create([
            'email' => strtolower(trim($validated['email'])),
            'password' => $validated['password'],
            'role_id' => $role->id,
            'is_active' => true,
        ]);

        UserDetail::create([
            'user_id' => $user->id,
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'mobile' => $validated['mobile'] ?? null,
        ]);

        return redirect()->route('admin.professors.index')->with('success', 'Professor added successfully.');
    }

    public function show(User $professor): View
    {
        if ($professor->role?->name !== 'Instructor') {
            abort(404, 'Not an instructor.');
        }
        $professor->load('userDetail', 'role');

        return view('admin.professors.show', compact('professor'));
    }

    public function edit(User $professor): View
    {
        if ($professor->role?->name !== 'Instructor') {
            abort(404, 'Not an instructor.');
        }
        $professor->load('userDetail');

        return view('admin.professors.edit', compact('professor'));
    }

    public function update(Request $request, User $professor): RedirectResponse
    {
        if ($professor->role?->name !== 'Instructor') {
            abort(404, 'Not an instructor.');
        }

        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'mobile' => ['nullable', 'string', 'max:20'],
            'password' => ['nullable', 'string', 'confirmed', 'min:8'],
        ], [
            'password.confirmed' => 'The password confirmation does not match.',
            'password.min' => 'Password must be at least 8 characters.',
        ]);

        $detail = $professor->userDetail;
        if (! $detail) {
            $detail = UserDetail::create([
                'user_id' => $professor->id,
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'mobile' => $validated['mobile'] ?? null,
            ]);
        } else {
            $detail->update([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'mobile' => $validated['mobile'] ?? null,
            ]);
        }

        if (! empty($validated['password'])) {
            $professor->update(['password' => $validated['password']]);
        }

        return redirect()->route('admin.professors.index')->with('success', 'Professor updated successfully.');
    }

    public function destroy(User $professor): RedirectResponse
    {
        if ($professor->role?->name !== 'Instructor') {
            abort(404, 'Not an instructor.');
        }

        $professor->delete();

        return redirect()->route('admin.professors.index')->with('success', 'Professor deleted successfully.');
    }
}
