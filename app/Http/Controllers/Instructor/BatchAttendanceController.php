<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\BiometricAttendance;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BatchAttendanceController extends Controller
{
    private function authorizeBatch(Batch $batch): void
    {
        $user = auth()->user();
        if ($batch->instructor_id !== $user->id && $user->role?->name !== 'SuperAdmin') {
            abort(403, 'You can only manage attendance for your own batches.');
        }
    }

    public function index(Batch $batch): View|RedirectResponse
    {
        $this->authorizeBatch($batch);

        $enrolledUserIds = $batch->enrollments()->pluck('user_id');
        $dates = $enrolledUserIds->isEmpty()
            ? collect()
            : BiometricAttendance::whereIn('user_id', $enrolledUserIds)
                ->select('date')
                ->distinct()
                ->orderByDesc('date')
                ->limit(50)
                ->pluck('date')
                ->map(fn ($d) => $d->format('Y-m-d'));

        return view('instructor.batches.attendance-index', compact('batch', 'dates'));
    }

    public function take(Batch $batch, Request $request): RedirectResponse
    {
        return redirect()->route('attendance.biometric-only')
            ->with('info', 'Attendance is only recorded via Biometric Scanner at the Institute.');
    }

    public function store(Request $request, Batch $batch): RedirectResponse
    {
        return redirect()->route('attendance.biometric-only')
            ->with('info', 'Attendance is only recorded via Biometric Scanner at the Institute.');
    }

    public function view(Batch $batch, string $date): View|RedirectResponse
    {
        $this->authorizeBatch($batch);
        $sessionDate = Carbon::parse($date)->startOfDay();

        $enrollments = $batch->enrollments()->with('user.userDetail')->orderBy('id')->get();
        $userIds = $enrollments->pluck('user_id');
        $biometricRecords = BiometricAttendance::whereIn('user_id', $userIds)
            ->whereDate('date', $sessionDate)
            ->get()
            ->keyBy('user_id');

        $attendances = $enrollments->map(function ($e) use ($biometricRecords) {
            $bio = $biometricRecords->get($e->user_id);
            return (object) [
                'user' => $e->user,
                'status' => $bio ? $bio->status : 'Absent',
                'check_in_time' => $bio?->check_in_time,
                'check_out_time' => $bio?->check_out_time,
                'mode' => 'Biometric',
            ];
        });

        return view('instructor.batches.attendance-view', compact('batch', 'sessionDate', 'attendances'));
    }
}
