<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\IdEncoder;


class CommentController extends Controller
{

    public function index()
    {
        // Lấy tất cả bài viết có ít nhất một bình luận cùng với số bình luận tương ứng
        $posts = Post::has('comments')->withCount('comments')->paginate(5);

        // Trả về view với danh sách bài viết
        return view('admin.comments.posts_comments', compact('posts'));
    }

    public function search(Request $request)
    {
        $search = $request->input('search'); // Lấy giá trị tìm kiếm

        if ($search) {
            // Nếu có từ khóa tìm kiếm, lọc bài viết theo tiêu đề và nội dung
            $posts = Post::where('title', 'like', '%' . $search . '%')
                ->orWhere('content', 'like', '%' . $search . '%')
                ->withCount('comments') // Đếm số lượng bình luận cho mỗi bài viết
                ->paginate(5);
        } else {
            // Nếu không có tìm kiếm, hiển thị tất cả bài viết
            $posts = Post::withCount('comments')->paginate(5);
        }

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

        // Validation cho nội dung bình luận
        $request->validate([
            'content' => [
                'required',
                'string',
                'max:255',
                'regex:/\S/', // Kiểm tra nội dung không phải là khoảng trắng
            ],
        ]);

        // Kiểm tra nếu có parent_id (bình luận trả lời)
        $parentId = $request->input('parent_id'); // Nếu không có thì sẽ trả về null

        // Tạo bình luận mới
        Comment::create([
            'content' => $request->input('content'),
            'post_id' => $post->id,
            'user_id' => Auth::id(),
            'parent_id' => $parentId, // Lưu lại id của bình luận mẹ nếu có
        ]);

        // Chuyển hướng về trang bài viết với thông báo thành công
        return redirect()->route('posts.post_detail', ['id' => $post->id, 'slug' => $post->slug])
            ->with('success', 'Bình luận đã được thêm thành công!');
    }


    public function delete($comment_id)
    {
        // Giải mã comment_id
        $comment_id = IdEncoder::decode($comment_id);
        // dd($comment_id);

        // Tìm bình luận cần xóa theo comment_id
        $comment = Comment::findOrFail($comment_id);

        // Xóa bình luận
        $comment->delete();

        // Chuyển hướng về trang danh sách bình luận
        return redirect()->back()->with('success', 'Bình luận đã được xóa thành công!');
    }
    public function detail($id)
    {
        // Lấy thông tin bình luận theo ID, cùng với thông tin người dùng
        $comment = Comment::with('user')->findOrFail($id);

        // Trả về view chi tiết bình luận, truyền dữ liệu bình luận vào view
        return view('admin.comments.comment_detail', compact('comment'));
    }
}
