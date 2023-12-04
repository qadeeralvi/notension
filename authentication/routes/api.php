<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\RolesPermissionApiController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::get('/sendmail',[ApiController::class,'sendmail']);
Route::get('/test',[ApiController::class,'test']);
Route::get('/mail-verification',[ApiController::class,'mail_verification']);

Route::post('/sendNotification',[ApiController::class,'sendNotification']);
Route::post('/userNotification',[ApiController::class,'userNotification']);
Route::post('/providerNotification',[ApiController::class,'providerNotification']);
Route::post('/userNotificationCounter',[ApiController::class,'userNotificationCounter']);
Route::post('/providerNotificationCounter',[ApiController::class,'providerNotificationCounter']);
Route::post('/saveProviderToken',[ApiController::class,'saveProviderToken']);
Route::post('/saveUserToken',[ApiController::class,'saveUserToken']);

Route::post('/send_otp',[ApiController::class,'send_otp']);


Route::post('/service-provider/signup',[ApiController::class,'serviceProviderRegistration']);
Route::post('/user/signup',[ApiController::class,'userRegistration']);
Route::post('/login',[ApiController::class,'login']);
Route::post('/providerLogin',[ApiController::class,'providerLogin']);
Route::post('/user_update',[ApiController::class,'user_update']);

Route::post('/provider_update',[ApiController::class,'provider_update']);
Route::post('/change_provider_status',[ApiController::class,'change_provider_status']);
Route::post('/check_provider_email',[ApiController::class,'check_provider_email']);

Route::post('/check_user_email',[ApiController::class,'check_user_email']);

Route::post('/user_info',[ApiController::class,'user_info']);
Route::post('/provider_info',[ApiController::class,'provider_info']);
Route::post('/provider_location',[ApiController::class,'provider_location']);

Route::post('/change_user_status',[ApiController::class,'change_user_status']);

Route::post('/forget',[ApiController::class,'forget']);
Route::post('/user_forget',[ApiController::class,'user_forget']);
Route::post('/verify_code',[ApiController::class,'verify_code']);
Route::post('/use_verify_code',[ApiController::class,'use_verify_code']);

// Facebook login route
Route::prefix('facebook')->name('facebook.')->group( function(){
    Route::get('auth', [UserController::class, 'loginUsingFacebook'])->name('login');
    Route::get('callback', [UserController::class, 'callbackFromFacebook'])->name('callback');
});

// Google login route
Route::prefix('google')->name('google.')->group( function(){
    Route::get('auth', [UserController::class, 'loginUsingGoogle'])->name('login');
    Route::get('callback', [UserController::class, 'callbackFromGoogle'])->name('callback');
});


Route::post('/provider_list',[ApiController::class,'provider_list']);
Route::post('/user_list',[ApiController::class,'user_list']);
Route::post('/delete_user',[ApiController::class,'delete_user']);
Route::post('/delete_provider',[ApiController::class,'delete_provider']);
Route::post('/adminLogin',[ApiController::class,'adminLogin']);

// admin role routes
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



