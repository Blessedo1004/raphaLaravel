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
            return response()->json([]);
        }
        
        
        $roomIds = $allBookedRooms->pluck('room_id');
        $rooms = Room::find($roomIds)->keyBy('id'); // Key by ID for easy lookup

        $result = $allBookedRooms->map(function ($bookedRoom) use ($rooms) {
            $room = $rooms->get($bookedRoom->room_id);
            return [
                'room_name' => $room ? $room->name : 'Unknown Room',
                'bookings_count' => $bookedRoom->bookings_count,
            ];
        });

        return response()->json($result);
    }

    //show analytics of searched room
    public function getRoomAnalytics(Request $request){
        $validatedData = $request->validate([
            'year' => 'required|integer',
            'search' => 'required|string'
        ]);

        $year = $validatedData['year'];
        $search = $validatedData['search'];

        $room = Room::where('name', $search)->first();

        if (!$room) {
            return response()->json(["room" => $search, "count" => 0]);
        }

        if(Auth::user()->role ==="admin"){
            $count = CompletedReservation::withoutGlobalScope('user')
                ->whereYear('created_at', $year)
                ->where("room_id", $room->id)
                ->count();
        }

        else{
            $count = CompletedReservation::whereYear('created_at', $year)
                ->where("room_id", $room->id)
                ->count();
        }
        return response()->json(["room" => $search, "count" => $count]);

    }

    public function getRoomMonthlyAnalytics (Request $request){
        $validatedData = $request->validate([
            "year" => "required|integer",
            "month" => 'required|integer'
        ]);

        $year = $validatedData["year"];
        $month = $validatedData["month"];

            if(Auth::user()->role ==="admin"){
             $allBookedRooms = CompletedReservation::withoutGlobalScope('user')
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->select('room_id', DB::raw('count(*) as bookings_count'))
            ->groupBy('room_id')
            ->orderByDesc('bookings_count')
            ->get();
        }    

        else{
             $allBookedRooms = CompletedReservation::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->select('room_id', DB::raw('count(*) as bookings_count'))
            ->groupBy('room_id')
            ->orderByDesc('bookings_count')
            ->get();
        }

        if ($allBookedRooms->isEmpty()) {
            return response()->json([]);
        }
        
        
        $roomIds = $allBookedRooms->pluck('room_id');
        $rooms = Room::find($roomIds)->keyBy('id'); // Key by ID for easy lookup

        $result = $allBookedRooms->map(function ($bookedRoom) use ($rooms) {
            $room = $rooms->get($bookedRoom->room_id);
            return [
                'room_name' => $room ? $room->name : 'Unknown Room',
                'bookings_count' => $bookedRoom->bookings_count,
            ];
        });

        return response()->json($result);
    }

        public function getRoomMonthlyAnalyticsSearch(Request $request){
        $validatedData = $request->validate([
            'year2' => 'required|integer',
            'month2' => 'required|integer',
            'search' => 'required|string'
        ]);

        $year = $validatedData['year2'];
        $month = $validatedData['month2'];
        $search = $validatedData['search'];

        $room = Room::where('name', $search)->first();

        if (!$room) {
            return response()->json(["room" => $search, "count" => 0]);
        }

        if(Auth::user()->role ==="admin"){
            $count = CompletedReservation::withoutGlobalScope('user')
                ->whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->where("room_id", $room->id)
                ->count();
        }

        else{
            $count = CompletedReservation::whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->where("room_id", $room->id)
                ->count();
        }
        return response()->json(["room" => $search, "count" => $count]);

    }

}
