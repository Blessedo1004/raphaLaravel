<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Review;
use App\Models\Room;
use App\Models\PendingReservation;
use App\Models\ActiveReservation;
use App\Models\ClearedReservation;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationEmail;

class UserController extends Controller
{
    public function showMakeReservation(){
        $rooms = Room::orderBy('name')->get();
        return view('rapha.user.make-reservation', compact('rooms'));
    }

     public function showDashboard(){
        $pending = PendingReservation::get()->count();
        $active = ActiveReservation::get()->count();
        $cleared = ClearedReservation::get()->count();
        return view('rapha.user.dashboard', compact('pending', 'active', 'cleared'));
    }

    public function showPendingReservations(Request $request){
        $details = $request->session()->get('details');
        $pendingEdit = $request->session()->get('pendingEdit');
        $pendingDelete = $request->session()->get('pendingDelete');
        $route = "pending";
        $reservations = PendingReservation::orderBy('id', 'desc')->get();
        $rooms = Room::all();
        return view('rapha.user.reservations', compact('reservations','details', 'pendingEdit', 'rooms','route','pendingDelete'));
    }

    public function showActiveReservations(Request $request){
        $details = $request->session()->get('details');
        $route = "active";
        $reservations = ActiveReservation::orderBy('id', 'desc')->get();
        return view('rapha.user.reservations', compact('reservations','details','route'));
    }


    public function showClearedReservations(Request $request){
        $details = $request->session()->get('details');
        $route = "cleared";
        $reservations = ClearedReservation::orderBy('id', 'desc')->get();
        return view('rapha.user.reservations', compact('reservations','details','route'));
    }

    public function makeReservation(Request $request){
        $maxCheckoutDate = now()->addMonths(3)->format('Y-m-d');
        $validatedData = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after:check_in_date|before_or_equal:' . $maxCheckoutDate,
        ]);

        $reservationID = Str::random(6);
        $expiry = Carbon::parse($validatedData['check_in_date'])->addDay();
        $user = Auth::user();
        $userEmail = $user->email;
        $validatedData['reservation_id'] = $reservationID;
        $validatedData['expires_at'] = $expiry;

        $reservation = PendingReservation::create($validatedData);
        $reservation->load('room');
        Mail::to($userEmail)->send(new ReservationEmail($reservation));

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


    public function showPendingDetails(PendingReservation $details){
        $details->load('room');
        return back()->with('reservationModal','reservationDetails')->with('details',$details);
    }

    public function showActiveDetails(ActiveReservation $details){
        $details->load('room');
        return back()->with('reservationModal','reservationDetails')->with('details',$details);
    }

      public function showClearedDetails(ClearedReservation $details){
        $details->load('room');
        return back()->with('reservationModal','reservationDetails')->with('details',$details);
    }

     public function showEditPendingReservation (PendingReservation $pendingDetails){
        return back()->with('showEditReservation','reservationDetails')->with('pendingEdit',$pendingDetails);
    }

    public function showDeletePendingReservation (PendingReservation $pendingDetails){
        return back()->with('showDeleteReservation','reservationDetails')->with('pendingDelete',$pendingDetails);
    }
}
