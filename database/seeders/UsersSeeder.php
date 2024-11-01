<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'username' => 'user1',
                'email' => 'user1@example.com',
                'password' => Hash::make('password'),
                'image' => 'user1.jpg',
                'role' => 1, // 1 là user
            ],
            [
                'username' => 'admin1',
                'email' => 'admin1@example.com',
                'password' => Hash::make('password'),
                'image' => 'admin1.jpg',
                'role' => 2, // 2 là admin
            ],
            [
                'username' => 'author1',
                'email' => 'author1@example.com',
                'password' => Hash::make('password'),
                'image' => 'author1.jpg',
                'role' => 3, // 3 là author
            ],
        ]);
    }
}
