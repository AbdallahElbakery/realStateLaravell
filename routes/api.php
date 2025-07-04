<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ComplaintsController;
use App\Http\Controllers\API\NotificationController;
use App\Http\Controllers\API\PropertyController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\API\SellerController;
use App\Http\Controllers\Api\SellerBookingController;
use App\Http\Controllers\Auth\UserRegisterController;
use App\Http\Controllers\Auth\SellerRegisterController;
use App\Http\Controllers\Auth\loginController;
use App\Http\Controllers\Auth\logoutController;
use App\Http\Controllers\Api\ReviewController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
Route::apiResource('complaints', ComplaintsController::class);
Route::apiResource('notifications', NotificationController::class);
Route::put('notifications', [NotificationController::class, 'markallasread']);
Route::apiResource('properties', PropertyController::class);
Route::apiResource('bookings', BookingController::class);
Route::apiResource('seller/bookings', SellerBookingController::class);
Route::post('seller/bookings/{booking}/confirm', [SellerBookingController::class, 'confirm']);
Route::post('seller/bookings/{booking}/cancel', [SellerBookingController::class, 'cancel']);
Route::apiResource('sellers',SellerController::class);
// Route::get('sellers/{user_id}', [SellerController::class, 'show']);
Route::apiResource('complaints',ComplaintsController::class);
Route::apiResource('notifications',NotificationController::class);
Route::put('notifications',[NotificationController::class,'markallasread']);
Route::post('register/user',[UserRegisterController::class,'register']);
Route::post('register/seller',[SellerRegisterController::class,'register']);
Route::post('login',[loginController::class,'login']);
Route::apiResource('reviews', ReviewController::class);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout',[logoutController::class,'logout']);
});
