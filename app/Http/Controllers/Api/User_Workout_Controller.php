<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User_workout;
class User_Workout_Controller extends Controller
{
    public function store_user_workout(Request $request){
        $validation = \Validator::make($request->all(), [
            'user_workout_total_time' => 'required',
        ]);
        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()], 422);
        }
        $user_id =auth('sanctum')->id();
        $user_workout = new User_workout();
        $user_workout->user_workout_member_id = $user_id;
        $user_workout->user_workout_total_time = $request->input('user_workout_total_time');
        $user_workout->save();
        return response()->json(['status'=>'success', 'message' => 'User Workout added successfully'], 201);
        
    }
}
