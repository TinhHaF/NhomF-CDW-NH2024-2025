<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Models\Author;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
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
            abort(403, 'Không có quyền truy cập.');
        }

        // Lấy bài viết cùng với các bình luận và thông tin người dùng
        $post = Post::with('comments.user')->findOrFail($id);

        // Kiểm tra trạng thái đăng nhập
        $isLoggedIn = Auth::check();

        return view('posts.show', compact('post', 'isLoggedIn'));
    }
}
