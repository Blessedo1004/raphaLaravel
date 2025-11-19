<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PendingReservation;
use App\Models\ActiveReservation;
use App\Models\CompletedReservation;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    //show admin dashboard
    public function showAdminDashboard(){
        $pending = PendingReservation::withoutGlobalScope('user')->get()->count();
        $active = ActiveReservation::withoutGlobalScope('user')->get()->count();
        $completed = CompletedReservation::withoutGlobalScope('user')->get()->count();
        return view('rapha.admin.dashboard', compact('pending', 'active', 'completed'));
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

}
