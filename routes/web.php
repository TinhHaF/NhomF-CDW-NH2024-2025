<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/admin/new/{type}', function ($type) {
    return view('admin.new.' . $type);
});

Route::get('admin/dashboard', function () {
    return view('admin.dashboard.dashboard');
});



Route::get('homepage/', [PostController::class, 'index'])->name('post.show');