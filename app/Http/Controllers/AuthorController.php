<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Author;
use Vinkla\Hashids\Facades\Hashids;

class AuthorController extends Controller
{
    public function index()
    {
        $authors = Author::all();
        return response()->json($authors); // Trả về danh sách tác giả
    }
    /**
     * Hiển thị thông tin chi tiết tác giả.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */

     public function show($encodedAuthorId)
     {
         // Giải mã ID từ URL
         $authorId = Hashids::decode($encodedAuthorId)[0] ?? null;
         if (!$authorId) {
             abort(404, 'Tác giả không tồn tại.');
         }
     
         // Lấy thông tin tác giả từ cơ sở dữ liệu
         $author = Author::findOrFail($authorId);
     
         // Đặt đường dẫn logo của tác giả
         $logoPath = $author->image ? 'storage/authors/' . $author->image : 'default-avatar.jpg';
     
         // Lấy danh sách bài viết của tác giả và phân trang
         $posts = $author->posts()->paginate(5);
     
         // Truyền dữ liệu vào view
         return view('authors.show', compact('author', 'logoPath', 'posts'));
     }
     


    // AuthorController.php
    public function follow($encodedAuthorId)
{
    // Giải mã ID tác giả
    $authorId = Hashids::decode($encodedAuthorId)[0] ?? null;
    if (!$authorId) {
        abort(404, 'Tác giả không tồn tại.');
    }

    $author = Author::findOrFail($authorId);
    auth()->user()->follow($author);

    return redirect()->back()->with('status', 'Đăng ký theo dõi tác giả thành công!');
}

public function unfollow($encodedAuthorId)
{
    // Giải mã ID tác giả
    $authorId = Hashids::decode($encodedAuthorId)[0] ?? null;
    if (!$authorId) {
        abort(404, 'Tác giả không tồn tại.');
    }

    $author = Author::findOrFail($authorId);
    auth()->user()->unfollow($author);

    return redirect()->back()->with('status', 'Hủy theo dõi tác giả thành công!');
}

}
