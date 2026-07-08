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
        Schema::create('workout_log_exercise_sets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workout_log_exercise_id')->constrained('workout_log_exercises')->onDelete('cascade');
            $table->integer('set_number');
            $table->integer('reps');
            $table->decimal('weight', 8, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workout_log_exercise_sets');
    }
};
