<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Review;
use App\Models\Room;
use App\Models\PendingReservation;
use App\Models\ActiveReservation;
use App\Models\CompletedReservation;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationEmail;

class UserController extends Controller
{
    public function showMakeReservation($selectedRoom = null){
        $rooms = Room::orderBy('name')->get();
        $selectedRoom = $selectedRoom ? Room::findOrFail($selectedRoom) : null;
        return view('rapha.user.make-reservation', compact('rooms', 'selectedRoom'));
    }

     public function showDashboard(){
        $pending = PendingReservation::get()->count();
        $active = ActiveReservation::get()->count();
        $completed = CompletedReservation::get()->count();
        return view('rapha.user.dashboard', compact('pending', 'active', 'completed'));
    }

    public function showPendingReservations(Request $request){
        $details = $request->session()->get('details');
        $pendingEdit = $request->session()->get('pendingEdit');
        $pendingDelete = $request->session()->get('pendingDelete');
        $route = "pending";
        $reservations = PendingReservation::orderBy('id', 'desc')->get();
        $groupedReservations = $reservations->groupBy(function($reservation) {
            return $reservation->created_at->format('Y-m-d');
        });
        $rooms = Room::all();
        return view('rapha.user.reservations', compact('groupedReservations','details', 'pendingEdit', 'rooms','route','pendingDelete'));
    }

    public function showActiveReservations(Request $request){
        $details = $request->session()->get('details');
        $route = "active";
        $reservations = ActiveReservation::orderBy('id', 'desc')->get();
        $groupedReservations = $reservations->groupBy(function($reservation) {
            return $reservation->created_at->format('Y-m-d');
        });
        return view('rapha.user.reservations', compact('groupedReservations','details','route'));
    }


    public function showCompletedReservations(Request $request){
        $details = $request->session()->get('details');
        $route = "completed";
        $reservations = CompletedReservation::orderBy('id', 'desc')->get();
        $groupedReservations = $reservations->groupBy(function($reservation) {
            return $reservation->created_at->format('Y-m-d');
        });
        return view('rapha.user.reservations', compact('groupedReservations','details','route'));
    }

    public function makeReservation(Request $request){
        $maxCheckinDate = now()->addDays(3)->format('Y-m-d');
        $maxCheckoutDate = now()->addMonths(3)->format('Y-m-d');
        $validatedData = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'check_in_date' => 'required|date|after_or_equal:today|before_or_equal:' . $maxCheckinDate,
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
        return view('rapha.user.write-review');
    }

    public function writeReview (Request $request){
        $verified = $request->validate([
            "rating_id" => "required|exists:ratings,id",
            "content" => "required|string|min:20|max:250"       
    ]);
        Review::create($verified);
        return redirect()->route('reviews')->with('reviewSuccess','Review Created. Thank you!');
    }

    public function showReviews(Request $request){
        $reviews = Review::get();
        session()->flash('edit_form', true);
        $selectedReview = $request->session()->get('review');
        return view('rapha.user.reviews', compact('reviews' , 'selectedReview'));
    }

    //show delete review modal
    public function showDeleteReview(Review $review){
        return back()->with('deleteReviewModal', 'delete')->with('review', $review);
    }

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

      public function showCompletedDetails(CompletedReservation $details){
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
