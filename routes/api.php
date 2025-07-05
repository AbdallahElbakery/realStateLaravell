<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ComplaintsController;
use App\Http\Controllers\API\NotificationController;
use App\Http\Controllers\API\PropertyController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\API\SellerController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
Route::apiResource('complaints', ComplaintsController::class);
Route::apiResource('notifications', NotificationController::class);
Route::put('notifications', [NotificationController::class, 'markallasread']);
Route::apiResource('properties', PropertyController::class);
Route::apiResource('bookings', BookingController::class);
Route::apiResource('sellers',SellerController::class);
// Route::get('sellers/{user_id}', [SellerController::class, 'show']);