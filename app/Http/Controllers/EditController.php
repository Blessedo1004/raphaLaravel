<?php

namespace App\Http\Controllers;

use App\Models\PendingReservation;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Review;
use Carbon\Carbon;

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
        if(Auth::user()->role==="regular"){
        return redirect()->route('profile')->with('editSuccess', $name . ' Updated');
        }
        return redirect()->route('admin-profile')->with('editSuccess', $name . ' Updated');
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
        if(Auth::user()->role==="regular"){
        return redirect()->route('profile')->with('editSuccess', $name . ' Updated');
        }
        return redirect()->route('admin-profile')->with('editSuccess', $name . ' Updated');
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
        if(Auth::user()->role==="regular"){
        return redirect()->route('profile')->with('editSuccess', $name . ' Updated');
        }
        return redirect()->route('admin-profile')->with('editSuccess', $name . ' Updated');
    }

    // show phone Number in view
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
        if(Auth::user()->role==="regular"){
        return redirect()->route('profile')->with('editSuccess', $name . ' Updated');
        }
        return redirect()->route('admin-profile')->with('editSuccess', $name . ' Updated');
    }

    // show password in view
    public function showChangePassword(){
        $header = 'Change Password';
        $placeholder = 'New Password';
        $route = 'change-password';
        $name = 'password';
        $profile = User::where('id', Auth::user()->id)->first();
        return view('rapha.user.edit', compact('header','placeholder','route','name','profile'));
    }

    // change password
     public function changePassword(Request $request, User  $edit){
        $verified = $request->validate(['password'=>'required|string|min:8|confirmed']);
        $edit->update($verified);
        $name = 'Password';
        if(Auth::user()->role==="regular"){
        return redirect()->route('profile')->with('editSuccess', $name . ' Updated');
        }
        return redirect()->route('admin-profile')->with('editSuccess', $name . ' Updated');
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

    // delete review
    public function deleteReview(Review $review){
        $review->delete();
        return back()->with('deleteReviewSuccess', 'Review Deleted');
    }

    // delete account
    public function deleteAccount(Request $request,User $account){
        $account->delete();
        Auth::logout();
        $request->session()->invalidate();
        return redirect()->route('login')->with('deleteAccountSuccess', 'Account Deleted');
    }

    // edit reservation
    public function editReservation (Request $request, PendingReservation $edit){
       $maxCheckoutDate = now()->addMonths(3)->format('Y-m-d');
        $validatedData = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after:check_in_date|before_or_equal:' . $maxCheckoutDate,
        ]);

        $expiry = Carbon::parse($validatedData['check_in_date'])->addDay();
        $validatedData['expires_at'] = $expiry;
        $edit->update($validatedData);
        return redirect()->route('reservations')->with('reservationEditSuccess','Reservation Updated Successfully');
    }

    
    // delete reservation
    public function deleteReservation (PendingReservation $reservation){
        $reservation->delete();
        return redirect()->route('reservations')->with('reservationDeleteSuccess','Reservation Deleted Successfully');
    }
}
