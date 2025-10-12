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
Route::middleware('cache.headers:no_store,private')->controller(AuthController::class)->group(function(){
    Route::get('/login','showLogin')->name('login');
    Route::get('/signup','showSignUp')->name('rapha.signup');
    Route::post('/signup','signUp')->name('rapha.signup');
    Route::post('/login','login')->name('rapha.login');
});

//verification routes starts
Route::controller(VerificationController::class)->group(function(){
    Route::get('/preregister/notice', 'showPreregisterNotice')->name('preregister.notice')->middleware('preregister.notice');
    Route::post('/preregister/verify', 'preregisterVerify')->name('preregister.verify');
    // Resend email verification route for sign up
    Route::post('/preregister/resend', 'preregisterResend')->name('preregister.resend');
});
//verification routes ends


//forgot password routes starts
Route::controller(ForgotPasswordController::class)->group(function(){
    Route::get('/forgotpassword','showForgotPassword')->name('forgotPassword')->middleware('preregister.notice');
    Route::post('/forgotpassword','forgotPassword')->name('forgotPassword');
    Route::get('/forgotpasswordCode','showCodeVerification')->name('forgotpassword.verify')->middleware('preregister.notice');
});
//verification routes ends

// guest routes ends


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


// Auth routes start

Route::middleware('auth')->group(function(){
    // Route::post('/logout',[AuthController::class,'logout'])->name('rapha.logout');
    Route::get('/user/make-booking',[UserController::class,'showMakeBooking'])->name('make-booking');
});