<?php
return [
    'api_url' => 'https://api.bdbulksms.net/api.php?json',
    'token'   => env('BD_BULKSMS_TOKEN', ''),
    'log_retention_days' => env('BD_BULKSMS_LOG_RETENTION', 30),
];
