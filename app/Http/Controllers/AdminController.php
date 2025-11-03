<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PendingReservation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function showAdminDashboard(){
        $pending = PendingReservation::withoutGlobalScope('user')->get()->count();
        return view('rapha.admin.dashboard', compact('pending'));
    }

     public function showAllPendingReservations(Request $request){
        $reservations = PendingReservation::withoutGlobalScope('user')->orderBy('id', 'desc')->get();
        $pending = $request->session()->get('pending');
        return view('rapha.admin.reservations', compact('reservations','pending'));
    }

    public function showAdminProfile(){
        $profile = Auth::user();
        session()->flash('edit_form', true);
        return view('rapha.admin.profile', compact('profile'));
    }

    public function showPendingDetails($pending){
        $pending = PendingReservation::withoutGlobalScope('user')->findOrFail($pending);
        $pending->load('room');
        return back()->with('reservationModal','reservationDetails')->with('pending',$pending);
    }

}
