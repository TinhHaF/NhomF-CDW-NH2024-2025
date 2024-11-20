<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable; // Thêm dòng này

class Subscriber extends Model
{
    use HasFactory, Notifiable; // Thêm Notifiable vào đây

    protected $fillable = ['email'];
}
