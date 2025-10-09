<?php

namespace App\Console\Commands;

use App\Models\LoginAttempt;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Spatie\Activitylog\Models\Activity;

class CleanupOldLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'logs:archive {--months=3 : Number of months to keep logs in database}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Archive old activity logs and login attempts to files instead of deleting';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $months = (int) $this->option('months');
        $cutoffDate = now()->subMonths($months);
        $archiveDate = now()->format('Y-m-d_H-i-s');

        $this->info("Archiving logs older than {$months} months (before {$cutoffDate->format('Y-m-d H:i:s')})...");

        // Create archive directory if it doesn't exist
        $archivePath = 'logs/archives/' . now()->format('Y/m');
        Storage::makeDirectory($archivePath);

        // Archive activity logs
        $activityLogs = Activity::where('created_at', '<', $cutoffDate)->get();

        if ($activityLogs->isNotEmpty()) {
            $activityFileName = "{$archivePath}/activity-logs_{$archiveDate}.json";
            Storage::put($activityFileName, $activityLogs->toJson(JSON_PRETTY_PRINT));

            // Delete archived records from database
            Activity::where('created_at', '<', $cutoffDate)->delete();

            $this->info("Archived {$activityLogs->count()} activity log records to: storage/app/{$activityFileName}");
        } else {
            $this->info("No activity logs to archive.");
        }

        // Archive login attempts
        $loginAttempts = LoginAttempt::where('attempted_at', '<', $cutoffDate)->get();

        if ($loginAttempts->isNotEmpty()) {
            $attemptsFileName = "{$archivePath}/login-attempts_{$archiveDate}.json";
            Storage::put($attemptsFileName, $loginAttempts->toJson(JSON_PRETTY_PRINT));

            // Delete archived records from database
            LoginAttempt::where('attempted_at', '<', $cutoffDate)->delete();

            $this->info("Archived {$loginAttempts->count()} login attempt records to: storage/app/{$attemptsFileName}");
        } else {
            $this->info("No login attempts to archive.");
        }

        $this->newLine();
        $this->info('✓ Log archival completed successfully!');
        $this->info("Archives stored in: storage/app/{$archivePath}");

        return Command::SUCCESS;
    }
}
