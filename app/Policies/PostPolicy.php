<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    /**
     * Determine whether the user can view any posts.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->role === '2'||$user->role === '3'; // Chỉ admin mới có thể xem tất cả các bài viết
    }

    /**
     * Determine whether the user can view the post.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Post  $post
     * @return mixed
     */
    // public function view(User $user, Post $post)
    // {
    //     return $user->role === '2' || $user->id === $post->user_id || $user->role === '1'; // Admin hoặc chủ sở hữu bài viết có thể xem
    // }


    public function view(User $user, Post $post)
    {
        return true; // Chấp nhận mọi người đều có quyền xem bài viết
    }


    /**
     * Determine whether the user can create posts.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->role === '2' || $user->role === '3'; // Admin hoặc editor có thể tạo bài viết
    }

    /**
     * Determine whether the user can update the post.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Post  $post
     * @return mixed
     */
    public function update(User $user, Post $post)
    {
        return $user->role === '2' || $user->id === $post->user_id; // Admin hoặc chủ sở hữu bài viết có thể cập nhật
    }

    /**
     * Determine whether the user can delete the post.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Post  $post
     * @return mixed
     */
    public function delete(User $user)
    {
        return $user->role === '2'; // Chỉ admin mới có thể xóa bài viết
    }
}
