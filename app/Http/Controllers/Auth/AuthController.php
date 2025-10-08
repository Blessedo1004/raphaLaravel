<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // show login view
    public function showLogin (){
        return view ('rapha.auth.login');
    }

    //show sign up view
     public function showSignUp (){
        return view ('rapha.auth.signup');
    }

    // save user details temporarily and send verification token
    public function signUp (Request $request){
        $userData = $request->validate([
            'first_name'=>'required|string|min:6|max:20',
            'last_name'=>'required|string|min:6|max:20',
            'user_name'=>'required|string|min:6|max:20|unique:users,user_name',
            'phone_number'=>'required|string|size:11',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|string|min:8|confirmed'
        ]);

         $existingCode =   Cache::get('preregister_email_token'. $userData['email']);

        if($existingCode){
            Cache::forget('preregister_user'. $existingCode);
            Cache::forget('preregister_email_token'. $userData['email']);
        }
        
        $code = Str::random(10);
        Cache::put('preregister_user'. $code, $userData, 60 * 20);
        Cache::put('preregister_email_token'. $userData['email'], $code, 60 * 20);

        // Send verification email
        Mail::send('rapha.emails.verify-preregistration', ['code' => $code], function ($message) use ($userData) {
            $message->to($userData['email']);
            $message->subject('Verify Your Email Address');
        });

                session()->flash('show_preregister_notice', true);
        session()->flash('prereg_email', $userData['email']);

        return redirect()->route('preregister.notice');
        
    }


    //login
    public function login(){

    }
}
