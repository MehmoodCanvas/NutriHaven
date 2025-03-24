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
        Schema::create('workout_videos', function (Blueprint $table) {
            $table->id('workout_videos_id');
            $table->string('workout_videos_description');
            $table->string('workout_videos_title');
            $table->string('workout_videos_cdn_url');
            $table->integer('workout_videos_category_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workout_videos');
    }
};
