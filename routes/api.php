<?php

use App\Http\Controllers\API\WishlistController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ComplaintsController;
use App\Http\Controllers\API\NotificationController;
use App\Http\Controllers\API\PropertyController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\API\SellerController;
use App\Http\Controllers\Api\SellerBookingController;

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

Route::apiResource('sellers', SellerController::class);

Route::apiResource('wishlist', WishlistController::class);
Route::delete('wishlist/{id}/{prop_id}', [WishlistController::class, 'destroy']);
Route::post('wishlist/{id}/{prop_id}', [WishlistController::class, 'store']);
// Route::get('sellers/{user_id}', [SellerController::class, 'show']);