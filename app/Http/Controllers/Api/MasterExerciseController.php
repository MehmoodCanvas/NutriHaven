<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MasterExercise;
use App\Models\MuscleGroup;

class MasterExerciseController extends Controller
{
    public function index(Request $request)
    {
        $query = MasterExercise::with(['muscleGroup', 'equipmentRequired', 'auxEquipment', 'workoutVideo']);

        // Comprehensive Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('primary_muscles', 'LIKE', "%{$search}%")
                  ->orWhere('secondary_muscles', 'LIKE', "%{$search}%")
                  ->orWhere('difficulty', 'LIKE', "%{$search}%")
                  ->orWhereJsonContains('goals', $search)
                  // Search in Muscle Group Name
                  ->orWhereHas('muscleGroup', function ($sub) use ($search) {
                      $sub->where('name', 'LIKE', "%{$search}%");
                  })
                  // Search in Equipment Name
                  ->orWhereHas('equipmentRequired', function ($sub) use ($search) {
                      $sub->where('name', 'LIKE', "%{$search}%");
                  })
                  // Search in Aux Equipment Name
                  ->orWhereHas('auxEquipment', function ($sub) use ($search) {
                      $sub->where('name', 'LIKE', "%{$search}%");
                  });
            });
        }

        // Filter by Muscle Group ID(s)
        if ($request->has('muscle_group_id')) {
            $muscleGroupIds = $request->muscle_group_id;
            
            if (is_string($muscleGroupIds) && str_contains($muscleGroupIds, ',')) {
                $muscleGroupIds = explode(',', $muscleGroupIds);
            }
            
            if (is_array($muscleGroupIds)) {
                $query->whereIn('muscle_group_id', $muscleGroupIds);
            } else {
                $query->where('muscle_group_id', $muscleGroupIds);
            }
        }

        if ($request->has('goal')) {
            $query->whereJsonContains('goals', $request->goal);
        }

        if ($request->has('difficulty')) {
            // Cumulative difficulty: higher levels include all lower-level exercises
            $difficultyMap = [
                'Beginner'     => ['Beginner'],
                'Intermediate' => ['Beginner', 'Intermediate'],
                'Advanced'     => ['Beginner', 'Intermediate', 'Advanced'],
            ];

            $levels = $difficultyMap[$request->difficulty] ?? [$request->difficulty];
            $query->whereIn('difficulty', $levels);
        }

        // Sorting
        $sort = $request->get('sort', 'a-z');
        switch ($sort) {
            case 'z-a':
                $query->orderBy('name', 'desc');
                break;
            case 'latest':
                $query->latest();
                break;
            case 'a-z':
            default:
                $query->orderBy('name', 'asc');
                break;
        }

        $perPage = $request->get('per_page', 20);

        $exercises = $query->paginate($perPage);

        return response()->json([
            'status' => true,
            'message' => 'Exercises fetched successfully',
            'data' => $exercises
        ]);
    }

    public function muscleGroups(Request $request)
    {
        $query = MuscleGroup::query();

        // Search by name
        if ($request->has('search')) {
            $query->where('name', 'LIKE', "%{$request->search}%");
        }

        // Filter by Category (Chest, Arms, Shoulders, Legs, Back, Core, Cardio, Fresh Muscles)
        if ($request->has('targeted_muscles')) {
            $category = strtolower($request->targeted_muscles);
            $mapping = [
                'chest'         => [5],                // CHEST
                'arms'          => [3, 6, 11],         // BICEPS, FOREARMS, TRICEPS
                'shoulders'     => [9],                // SHOULDERS
                'legs'          => [7],                // LEGS & GLUTES
                'back'          => [2],                // BACK
                'core'          => [1],                // ABS & CORE
                'cardio'        => [4],                // CARDIO
                'fresh muscles' => [1, 2, 3, 5, 6, 7, 9, 11], // All major groups
            ];

            if (isset($mapping[$category])) {
                $query->whereIn('id', $mapping[$category]);
            }
        }

        $perPage = $request->get('per_page', 20);
        $muscleGroups = $query->paginate($perPage);

        return response()->json([
            'status' => true,
            'message' => 'Muscle Groups fetched successfully',
            'data' => $muscleGroups
        ]);
    }
}
