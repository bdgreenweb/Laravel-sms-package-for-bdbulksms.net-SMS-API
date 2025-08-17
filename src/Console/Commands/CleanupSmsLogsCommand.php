<?php
namespace BDBulkSMS\LaravelSms\Console\Commands;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use BDBulkSMS\LaravelSms\Models\SmsLog;

class CleanupSmsLogsCommand extends Command
{
    protected $signature = 'sms:cleanup {--days= : Number of days to keep logs (overrides config)}';
    protected $description = 'Delete old SMS logs from database';

    public function handle()
    {
        $days = $this->option('days') ? (int)$this->option('days') : config('bdbulksms.log_retention_days');
        if(empty($days) || $days <= 0){$this->error('Log cleanup disabled. Set log_retention_days in config or use --days option.'); return 0;}
        $cutoff = Carbon::now()->subDays($days);
        $deleted = SmsLog::where('created_at','<',$cutoff)->delete();
        $this->info("✅ Deleted {$deleted} SMS log(s) older than {$days} days.");
    }
}
