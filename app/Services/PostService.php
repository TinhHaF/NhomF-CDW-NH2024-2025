<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class PostService
{
    public function create(array $data, $image = null)
    {
        try {
            $imageUrl = null;

            if ($image && $image instanceof UploadedFile) {
                // Nếu $image là một đối tượng UploadedFile, tiến hành lưu ảnh
                $imageUrl = $image->store('posts', 'public');
            } elseif (is_string($image)) {
                // Nếu $image là chuỗi, có thể đây là một đường dẫn tệp đã có sẵn, bạn có thể xử lý theo cách khác nếu cần
                $imageUrl = $image; // Đặt lại giá trị $imageUrl nếu cần
            }

            return Post::create([
                'title' => $data['title'],
                'slug' => $data['slug'],
                'content' => $data['content'],
                'category_id' => $data['category_id'],
                'author_id' => $data['author_id'],
                'seo_title' => $data['seo_title'],
                'seo_description' => $data['seo_description'],
                'seo_keywords' => $data['seo_keywords'],
                'image' => $imageUrl,
                'is_featured' => $data['is_featured'] ?? false,
                'is_published' => $data['is_published'] ?? false,
            ]);
            if (isset($data['tags'])) {
                $post->tags()->sync($data['tags']);
            }
        } catch (\Exception $e) {
            Log::error('Error creating post: ' . $e->getMessage());
            throw $e;
        }
    }

    public function update(Post $post, array $data, ?UploadedFile $image = null): Post
    {
        return DB::transaction(function () use ($post, $data, $image) {
            $post->update([
                'title' => $data['title'],
                'slug' => Str::slug($data['slug']),
                'content' => $data['content'],
                'category_id' => $data['category_id'],
                'author_id' => $data['author_id'],
                'seo_title' => $data['seo_title'],
                'seo_description' => $data['seo_description'],
                'seo_keywords' => $data['seo_keywords'],
            ]);

            if ($image) {
                // Delete old image
                // if ($post->image) {
                //     Storage::delete('public/' . $post->image);
                // }
                // $path = $image->store('posts', 'public');
                // $post->update(['image' => $path]);
                if ($post->image) {
                    Storage::disk('public')->delete($post->image);
                }
                $data['image'] = $image->store('posts', 'public');  
            }
            $post->update($data);

            if (isset($data['tags'])) {
                $post->tags()->sync($data['tags']);
            }

            return $post;
        });
    }

    public function delete(Post $post): bool
    {
        return DB::transaction(function () use ($post) {
            if ($post->image) {
                Storage::delete('public/' . $post->image);
            }
            return $post->delete();
        });
    }

    public function bulkDelete(array $ids): void
    {
        DB::transaction(function () use ($ids) {
            $posts = Post::whereIn('id', $ids)->get();
            foreach ($posts as $post) {
                if ($post->image) {
                    Storage::delete('public/' . $post->image);
                }
                $post->delete();
            }
        });
    }

    public function copy(Post $post): Post
    {
        return DB::transaction(function () use ($post) {
            $newPost = $post->replicate();
            // Xóa ký tự số trong tiêu đề để tạo một tiêu đề mới
            $baseTitle = preg_replace('/\s*\(\d+\)\s*$/', '', $post->title);
            // Đếm số lần tiêu đề đã tồn tại để tạo tiêu đề mới không bị trùng
            $count = post::where('title', 'LIKE', $baseTitle . ' (%)')->orWhere('title', $baseTitle)->count();
            // Cập nhật tiêu đề mới
            $newPost->title = $baseTitle . ' (' . ($count + 1) . ')';
            // Tạo slug từ tiêu đề mới
            $newPost->slug = Str::slug($newPost->title); // Tạo slug mới từ tiêu đề mới
            $newPost->image = null; // Đặt hình ảnh là null hoặc giữ lại theo yêu cầu
            $newPost->save();

            return $newPost;
        });
    }
}
