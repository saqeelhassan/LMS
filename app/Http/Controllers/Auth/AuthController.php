<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Role;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showSignIn(): View
    {
        return view('pages.auth.sign-in');
    }

    public function showSignUpStudent(): View
    {
        $courses = Course::orderBy('name')->get();

        return view('pages.auth.sign-up-student', compact('courses'));
    }

    public function showSignUpStaff(): View
    {
        return view('pages.auth.sign-up-staff');
    }

    public function showPendingApproval(): View
    {
        return view('pages.auth.pending-approval');
    }

    public function showForgotPassword(): View
    {
        return view('pages.auth.forgot-password');
    }

    public function sendResetLink(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
        ], [
            'email.required' => 'Please enter your email address.',
        ]);

        $email = trim($request->email);
        $user = User::whereRaw('LOWER(email) = ?', [strtolower($email)])->first();
        $status = Password::sendResetLink(
            ['email' => $user ? $user->getEmailForPasswordReset() : $email]
        );

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('status', __($status));
        }

        return back()->withErrors(['email' => __($status)]);
    }

    public function showResetForm(Request $request, string $token): View
    {
        return view('pages.auth.reset-password', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    public function resetPassword(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'confirmed', 'min:8'],
        ], [
            'password.confirmed' => 'The password confirmation does not match.',
            'password.min' => 'Password must be at least 8 characters.',
        ]);

        $status = Password::reset(
            [
                'email' => strtolower(trim($request->email)),
                'password' => $request->password,
                'password_confirmation' => $request->password_confirmation,
                'token' => $request->token,
            ],
            function (User $user, string $password): void {
                $user->forceFill(['password' => $password])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('status', __($status));
        }

        return back()->withErrors(['email' => __($status)]);
    }

    public function login(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string'],
            'remember' => ['nullable', 'boolean'],
        ], [
            'email.required' => 'Please enter your email address.',
            'password.required' => 'Please enter your password.',
        ]);

        $email = strtolower(trim($validated['email']));

        $user = User::whereRaw('LOWER(email) = ?', [$email])->first();

        if ($user && Auth::getProvider()->validateCredentials($user, ['password' => $validated['password']])) {
            if (! $user->is_active) {
                return back()->withErrors([
                    'email' => 'Your account is pending approval. You will be able to log in once an administrator approves your registration.',
                ])->onlyInput('email');
            }
            Auth::login($user, $request->boolean('remember'));
            $request->session()->regenerate();

            $intendedUrl = $request->input('intended', route('dashboard'));

            if ($request->filled('enroll_course') && $user->role && strtolower($user->role->name) === 'student') {
                $courseId = (int) $request->input('enroll_course');
                if ($courseId && ! Enrollment::where('user_id', $user->id)->where('course_id', $courseId)->exists()) {
                    Enrollment::create([
                        'user_id' => $user->id,
                        'course_id' => $courseId,
                        'payment_status' => 'pending',
                        'enrollment_status' => 'pending_approval',
                    ]);
                }
            }

            return redirect()->to($intendedUrl);
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
            'password' => 'The provided password is incorrect.',
        ])->onlyInput('email', 'password');
    }

    public function registerStudent(Request $request): RedirectResponse
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
            return back()->withErrors(['email' => 'Student registration is not available.'])->withInput($request->except('password', 'password_confirmation'));
        }

        try {
            $user = User::create([
                'email' => strtolower(trim($validated['email'])),
                'password' => $validated['password'],
                'role_id' => $role->id,
                'is_active' => false,
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

            return redirect()->route('auth.pending-approval')->with('success', 'Registration submitted. Your account is pending approval by an administrator.');
        } catch (\Throwable $e) {
            report($e);
            if (isset($user) && $user->id) {
                Storage::disk('public')->deleteDirectory('student-documents/' . $user->id);
                $user->delete();
            }
            return back()->withErrors(['email' => 'Registration failed. Please try again.'])->withInput($request->except('password', 'password_confirmation'));
        }
    }

    public function registerStaff(Request $request): RedirectResponse
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
            return back()->withErrors(['email' => 'Staff registration is not available.'])->withInput($request->except('password', 'password_confirmation'));
        }

        try {
            $user = User::create([
                'email' => strtolower(trim($validated['email'])),
                'password' => $validated['password'],
                'role_id' => $role->id,
                'is_active' => false,
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

            return redirect()->route('auth.pending-approval')->with('success', 'Registration submitted. Your account is pending approval by an administrator.');
        } catch (\Throwable $e) {
            report($e);
            if (isset($user) && $user->id) {
                Storage::disk('public')->deleteDirectory('staff-documents/' . $user->id);
                $user->delete();
            }
            return back()->withErrors(['email' => 'Registration failed. Please try again.'])->withInput($request->except('password', 'password_confirmation'));
        }
    }

    private function registerWithRole(Request $request, string $roleName, string $backRoute, string $dashboardRoute): RedirectResponse
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

        $role = Role::where('name', $roleName)->where('is_active', true)->first();
        if (! $role) {
            return back()->withErrors(['email' => 'Registration is not available. Please contact support.'])->withInput($request->only('email', 'first_name', 'last_name', 'mobile'));
        }

        try {
            $user = User::create([
                'email' => strtolower(trim($validated['email'])),
                'password' => $validated['password'],
                'role_id' => $role->id,
                'is_active' => false,
            ]);

            UserDetail::create([
                'user_id' => $user->id,
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'mobile' => $validated['mobile'] ?? null,
            ]);

            return redirect()->route('auth.pending-approval')->with('success', 'Registration submitted. Your account is pending approval by an administrator.');
        } catch (\Throwable $e) {
            report($e);
            return back()->withErrors(['email' => 'Registration failed. Please try again or use a different email.'])->withInput($request->only('email', 'first_name', 'last_name', 'mobile'));
        }
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
