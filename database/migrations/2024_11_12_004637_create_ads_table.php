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
        Schema::create('ads', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Tiêu đề quảng cáo
            $table->string('image'); // Hình ảnh quảng cáo
            $table->string('url'); // Liên kết khi click vào quảng cáo
            $table->string('position'); // Vị trí quảng cáo
            $table->boolean('status')->default(1); // Trạng thái (1: kích hoạt, 0: vô hiệu)
            $table->date('start_date')->nullable(); // Ngày bắt đầu
            $table->date('end_date')->nullable(); // Ngày kết thúc
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ads');
    }
};
