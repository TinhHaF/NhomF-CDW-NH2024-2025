<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\UserStatsController;


// Route trang chủ
Route::get('/', [PostController::class, 'homepage'])->name('home');
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

Route::get('homepage/posts/{id}', [PostController::class, 'show'])->name('posts.show');
// Chỉ giữ một route cho admin dashboard
Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
Route::get('homepage/', [PostController::class, 'homepage'])->name('home');
Route::get('homepage/posts/{id}', [PostController::class, 'show'])->name('posts.show');
Route::post('/change-password', [UserController::class, 'changePassword'])->name('user.change_pw');
Route::get('/change_pw', [UserController::class, 'change_user_password'])->name('user.change_show');
// Route::middleware('admin')->group(function () {
//     Route::resource('posts', PostController::class);
// });


// Routes cho admin (group theo prefix)
Route::prefix('admin')->group(function () {
    Route::resource('posts', PostController::class);
});

// Các routes khác
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/authors', [AuthorController::class, 'index']);
Route::patch('/posts/{id}/updateStatus', [PostController::class, 'updateStatus'])->name('posts.updateStatus');
Route::post('posts/bulk-delete', [PostController::class, 'bulkDelete'])->name('posts.bulk-delete');

Route::post('/posts/{post}/copy', [PostController::class, 'copy'])->name('posts.copy');


// Routes thống kê người dùng
Route::get('/online-users', [UserStatsController::class, 'getOnlineUsers']);
Route::get('/weekly-visits', [UserStatsController::class, 'getWeeklyVisits']);
Route::get('/monthly-visits', [UserStatsController::class, 'getMonthlyVisits']);
Route::get('/total-visits', [UserStatsController::class, 'getTotalVisits']);

//comments

// Route cho việc lưu bình luận
Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');

