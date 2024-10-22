<?php

namespace App\Http\Controllers;

use App\Models\Post;

use Illuminate\Http\Request;

class PostController extends Controller
{
    public function homepage()
    {
         // Lấy các bài viết từ bảng posts, sắp xếp theo thời gian tạo, phân trang với 6 bài mỗi trang
         $posts = Post::latest()->paginate(3); // Lấy 6 bài viết mới nhất
         return view('home.home', compact('posts')); // Trả về view với danh sách bài viết
    }
}
