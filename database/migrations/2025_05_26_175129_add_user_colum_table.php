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

            $table->foreignId('exercise_muscle_member_id')
            ->after('exercise_muscle_muscle_id')
            ->constrained('member', 'member_id')
            ->onDelete('cascade')->comment('Foreign key referencing the members table');
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
