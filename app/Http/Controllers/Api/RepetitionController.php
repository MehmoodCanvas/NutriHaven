<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Repetition;
use Illuminate\Support\Facades\Validator;

class RepetitionController extends Controller
{

    public function store_repetition(Request $request)
    {

       $validation = Validator::make($request->all(), [
            'repetition_excerise_id' => 'required|integer',
            'repetition_user_workout_id' => 'required|integer',
            'repetition_time' => 'required',
            'repetition_completed' => 'nullable',
        ]);

        if ($validation->fails()) {
            return response()->json(['errors' => $validation->errors()], 422);
        }

        $repetition = new Repetition();
        $repetition->repetition_excerise_id = $request->input('repetition_excerise_id');
        $repetition->repetition_user_workout_id = $request->input('repetition_user_workout_id');
        $repetition->repetition_time = $request->input('repetition_time');
        $repetition->repetition_completed = $request->input('repetition_completed');
        $repetition->save();
        return response()->json(['status'=>'success', 'message' => 'Repetition added successfully'], 201);

    }

}
