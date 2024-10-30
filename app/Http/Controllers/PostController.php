<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Models\Author;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;


class PostController extends Controller
{
    public static function encodeId($id)
    {
        $key = 'your-secret-key'; // Thay thế bằng khóa bí mật của bạn
        return base64_encode($id . '::' . $key);
    }

    public function homepage()
    {
        $posts = Post::latest()->paginate(6);
        return view('home.home', compact('posts'));
    }

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
    public function index(Request $request)
    {
        $query = $request->input('search');
        $posts = Post::search($query);
        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        $categories = Category::all();
        $authors = Author::all();
        return view('admin.posts.create', compact('categories', 'authors'));
    }

    public function store(Request $request)
    {
        // Kiểm tra dữ liệu đầu vào
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'seo_title' => 'required|string|max:255',
            'seo_description' => 'required|string',
            'seo_keywords' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Tạo slug từ tiêu đề
        $slug = Str::slug($request->title);
        $originalSlug = $slug; // Lưu slug gốc để kiểm tra trùng lặp
        $count = 1; // Biến đếm để thêm vào slug nếu cần

        // Kiểm tra xem slug có bị trùng lặp trong cơ sở dữ liệu không
        while (Post::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count; // Thêm số vào slug
            $count++; // Tăng biến đếm
        }

        // Tạo bài viết với slug duy nhất
        $post = Post::create($request->only('title', 'content', 'author_id', 'seo_title', 'seo_description', 'seo_keywords') + [
            'slug' => $slug, // Thêm slug duy nhất vào bài viết
            'is_featured' => $request->has('is_featured') ? 1 : 0,
            'is_published' => $request->has('is_published') ? 1 : 0,
        ]);

        // Lưu hình ảnh nếu có
        $post->storeImage($request->file('image'));

        // Hiển thị thông báo nếu có slug mới được tạo
        if ($count > 1) {
            return redirect()->route('posts.create')
                ->with('warning', 'Tiêu đề đã tồn tại, một slug mới đã được tạo: ' . $slug);
        }

        // Chuyển hướng về trang danh sách bài viết và hiển thị thông báo thành công
        return redirect()->route('posts.index')->with('success', 'Bài viết đã được thêm thành công!');
    }


    // public function show($id)
    // {
    //     $post = Post::findOrFail($id);
    //     return view('admin.posts.show', compact('post'));
    // }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $categories = Category::all();
        $authors = Author::all();
        return view('admin.posts.edit', compact('post', 'categories', 'authors'));
    }

    public function update(Request $request, Post $post)
    {
        // Xác thực dữ liệu đầu vào với các quy tắc và thông báo lỗi tùy chỉnh

        // Cập nhật các trường của bài viết
        $post->title = $request->input('title');
        $post->slug = $request->input('slug');
        $post->content = $request->input('content');
        $post->category_id = $request->input('category_id');
        $post->author_id = $request->input('author_id');
        $post->seo_title = $request->input('seo_title');
        $post->seo_description = $request->input('seo_description');
        $post->seo_keywords = $request->input('seo_keywords');

        // Kiểm tra và xử lý hình ảnh
        if ($request->hasFile('image')) {
            // Xóa ảnh cũ nếu có
            if ($post->image) {
                Storage::delete('public/' . $post->image);
            }

            // Lưu ảnh mới
            $path = $request->file('image')->store('images', 'public');
            $post->image = $path;
        }

        // Lưu thay đổi vào cơ sở dữ liệu
        $post->save();

        // Chuyển hướng sau khi cập nhật thành công
        return redirect()->route('posts.index')->with('success', 'Cập nhật bài viết thành công!');
    }



    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->deleteImage();
        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Bài viết đã được xóa thành công!');
    }

    public function updateStatus(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        $post->updateStatus($request->has('is_featured'), $request->has('is_published'));
        return redirect()->route('posts.index')->with('success', 'Trạng thái bài viết đã cập nhật!');
    }

    public function bulkDelete(Request $request)
    {
        $postIds = $request->input('post_ids');

        if (empty($postIds)) {
            return redirect()->route('posts.index')->with('error', 'Không có bài viết nào được chọn.');
        }

        Post::bulkDelete($postIds);
        return redirect()->route('posts.index')->with('success', 'Các bài viết đã được xóa thành công.');
    }

    public function copy($id)
    {
        $post = Post::findOrFail($id)->copy();
        return redirect()->route('posts.index')->with('success', 'Bài viết đã được sao chép thành công.');
    }
}
