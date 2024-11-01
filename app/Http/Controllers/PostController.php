<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Models\Author;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Helpers\IdEncoder;

use Illuminate\Validation\Rule;



class PostController extends Controller
{
    public static function encodeId($id)
    {
        return IdEncoder::encode($id);
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
        $id = IdEncoder::decode($encodedId);

        // Lấy bài viết cùng với các bình luận và thông tin người dùng
        $post = Post::with('comments.user')->findOrFail($id);

        // Kiểm tra trạng thái đăng nhập
        $isLoggedIn = Auth::check();

        return view('posts.post_detail', compact('post', 'isLoggedIn'));
    }

  

    // public function index(Request $request)
    // {
    //     $query = $request->input('search');
    //     $posts = Post::search($query);
    //     return view('admin.posts.index', compact('posts'));
    // }
    public function index(Request $request)
    {
        $query = $request->input('search');
        $posts = Post::search($query);
    
        $encodeId = function($id) {
            return IdEncoder::encode($id);
        };
    
        return view('admin.posts.index', compact('posts', 'encodeId'));
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

        // Kiểm tra xem tiêu đề đã tồn tại trong cơ sở dữ liệu chưa
        if (Post::where('title', $request->title)->exists()) {
            return redirect()->route('posts.create')->with(['warning' => 'Tiêu đề đã tồn tại. Vui lòng sửa tiêu đề khác.'])->withInput();
        }

        // Tạo slug từ tiêu đề
        $slug = Str::slug($request->title);

        // Tạo bài viết với slug duy nhất
        $post = Post::create($request->only('title', 'content', 'author_id', 'seo_title', 'seo_description', 'seo_keywords') + [
            'slug' => $slug,
            'is_featured' => $request->has('is_featured') ? 1 : 0,
            'is_published' => $request->has('is_published') ? 1 : 0,
        ]);

        // Lưu hình ảnh nếu có
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public'); // Lưu ảnh trong thư mục 'public/images'
            $post->image = $path; // Cập nhật đường dẫn ảnh cho bài viết
            $post->save(); // Lưu bài viết
        }

        // Chuyển hướng về trang danh sách bài viết và hiển thị thông báo thành công
        return redirect()->route('posts.index')->with('success', 'Bài viết đã được thêm thành công!');
    }




   

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $categories = Category::all();
        $authors = Author::all();
        return view('admin.posts.edit', compact('post', 'categories', 'authors'));
    }

    public function update(Request $request, Post $post)
    {
        // Xác thực dữ liệu đầu vào
        // $request->validate([
        //     'title' => 'required|string|max:255',
        //     'content' => 'required|string',
        //     'seo_title' => 'required|string|max:255',
        //     'seo_description' => 'required|string',
        //     'seo_keywords' => 'required|string|max:255',
        //     'category_id' => 'required|integer',
        //     'author_id' => 'required|integer',
        //     'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        // ]);

        // Kiểm tra xem tiêu đề mới đã tồn tại trong cơ sở dữ liệu chưa
        if (Post::where('title', $request->input('title'))->where('id', '!=', $post->id)->exists()) {
            return redirect()->back()->with(['warning' => 'Tiêu đề đã tồn tại. Vui lòng sửa tiêu đề khác.'])->withInput();
        }

        // Cập nhật các trường của bài viết
        $post->title = $request->input('title');
        $post->slug = Str::slug($request->input('title')); // Cập nhật slug mới từ tiêu đề
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
