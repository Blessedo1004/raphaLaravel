<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Console\Commands\CleanExpiredPendingReservations;
use App\Console\Commands\SendCheckOutReminderToUser;
use App\Console\Commands\SendCheckoutNotificationsToAdmin;
use App\Console\Commands\SendCheckoutNotificationToUser;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command(CleanExpiredPendingReservations::class)->hourly();
Schedule::command(SendCheckoutNotificationsToAdmin::class)->hourly();
Schedule::command(SendCheckoutReminderToUser::class)->hourly();
Schedule::command(SendCheckoutNotificationToUser::class)->hourly();
