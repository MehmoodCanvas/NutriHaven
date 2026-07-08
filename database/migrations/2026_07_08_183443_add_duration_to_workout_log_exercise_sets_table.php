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
        Schema::table('workout_log_exercise_sets', function (Blueprint $table) {
            $table->string('duration')->nullable()->after('weight');
            $table->integer('reps')->nullable()->change();
            $table->decimal('weight', 8, 2)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('workout_log_exercise_sets', function (Blueprint $table) {
            $table->dropColumn('duration');
            $table->integer('reps')->nullable(false)->change();
            $table->decimal('weight', 8, 2)->nullable(false)->change();
        });
    }
};
