<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerManagementController;

// trang login, register
Route::get('login', [UserController::class, 'login'])->name('login');
Route::get('register', [UserController::class, 'register'])->name('register');

