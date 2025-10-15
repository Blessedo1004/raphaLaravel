<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function showMakeReservation(){
        return view('rapha.user.make-reservation');
    }

     public function showDashboard(){
        return view('rapha.user.dashboard');
    }

    public function showReservations(){
        return view('rapha.user.reservations');
    }

    public function makeReservation(){
        return view('rapha.user.reservations');
    }

    public function showWriteReview(){
        return view('rapha.user.write-review');
    }

    public function showReviews(){
        return view('rapha.user.reviews');
    }

        public function showProfile(){

            $profile = Auth::user();

            $header = 'Edit First Name';

            $placeholder = 'New first name';

            $route = 'edit-first-name';

            $wildcard = 'first_name';

            return view('rapha.user.profile', compact('profile', 'header', 'placeholder', 'route', 'wildcard'));

        }
}
