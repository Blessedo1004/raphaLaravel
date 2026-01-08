<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    // get room availability
    public function getRoomAvailability(Room $room){
        return response()->json(['availability' => $room->availability]);
    }

    //show make reservation page
    public function showMakeReservation($selectedRoom = null){
        $rooms = Room::orderBy('name')->get();
        $selectedRoom = $selectedRoom ? $selectedRoom : null;
        return view('rapha.user.make-reservation', compact('rooms', 'selectedRoom'));
    }

    //show user dashboard
     public function showDashboard(){
        $pending = PendingReservation::get()->count();
        $active = ActiveReservation::get()->count();
        $completed = CompletedReservation::get()->count();
        $currentYear = date('Y');
        $driver = DB::connection()->getDriverName();
        $yearExpression = ($driver === 'sqlite')
            ? "strftime('%Y', created_at)"
            : "YEAR(created_at)";

        $years = CompletedReservation::select(DB::raw("{$yearExpression} as year"))
            ->distinct()
            ->orderBy('year', 'DESC')
            ->pluck('year')
            ->toArray();
        return view('rapha.user.dashboard', compact('pending', 'active', 'completed', 'years', 'currentYear'));
    }

        //show selected year analytics
    public function currentYear($year){
        $allBookedRooms = CompletedReservation::whereYear('created_at', $year)
            ->select('room_id', DB::raw('count(*) as bookings_count'))
            ->groupBy('room_id')
            ->orderByDesc('bookings_count')
            ->get();

        if ($allBookedRooms->isEmpty()) {
            return response()->json([]); // Return an empty array if no data
        }
        
        // Now, let's get the room details for each room_id and combine the data.
        $roomIds = $allBookedRooms->pluck('room_id');
        $rooms = Room::find($roomIds)->keyBy('id'); // Key by ID for easy lookup

        $result = $allBookedRooms->map(function ($bookedRoom) use ($rooms) {
            $room = $rooms->get($bookedRoom->room_id);
            return [
                'room_name' => $room ? $room->name : 'Unknown Room',
                'bookings_count' => $bookedRoom->bookings_count,
                'room_id' => $bookedRoom->room_id,
            ];
        });

        return response()->json($result);
    }

    //show user's pending reservations
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

    //show user's active reservations
    public function showActiveReservations(Request $request){
        $details = $request->session()->get('details');
        $route = "active";
        $reservations = ActiveReservation::orderBy('id', 'desc')->get();
        $groupedReservations = $reservations->groupBy(function($reservation) {
            return $reservation->created_at->format('Y-m-d');
        });
        return view('rapha.user.reservations', compact('groupedReservations','details','route'));
    }


    //show user's completed reservations
    public function showCompletedReservations(Request $request){
        $details = $request->session()->get('details');
        $route = "completed";
        $reservations = CompletedReservation::orderBy('id', 'desc')->get();
        $groupedReservations = $reservations->groupBy(function($reservation) {
            return $reservation->created_at->format('Y-m-d');
        });
        return view('rapha.user.reservations', compact('groupedReservations','details','route'));
    }

    // make a reservation
    public function makeReservation(Request $request){
        $maxCheckinDate = now()->addDays(3)->format('F j,Y');
        $maxCheckoutDate = now()->addMonths(3)->format('Y-m-d');
        $validatedData = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'check_in_date' => 'required|date|after_or_equal:today|before_or_equal:' . $maxCheckinDate,
            'check_out_date' => 'required|date|after:check_in_date|before_or_equal:' . $maxCheckoutDate,
            'number_of_rooms' => 'required|integer|min:1'
        ]);


        $reservationID = Str::random(6);
        $expiry = Carbon::parse($validatedData['check_in_date'])->addDay();
        $user = Auth::user();
        $userEmail = $user->email;
        $validatedData['reservation_id'] = $reservationID;
        $validatedData['expires_at'] = $expiry;

        $reservation = PendingReservation::create($validatedData);
        $room = Room::where('id', $validatedData['room_id'])->first();
        $room->update(['availability' => $room->availability - $validatedData['number_of_rooms']]);
        $reservation->load('room');
        Mail::to($userEmail)->send(new ReservationEmail($reservation));

        return redirect()->route('reservations')->with('reservationSuccess', 'Reservation made. Please check your email for reservation details.');
    }

    //show write review page
    public function showWriteReview(){
        return view('rapha.user.write-review');
    }

    //submit review
    public function writeReview (Request $request){
        $verified = $request->validate([
            "rating_id" => "required|exists:ratings,id",
            "content" => "required|string|min:20|max:250"       
    ]);
        Review::create($verified);
        return redirect()->route('reviews')->with('reviewSuccess','Review Created. Thank you!');
    }

    //show user's reviews
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

    //show user profile
    public function showProfile(){
        $profile = Auth::user();;
        session()->flash('edit_form', true);
        return view('rapha.user.profile', compact('profile'));
    }

    //show pending reservation details
    public function showPendingDetails(PendingReservation $details){
        $details->load('room');
        return back()->with('reservationModal','reservationDetails')->with('details',$details);
    }

    //show active reservation details
    public function showActiveDetails(ActiveReservation $details){
        $details->load('room');
        return back()->with('reservationModal','reservationDetails')->with('details',$details);
    }

    //show completed reservation details
      public function showCompletedDetails(CompletedReservation $details){
        $details->load('room');
        return back()->with('reservationModal','reservationDetails')->with('details',$details);
    }

    //show edit pending reservation modal
     public function showEditPendingReservation (PendingReservation $pendingDetails){
        return back()->with('showEditReservation','reservationDetails')->with('pendingEdit',$pendingDetails);
    }

    //show delete pending reservation modal
    public function showDeletePendingReservation (PendingReservation $pendingDetails){
        return back()->with('showDeleteReservation','reservationDetails')->with('pendingDelete',$pendingDetails);
    }

      //show notifications
    public function showNotifications(){
        $notifications = Auth::user()->notifications;
        $notificationsCount = Auth::user()->unreadNotifications->count();
        $groupedNotifications = $notifications->groupBy(function($notification) {
            return $notification->created_at->format('Y-m-d');
        });
        return view('rapha.user.notifications', compact('groupedNotifications', 'notificationsCount'));
    }

    //mark a notification as read
    public function markAsRead($id){
        $notification = Auth::user()->unreadNotifications->where('id', $id)->first();
        if($notification){
            $notification->markAsRead();
        }
        return back();
    }

    //mark all notifications as read
    public function markAllAsRead(){
        Auth::user()->unreadNotifications->markAsRead();
        return back();
    }
}
