<?php

namespace App\Services;

use App\Helpers\FeeConfig;
use App\Models\AttendanceDeduction;
use App\Models\Enrollment;
use App\Models\StudentAttendance;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Compute attendance-based fines (Absent/Late) and add to enrollment arrears.
 * Runs monthly; each period is processed once (idempotent).
 */
class AttendanceDeductionService
{
    /**
     * Process deductions for a given month.
     *
     * @return array{processed: int, total_amount: float, skipped: int, errors: array<int, string>}
     */
    public function processForMonth(Carbon $month): array
    {
        if (! FeeConfig::attendanceFineEnabled()) {
            return ['processed' => 0, 'total_amount' => 0.0, 'skipped' => 0, 'errors' => []];
        }

        $finePerAbsence = FeeConfig::attendanceFinePerAbsence();
        $finePerLate = FeeConfig::attendanceFinePerLate();

        if ($finePerAbsence <= 0 && $finePerLate <= 0) {
            return ['processed' => 0, 'total_amount' => 0.0, 'skipped' => 0, 'errors' => []];
        }

        $periodStart = $month->copy()->startOfMonth()->toDateString();
        $periodEnd = $month->copy()->endOfMonth()->toDateString();

        $enrollments = Enrollment::where('enrollment_status', 'active')
            ->whereNotNull('batch_id')
            ->with(['user', 'batch', 'course'])
            ->get();

        $processed = 0;
        $totalAmount = 0.0;
        $skipped = 0;
        $errors = [];

        foreach ($enrollments as $enrollment) {
            if (AttendanceDeduction::where('enrollment_id', $enrollment->id)
                ->where('period_start', $periodStart)
                ->exists()) {
                $skipped++;
                continue;
            }

            $absences = (int) StudentAttendance::where('student_id', $enrollment->user_id)
                ->where('batch_id', $enrollment->batch_id)
                ->whereBetween('date', [$periodStart, $periodEnd])
                ->where('status', StudentAttendance::STATUS_ABSENT)
                ->count();

            $late = (int) StudentAttendance::where('student_id', $enrollment->user_id)
                ->where('batch_id', $enrollment->batch_id)
                ->whereBetween('date', [$periodStart, $periodEnd])
                ->where('status', StudentAttendance::STATUS_LATE)
                ->count();

            $amount = ($absences * $finePerAbsence) + ($late * $finePerLate);
            if ($amount <= 0) {
                continue;
            }

            try {
                DB::transaction(function () use ($enrollment, $periodStart, $periodEnd, $absences, $late, $finePerAbsence, $amount, &$processed, &$totalAmount) {
                    AttendanceDeduction::create([
                        'enrollment_id' => $enrollment->id,
                        'period_start' => $periodStart,
                        'period_end' => $periodEnd,
                        'absences_count' => $absences,
                        'late_count' => $late,
                        'fine_per_absence' => $finePerAbsence,
                        'total_amount' => round($amount, 2),
                        'applied_at' => now(),
                    ]);

                    $enrollment->arrears = (float) ($enrollment->arrears ?? 0) + round($amount, 2);
                    $enrollment->save();

                    $processed++;
                    $totalAmount += round($amount, 2);
                });
            } catch (\Throwable $e) {
                $errors[$enrollment->id] = $e->getMessage();
            }
        }

        return [
            'processed' => $processed,
            'total_amount' => round($totalAmount, 2),
            'skipped' => $skipped,
            'errors' => $errors,
        ];
    }
}
