<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Mail\ForgotPasswordEmail;
use App\Mail\PreregisterEmail;

class ForgotPasswordController extends Controller
{

     //show forgot password view

    public function showForgotPassword (){
        return view ('rapha.auth.forgot-password');
    }

    // show reset password view 

    public function showResetPassword(Request $request){
        $email = $request->session()->get('email');
        $code = $request->session()->get('code');
        session(['codeVerifySuccess' => 'Email verified! You can now reset your password']);
        return view('rapha.auth.reset-password', compact('email', 'code'));
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

       $code = str_pad(random_int(1, 999999), 6, '0', STR_PAD_LEFT);
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
      $code = $request->validate(['code'=>'required|integer']);

      $userEmail = Cache::get('forgot_password_for' . $code['code']);

      if (!$userEmail) {
        session()->flash('from_verification_form', true);
        return back()->withErrors(['email' =>'Code is invalid or expired']);
      }

      session()->flash('from_verification_form', true);
      
      return redirect()->route('resetPassword')->with('email', $userEmail)->with('code', $code['code']);
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
       

        $newCode = str_pad(random_int(1, 999999), 6, '0', STR_PAD_LEFT);
        $userEmail = $email['email'];

         Cache::put('forgot_password_for'. $newCode, $userEmail, 60 * 20);
        Cache::put('forgot_password_email_code'. $userEmail, $newCode, 60 * 20);

         Mail::to($userEmail)->send(new PreregisterEmail($newCode));
        session()->flash('from_verification_form', true);
        return back()->with('resendSuccess2','Code resent. Check your email');
    }

     //reset password
    public function resetPassword(Request $request){
        $details = $request->validate([
            'code' => 'required|integer',
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
        
        $cachedEmail = Cache::get('forgot_password_for' . $details['code']);

        if(!$cachedEmail || $cachedEmail != $details['email']){
            session()->flash('from_verification_form', true);
            return back()->withErrors(['email' => 'Session expired. Try again']);
        }

        $user= User::where('email', $cachedEmail);
        $user->update(['password' => Hash::make($details['password'])]);

        Cache::forget('forgot_password_for' . $details['code']);
        Cache::forget('forgot_password_email_code' . $cachedEmail);

        return redirect()->route('rapha.login')->with('resetSuccess', 'Password Reset Successful! You can now login');
    }
}
