<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class EditProfileController extends Controller
{
    public function editFirstName(Request $request,  $firstName){
        $verified = $request->validate(['first_name'=>'required|string']);
        $update = User::where('first_name', $firstName)->first();
        $update->update(['first_name' =>$verified]);
        return redirect()->route('profile')->with('firstName','First Name Updated');
    }
}
