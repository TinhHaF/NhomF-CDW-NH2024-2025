<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;
    protected $fillable =
    [
        'title',
        'content',
        'image',
        'is_featured',
        'view',
        'category_id',
        'is_published',
        'author_id'
    ];

    public function getEncodedIdAttribute()
    {
        return \App\Http\Controllers\PostController::encodeId($this->id);
    }

     /**
     * Thiết lập quan hệ với model Comment.
     * Một bài viết có thể có nhiều bình luận.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
