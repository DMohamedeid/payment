<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PayPalController;

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

Route::get('paypal/go-payment',[PayPalController::class,'goPayment'])->name('payPal.goPayment');

Route::get('paypal/payment',[PayPalController::class,'payment'])->name('payPal.payment');
Route::get('paypal/cancel',[PayPalController::class,'cancel'])->name('payPal.cancel');
Route::get('paypal/payment/success',[PayPalController::class,'success'])->name('payPal.success');
