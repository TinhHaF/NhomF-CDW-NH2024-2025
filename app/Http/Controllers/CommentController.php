<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\IdEncoder;

class CommentController extends Controller
{
    public function show($encodedId)
    {
        // Giải mã ID
        $id = IdEncoder::decode($encodedId);

        // Lấy bài viết cùng với các bình luận và sắp xếp bình luận theo ID mới nhất lên trên
        $post = Post::with(['comments' => function ($query) {
            $query->orderBy('comment_id', 'desc'); // Sắp xếp bình luận theo ID
        }])->findOrFail($id);

        // Kiểm tra trạng thái đăng nhập
        $isLoggedIn = Auth::check();

        return view('posts.show', compact('post', 'isLoggedIn'));
    }


    public function store(Request $request, $postId)
    {
        // Kiểm tra đăng nhập
        if (!Auth::check()) {
            return redirect()->back()->with('error', 'Bạn cần đăng nhập để bình luận.');
        }

        // Xác thực dữ liệu đầu vào
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        // Tạo bình luận mới
        Comment::create([
            'content' => $request->input('content'),
            'post_id' => $postId,
            'user_id' => Auth::id(),
        ]);

        // Mã hóa ID của bài viết
        $encodedPostId = IdEncoder::encode($postId); // Sử dụng hàm encode từ IdEncoder

        // Chuyển hướng về trang bài viết với thông báo thành công
        return redirect()->route('posts.show', $encodedPostId)->with('success', 'Bình luận đã được thêm thành công!');
    }
}
