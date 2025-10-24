<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Review;


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
        $review = Review::first();

        if ($review) {
            $review->load('rating');
        }
        session()->flash('edit_form', true);
        return view('rapha.user.write-review', compact('review'));
    }

    public function writeReview (Request $request){
        $verified = $request->validate([
            "rating_id" => "required|exists:ratings,id",
            "content" => "required|string|min:20|max:250"       
    ]);
        Review::create($verified);
        return back()->with('reviewSuccess','Review Created. Thank you!');
    }

    // public function showReviews(){
    //     return view('rapha.user.reviews');
    // }

    public function showProfile(){
        $profile = User::where('id', Auth::user()->id)->first();
        session()->flash('edit_form', true);
        return view('rapha.user.profile', compact('profile'));
    }
}
