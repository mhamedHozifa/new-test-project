<?php

use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\User\AuthController;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

Route::get('/admin/login', [AdminLoginController::class, 'create'])
    ->name('admin.login.form');

Route::post('/admin/login', [AdminLoginController::class, 'store'])
    ->name('admin.login');

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['AdminProtectMiddleware'])
    ->group(function () {
        Route::get('/', function () {
            return view('admin.dashboard', [
                'productsCount' => Product::count(),
                'categoriesCount' => Category::count(),
                'featuredCount' => Product::where('is_featured', true)->count(),
                'lowStockCount' => Product::where('stock', '<=', 5)->count(),
            ]);
        })->name('dashboard');

        Route::resource('products', ProductController::class)->except(['create', 'edit', 'show']);
        Route::get('products/{product}/edit-data', [ProductController::class, 'editData'])
            ->name('products.edit-data');

        Route::resource('categories', CategoryController::class)->except(['create', 'edit', 'show']);
        Route::get('categories/{category}/edit-data', [CategoryController::class, 'editData'])
            ->name('categories.edit-data');

        Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');
    });

Route::get('/register', [AuthController::class, 'showRegisterForm'])
    ->name('user.register.form');

Route::post('/register', [AuthController::class, 'register'])
    ->name('user.register');

Route::get('/', [AuthController::class, 'showLoginForm'])
    ->name('user.login.form');

Route::post('/', [AuthController::class, 'login'])
    ->name('user.login');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('user.logout');

Route::get('/forgot-password', [AuthController::class, 'showForgotForm'])
    ->name('user.forgot.form');

Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])
    ->name('user.forgot');

Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])
    ->name('password.reset');

Route::post('/reset-password', [AuthController::class, 'reset'])
    ->name('user.reset');