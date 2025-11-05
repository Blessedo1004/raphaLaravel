<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PendingReservation;
use App\Models\ActiveReservation;
use App\Models\ClearedReservation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function showAdminDashboard(){
        $pending = PendingReservation::withoutGlobalScope('user')->get()->count();
        $active = ActiveReservation::withoutGlobalScope('user')->get()->count();
        $cleared = ClearedReservation::withoutGlobalScope('user')->get()->count();
        return view('rapha.admin.dashboard', compact('pending', 'active', 'cleared'));
    }

     public function showAllPendingReservations(Request $request){
        $reservations = PendingReservation::withoutGlobalScope('user')->orderBy('id', 'desc')->get();
        $details = $request->session()->get('details');
        $route = "admin-pending";
        return view('rapha.admin.reservations', compact('reservations','details','route'));
    }

    public function showAllActiveReservations(Request $request){
        $reservations = ActiveReservation::withoutGlobalScope('user')->orderBy('id', 'desc')->get();
        $details = $request->session()->get('details');
        $route = "admin-active";
        return view('rapha.admin.reservations', compact('reservations','details','route'));
    }

    public function showAllClearedReservations(Request $request){
        $reservations = ClearedReservation::withoutGlobalScope('user')->orderBy('id', 'desc')->get();
        $details = $request->session()->get('details');
        $route = "admin-cleared";
        return view('rapha.admin.reservations', compact('reservations','details','route'));
    }

    public function showAdminProfile(){
        $profile = Auth::user();
        session()->flash('edit_form', true);
        return view('rapha.admin.profile', compact('profile'));
    }

    public function showPendingDetails($details){
        $details = PendingReservation::withoutGlobalScope('user')->findOrFail($details);
        $details->load('room');
        return back()->with('reservationModal','reservationDetails')->with('details',$details);
    }

     public function showActiveDetails($details){
        $details = ActiveReservation::withoutGlobalScope('user')->findOrFail($details);
        $details->load('room');
        return back()->with('reservationModal','reservationDetails')->with('details',$details);
    }

    public function showClearedDetails($details){
        $details = ClearedReservation::withoutGlobalScope('user')->findOrFail($details);
        $details->load('room');
        return back()->with('reservationModal','reservationDetails')->with('details',$details);
    }

    public function checkIn($checkin){
        $checkin = PendingReservation::withoutGlobalScope('user')->findOrFail($checkin);
        ActiveReservation::create([
            "user_id" => $checkin->user_id,
            "room_id" => $checkin->room_id,
            "check_in_date" => $checkin->check_in_date,
            "check_out_date" => $checkin->check_out_date,
            "reservation_id" => $checkin->reservation_id
        ]);

        $checkin->delete();

        return redirect()->route('admin-active-reservations')->with('checkinSuccess', 'Check In Successful');
    }

    public function checkout($checkout){
        $checkout = ActiveReservation::withoutGlobalScope('user')->findOrFail($checkout);
        ClearedReservation::create([
            "user_id" => $checkout->user_id,
            "room_id" => $checkout->room_id,
            "check_in_date" => $checkout->check_in_date,
            "check_out_date" => $checkout->check_out_date,
            "reservation_id" => $checkout->reservation_id
        ]);

        $checkout->delete();

        return redirect()->route('admin-cleared-reservations')->with('checkoutSuccess', 'Check Out Successful');
    }

}
