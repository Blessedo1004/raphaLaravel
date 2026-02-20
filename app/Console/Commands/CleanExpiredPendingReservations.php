<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PendingReservation;
use App\Models\Room;
use Carbon\Carbon;

class CleanExpiredPendingReservations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reservations:cleanup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete expired pending reservations';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $deletedCount = 0;
        PendingReservation::with('room')
            ->where('expires_at', '<', Carbon::now())
            ->chunkById(100, function ($expiredReservations) use (&$deletedCount) {
                foreach ($expiredReservations as $reservation) {
                    if ($reservation->room) {
                        $reservation->room->availability = (int)$reservation->room->getAttributes()['availability'] + $reservation->number_of_rooms;
                        $reservation->room->save();
                    }

                    $reservation->delete();
                    $deletedCount++;
                }
            });


        $this->info("$deletedCount expired pending reservations deleted.");
    }
}
