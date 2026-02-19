<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\AdminCheck;
use App\Http\Middleware\LoggedInAdmin;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin All Routes
Route::prefix('admin')->group(function () {
    Route::controller(AdminController::class)->group(function () {
        Route::get('login', 'LoginPage')->name('admin.login.page')->middleware(LoggedInAdmin::class);
        Route::get('dashboard', 'AdminDashboard')->name('admin.dashboard')->middleware(AdminCheck::class);
        Route::post('login/success', 'AdminLogin')->name('admin.login');
        Route::post('logout', 'AdminLogout')->name('admin.logout');

    });

    Route::resource('product', ProductController::class)->middleware(AdminCheck::class);
});

Route::controller(CartController::class)->group(function () {
    Route::post('cart/add/{id}', 'CartAdd')->name('cart.add');

    Route::get('cart/product', 'CartProducts')->name('cart.product');

    Route::delete('/cart/remove/{id}', 'CartRemove');
    Route::put('/cart/quantity/{id}', 'CartQuantity');
});

require __DIR__.'/auth.php';
