<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Excerise_Muscle;
use App\Models\Excercise;

class Exercise_Muscle_Controller extends Controller
{
    public function store_exercise_muscle(Request $request)
    {

        $validation = \Validator::make($request->all(), [
            'exercise_id' => 'required|integer',
            'muscle_id' => 'required|integer',
        ]);

        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()], 422);
        }

        if (!Excercise::where('exercise_id', $request->input('exercise_id'))->exists()) {
            return response()->json(['error' => 'Invalid exercise_id'], 422);
        }

        if (!\App\Models\Muscle::where('muscle_id', $request->input('muscle_id'))->exists()) {
            return response()->json(['error' => 'Invalid muscle_id'], 422);
        }

        $user_id = auth('sanctum')->id();

        $exerciseMuscle = new Excerise_Muscle();
        $exerciseMuscle->exercise_muscle_exercise_id = $request->input('exercise_id');
        $exerciseMuscle->exercise_muscle_muscle_id = $request->input('muscle_id');
        $exerciseMuscle->exercise_muscle_member_id = $user_id;
        $exerciseMuscle->save();

        return response()->json(['status' => 'success', 'message' => 'Exercise muscle added successfully'], 201);

    }
}
