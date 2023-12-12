<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\RolesPermissionApiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\API\UserApiController;
use App\Http\Controllers\API\ProviderApiController;


//User API
Route::post('/user/signup',[UserApiController::class,'userRegistration']);
Route::post('/login',[UserApiController::class,'login']);
Route::post('/user_update',[UserApiController::class,'user_update']);
Route::post('/user_forget',[UserApiController::class,'user_forget']);
Route::post('/use_verify_code',[UserApiController::class,'use_verify_code']);
Route::post('/check_user_email',[UserApiController::class,'check_user_email']);
Route::post('/change_user_status',[UserApiController::class,'change_user_status']);
Route::post('/user_info',[UserApiController::class,'user_info']);


//Provider API
Route::post('/service-provider/signup',[ProviderApiController::class,'serviceProviderRegistration']);
Route::post('/providerLogin',[ProviderApiController::class,'providerLogin']);
Route::post('/check_provider_email',[ProviderApiController::class,'check_provider_email']);
Route::post('/provider_update',[ProviderApiController::class,'provider_update']);
Route::get('/mail-verification',[ProviderApiController::class,'mail_verification']);
Route::post('/forget',[ProviderApiController::class,'forget']);
Route::post('/verify_code',[ProviderApiController::class,'verify_code']);
Route::post('/provider_info',[ProviderApiController::class,'provider_info']);
Route::post('/change_provider_status',[ProviderApiController::class,'change_provider_status']);
Route::post('/provider_location',[ProviderApiController::class,'provider_location']);


//Notification API
Route::post('/sendNotification',[ApiController::class,'sendNotification']);
Route::post('/userNotification',[ApiController::class,'userNotification']);
Route::post('/providerNotification',[ApiController::class,'providerNotification']);
Route::post('/userNotificationCounter',[ApiController::class,'userNotificationCounter']);
Route::post('/providerNotificationCounter',[ApiController::class,'providerNotificationCounter']);
Route::post('/saveProviderToken',[ApiController::class,'saveProviderToken']);
Route::post('/saveUserToken',[ApiController::class,'saveUserToken']);
Route::post('/send_otp',[ApiController::class,'send_otp']);


// Facebook login API
Route::prefix('facebook')->name('facebook.')->group( function(){
    Route::get('auth', [UserController::class, 'loginUsingFacebook'])->name('login');
    Route::get('callback', [UserController::class, 'callbackFromFacebook'])->name('callback');
});

// Google login API
Route::prefix('google')->name('google.')->group( function(){
    Route::get('auth', [UserController::class, 'loginUsingGoogle'])->name('login');
    Route::get('callback', [UserController::class, 'callbackFromGoogle'])->name('callback');
});


//Common API
Route::post('/optForgetUserProvider',[ApiController::class,'optForgetUserProvider']);
Route::post('/verifyOtpUserProvider',[ApiController::class,'verifyOtpUserProvider']);



// Admin API
Route::post('/provider_list',[ApiController::class,'provider_list']);
Route::post('/user_list',[ApiController::class,'user_list']);
Route::post('/delete_user',[ApiController::class,'delete_user']);
Route::post('/delete_provider',[ApiController::class,'delete_provider']);
Route::post('/adminLogin',[ApiController::class,'adminLogin']);

Route::post('/roles',[RolesPermissionApiController::class,'roles']);
Route::post('/roleSave',[RolesPermissionApiController::class,'roleSave']);
Route::post('/changeRoleStatus',[RolesPermissionApiController::class,'changeRoleStatus']);
Route::post('/updateRole',[RolesPermissionApiController::class,'updateRole']);
Route::post('/fetchRole',[RolesPermissionApiController::class,'fetchRole']);

Route::post('/admins',[RolesPermissionApiController::class,'admins']);
Route::post('/admin_update',[RolesPermissionApiController::class,'admin_update']);
Route::post('/saveAdmin',[RolesPermissionApiController::class,'saveAdmin']);
Route::post('/admin_info',[RolesPermissionApiController::class,'admin_info']);
Route::post('/changeAdminStatus',[RolesPermissionApiController::class,'changeAdminStatus']);
Route::post('/modules',[RolesPermissionApiController::class,'modules']);
Route::post('/savePermission',[RolesPermissionApiController::class,'savePermission']);
Route::post('/fetchPermisison',[RolesPermissionApiController::class,'fetchPermisison']);
Route::post('/fetchCounter',[ApiController::class,'fetchCounter']);



Route::get('/sendmail',[ApiController::class,'sendmail']);
Route::get('/test',[ApiController::class,'test']);



