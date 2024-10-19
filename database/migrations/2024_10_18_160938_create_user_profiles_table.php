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
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id'); // Định nghĩa cột khóa ngoại trước
            $table->string('full_name', 100)->nullable();
            $table->text('bio')->nullable();
            $table->string('avatar', 255)->nullable();
            $table->string('website', 255)->nullable();
            
            // Thiết lập khóa chính là user_id
            $table->primary('user_id');

            // Định nghĩa khóa ngoại liên kết đến bảng users
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};
