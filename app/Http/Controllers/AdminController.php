<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PendingReservation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function showAdminDashboard(){
        return view('rapha.admin.dashboard');
    }

     public function showAllPendingReservations(){
        $reservations = PendingReservation::withoutGlobalScope('user')->orderBy('id', 'desc')->get();
        $reservations->load('room');
        return view('rapha.admin.reservations', compact('reservations'));
    }

    public function showAdminProfile(){
        $profile = Auth::user();
        session()->flash('edit_form', true);
        return view('rapha.admin.profile', compact('profile'));
    }
}
