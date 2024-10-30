<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AuthorSeeder extends Seeder
{
    public function run()
    {
        DB::table('authors')->insert([
            [
                'user_id' => 1, 
                'pen_name' => 'Hà Quốc Tính',
                'biography' => 'Hà Quốc Tính là một tác giả nổi tiếng trong lĩnh vực văn học.',
                'published_date' => now(), 
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'pen_name' => 'Huỳnh Nguyễn Ngọc Trân',
                'biography' => 'Huỳnh Nguyễn Ngọc Trân chuyên viết về văn học trẻ.',
                'published_date' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 3,
                'pen_name' => 'Hà Văn Phương',
                'biography' => 'Hà Văn Phương là một tác giả nổi bật trong lĩnh vực khoa học.',
                'published_date' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
