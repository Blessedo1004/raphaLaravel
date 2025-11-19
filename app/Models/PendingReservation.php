<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\FilterByUser;
class PendingReservation extends Model
{
    protected $fillable = [
        'room_id',
        'user_id',
        'check_in_date',
        'check_out_date',
        'reservation_id',
        'expires_at',
        'number_of_rooms'
    ];
    use FilterByUser;
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
}
