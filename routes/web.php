<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/admin/login', [App\Http\Controllers\AdminLogin::class, 'create'])
    ->middleware('admin')
    ->name('admin.login');

Route::post('/admin/login', [App\Http\Controllers\AdminLogin::class, 'store'])
    ->middleware('admin')
    ->name('admin.login.store');

Route::get('/admin/dashboard', [App\Http\Controllers\DashboardController::class, 'create'])
    ->middleware('admin')
    ->name('dashboard');
