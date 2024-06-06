<?php

use App\Http\Controllers\Api\Auth\RegistrationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register',[RegistrationController::class,'registration']);
Route::post('/login',[RegistrationController::class,'login']);
Route::post('/logout',[RegistrationController::class,'logout'])->middleware('auth:sanctum');
Route::post('/update',[RegistrationController::class,'update'])->middleware('auth:sanctum');
