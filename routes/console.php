<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Console\Commands\CleanExpiredPendingReservations;
use App\Console\Commands\SendCheckoutNotifications;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command(CleanExpiredPendingReservations::class)->hourly();
Schedule::command(SendCheckoutNotifications::class)->hourly();
