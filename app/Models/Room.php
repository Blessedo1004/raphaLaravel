<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    public function getAvailabilityAttribute($value)
    {
        if ($value > 0) {
            return $value;
        }
        return 'Unavailable';
    }

    public function pendingReservations(){
        $this->hasMany(PendingReservation::class);
    }

    public function activeReservations(){
        $this->hasMany(ActiveReservation::class);
    }

    public function completedReservations(){
        $this->hasMany(CompletedReservation::class);
    }
}
