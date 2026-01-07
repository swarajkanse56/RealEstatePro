<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Api\RegisterController;


 use App\Http\Controllers\Api\CategorysController;
use App\Http\Controllers\Api\LoginaaController;
 use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PostController;
 use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\SliderApiController;
use App\Http\Controllers\Api\WishlistController;
use App\Http\Controllers\Auth\RegisterController as AuthRegisterController;

/*
|--------------------------------------------------------------------------
| Public API Routes
|--------------------------------------------------------------------------
|
| These API routes are open and do not require authentication.
|
*/

// 🏠 List all properties
Route::get('/properties', [PostController::class, 'index']);

// 🏠 Show single property
Route::get('/properties/{id}', [PostController::class, 'show']);

// 📅 Schedule a property visit
Route::post('/visits', [PostController::class, 'store']);

// 📂 Get all property categories
Route::get('/categoryget', [CategorysController::class, 'index']);

Route::post('/login', [LoginaaController::class, 'login']);
Route::post('/google-login', [LoginaaController::class, 'googleLogin']);

Route::post('/register', [RegisterController::class, 'register']);
Route::get('sliders', [SliderApiController::class, 'index']);


Route::middleware('auth:sanctum')->group(function() {
    Route::get('/profile', [ProfileController::class, 'getProfile']);
    Route::post('/profile/update', [ProfileController::class, 'updateProfile']);
     Route::post('property-sold', [ProfileController::class, 'markAsSold']);
    Route::delete('properties/{id}', [ProfileController::class, 'deleteProperty']);
});
Route::middleware('auth:sanctum')->post('/save-onesignal-id', [AdminController::class, 'saveOneSignalId']);

// routes/api.php

 
 
       // Single property
Route::post('/visit', [PostController::class, 'store']);               // Schedule visit
Route::get('/dropdowns', [PostController::class, 'createDropdowns']);  // Cities + Categories

// Protected route for property upload (requires token)
Route::middleware('auth:sanctum')->post('/properties/create', [PostController::class, 'createProperty']);
Route::get('/dropdowns', [PostController::class, 'dropdowns']);
Route::post('/city/store', [PostController::class, 'storeCityApi']);
Route::post('/category/store', [PostController::class, 'storeCategoryApi']);
Route::get('/cities', [PostController::class, 'cityListApi']);
Route::get('/categoryByCity', [PostController::class, 'categoryByCity']);
Route::get('/propertyFilter', [PostController::class, 'propertyFilter']);
Route::get('/owner-properties/{userId}', [PostController::class, 'ownerProperties']);
Route::delete('/properties/{id}', [ProfileController::class, 'deleteProperty']);
 // routes/api.php
Route::middleware('auth:sanctum')->group(function () {
    Route::post('wishlist/toggle', [WishlistController::class, 'toggle']);
    Route::get('wishlist', [WishlistController::class, 'list']);
    Route::post('wishlist/check-status', [WishlistController::class, 'checkWishlistStatus']);
    // ... other authenticated routes
});


 
 






