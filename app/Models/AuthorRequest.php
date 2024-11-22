<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuthorRequest extends Model
{
    use HasFactory;

    // Đặt tên bảng nếu không theo chuẩn Laravel (nếu tên bảng không phải 'author_requests')
    protected $table = 'author_requests';

    // Các cột có thể mass-assigned
    protected $fillable = [
        'user_id',
        'pen_name',
        'biography',
        'status',
    ];

    // Định nghĩa quan hệ với bảng 'users'
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}