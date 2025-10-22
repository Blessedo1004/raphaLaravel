<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    public function review()
    {
        return $this->hasMany(Review::class);
    }
}
