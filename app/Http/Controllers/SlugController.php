<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class SlugController extends Controller
{
    public function checkSlug(Request $request)
    {
        $slug = $request->query('slug'); // Lấy slug từ query string

        // Kiểm tra xem slug đã tồn tại trong bảng `posts` chưa
        $exists = Post::where('slug', $slug)->exists();

        // Trả về JSON thông báo có tồn tại hay không
        return response()->json(['exists' => $exists]);
    }
}
