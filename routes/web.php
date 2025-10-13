<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\UserController;
Route::get('/', function () {
    return view('rapha.home');
})->name('rapha.home');


// guest routes starts
Route::controller(AuthController::class)->group(function(){
    Route::get('/login','showLogin')->name('login');
    Route::get('/signup','showSignUp')->name('rapha.signup');
    Route::post('/signup','signUp')->name('rapha.signup');
    Route::post('/login','login')->name('rapha.login');
});

//Pre registration verification routes starts
Route::controller(VerificationController::class)->group(function(){
    Route::get('/preregister/notice', 'showPreregisterNotice')->name('preregister.notice')->middleware('preregister.notice');
    Route::post('/preregister/verify', 'preregisterVerify')->name('preregister.verify');
    // Resend email verification route for sign up
    Route::post('/preregister/resend', 'preregisterResend')->name('preregister.resend');
});
// Pre registration verification routes ends


//forgot password routes starts
Route::controller(ForgotPasswordController::class)->group(function(){
    Route::get('/forgotpassword','showForgotPassword')->name('forgotPassword')->middleware('preregister.notice');
    Route::post('/forgotpassword','forgotPassword')->name('forgotPassword');
    Route::get('/forgotpassword/verify','showCodeVerification')->name('forgotpassword.verify')->middleware('preregister.notice');
    Route::post('/forgotpassword/verify','codeVerification')->name('forgotpassword.verify');
    Route::get('/reset-password', 'showResetPassword')->name('resetPassword')->middleware('preregister.notice');
    Route::post('/reset-password', 'resetPassword')->name('resetPassword');
    // Resend code route for forgot password
    Route::get('/forgotpassword/resend')->name('forgot-password.resend')->middleware('preregister.notice');
    Route::post('/forgotpassword/resend', 'resendCode')->name('forgot-password.resend');
});
//forgot password routes ends




Route::controller(GuestController::class)->group(function(){
    // Room routes start
    Route::get('/rooms','showRooms')->name('rapha.rooms');
    Route::get('/rooms/superstudio','superStudio')->name('room.superstudio');
    Route::get('/rooms/exclusive','exclusive')->name('room.exclusive');
    Route::get('/rooms/classic','classic')->name('room.classic');
    Route::get('/rooms/premier','premier')->name('room.premier');
    Route::get('/rooms/luxury','luxury')->name('room.luxury');
    Route::get('/rooms/family','family')->name('room.family');
    Route::get('/rooms/ambassador','ambassador')->name('room.ambassador');
    Route::get('/rooms/presidential','presidential')->name('room.presidential');
    Route::get('/rooms/hall','hall')->name('room.hall');
    Route::get('/rooms/apartment','apartment')->name('room.apartment');
    //Room routes end


    Route::get('/gallery','gallery')->name('rapha.gallery');
    Route::get('/about','about')->name('rapha.about');
    Route::get('/contact','contact')->name('rapha.contact');
});
// guest routes ends

// Auth routes start
Route::middleware('auth')->group(function(){
    // Route::post('/logout',[AuthController::class,'logout'])->name('rapha.logout');
    Route::get('/user/make-booking',[UserController::class,'showMakeBooking'])->name('make-booking');
});
// Auth routes ends