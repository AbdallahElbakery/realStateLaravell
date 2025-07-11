<?php

use App\Http\Controllers\API\WishlistController;
use App\Http\Controllers\API\CategoryController;
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
use App\Http\Controllers\Api\AddressController;

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

Route::patch('sellers/update-company-details/{id}',[SellerController::class,'updateCompanyDetails']);
Route::patch('sellers/update-personal-details/{id}',[SellerController::class,'editPersonalInfo']);
Route::patch('sellers/change-password/{id}',[SellerController::class,'changePassword']);
Route::delete('sellers/{user_id}/{prop_id}', [SellerController::class, 'deleteOwnProperty']);
Route::post('sellers/{user_id}',[SellerController::class,'addOwnProperty']);
Route::put('sellers/{user_id}/{prop_id}', [SellerController::class, 'updateOwnProperty']);
Route::get('sellers/{user_id}/{prop_id}', [SellerController::class, 'getOwnProperty']);

Route::apiResource('wishlist', WishlistController::class);
Route::delete('wishlist/{id}/{prop_id}', [WishlistController::class, 'destroy']);
Route::post('wishlist/{id}/{prop_id}', [WishlistController::class, 'store']);

Route::apiResource('addresses', AddressController::class);


Route::apiResource('categories', CategoryController::class);
// Route::get('sellers/{user_id}', [SellerController::class, 'show']);