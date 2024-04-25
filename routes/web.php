<?php

use App\Http\Web\Controllers\DashboardController;
use App\Http\Web\Controllers\Basket\BasketController;
use App\Http\Web\Controllers\Basket\BasketItemController;
use App\Http\Web\Controllers\Customer\CustomerController;
use App\Http\Web\Controllers\Order\OrderController;
use App\Http\Web\Controllers\Product\ProductController;
use App\Http\Web\Controllers\Site\SiteController;
use App\Http\Web\Controllers\Payment\PaymentController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [ProductController::class, 'index'])->name('products.index');
Route::get('/product/{product}', [ProductController::class, 'show'])->name('product');

Route::get('/basket', [BasketController::class, 'index'])->name('basket.index');

// Guest
Route::delete('/basket/guest/empty', [BasketController::class, 'emptyGuest']);

Route::post('/basket-items/guest', [BasketItemController::class, 'storeGuest']);
Route::put('/basket-items/guest', [BasketItemController::class, 'updateGuest']);
Route::delete('/basket-items/guest/{id}', [BasketItemController::class, 'destroyGuest']);

// Route::get('/customer/{id}/basket', [CustomerController::class, 'basket']);

// Auth Middleware
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    // 'verified',
    ])->group(function () {     
        // Basket
        Route::delete('/basket/{id}', [BasketController::class, 'destroy']);
        Route::delete('/basket/empty/{id}', [BasketController::class, 'empty']);
        
        Route::post('/basket-items', [BasketItemController::class, 'store']);
        Route::put('/basket-items', [BasketItemController::class, 'update']);
        Route::delete('/basket-items/{id}', [BasketItemController::class, 'destroy']);
        
        // App
        Route::get('/dashboard', DashboardController::class)->name('dashboard');
        Route::get('/orders', [OrderController::class, 'index'])->name('orders');
        Route::get('/payments', [PaymentController::class, 'index'])->name('payments');
        
        // Misc
        Route::get('/checkout', [SiteController::class, 'checkout'])->name('checkout');
        Route::post('/customer', [CustomerController::class, 'store']);
        
        // Customer Middleware
        Route::middleware(['customer'])->group( function() {
            Route::get('/order-confirmation', [SiteController::class, 'confirmation'])->name('order.confirmation');
            Route::post('/order', [OrderController::class, 'store']);
        });
    });