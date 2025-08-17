<?php
namespace BDBulkSMS\LaravelSms\Events;

class SmsSent
{
    public $response;
    public function __construct(array $response){ $this->response = $response; }
}
