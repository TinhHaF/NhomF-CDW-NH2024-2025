<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB; 
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'name' => 'Thế giới',
                'description' => 'Tin tức thế giới',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Thời sự',
                'description' => 'Tin tức thời sự',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Góc nhìn',
                'description' => 'Các góc nhìn từ chuyên gia',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Thể Thao',
                'description' => 'Các góc nhìn từ chuyên gia',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Siêu ẢO',
                'description' => 'Các góc nhìn từ chuyên gia',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Ca Cao',
                'description' => 'Các góc nhìn từ chuyên gia',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Đôf HỌa',
                'description' => 'Các góc nhìn từ chuyên gia',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Siêu Nhân',
                'description' => 'Các góc nhìn từ chuyên gia',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Góc Cây',
                'description' => 'Các góc nhìn từ chuyên gia',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Góc Hài',
                'description' => 'Các góc nhìn từ chuyên gia',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Hi nhìn',
                'description' => 'Các góc nhìn từ chuyên gia',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Ho nhìn',
                'description' => 'Các góc nhìn từ chuyên gia',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Ho HO',
                'description' => 'Các góc nhìn từ chuyên gia',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Ho LuGia',
                'description' => 'Các góc nhìn từ chuyên gia',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
        
    }
}
