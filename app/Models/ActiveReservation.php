<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
class ActiveReservation extends Model
{
    protected $fillable = [
        "user_id", "reservation_id", "check_in_date", "check_out_date", "room_id","number_of_rooms"
    ];
    protected $casts = [
        'check_in_date' => 'date',
        'check_out_date' => 'date',
        'expires_at' => 'datetime',
    ];
    
     public function room (){
       return  $this->belongsTo(Room::class);
    }

    public function user (){
        return $this->belongsTo(User::class);
    }

    protected static function booted()
    {

        self::addGlobalScope('user', function (Builder $builder) {
            if (Auth::check()) {
                $builder->where('user_id', Auth::id());
            }
        });
    }
}
