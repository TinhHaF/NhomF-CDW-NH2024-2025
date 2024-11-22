<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    
    protected $dates = ['published_date'];  // Đảm bảo thuộc tính là đối tượng Carbon

    use HasFactory;

    protected $fillable = [
        'user_id',
        'pen_name',
        'biography',
        'image',
        'published_date',
    ];
    // public function followers(): HasMany
    // {
    //     return $this->hasMany(AuthorFollower::class, 'author_id');
    // }
    public function followers()
    {
        return $this->belongsToMany(User::class, 'author_followers', 'author_id', 'user_id');
    }
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
   


}
