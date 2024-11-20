<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Faker\Factory as Faker;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $posts = [];

        // Vòng lặp để tạo 10 bài ngẫu nhiên
        for ($i = 0; $i < 100; $i++) {
            $posts[] = [
                'author_id' => $faker->numberBetween(1, 3), // Giả sử có 3 tác giả
                'title' => $faker->sentence(6), // Tạo tiêu đề ngẫu nhiên
                'slug' => $faker->slug, // Tạo slug từ tiêu đề
                'content' => $faker->paragraphs(3, true), // Tạo nội dung ngẫu nhiên
                'view' => $faker->numberBetween(50, 500), // Số lượt xem ngẫu nhiên
                'image' => 'nro' . $faker->numberBetween(1, 3) . '.jpg', // Chọn ngẫu nhiên từ 3 hình ảnh
                'is_featured' => $faker->boolean(30), // 30% bài được đánh dấu nổi bật
                'is_published' => 1, // Mặc định xuất bản
                'seo_title' => $faker->sentence(4), // Tạo tiêu đề SEO ngẫu nhiên
                'seo_description' => $faker->sentence(10), // Mô tả SEO
                'seo_keywords' => implode(', ', $faker->words(5)), // Từ khóa SEO
                'category_id' => $faker->numberBetween(1, 5), // Giả sử có 5 danh mục
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        // Chèn dữ liệu vào bảng posts
        DB::table('posts')->insert($posts);

        // Hiển thị thông báo khi chạy lệnh db:seed
        $this->command->info('Đã tạo 100 bài viết ngẫu nhiên thành công!');
    }
}
