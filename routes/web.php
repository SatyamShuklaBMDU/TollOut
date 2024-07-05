<?php


use App\Http\Controllers\FaqController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OrderByPointsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ManageAdminController;
use App\Http\Controllers\GiftProductController;
use App\Http\Controllers\PointsController;


use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\SubCategoryController;

Route::get('/', function () {
    return redirect('/login');
});

route::middleware('auth')->group(function () {
   Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashborad');
    route::get('/logout', [HomeController::class, 'logout'])->name('logout');
    route::middleware(['auth','rolecheck:User'])->group(function(){
    route::get('/users', [UserController::class, 'users'])->name('users');
    Route::post('/user/filter', [UserController::class, 'filter'])->name('user-filters');
    Route::get('/user/show', [UserController::class, 'show'])->name('user-show');
    Route::post('/user-report-show',[UserController::class,'userreportshow'])->name('user-report-show');
    Route::post('/change-user-status',[UserController::class,'changeStatus'])->name('change-user-status');
    });
    // Faq Route
    route::middleware(['auth','rolecheck:Faq'])->group(function(){
    Route::get('faq-index', [FaqController::class, 'index'])->name('faq-index');
    Route::post('faq-store', [FaqController::class, 'store'])->name('faqs-store');
    Route::get('/faq/edit-detail/{id}', [FaqController::class, 'edit'])->name('faq-details');
    Route::post('/faq/update-status', [FaqController::class, 'updateStatus'])->name('update-faq-status');
    Route::post('/faq/update-details', [FaqController::class, 'update'])->name('update-faq');
    Route::delete('/faq/delete/{id}', [FaqController::class, 'delete'])->name('faq-delete');
    Route::post('filter-faq', [FaqController::class, 'filterdata'])->name('filter-faq');
    });
    // Notification Route
    route::middleware(['auth','rolecheck:Notification'])->group(function(){
    Route::get('show-notification', [NotificationController::class, 'index'])->name('show-notification');
    Route::post('/notifications', [NotificationController::class, 'store'])->name('notifications.store');
    Route::post('/notifications-update', [NotificationController::class, 'update'])->name('notifications.update');
    Route::delete('/notifications/{notification}', [NotificationController::class, 'delete'])->name('notifications.destroy');
    Route::get('/notification/{id}/edit', [NotificationController::class, 'edit'])->name('notifications.edit');
    Route::post('filter-notification', [NotificationController::class, 'filterdata'])->name('filter-notification');
    });
    // feedback Route
    route::middleware(['auth','rolecheck:Feedback'])->group(function(){
    Route::get('/feedback', [FeedbackController::class, 'index'])->name('show-category');
    Route::delete('/feedback/{category}', [FeedbackController::class, 'delete'])->name('category.destroy');
    Route::post('filter-feedback', [FeedbackController::class, 'filterdata'])->name('filter-category');
    Route::post('/feedback-reply',[FeedbackController::class,'reply'])->name('feedback-reply');
    });
    //manage admin
    route::middleware(['auth','rolecheck:All'])->group(function(){
    route::get('/manage-admin',[ManageAdminController::class, 'index'])->name('manage-admin');
    route::get('/add-admin',[ManageAdminController::class, 'addadmin'])->name('add-admin');
    route::post('/admin-store',[ManageAdminController::class, 'addadminstore'])->name('admin-store');
    route::get('/edit-admin/{id}',[ManageAdminController::class, 'editadmin'])->name('edit-admin');
    route::post('/edit-admin-store/{id}',[ManageAdminController::class, 'editadminstore'])->name('edit-admin-store');
    route::delete('/delete-admin/{id}',[ManageAdminController::class, 'delete'])->name('delete-admin');
    Route::post('filter-admin', [ManageAdminController::class, 'filterdata'])->name('filter-admin');
    Route::post('/change-role', [ManageAdminController::class, 'updateUserRole']);
    });
    //manage roles
    route::middleware(['auth','rolecheck:All'])->group(function(){
    route::get('/add-role',[RoleController::class, 'index'])->name('add-role');
    route::post('/role-store',[RoleController::class, 'store'])->name('role-store');
    route::get('/role',[RoleController::class, 'roles'])->name('all-role');
    route::get('/edit/role/{id}',[RoleController::class, 'edit'])->name('edit-role');
    route::post('/edit/role-store/{id}',[RoleController::class, 'editrolestore'])->name('edit-role-store');
    route::delete('/delete-role/{id}',[RoleController::class, 'delete'])->name('delete-role');
    Route::post('filter-role', [RoleController::class, 'filterdata'])->name('filter-role');
    });
    
    
    
    //Wishlist Route
    Route::post('filter-wishlist', [wishlistController::class, 'filterdata'])->name('filter-wishlist');
    route::get('/wishlist',[wishlistController::class, 'index'])->name('wishlist');

    
    
    //Category Route
    route::middleware(['auth','rolecheck:Category'])->group(function(){
    Route::get('/category/show', [CategoryController::class, 'index'])->name('showCategory');
    Route::post('/category/update', [CategoryController::class, 'changeStatus'])->name('category-status-update');

    //Sub- Category Route
    Route::get('/subcategory/show/{cateogry}', [SubCategoryController::class, 'index'])->name('
    showSubCategory');
    Route::post('/subcategory/update', [SubCategoryController::class, 'changeStatus'])->name('subcategory-status-update');
    });
    
    
    // Gift Product Route
     route::middleware(['auth','rolecheck:Earn Product List'])->group(function(){
    Route::get('/gift-product/show', [GiftProductController::class, 'index'])->name('showGiftProduct');
    Route::post('/gift-product/add', [GiftProductController::class, 'addProduct'])->name
    ('gift-product-add');
    Route::post('/giftproduct/status', [GiftProductController::class, 'changeStatus'])->name('gift-product-status');
    
    
    Route::get('/gift-product/{id}', [GiftProductController::class, 'edit'])->name
    ('editGiftProduct');
    Route::put('/gift-product/update/{id}', [GiftProductController::class, 'update'])->
    name('updateGiftProduct');
    Route::delete('/gift-product/{id}', [GiftProductController::class, 'delete'])->
    name('deleteGiftProduct');
     });
    
     //Order by Coins
    route::get('order-by-point',[OrderByPointsController::class,'index'])->name('order-by-points');
    route::post('point-order-status-update',[OrderByPointsController::class,'changestatus'])->name('point-order-status-update');
    Route::post('/filter-order-by-points', [OrderByPointsController::class, 'filterdata'])->name('filter-order-by-points');



    
    // Points
    route::middleware(['auth','rolecheck:User Earn Points'])->group(function(){
    Route::get('/points/show', [PointsController::class, 'index'])->name('pointshow');
    Route::get('/points/show/{customer}', [PointsController::class, 'ShowPointHistory'])->name('ShowPointHistory');
    });




});

