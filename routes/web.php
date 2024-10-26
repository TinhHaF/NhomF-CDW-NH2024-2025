<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;

use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;

Route::get('/admin/new/{type}', function ($type) {
    return view('admin.new.' . $type);
});

Route::get('admin/dashboard', function () {
    return view('admin.dashboard.dashboard');
});
Route::get('/register', [UserController::class, 'registerUser'])->name('user.registerUser');
Route::get('/profile', [UserController::class, 'getUserInfo'])->name('user.profile');
Route::post('register', [UserController::class, 'addUser'])->name('user.addUser');
Route::get('/login', [UserController::class, 'login'])->name('user.login');
Route::post('login', [UserController::class, 'loginUser'])->name('user.loginUser');
Route::get('logout', [UserController::class, 'logout'])->name('user.logout');
Route::get('homepage/', [PostController::class, 'homepage'])->name('home');
Route::get('homepage/posts/{id}', [PostController::class, 'show'])->name('posts.show');
Route::get('/change_pw', [UserController::class, 'change_user_password'])->name('user.change_pw');
