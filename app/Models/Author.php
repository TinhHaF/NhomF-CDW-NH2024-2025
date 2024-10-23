<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{

    use HasFactory;

    protected $fillable = [
        'user_id',
        'pen_name',
        'biography',
        'image',
        'published_date',
    ];
}
