<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ActiveReservation;
use App\Models\User;
use App\Notifications\CheckOutReminder;
use Illuminate\Support\Facades\Mail;
use App\Mail\CheckOutReminderMail;

class SendCheckOutReminderToUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-check-out-reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $targetTime = now()->addHours(2);
        
        ActiveReservation::with('user')
            ->whereBetween('check_out_date', [$targetTime->copy()->startOfMinute(), $targetTime->copy()->endOfMinute()])
            ->chunkById(100, function ($reservations) {
                foreach ($reservations as $reservation) {
                    if ($reservation->user) {
                        $reservation->user->notify(new CheckOutReminder($reservation));
                        Mail::to($reservation->user->email)->send(new CheckOutReminderMail($reservation));
                    }
                }
            });
    }
}
