<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PendingReservation;
use App\Models\ActiveReservation;
use App\Models\CompletedReservation;
use Illuminate\Support\Facades\Auth;
use App\Models\Room;
use App\Models\Review;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Models\User;
use Carbon\Carbon;

class AdminController extends Controller
{
    //show admin dashboard
    public function showAdminDashboard(){
        $pending = PendingReservation::withoutGlobalScope('user')->count();
        $active = ActiveReservation::withoutGlobalScope('user')->count();
        $completed = CompletedReservation::withoutGlobalScope('user')->count();
        $users = User::where('role','regular')->count();
        $latestPendingReservations = PendingReservation::withoutGlobalScope('user')->with(['user:id,first_name,last_name','room:id,name'])->select(['id', 'user_id' , 'room_id', 'created_at'])->orderBy('id', 'desc')->limit(5)->get();
        return view('rapha.admin.dashboard', compact('pending', 'active', 'completed','users','latestPendingReservations'));
    }

    //show admin analytics page
    public function showAdminAnalytics(){
        return view('rapha.admin.analytics');
    }

    //show all rooms
    public function showAllRooms(){
        $rooms = Room::paginate(10)->onEachSide(0);
        session()->flash('change_availability', true);
        return view('rapha.admin.rooms', compact('rooms'));
    }

    //show edit room availability
    public function showEditRoomAvailability(Room $room){
        $title = "Edit " . $room->name ." availability";
        return view('rapha.admin.edit-room-availability', compact('room','title'));
    }

     //edit room availability
    public function editRoomAvailability(Request $request, Room $room){
        $validatedData = $request->validate(["availability" => "required|integer"]);
        $room->update(["availability" => $validatedData['availability']]);
        return redirect()->route('rooms')->with('changeSuccessfull', $room->name . " availability updated successfully");
    }

    //show clients reviews
    public function showClientReviews(){
        $reviews = Review::withoutGlobalScope('user')->with('rating')->paginate(10)->onEachSide(0);
        return view('rapha.admin.client-reviews', compact('reviews'));
    }

    //show filtered clients reviews
    public function showFilteredClientReviews(Request $request){
        $validatedData = $request->validate([
            "startingDate" => "required|date",
            "endingDate" => "required|date|after_or_equal:startingDate",
            "rating" => "required|string"
        ]);

        $startingDate = Carbon::parse($validatedData["startingDate"]);
        $endingDate = Carbon::parse($validatedData["endingDate"]);
        $rating = $validatedData["rating"];

        if ($rating === "all"){
            $reviews = Review::withoutGlobalScope('user')->whereBetween("created_at", [$startingDate->copy()->startOfDay(), $endingDate->copy()->endOfDay()])->with('rating')->paginate(10)->onEachSide(0);
            return response()->json($reviews);
        }

        $reviews = Review::withoutGlobalScope('user')->whereBetween("created_at", [$startingDate->copy()->startOfDay(), $endingDate->copy()->endOfDay()])->where("rating_id", $rating)->with('rating')->paginate(10)->onEachSide(0);
        return response()->json($reviews);
    }

    //show admin user profile
    public function showAdminProfile(){
        $userID = Auth::id();
        $profile =  Cache::remember("user_profile_{$userID}", now()->addMinutes(15), function () use ($userID) {
            return User::findOrFail($userID);
        });
        session()->flash('edit_form', true);
        return view('rapha.admin.profile', compact('profile'));
    }

    //show notifications
    public function showNotifications(){
        $notifications = Auth::user()->notifications()->paginate(10)->onEachSide(0);
        $notificationsCount = Auth::user()->unreadNotifications->count();
        return view('rapha.admin.notifications', compact('notifications', 'notificationsCount'));
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
