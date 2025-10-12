<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class ForgotPasswordController extends Controller
{

     //show forgot password view

    public function showForgotPassword (){
        return view ('rapha.auth.forgot-password');
    }

    // forgot password
    public function forgotPassword (Request $request){
        $verified = $request->validate(['email' => 'required|email']);
        
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            session()->flash('from_verification_form', true);
            return back()->withErrors(['email' => 'Email doesn\'t exist']);
        }

        $code = Str::random(10);
        $email = $verified['email'];
        Cache::put('forgot_password_for' . $code, $email, 20 * 20);
        Cache::put('forgot_password_email_code' . $email, $code, 20 * 20);

        Mail::send('rapha.emails.forgot-password', ['code' => $code], function ($message) use ($email){
          $message->to($email);
          $message->subject('Password Reset');
        });
        session()->flash('from_verification_form', true);
        return redirect()->route('forgotpassword.verify')->with('email', $email);
    }

    //show verify code view

    public function showCodeVerification(Request $request){
        $email = $request->session()->get('email');
        return view('rapha.auth.forgot-password-verify', ['email' => $email]);
    }
}
