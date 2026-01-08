<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Excercise;

class ExerciseController extends Controller
{
    public function show($id)
    {
        $exercise = Excercise::find($id);

        if (!$exercise) {
            return response()->json(['status' => 'error', 'message' => 'Exercise not found'], 404);
        }

        return response()->json(['status' => 'success', 'data' => $exercise], 200);
    }

    public function store_exercise(Request $request)
    {
        $validation = \Validator::make($request->all(), [
            'exercise_nutrihaven_exercise_id' => 'required|integer',
            'exercise_workout_exercise_id' => 'required|integer',
            'exercise_repetitions' => 'required|integer',
        ]);

        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()], 422);
        }

        $user_id = auth('sanctum')->id();

        $exercise = new Excercise();
        $exercise->exercise_nutrihaven_exercise_id = $request->input('exercise_nutrihaven_exercise_id');
        $exercise->exercise_workout_exercise_id = $request->input('exercise_workout_exercise_id');
        $exercise->exercise_repetitions = $request->input('exercise_repetitions');
        $exercise->save();

        return response()->json(['status' => 'success', 'message' => 'Exercise added successfully', 'data' => $exercise], 201);
    }
}
