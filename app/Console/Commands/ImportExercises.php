<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\MuscleGroup;
use App\Models\Equipment;
use App\Models\AuxEquipment;
use App\Models\MasterExercise;

class ImportExercises extends Command
{
    protected $signature = 'app:import-exercises';
    protected $description = 'Import exercises from Google Sheet CSV';

    public function handle()
    {
        $url = 'https://docs.google.com/spreadsheets/d/1s0ri-600rwTBhsPS4-DGEj4mVbtZvjM3VCk8xFdN3Y4/export?format=csv&gid=0';
        $this->info("Fetching data from: $url");

        try {
            $content = file_get_contents($url);
        } catch (\Exception $e) {
            $this->error("Failed to fetch data: " . $e->getMessage());
            return 1;
        }

        $lines = explode("\n", $content);
        // Skip header
        array_shift($lines);

        $bar = $this->output->createProgressBar(count($lines));
        $bar->start();

        foreach ($lines as $line) {
            if (empty(trim($line)))
                continue;

            $row = str_getcsv($line);

            // Expected: Excercise (0), Muscle Group (1), Equipment Required (2), Aux Equipment (3)
            if (count($row) < 2)
                continue;

            $exerciseName = trim($row[0]);
            $muscleGroupName = trim($row[1]);
            $equipmentName = isset($row[2]) ? trim($row[2]) : null;
            $auxEquipmentName = isset($row[3]) ? trim($row[3]) : null;

            if (empty($exerciseName))
                continue;

            // Muscle Group
            $muscleGroup = MuscleGroup::firstOrCreate(['name' => $muscleGroupName]);

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

            // Create Exercise
            MasterExercise::updateOrCreate(
                ['name' => $exerciseName],
                [
                    'muscle_group_id' => $muscleGroup->id,
                    'equipment_required_id' => $equipmentId,
                    'aux_equipment_id' => $auxEquipmentId,
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
                ['Master Exercises', MasterExercise::count()],
            ]
        );
    }
}
