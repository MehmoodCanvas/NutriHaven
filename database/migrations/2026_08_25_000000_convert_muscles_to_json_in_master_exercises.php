<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     * Convert primary_muscles and secondary_muscles from text (comma-separated) to JSON arrays.
     */
    public function up(): void
    {
        // Step 1: Convert existing comma-separated text data to JSON arrays
        $exercises = DB::table('master_exercises')->get();
        foreach ($exercises as $exercise) {
            $primary = null;
            $secondary = null;

            if (!empty($exercise->primary_muscles)) {
                $muscles = array_map('trim', explode(',', $exercise->primary_muscles));
                $muscles = array_filter($muscles);
                $primary = json_encode(array_values($muscles));
            }

            if (!empty($exercise->secondary_muscles)) {
                $muscles = array_map('trim', explode(',', $exercise->secondary_muscles));
                $muscles = array_filter($muscles);
                $secondary = json_encode(array_values($muscles));
            }

            DB::table('master_exercises')
                ->where('id', $exercise->id)
                ->update([
                    'primary_muscles' => $primary,
                    'secondary_muscles' => $secondary,
                ]);
        }

        // Step 2: Change column type from text to json
        Schema::table('master_exercises', function (Blueprint $table) {
            $table->json('primary_muscles')->nullable()->change();
            $table->json('secondary_muscles')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Change back to text
        Schema::table('master_exercises', function (Blueprint $table) {
            $table->text('primary_muscles')->nullable()->change();
            $table->text('secondary_muscles')->nullable()->change();
        });

        // Convert JSON arrays back to comma-separated text
        $exercises = DB::table('master_exercises')->get();
        foreach ($exercises as $exercise) {
            $primary = null;
            $secondary = null;

            if (!empty($exercise->primary_muscles)) {
                $decoded = json_decode($exercise->primary_muscles, true);
                if (is_array($decoded)) {
                    $primary = implode(', ', $decoded);
                }
            }

            if (!empty($exercise->secondary_muscles)) {
                $decoded = json_decode($exercise->secondary_muscles, true);
                if (is_array($decoded)) {
                    $secondary = implode(', ', $decoded);
                }
            }

            DB::table('master_exercises')
                ->where('id', $exercise->id)
                ->update([
                    'primary_muscles' => $primary,
                    'secondary_muscles' => $secondary,
                ]);
        }
    }
};
