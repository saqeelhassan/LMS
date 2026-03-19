<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Role;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    public function index(): View
    {
        $studentRoleId = Role::where('name', 'Student')->value('id');
        $students = User::with('userDetail')
            ->where('role_id', $studentRoleId)
            ->orderBy('email')
            ->paginate(20);

        return view('admin.students.index', compact('students'));
    }

    public function create(): View
    {
        $courses = Course::orderBy('name')->get();

        return view('admin.students.create', compact('courses'));
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
            'course_id' => ['nullable', 'integer', 'exists:courses,id'],
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

        $role = Role::where('name', 'Student')->where('is_active', true)->first();
        if (! $role) {
            return back()->withErrors(['role' => 'Student role not found.'])->withInput($request->except('password', 'password_confirmation'));
        }

        try {
            $user = User::create([
                'email' => strtolower(trim($validated['email'])),
                'password' => $validated['password'],
                'role_id' => $role->id,
                'is_active' => true,
            ]);

            $cnicFrontPath = $request->file('cnic_front')->store('student-documents/' . $user->id, 'public');
            $cnicBackPath = $request->file('cnic_back')->store('student-documents/' . $user->id, 'public');
            $lastDegreePath = $request->file('last_degree')->store('student-documents/' . $user->id, 'public');
            $domicilePrcPath = $request->file('domicile_prc')->store('student-documents/' . $user->id, 'public');

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

            if (! empty($validated['course_id'])) {
                Enrollment::create([
                    'user_id' => $user->id,
                    'course_id' => (int) $validated['course_id'],
                    'payment_status' => 'pending',
                    'enrollment_status' => 'pending_approval',
                ]);
            }

            return redirect()->route('admin.students.index')->with('success', 'Student added successfully.');
        } catch (\Throwable $e) {
            report($e);
            if (isset($user) && $user->id) {
                Storage::disk('public')->deleteDirectory('student-documents/' . $user->id);
                $user->delete();
            }
            return back()->withErrors(['email' => 'Registration failed. Please try again.'])->withInput($request->except('password', 'password_confirmation'));
        }
    }

    public function show(User $student): View
    {
        if ($student->role?->name !== 'Student') {
            abort(404, 'Not a student.');
        }
        $student->load('userDetail', 'role');

        return view('admin.students.show', compact('student'));
    }

    public function edit(User $student): View
    {
        if ($student->role?->name !== 'Student') {
            abort(404, 'Not a student.');
        }
        $student->load('userDetail');

        return view('admin.students.edit', compact('student'));
    }

    public function update(Request $request, User $student): RedirectResponse
    {
        if ($student->role?->name !== 'Student') {
            abort(404, 'Not a student.');
        }

        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'mobile' => ['nullable', 'string', 'max:20'],
            'gender' => ['nullable', 'string', 'in:Male,Female,Other'],
            'father_name' => ['nullable', 'string', 'max:255'],
            'emergency_contact' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:1000'],
            'password' => ['nullable', 'string', 'confirmed', 'min:8'],
            'profile_picture' => ['nullable', 'image', 'mimes:jpeg,jpg,png,gif,webp', 'max:2048'],
        ], [
            'password.confirmed' => 'The password confirmation does not match.',
            'password.min' => 'Password must be at least 8 characters.',
            'profile_picture.max' => 'The profile picture must not be larger than 2 MB.',
        ]);

        $detailData = [
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'mobile' => $validated['mobile'] ?? null,
            'gender' => $validated['gender'] ?? null,
            'father_name' => $validated['father_name'] ?? null,
            'emergency_contact' => $validated['emergency_contact'] ?? null,
            'address' => $validated['address'] ?? null,
        ];

        if ($request->hasFile('profile_picture')) {
            $detail = $student->userDetail;
            if ($detail && $detail->profile_picture && Storage::disk('public')->exists($detail->profile_picture)) {
                Storage::disk('public')->delete($detail->profile_picture);
            }
            $path = $request->file('profile_picture')->store('profile-pictures', 'public');
            $detailData['profile_picture'] = $path;
        }

        $detail = $student->userDetail;
        if (! $detail) {
            $detail = UserDetail::create(array_merge(['user_id' => $student->id], $detailData));
        } else {
            $detail->update($detailData);
        }

        if (! empty($validated['password'])) {
            $student->update(['password' => $validated['password']]);
        }

        return redirect()->route('admin.students.index')->with('success', 'Student updated successfully.');
    }

    public function destroy(User $student): RedirectResponse
    {
        if ($student->role?->name !== 'Student') {
            abort(404, 'Not a student.');
        }

        $student->delete();

        return redirect()->route('admin.students.index')->with('success', 'Student deleted successfully.');
    }
}
