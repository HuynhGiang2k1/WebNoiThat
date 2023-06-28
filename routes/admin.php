<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DiscountController;
use App\Http\Controllers\Admin\OrderController;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "admin" middleware group. Now create something great!
|
*/

Route::prefix('admin')->group(function () {
    Route::get('', [AdminController::class, 'dashboard']) ->name('admin');

    Route::get('/discounts', [AdminController::class, 'discounts']);

    Route::controller(CategoryController::class)->prefix('categories')->group(function () {
        Route::get('', 'index')->name('admin.category');
        Route::post('create', 'store')->name('admin.categories.store');
        Route::post('update', 'update')->name('admin.categories.update');
        Route::delete('delete/{id}', 'delete')->name('admin.categories.delete');
    });

    Route::controller(SubCategoryController::class)->prefix('subCategories')->group(function () {
        Route::get('', 'index')->name('admin.subcategory');
        Route::post('create', 'store')->name('admin.subcategories.store');
        Route::post('update', 'update')->name('admin.subcategories.update');
        Route::delete('delete/{id}', 'delete')->name('admin.subcategories.delete');
    });

    Route::controller(UserController::class)->prefix('users')->group(function () {
        Route::get('', 'index')->name('admin.users');
        Route::get('/{id}', 'show')->name('admin.user.show');
        Route::post('/{id}', 'update')->name('admin.user.update');
        Route::delete('/{id}', 'destroy')->name('admin.user.delete');
        Route::post('login/{id}', 'getLogin')->name('admin.user.login');
    });

    Route::controller(ProductController::class)->prefix('products')->group(function () {
        Route::get('', 'index')->name('admin.products');
        Route::get('/create', 'create')->name('admin.product.create');
        Route::post('', 'store')->name('admin.product.store');
        Route::get('/{id}', 'edit')->name('admin.product.edit');
        Route::post('/{id}', 'update')->name('admin.product.update');
        Route::delete('/{id}', 'destroy')->name('admin.product.delete');
        Route::delete('/image/{id}', 'deleteImage')->name('admin.product.deleteimg');
    });

    Route::controller(DiscountController::class)->prefix('discounts')->group(function () {
        Route::get('', 'index')->name('admin.discounts');
        Route::get('/create', 'create')->name('admin.discount.create');
        Route::post('/', 'store')->name('admin.discount.store');
        Route::get('/{id}/detail', 'show')->name('admin.discount.detail');
        Route::get('/{id}', 'edit')->name('admin.discount.edit');
        Route::post('/{id}', 'update')->name('admin.discount.update');
        Route::delete('/{id}', 'destroy')->name('admin.discount.delete');
        Route::get('/apply/{id}', 'showFormApply')->name('admin.discount.formApply');
        Route::post('/apply/{id}', 'applicableProducts')->name('admin.discount.apply');
    });

    Route::controller(OrderController::class)->prefix('orders')->group(function () {
        Route::get('/pending',  'getOrdersPending')->name('admin.orders.pending');
        Route::get('/approve',  'getOrdersApprove')->name('admin.orders.approve');
        Route::get('/success',  'getOrdersSuccess')->name('admin.orders.success');
        Route::get('/fail',  'getOrdersFail')->name('admin.orders.fail');
        Route::post('/{id}', 'update')->name('admin.order.update');
        Route::delete('/{id}', 'delete')->name('admin.order.delete');

    });
});
