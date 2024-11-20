<?php

use App\Http\Controllers\AdController;
use App\Http\Controllers\FacebookController;
use App\Http\Controllers\LogoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FileManagerController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\SlugController;
use App\Services\VisitorTrackingService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\AdministrationMiddleware;

use App\Http\Controllers\NotificationController;
// Route trang chủ
Route::get('/', [PostController::class, 'homepage'])->name('home');

// Routes xác thực người dùng - không thay đổi
Route::get('/register', [UserController::class, 'registerUser'])->name('user.registerUser');
Route::post('/register', [UserController::class, 'addUser'])->name('user.addUser');
Route::get('/login', [UserController::class, 'login'])->name('login');
Route::post('/login', [UserController::class, 'loginUser'])->name('user.loginUser');
Route::get('logout', [UserController::class, 'logout'])->name('user.logout');

// Routes người dùng - không thay đổi
Route::post('/user/update-avatar', [UserController::class, 'updateAvatar'])->name('user.update_avatar');
Route::get('/profile', [UserController::class, 'getUserInfo'])->name('user.profile');
Route::post('/change-password', [UserController::class, 'changePassword'])->name('user.change_pw');
Route::get('/change_pw', [UserController::class, 'change_user_password'])->name('user.change_show');

// Routes công khai cho bài viết
Route::get('/homepage/posts/{id}-{slug}', [PostController::class, 'detail'])->name('posts.post_detail');
Route::get('/search', [PostController::class, 'search'])->name('posts.search');
Route::get('/searchHomepage', [PostController::class, 'searchHomepage'])->name('posts.searchHomepage');
Route::get('/postsCategory/{id}', [PostController::class, 'showPostsCate'])->name('posts.showCate');


// Routes bình luận
Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments_store');

// Routes kiểm tra slug - yêu cầu xác thực
Route::post('/check-slug', [SlugController::class, 'checkSlug'])
    ->name('check.slug')
    ->middleware(['auth']);

// Routes danh mục và tác giả công khai
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/authors', [AuthorController::class, 'index']);
Route::get('/category/{id}', [CategoryController::class, 'show'])->name('category.show');
Route::get('/homepage/nav', [CategoryController::class, 'showCategory'])->name('posts.showCategory');

// Middleware cho Admin và Author
Route::middleware([AdministrationMiddleware::class])->group(function () {
    Route::prefix('admin')->group(function () {
        // Dashboard
        Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

        // CRUD Posts với encoded IDs
        Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
        Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
        Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
        Route::get('/posts/{encodedId}/edit', [PostController::class, 'edit'])->name('posts.edit');
        Route::put('/posts/{encodedId}', [PostController::class, 'update'])->name('posts.update');
        Route::delete('/posts/{encodedId}', [PostController::class, 'destroy'])->name('posts.destroy');

        // Các thao tác đặc biệt với Posts
        Route::patch('/posts/{encodedId}/update-status', [PostController::class, 'updateStatus'])->name('posts.updateStatus');
        Route::post('/posts/bulk-delete', [PostController::class, 'bulkDelete'])->name('posts.bulk-delete');
        Route::post('/posts/{encodedId}/copy', [PostController::class, 'copy'])->name('posts.copy');

        // Quản lý categories
        Route::resource('categories', CategoryController::class);
    });
});

// Middleware chỉ dành cho Admin
Route::middleware([AdminMiddleware::class])->group(function () {
    Route::prefix('admin')->group(function () {
        // Quản lý người dùng
        Route::get('users', [UserController::class, 'index'])->name('users.index');
        Route::post('/storeUser', [UserController::class, 'store'])->name('user.storeUser');
        Route::get('user/create', [UserController::class, 'store_user'])->name('users.create');
        Route::delete('user/destroyUser/{id}', [UserController::class, 'destroy'])->name('user.destroy');
        Route::get('user/detail/{id}', [UserController::class, 'show'])->name('user_view');
        Route::get('user/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
        Route::put('user/update/{id}', [UserController::class, 'update'])->name('user.update');

        // Quản lý bình luận
        Route::get('/PostsComment', [CommentController::class, 'index'])->name('PostsComment');
        Route::get('/SearchPComment', [CommentController::class, 'search'])->name('Search_PostsComment');
        Route::get('/comments/{id}', [CommentController::class, 'Comments'])->name('comments_index');
        Route::get('/comments/detail/{id}', [CommentController::class, 'detail'])->name('comments_detail');
        Route::delete('/comments/admin/delete/{comment_id}', [CommentController::class, 'delete'])->name('comments.admin_delete');
        Route::delete('/comments/user/delete/{comment_id}', [CommentController::class, 'delete'])->name('comments.user_delete');
    });
});

// Routes cho logo
Route::get('/admin/logo/upload', [LogoController::class, 'showUploadForm'])->name('logo.upload.form');
Route::post('/admin/logo/upload', [LogoController::class, 'upload'])->name('logo.upload');
Route::delete('/admin/logo/{id}', [LogoController::class, 'delete'])->name('logo.delete');

// Routes cho analytics
Route::get('/admin/analytics/chart-data', [DashboardController::class, 'getChartData']);
Route::get('/online-users', [VisitorTrackingService::class, 'getOnlineUsers']);
Route::get('/weekly-visits', [VisitorTrackingService::class, 'getWeeklyVisits']);
Route::get('/monthly-visits', [VisitorTrackingService::class, 'getMonthlyVisits']);
Route::get('/total-visits', [VisitorTrackingService::class, 'getTotalVisits']);

// Route kiểm tra slug trùng lặp
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

// Quảng cáo cho trang web
Route::middleware([AdminMiddleware::class])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('/ads', [AdController::class, 'index'])->name('ads.index');
        Route::get('/ads/create', [AdController::class, 'create'])->name('ads.create');
        Route::post('/ads', [AdController::class, 'store'])->name('ads.store');
        Route::get('/ads/{id}/edit', [AdController::class, 'edit'])->name('ads.edit');
        Route::put('/ads/{id}', [AdController::class, 'update'])->name('ads.update');
        Route::delete('/ads/{id}', [AdController::class, 'destroy'])->name('ads.destroy');
    });
});

// Đăng nhập bằng facebook
Route::get('login/facebook', [FacebookController::class, 'redirectToFacebook'])->name('login.facebook');
Route::get('login/facebook/callback', [FacebookController::class, 'handleFacebookCallback']);

// Đăng nhập bằng google
Route::get('login/google', [GoogleController::class, 'redirectToGoogle'])->name('login.google');
Route::get('login/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('callback.google');

// Để duyệt hình ảnh
Route::get('/filemanager', [FileManagerController::class, 'index'])->name('filemanager.index');

// Để tải ảnh lên
Route::post('/filemanager/upload', [FileManagerController::class, 'upload'])->name('filemanager.upload');




Route::get('/notifications', [NotificationController::class, 'index']);