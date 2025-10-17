<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class EditProfileController extends Controller
{
    // show first name details in view
    public function showEditFirstName(){
        $header = 'Edit First Name';
        $placeholder = 'New first name';
        $route = 'edit-first-name';
        $wildcard = 'first_name';
        $profile = User::where('id', Auth::user()->id)->first();
        return view('rapha.user.edit', compact('header','placeholder','route','wildcard','profile'));
    }

    // update first name
    public function editFirstName(Request $request,  $edit){
        $verified = $request->validate(['first_name'=>'required|string|min:6|max:20']);
        $update = User::where('first_name', $edit)->first();
        $update->update(['first_name' =>$verified['first_name']]);
        $name = 'First Name';
        return redirect()->route('profile')->with('editSuccess', $name . ' Updated');
    }

    // show last name details in view
    public function showEditLastName(){
        $header = 'Edit Last Name';
        $placeholder = 'New last name';
        $route = 'edit-last-name';
        $wildcard = 'last_name';
        $profile = User::where('id', Auth::user()->id)->first();
        return view('rapha.user.edit', compact('header','placeholder','route','wildcard','profile'));
    }

    // update last name
     public function editLastName(Request $request,  $edit){
        $verified = $request->validate(['last_name'=>'required|string|min:6|max:20']);
        $update = User::where('last_name', $edit)->first();
        $update->update(['last_name' =>$verified['last_name']]);
        $name = 'Last Name';
        return redirect()->route('profile')->with('editSuccess', $name . ' Updated');
    }

    // show user name details in view
    public function showEditUserName(){
        $header = 'Edit User Name';
        $placeholder = 'New User name';
        $route = 'edit-user-name';
        $wildcard = 'user_name';
        $profile = User::where('id', Auth::user()->id)->first();
        return view('rapha.user.edit', compact('header','placeholder','route','wildcard','profile'));
    }


    // update user name
     public function editUserName(Request $request,  $edit){
        $verified = $request->validate(['user_name'=>'required|string|min:6|max:20']);
        $update = User::where('user_name', $edit)->first();
        $update->update(['user_name' =>$verified['user_name']]);
        $name = 'User Name';
        return redirect()->route('profile')->with('editSuccess', $name . ' Updated');
    }

    // show user name details in view
    public function showEditPhoneNumber(){
        $header = 'Edit Phone Number';
        $placeholder = 'New Phone Number';
        $route = 'edit-phone-number';
        $wildcard = 'phone_number';
        $profile = User::where('id', Auth::user()->id)->first();
        return view('rapha.user.edit', compact('header','placeholder','route','wildcard','profile'));
    }


    // update phone number
     public function editPhoneNumber(Request $request,  $edit){
        $verified = $request->validate(['phone_number'=>'required|string|size:11']);
        $update = User::where('phone_Number', $edit)->first();
        $update->update(['phone_number' =>$verified['phone_number']]);
        $name = 'Phone Number';
        return redirect()->route('profile')->with('editSuccess', $name . ' Updated');
    }


}
