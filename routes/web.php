<?php

use App\Http\Controllers\LogoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SlugController;
use App\Services\VisitorTrackingService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

// Route trang chủ
Route::get('/', [PostController::class, 'homepage'])->name('home');

// Route cho trang dashboard admin

// Route cho đăng ký và đăng nhập
Route::get('/register', [UserController::class, 'registerUser'])->name('user.registerUser');
Route::post('/register', [UserController::class, 'addUser'])->name('user.addUser');
Route::get('/login', [UserController::class, 'login'])->name('login');
Route::post('/login', [UserController::class, 'loginUser'])->name('user.loginUser');
Route::get('logout', [UserController::class, 'logout'])->name('user.logout');

// Route cho thông tin người dùng
Route::get('/profile', [UserController::class, 'getUserInfo'])->name('user.profile');
Route::post('/change-password', [UserController::class, 'changePassword'])->name('user.change_pw');
Route::get('/change_pw', [UserController::class, 'change_user_password'])->name('user.change_show');

// Route cho bài viết
Route::get('/homepage/posts/{id}-{slug}', [PostController::class, 'detail'])->name('posts.post_detail');
//bình luận
Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments_store');





// Group routes cho admin, chỉ cho phép admin đã xác thực truy cập
Route::post('/check-slug', [SlugController::class, 'checkSlug'])
    ->name('check.slug')
    ->middleware(['auth']);


// Routes cho các category và author
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/authors', [AuthorController::class, 'index']);

// Routes cho các hành động khác liên quan đến bài viết
Route::patch('posts/{post}/update-status', [PostController::class, 'updateStatus'])->name('posts.updateStatus');


Route::post('posts/bulk-delete', [PostController::class, 'bulkDelete'])->name('posts.bulk-delete');
Route::post('/posts/{post}/copy', [PostController::class, 'copy'])->name('posts.copy');


Route::post('/check-slug', function (Request $request) {
    $validator = Validator::make($request->all(), [
        'slug' => [
            'required',
            Rule::unique('posts', 'slug')->ignore($request->post_id),
        ]
    ]);

    return response()->json([
        'duplicate' => $validator->fails()
    ]);
});

// Routes thống kê người dùng
Route::get('/online-users', [VisitorTrackingService::class, 'getOnlineUsers']);
Route::get('/weekly-visits', [VisitorTrackingService::class, 'getWeeklyVisits']);
Route::get('/monthly-visits', [VisitorTrackingService::class, 'getMonthlyVisits']);
Route::get('/total-visits', [VisitorTrackingService::class, 'getTotalVisits']);

// Route cho việc lưu bình luận

// Group routes cho admin, chỉ cho phép admin đã xác thực truy cập
Route::middleware(['auth'])->group(function () {
    Route::prefix('admin')->middleware(['admin'])->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::resource('posts', PostController::class);

        // Route để xử lý khi gửi form tải lên logo
    });
});

Route::get('/admin/logo/upload', [LogoController::class, 'showUploadForm'])->name('logo.upload.form');
Route::post('/admin/logo/upload', [LogoController::class, 'upload'])->name('logo.upload');
Route::delete('/admin/logo/{id}', [LogoController::class, 'delete'])->name('logo.delete');


Route::get('/admin/analytics/chart-data', [DashboardController::class, 'getChartData']);
