<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\ApiCustomerSupportController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/send_message',[ApiController::class,'send_message']);

Route::post('/user_messages',[ApiController::class,'user_messages']);

Route::post('/provider_messages',[ApiController::class,'provider_messages']);

Route::post('/user_mesgs_list',[ApiController::class,'user_mesgs_list']);

Route::post('/provider_mesgs_list',[ApiController::class,'provider_mesgs_list']);

Route::post('/userMsgCounter',[ApiController::class,'userMsgCounter']);

Route::post('/providerMsgCounter',[ApiController::class,'providerMsgCounter']);

Route::post('/register_complaint',[ApiController::class,'register_complaint']);


Route::post('/user_complaints',[ApiController::class,'user_complaints']);

Route::post('/provider_complaints',[ApiController::class,'provider_complaints']);

Route::post('/single_complain',[ApiController::class,'single_complain']);

Route::post('/change_status_complaint',[ApiController::class,'change_status_complaint']);

Route::post('/all_complaint',[ApiController::class,'all_complaint']);

Route::post('/saveComplainChat',[ApiController::class,'saveComplainChat']);

Route::post('/complainChat',[ApiController::class,'complainChat']);

Route::post('/send_msg_cust_support',[ApiCustomerSupportController::class,'send_msg_cust_support']);

Route::post('/fetch_messages_cust_support',[ApiCustomerSupportController::class,'fetch_messages_cust_support']);

Route::post('/question_cust_support',[ApiCustomerSupportController::class,'question_cust_support']);

Route::post('/answer_cust_support',[ApiCustomerSupportController::class,'answer_cust_support']);