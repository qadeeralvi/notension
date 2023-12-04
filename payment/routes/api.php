
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;



Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('save_payment', [ApiController::class, 'save_payment'])->name('save_payment');

Route::post('provider_payment', [ApiController::class, 'provider_payment'])->name('provider_payment');

Route::post('change_status', [ApiController::class, 'change_status'])->name('change_status');

Route::post('payments', [ApiController::class, 'payments'])->name('payments');

Route::post('single_payment', [ApiController::class, 'single_payment'])->name('single_payment');

Route::post('wallet', [ApiController::class, 'wallet'])->name('wallet');

Route::post('deduct_payment', [ApiController::class, 'deduct_payment'])->name('deduct_payment');

Route::post('payment_filter', [ApiController::class, 'payment_filter'])->name('payment_filter');

Route::post('accounts', [ApiController::class, 'accounts'])->name('accounts');

Route::post('saveAccount', [ApiController::class, 'saveAccount'])->name('saveAccount');

Route::post('coupenSave', [ApiController::class, 'coupenSave'])->name('coupenSave');

Route::post('coupen', [ApiController::class, 'coupen'])->name('coupen');

Route::post('coupenUsed', [ApiController::class, 'coupenUsed'])->name('coupenUsed');

Route::post('providerWallet', [ApiController::class, 'providerWallet'])->name('providerWallet');
