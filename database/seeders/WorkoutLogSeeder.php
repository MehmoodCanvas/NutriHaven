<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WorkoutLog;
use App\Models\WorkoutLogExercise;
use App\Models\WorkoutLogExerciseSet;
use Carbon\Carbon;

class WorkoutLogSeeder extends Seeder
{
    public function run(): void
    {
        $memberId = 1;

        // Realistic workout schedule: 3 weeks, 4-5 days per week
        $workouts = [
            // ====== WEEK 1 (June 23 - June 29) ======
            [
                'name' => 'Push Day - Chest & Triceps',
                'log_date' => '2026-06-23',
                'start_time' => '2026-06-23 07:00:00',
                'end_time' => '2026-06-23 08:10:00',
                'exercises' => [
                    // Bench Press (Chest)
                    ['id' => 182, 'sets' => [['reps' => 12, 'weight' => 135], ['reps' => 10, 'weight' => 155], ['reps' => 8, 'weight' => 175], ['reps' => 6, 'weight' => 185]]],
                    // Cable Chest Fly
                    ['id' => 176, 'sets' => [['reps' => 15, 'weight' => 30], ['reps' => 12, 'weight' => 35], ['reps' => 12, 'weight' => 35]]],
                    // Incline Push Up
                    ['id' => 214, 'sets' => [['reps' => 15, 'weight' => 0], ['reps' => 12, 'weight' => 0], ['reps' => 10, 'weight' => 0]]],
                    // Tricep Dumbbell Kickback
                    ['id' => 449, 'sets' => [['reps' => 12, 'weight' => 20], ['reps' => 10, 'weight' => 25], ['reps' => 10, 'weight' => 25]]],
                    // Over Head Cable Extension
                    ['id' => 444, 'sets' => [['reps' => 15, 'weight' => 40], ['reps' => 12, 'weight' => 45], ['reps' => 10, 'weight' => 50]]],
                    // Plank finish (time-based)
                    ['id' => 28, 'time_based' => true, 'sets' => [['duration' => '45s'], ['duration' => '45s'], ['duration' => '30s']]],
                ],
            ],
            [
                'name' => 'Pull Day - Back & Biceps',
                'log_date' => '2026-06-24',
                'start_time' => '2026-06-24 17:30:00',
                'end_time' => '2026-06-24 18:45:00',
                'exercises' => [
                    // Barbell Row
                    ['id' => 85, 'sets' => [['reps' => 10, 'weight' => 135], ['reps' => 8, 'weight' => 155], ['reps' => 8, 'weight' => 155], ['reps' => 6, 'weight' => 165]]],
                    // Db Bent Over Rows
                    ['id' => 87, 'sets' => [['reps' => 12, 'weight' => 40], ['reps' => 10, 'weight' => 45], ['reps' => 10, 'weight' => 45]]],
                    // Cable Lat Pull Overs
                    ['id' => 88, 'sets' => [['reps' => 12, 'weight' => 50], ['reps' => 12, 'weight' => 55], ['reps' => 10, 'weight' => 60]]],
                    // Close Grip Cable Row
                    ['id' => 90, 'sets' => [['reps' => 12, 'weight' => 70], ['reps' => 10, 'weight' => 80], ['reps' => 10, 'weight' => 80]]],
                    // Hollow Body Hold (time-based)
                    ['id' => 32, 'time_based' => true, 'sets' => [['duration' => '30s'], ['duration' => '30s'], ['duration' => '25s']]],
                ],
            ],
            [
                'name' => 'Leg Day',
                'log_date' => '2026-06-25',
                'start_time' => '2026-06-25 06:30:00',
                'end_time' => '2026-06-25 07:50:00',
                'exercises' => [
                    // Db Squats
                    ['id' => 263, 'sets' => [['reps' => 12, 'weight' => 50], ['reps' => 10, 'weight' => 60], ['reps' => 8, 'weight' => 70], ['reps' => 8, 'weight' => 70]]],
                    // Dumbbell Lunges
                    ['id' => 276, 'sets' => [['reps' => 12, 'weight' => 30], ['reps' => 10, 'weight' => 35], ['reps' => 10, 'weight' => 35]]],
                    // Landmine Squat
                    ['id' => 303, 'sets' => [['reps' => 12, 'weight' => 45], ['reps' => 10, 'weight' => 55], ['reps' => 10, 'weight' => 55]]],
                    // Cossack Squat
                    ['id' => 257, 'sets' => [['reps' => 10, 'weight' => 0], ['reps' => 10, 'weight' => 0], ['reps' => 8, 'weight' => 0]]],
                    // Copenhagen Plank (time-based)
                    ['id' => 15, 'time_based' => true, 'sets' => [['duration' => '20s'], ['duration' => '20s'], ['duration' => '15s']]],
                ],
            ],
            [
                'name' => 'Shoulders & Core',
                'log_date' => '2026-06-27',
                'start_time' => '2026-06-27 07:15:00',
                'end_time' => '2026-06-27 08:15:00',
                'exercises' => [
                    // Bent Over Side Raises
                    ['id' => 358, 'sets' => [['reps' => 15, 'weight' => 15], ['reps' => 12, 'weight' => 20], ['reps' => 12, 'weight' => 20]]],
                    // Landmine Punch
                    ['id' => 393, 'sets' => [['reps' => 10, 'weight' => 25], ['reps' => 10, 'weight' => 25], ['reps' => 8, 'weight' => 30]]],
                    // Elbow Up Down Planks (time-based)
                    ['id' => 21, 'time_based' => true, 'sets' => [['duration' => '40s'], ['duration' => '35s'], ['duration' => '30s']]],
                    // Hip Roll Plank (time-based)
                    ['id' => 31, 'time_based' => true, 'sets' => [['duration' => '30s'], ['duration' => '30s'], ['duration' => '25s']]],
                    // Jack Plank (time-based)
                    ['id' => 34, 'time_based' => true, 'sets' => [['duration' => '30s'], ['duration' => '25s'], ['duration' => '20s']]],
                ],
            ],

            // ====== WEEK 2 (June 30 - July 6) ======
            [
                'name' => 'Push Day - Chest & Triceps',
                'log_date' => '2026-06-30',
                'start_time' => '2026-06-30 06:45:00',
                'end_time' => '2026-06-30 08:00:00',
                'exercises' => [
                    ['id' => 182, 'sets' => [['reps' => 12, 'weight' => 140], ['reps' => 10, 'weight' => 160], ['reps' => 8, 'weight' => 180], ['reps' => 6, 'weight' => 190]]],
                    ['id' => 225, 'sets' => [['reps' => 12, 'weight' => 25], ['reps' => 12, 'weight' => 25], ['reps' => 10, 'weight' => 30]]],
                    ['id' => 230, 'sets' => [['reps' => 12, 'weight' => 30], ['reps' => 10, 'weight' => 35], ['reps' => 10, 'weight' => 35]]],
                    ['id' => 432, 'sets' => [['reps' => 12, 'weight' => 25], ['reps' => 10, 'weight' => 30], ['reps' => 10, 'weight' => 30]]],
                    ['id' => 28, 'time_based' => true, 'sets' => [['duration' => '50s'], ['duration' => '45s'], ['duration' => '40s']]],
                ],
            ],
            [
                'name' => 'Pull Day - Back & Biceps',
                'log_date' => '2026-07-01',
                'start_time' => '2026-07-01 17:00:00',
                'end_time' => '2026-07-01 18:20:00',
                'exercises' => [
                    ['id' => 84, 'sets' => [['reps' => 10, 'weight' => 135], ['reps' => 8, 'weight' => 155], ['reps' => 6, 'weight' => 175]]],
                    ['id' => 96, 'sets' => [['reps' => 12, 'weight' => 35], ['reps' => 10, 'weight' => 40], ['reps' => 10, 'weight' => 40]]],
                    ['id' => 91, 'sets' => [['reps' => 12, 'weight' => 40], ['reps' => 10, 'weight' => 45], ['reps' => 10, 'weight' => 45]]],
                    ['id' => 90, 'sets' => [['reps' => 12, 'weight' => 75], ['reps' => 10, 'weight' => 85], ['reps' => 10, 'weight' => 85]]],
                    ['id' => 32, 'time_based' => true, 'sets' => [['duration' => '35s'], ['duration' => '35s'], ['duration' => '30s']]],
                ],
            ],
            [
                'name' => 'Leg Day',
                'log_date' => '2026-07-02',
                'start_time' => '2026-07-02 07:00:00',
                'end_time' => '2026-07-02 08:15:00',
                'exercises' => [
                    ['id' => 263, 'sets' => [['reps' => 12, 'weight' => 55], ['reps' => 10, 'weight' => 65], ['reps' => 8, 'weight' => 75], ['reps' => 8, 'weight' => 75]]],
                    ['id' => 276, 'sets' => [['reps' => 12, 'weight' => 35], ['reps' => 10, 'weight' => 40], ['reps' => 10, 'weight' => 40]]],
                    ['id' => 303, 'sets' => [['reps' => 12, 'weight' => 50], ['reps' => 10, 'weight' => 60], ['reps' => 10, 'weight' => 60]]],
                    ['id' => 15, 'time_based' => true, 'sets' => [['duration' => '25s'], ['duration' => '25s'], ['duration' => '20s']]],
                ],
            ],
            [
                'name' => 'Upper Body & Core',
                'log_date' => '2026-07-04',
                'start_time' => '2026-07-04 08:00:00',
                'end_time' => '2026-07-04 09:00:00',
                'exercises' => [
                    ['id' => 231, 'sets' => [['reps' => 12, 'weight' => 40], ['reps' => 10, 'weight' => 45], ['reps' => 10, 'weight' => 45]]],
                    ['id' => 358, 'sets' => [['reps' => 15, 'weight' => 20], ['reps' => 12, 'weight' => 25], ['reps' => 12, 'weight' => 25]]],
                    ['id' => 449, 'sets' => [['reps' => 12, 'weight' => 22], ['reps' => 10, 'weight' => 27], ['reps' => 10, 'weight' => 27]]],
                    ['id' => 8, 'time_based' => true, 'sets' => [['duration' => '40s'], ['duration' => '35s'], ['duration' => '30s']]],
                    ['id' => 20, 'time_based' => true, 'sets' => [['duration' => '30s'], ['duration' => '25s'], ['duration' => '20s']]],
                ],
            ],

            // ====== WEEK 3 (July 7 - July 9) ======
            [
                'name' => 'Push Day - Chest & Triceps',
                'log_date' => '2026-07-07',
                'start_time' => '2026-07-07 06:30:00',
                'end_time' => '2026-07-07 07:50:00',
                'exercises' => [
                    ['id' => 182, 'sets' => [['reps' => 12, 'weight' => 145], ['reps' => 10, 'weight' => 165], ['reps' => 8, 'weight' => 185], ['reps' => 5, 'weight' => 195]]],
                    ['id' => 176, 'sets' => [['reps' => 15, 'weight' => 35], ['reps' => 12, 'weight' => 40], ['reps' => 12, 'weight' => 40]]],
                    ['id' => 214, 'sets' => [['reps' => 18, 'weight' => 0], ['reps' => 15, 'weight' => 0], ['reps' => 12, 'weight' => 0]]],
                    ['id' => 444, 'sets' => [['reps' => 15, 'weight' => 45], ['reps' => 12, 'weight' => 50], ['reps' => 10, 'weight' => 55]]],
                    ['id' => 28, 'time_based' => true, 'sets' => [['duration' => '60s'], ['duration' => '50s'], ['duration' => '45s']]],
                ],
            ],
            [
                'name' => 'Pull Day - Back',
                'log_date' => '2026-07-08',
                'start_time' => '2026-07-08 17:15:00',
                'end_time' => '2026-07-08 18:30:00',
                'exercises' => [
                    ['id' => 85, 'sets' => [['reps' => 10, 'weight' => 140], ['reps' => 8, 'weight' => 160], ['reps' => 8, 'weight' => 160], ['reps' => 6, 'weight' => 175]]],
                    ['id' => 87, 'sets' => [['reps' => 12, 'weight' => 45], ['reps' => 10, 'weight' => 50], ['reps' => 10, 'weight' => 50]]],
                    ['id' => 88, 'sets' => [['reps' => 12, 'weight' => 55], ['reps' => 12, 'weight' => 60], ['reps' => 10, 'weight' => 65]]],
                    ['id' => 92, 'sets' => [['reps' => 10, 'weight' => 30], ['reps' => 10, 'weight' => 30], ['reps' => 8, 'weight' => 35]]],
                    ['id' => 32, 'time_based' => true, 'sets' => [['duration' => '40s'], ['duration' => '35s'], ['duration' => '30s']]],
                ],
            ],
            [
                'name' => 'Leg & Core',
                'log_date' => '2026-07-09',
                'start_time' => '2026-07-09 07:00:00',
                'end_time' => '2026-07-09 08:20:00',
                'exercises' => [
                    ['id' => 263, 'sets' => [['reps' => 12, 'weight' => 60], ['reps' => 10, 'weight' => 70], ['reps' => 8, 'weight' => 80], ['reps' => 8, 'weight' => 80]]],
                    ['id' => 276, 'sets' => [['reps' => 12, 'weight' => 35], ['reps' => 10, 'weight' => 40], ['reps' => 10, 'weight' => 40]]],
                    ['id' => 257, 'sets' => [['reps' => 10, 'weight' => 10], ['reps' => 10, 'weight' => 10], ['reps' => 8, 'weight' => 15]]],
                    ['id' => 21, 'time_based' => true, 'sets' => [['duration' => '45s'], ['duration' => '40s'], ['duration' => '35s']]],
                    ['id' => 15, 'time_based' => true, 'sets' => [['duration' => '25s'], ['duration' => '25s'], ['duration' => '20s']]],
                    ['id' => 34, 'time_based' => true, 'sets' => [['duration' => '35s'], ['duration' => '30s'], ['duration' => '25s']]],
                ],
            ],
        ];

        foreach ($workouts as $workout) {
            $log = WorkoutLog::create([
                'member_id' => $memberId,
                'name' => $workout['name'],
                'start_time' => Carbon::parse($workout['start_time']),
                'end_time' => Carbon::parse($workout['end_time']),
                'log_date' => $workout['log_date'],
            ]);

            foreach ($workout['exercises'] as $exerciseData) {
                $logExercise = WorkoutLogExercise::create([
                    'workout_log_id' => $log->id,
                    'master_exercise_id' => $exerciseData['id'],
                ]);

                $isTimeBased = $exerciseData['time_based'] ?? false;

                foreach ($exerciseData['sets'] as $index => $setData) {
                    WorkoutLogExerciseSet::create([
                        'workout_log_exercise_id' => $logExercise->id,
                        'set_number' => $index + 1,
                        'reps' => $isTimeBased ? null : ($setData['reps'] ?? null),
                        'weight' => $isTimeBased ? null : ($setData['weight'] ?? null),
                        'duration' => $isTimeBased ? ($setData['duration'] ?? null) : null,
                    ]);
                }
            }
        }
    }
}
