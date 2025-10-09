<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Schedule log archival to run monthly (on the 1st day of each month at 2:00 AM)
Schedule::command('logs:archive')->monthlyOn(1, '02:00');
