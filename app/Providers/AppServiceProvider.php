<?php

namespace App\Providers;

use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
        View::prependNamespace('pagination', resource_path('views/vendor/pagination'));

        View::composer(['layouts.partials.admin-topbar', 'layouts.partials.admin-header', 'layouts.partials.super-admin-header'], function ($view) {
            $notifications = [];
            if (Auth::check()) {
                $user = Auth::user();
                $canSeeRegistrations = $user->role?->name === 'SuperAdmin'
                    || ($user->role?->name === 'Admin' && $user->hasAdminPermission('registrations.approve'));
                if ($canSeeRegistrations) {
                    $pending = User::with('userDetail')
                        ->where('is_active', false)
                        ->whereHas('role', fn ($q) => $q->whereIn('name', ['Student', 'Staff']))
                        ->latest()
                        ->limit(5)
                        ->get();
                    foreach ($pending as $u) {
                        $notifications[] = [
                            'type' => 'pending_registration',
                            'title' => 'Pending registration',
                            'message' => $u->name . ' (' . $u->email . ') is waiting for approval.',
                            'url' => $user->role?->name === 'SuperAdmin' ? route('super-admin.registrations.index') : route('admin.registrations.index'),
                            'time' => $u->created_at->diffForHumans(),
                            'sort_at' => $u->created_at->getTimestamp(),
                        ];
                    }
                }
                $recentEnrollments = Enrollment::with(['user.userDetail', 'course'])
                    ->latest('created_at')
                    ->limit(5)
                    ->get();
                foreach ($recentEnrollments as $e) {
                    $notifications[] = [
                        'type' => 'enrollment',
                        'title' => 'New enrollment',
                        'message' => ($e->user->name ?? $e->user->email) . ' enrolled in ' . ($e->course->name ?? 'a course') . '.',
                        'url' => route('courses.index'),
                        'time' => $e->created_at->diffForHumans(),
                        'sort_at' => $e->created_at->getTimestamp(),
                    ];
                }
                usort($notifications, fn ($a, $b) => ($b['sort_at'] ?? 0) <=> ($a['sort_at'] ?? 0));
                $notifications = array_slice($notifications, 0, 8);
            }
            $view->with('notifications', $notifications ?? []);
        });

        View::composer(['layouts.partials.super-admin-sidenav', 'layouts.partials.view-as-modals'], function ($view) {
            $viewAsAdmins = collect();
            $viewAsInstructors = collect();
            $viewAsStudents = collect();
            if (Auth::check() && Auth::user()->role?->name === 'SuperAdmin') {
                $viewAsAdmins = User::with('userDetail')->whereHas('role', fn ($q) => $q->where('name', 'Admin'))->orderBy('email')->get();
                $viewAsInstructors = User::with('userDetail')->whereHas('role', fn ($q) => $q->where('name', 'Instructor'))->orderBy('email')->get();
                $viewAsStudents = User::with('userDetail')->whereHas('role', fn ($q) => $q->where('name', 'Student'))->orderBy('email')->get();
            }
            $view->with(compact('viewAsAdmins', 'viewAsInstructors', 'viewAsStudents'));
        });
    }
}
