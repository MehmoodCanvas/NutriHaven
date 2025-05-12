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
        Schema::create('tag', function (Blueprint $table) {
            $table->id('tag_id');
            $table->foreignId('tag_nutriheaven_excerise_id')->references('nutrihaven_exercise_id')->on('nutrihaven_exercise')->onDelete('cascade');
            $table->string('tag_name'); 
            $table->string('tag_description'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tag');
    }
};
