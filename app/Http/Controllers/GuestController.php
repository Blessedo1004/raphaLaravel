<?php

namespace App\Http\Controllers;
use App\Models\Review;
use App\Models\Room;

class GuestController extends Controller
{

    public function home(){
      $reviews =  Review::withoutGlobalScope('user')->limit(5)->orderBy('id', 'desc')->get();
      $reviews->load('user','rating');
        return view('rapha.home', compact('reviews'));
    }


    public function showRooms(){
        return view('rapha.rooms.rooms');
    }

    public function superStudio(){
        $room = Room::where('name', 'Super Studio Room')->first();
        return view('rapha.rooms.superstudio', compact('room'));
    }

     public function exclusive(){
        $room = Room::where('name', 'Exclusive Room')->first();
        return view('rapha.rooms.exclusive' , compact('room'));
    }

    public function classic(){
        $room = Room::where('name', 'Classic Room')->first();
        return view('rapha.rooms.classic' , compact('room'));
    }

    public function premier(){
        $room = Room::where('name', 'Premier Room')->first();
        return view('rapha.rooms.premier' , compact('room'));
    }

    public function luxury(){
        $room = Room::where('name', 'Luxury Room')->first();
        return view('rapha.rooms.luxury' , compact('room'));
    }

    public function family (){
        $room = Room::where('name', 'Family Room')->first();
        return view('rapha.rooms.family' , compact('room'));
    }

    public function ambassador(){
        $room = Room::where('name', 'Ambassador Suite')->first();
        return view('rapha.rooms.ambassador' , compact('room'));
    }

    public function presidential(){
        $room = Room::where('name', 'Presidential Suite')->first();
        return view('rapha.rooms.presidential' , compact('room'));
    }

    public function hall(){
        $room = Room::where('name', 'Banquet and Conference Hall')->first();
        return view('rapha.rooms.hall' , compact('room'));
    }

    public function apartment(){
        $room = Room::where('name', 'Apartments')->first();
        return view('rapha.rooms.apartment' , compact('room'));
    }

    public function gallery(){
        return view('rapha.gallery');
    }

    public function about(){
        return view('rapha.about');
    }
    public function contact(){
        return view('rapha.contact');
    }
}
