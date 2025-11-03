<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\FilterByUser;
class ActiveReservation extends Model
{
    use FilterByUser;
     public function room (){
       return  $this->belongsTo(Room::class);
    }

    public function user (){
        return $this->belongsTo(User::class);
    }
}
