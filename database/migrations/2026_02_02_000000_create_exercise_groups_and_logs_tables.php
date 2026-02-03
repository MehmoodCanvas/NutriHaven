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
        Schema::create('exercise_groups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained('member', 'member_id')->onDelete('cascade');
            $table->string('title');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('group_exercises', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id')->constrained('exercise_groups')->onDelete('cascade');
            $table->foreignId('master_exercise_id')->constrained('master_exercises')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('exercise_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained('member', 'member_id')->onDelete('cascade');
            $table->foreignId('group_exercise_id')->nullable()->constrained('group_exercises')->onDelete('cascade');
            $table->foreignId('master_exercise_id')->constrained('master_exercises')->onDelete('cascade');
            $table->dateTime('start_time');
            $table->dateTime('end_time')->nullable();
            $table->date('log_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exercise_logs');
        Schema::dropIfExists('group_exercises');
        Schema::dropIfExists('exercise_groups');
    }
};
