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
            $query->where('muscle_group_id', $request->muscle_group_id);
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

        $exercises = $query->paginate(10);

        return response()->json([
            'status' => true,
            'message' => 'Exercises fetched successfully',
            'data' => $exercises
        ]);
    }

    public function muscleGroups()
    {
        $muscleGroups = MuscleGroup::paginate(10);

        return response()->json([
            'status' => true,
            'message' => 'Muscle Groups fetched successfully',
            'data' => $muscleGroups
        ]);
    }
}
