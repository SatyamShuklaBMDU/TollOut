<?php

use App\Http\Controllers\FaqController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

route::middleware('auth')->group(function () {
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashborad');
    route::get('/logout', [HomeController::class, 'logout'])->name('logout');
    route::get('/users', [UserController::class, 'users'])->name('users');
    Route::post('/user/filter', [UserController::class, 'filter'])->name('user-filters');
    Route::get('/user/show', [UserController::class, 'show'])->name('user-show');
    // Faq Route
    Route::get('faq-index', [FaqController::class, 'index'])->name('faq-index');
    Route::post('faq-store', [FaqController::class, 'store'])->name('faqs-store');
    Route::get('/faq/edit-detail/{id}', [FaqController::class, 'edit'])->name('faq-details');
    Route::post('/faq/update-status', [FaqController::class, 'updateStatus'])->name('update-faq-status');
    Route::post('/faq/update-details', [FaqController::class, 'update'])->name('update-faq');
    Route::delete('/faq/delete/{id}', [FaqController::class, 'delete'])->name('faq-delete');
    Route::post('filter-faq', [FaqController::class, 'filterdata'])->name('filter-faq');
    // Notification Route
    Route::get('show-notification', [NotificationController::class, 'index'])->name('show-notification');
    Route::post('/notifications', [NotificationController::class, 'store'])->name('notifications.store');
    Route::post('/notifications-update', [NotificationController::class, 'update'])->name('notifications.update');
    Route::delete('/notifications/{notification}', [NotificationController::class, 'delete'])->name('notifications.destroy');
    Route::get('/notification/{id}/edit', [NotificationController::class, 'edit'])->name('notifications.edit');
    Route::post('filter-notification', [NotificationController::class, 'filterdata'])->name('filter-notification');

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
