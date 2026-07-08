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
            $isTimeBased = false;

            // Rule 1: Cardio & Movement
            if (preg_match('/(run|jump|walk|treadmill|bike|rope|rowing|cycling|cardio|skip|step|skater)/i', $name)) {
                $goals = array_merge($goals, ['Cardio', 'Weight Loss', 'Increase energy levels']);
                $isTimeBased = true;
            }

            // Rule 2: Flexibility & Stretching
            if (preg_match('/(stretch|yoga|hold|rotation|flexion|band|mobility|roll|pose)/i', $name)) {
                $goals = array_merge($goals, ['Flexibility', 'Improve Mobility', 'Stress Relief', 'Rehab', 'Improve posture']);
                $isTimeBased = true;
            }

            // Rule 3: Abs & Core
            if (preg_match('/(crunch|sit-up|sit up|twist|abs|core|ab |leg raise|russian|tuck)/i', $name)) {
                $goals = array_merge($goals, ['Weight Maintenance', 'Improve posture']);
                $isTimeBased = false;
            }
            if (preg_match('/(plank|hold|hollow body)/i', $name)) {
                $goals = array_merge($goals, ['Weight Maintenance', 'Improve posture']);
                $isTimeBased = true;
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
            if ($isTimeBased) {
                $dur = in_array('Cardio', $goals) ? '10m' : '30s';
                $defaultSets = [
                    ['set' => 1, 'duration' => $dur],
                    ['set' => 2, 'duration' => $dur],
                    ['set' => 3, 'duration' => $dur],
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
            $exercise->is_time_based = $isTimeBased;
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
