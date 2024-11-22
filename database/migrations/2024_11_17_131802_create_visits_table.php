<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitsTable extends Migration
{
    public function up()
    {
        Schema::create('visits', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->string('browser')->nullable();
            $table->string('device_type')->nullable();
            $table->timestamp('visited_at')->nullable();
            $table->string('page_url', 500)->nullable();
            $table->string('referrer')->nullable();
            $table->string('session_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->boolean('is_anonymous')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('visits');
    }
}
