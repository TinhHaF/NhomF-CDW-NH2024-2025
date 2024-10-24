<?php

namespace App\Http\Controllers;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Models\Author;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;


class PostController extends Controller
{
    // Phương thức tĩnh để mã hóa ID
    public static function encodeId($id)
    {
        $key = 'your-secret-key'; // Thay thế bằng khóa bí mật của bạn
        return base64_encode($id . '::' . $key);
    }

    public function homepage()
    {
        $posts = Post::latest()->paginate(6);
        $featuredPosts = Post::where('is_featured', 1)->latest()->paginate(6);
        return view('home', compact('posts', 'featuredPosts')); 
    }

    //chi tiet blog
    public function show($encodedId)
    {
        // Giải mã ID
        $decoded = base64_decode($encodedId);
        list($id, $key) = explode('::', $decoded);

        // Kiểm tra xem khóa có khớp để ngăn chặn việc giả mạo
        if ($key !== 'your-secret-key') {
            abort(403, 'Lỏ');
        }

        $post = Post::findOrFail($id);
        return view('posts.show', compact('post'));
    }

    public function showAdmin($id)
    {
        // Find the post by ID
        $post = Post::findOrFail($id);
        return view('admin.posts.show', compact('post'));
    }

    // Hiển thị danh sách tin tức
    public function index(Request $request)
    {
        $query = $request->input('search');

        // Tìm nạp các bài đăng có chức năng tìm kiếm và sắp xếp theo ngày tạo (mới nhất trước)
        $posts = Post::when($query, function ($queryBuilder) use ($query) {
            $queryBuilder->where('title', 'like', "%{$query}%")
                ->orWhere('content', 'like', "%{$query}%"); // Bao gồm các trường khác nếu cần thiết
        })->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.posts.index', compact('posts'));
    }


    // Hiển thị form thêm mới tin tức
    public function create()
    {
        $categories = Category::all(); // Lấy danh sách danh mục
        $authors = Author::all(); // Lấy danh sách tác giả

        return view('admin.posts.create', compact('categories', 'authors'));
    }

    // Lưu tin tức mới
    public function store(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $post = new Post();
        $post->title = $request->input('title');
        $post->content = $request->input('content');
        $post->is_featured = $request->has('is_featured') ? 1 : 0; // Kiểm tra trạng thái của checkbox
        $post->is_published = $request->has('is_published') ? 1 : 0; // Tương tự cho is_published

        // Lưu ảnh nếu có, vào thư mục public
        if ($request->hasFile('image')) {
            // Lưu ảnh vào thư mục public/posts
            $imagePath = $request->file('image')->store('posts', 'public');
            $post->image = $imagePath;
        }

        // Lưu thông tin tác giả từ form
        $post->author_id = $request->input('author_id');

        $post->save();

        return redirect()->route('posts.index')->with('success', 'Bài viết đã được thêm thành công!');
    }
    // Hiển thị form chỉnh sửa tin tức
    public function edit($id)
    {
        $post = Post::findOrFail($id);

        $categories = Category::all();
        $authors = Author::all();

        // Return the edit view with the post, categories, and authors
        return view('admin.posts.edit', compact('post', 'categories', 'authors'));
    }


    // Cập nhật tin tức
    public function update(Request $request, $id)
    {
        // Kiểm tra tính hợp lệ của dữ liệu đầu vào
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'author_id' => 'required|exists:authors,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Nếu có hình ảnh, kiểm tra định dạng và kích thước
        ]);

        $post = Post::findOrFail($id);
        $post->title = $validatedData['title'];
        $post->content = $validatedData['content'];
        $post->category_id = $validatedData['category_id'];
        $post->author_id = $validatedData['author_id'];

        // Xử lý hình ảnh nếu có
        if ($request->hasFile('image')) {
            // Xóa hình ảnh cũ nếu cần thiết
            if ($post->image) {
                Storage::delete($post->image);
            }

            $path = $request->file('image')->store('images/posts');
            $post->image = $path;
        }
        $post->save();
        return redirect()->route('posts.index')->with('success', 'Cập nhật bài viết thành công.');
    }




    // Xóa tin tức
    public function destroy($id)
    {
        $post = Post::find($id);

        // Delete the image from storage
        if ($post && $post->image) {
            Storage::disk('public')->delete($post->image);
        }

        // Delete the post
        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Bài viết đã được xóa thành công!');
    }
    public function updateStatus(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        // Cập nhật trạng thái dựa trên dữ liệu gửi từ form
        if ($request->has('is_featured')) {
            $post->is_featured = 1; // Nếu checkbox được check
        } else {
            $post->is_featured = 0; // Nếu không check
        }

        if ($request->has('is_published')) {
            $post->is_published = 1; // Nếu checkbox được check
        } else {
            $post->is_published = 0; // Nếu không check
        }

        $post->save();

        return redirect()->route('posts.index')->with('success', 'Trạng thái bài viết đã được cập nhật!');
    }

    public function bulkDelete(Request $request)
    {
        $postIds = $request->input('post_ids');
        if ($postIds) {
            Post::whereIn('id', $postIds)->delete();
            return redirect()->route('posts.index')->with('success', 'Các bài viết đã được xóa thành công.');
        } else {
            return redirect()->route('posts.index')->with('error', 'Không có bài viết nào được chọn.');
        }
    }

    public function copy($id)
    {
        $originalPost = Post::findOrFail($id);

        $newPost = $originalPost->replicate();
        $newPost->title = $originalPost->title . ' (Sao chép)';
        $newPost->save();

        return redirect()->route('posts.index')->with('success', 'Bài viết đã được sao chép thành công!');
    }
}
