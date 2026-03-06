<?php

namespace App\Observers;

use App\Models\PendingReservation;

class PendingReservationObserver
{
    /**
     * Handle the PendingReservation "created" event.
     */
    public function created(PendingReservation $pendingReservation): void
    {
        //
    }

    /**
     * Handle the PendingReservation "updated" event.
     */
    public function updated(PendingReservation $pendingReservation): void
    {
        //
    }

    /**
     * Handle the PendingReservation "deleted" event.
     */
    public function deleted(PendingReservation $pendingReservation): void
    {
        //
    }

    /**
     * Handle the PendingReservation "restored" event.
     */
    public function restored(PendingReservation $pendingReservation): void
    {
        //
    }

    /**
     * Handle the PendingReservation "force deleted" event.
     */
    public function forceDeleted(PendingReservation $pendingReservation): void
    {
        //
    }
}
