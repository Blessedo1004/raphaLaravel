<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ActiveReservation;
use App\Models\User;
use App\Notifications\CheckOutNotification;
use Illuminate\Support\Facades\Mail;
use App\Mail\CheckOutNotificationMail;

class SendCheckOutNotificationToUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-check-out-notification';

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
        ActiveReservation::with('user')->where('check_out_date', '<=', now())
            ->chunkById(100, function ($reservations) {
                foreach ($reservations as $reservation) {
                    if ($reservation->user) {
                        $reservation->user->notify(new CheckOutNotification($reservation));
                        Mail::to($reservation->user->email)->send(new CheckOutNotificationMail($reservation));
                    }
                }
            });
    }
}
