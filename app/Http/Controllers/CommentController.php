<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CommentController extends Controller
{

    public function index()
    {
        // Lấy tất cả bài viết có ít nhất một bình luận cùng với số bình luận tương ứng
        $posts = Post::has('comments')->withCount('comments')->paginate(5);

        // Trả về view với danh sách bài viết
        return view('admin.comments.posts_comments', compact('posts'));
    }
    public function Comments($id)
    {
        // Lấy bài viết và tất cả các bình luận kèm theo thông tin người dùng
        $post = Post::findOrFail($id);

        // Lấy tất cả các bình luận kèm theo thông tin người dùng
        $comments = $post->comments()->with('user')->paginate(5);

        // Trả về view với danh sách bình luận
        return view('admin.comments.comments_index', compact('post', 'comments'));
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
