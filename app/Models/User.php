<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'image',
        'role',
        'facebook_id',
        'google_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Thiết lập quan hệ với model Comment.
     * Một người dùng có thể có nhiều bình luận.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    /**
     * Kiểm tra nếu người dùng là admin.
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->role === '2';
    }
    public function isAuthor(): bool
    {
        return $this->role === '3';
    }
    public function isUser(): bool
    {
        return $this->role === '1';
    }


    protected $appends = ['avatar_url'];

    public function posts()
    {
        return $this->hasMany(Post::class, 'author_id');
    }

    public function getAvatarUrlAttribute()
    {
        if ($this->avatar) {
            return Storage::url($this->avatar);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name);
    }
    public function follow(Author $author)
    {
        return $this->authorFollowers()->attach($author);
    }

    public function unfollow(Author $author)
    {
        return $this->authorFollowers()->detach($author);
    }

    public function authorFollowers()
    {
        return $this->belongsToMany(Author::class, 'author_followers');
    }

    public function isFollowing(Author $author)
    {
        return $this->authorFollowers()->where('author_id', $author->id)->exists();
    }
    public function savedByUsers()
    {
        return $this->belongsToMany(User::class, 'saved_posts')->withTimestamps();
    }
}
