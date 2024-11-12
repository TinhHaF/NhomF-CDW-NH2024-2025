<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\IdEncoder;

class Comment extends Model
{
    use HasFactory;

    // Các thuộc tính có thể được gán hàng loạt
    protected $fillable = ['post_id', 'user_id', 'parent_id', 'content'];

    // Chỉ định khóa chính
    protected $primaryKey = 'comment_id';
    public $incrementing = true; // Xác định khóa chính tăng tự động
    protected $keyType = 'int';  // Loại dữ liệu của khóa chính

    /**
     * Thiết lập quan hệ với model Post.
     * Mỗi comment thuộc về một bài viết.
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * Quan hệ replies - trả về các phản hồi cho comment
     */
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id')->with('replies');
    }


    /**
     * Quan hệ với comment cha
     */
    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    /**
     * Thiết lập quan hệ với model User.
     * Mỗi comment được đăng bởi một người dùng.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Mã hóa ID bình luận
     */
    public function getEncodedCommentIdAttribute()
    {
        return IdEncoder::encode($this->comment_id);
    }
}
