<?php

namespace App\Http\Controllers;


use App\Helpers\IdEncoder_2;
use App\Models\Subscriber;
use App\Models\Post;
use App\Models\Author;
use App\Models\Category;
use App\Services\PostService;
use App\Notifications\NewPostNotification;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Logo;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controller;
use App\Models\Notification;

class PostController extends Controller
{
    use AuthorizesRequests;

    protected $postService;

    protected $idEncoder;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
        $this->idEncoder = new IdEncoder_2();
        // Middleware auth yêu cầu xác thực cho tất cả các phương thức ngoại trừ homepage và show
        $this->middleware('auth')->except(['homepage', 'detail', 'search', 'searchHomepage']);
        // $this->authorizeResource(Post::class, 'post'); // Phương thức này sẽ hoạt động nếu trait được sử dụng
    }


    // Trong Controller
    public function homepage()
    {
        try {
            $posts = Post::where('is_published', true)
                ->whereNotNull('image') // Chỉ lấy bài viết có ảnh
                ->where('image', '!=', '') // Kiểm tra thêm nếu image là chuỗi rỗng
                ->latest()
                ->take(6)
                ->get();

            $featuredPosts = Post::where('is_featured', true)
                ->whereNotNull('image') // Chỉ lấy bài viết nổi bật có ảnh
                ->where('image', '!=', '') // Kiểm tra thêm nếu image là chuỗi rỗng
                ->latest()
                ->take(6) // Lấy đúng 6 bài nổi bật
                ->get(); // Không phân trang, chỉ lấy các bài viết cần thiết

            // Lấy tất cả các danh mục
            $categories = Category::all();
            $notifications = Notification::all();
            $logo = Logo::latest()->first();
            $logoPath = $logo ? $logo->path : 'images/logo.jpg';

            // Lấy tag
            $tags = Tag::all();

            return view('home', compact('posts', 'featuredPosts', 'categories', 'logoPath', 'tags'));
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
            $post = Post::where('id', $id)->where('slug', $slug)->firstOrFail();
            if (!$post || $post->slug !== $slug) {
                return abort(404, 'Bài viết không tồn tại.');
            }



            // Tăng lượt xem
            $post->increment('view');

            // Lấy bình luận gốc và phân trang
            $comments = $post->comments()
                ->whereNull('parent_id')  // Chỉ lấy bình luận gốc
                ->with('replies')         // Lấy tất cả phản hồi lồng vào
                ->orderBy('created_at', 'desc')
                ->paginate(5);

            // Lấy tất cả các danh mục
            $categories = Category::all();
            $notifications = Notification::all();
            // Lấy bài viết liên quan cùng danh mục
            $relatedPosts = Post::where('category_id', $post->category_id)
                ->where('id', '!=', $post->id) // Loại bỏ bài viết hiện tại
                ->latest()
                ->take(5) // Giới hạn số lượng bài viết liên quan
                ->get();

            $logo = Logo::latest()->first();
            $logoPath = $logo ? $logo->path : 'images/logo.jpg';

            $featuredPosts = Post::where('is_featured', true)
                ->whereNotNull('image') // Chỉ lấy bài viết nổi bật có ảnh
                ->where('image', '!=', '') // Kiểm tra thêm nếu image là chuỗi rỗng
                ->latest()
                ->take(6) // Lấy đúng 6 bài nổi bật
                ->get(); // Không phân trang, chỉ lấy các bài viết cần thiết
            Notification::where('post_id', $id)->where('user_id', Auth::id())->update(['read' => true]);
            return view('posts.post_detail', compact('post', 'comments', 'categories', 'logoPath', 'featuredPosts'));
        } catch (ModelNotFoundException $e) {
            Log::info('Post not found', ['id' => $id]);
            return request()->expectsJson()
                ? response()->json(['error' => 'Bài viết không tồn tại.'], 404)
                : abort(404, 'Bài viết không tồn tại.');
        } catch (\Exception $e) {
            return back()->with('error', 'Có lỗi xảy ra. Vui lòng thử lại sau.');
        }
    }

    public function showPostsCate($id)
    {
        // Tìm danh mục theo ID
        $category = Category::findOrFail($id);
        // Lấy các bài viết nổi bật có ảnh
        $featuredPosts = Post::where('is_featured', true)
            ->whereNotNull('image') // Chỉ lấy bài viết có ảnh
            ->where('image', '!=', '') // Loại trừ chuỗi rỗng
            ->latest()
            ->take(6) // Giới hạn 6 bài viết
            ->get();

        // Lấy logo mới nhất hoặc gán giá trị mặc định
        $logo = Logo::latest()->first();
        $logoPath = $logo ? $logo->path : 'images/no-image-available';

        // Lấy tất cả danh mục
        $categories = Category::all();
        // Lấy các bài viết thuộc danh mục đó
        $posts = $category->posts()->latest()->paginate(10);

        // Trả về view và truyền dữ liệu
        return view('posts.post_categories', compact('category', 'posts', 'logoPath', 'categories', 'featuredPosts'));
    }

    public function searchHomePage(Request $request)
    {
        try {
            // Lấy các bài viết nổi bật có ảnh
            $featuredPosts = Post::where('is_featured', true)
                ->whereNotNull('image') // Chỉ lấy bài viết có ảnh
                ->where('image', '!=', '') // Loại trừ chuỗi rỗng
                ->latest()
                ->take(6) // Giới hạn 6 bài viết
                ->get();

            // Lấy logo mới nhất hoặc gán giá trị mặc định
            $logo = Logo::latest()->first();
            $logoPath = $logo ? $logo->path : 'images/no-image-available';

            // Lấy tất cả danh mục
            $categories = Category::all();

            // Lấy từ khóa tìm kiếm
            $query = $request->input('query');

            $notifications = Notification::all();
            // Tìm kiếm bài viết theo tiêu đề hoặc nội dung, phân trang 5 bài mỗi trang
            $posts = Post::where('title', 'LIKE', "%{$query}%")
                ->orWhere('content', 'LIKE', "%{$query}%")
                ->paginate(3); // Số bài viết mỗi trang là 5

            // Trả về view kết quả tìm kiếm
            return view('posts.posts_search', compact('posts', 'query', 'logoPath', 'categories', 'featuredPosts', 'notifications'));
        } catch (\Exception $e) {
            // Log lỗi để tiện debug
            \Log::error("Error during search: " . $e->getMessage());

            // Trả về trang lỗi với thông báo
            return redirect()->back()->with('error', 'Đã xảy ra lỗi trong quá trình tìm kiếm. Vui lòng thử lại sau.');
        }
    }




    public function search(Request $request)
    {
        $query = $request->input('query');

        // Tìm kiếm bài viết có ảnh
        $posts = Post::where(function ($queryBuilder) use ($query) {
            $queryBuilder->where('title', 'like', '%' . $query . '%')
                ->orWhere('content', 'like', '%' . $query . '%');
        })
            ->whereNotNull('image')  // Chỉ lấy bài viết có ảnh
            ->where('image', '!=', '')  // Kiểm tra thêm nếu image là chuỗi rỗng
            ->paginate(6);

        return view('posts.posts_search', compact('posts'));
    }


    public function index(Request $request)
    {
        try {
            $query = $request->input('search');
            $posts = Post::search($query);

            // Kiểm tra nếu không có bài viết nào
            if ($posts->isEmpty()) {
                $message = 'Không có bài viết nào có thông tin phù hợp với kết quả bạn đang tìm';
            } else {
                $message = null;
            }

            if ($request->expectsJson()) {
                return response()->json(['posts' => $posts->toArray(), 'message' => $message]);
            }

            $encodeId = function ($id) {
                return IdEncoder_2::encode($id);
            };

            return view('admin.posts.index', compact('posts', 'encodeId', 'message'));
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
            // Lấy danh mục và tác giả từ database thay vì cache
            $categories = Category::orderBy('created_at', 'desc')->get(); // Truy vấn tất cả danh mục từ cơ sở dữ liệu
            $authors = Author::orderBy('created_at', 'desc')->get(); // Truy vấn tất cả tác giả từ cơ sở dữ liệu
            $tags = Tag::orderBy('name')->get();

            Log::info('Categories being passed to view:', ['categories' => $categories->toArray()]);

            return view('admin.posts.create', compact('categories', 'authors', 'tags'));
        } catch (\Exception $e) {
            Log::error('Error loading create post form', ['error' => $e->getMessage()]);

            return back()->with('error', 'Có lỗi xảy ra khi tải form tạo bài viết.');
        }
    }

    private function sendNewPostNotification($post)
    {
        // Lấy tất cả các subscriber từ database
        $subscribers = Subscriber::all();

        // Gửi notification cho tất cả subscriber
        foreach ($subscribers as $subscriber) {
            $subscriber->notify(new NewPostNotification($post));
        }
    }
    public function store(StorePostRequest $request)
    {
        try {
            // Kiểm tra dữ liệu và log để debug nếu cần
            Log::info('Creating post', [
                'request_data' => $request->all(),
                'user_id' => Auth::id()
            ]);

            // Xử lý ảnh (nếu có)
            $imageUrl = null;
            if ($request->hasFile('image')) {
                $imageUrl = $request->file('image')->store('posts', 'public');
            }

            // Tạo bài viết
            $post = $this->postService->create(
                $request->validated(),
                $imageUrl
            );

            // Sync tags
            // if ($request->has('tags')) {
            //     $post->tags()->sync($request->tags);
            // }
            // Xử lý tags
            if ($request->has('tags')) {
                $post->tags()->attach($request->tags); // Gắn tags cũ
            }

            if ($request->has('new_tags')) {
                $newTags = explode(',', $request->new_tags);
                foreach ($newTags as $tagName) {
                    $tagName = trim($tagName);
                    if ($tagName) {
                        $tag = Tag::firstOrCreate(['name' => $tagName]); // Tạo tag nếu chưa tồn tại
                        $post->tags()->attach($tag->id);
                    }
                }
            }


            // Gửi thông báo qua email cho tất cả các subscriber
            $this->sendNewPostNotification($post);

            // Log thông tin tạo bài viết thành công
            Log::info('Post created successfully', [
                'post_id' => $post->id,
                'user_id' => Auth::id()
            ]);

            // Tạo thông báo cho người dùng khi bài viết được thêm
            Notification::create([
                'type' => 'post_created', // Loại thông báo
                'title' => 'Bài viết mới !!!"' . $post->title, // Tiêu đề thông báo
                'read' => false, // Chưa đọc
                'user_id' => Auth::id(),
                'post_id' => $post->id,
            ]);

            // Xử lý trả về kết quả tùy vào yêu cầu JSON hoặc redirect
            return $request->expectsJson()
                ? new PostResource($post) // Trả về tài nguyên post dưới dạng JSON
                : redirect()->route('posts.index')->with('success', 'Bài viết đã được thêm thành công!');
        } catch (\Exception $e) {
            Log::error('Post creation failed', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id(),
                'request_data' => $request->all()
            ]);

            return $request->expectsJson()
                ? response()->json(['error' => 'Không thể tạo bài viết.'], 500)
                : back()->withInput()->with('error', 'Có lỗi xảy ra khi tạo bài viết.');
        }
    }


    public function edit($encodedId)
    {
        try {
            // Validate và giải mã ID
            if (!IdEncoder_2::isValid($encodedId)) {
                throw new \InvalidArgumentException('ID không hợp lệ');
            }

            $id = IdEncoder_2::decode($encodedId);
            $post = Post::findOrFail($id);

            // Lấy danh mục và tác giả từ database
            $categories = Category::all();
            $authors = Author::all();
            $tags = Tag::orderBy('name')->get();

            // Thêm encoded_id vào post để sử dụng trong form
            $post->encoded_id = IdEncoder_2::encode($post->id);

            return view('admin.posts.edit', compact('post', 'categories', 'authors', 'tags'));
        } catch (\Exception $e) {
            Log::error('Error loading edit post form', [
                'encoded_id' => $encodedId,
                'error' => $e->getMessage()
            ]);

            return back()->with('error', 'Có lỗi xảy ra khi tải form chỉnh sửa.');
        }
    }

    public function update(UpdatePostRequest $request, $encodedId)
    {
        try {
            // Validate và giải mã ID
            if (!IdEncoder_2::isValid($encodedId)) {
                throw new \InvalidArgumentException('ID không hợp lệ');
            }

            $id = IdEncoder_2::decode($encodedId);
            $post = Post::findOrFail($id);

            $updatedPost = $this->postService->update(
                $post,
                $request->validated(),
                $request->hasFile('image') ? $request->file('image') : null
            );

            // // Sync tags
            if ($request->has('tags')) {
                $updatedPost->tags()->sync($request->tags);
            }

            // Thêm encoded_id cho response
            $updatedPost->encoded_id = IdEncoder_2::encode($updatedPost->id);

            Log::info('Post updated', [
                'encoded_id' => $encodedId,
                'user_id' => Auth::id()
            ]);

            return $request->expectsJson()
                ? new PostResource($updatedPost)
                : redirect()->route('posts.index')->with('success', 'Cập nhật bài viết thành công!');
        } catch (\Exception $e) {
            Log::error('Post update failed', [
                'encoded_id' => $encodedId,
                'error' => $e->getMessage()
            ]);
            return $request->expectsJson()
                ? response()->json(['error' => 'Không thể cập nhật bài viết.'], 500)
                : back()->withInput()->with('error', 'Có lỗi xảy ra khi cập nhật bài viết.');
        }
    }


    public function destroy($encodedId)
    {
        try {
            // Validate và giải mã ID
            if (!IdEncoder_2::isValid($encodedId)) {
                throw new \InvalidArgumentException('ID không hợp lệ');
            }

            $id = IdEncoder_2::decode($encodedId);
            $post = Post::findOrFail($id);

            $this->postService->delete($post);

            Log::info('Post deleted', [
                'encoded_id' => $encodedId,
                'user_id' => Auth::id()
            ]);

            return request()->expectsJson()
                ? response()->json(['message' => 'Xóa bài viết thành công'])
                : redirect()->route('posts.index')->with('success', 'Bài viết đã được xóa thành công!');
        } catch (\Exception $e) {
            Log::error('Post deletion failed', [
                'encoded_id' => $encodedId,
                'error' => $e->getMessage()
            ]);
            return request()->expectsJson()
                ? response()->json(['error' => 'Không thể xóa bài viết.'], 500)
                : back()->with('error', 'Có lỗi xảy ra khi xóa bài viết.');
        }
    }



    public function updateStatus(Request $request, $encodedId)
    {
        try {
            if (!IdEncoder_2::isValid($encodedId)) {
                throw new \InvalidArgumentException('ID không hợp lệ');
            }

            $id = IdEncoder_2::decode($encodedId);
            $post = Post::findOrFail($id);
            $this->authorize('update', $post);

            $post->updateStatus(
                $request->has('is_featured'),
                $request->has('is_published')
            );

            Log::info('Post status updated', [
                'encoded_id' => $encodedId,
                'user_id' => Auth::id(),
                'featured' => $request->has('is_featured'),
                'published' => $request->has('is_published')
            ]);

            $post->encoded_id = $encodedId;
            return request()->expectsJson()
                ? new PostResource($post)
                : redirect()->route('posts.index')->with('success', 'Trạng thái bài viết đã cập nhật!');
        } catch (\Exception $e) {
            Log::error('Post status update failed', [
                'encoded_id' => $encodedId,
                'error' => $e->getMessage()
            ]);
            return request()->expectsJson()
                ? response()->json(['error' => 'Không thể cập nhật trạng thái.'], 500)
                : back()->with('error', 'Có lỗi xảy ra khi cập nhật trạng thái.');
        }
    }

    public function bulkDelete(Request $request)
    {
        try {
            $this->authorize('delete', Post::class);
            $encodedIds = $request->input('post_ids', []);

            if (empty($encodedIds)) {
                return redirect()->route('posts.index')
                    ->with('error', 'Không có bài viết nào được chọn.');
            }

            // Giải mã và validate tất cả ID
            $postIds = [];
            foreach ($encodedIds as $encodedId) {
                if (!IdEncoder_2::isValid($encodedId)) {
                    throw new \InvalidArgumentException('ID không hợp lệ: ' . $encodedId);
                }
                $postIds[] = IdEncoder_2::decode($encodedId);
            }

            $this->postService->bulkDelete($postIds);

            Log::info('Bulk delete completed', [
                'encoded_ids' => $encodedIds,
                'user_id' => Auth::id()
            ]);

            return request()->expectsJson()
                ? response()->json(['message' => 'Xóa các bài viết thành công'])
                : redirect()->route('posts.index')->with('success', 'Các bài viết đã được xóa thành công.');
        } catch (\Exception $e) {
            Log::error('Bulk deletion failed', [
                'encoded_ids' => $encodedIds ?? [],
                'error' => $e->getMessage()
            ]);
            return request()->expectsJson()
                ? response()->json(['error' => 'Không thể xóa các bài viết.'], 500)
                : back()->with('error', 'Có lỗi xảy ra khi xóa các bài viết.');
        }
    }


    public function copy($encodedId)
    {
        try {
            if (!IdEncoder_2::isValid($encodedId)) {
                throw new \InvalidArgumentException('ID không hợp lệ');
            }

            $id = IdEncoder_2::decode($encodedId);
            $post = Post::findOrFail($id);
            $this->authorize('create', Post::class);
            $newPost = $this->postService->copy($post);
            $newPost->encoded_id = IdEncoder_2::encode($newPost->id);

            Log::info('Post copied', [
                'original_encoded_id' => $encodedId,
                'new_encoded_id' => $newPost->encoded_id,
                'user_id' => Auth::id()
            ]);

            return request()->expectsJson()
                ? new PostResource($newPost)
                : redirect()->route('posts.index')->with('success', 'Bài viết đã được sao chép thành công.');
        } catch (\Exception $e) {
            Log::error('Post copy failed', [
                'encoded_id' => $encodedId,
                'error' => $e->getMessage()
            ]);
            return request()->expectsJson()
                ? response()->json(['error' => 'Không thể sao chép bài viết.'], 500)
                : back()->with('error', 'Có lỗi xảy ra khi sao chép bài viết.');
        }
    }

    public function postsByTag($id)
    {
        // Lấy tag theo ID
        $tag = Tag::findOrFail($id);

        // Lấy tất cả bài viết liên quan đến tag
        $posts = $tag->posts()->latest()->paginate(10); // Hiển thị 10 bài mỗi trang


        $featuredPosts = Post::where('is_featured', true)
            ->whereNotNull('image') // Chỉ lấy bài viết nổi bật có ảnh
            ->where('image', '!=', '') // Kiểm tra thêm nếu image là chuỗi rỗng
            ->latest()
            ->take(6) // Lấy đúng 6 bài nổi bật
            ->get(); // Không phân trang, chỉ lấy các bài viết cần thiết

        // Lấy tất cả các danh mục
        $categories = Category::all();

        $logo = Logo::latest()->first();
        $logoPath = $logo ? $logo->path : 'images/logo.jpg';

        return view('posts.by_tag', compact('tag', 'posts', 'featuredPosts', 'categories', 'logoPath'));
    }



    public function show($id)
    {
        $post = Post::findOrFail($id); // Tìm bài viết theo ID
        return view('posts.show', compact('post')); // Trả về view với dữ liệu bài viết
    }


}

