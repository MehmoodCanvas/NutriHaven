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
        Schema::create('member', function (Blueprint $table) {
            $table->id('member_id');
            $table->string('member_full_name');
            $table->string('member_email')->unqiue();
            $table->string('member_password');
            $table->string('member_profile')->nullable();
            $table->string('member_gender');
            $table->integer('member_age');
            $table->double('member_weight');
            $table->enum('member_weight_unit',['lbs','kg']);
            $table->double('member_height_ft');
            $table->double('member_height_in');
            $table->string('member_goal');
            $table->string('member_exp');
            $table->LongText('member_excerise_place');
            $table->string('member_token');
            $table->string('member_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member');
    }
};
