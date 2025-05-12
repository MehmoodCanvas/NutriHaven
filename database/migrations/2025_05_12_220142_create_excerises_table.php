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
        Schema::create('excerise', function (Blueprint $table) {
            $table->id('excerise_id');
            $table->integer('excerise_nutrihaven_excerise_id');
            $table->integer('excerise_workout_excerise_id');
            $table->integer('excerise_repetitions');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('excerise');
    }
};
