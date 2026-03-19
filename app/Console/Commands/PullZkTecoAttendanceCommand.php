<?php

namespace App\Console\Commands;

use App\Services\BiometricPunchProcessor;
use App\Services\ZkTecoAttendancePullService;
use Illuminate\Console\Command;

class PullZkTecoAttendanceCommand extends Command
{
    protected $signature = 'biometric:pull-zkteco
                            {--process : Also run biometric:process for today after pull}';

    protected $description = 'Pull attendance logs from ZKTeco uFace 800 (IP:4370) into biometric_logs; optional process to biometric_attendance.';

    public function handle(): int
    {
        $service = app(ZkTecoAttendancePullService::class);
        $summary = $service->pull();

        if (isset($summary['error'])) {
            $this->error($summary['error']);

            return 1;
        }

        $this->info("Pulled {$summary['pulled']} record(s); inserted {$summary['inserted']}, skipped {$summary['skipped_duplicate']} duplicate(s), {$summary['unknown_user']} unknown user(s).");

        if ($this->option('process') && ($summary['inserted'] > 0 || $summary['pulled'] > 0)) {
            $processor = app(BiometricPunchProcessor::class);
            $result = $processor->processForDate(now()->toDateString());
            $this->info("Processed logs: {$result['created']} created, {$result['updated']} updated.");
        }

        return 0;
    }
}
