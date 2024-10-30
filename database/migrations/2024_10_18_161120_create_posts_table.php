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
            $table->bigIncrements('id');               // Primary key
            $table->unsignedBigInteger('author_id')->nullable();
            $table->string('title', 255);
            $table->string('slug', 255)->nullable();   // Không cần dùng 'AFTER'
            $table->text('content');
            $table->string('image', 255)->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->tinyInteger('is_featured')->default(0);
            $table->tinyInteger('is_published')->default(0);
            $table->string('seo_title', 255)->nullable();
            $table->text('seo_description')->nullable();
            $table->string('seo_keywords', 255)->nullable();
            $table->unsignedBigInteger('category_id')->nullable();

            // $table->string('slug')->nullable()->after('title'); // Đảm bảo cột này là duy nhất
            // $table->unique('slug');
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
