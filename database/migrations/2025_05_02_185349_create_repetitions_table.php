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
        Schema::create('repetition', function (Blueprint $table) {
            $table->id('repetition_id');
            $table->foreignId('repetition_excerise_id')->references('excerise_id')->on('excerise')->onDelete('cascade');
            $table->foreignId('repetition_user_workout_id')->references('user_workout_id')->on('user_workout')->onDelete('cascade');
            $table->integer('repetition_time');
            $table->boolean('repetition_completed')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('repetition');
    }
};
