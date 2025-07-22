<?php

use App\Http\Controllers\API\WishlistController;
use App\Http\Controllers\API\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
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
use App\Http\Controllers\Auth\AdminRegisterController;
use App\Http\Controllers\API\ReviewController;
use App\Http\Controllers\API\AddressController;
use App\Http\Controllers\API\PaymentController;
use App\Http\Controllers\API\OfferController;
use App\Http\Controllers\API\Admin\AdminUserController;
use App\Http\Controllers\API\Admin\PropertyAdminController;
use App\Http\Controllers\API\Admin\CategoryAdminController;
use App\Http\Controllers\API\Admin\PaymentAdminController;
use App\Http\Controllers\API\Admin\ReviewAdminController;
use App\Http\Controllers\API\Admin\SellerAdminController;
use App\Http\Controllers\ChatController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
use App\Http\Controllers\API\Admin\BookingAdminController;
use App\Http\Controllers\API\Admin\AdminProfileController;
use App\Http\Middleware\checkRole;

//auth
Route::post('login', [loginController::class, 'login']);
Route::post('register/user', [UserRegisterController::class, 'register']);
Route::post('register/seller', [SellerRegisterController::class, 'register']);
Route::post('register/admin', [AdminRegisterController::class, 'registerAdmin']);

Route::middleware('auth:sanctum')->group(function () {
    //logout
    Route::post('logout', [logoutController::class, 'logout']);

    //user
    Route::get('/me', [UserController::class, 'me']);

    //user-bookings
    Route::apiResource('user/bookings', BookingController::class);
    Route::get('/my-bookings', [BookingController::class, 'myBookings']);

    //seller/bookings
    Route::prefix('seller/bookings')->controller(SellerBookingController::class)->group(function () {
        Route::get('/', 'index');
        Route::post('{booking}/confirm', 'confirm');
        Route::post('{booking}/cancel', 'cancel');
    });

    //seller
    Route::apiResource('sellers', SellerController::class)->only(['index', 'store']);
    Route::get('seller', [SellerController::class, 'show']);
    Route::get('single-seller/{id}', [SellerController::class, 'showSeller']);
    Route::get('get-seller-properties/{id}', [SellerController::class, 'getSellerProperties']);
    Route::put('seller', [SellerController::class, 'update']);
    Route::delete('seller', [SellerController::class, 'destroy']);

    //seller-profile
    Route::match(['POST', 'PATCH'], 'seller/update-company-details', [SellerController::class, 'updateCompanyDetails']);
    Route::patch('seller/change-password', [SellerController::class, 'changePassword']);
    Route::match(['POST', 'PATCH'], 'seller/update-personal-details', [SellerController::class, 'editPersonalInfo']);
    Route::post('seller-add-prop', [SellerController::class, 'addOwnProperty']);
    Route::put('seller-update-prop/{prop_id}', [SellerController::class, 'updateOwnProperty']);
    Route::get('seller-get-prop/{prop_id}', [SellerController::class, 'getOwnProperty']);
    Route::delete('seller-delete-prop/{prop_id}', [SellerController::class, 'deleteOwnProperty']);

    //properties
    Route::post('properties', [PropertyController::class, 'store']);
    Route::put('properties/{id}', [PropertyController::class, 'update']);
    Route::delete('properties/{id}', [PropertyController::class, 'destroy']);



    //categories
    Route::apiResource('categories', CategoryController::class);

    //payment
    Route::post('payment', [PaymentController::class, 'paypal'])->name('paypal');

    //admin

});
Route::middleware(['auth:sanctum', 'checkRole'])->prefix('admin')->group(function () {
    Route::apiResource('users', AdminUserController::class);
    Route::apiResource('properties', PropertyAdminController::class);
    Route::apiResource('payments', PaymentAdminController::class);
    Route::apiResource('sellers', SellerAdminController::class);
    Route::apiResource('reviews', ReviewAdminController::class);
    Route::apiResource('categories', CategoryAdminController::class);
    Route::apiResource('bookings', BookingAdminController::class);
    Route::put('edit-profile', [AdminProfileController::class, 'update']);
    Route::get('profile', [AdminProfileController::class, 'index']);
});
Route::get('payment/success', [PaymentController::class, 'success'])->name('success');
Route::get('payment/cancel', [PaymentController::class, 'cancel'])->name('cancel');

//properties
Route::apiResource('properties', PropertyController::class)->only(['index', 'show']);

//sellers
Route::apiResource('sellers', SellerController::class)->only(['index', 'store']);

//complaints
Route::apiResource('complaints', ComplaintsController::class);

//notifications
Route::apiResource('notifications', NotificationController::class);
Route::put('notifications', [NotificationController::class, 'markallasread']);

//wishlist
Route::apiResource('wishlist', WishlistController::class);
Route::delete('wishlist/{id}/{prop_id}', [WishlistController::class, 'destroy']);
Route::post('wishlist/{id}/{prop_id}', [WishlistController::class, 'store']);

//reviews
Route::get('/reviews', [ReviewController::class, 'index']);
Route::post('/reviews', [ReviewController::class, 'store']);
Route::get('/reviews/seller/{sellerId}', [ReviewController::class, 'getReviewsBySeller']);

//Mail
Route::post('/offers/{id}/accept', [OfferController::class, 'accept']);

//chat
Route::post('/chat', [ChatController::class, 'ask']);

//addresses
Route::apiResource('addresses', AddressController::class);