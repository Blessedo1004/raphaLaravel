<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PendingReservation;
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
        $deletedCount = PendingReservation::where('expires_at', '<', Carbon::now())->delete();

        $this->info("$deletedCount expired pending reservations deleted.");
    }
}
