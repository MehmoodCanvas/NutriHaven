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
        Schema::create('nutrihaven_excerise', function (Blueprint $table) {
            $table->id('nutrihaven_excerise_id');
            $table->foreign('nutrihaven_excerise_excerise_muscle_id')->references('exercise_muscle_id')->on('exercise_muscle')->onDelete('cascade');
            $table->foreign('nutrihaven_excerise_routine_id')->references('workout_routine_id')->on('workout_routine')->onDelete('cascade');
            $table->string('nutrihaven_excerise_name');
            $table->LONGTEXT('nutrihaven_excerise_instructions');
            $table->string('nutrihaven_excerise_video_url');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nutrihaven_excerise');
    }
};
