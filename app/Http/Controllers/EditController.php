<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Review;

class EditController extends Controller
{
    // show first name details in view
    public function showEditFirstName(){
        $header = 'Edit First Name';
        $placeholder = 'New first name';
        $route = 'edit-first-name';
        $name = 'first_name';
        $profile = User::where('id', Auth::user()->id)->first();
        return view('rapha.user.edit', compact('header','placeholder','route','name','profile'));
    }

    // update first name
    public function editFirstName(Request $request, User $edit){
        $verified = $request->validate(['first_name'=>'required|string|min:3|max:20']);
        $edit->update($verified);
        $name = 'First Name';
        return redirect()->route('profile')->with('editSuccess', $name . ' Updated');
    }

    // show last name details in view
    public function showEditLastName(){
        $header = 'Edit Last Name';
        $placeholder = 'New last name';
        $route = 'edit-last-name';
        $name = 'last_name';
        $profile = User::where('id', Auth::user()->id)->first();
        return view('rapha.user.edit', compact('header','placeholder','route','name','profile'));
    }

    // update last name
     public function editLastName(Request $request, User $edit){
        $verified = $request->validate(['last_name'=>'required|string|min:3|max:20']);
        $edit->update($verified);
        $name = 'Last Name';
        return redirect()->route('profile')->with('editSuccess', $name . ' Updated');
    }

    // show user name details in view
    public function showEditUserName(){
        $header = 'Edit User Name';
        $placeholder = 'New User name';
        $route = 'edit-user-name';
        $name = 'user_name';
        $profile = User::where('id', Auth::user()->id)->first();
        return view('rapha.user.edit', compact('header','placeholder','route','name','profile'));
    }


    // update user name
     public function editUserName(Request $request, User $edit){
        $verified = $request->validate(['user_name'=>'required|string|min:6|max:20|unique:users,user_name']);
        $edit->update($verified);
        $name = 'User Name';
        return redirect()->route('profile')->with('editSuccess', $name . ' Updated');
    }

    // show user name details in view
    public function showEditPhoneNumber(){
        $header = 'Edit Phone Number';
        $placeholder = 'New Phone Number';
        $route = 'edit-phone-number';
        $name = 'phone_number';
        $profile = User::where('id', Auth::user()->id)->first();
        return view('rapha.user.edit', compact('header','placeholder','route','name','profile'));
    }


    // update phone number
     public function editPhoneNumber(Request $request, User  $edit){
        $verified = $request->validate(['phone_number'=>'required|string|size:11']);
        $edit->update($verified);
        $name = 'Phone Number';
        return redirect()->route('profile')->with('editSuccess', $name . ' Updated');
    }


    //show edit review
    public function showEditReview(){
        $review = Review::where('user_id', Auth::user()->id)->first();
        return view('rapha.user.edit-review', compact('review'));
    }

    //edit review
    public function editReview(Request $request, Review $edit){
         $verified = $request->validate([
            "rating_id" => "required|exists:ratings,id",
            "content" => "required|string|min:20|max:250"       
    ]);
        $edit->update($verified);
         return redirect()->route('write-review')->with('editReviewSuccess','Review Edited Successfully');
    }
}
