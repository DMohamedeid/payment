<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PayPalController;
use App\Http\Controllers\KashierController;
use App\Http\Controllers\PaymobController;

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

// Kashier Payment

Route::get('kashier',function (){
    return view('Product.kashier_payment');
});
Route::get('/KashierOrderHash',[KashierController::class,'generateKashierOrderHash'])->name('kashierOrder');

Route::get('/successKashier',[KashierController::class,'validateSignature'])->name('kashier.validateSignature');

// End of Kashier

//payment for paymob
Route::get('/paymob' , function (){
    return view('Product.paymob');
});

//Route::post('/credit',[PaymobController::class,'credit'])->name('credit');
Route::get('/credit/{type?}',[PaymobController::class,'credit'])->name('credit');
Route::get('/callBack',[PaymobController::class,'callBack'])->name('callBack');

//payment for paymob
