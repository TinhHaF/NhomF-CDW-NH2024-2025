<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('authors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('user_id')->unique()->constrained('users')->onDelete('cascade');
            $table->string('pen_name', 100)->nullable();
            $table->text('biography')->nullable();
            $table->string('image')->unique(); // Thêm cột image
            $table->date('published_date')->nullable();
            $table->timestamps();
        });
        DB::statement('ALTER TABLE authors ENGINE = InnoDB');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('authors');
    }
};
