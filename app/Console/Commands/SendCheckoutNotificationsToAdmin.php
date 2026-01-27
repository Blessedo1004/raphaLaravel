<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ActiveReservation;
use App\Models\User;
use App\Notifications\CheckOut;
use Carbon\Carbon;

class SendCheckoutNotificationsToAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'checkout:notify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send notifications to admins for checkouts happening today.';

    /**

     * Execute the console command.
     */
    
    public function handle()
    {
        $admins = User::where('role', 'admin')->get();
        
        ActiveReservation::with('user')
            ->where('check_out_date', '<', Carbon::now())
            ->chunkById(100, function ($reservations) use ($admins, &$notificationCount) {
                foreach ($reservations as $reservation) {
                    foreach ($admins as $admin) {
                        $admin->notify(new CheckOut($reservation));
                        $notificationCount++;
                    }
                }
            });

        $this->info("$notificationCount checkout notifications sent.");
    }
}
