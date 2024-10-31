<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    // Các thuộc tính có thể được gán hàng loạt
    protected $fillable = ['post_id', 'user_id', 'content'];

    /**
     * Thiết lập quan hệ với model Post.
     * Mỗi comment thuộc về một bài viết.
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * Thiết lập quan hệ với model User.
     * Mỗi comment được đăng bởi một người dùng.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
