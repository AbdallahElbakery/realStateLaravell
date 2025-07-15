<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});
// Route::get('api/payment/success',[PaymentController::class, 'success'] ,function () {return view('payment.success');})->name('success');

// Route::get('api/payment/cancel', function () {
//     return view('payment.cancel');
// })->name('cancel');
