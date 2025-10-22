<?php

namespace App\Http\Controllers;
use App\Models\Review;

class GuestController extends Controller
{

    public function home(){
      $reviews =  Review::withoutGlobalScope('user')->get(); // Bypass the global scope
      $reviews->load('user','rating');
        return view('rapha.home', compact('reviews'));
    }


    public function showRooms(){
        return view('rapha.rooms.rooms');
    }

    public function superStudio(){
        return view('rapha.rooms.superstudio');
    }

     public function exclusive(){
        return view('rapha.rooms.exclusive');
    }

    public function classic(){
        return view('rapha.rooms.classic');
    }

    public function premier(){
        return view('rapha.rooms.premier');
    }

    public function luxury(){
        return view('rapha.rooms.luxury');
    }

    public function family (){
        return view('rapha.rooms.family');
    }

    public function ambassador(){
        return view('rapha.rooms.ambassador');
    }

    public function presidential(){
        return view('rapha.rooms.presidential');
    }

    public function hall(){
        return view('rapha.rooms.hall');
    }

    public function apartment(){
        return view('rapha.rooms.apartment');
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
