<?php

use App\Http\Controllers\AdController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FacebookController;
use App\Http\Controllers\LogoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\FileManagerController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\SlugController;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\AdministrationMiddleware;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;

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
// Route::get('/posts/{post}', [PostController::class, 'showPostsSimilar'])->name('posts.show');

Route::get('/tags/{id}', [PostController::class, 'postsByTag'])->name('posts.by_tag');

// Middleware cho Admin và Author
Route::middleware([AdministrationMiddleware::class])->group(function () {
    Route::prefix('admin')->group(function () {
        // Dashboard
        Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('/dashboard/chart-data', [DashboardController::class, 'getChartData']);

        // CRUD Posts với encoded IDs
        Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
        Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
        Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
        Route::get('/posts/{encodedId}/edit', [PostController::class, 'edit'])->name('posts.edit');
        Route::put('/posts/{encodedId}', [PostController::class, 'update'])->name('posts.update');
        
        // Các thao tác đặc biệt với Posts
        Route::patch('/posts/{encodedId}/update-status', [PostController::class, 'updateStatus'])->name('posts.updateStatus');
        Route::post('/posts/bulk-delete', [PostController::class, 'bulkDelete'])->name('posts.bulk-delete');
        Route::post('/posts/{encodedId}/copy', [PostController::class, 'copy'])->name('posts.copy');

       
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


        //Cap quyen author
        Route::get('/admin/author-requests', [UserController::class, 'viewRequests'])->name('author-requests');
        Route::post('/admin/author-requests/{id}/approve', [UserController::class, 'approveRequest']);
        Route::delete('/admin/author-requests/{id}/reject', [UserController::class, 'rejectRequest'])->name('author-rejectRequest');


         // Quản lý categories
         Route::resource('categories', CategoryController::class);

         // Quảng cáo
         Route::get('/ads', [AdController::class, 'index'])->name('ads.index');
         Route::get('/ads/create', [AdController::class, 'create'])->name('ads.create');
         Route::post('/ads', [AdController::class, 'store'])->name('ads.store');
         Route::get('/ads/{encodedId}/edit', [AdController::class, 'edit'])->name('ads.edit');
         Route::put('/ads/{encodedId}', [AdController::class, 'update'])->name('ads.update');
         Route::delete('/ads/{encodedId}', [AdController::class, 'destroy'])->name('ads.destroy');

         //xoa bai viet
         Route::delete('/posts/{encodedId}', [PostController::class, 'destroy'])->name('posts.destroy');

    });
});
Route::delete('/comments/user/delete/{comment_id}', [CommentController::class, 'delete'])->name('comments.user_delete');
// Routes cho logo
Route::get('/admin/logo/upload', [LogoController::class, 'showUploadForm'])->name('logo.upload.form');
Route::post('/admin/logo/upload', [LogoController::class, 'upload'])->name('logo.upload');
Route::delete('/admin/logo/{id}', [LogoController::class, 'delete'])->name('logo.delete');

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
//quên mật khẩu
// Hiển thị form quên mật khẩu
// Route cho việc gửi email đặt lại mật khẩu
Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');

// Route cho việc nhập mật khẩu mới
Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.update');
//đăng kí nhận tin 
Route::post('/subscribe', [SubscriptionController::class, 'subscribe'])->name('subscribe');


Route::get('/notifications', [NotificationController::class, 'index']);


Route::get('/authors/{id}', [AuthorController::class, 'show'])->name('authors.show');
Route::get('posts/{id}', [PostController::class, 'show'])->name('posts.show');
Route::post('/authors/{author}/follow', [AuthorController::class, 'follow'])->name('authors.follow');
Route::delete('/authors/{author}/unfollow', [AuthorController::class, 'unfollow'])->name('authors.unfollow');
Route::get('/authors/show/{authorId}', [AuthorController::class, 'show'])->name('authors.show');


Route::get('/privacy-policy', function () {
    return view('privacy-policy');
});


Route::get('/register-author-show', [UserController::class, 'showRegisterForm'])->name('show_rq')->middleware('auth');
Route::post('/register-author', [UserController::class, 'submitRegisterForm'])->name('update_auth')->middleware('auth');



Route::post('/posts/{post}/save', [PostController::class, 'savePost'])->name('posts.save');