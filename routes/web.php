<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Front\PageController;
use App\Http\Controllers\Front\ProductController;
use App\Http\Controllers\SocialiteController;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\UserController;
use App\Http\Controllers\Front\OrderController;
use App\Http\Controllers\Front\PayController;
use App\Http\Controllers\Front\BotManController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::controller(PageController::class)->group(function () {
    Route::get('', 'home')->name('home');
    Route::get('gioi-thieu', 'intro')->name('intro');
    Route::get('blog', 'blog')->name('blog');
    Route::get('feedback', 'feedback')->name('feedback');
    Route::get('concept', 'concept')->name('concept');
    Route::get('thiet-ke', 'design')->name('design');
});

Route::controller(AuthController::class)->prefix('auth')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', 'showFormLogin')->name('auth.login');
        Route::post('/login', 'login')->name('auth.login.check');
        Route::get('/register', 'showFormRegister')->name('auth.register');
        Route::post('/register', 'register')->name('auth.register.check');
        Route::get('/forgot-password', 'showFormForgotPassword')->name('password.request');
        Route::post('/forgot-password', 'sendMailResetPassword')->name('password.email');
        Route::get('/reset-password/{token}', 'showFormResetPassword')->name('password.reset');
        Route::post('/reset-password', 'resetPassword')->name('password.update');
    });

    Route::middleware('auth')->group(function () {
        Route::get('/email/verify', 'showFormVerify')->name('verification.notice');
        Route::post('email/verification-notification', 'sendMailVerify')
            ->middleware(['auth', 'throttle:6,1'])
            ->name('verification.send');
        Route::get('/email/verify/{id}/{hash}', 'verify')
            ->middleware(['signed', 'throttle:6,1'])
            ->name('verification.verify');

        Route::get('/logout', 'logout')->name('auth.logout');
    });
});

Route::controller(SocialiteController::class)->group(function (){
    Route::get('auth/google', 'redireactGoogle')->name('google-auth');
    Route::get('auth/google/call-back', 'callbackGoogle');
    Route::get('auth/facebook', 'redireactFacebook')->name('facebook-auth');
    Route::get('auth/facebook/call-back', 'callbackFacebook');
});

Route::controller(ProductController::class)->group(function () {
   Route::get('danh-muc-san-pham/{category?}/{subcategory?}', 'index')->name('front.products');
   Route::get('san-pham/{id}', 'show')->name('front.product.show');
   Route::get('product/', 'search')->name('front.product.search');
   Route::get('sale', 'getSale')->name('front.product.sale');
});

Route::middleware('auth')->group(function () {
    Route::controller(UserController::class)->prefix('my')->group(function () {
        Route::get('profile', 'index')->name('front.user.profile');
        Route::get('profile/edit', 'edit')->name('front.user.edit');
        Route::post('profile/update', 'update')->name('front.user.update');
        Route::get('/order', 'getMyOrders')->name('front.user.order');
        Route::get('/order-success', 'getMyOrdersPaid')->name('front.user.order.success');
    });

    Route::middleware('verified')->group(function () {
        Route::controller(CartController::class)->prefix('cart')->group(function () {
            Route::get('', 'index')->name('cart');
            Route::post('', 'store')->name('cart.create');
            Route::post('/update', 'update')->name('cart.update');
            Route::delete('/{id}', 'destroy')->name('cart.destroy');
        });

        Route::controller(OrderController::class)->prefix('order')->group(function () {
            Route::post('', 'index')->name('order.create');
            Route::post('confirm', 'confirm')->name('order.confirm');
            Route::post('create', 'store')->name('order.store');
            Route::get('/vnpay/return', 'vnpayReturn')->name('vnpay.return');
            Route::get('/complete/{token}', 'complete')->name('order.complete');
            Route::post('/success/{id}', 'updateSuccess')->name('admin.order.success.update');
        });
    });
});

Route::match(['get', 'post'], '/botman', [BotManController::class, 'handle']);


