<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB; 
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('posts')->insert([
            [
                'author_id' => 1,
                'category_id' => 1,
                'title' => 'Tin tức thế giới',
                'content' => 'abc',
                'image' => 'nro1.jpg',
                'view' => 1,
            ],
            [
                'author_id' => 1,
                'category_id' => 1,
                'title' => 'Tin tức thế giới',
                'content' => 'abc',
                'image' => 'nro2.jpg',
                'view' => 1,
            ],
            [
                'author_id' => 1,
                'category_id' => 1,
                'title' => 'Tin tức thế giới',
                'content' => 'abc',
                'image' => 'nro2.jpg',
                'view' => 1,
            ],
           
        ]);
    }
}
