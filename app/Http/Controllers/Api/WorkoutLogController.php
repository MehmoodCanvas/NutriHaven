<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WorkoutLog;
use App\Models\WorkoutPlan;
use App\Models\WorkoutLogExercise;
use App\Models\WorkoutLogExerciseSet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class WorkoutLogController extends Controller
{
    /**
     * Helper: format a number to max 2 decimal places, safe for json_encode on any server.
     */
    private function fmt($value, $decimals = 2)
    {
        return (float) number_format((float) $value, $decimals, '.', '');
    }

    /**
     * Store a new workout log (with exercises and sets).
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'nullable|string|max:255',
                'workout_plan_id' => 'required|exists:workout_plans,id',
                'start_time' => 'required|date',
                'end_time' => 'required|date',
                'log_date' => 'required|date',
                'exercises' => 'nullable|array',
                'exercises.*.master_exercise_id' => 'required|exists:master_exercises,id',
                'exercises.*.sets' => 'nullable|array',
                'exercises.*.sets.*.reps' => 'nullable|integer|min:1',
                'exercises.*.sets.*.weight' => 'nullable|numeric|min:0',
                'exercises.*.sets.*.duration' => 'nullable|string|max:20',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $user = Auth::user();

            // Auto-fill name from workout plan
            $plan_id = $request->workout_plan_id;
            $plan = WorkoutPlan::where('id', $plan_id)->first();
            $logName = $request->name ?: ($plan ? $plan->name : 'Workout');

            DB::beginTransaction();

            $log = WorkoutLog::create([
                'member_id' => $user->member_id,
                'workout_plan_id' => $plan_id,
                'name' => $logName,
                'start_time' => Carbon::parse($request->start_time),
                'end_time' => Carbon::parse($request->end_time),
                'log_date' => $request->log_date,
            ]);

            if ($request->has('exercises') && is_array($request->exercises)) {
                foreach ($request->exercises as $exerciseData) {
                    $workoutLogExercise = WorkoutLogExercise::create([
                        'workout_log_id' => $log->id,
                        'master_exercise_id' => $exerciseData['master_exercise_id'],
                    ]);

                    if (isset($exerciseData['sets']) && is_array($exerciseData['sets'])) {
                        foreach ($exerciseData['sets'] as $index => $setData) {
                            WorkoutLogExerciseSet::create([
                                'workout_log_exercise_id' => $workoutLogExercise->id,
                                'set_number' => $index + 1,
                                'reps' => $setData['reps'] ?? null,
                                'weight' => $setData['weight'] ?? null,
                                'duration' => $setData['duration'] ?? null,
                            ]);
                        }
                    }
                }
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Workout log saved successfully',
                'data' => $log->load('exercises.masterExercise', 'exercises.sets')
            ], 201);

        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while saving the workout log',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Get Paginated Workout History
     */
    public function history(Request $request)
    {
        try {
            $user = Auth::user();
            $perPage = $request->get('per_page', 10);

            $query = WorkoutLog::with([
                'exercises.masterExercise.muscleGroup',
                'exercises.sets',
                'workoutPlan'
            ])->where('member_id', $user->member_id);

            // Filter by name
            if ($request->filled('name')) {
                $query->where('name', 'like', '%' . $request->name . '%');
            }

            // Filter by date range
            if ($request->filled('start_date') && $request->filled('end_date')) {
                $query->whereBetween('log_date', [$request->start_date, $request->end_date]);
            } elseif ($request->filled('start_date')) {
                $query->where('log_date', '>=', $request->start_date);
            } elseif ($request->filled('end_date')) {
                $query->where('log_date', '<=', $request->end_date);
            }

            $logs = $query->orderBy('log_date', 'desc')
                ->orderBy('start_time', 'desc')
                ->paginate($perPage);

            $formattedLogs = $logs->map(function ($log) {
                $durationInMinutes = $this->fmt(Carbon::parse($log->start_time)->diffInMinutes(Carbon::parse($log->end_time)));
                
                $muscles = collect();
                $formattedExercises = $log->exercises->map(function ($exercise) use (&$muscles) {
                    if ($exercise->masterExercise && $exercise->masterExercise->muscleGroup) {
                        $muscles->push($exercise->masterExercise->muscleGroup->name);
                    }
                    
                    $isTimeBased = $exercise->masterExercise->is_time_based ?? false;
                    $totalSets = $exercise->sets->count();

                    if ($isTimeBased) {
                        $durations = $exercise->sets->pluck('duration')->filter()->implode(', ');
                        return [
                            'name' => $exercise->masterExercise->name ?? 'Unknown Exercise',
                            'is_time_based' => true,
                            'sets_summary' => "{$totalSets} sets",
                            'duration_detail' => $durations ?: null,
                            'max_weight' => null,
                        ];
                    } else {
                        $maxReps = $exercise->sets->max('reps');
                        $maxWeight = $exercise->sets->max('weight');
                        $maxWeight = $maxWeight !== null ? $this->fmt($maxWeight) : null;
                        return [
                            'name' => $exercise->masterExercise->name ?? 'Unknown Exercise',
                            'is_time_based' => false,
                            'sets_summary' => "{$totalSets} sets • {$maxReps} max reps",
                            'duration_detail' => null,
                            'max_weight' => $maxWeight ? "{$maxWeight} " : null,
                        ];
                    }
                });

                // Build exercises_data from log exercises (not original plan)
                // so "Repeat this workout" uses the actual logged exercises
                $logExercisesData = $log->exercises->map(function ($exercise) {
                    $masterExercise = $exercise->masterExercise;
                    $muscleGroup = $masterExercise ? $masterExercise->muscleGroup : null;
                    return [
                        'id' => $masterExercise->id ?? null,
                        'name' => $masterExercise->name ?? 'Unknown Exercise',
                        'is_time_based' => $masterExercise->is_time_based ?? false,
                        'difficulty' => $masterExercise->difficulty ?? null,
                        'muscle_group_id' => $masterExercise->muscle_group_id ?? null,
                        'primary_muscles' => is_array($masterExercise->primary_muscles) ? implode(', ', $masterExercise->primary_muscles) : ($masterExercise->primary_muscles ?? null),
                        'secondary_muscles' => is_array($masterExercise->secondary_muscles) ? implode(', ', $masterExercise->secondary_muscles) : ($masterExercise->secondary_muscles ?? null),
                        'goals' => $masterExercise->goals ?? [],
                        'duration_minutes' => $masterExercise->duration_minutes ?? null,
                        'default_sets' => $exercise->sets->map(function ($set) {
                            return [
                                'set' => $set->set_number,
                                'reps' => $set->reps,
                                'weight' => $set->weight !== null ? (float) number_format((float) $set->weight, 2, '.', '') : null,
                                'duration' => $set->duration,
                                'is_completed' => false,
                            ];
                        })->values()->toArray(),
                        'workout_video_id' => $masterExercise->workout_video_id ?? null,
                        'equipment_required_id' => $masterExercise->equipment_required_id ?? null,
                        'aux_equipment_id' => $masterExercise->aux_equipment_id ?? null,
                        'exercise_image' => $masterExercise->exercise_image ?? null,
                        'created_at' => $masterExercise->created_at ?? null,
                        'updated_at' => $masterExercise->updated_at ?? null,
                        'muscle_group' => $muscleGroup ? [
                            'id' => $muscleGroup->id,
                            'name' => $muscleGroup->name,
                            'muscle_image' => $muscleGroup->muscle_image ?? null,
                            'created_at' => $muscleGroup->created_at,
                            'updated_at' => $muscleGroup->updated_at,
                        ] : null,
                    ];
                })->values()->toArray();

                // Override workout_plan exercises_data with log exercises
                $workoutPlan = $log->workoutPlan;
                if ($workoutPlan) {
                    $workoutPlan = $workoutPlan->toArray();
                    $originalExercisesData = $workoutPlan['exercises_data'] ?? [];
                    // Preserve original structure (filters, etc.) but replace exercises with log exercises
                    if (is_array($originalExercisesData) && isset($originalExercisesData['exercises'])) {
                        $originalExercisesData['exercises'] = $logExercisesData;
                        $originalExercisesData['total'] = count($logExercisesData);
                    } else {
                        $originalExercisesData = [
                            'exercises' => $logExercisesData,
                            'total' => count($logExercisesData),
                        ];
                    }
                    $workoutPlan['exercises_data'] = $originalExercisesData;
                }

                return [
                    'id' => $log->id,
                    'workout_plan' => $workoutPlan,
                    'name' => $log->name ?? 'Workout',
                    'date' => Carbon::parse($log->log_date)->format('M d, Y'),
                    'duration' => "{$durationInMinutes} min",
                    'muscles_trained' => $muscles->unique()->implode(', '),
                    'exercises' => $formattedExercises
                ];
            });

            return response()->json([
                'status' => true,
                'message' => 'Workout history retrieved',
                'data' => [
                    'items' => $formattedLogs,
                    'pagination' => [
                        'total' => $logs->total(),
                        'current_page' => $logs->currentPage(),
                        'last_page' => $logs->lastPage()
                    ]
                ]
            ], 200);

        } catch (\Throwable $th) {
            Log::error('Workout history error: ' . $th->getMessage(), [
                'file' => $th->getFile(),
                'line' => $th->getLine(),
                'trace' => $th->getTraceAsString()
            ]);
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while retrieving history',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Get Workout Insights (Stats and Charts)
     */
    public function insights(Request $request)
    {
        try {
            // Fix floating-point serialization on servers with high serialize_precision
            ini_set('serialize_precision', -1);

            $user = Auth::user();
            $memberId = $user->member_id;

            $now = Carbon::now();
            $startOfWeek = $now->copy()->startOfWeek();
            $endOfWeek = $now->copy()->endOfWeek();
            
            // 1. Workouts This Week
            $weeklyLogs = WorkoutLog::where('member_id', $memberId)
                ->whereBetween('log_date', [$startOfWeek->format('Y-m-d'), $endOfWeek->format('Y-m-d')])
                ->get();
            
            $workoutsThisWeek = $weeklyLogs->count();

            // 2. Total Time This Week
            $totalMinutesThisWeek = 0;
            foreach ($weeklyLogs as $log) {
                if ($log->start_time && $log->end_time) {
                    $totalMinutesThisWeek += Carbon::parse($log->start_time)->diffInMinutes(Carbon::parse($log->end_time));
                }
            }
            $hours = floor($totalMinutesThisWeek / 60);
            $minutes = $totalMinutesThisWeek % 60;
            $totalTimeThisWeek = "{$hours}h {$minutes}m";

            // 3. Avg Duration (last 30 days vs previous 30 days)
            $last30Days = $now->copy()->subDays(30);
            $recentLogs = WorkoutLog::where('member_id', $memberId)
                ->where('log_date', '>=', $last30Days->format('Y-m-d'))
                ->get();
            
            $totalDuration30Days = 0;
            foreach ($recentLogs as $log) {
                if ($log->start_time && $log->end_time) {
                    $totalDuration30Days += Carbon::parse($log->start_time)->diffInMinutes(Carbon::parse($log->end_time));
                }
            }
            $avgDuration = $recentLogs->count() > 0 ? $this->fmt($totalDuration30Days / $recentLogs->count()) : 0;

            // Previous 30 days (day 31 to day 60) for comparison
            $prev30Start = $now->copy()->subDays(60);
            $prev30End = $now->copy()->subDays(31);
            $prevLogs = WorkoutLog::where('member_id', $memberId)
                ->whereBetween('log_date', [$prev30Start->format('Y-m-d'), $prev30End->format('Y-m-d')])
                ->get();

            $prevTotalDuration = 0;
            foreach ($prevLogs as $log) {
                if ($log->start_time && $log->end_time) {
                    $prevTotalDuration += Carbon::parse($log->start_time)->diffInMinutes(Carbon::parse($log->end_time));
                }
            }
            $prevAvgDuration = $prevLogs->count() > 0 ? $this->fmt($prevTotalDuration / $prevLogs->count()) : 0;

            // Calculate percentage change
            $avgDurationChange = 0;
            if ($prevAvgDuration > 0) {
                $avgDurationChange = $this->fmt((($avgDuration - $prevAvgDuration) / $prevAvgDuration) * 100);
            }

            // 4. Weekly Activity Chart (last 7 days duration)
            $weeklyActivity = [];
            for ($i = 6; $i >= 0; $i--) {
                $day = $now->copy()->subDays($i);
                $dayStr = $day->format('Y-m-d');
                
                $dayDuration = 0;
                foreach ($recentLogs as $log) {
                    $logDateStr = $log->log_date instanceof Carbon ? $log->log_date->format('Y-m-d') : $log->log_date;
                    if ($logDateStr === $dayStr && $log->start_time && $log->end_time) {
                        $dayDuration += Carbon::parse($log->start_time)->diffInMinutes(Carbon::parse($log->end_time));
                    }
                }
                
                $weeklyActivity[] = [
                    'label' => substr($day->format('D'), 0, 3), // Mon, Tue, Wed...
                    'count' => $this->fmt($dayDuration)
                ];
            }

            // 5. Most Trained Muscle (This month)
            $startOfMonth = $now->copy()->startOfMonth();
            $mostTrained = DB::table('workout_log_exercises')
                ->join('workout_logs', 'workout_log_exercises.workout_log_id', '=', 'workout_logs.id')
                ->join('master_exercises', 'workout_log_exercises.master_exercise_id', '=', 'master_exercises.id')
                ->join('muscle_groups', 'master_exercises.muscle_group_id', '=', 'muscle_groups.id')
                ->where('workout_logs.member_id', $memberId)
                ->where('workout_logs.log_date', '>=', $startOfMonth->format('Y-m-d'))
                ->select('muscle_groups.name', DB::raw('COUNT(workout_log_exercises.id) as sessions'))
                ->groupBy('muscle_groups.id', 'muscle_groups.name')
                ->orderByDesc('sessions')
                ->first();

            $mostTrainedData = null;
            if ($mostTrained) {
                $mostTrainedData = [
                    'muscle' => $mostTrained->name,
                    'sessions' => $mostTrained->sessions
                ];
            }

            // 6. Monthly Activity (Jan-Dec workout count per month for current year)
            $currentYear = $now->year;
            $monthlyRaw = WorkoutLog::where('member_id', $memberId)
                ->whereYear('log_date', $currentYear)
                ->selectRaw('MONTH(log_date) as month, COUNT(*) as workouts')
                ->groupByRaw('MONTH(log_date)')
                ->pluck('workouts', 'month');

            $monthlyActivity = [];
            $monthLabels = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
            for ($m = 1; $m <= 12; $m++) {
                $monthlyActivity[] = [
                    'label' => $monthLabels[$m - 1],
                    'count' => $this->fmt($monthlyRaw[$m] ?? 0),
                ];
            }

            // 7. Workout Length (daily duration for last 30 days)
            $workoutLength = [];
            for ($d = 29; $d >= 0; $d--) {
                $date = $now->copy()->subDays($d);
                $dateStr = $date->format('Y-m-d');
                
                $dayDuration = 0;
                foreach ($recentLogs as $log) {
                    $logDateStr = $log->log_date instanceof Carbon ? $log->log_date->format('Y-m-d') : $log->log_date;
                    if ($logDateStr === $dateStr && $log->start_time && $log->end_time) {
                        $dayDuration += Carbon::parse($log->start_time)->diffInMinutes(Carbon::parse($log->end_time));
                    }
                }

                $workoutLength[] = [
                    'label' => (int) $date->format('d'),
                    'duration' => $this->fmt($dayDuration),
                ];
            }

            // 8. Streak Calculation
            $streak = 0;
            $checkDate = $now->copy();
            while (true) {
                $hasWorkout = WorkoutLog::where('member_id', $memberId)
                    ->where('log_date', $checkDate->format('Y-m-d'))
                    ->exists();
                if ($hasWorkout) {
                    $streak++;
                    $checkDate->subDay();
                } else {
                    break;
                }
            }

            return response()->json([
                'status' => true,
                'data' => [
                    'workouts_this_week' => $workoutsThisWeek,
                    'total_time' => $totalTimeThisWeek,
                    'average' => ['duration' => $avgDuration, 'duration_change' => $avgDurationChange],
                    'most_trained' => $mostTrainedData,
                    'streak' => "{$streak} Days",
                    'weekly_activity' => $weeklyActivity,
                    'monthly_activity' => $monthlyActivity,
                    'workout_length' => $workoutLength
                ]
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while retrieving insights',
                'error' => $th->getMessage()
            ], 500);
        }
    }
}
