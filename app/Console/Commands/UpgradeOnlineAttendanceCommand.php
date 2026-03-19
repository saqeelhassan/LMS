<?php

namespace App\Console\Commands;

use App\Models\StudentAttendance;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpgradeOnlineAttendanceCommand extends Command
{
    protected $signature = 'attendance:upgrade-online
                            {--minutes=15 : Minimum minutes connected to mark Present}';

    protected $description = 'Mark students Present for online sessions after they have been connected for the required minutes (default 15).';

    public function handle(): int
    {
        $minMinutes = (int) $this->option('minutes');
        $cutoff = Carbon::now()->subMinutes($minMinutes);

        $updated = StudentAttendance::where('mode', StudentAttendance::MODE_ONLINE)
            ->where('status', StudentAttendance::STATUS_ABSENT)
            ->whereNotNull('login_time')
            ->where('login_time', '<=', $cutoff)
            ->update(['status' => StudentAttendance::STATUS_PRESENT]);

        $this->info("Upgraded {$updated} online attendance record(s) to Present (connected >= {$minMinutes} min).");

        return 0;
    }
}
