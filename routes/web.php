<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});


route::middleware('auth')->group(function () {
   Route::get('/dashboard', [HomeController::class,'dashboard'])->name('dashborad');
    route::get('/logout',[HomeController::class,'logout'])->name('logout');
    route::get('/users',[UserController::class,'users'])->name('users');
    Route::post('/user/filter',[UserController::class,'filter'])->name('user-filters');
    Route::get('/user/show',[UserController::class,'show'])->name('user-show');
    Route::get('/user-report-show',[UserController::class,'userreportshow'])->name('user-report-show');
    Route::post('/change-user-status',[UserController::class,'changeStatus'])->name('change-user-status');

});


// Route::middleware([
//     'auth:sanctum',
//     config('jetstream.auth_session'),
//     'verified',
// ])->group(function () {
//     Route::get('/dashboard', function () {
//         return view('admin.dashboard');
//     })->name('dashboard');
// });
