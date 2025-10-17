<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class EditProfileController extends Controller
{
    // show 
    public function showEditFirstName(){
        $header = 'Edit First Name';
        $placeholder = 'New first name';
        $route = 'edit-first-name';
        $user = User::where('first_name', Auth::user()->first_name)->first();
        $wildcard = 'first_name';
        $profile = User::where('id', Auth::user()->id)->first();
        return view('rapha.user.edit', compact('header','placeholder','route','user','wildcard','profile'));
    }

    public function editFirstName(Request $request,  $edit){
        $verified = $request->validate(['first_name'=>'required|string|min:6|max:20']);
        $update = User::where('first_name', $edit)->first();
        $update->update(['first_name' =>$verified['first_name']]);
        $name = 'First Name';
        return redirect()->route('profile')->with('editSuccess', $name . ' Updated');
    }

    public function showEditLastName(){
        $header = 'Edit Last Name';
        $placeholder = 'New last name';
        $route = 'edit-last-name';
        $user = User::where('last_name', Auth::user()->first_name)->first();
        $wildcard = 'last_name';
        $profile = User::where('id', Auth::user()->id)->first();
        return view('rapha.user.edit', compact('header','placeholder','route','user','wildcard','profile'));
    }

     public function editLastName(Request $request,  $edit){
        $verified = $request->validate(['last_name'=>'required|string|min:6|max:20']);
        $update = User::where('last_name', $edit)->first();
        $update->update(['last_name' =>$verified['last_name']]);
        $name = 'Last Name';
        return redirect()->route('profile')->with('editSuccess', $name . ' Updated');
    }
}
