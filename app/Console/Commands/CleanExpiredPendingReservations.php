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
        $expiredReservations = PendingReservation::where('expires_at', '<', Carbon::now())->get();

        $deletedCount = 0;

        foreach ($expiredReservations as $reservation) {
            $room = Room::find($reservation->room_id);

            if ($room) {
                $room->availability += $reservation->number_of_rooms;
                $room->save();
            }

            $reservation->delete();
            $deletedCount++;
        }


        $this->info("$deletedCount expired pending reservations deleted.");
    }
}
