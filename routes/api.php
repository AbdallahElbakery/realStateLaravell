<?php

use App\Http\Controllers\API\WishlistController;
use App\Http\Controllers\API\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ComplaintsController;
use App\Http\Controllers\API\NotificationController;
use App\Http\Controllers\API\PropertyController;
use App\Http\Controllers\API\BookingController;
use App\Http\Controllers\API\SellerController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\Api\SellerBookingController;
use App\Http\Controllers\Auth\UserRegisterController;
use App\Http\Controllers\Auth\SellerRegisterController;
use App\Http\Controllers\Auth\loginController;
use App\Http\Controllers\Auth\logoutController;
use App\Http\Controllers\API\ReviewController;
use App\Http\Controllers\API\AddressController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('login', [loginController::class, 'login']);
Route::post('register/user', [UserRegisterController::class, 'register']);
Route::post('register/seller', [SellerRegisterController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [logoutController::class, 'logout']);
});

Route::apiResource('properties', PropertyController::class)->only(['index', 'show']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('properties', [PropertyController::class, 'store']);
    Route::put('properties/{id}', [PropertyController::class, 'update']);
    Route::delete('properties/{id}', [PropertyController::class, 'destroy']);
});

Route::apiResource('user/bookings', BookingController::class);
Route::apiResource('seller/bookings', SellerBookingController::class);
Route::post('seller/bookings/{booking}/confirm', [SellerBookingController::class, 'confirm']);
Route::post('seller/bookings/{booking}/cancel', [SellerBookingController::class, 'cancel']);

Route::middleware('auth:sanctum')->get('/my-bookings', [BookingController::class, 'myBookings']);

Route::middleware('auth:sanctum')->apiResource('sellers', SellerController::class)->only(['index', 'store']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('seller', [SellerController::class, 'show']);
    Route::put('seller', [SellerController::class, 'update']);
    Route::delete('seller', [SellerController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::patch('seller/update-company-details', [SellerController::class, 'updateCompanyDetails']);
    Route::patch('seller/change-password', [SellerController::class, 'changePassword']);
    Route::match(['POST', 'PATCH'],'seller/update-personal-details', [SellerController::class, 'editPersonalInfo']);
    Route::post('seller-add-prop', [SellerController::class, 'addOwnProperty']);
    Route::put('seller-update-prop/{prop_id}', [SellerController::class, 'updateOwnProperty']);
    Route::get('seller-get-prop/{prop_id}', [SellerController::class, 'getOwnProperty']);
    Route::delete('seller-delete-prop/{prop_id}', [SellerController::class, 'deleteOwnProperty']);
});


Route::middleware('auth:sanctum')->apiResource('addresses', AddressController::class);

Route::middleware('auth:sanctum')->apiResource('categories', CategoryController::class);


Route::get('/reviews', [ReviewController::class, 'index']);
Route::post('/reviews', [ReviewController::class, 'store']);
Route::get('/reviews/seller/{sellerId}', [ReviewController::class, 'getReviewsBySeller']);




Route::apiResource('wishlist', WishlistController::class);
Route::delete('wishlist/{id}/{prop_id}', [WishlistController::class, 'destroy']);
Route::post('wishlist/{id}/{prop_id}', [WishlistController::class, 'store']);

Route::apiResource('complaints', ComplaintsController::class);

Route::apiResource('notifications', NotificationController::class);
Route::put('notifications', [NotificationController::class, 'markallasread']);