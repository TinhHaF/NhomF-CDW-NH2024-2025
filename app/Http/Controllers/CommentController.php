<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    // Thêm phương thức encodeId trực tiếp vào CommentController
    public static function encodeId($id)
    {
        $key = 'your-secret-key';
        return base64_encode($id . '::' . $key);
    }

    public function store(Request $request, $postId)
    {
        // Kiểm tra đăng nhập
        if (!Auth::check()) {
            // Trả về thông báo yêu cầu đăng nhập mà không chuyển hướng
            return redirect()->back()->with('error', 'Bạn cần đăng nhập để bình luận.');
        }

        // Xác thực dữ liệu đầu vào
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        // Mã hóa ID của bài viết
        $encodedPostId = self::encodeId($postId);

        // Tạo bình luận mới
        Comment::create([
            'content' => $request->input('content'),
            'post_id' => $postId,
            'user_id' => Auth::id(),
        ]);

        // Chuyển hướng về trang bài viết với thông báo thành công
        return redirect()->route('posts.show', $encodedPostId)->with('success', 'Bình luận đã được thêm thành công!');
    }
}
