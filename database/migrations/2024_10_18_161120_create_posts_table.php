<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id(); // Cột id tự động tăng
            $table->foreignId('author_id')->nullable(); // Khóa ngoại cho tác giả
            $table->foreignId('category_id')->nullable();// Khóa ngoại cho danh mục
            $table->string('title'); // Tiêu đề bài viết
            $table->text('content'); // Nội dung bài viết
            $table->string('image')->nullable(); // Hình ảnh
            $table->integer('view')->default(0); // Số lượt xem
            $table->timestamps(); // Các trường created_at và updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
