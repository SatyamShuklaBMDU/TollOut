<?php

use App\Http\Controllers\FaqController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ManageAdminController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FeedbackController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect('/login');
});

route::middleware('auth')->group(function () {
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashborad');
    route::get('/logout', [HomeController::class, 'logout'])->name('logout');
    route::middleware(['auth','isAdmin:usermanagement'])->group(function(){
    route::get('/users', [UserController::class, 'users'])->name('users');
    Route::post('/user/filter', [UserController::class, 'filter'])->name('user-filters');
    Route::get('/user/show', [UserController::class, 'show'])->name('user-show');
    Route::post('/user-report-show',[UserController::class,'userreportshow'])->name('user-report-show');
    Route::post('/change-user-status',[UserController::class,'changeStatus'])->name('change-user-status');
    });
    // Faq Route
    route::middleware(['auth','isAdmin:faqmanagement'])->group(function(){
    Route::get('faq-index', [FaqController::class, 'index'])->name('faq-index');
    Route::post('faq-store', [FaqController::class, 'store'])->name('faqs-store');
    Route::get('/faq/edit-detail/{id}', [FaqController::class, 'edit'])->name('faq-details');
    Route::post('/faq/update-status', [FaqController::class, 'updateStatus'])->name('update-faq-status');
    Route::post('/faq/update-details', [FaqController::class, 'update'])->name('update-faq');
    Route::delete('/faq/delete/{id}', [FaqController::class, 'delete'])->name('faq-delete');
    Route::post('filter-faq', [FaqController::class, 'filterdata'])->name('filter-faq');
    });
    // Notification Route
    route::middleware(['auth','isAdmin:notificationmanagement'])->group(function(){
    Route::get('show-notification', [NotificationController::class, 'index'])->name('show-notification');
    Route::post('/notifications', [NotificationController::class, 'store'])->name('notifications.store');
    Route::post('/notifications-update', [NotificationController::class, 'update'])->name('notifications.update');
    Route::delete('/notifications/{notification}', [NotificationController::class, 'delete'])->name('notifications.destroy');
    Route::get('/notification/{id}/edit', [NotificationController::class, 'edit'])->name('notifications.edit');
    Route::post('filter-notification', [NotificationController::class, 'filterdata'])->name('filter-notification');
    });
    // feedback Route
    route::middleware(['auth','isAdmin:categorymanagement'])->group(function(){
    Route::get('/feedback', [FeedbackController::class, 'index'])->name('show-category');
    Route::delete('/feedback/{category}', [FeedbackController::class, 'delete'])->name('category.destroy');
    Route::post('filter-feedback', [FeedbackController::class, 'filterdata'])->name('filter-category');
    Route::post('/feedback-reply',[FeedbackController::class,'reply'])->name('feedback-reply');
    });
    //manage admin
    route::middleware(['auth','isAdmin:manageadmin'])->group(function(){
    route::get('/manage-admin',[ManageAdminController::class, 'index'])->name('manage-admin');
    route::get('/add-admin',[ManageAdminController::class, 'addadmin'])->name('add-admin');
    route::post('/admin-store',[ManageAdminController::class, 'addadminstore'])->name('admin-store');
    route::get('/edit-admin/{id}',[ManageAdminController::class, 'editadmin'])->name('edit-admin');
    route::post('/edit-admin-store/{id}',[ManageAdminController::class, 'editadminstore'])->name('edit-admin-store');
    route::delete('/delete-admin/{id}',[ManageAdminController::class, 'delete'])->name('delete-admin');
    Route::post('filter-admin', [ManageAdminController::class, 'filterdata'])->name('filter-admin');
    });

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