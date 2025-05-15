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
        Schema::table('exercise_muscle', function (Blueprint $table) {
            $table->dropForeign(['exercise_muscle_exercise_group_id']);
            $table->dropColumn('exercise_muscle_exercise_group_id');
            $table->foreignId('exercise_muscle_exercise_id')
            ->after('exercise_muscle_id')
            ->constrained('exercise', 'exercise_id')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('exercise_muscle', function (Blueprint $table) {
            //
        });
    }
};
