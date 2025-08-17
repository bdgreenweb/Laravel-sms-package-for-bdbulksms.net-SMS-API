<?php
namespace BDBulkSMS\LaravelSms\Console\Commands;
use Illuminate\Console\Command;
use Sms;

class SendSmsCommand extends Command
{
    protected $signature = 'sms:send {to : Recipient phone number} {message : SMS text}';
    protected $description = 'Send an SMS using bdbulksms.net API';

    public function handle()
    {
        $to = $this->argument('to');
        $message = $this->argument('message');
        $this->info("Sending SMS to {$to}...");
        $response = Sms::send([['to'=>$to,'message'=>$message]]);
        $this->line(json_encode($response, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE));
    }
}
