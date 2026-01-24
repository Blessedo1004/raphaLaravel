<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompletedReservation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Room;

class AnalyticsController extends Controller
{
        //show selected year analytics
    public function currentYear($year)
    { 
        if(Auth::user()->role ==="admin"){
              $allBookedRooms = CompletedReservation::withoutGlobalScope('user')
            ->whereYear('created_at', $year)
            ->select('room_id', DB::raw('count(*) as bookings_count'))
            ->groupBy('room_id')
            ->orderByDesc('bookings_count')
            ->get();
        }    

        else{
             $allBookedRooms = CompletedReservation::whereYear('created_at', $year)
            ->select('room_id', DB::raw('count(*) as bookings_count'))
            ->groupBy('room_id')
            ->orderByDesc('bookings_count')
            ->get();
        }

        if ($allBookedRooms->isEmpty()) {
            return response()->json([]); // Return an empty array if no data
        }
        
        
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

}
