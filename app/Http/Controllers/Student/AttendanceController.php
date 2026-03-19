<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\BiometricAttendance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * My Attendance: biometric-only. Data from BiometricPunchController.
 */
class AttendanceController extends Controller
{
    /**
     * My Attendance: calendar view + percentage bar (biometric data).
     */
    public function index(Request $request): View
    {
        $user = auth()->user();
        $month = $request->get('month', now()->format('Y-m'));
        $start = Carbon::parse($month . '-01')->startOfDay();
        $end = $start->copy()->endOfMonth();

        $records = BiometricAttendance::where('user_id', $user->id)
            ->whereBetween('date', [$start, $end])
            ->orderBy('date')
            ->get();

        $byDate = $records->groupBy(fn ($r) => $r->date->format('Y-m-d'));
        $calendar = [];
        foreach ($byDate as $dateStr => $dayRecords) {
            $status = $this->dayStatus($dayRecords);
            $calendar[$dateStr] = $status;
        }

        $total = $records->count();
        $present = $records->whereIn('status', ['Present', 'Late'])->count();
        $percent = $total > 0 ? round(($present / $total) * 100, 1) : 0;
        $percentLow = $percent < 75;

        $prevMonth = $start->copy()->subMonth()->format('Y-m');
        $nextMonth = $start->copy()->addMonth()->format('Y-m');

        return view('student.attendance.index', compact(
            'month',
            'start',
            'calendar',
            'percent',
            'percentLow',
            'total',
            'present',
            'prevMonth',
            'nextMonth'
        ));
    }

    private function dayStatus($dayRecords): string
    {
        $statuses = $dayRecords->pluck('status')->unique();
        if ($statuses->contains('Present')) {
            return 'Present';
        }
        if ($statuses->contains('Late')) {
            return 'Late';
        }
        if ($statuses->contains('Invalid')) {
            return 'Invalid';
        }
        return 'Absent';
    }
}
