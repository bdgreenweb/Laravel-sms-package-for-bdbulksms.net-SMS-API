<?php
namespace BDBulkSMS\LaravelSms\Jobs;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use BDBulkSMS\LaravelSms\SmsService;

class SendSmsJob implements ShouldQueue
{
    use Dispatchable, Queueable;
    public $messages;

    public function __construct(array $messages){ $this->messages = $messages; }

    public function handle(SmsService $sms){ $sms->send($this->messages); }
}
