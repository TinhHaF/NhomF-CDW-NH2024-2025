<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    // Đặt tên bảng mà Laravel sử dụng
    protected $table = 'password_resets';
    // Tắt timestamp nếu không có trường created_at, updated_at
    public $timestamps = false;

    // Các trường có thể gán đại trà (mass assignment)
    protected $fillable = ['email', 'token', 'created_at'];
}

