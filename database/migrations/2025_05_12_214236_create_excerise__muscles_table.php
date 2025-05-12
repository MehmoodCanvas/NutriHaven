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
        Schema::create('exercise_muscle', function (Blueprint $table) {
            $table->id('exercise_muscle_id');
            $table->foreignId('exercise_muscle_exercise_group_id')->references('nutrihaven_exercise_id')->on('nutrihaven_exercise')->onDelete('cascade');
            $table->foreignId('exercise_muscle_muscle_id')->references('muscle_id')->on('muscle')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exercise_muscle');
    }
};
