<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BiometricAttendance;
use App\Models\User;
use App\Services\BiometricPunchProcessor;
use App\Services\ZkTecoAttendancePullService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Admin attendance: biometric-only. Data originates from BiometricPunchController.
 */
class AttendanceReportController extends Controller
{
    /**
     * Today's attendance overview for dashboard (biometric-only).
     */
    public static function todayOverview(): array
    {
        $today = now()->toDateString();

        $studentRoleId = DB::table('roles')->where('name', 'Student')->value('id');
        $instructorRoleId = DB::table('roles')->where('name', 'Instructor')->value('id');

        $studentIds = User::where('role_id', $studentRoleId)->where('is_active', true)->pluck('id');
        $instructorIds = DB::table('batches')->where('is_active', true)->whereNotNull('instructor_id')->distinct()->pluck('instructor_id');

        $studentPresent = BiometricAttendance::whereDate('date', $today)
            ->whereIn('user_id', $studentIds)
            ->whereIn('status', ['Present', 'Late'])
            ->pluck('user_id')
            ->unique()
            ->count();
        $studentExpected = (int) DB::table('enrollments')
            ->join('batches', 'enrollments.batch_id', '=', 'batches.id')
            ->where('batches.is_active', true)
            ->whereNotNull('enrollments.batch_id')
            ->distinct()
            ->count('enrollments.user_id');
        $studentPercent = $studentExpected > 0 ? round(($studentPresent / $studentExpected) * 100, 1) : 0;

        $instructorPresent = BiometricAttendance::whereDate('date', $today)
            ->whereNotNull('check_in_time')
            ->whereIn('user_id', $instructorIds)
            ->count();
        $instructorAbsent = max(0, $instructorIds->count() - $instructorPresent);

        return [
            'student_present_count' => $studentPresent,
            'student_expected_count' => $studentExpected,
            'student_present_percent' => $studentPercent,
            'instructor_present_count' => $instructorPresent,
            'instructor_absent_count' => $instructorAbsent,
        ];
    }

    /**
     * List biometric attendance by date (all roles).
     */
    public function index(Request $request)
    {
        $date = $request->get('date', now()->toDateString());
        $records = BiometricAttendance::whereDate('date', $date)
            ->with('user.userDetail')
            ->orderBy('check_in_time')
            ->get();
        $scannerStatus = session('biometric_scanner_status'); // 'connected' | 'disconnected' | null

        return view('admin.attendance.index', compact('date', 'records', 'scannerStatus'));
    }

    /**
     * Pull attendance from ZKTeco uFace 800 (IP:4370) and process into attendance.
     */
    public function syncZkteco(Request $request)
    {
        $service = app(ZkTecoAttendancePullService::class);
        $summary = $service->pull();

        if (isset($summary['error'])) {
            return redirect()->route('admin.attendance.index', ['date' => $request->get('date', now()->toDateString())])
                ->with('error', 'uFace 800 sync failed: ' . $summary['error'])
                ->with('biometric_scanner_status', 'disconnected');
        }

        $date = $request->get('date', now()->toDateString());
        if ($summary['inserted'] > 0 || $summary['pulled'] > 0) {
            $processor = app(BiometricPunchProcessor::class);
            $processor->processForDate($date);
        }

        $msg = sprintf(
            'uFace 800: pulled %d, inserted %d, skipped %d duplicate(s), %d unknown user(s).',
            $summary['pulled'],
            $summary['inserted'],
            $summary['skipped_duplicate'],
            $summary['unknown_user']
        );

        return redirect()->route('admin.attendance.index', ['date' => $date])
            ->with('success', $msg)
            ->with('biometric_scanner_status', 'connected');
    }

    /**
     * Edit form for one biometric_attendance record.
     */
    public function edit(BiometricAttendance $attendance)
    {
        $attendance->load('user.userDetail');
        return view('admin.attendance.edit', compact('attendance'));
    }

    /**
     * Update check_in_time / check_out_time (correction).
     */
    public function update(Request $request, BiometricAttendance $attendance)
    {
        $validated = $request->validate([
            'check_in_time' => ['nullable', 'date'],
            'check_out_time' => ['nullable', 'date', 'after_or_equal:check_in_time'],
        ]);

        if (array_key_exists('check_in_time', $validated)) {
            $attendance->check_in_time = $validated['check_in_time'] ? Carbon::parse($validated['check_in_time']) : null;
        }
        if (array_key_exists('check_out_time', $validated)) {
            $attendance->check_out_time = $validated['check_out_time'] ? Carbon::parse($validated['check_out_time']) : null;
        }
        $attendance->save();

        return redirect()->route('admin.attendance.index', ['date' => $attendance->date->format('Y-m-d')])
            ->with('success', 'Attendance record updated.');
    }

    /**
     * Payroll report: CSV from biometric data (Instructors only).
     */
    public function payrollCsv(Request $request): StreamedResponse
    {
        $month = $request->get('month', now()->format('Y-m'));
        $start = Carbon::parse($month . '-01')->startOfDay();
        $end = $start->copy()->endOfMonth();
        $instructorRoleId = DB::table('roles')->where('name', 'Instructor')->value('id');
        $instructorIds = User::where('role_id', $instructorRoleId)->pluck('id');

        $records = BiometricAttendance::whereBetween('date', [$start, $end])
            ->whereNotNull('check_in_time')
            ->whereIn('user_id', $instructorIds)
            ->with('user.userDetail')
            ->get();

        $byUser = $records->groupBy('user_id');
        $rows = [];
        foreach ($byUser as $userId => $attendances) {
            $user = $attendances->first()->user;
            $daysPresent = $attendances->count();
            $totalMinutes = $attendances->sum(fn ($a) => $a->check_out_time ? (int) $a->check_in_time->diffInMinutes($a->check_out_time) : 0);
            $rows[] = [$user->name ?? $user->email, $daysPresent, round($totalMinutes / 60, 2)];
        }

        return response()->streamDownload(function () use ($rows) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['Name', 'Days Present', 'Total Hours']);
            foreach ($rows as $row) {
                fputcsv($out, $row);
            }
            fclose($out);
        }, 'payroll-attendance-' . $month . '.csv', ['Content-Type' => 'text/csv']);
    }

    /**
     * Export PDF (print-friendly view; user can Print to PDF).
     * Optional program filter: only users with that program_category; program name shown in header.
     * Optional month (Y-m): export full month of records; dateLabel used in header.
     */
    public function exportPdf(Request $request)
    {
        $program = $request->get('program');
        $month = $request->get('month');
        $date = $request->get('date', now()->toDateString());

        $query = BiometricAttendance::with('user.userDetail');

        if ($month) {
            $start = Carbon::parse($month . '-01')->startOfDay();
            $end = $start->copy()->endOfMonth();
            $query->whereBetween('date', [$start, $end]);
            $dateLabel = $start->format('F Y');
        } else {
            $query->whereDate('date', $date);
            $dateLabel = Carbon::parse($date)->format('l, F j, Y');
        }

        if ($program) {
            $query->whereHas('user', fn ($q) => $q->where('program_category', $program));
        }

        $records = $query->orderBy('date')->orderBy('check_in_time')->get();

        $programName = $program ?: null;

        return view('admin.attendance.export-pdf', compact('date', 'records', 'programName', 'dateLabel'));
    }

    /**
     * Government-funded program monthly report (e.g. BBSHRRDA). Filter by program_category; only those students.
     */
    public function governmentReport(Request $request)
    {
        $month = $request->get('month', now()->format('Y-m'));
        $program = $request->get('program', User::PROGRAM_BBSHRRDA);

        $start = Carbon::parse($month . '-01')->startOfDay();
        $end = $start->copy()->endOfMonth();

        $records = BiometricAttendance::whereBetween('date', [$start, $end])
            ->whereHas('user', fn ($q) => $q->where('program_category', $program))
            ->with('user.userDetail')
            ->orderBy('date')
            ->orderBy('check_in_time')
            ->get();

        $dateLabel = $start->format('F Y');

        return view('admin.attendance.government-report', compact('records', 'month', 'program', 'dateLabel'));
    }

    /**
     * Export Excel (CSV).
     */
    public function exportExcel(Request $request): StreamedResponse
    {
        $date = $request->get('date', now()->toDateString());
        $records = BiometricAttendance::whereDate('date', $date)
            ->with('user.userDetail')
            ->orderBy('check_in_time')
            ->get();

        $filename = 'biometric-attendance-' . $date . '.csv';
        return response()->streamDownload(function () use ($records) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['Name', 'Email', 'Check-in', 'Check-out', 'Status', 'Device']);
            foreach ($records as $attendanceRecord) {
                fputcsv($out, [
                    $attendanceRecord->user->name ?? $attendanceRecord->user->email ?? '—',
                    $attendanceRecord->user->email ?? '—',
                    $attendanceRecord->check_in_time?->format('H:i:s') ?? '—',
                    $attendanceRecord->check_out_time?->format('H:i:s') ?? '—',
                    $attendanceRecord->status ?? '—',
                    $attendanceRecord->device_id ?? '—',
                ]);
            }
            fclose($out);
        }, $filename, ['Content-Type' => 'text/csv']);
    }
}
