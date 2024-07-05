<?php

use App\Http\Controllers\Api\Auth\RegistrationController;
use App\Http\Controllers\Api\FaqController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\GiftProductController;
use App\Http\Controllers\Api\PointsController;

use Illuminate\Support\Facades\Route;

Route::post('/registration', [RegistrationController::class, 'registration']);
Route::post('/login', [RegistrationController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [RegistrationController::class, 'logout']);
    Route::post('/password-reset', [RegistrationController::class,'reset']);
    Route::post('/profile-info',[RegistrationController::class,'profileinfo']);
    Route::post('/update-profile',[RegistrationController::class,'update']);
    // Faq API
    Route::get('/get-faq', [FaqController::class, 'index']);
    Route::get('/get-notification',[NotificationController::class,'index']);
    
    
       //gift Product API
    Route::get('/get-gift-product',[GiftProductController::class,'index']);

     Route::post('/gift-order',[PointsController::class,'orderGift']);

    Route::get('/show-coins',[PointsController::class,'showCoins']);
    
      //get category
    Route::get('/get-category',[CategoryController::class,'getCategory']);
    Route::get('/getSubCategory/{id}',[CategoryController::class,'getSubCategory']);


    
});

