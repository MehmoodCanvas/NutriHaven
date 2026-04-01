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
        $query = MasterExercise::with(['muscleGroup', 'equipmentRequired', 'auxEquipment']);

        if ($request->has('muscle_group_id')) {
            $muscleGroupIds = $request->muscle_group_id;
            
            // If it's a comma-separated string, convert it to an array
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

        if ($request->has('duration_minutes')) {
            $query->where('duration_minutes', $request->duration_minutes);
        }

        if ($request->has('difficulty')) {
            $query->where('difficulty', $request->difficulty);
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
        $perPage = $request->get('per_page', 20);
        $muscleGroups = MuscleGroup::paginate($perPage);

        return response()->json([
            'status' => true,
            'message' => 'Muscle Groups fetched successfully',
            'data' => $muscleGroups
        ]);
    }
}
