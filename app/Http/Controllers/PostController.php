<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Author;
use App\Models\Category;
use App\Services\PostService;
use App\Helpers\IdEncoder;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Http\Resources\PostCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Routing\Controller;

class PostController extends Controller
{
    use AuthorizesRequests;

    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    
        // Middleware auth yêu cầu xác thực cho tất cả các phương thức ngoại trừ homepage và show
        $this->middleware('auth')->except(['homepage','detail']);
    
        // Sử dụng authorizeResource để quản lý quyền truy cập cho các phương thức trong controller
        $this->authorizeResource(Post::class, 'post');
    }

    public function homepage()
    {
        try {
            $posts = Cache::remember('home_posts', 3600, function () {
                return Post::where('is_published', true)
                    ->latest()
                    ->paginate(6);
            });

            $featuredPosts = Cache::remember('featured_posts', 3600, function () {
                return Post::where('is_published', true)
                    ->where('is_featured', true)
                    ->latest()
                    ->paginate(6);
            });

            return view('home', compact('posts', 'featuredPosts'));
        } catch (\Exception $e) {
            Log::error('Homepage loading failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return view('home')->with('error', 'Không thể tải trang chủ. Vui lòng thử lại sau.');
        }
    }

    public function detail($id, $slug)
    {
        try {
            $post = Post::find($id);
            if (!$post || $post->slug !== $slug) {
                return abort(404, 'Bài viết không tồn tại.');
            }

            // Lấy bình luận và phân trang
            $comments = $post->comments()->orderBy('created_at', 'desc')->paginate(5);

            return view('posts.post_detail', compact('post', 'comments'));
        } catch (ModelNotFoundException $e) {
            Log::info('Post not found', ['id' => $id]);
            return request()->expectsJson()
                ? response()->json(['error' => 'Bài viết không tồn tại.'], 404)
                : abort(404, 'Bài viết không tồn tại.');
        } catch (\Exception $e) {
            return back()->with('error', 'Có lỗi xảy ra. Vui lòng thử lại sau.');
        }
    }





    public function index(Request $request)
    {
        try {
            $query = $request->input('search');
            $posts = Post::search($query);
            // Kiểm tra xem có bài viết nào được tìm thấy không
            if ($posts->isEmpty()) {
                session()->flash('message', 'Không tìm thấy bài viết nào với từ khóa tìm kiếm.');
            }
            if ($request->expectsJson()) {
                return new PostCollection($posts);
            }

            $encodeId = function ($id) {
                return IdEncoder::encode($id);
            };

            return view('admin.posts.index', compact('posts', 'encodeId'));
        } catch (\Exception $e) {
            Log::error('Error listing posts', [
                'search' => $query,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return $request->expectsJson()
                ? response()->json(['error' => 'Có lỗi xảy ra.'], 500)
                : back()->with('error', 'Có lỗi xảy ra khi tải danh sách bài viết.');
        }
    }


    public function create()
    {
        try {
            $categories = Cache::remember('categories.all', 3600, fn() => Category::all());
            $authors = Cache::remember('authors.all', 3600, fn() => Author::all());
            Log::info('Categories being passed to view:', ['categories' => $categories->toArray()]);
            return view('admin.posts.create', compact('categories', 'authors'));
        } catch (\Exception $e) {
            Log::error('Error loading create post form', ['error' => $e->getMessage()]);

            return back()->with('error', 'Có lỗi xảy ra khi tải form tạo bài viết.');
        }
    }

    public function store(StorePostRequest $request)
    {
        try {
            // dd($request->all()); // Thêm dòng này để debug
            $post = $this->postService->create(
                $request->validated(),
                $request->hasFile('image') ? $request->file('image') : null
            );

            Log::info('Post created', [
                'post_id' => $post->id,
                'user_id' => Auth::id()
            ]);

            // Cache::tags(['posts', 'homepage'])->flush();

            return $request->expectsJson()
                ? new PostResource($post)
                : redirect()->route('posts.index')->with('success', 'Bài viết đã được thêm thành công!');
        } catch (\Exception $e) {
            Log::error('Post creation failed', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id()
            ]);
            Log::info('Category ID received:', ['category_id' => $request->category_id]);
            return $request->expectsJson()
                ? response()->json(['error' => 'Không thể tạo bài viết.'], 500)
                : back()->withInput()->with('error', 'Có lỗi xảy ra khi tạo bài viết.');
        }
    }

    public function edit(Post $post)
    {
        try {
            $categories = Cache::remember('categories.all', 3600, fn() => Category::all());
            $authors = Cache::remember('authors.all', 3600, fn() => Author::all());

            return view('admin.posts.edit', compact('post', 'categories', 'authors'));
        } catch (\Throwable $e) {
            Log::error('Error loading edit post form', [
                'post_id' => $post->id,
                'error' => $e->getMessage()
            ]);
            return back()->with('error', 'Có lỗi xảy ra khi tải form chỉnh sửa.');
        }
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        try {
            $updatedPost = $this->postService->update(
                $post,
                $request->validated(),
                $request->hasFile('image') ? $request->file('image') : null
            );

            Log::info('Post updated', [
                'post_id' => $post->id,
                'user_id' => Auth::id()
            ]);

            // Cache::tags(['posts', 'homepage'])->flush();

            return $request->expectsJson()
                ? new PostResource($updatedPost)
                : redirect()->route('posts.index')->with('success', 'Cập nhật bài viết thành công!');
        } catch (\Exception $e) {
            Log::error('Post update failed', [
                'post_id' => $post->id,
                'error' => $e->getMessage()
            ]);
            return $request->expectsJson()
                ? response()->json(['error' => 'Không thể cập nhật bài viết.'], 500)
                : back()->withInput()->with('error', 'Có lỗi xảy ra khi cập nhật bài viết.');
        }
    }

    public function destroy(Post $post)
    {
        try {
            $this->postService->delete($post);

            Log::info('Post deleted', [
                'post_id' => $post->id,
                'user_id' => Auth::id()
            ]);
            

            // Cache::tags(['posts', 'homepage'])->flush();

            return request()->expectsJson()
                ? response()->json(['message' => 'Xóa bài viết thành công'])
                : redirect()->route('posts.index')->with('success', 'Bài viết đã được xóa thành công!');
        } catch (\Exception $e) {
            Log::error('Post deletion failed', [
                'post_id' => $post->id,
                'error' => $e->getMessage()
            ]);
            return request()->expectsJson()
                ? response()->json(['error' => 'Không thể xóa bài viết.'], 500)
                : back()->with('error', 'Có lỗi xảy ra khi xóa bài viết.');
        }
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $post = Post::findOrFail($id);

            // Cập nhật trạng thái
            $post->updateStatus(
                $request->has('is_featured'),
                $request->has('is_published')
            );

            // Log khi cập nhật thành công
            Log::info('Post status updated', [
                'post_id' => $post->id,
                'user_id' => Auth::id(),
                'featured' => $request->has('is_featured'),
                'published' => $request->has('is_published')
            ]);

            return request()->expectsJson()
                ? new PostResource($post)
                : redirect()->route('posts.index')->with('success', 'Trạng thái bài viết đã cập nhật!');
        } catch (\Exception $e) {
            // Ghi log lỗi với ID nếu bài viết không tìm thấy
            Log::error('Post status update failed', [
                'post_id' => $id,
                'error' => $e->getMessage()
            ]);

            return request()->expectsJson()
                ? response()->json(['error' => 'Không thể cập nhật trạng thái.'], 500)
                : back()->with('error', 'Có lỗi xảy ra khi cập nhật trạng thái.');
        }
    }



    public function bulkDelete(Request $request)
    {
        $postIds = []; // Khởi tạo biến $postIds ở đây

        try {
            $postIds = $request->input('post_ids', []);

            if (empty($postIds)) {
                return redirect()->route('posts.index')
                    ->with('error', 'Không có bài viết nào được chọn.');
            }

            $this->postService->bulkDelete($postIds);

            Log::info('Bulk delete completed', [
                'post_ids' => $postIds,
                'user_id' => Auth::id()
            ]);

            // Cache::tags(['posts', 'homepage'])->flush();

            return request()->expectsJson()
                ? response()->json(['message' => 'Xóa các bài viết thành công'])
                : redirect()->route('posts.index')->with('success', 'Các bài viết đã được xóa thành công.');
        } catch (\Exception $e) {
            Log::error('Bulk deletion failed', [
                'post_ids' => $postIds,
                'error' => $e->getMessage()
            ]);
            return request()->expectsJson()
                ? response()->json(['error' => 'Không thể xóa các bài viết.'], 500)
                : back()->with('error', 'Có lỗi xảy ra khi xóa các bài viết.');
        }
    }


    public function copy(Post $post)
    {
        try {
            $newPost = $this->postService->copy($post);

            Log::info('Post copied', [
                'original_id' => $post->id,
                'new_id' => $newPost->id,
                'user_id' => Auth::id()
            ]);

            // Cache::tags(['posts', 'homepage'])->flush();

            return request()->expectsJson()
                ? new PostResource($newPost)
                : redirect()->route('posts.index')->with('success', 'Bài viết đã được sao chép thành công.');
        } catch (\Exception $e) {
            Log::error('Post copy failed', [
                'post_id' => $post->id,
                'error' => $e->getMessage()
            ]);
            return request()->expectsJson()
                ? response()->json(['error' => 'Không thể sao chép bài viết.'], 500)
                : back()->with('error', 'Có lỗi xảy ra khi sao chép bài viết.');
        }
    }
}
