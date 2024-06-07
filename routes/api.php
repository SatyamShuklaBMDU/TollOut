<?php

use App\Http\Controllers\Api\Auth\RegistrationController;
use App\Http\Controllers\API\FaqController;
use App\Http\Controllers\API\NotificationController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [RegistrationController::class, 'registration']);
Route::post('/login', [RegistrationController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [RegistrationController::class, 'logout']);
    // Faq API
    Route::get('get-faq', [FaqController::class, 'index']);
});
Route::get('get-notification',[NotificationController::class,'index']);
Route::post('/update',[RegistrationController::class,'update'])->middleware('auth:sanctum');
