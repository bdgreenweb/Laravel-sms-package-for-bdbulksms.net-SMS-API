# BDBulkSMS Laravel SMS Package

[![License: MIT](https://img.shields.io/badge/License-MIT-blue.svg)](LICENSE)

A **modern Laravel SMS package** for sending SMS via [bdbulksms.net API](https://api.bdbulksms.net/api.php) with **queue support, database logging, events, and scheduler**. Perfect for Bangladesh Bulk SMS integration.

---

## Features

- Send SMS immediately or via queue
- Log all SMS in database (`sms_logs` table)
- Events: `SmsSent` & `SmsFailed`
- Artisan commands:
  - `sms:send {to} {message}`
  - `sms:logs --limit=n`
  - `sms:cleanup --days=n`
- Auto-truncate logs based on config
- Daily scheduled cleanup
- Configurable API URL & token
- Supports Bangla messages

---

## Installation

```bash
composer require bdbulksms/laravel-sms
php artisan vendor:publish --tag=config
php artisan vendor:publish --tag=migrations
php artisan migrate
```

## Usage

```php
use Sms;

// Send immediately
Sms::send([ ['to'=>'+8801xxxxxxx','message'=>'Hello World'] ]);

// Send via queue
Sms::queue([ ['to'=>'+8801xxxxxxx','message'=>'Hello Queue'] ]);
```

## Queue Setup

1. Ensure `QUEUE_CONNECTION=database` in `.env`
2. Run migrations: `php artisan queue:table && php artisan migrate`
3. Start queue worker: `php artisan queue:work`

## .env setup
Login SMS Portal From https://sms.greenweb.com.bd/ and visit developer zone to generate token.

## License

MIT
