<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
Route::get('/', function () {
    return view('welcome');
});
Route::get('/admin/new/{type}', function ($type) {
    return view('admin.new.' . $type);
});

Route::get('admin/dashboard', function () {
    return view('admin.dashboard.dashboard');
});


Route::get('/register', [UserController::class, 'registerUser'])->name('user.registerUser');
Route::post('register', [UserController::class, 'addUser'])->name('user.addUser');
Route::get('/login', [UserController::class, 'login'])->name('user.login');
Route::post('login', [UserController::class, 'loginUser'])->name('user.loginUser');
Route::get('/home', [UserController::class, 'home'])->name('home');