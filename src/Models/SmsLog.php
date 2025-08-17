<?php
namespace BDBulkSMS\LaravelSms\Models;
use Illuminate\Database\Eloquent\Model;

class SmsLog extends Model
{
    protected $fillable = ['to','message','status','statusmsg'];
}
