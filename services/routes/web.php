<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\JobManagementController;
use App\Http\Controllers\Admin\AdminController;

use App\Http\Controllers\Admin\AdminJobManagemnet;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SubCategoryController;

use App\Http\Controllers\ServiceGiver\ServiceGiverContoller;
use App\Http\Controllers\ServiceGiver\ServiceProviderDashboard;
use App\Http\Controllers\ServiceGiver\ProviderJobManagement;

// use App\Http\Controllers\ServiceProvider\ServiceProviderController;
// use App\Http\Controllers\ServiceProvider\Jb;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('admin')->name('admin.')->group(function(){
       
    Route::middleware(['guest:admin','PreventBackHistory'])->group(function(){
          Route::view('/','auth.admin.login')->name('login');
          Route::view('/login','auth.admin.login')->name('login');

          Route::post('/check',[AdminController::class,'check'])->name('check');

    });

    Route::middleware(['auth:admin','PreventBackHistory'])->group(function(){

        // Route::view('/home','dashboard.admin.home')->name('home');

        Route::get('/dashboard',[AdminDashboardController::class,'index'])->name('dashboard');

        Route::get('job-list',[AdminJobManagemnet::class,'list'])->name('joblist');
        
        Route::resource('category', CategoryController::class);
        
        Route::resource('subcategory', SubCategoryController::class);

        Route::get('category-list',[CategoryController::class,'index'])->name('categoryList');
        
        Route::get('subCategory-list',[SubCategoryController::class,'index'])->name('subCategory');

        Route::get('job-status/{id}',[AdminJobManagemnet::class,'change_status'])->name('status');

        Route::get('provider_data',[AdminJobManagemnet::class,'provider_data'])->name('provider_data');

        Route::post('status-update',[AdminJobManagemnet::class,'update_status'])->name('update');

        Route::get('/logout',[AdminController::class,'logout'])->name('logout');



    });

});


Route::prefix('user')->name('user.')->group(function(){
  
    Route::middleware(['guest:web','PreventBackHistory'])->group(function(){
          Route::view('/login','auth.user.login')->name('login');
        //   Route::view('/register','dashboard.user.register')->name('register');
          Route::view('/register','auth.user.signUp')->name('register');
          Route::post('/create',[UserController::class,'create'])->name('create');
          Route::post('/check',[UserController::class,'check'])->name('check');
    });

    Route::middleware(['auth:web','PreventBackHistory'])->group(function(){

        Route::get('/',[JobManagementController::class,'index'])->name('index');

        Route::get('job-list',[JobManagementController::class,'index'])->name('dashboard');

        Route::get('job-list',[JobManagementController::class,'list'])->name('joblist');

        Route::get('job-status',[JobManagementController::class,'change_status'])->name('status');

        Route::get('/job-add',[JobManagementController::class,'create'])->name('jobadd');

        Route::get('/store-data',[JobManagementController::class,'store'])->name('storedata');

        Route::get('/store-edit',[JobManagementController::class,'edit'])->name('storeedit');

        Route::get('/category-fetch',[JobManagementController::class,'fetch_category'])->name('categoryfetch');

        Route::resource('jobManagement', JobManagementController::class);

          // Route::view('/home','dashboard.user.home')->name('home');
          Route::post('/logout',[UserController::class,'logout'])->name('logout');
          Route::get('/add-new',[UserController::class,'add'])->name('add');
    });

});


Route::prefix('servicegiver')->name('servicegiver.')->group(function(){
       
    Route::middleware(['guest:servicegiver','PreventBackHistory'])->group(function(){
        //   Route::view('/login','dashboard.admin.login')->name('login');
          Route::view('/login','auth.servicegiver.login')->name('login');
          Route::view('/register','auth.servicegiver.signUp')->name('register');
          Route::post('/create',[ServiceGiverContoller::class,'create'])->name('create');
          Route::post('/check',[ServiceGiverContoller::class,'check'])->name('check');
    });

    Route::middleware(['auth:servicegiver','PreventBackHistory'])->group(function(){

        Route::get('/dashboard',[ServiceProviderDashboard::class,'index'])->name('dashboard');

        // Route::get('job-list',[ProviderJobManagement::class,'list'])->name('joblist');
        Route::get('job-list',[ProviderJobManagement::class,'job_list'])->name('joblist');
        Route::get('activeJob-save',[ProviderJobManagement::class,'active_job_save'])->name('active_job_save');

        Route::view('/home','dashboard.servicegiver.home')->name('home');
        Route::post('/logout',[ServiceGiverContoller::class,'logout'])->name('logout');
        Route::get('/logout',[ServiceGiverContoller::class,'logout'])->name('logout');
    });

});
