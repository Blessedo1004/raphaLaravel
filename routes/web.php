<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EditController;



// guest routes starts
Route::middleware('cache.headers:no_store,private')->controller(AuthController::class)->group(function(){
    Route::get('/login','showLogin')->name('login');
    Route::post('/login','login')->name('rapha.login');
    Route::get('/signup','showSignUp')->name('rapha.signup');
    Route::post('/signup','signUp')->name('rapha.signup');
});

Route::post('/logout',[AuthController::class,'logout'])->name('logout');

//Pre registration verification routes starts
Route::middleware('cache.headers:no_store,private')->controller(VerificationController::class)->group(function(){
    Route::get('/preregister/notice', 'showPreregisterNotice')->name('preregister.notice')->middleware('preregister.notice');
    Route::post('/preregister/verify', 'preregisterVerify')->name('preregister.verify');
    // Resend email verification route for sign up
    Route::post('/preregister/resend', 'preregisterResend')->name('preregister.resend');
});
// Pre registration verification routes ends


//forgot password routes starts
Route::middleware('cache.headers:no_store,private')->controller(ForgotPasswordController::class)->group(function(){
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

    Route::get('/','home')->name('rapha.home');
    Route::get('/gallery','gallery')->name('rapha.gallery');
    Route::get('/about','about')->name('rapha.about');
    Route::get('/contact','contact')->name('rapha.contact');
});
// guest routes ends

// Auth routes starts

Route::group(['middleware'=>['auth','cache.headers:no_store,private']],function(){
    Route::controller(EditController::class)->group(function(){
        //edit profile info starts
    Route::get('/profile-edit-first-name','showEditFirstName')->name('show-edit-first-name')->middleware('one-time-user');
    Route::put('/profile-edit-first-name/{edit}','editFirstName')->name('edit-first-name');
    Route::get('/profile-edit-last-name','showEditLastName')->name('show-edit-last-name')->middleware('one-time-user');
    Route::put('/profile-edit-last-name/{edit}','editLastName')->name('edit-last-name');
    Route::get('/profile-edit-user-name','showEditUserName')->name('show-edit-user-name')->middleware('one-time-user');
    Route::put('/profile-edit-user-name/{edit}','editUserName')->name('edit-user-name');
    Route::get('/profile-edit-phone-number','showEditPhoneNumber')->name('show-edit-phone-number')->middleware('one-time-user');
    Route::put('/profile-edit-phone-number/{edit}','editPhoneNumber')->name('edit-phone-number');
    Route::get('/change-password','showChangePassword')->name('show-change-password')->middleware('one-time-user');
    Route::put('/change-password/{edit}','changePassword')->name('change-password');
    //edit profile info ends
    });    
});


// regular user routes starts
Route::group(['middleware'=>['auth','can:manage-regular','cache.headers:no_store,private'],'prefix'=>'user'],function(){
    Route::controller(UserController::class)->group(function(){
    Route::get('/dashboard','showDashboard')->name('dashboard');
    Route::get('/make-reservation','showMakeReservation')->name('make-reservation');
    Route::post('/make-reservation','makeReservation')->name('make-reservation');
        Route::group(['prefix'=>'reservations'], function(){
            Route::get('/pending','showPendingReservations')->name('reservations');
            Route::get('/active','showActiveReservations')->name('active');
            Route::get('/cleared','showClearedReservations')->name('cleared');
            Route::get('/pending/{pending}','showPendingDetails')->name('pending');
        });
    Route::get('/write-review','showWriteReview')->name('write-review');
    Route::post('/write-review','writeReview')->name('write-review');
    // Route::get('/user/reviews','showReviews')->name('reviews');
    Route::get('/profile','showProfile')->name('profile');
    //edit reservation
    Route::get('/edit-reservation/{pendingDetails}', 'showEditPendingReservation')->name('edit-pending-reservation');
    });

    
    Route::controller(EditController::class)->group(function(){
    //edit review
    Route::get('/edit-review','showEditReview')->name('show-edit-review')->middleware('one-time-user');
    Route::put('/edit-review/{edit}','editReview')->name('edit-review');
    //delete review and account
    Route::delete('/delete-review/{review}', 'deleteReview')->name('delete-review');
    Route::delete('/delete-account/{account}', 'deleteAccount')->name('delete-account');
    
    
    });
    
});

// normal user routes ends

//admin routes starts
Route::group(['middleware'=>['auth','can:manage-admin','cache.headers:no_store,private'],'prefix'=>'admin'],function(){
    Route::controller(AdminController::class)->group(function(){
        Route::get('/dashboard', 'showAdminDashboard')->name('admin-dashboard');
        Route::group(['prefix'=>'reservations'], function(){
            Route::get('/pending', 'showAllPendingReservations')->name('admin-reservation');
            Route::get('/pending/{pending}','showPendingDetails')->name('admin-pending');
        });
        Route::get('/profile','showAdminProfile')->name('admin-profile');
    });
    
});
//admin routes ends
// Auth routes ends