<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Lấy tất cả các bài viết và người dùng
        $posts = Post::all();
        $users = User::all();

        // Kiểm tra xem có bài viết và người dùng nào không
        if ($posts->isEmpty() || $users->isEmpty()) {
            $this->command->info('Không có bài viết hoặc người dùng nào để tạo bình luận.');
            return;
        }

        // Tạo 10 bình luận ngẫu nhiên
        foreach (range(1, 50) as $index) {
            Comment::create([
                'post_id' => $posts->random()->id, // Lấy ngẫu nhiên bài viết (sử dụng 'id' thay vì 'post_id')
                'user_id' => $users->random()->id, // Lấy ngẫu nhiên người dùng (sử dụng 'id' thay vì 'user_id')
                'content' => $index . 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Repellendus natus assumenda corrupti expedita placeat reprehenderit. Ad praesentium aperiam dolore labore, veniam, reiciendis accusantium nisi beatae ipsum dolor odit temporibus iste?', // Nội dung bình luận
            ]);
        }

        $this->command->info('Đã tạo 100 bình luận mẫu!');
    }
}
