<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordController extends Controller
{

     //show forgot password view

    public function showForgotPassword (){
        return view ('rapha.auth.forgot-password');
    }

    // forgot password
    public function forgotPassword (Request $request){
        $verified = $request->validate(['email' => 'required|email']);

        $existingCode =   Cache::get('forgot_password_email_code'. $verified['email']);

        if($existingCode){
            Cache::forget('forgot_password_for'. $existingCode);
            Cache::forget('forgot_password_email_code'. $verified['email']);
        }
        
        $user = User::where('email', $verified['email'])->first();

        if (!$user) {
            session()->flash('from_verification_form', true);
            return back()->withErrors(['email' => 'Email doesn\'t exist']);
        }

        $code = Str::random(10);
        $email = $verified['email'];
        Cache::put('forgot_password_for' . $code, $email, 60 * 20);
        Cache::put('forgot_password_email_code' . $email, $code, 60 * 20);

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

    public function codeVerification(Request $request){
      $code = $request->validate(['code'=>'required|string']);

      $userEmail = Cache::get('forgot_password_for' . $code['code']);

      if (!$userEmail) {
        session()->flash('from_verification_form', true);
        return back()->withErrors(['email' =>'Code is invalid or expired']);
      }

      session(['codeVerifySuccess' => 'You can now reset your password']);
      session()->flash('from_verification_form', true);
      return view('rapha.auth.reset-password' , ['code' => $code['code'], 'email' => $userEmail]);
    }

    public function resetPassword(Request $request){
        $details = $request->validate([
            'code' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string|confirmed|min:8'
        ]);
        
        $cachedEmail = Cache::get('forgot_password_for' . $details['code']);

        if(!$cachedEmail || $cachedEmail != $details['email']){
            session()->flash('from_verification_form', true);
            return back()->withErrors(['email' => 'Session expired. Try again']);
        }

        $user= User::where('email', $cachedEmail);
        $user->update(['password' => Hash::make($details['password'])]);

        Cache::forget('forgot_password_for' . $details['code']);
        Cache::forget('forgot_password_email_code' . $cachedEmail);

        return redirect()->route('rapha.login')->with('resetSuccess', 'Pssword Reset Successful. You can now login');
    }
}
