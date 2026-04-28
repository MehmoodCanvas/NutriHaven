<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\MasterExercise;
use Illuminate\Support\Facades\Log;

class ClassifyExercises extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exercises:classify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically classify master exercises with goals and duration based on keywords';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $exercises = MasterExercise::all();
        $videos = \App\Models\Workout_videos::all();
        $count = 0;

        foreach ($exercises as $exercise) {
            $name = strtolower($exercise->name);
            $goals = [];
            $duration = 10; // Default

            // Rule 1: Cardio & Movement
            if (preg_match('/(run|jump|walk|treadmill|bike|rope|rowing|cycling|cardio|skip|step|skater)/i', $name)) {
                $goals = array_merge($goals, ['Cardio', 'Weight Loss', 'Increase energy levels']);
                $duration = 15;
            }

            // Rule 2: Flexibility & Stretching
            if (preg_match('/(stretch|yoga|hold|rotation|flexion|band|mobility|roll|pose)/i', $name)) {
                $goals = array_merge($goals, ['Flexibility', 'Improve Mobility', 'Stress Relief', 'Rehab', 'Improve posture']);
                $duration = 5;
            }

            // Rule 3: Abs & Core
            if (preg_match('/(crunch|plank|sit-up|sit up|twist|abs|core|ab |leg raise|russian|tuck)/i', $name)) {
                $goals = array_merge($goals, ['Weight Maintenance', 'Improve posture']);
                if ($duration == 10) $duration = 5; // Isolation work
            }

            // Rule 4: Bodybuilding & Weights
            if (preg_match('/(db |dumbell|dumbbell|barbell|machine|press|curl|squat|deadlift|extension|fly|row|lunge|raise|push|pull|pulldown|cable|smith)/i', $name)) {
                $goals = array_merge($goals, ['Bodybuilding', 'Weight Maintenance', 'Increase energy levels']);
                // Keep 10 or bump if heavy, but 10 is fine.
            }

            // If empty, fallback to Bodybuilding / Weight Maintenance for general gym equipment
            if (empty($goals)) {
                 $goals = ['Bodybuilding', 'Weight Maintenance'];
            }

            // Default Sets logic
            $defaultSets = [];
            if (in_array('Cardio', $goals)) {
                $defaultSets = [
                    ['set' => 1, 'reps' => 15, 'weight' => 0],
                    ['set' => 2, 'reps' => 15, 'weight' => 0],
                    ['set' => 3, 'reps' => 15, 'weight' => 0],
                ];
            } elseif (in_array('Flexibility', $goals)) {
                $defaultSets = [
                    ['set' => 1, 'reps' => 1, 'weight' => 0, 'duration' => '30s'],
                    ['set' => 2, 'reps' => 1, 'weight' => 0, 'duration' => '30s'],
                    ['set' => 3, 'reps' => 1, 'weight' => 0, 'duration' => '30s'],
                ];
            } else {
                // Strength/Bodybuilding default
                $defaultSets = [
                    ['set' => 1, 'reps' => 10, 'weight' => 20],
                    ['set' => 2, 'reps' => 10, 'weight' => 20],
                    ['set' => 3, 'reps' => 10, 'weight' => 20],
                ];
            }

            // Remove duplicates
            $goals = array_values(array_unique($goals));

            $exercise->goals = $goals;
            $exercise->duration_minutes = $duration;
            $exercise->default_sets = $defaultSets;

            // Try to match with a workout video (Case-Insensitive)
            $searchName = strtolower($exercise->name);
            
            $matchedVideo = $videos->first(function($v) use ($searchName) {
                $vTitle = strtolower($v->workout_videos_title);
                $vDesc = strtolower($v->workout_videos_description);
                return str_contains($vTitle, $searchName) || 
                       str_contains($vDesc, $searchName) || 
                       str_contains($searchName, $vTitle);
            });

            if ($matchedVideo) {
                $exercise->workout_video_id = $matchedVideo->workout_videos_id;
            }

            $exercise->save();

            $count++;
        }

        $this->info("Successfully classified $count exercises.");
    }
}
