<?php
namespace BDBulkSMS\LaravelSms;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Carbon;
use BDBulkSMS\LaravelSms\Jobs\SendSmsJob;
use BDBulkSMS\LaravelSms\Events\SmsSent;
use BDBulkSMS\LaravelSms\Events\SmsFailed;
use BDBulkSMS\LaravelSms\Models\SmsLog;

class SmsService
{
    protected $apiUrl;
    protected $token;

    public function __construct(){ $this->apiUrl=config('bdbulksms.api_url'); $this->token=config('bdbulksms.token'); }

    public function send(array $messages)
    {
        $payload=['smsdata'=>$messages,'token'=>$this->token];
        $response=Http::withHeaders(['Content-Type'=>'application/json'])->post($this->apiUrl,$payload)->json();
        if(is_array($response)){
            foreach($response as $sms){
                SmsLog::create(['to'=>$sms['to']??'','message'=>$sms['message']??'','status'=>$sms['status']??'UNKNOWN','statusmsg'=>$sms['statusmsg']??'']);
                if(isset($sms['status']) && strtoupper($sms['status'])==='SENT'){ Event::dispatch(new SmsSent($sms)); }
                else{ Event::dispatch(new SmsFailed($sms)); }
            }
            $days=config('bdbulksms.log_retention_days');
            if(!empty($days) && $days>0){ SmsLog::where('created_at','<',Carbon::now()->subDays($days))->delete(); }
        }
        return $response;
    }

    public function queue(array $messages){ SendSmsJob::dispatch($messages); return true; }
}
