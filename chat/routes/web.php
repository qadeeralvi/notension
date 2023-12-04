<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersComplaintController;

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

// Route::get('/home', function () {
//     return view('welcome');
// });

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';


Route::get('/home', [UsersComplaintController::class, 'index'])->name('home');
Route::get('/', [UsersComplaintController::class, 'index'])->name('home');
Route::resource('jb', UsersComplaintController::class);
Route::resource('complaints', UsersComplaintController::class);