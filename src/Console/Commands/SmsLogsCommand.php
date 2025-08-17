<?php
namespace BDBulkSMS\LaravelSms\Console\Commands;
use Illuminate\Console\Command;
use BDBulkSMS\LaravelSms\Models\SmsLog;

class SmsLogsCommand extends Command
{
    protected $signature = 'sms:logs {--limit=10 : Number of recent logs to display}';
    protected $description = 'Display recent SMS logs from the database';

    public function handle()
    {
        $limit = (int)$this->option('limit');
        $logs = SmsLog::latest()->take($limit)->get(['to','message','status','statusmsg','created_at']);
        if($logs->isEmpty()){$this->warn("No SMS logs found."); return 0;}
        $this->table(['To','Message','Status','Status Message','Sent At'],
            $logs->map(fn($log)=>[$log->to, mb_strimwidth($log->message,0,30,'...'), $log->status,
            mb_strimwidth($log->statusmsg,0,40,'...'), $log->created_at->toDateTimeString()]));
    }
}
