<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Review;
use App\Models\Room;
use App\Models\PendingReservation;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function showMakeReservation(){
        $rooms = Room::orderBy('name')->get();
        return view('rapha.user.make-reservation', compact('rooms'));
    }

     public function showDashboard(){
        return view('rapha.user.dashboard');
    }

    public function showPendingReservations(){
        $reservations = PendingReservation::get();
        return view('rapha.user.reservations', compact('reservations'));
    }

    public function makeReservation(Request $request){
        $maxCheckoutDate = now()->addMonths(3)->format('Y-m-d');
        $validatedData = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after:check_in_date|before_or_equal:' . $maxCheckoutDate,
        ]);

        $reservationID = Str::random(10);
        $expiry = Carbon::parse($validatedData['check_in_date'])->addDay();
        $user = Auth::user();
        $userEmail = $user->email;
        $validatedData['reservation_id'] = $reservationID;
        $validatedData['expires_at'] = $expiry;

        $reservation = PendingReservation::create($validatedData);
        $reservation->load('room');
        Mail::send('rapha.emails.reservation-email', compact('reservation'), function ($message) use ($userEmail){
            $message->to($userEmail);
            $message->subject('Reservation Details');
        });

        return redirect()->route('reservations')->with('reservationSuccess', 'Reservation made. Please check your email for reservation details.');
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
        $profile = Auth::user();;
        session()->flash('edit_form', true);
        return view('rapha.user.profile', compact('profile'));
    }


    public function showPendingDetails(PendingReservation $pending){
        $pending->load('room');
        return view('rapha.user.show-reservation-details', compact('pending'));
    }
}
