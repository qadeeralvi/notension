<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\ApiRatingController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/test',[ApiController::class,'test']);

Route::get('/category',[ApiController::class,'category']);

Route::get('/all_sub_category',[ApiController::class,'all_sub_category']);

Route::get('/sub-category',[ApiController::class,'sub_category']);

Route::post('/subCategory',[ApiController::class,'subCategory']);

Route::post('/singleCategory',[ApiController::class,'singleCategory']);

Route::post('/singleSubCategory',[ApiController::class,'singleSubCategory']);

Route::post('/updateCategory',[ApiController::class,'updateCategory']);

Route::post('/updateSubCategory',[ApiController::class,'updateSubCategory']);

Route::get('/banner',[ApiController::class,'banner']);

Route::post('/post_job',[ApiController::class,'post_job']);

Route::post('/category_filter',[ApiController::class,'category_filter']);

Route::post('/category_search',[ApiController::class,'category_search']);

Route::post('/category_Id',[ApiController::class,'category_Id']);

Route::post('/update_job',[ApiController::class,'update_job']);

Route::post('/delete_job_image',[ApiController::class,'delete_job_image']);

Route::post('/check',[ApiController::class,'check_job']);

Route::post('/save_job_status',[ApiController::class,'save_job_status']);

Route::post('/user_job_list',[ApiController::class,'user_job_list']);

Route::post('/all_job_list',[ApiController::class,'all_job_list']);

Route::post('/single_job',[ApiController::class,'single_job']);

Route::post('/job_images',[ApiController::class,'job_images']);

Route::post('/sendNotificationUser',[ApiController::class,'sendNotificationUser']);

Route::post('/provider_single_job',[ApiController::class,'provider_single_job']);

Route::post('/provider_jobs',[ApiController::class,'provider_jobs']);

Route::post('/providerByJob',[ApiController::class,'providerByJob']);

Route::post('/job_status',[ApiController::class,'job_status']);

Route::post('/provider_job_list',[ApiController::class,'provider_job_list']);

Route::post('/provider_job_status_change',[ApiController::class,'provider_job_status_change']);

Route::post('/user_job_status_change',[ApiController::class,'user_job_status_change']);

Route::post('/provider_job_status_pending',[ApiController::class,'provider_job_status_pending']);

Route::post('/provider_job_status_ongoing',[ApiController::class,'provider_job_status_ongoing']);

Route::post('/provider_job_status_complete',[ApiController::class,'provider_job_status_complete']);

Route::post('/save_category',[ApiController::class,'save_category']);

Route::post('/save_sub_category',[ApiController::class,'save_sub_category']);

Route::post('/delete_sub_category',[ApiController::class,'delete_sub_category']);

Route::post('/delete_category',[ApiController::class,'delete_category']);

Route::post('/providerJobReport',[ApiController::class,'providerJobReport']);

Route::post('/userJobProviderList',[ApiController::class,'userJobProviderList']);

Route::post('/providerJobUserList',[ApiController::class,'providerJobUserList']);

Route::post('/categorySearchByWord',[ApiController::class,'categorySearchByWord']);

//rating routes

Route::post('/save_rating',[ApiRatingController::class,'save_rating']);

Route::post('/provider_rating',[ApiRatingController::class,'provider_rating']);

Route::post('/user_rating',[ApiRatingController::class,'user_rating']);

Route::post('/ratings',[ApiRatingController::class,'ratings']);

Route::post('/job_rating',[ApiRatingController::class,'job_rating']);






