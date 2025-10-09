<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function showMakeBooking(){
        return view('rapha.user.make-booking');
    }
}
