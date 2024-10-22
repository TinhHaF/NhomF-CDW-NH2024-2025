<?php

namespace App\Http\Controllers;

use App\Models\Post;

use Illuminate\Http\Request;

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
        $posts = Post::latest()->paginate(3);
        return view('home', compact('posts'));
    }

    public function show($encodedId)
    {
        // Giải mã ID
        $decoded = base64_decode($encodedId);
        list($id, $key) = explode('::', $decoded);

        // Kiểm tra xem khóa có khớp để ngăn chặn việc giả mạo
        if ($key !== 'your-secret-key') {
            abort(403, 'Hành động không được phép.');
        }

        $post = Post::findOrFail($id);
        return view('posts.show', compact('post'));
    }
}
