<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ComplaintsController;
use App\Http\Controllers\API\NotificationController;
use App\Http\Controllers\Auth\UserRegisterController;
use App\Http\Controllers\Auth\SellerRegisterController;
use App\Http\Controllers\Auth\loginController;
use App\Http\Controllers\Auth\logoutController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
Route::apiResource('complaints',ComplaintsController::class);
Route::apiResource('notifications',NotificationController::class);
Route::put('notifications',[NotificationController::class,'markallasread']);
Route::post('register/user',[UserRegisterController::class,'register']);
Route::post('register/seller',[SellerRegisterController::class,'register']);
Route::post('login',[loginController::class,'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout',[logoutController::class,'logout']);
});
