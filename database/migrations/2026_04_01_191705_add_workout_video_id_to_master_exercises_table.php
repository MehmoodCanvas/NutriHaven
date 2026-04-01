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
        Schema::table('master_exercises', function (Blueprint $table) {
            $table->unsignedBigInteger('workout_video_id')->nullable()->after('default_sets');
            $table->foreign('workout_video_id')->references('workout_videos_id')->on('workout_videos')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('master_exercises', function (Blueprint $table) {
            $table->dropForeign(['workout_video_id']);
            $table->dropColumn('workout_video_id');
        });
    }
};
