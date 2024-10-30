<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\UserStatsController;

Route::get('/', function () {
    return view('welcome');
});
// Route::get('/admin/new/{type}', function ($type) {
//     return view('admin.new.' . $type);
// });

Route::get('admin/dashboard', function () {
    return view('admin.dashboard.dashboard');
});

// Route::middleware('admin')->group(function () {
//     Route::resource('posts', PostController::class);
// });

Route::prefix('admin')->group(function () {
    Route::resource('posts', PostController::class);
});

Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/authors', [AuthorController::class, 'index']);
Route::patch('/posts/{id}/updateStatus', [PostController::class, 'updateStatus'])->name('posts.updateStatus');
Route::post('posts/bulk-delete', [PostController::class, 'bulkDelete'])->name('posts.bulk-delete');

Route::post('/posts/{post}/copy', [PostController::class, 'copy'])->name('posts.copy');


Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');


Route::get('/online-users', [UserStatsController::class, 'getOnlineUsers']);
Route::get('/weekly-visits', [UserStatsController::class, 'getWeeklyVisits']);
Route::get('/monthly-visits', [UserStatsController::class, 'getMonthlyVisits']);
Route::get('/total-visits', [UserStatsController::class, 'getTotalVisits']);
