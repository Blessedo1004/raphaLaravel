<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\FilterByUser;

class Review extends Model 
{
    protected $fillable =['content','rating_id', 'user_id'];
    use FilterByUser;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rating()
    {
        return $this->belongsTo(Rating::class);
    }

}
