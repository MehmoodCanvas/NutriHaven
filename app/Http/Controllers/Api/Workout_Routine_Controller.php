<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\Models\Workout_Routine;
class Workout_Routine_Controller extends Controller
{
    public function store_routine(Request $request){
        $validate = \Validator::make($request->all(), [
            'workout_routine_name' => 'required|string|max:255',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => 400,
                'message' => $validate->errors()
            ], 400);
        }

        $user_id = auth('sanctum')->id();
        $workout_routine = new Workout_Routine(); 
        $workout_routine->workout_routine_name = $request->workout_routine_name;
        $workout_routine->save();
        return response()->json([
            'status' => 200,
            'message' => 'Workout Routine Created Successfully',
            'data' => $workout_routine
        ],200);
    }
}
