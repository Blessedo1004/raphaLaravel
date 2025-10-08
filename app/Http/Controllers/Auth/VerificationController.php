<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class VerificationController extends Controller
{
    // show preregister notice

    public function showPreregisterNotice(Request $request){
        $email = $request->session()->get('prereg_email');
        return view('rapha.auth.preregister-notice', ['email' => $email]);
    }

    //Verify the user email and code
     public function preregisterVerify (Request $request){
        $validatedData = $request->validate(['code'=>'required|string']);
        $code = $validatedData['code'];
        $userData =  Cache::get('preregister_user'. $code);
        if(!$userData){
            session()->flash('from_verification_form', true);
            return back()->with('failed','Code is incorrect or expired. Click resend button below to request another');
        }
        // Delete the cached data
        Cache::forget('preregister_user' . $code);
        Cache::forget('preregister_email_token' . $userData['email']); // Also remove email-to-token mapping

         // Create the user
        User::create($userData);

        


        // return redirect('/login')->with('status', 'Your email has been verified! You can now log in.');
    }

    //Resend code

    public function preregisterResend (Request $request){
       $email= $request->validate(['email'=>'required|email']);

       

        $oldCode = Cache::get('preregister_email_token' . $email['email']);
        $userData = Cache::get('preregister_user' . $oldCode);

        
             if (!$userData) {
            return back()->withErrors(['email' => 'No pending registration found for this email.']);
        }
       

        $newCode = Str::random(10);
        Cache::forget('preregister_user' . $oldCode);
        Cache::forget('preregister_email_token' . $email['email']);

         Cache::put('preregister_user'. $newCode, $userData, 60 * 20);
        Cache::put('preregister_email_token'. $userData['email'], $newCode, 60 * 20);

         Mail::send('rapha.emails.verify-preregistration', ['code' => $newCode], function ($message) use ($userData) {
            $message->to($userData['email']);
            $message->subject('Verify Your Email Address');
        });
        session()->flash('from_verification_form', true);
        return back()->with('resendSuccess','Code resent. Check your email');
    }
}
