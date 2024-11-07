<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Laravel mặc định sẽ sử dụng 'id' là khóa chính, bạn không cần khai báo nếu không thay đổi
    // Nếu muốn chỉ rõ, bạn có thể dùng
    // protected $primaryKey = 'id';

    protected $fillable = ['name', 'description'];

    // Quan hệ với bảng posts
    public function posts()
    {
        return $this->hasMany(Post::class, 'category_id');
    }
}
