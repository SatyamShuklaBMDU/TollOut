<?php

use App\Http\Controllers\Api\Auth\RegistrationController;
use App\Http\Controllers\API\FaqController;
use App\Http\Controllers\Api\FeedbackController;
use App\Http\Controllers\API\NotificationController;
use Illuminate\Support\Facades\Route;

Route::post('/registration', [RegistrationController::class, 'registration']);
Route::post('/login', [RegistrationController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [RegistrationController::class, 'logout']);
    Route::post('/password-reset', [RegistrationController::class,'reset']);
    Route::post('/update',[RegistrationController::class,'update']);
    // Faq API
    Route::get('/get-faq', [FaqController::class, 'index']);
    Route::get('/get-notification',[NotificationController::class,'index']); 
    //feedback API
    route::post('/feedback',[FeedbackController::class,'index']);
    route::post('/feedback-info',[FeedbackController::class,'GetFeedback']);

});

