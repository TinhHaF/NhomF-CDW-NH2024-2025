<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\IdEncoder;

class CommentController extends Controller
{
    public function show($slug)
    {
        $post = Post::with(['comments' => function ($query) {
            $query->orderBy('comment_id', 'desc'); // Sắp xếp bình luận theo ID
        }])->findOrFail($slug);

        // Kiểm tra trạng thái đăng nhập
        $isLoggedIn = Auth::check();

        return view('posts.show', compact('post', 'isLoggedIn'));
    }


    public function store(Request $request, Post $post)
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
            'post_id' => $post->id,
            'user_id' => Auth::id(),
        ]);

        // Chuyển hướng về trang bài viết với thông báo thành công
        return redirect()->route('posts.post_detail', ['id' => $post->id, 'slug' => $post->slug])
            ->with('success', 'Bình luận đã được thêm thành công!');
    }
}
