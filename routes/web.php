<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/admin/login', [App\Http\Controllers\AdminLogin::class, 'create'])
    ->middleware('admin')
    ->name('admin.login');

Route::post('/admin/login', [App\Http\Controllers\AdminLogin::class, 'store'])
    ->middleware('admin')
    ->name('admin.login.store');

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'create'])->name('dashboard');
    //                     name('dashboard') inside group → full name is 'admin.dashboard'
});