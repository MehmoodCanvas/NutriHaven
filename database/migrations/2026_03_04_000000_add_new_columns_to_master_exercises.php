<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('master_exercises', function (Blueprint $table) {
            $table->enum('difficulty', ['Beginner', 'Intermediate', 'Advanced'])->nullable()->after('name');
            $table->text('primary_muscles')->nullable()->after('muscle_group_id');
            $table->text('secondary_muscles')->nullable()->after('primary_muscles');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('master_exercises', function (Blueprint $table) {
            $table->dropColumn(['difficulty', 'primary_muscles', 'secondary_muscles']);
        });
    }
};
