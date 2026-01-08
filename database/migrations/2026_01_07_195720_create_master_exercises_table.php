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
        Schema::create('master_exercises', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('muscle_group_id')->constrained('muscle_groups')->onDelete('cascade');
            $table->foreignId('equipment_required_id')->nullable()->constrained('equipments')->onDelete('set null');
            $table->foreignId('aux_equipment_id')->nullable()->constrained('aux_equipments')->onDelete('set null');
            $table->string('exercise_image')->nullable()->default('public/assets/demo_exercises.png');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_exercises');
    }
};
