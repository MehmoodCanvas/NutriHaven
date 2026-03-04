<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\MuscleGroup;
use App\Models\Equipment;
use App\Models\AuxEquipment;
use App\Models\MasterExercise;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ImportExercises extends Command
{
    protected $signature = 'app:import-exercises';
    protected $description = 'Import exercises from Google Sheet CSV (new format with difficulty & muscles)';

    public function handle()
    {
        $url = 'https://docs.google.com/spreadsheets/d/1s0ri-600rwTBhsPS4-DGEj4mVbtZvjM3VCk8xFdN3Y4/export?format=csv&gid=177242604';
        $this->info("Fetching data from: $url");

        try {
            $content = file_get_contents($url);
        } catch (\Exception $e) {
            $this->error("Failed to fetch data: " . $e->getMessage());
            return 1;
        }

        // --- Truncate old data (order matters for FK constraints) ---
        $this->info('Truncating old exercise data...');
        Schema::disableForeignKeyConstraints();
        DB::table('exercise_logs')->truncate();
        DB::table('group_exercises')->truncate();
        DB::table('exercise_groups')->truncate();
        DB::table('master_exercises')->truncate();
        DB::table('muscle_groups')->truncate();
        DB::table('equipments')->truncate();
        DB::table('aux_equipments')->truncate();
        Schema::enableForeignKeyConstraints();
        $this->info('Old data truncated.');

        $lines = explode("\n", $content);
        // Skip header
        array_shift($lines);

        $bar = $this->output->createProgressBar(count($lines));
        $bar->start();

        foreach ($lines as $line) {
            if (empty(trim($line)))
                continue;

            $row = str_getcsv($line);

            // Expected columns:
            // 0: Exercise, 1: Equipment Required, 2: Aux Equipment,
            // 3: Difficulty, 4: Muscle Group, 5: Primary, 6: Secondary
            if (count($row) < 5)
                continue;

            $exerciseName     = trim($row[0]);
            $equipmentName    = isset($row[1]) ? trim($row[1]) : null;
            $auxEquipmentName = isset($row[2]) ? trim($row[2]) : null;
            $difficulty       = isset($row[3]) ? trim($row[3]) : null;
            $muscleGroupName  = isset($row[4]) ? trim($row[4]) : null;
            $primaryMuscles   = isset($row[5]) ? trim($row[5]) : null;
            $secondaryMuscles = isset($row[6]) ? trim($row[6]) : null;

            if (empty($exerciseName))
                continue;

            // Muscle Group
            $muscleGroup = null;
            if ($muscleGroupName && !empty($muscleGroupName)) {
                $muscleGroup = MuscleGroup::firstOrCreate(['name' => $muscleGroupName]);
            }

            // Equipment
            $equipmentId = null;
            if ($equipmentName && strtolower($equipmentName) !== 'none' && !empty($equipmentName)) {
                $eq = Equipment::firstOrCreate(['name' => $equipmentName]);
                $equipmentId = $eq->id;
            }

            // Aux Equipment
            $auxEquipmentId = null;
            if ($auxEquipmentName && strtolower($auxEquipmentName) !== 'none' && !empty($auxEquipmentName)) {
                $eq = AuxEquipment::firstOrCreate(['name' => $auxEquipmentName]);
                $auxEquipmentId = $eq->id;
            }

            // Validate difficulty
            $validDifficulties = ['Beginner', 'Intermediate', 'Advanced'];
            if ($difficulty && !in_array($difficulty, $validDifficulties)) {
                $difficulty = null;
            }

            // Create Exercise
            MasterExercise::updateOrCreate(
                ['name' => $exerciseName],
                [
                    'muscle_group_id'       => $muscleGroup ? $muscleGroup->id : null,
                    'equipment_required_id'  => $equipmentId,
                    'aux_equipment_id'       => $auxEquipmentId,
                    'difficulty'             => $difficulty,
                    'primary_muscles'        => $primaryMuscles,
                    'secondary_muscles'      => $secondaryMuscles,
                ]
            );

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('Import completed successfully.');

        $this->table(
            ['Table', 'Count'],
            [
                ['Muscle Groups', MuscleGroup::count()],
                ['Equipments', Equipment::count()],
                ['Aux Equipments', AuxEquipment::count()],
                ['Master Exercises', MasterExercise::count()],
            ]
        );
    }
}
