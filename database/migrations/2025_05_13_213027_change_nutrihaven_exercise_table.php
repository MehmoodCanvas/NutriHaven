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
        Schema::table('nutrihaven_exercise', function (Blueprint $table) {
            if (Schema::hasColumn('nutrihaven_exercise', 'nutrihaven_excerise_muscle_id')) {
            $table->dropForeign(['nutrihaven_excerise_muscle_id']);
            $table->dropColumn('nutrihaven_excerise_muscle_id');
            }
            if (Schema::hasColumn('nutrihaven_exercise', 'nutrihaven_excerise_routine_id')) {
            $table->dropForeign(['nutrihaven_excerise_routine_id']);
            $table->dropColumn('nutrihaven_excerise_routine_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nutrihaven_exercise', function (Blueprint $table) {
            //
        });
    }
};
