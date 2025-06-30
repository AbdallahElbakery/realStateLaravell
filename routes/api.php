<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ComplaintsController;
use App\Http\Controllers\API\NotificationController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
Route::apiResource('complaints',ComplaintsController::class);
Route::apiResource('notifications',NotificationController::class);
Route::put('notifications',[NotificationController::class,'markallasread']);