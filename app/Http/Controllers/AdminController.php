<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PendingReservation;
use App\Models\ActiveReservation;
use App\Models\CompletedReservation;
use Illuminate\Support\Facades\Auth;
use App\Models\Room;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    //show admin dashboard
    public function showAdminDashboard(){
        $pending = PendingReservation::withoutGlobalScope('user')->get()->count();
        $active = ActiveReservation::withoutGlobalScope('user')->get()->count();
        $completed = CompletedReservation::withoutGlobalScope('user')->get()->count();
        $currentYear = date('Y');
        $driver = DB::connection()->getDriverName();
        $yearExpression = ($driver === 'sqlite')
            ? "strftime('%Y', created_at)"
            : "YEAR(created_at)";

        $years = CompletedReservation::withoutGlobalScope('user')
            ->select(DB::raw("{$yearExpression} as year"))
            ->distinct()
            ->orderBy('year', 'DESC')
            ->pluck('year')
            ->toArray();
        return view('rapha.admin.dashboard', compact('pending', 'active', 'completed', 'years', 'currentYear'));
    }

    //show selected year analytics
    public function currentYear($year)
    {
        $totalBookings = CompletedReservation::withoutGlobalScope('user')
            ->whereYear('created_at', $year)
            ->count();
        $allBookedRooms = CompletedReservation::withoutGlobalScope('user')
            ->whereYear('created_at', $year)
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


    //show all pending reservations
     public function showAllPendingReservations(Request $request){
        $reservations = $request->session()->get('reservations') ??  PendingReservation::withoutGlobalScope('user')->orderBy('id', 'desc')->get();
        $groupedReservations = $reservations->groupBy(function($reservation) {
            return $reservation->created_at->format('Y-m-d');
        });
        $details = $request->session()->get('details');
        $route = "admin-pending";
        $searchWildcard = 'PendingReservation';
        return view('rapha.admin.reservations', compact('groupedReservations','details','route','searchWildcard'));
    }

    //show all active reservations
    public function showAllActiveReservations(Request $request){
        $reservations = $request->session()->get('reservations') ??  ActiveReservation::withoutGlobalScope('user')->orderBy('id', 'desc')->get();
        $groupedReservations = $reservations->groupBy(function($reservation) {
            return $reservation->created_at->format('Y-m-d');
        });
        $details = $request->session()->get('details');
        $route = "admin-active";
        $searchWildcard = 'ActiveReservation';
        return view('rapha.admin.reservations', compact('groupedReservations','details','route','searchWildcard'));
    }

    //show all completed reservations
    public function showAllCompletedReservations(Request $request){
        $reservations = $request->session()->get('reservations') ?? CompletedReservation::withoutGlobalScope('user')->orderBy('id', 'desc')->get();
        $groupedReservations = $reservations->groupBy(function($reservation) {
            return $reservation->created_at->format('Y-m-d');
        });
        $details = $request->session()->get('details');
        $route = "admin-completed";
        $searchWildcard = 'CompletedReservation';
        return view('rapha.admin.reservations', compact('groupedReservations','details','route','searchWildcard'));
    }

    //show admin user profile
    public function showAdminProfile(){
        $profile = Auth::user();
        session()->flash('edit_form', true);
        return view('rapha.admin.profile', compact('profile'));
    }

    //show pending reservation details
    public function showPendingDetails($details){
        $details = PendingReservation::withoutGlobalScope('user')->findOrFail($details);
        $details->load('room');
        return back()->with('reservationModal','reservationDetails')->with('details',$details);
    }

    //show active reservation details
     public function showActiveDetails($details){
        $details = ActiveReservation::withoutGlobalScope('user')->findOrFail($details);
        $details->load('room');
        return back()->with('reservationModal','reservationDetails')->with('details',$details);
    }

    //show completed reservation details
    public function showCompletedDetails($details){
        $details = CompletedReservation::withoutGlobalScope('user')->findOrFail($details);
        $details->load('room');
        return back()->with('reservationModal','reservationDetails')->with('details',$details);
    }

    //checkin
    public function checkIn($checkin){
        $checkin = PendingReservation::withoutGlobalScope('user')->findOrFail($checkin);
        ActiveReservation::create([
            "user_id" => $checkin->user_id,
            "room_id" => $checkin->room_id,
            "check_in_date" => $checkin->check_in_date,
            "check_out_date" => $checkin->check_out_date,
            "reservation_id" => $checkin->reservation_id,
            "number_of_rooms" => $checkin->number_of_rooms
        ]);

        $checkin->delete();

        return redirect()->route('admin-active-reservations')->with('checkinSuccess', 'Check In Successful');
    }

    //checkout
    public function checkout($checkout){
        $checkout = ActiveReservation::withoutGlobalScope('user')->findOrFail($checkout);
        CompletedReservation::create([
            "user_id" => $checkout->user_id,
            "room_id" => $checkout->room_id,
            "check_in_date" => $checkout->check_in_date,
            "check_out_date" => $checkout->check_out_date,
            "reservation_id" => $checkout->reservation_id,
            "number_of_rooms" => $checkout->number_of_rooms
        ]);

        $room = Room::where('id', $checkout->room_id)->first();
        $room->update(['availability' => $room->availability + $checkout->number_of_rooms]);
        $checkout->delete();
        return redirect()->route('admin-completed-reservations')->with('checkoutSuccess', 'Check Out Successful');
    }

    //search
    public function search(Request $request, $search){
        $searchterm = $request->search;
        $modelClass = "App\\Models\\{$search}";
        $reservations = $modelClass::withoutGlobalScope('user')
            ->with('room')
            ->where('reservation_id', 'like', "%{$searchterm}%")
            ->orderBy('id', 'desc')->get();
            
       return back()->with('reservations',$reservations);
    }

    //show notifications
    public function showNotifications(){
        $notifications = Auth::user()->notifications;
        $notificationsCount = Auth::user()->unreadNotifications->count();
        $groupedNotifications = $notifications->groupBy(function($notification) {
            return $notification->created_at->format('Y-m-d');
        });
        return view('rapha.admin.notifications', compact('groupedNotifications', 'notificationsCount'));
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
