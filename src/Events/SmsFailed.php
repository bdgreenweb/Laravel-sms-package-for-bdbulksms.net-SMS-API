<?php
namespace BDBulkSMS\LaravelSms\Events;

class SmsFailed
{
    public $response;
    public function __construct(array $response){ $this->response = $response; }
}
