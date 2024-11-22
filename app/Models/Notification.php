<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'title',
        'read',
        'user_id',
        'post_id',
    ];
    public function post()
    {
        return $this->belongsTo(Post::class); // Quan hệ giữa notification và post qua post_id
    }
}

