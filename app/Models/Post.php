<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    // Các cột có thể được lưu trữ hàng loạt
    protected $fillable = [
        'title',
        'content',
        'author_id',
        'image',
    ];
}
