<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Mail\ForgotPasswordEmail;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{

     //show forgot password view

    public function showForgotPassword (){
        return view ('rapha.auth.forgot-password');
    }

    // show reset password view 

    public function showResetPassword(Request $request){
        $email = $request->session()->get('email');
        $token = $request->session()->get('token');
        return view('rapha.auth.reset-password', compact('email', 'token'));
    }

    // forgot password
    public function forgotPassword (Request $request){
        $verified = $request->validate(['email' => 'required|email']);
        $lowerCaseEmail = strtolower($verified['email']);

        $existingCode =   Cache::get('forgot_password_email_code'. $lowerCaseEmail);

        if($existingCode){
            Cache::forget('forgot_password_for'. $existingCode);
            Cache::forget('forgot_password_email_code'. $lowerCaseEmail);
        }
        
        $user = User::where('email', $lowerCaseEmail)->first();

        if (!$user) {
            session()->flash('from_verification_form', true);
            return back()->withErrors(['email' => 'Email doesn\'t exist']);
        }

       $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $email = $lowerCaseEmail;
        Cache::put('forgot_password_for' . $code, $email, 60 * 20);
        Cache::put('forgot_password_email_code' . $email, $code, 60 * 20);

        Mail::to($email)->send(new ForgotPasswordEmail($code));
        session()->flash('from_verification_form', true);
        return redirect()->route('forgotpassword.verify')->with('email', $email);
    }

    //show verify code view

    public function showCodeVerification(Request $request){
        $email = $request->session()->get('email');
        return view('rapha.auth.forgot-password-verify', compact('email'));
    }

    

     //verify code
    public function codeVerification(Request $request){
      $code = $request->validate(['code'=>'required|string']);

      $userEmail = Cache::get('forgot_password_for' . $code['code']);

      if (!$userEmail) {
        session()->flash('from_verification_form', true);
        return back()->withErrors(['email' =>'Code is invalid or expired']);
      }

      Cache::forget('forgot_password_for' . $code['code']);
      Cache::forget('forgot_password_email_code' . $userEmail);

      $token = Str::random(64);

      Cache::put('forgot_password_for' . $token, $userEmail, 60*20);
      Cache::put('forgot_password_email_token' . $userEmail, $token, 60*20);
      session()->flash('from_verification_form', true);
      
      return redirect()->route('resetPassword')->with('email', $userEmail)->with('token', $token)->with('codeVerifySuccess' ,'Code verified! You can now reset your password');
    }

    //resend code

     public function resendCode (Request $request){
       $email= $request->validate(['email'=>'required|email']);

       

        $oldCode = Cache::get('forgot_password_email_code' . $email['email']);
        $userEmail = Cache::get('forgot_password_for' . $oldCode);

        
        if ($userEmail) {
           Cache::forget('forgot_password_for' . $oldCode);
           Cache::forget('forgot_password_email_code' . $email['email']);
        }
       

        $newCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $userEmail = $email['email'];

         Cache::put('forgot_password_for'. $newCode, $userEmail, 60 * 20);
        Cache::put('forgot_password_email_code'. $userEmail, $newCode, 60 * 20);

         Mail::to($userEmail)->send(new ForgotPasswordEmail($newCode));
        session()->flash('from_verification_form', true);
        return back()->with('resendSuccess2','Code resent. Check your email')->with('email', $userEmail);
    }

     //reset password
    public function resetPassword(Request $request){
        $details = $request->validate([
            'token' => 'required|string',
            'email' => 'required|email',
             'password' => [
                            'required',
                            'string',
                            'min:8',
                            'regex:/[a-z]/',
                            'regex:/[A-Z]/',
                            'regex:/[0-9]/',
                            'regex:/[@$!%*#?&]/',
                            'confirmed',
                        ],
        ]);
        
        $cachedEmail = Cache::get('forgot_password_for' . $details['token']);

        if(!$cachedEmail || $cachedEmail != $details['email']){
            session()->flash('from_verification_form', true);
            return back()->withErrors(['email' => 'Session expired. Try again']);
        }

        $user= User::where('email', $cachedEmail);
        $user->update(['password' => Hash::make($details['password'])]);

        Cache::forget('forgot_password_for' . $details['token']);
        Cache::forget('forgot_password_email_token' . $cachedEmail);

        return redirect()->route('rapha.login')->with('resetSuccess', 'Password Reset Successful! You can now login');
    }
}
