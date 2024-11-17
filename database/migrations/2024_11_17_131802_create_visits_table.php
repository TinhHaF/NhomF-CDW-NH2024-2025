<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // Trong migration
    public function up()
    {
        Schema::create('visits', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address');
            $table->text('user_agent');
            $table->string('browser')->nullable();
            $table->string('device_type');
            $table->timestamp('visited_at');
            $table->string('page_url')->nullable();
            $table->string('referrer')->nullable();
            $table->string('session_id')->nullable();
            $table->timestamps(); // Thêm dòng này để tạo cột created_at và updated_at
            // Add index cho các cột khác nếu cần
            $table->index('session_id');
        });

        // Tạo index thủ công với prefix length
        DB::statement('CREATE INDEX visits_ip_address_user_agent_visited_at_index ON visits (ip_address, user_agent(191), visited_at)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visits');
    }
};
