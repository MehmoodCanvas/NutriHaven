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
        Schema::create('nutrihaven_exercise', function (Blueprint $table) {
            $table->id('nutrihaven_exercise_id');
            $table->foreignId('nutrihaven_excerise_ muscle_id')->references('exercise_muscle_id')->on('exercise_muscle')->onDelete('cascade');
            $table->foreignId('nutrihaven_excerise_routine_id')->references('workout_routine_id')->on('workout_routine')->onDelete('cascade');
            $table->string('nutrihaven_exercise_name');
            $table->longText('nutrihaven_exercise_instructions');
            $table->string('nutrihaven_exercise_video_url');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nutrihaven_exercise');
    }
};
