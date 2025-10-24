<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClearedReservation extends Model
{
     public function room (){
       return  $this->belongsTo(Room::class);
    }

     public function user (){
        return  $this->belongsTo(User::class);
    }
}
