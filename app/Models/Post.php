<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

// use Laravel\Scout\Searchable;


class Post extends Model
{

    // use Searchable;
    use HasFactory;
    protected $fillable = [
        'title',
        'content',
        'image',
        'is_featured',
        'is_published',
        'author_id',
        'category_id',
        'slug',
        'seo_title',
        'seo_description',
        'seo_keywords'
    ];

    // public function toSearchableArray()
    // {
    //     $array = $this->toArray();

    //     return [
    //         'id' => $array['id'],
    //         'title' => $array['title'],
    //         'content' => $array['content'],
    //         'author_name' => $this->author ? $this->author->pen_name : null,
    //     ];
    // }

    // Method to handle search functionality
    public static function search($query)
    {
        return self::when($query, function ($queryBuilder) use ($query) {
            $queryBuilder->whereRaw("MATCH(title, content) AGAINST(? IN BOOLEAN MODE)", [$query])
                ->orWhere('content', 'LIKE', "%{$query}%")
                ->orWhere('title', 'LIKE', "%{$query}%");
        })->orderBy('created_at', 'desc')->paginate(10);
    }

    // Method to handle image storage
    public function storeImage($image)
    {
        if ($image) {
            $imagePath = $image->store('posts', 'public');
            $this->image = $imagePath;
            $this->save();
        }
    }

    // Method to handle image deletion
    public function deleteImage()
    {
        if ($this->image) {
            Storage::disk('public')->delete($this->image);
        }
    }

    // Method to handle status updates
    public function updateStatus($isFeatured, $isPublished)
    {
        $this->is_featured = $isFeatured ? 1 : 0;
        $this->is_published = $isPublished ? 1 : 0;
        $this->save();
    }

    // Method for bulk deletion
    public static function bulkDelete($postIds)
    {
        self::whereIn('id', $postIds)->each(function ($post) {
            $post->deleteImage();
            $post->delete();
        });
    }

    // Method for copying a post
    public function copy()
    {
        $newPost = $this->replicate();

        // Xóa ký tự số trong tiêu đề để tạo một tiêu đề mới
        $baseTitle = preg_replace('/\s*\(\d+\)\s*$/', '', $this->title);

        // Đếm số lần tiêu đề đã tồn tại để tạo tiêu đề mới không bị trùng
        $count = self::where('title', 'LIKE', $baseTitle . ' (%)')->orWhere('title', $baseTitle)->count();

        // Cập nhật tiêu đề mới
        $newPost->title = $baseTitle . ' (' . ($count + 1) . ')';

        // Tạo slug từ tiêu đề mới
        $newPost->slug = Str::slug($newPost->title); // Tạo slug mới từ tiêu đề mới

        $newPost->image = null; // Đặt hình ảnh là null hoặc giữ lại theo yêu cầu
        $newPost->save();

        return $newPost;
    }
}
