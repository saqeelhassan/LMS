<?php

namespace App\Console\Commands;

use App\Services\BiometricPunchProcessor;
use Illuminate\Console\Command;

class ProcessBiometricLogsCommand extends Command
{
    protected $signature = 'biometric:process
                            {--date= : Date (Y-m-d) to process; default is today}';

    protected $description = 'Process raw biometric_logs into biometric_attendance (first punch=check-in, last=check-out, late & ghost rules applied).';

    public function handle(): int
    {
        $date = $this->option('date');
        $processor = app(BiometricPunchProcessor::class);
        $result = $processor->processForDate($date);

        $this->info("Processed {$result['date']}: {$result['created']} created, {$result['updated']} updated.");

        return 0;
    }
}
