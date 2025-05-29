<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Workout_videos;
use App\Models\Category;
use App\Models\Muscle;
use App\Models\Nutrihaven_Exercise;



class DataController extends Controller
{
    public function workout_videos(Request $request){
        if (request()->has('q')) {
            $category_id = request()->input('q');
            $videos = Workout_videos::where('workout_videos_category_id', $category_id)
                ->join('category','category.category_id','=','workout_videos.workout_videos_category_id')
                ->get();
                return response()->json([
                    'status' => 'success',
                    'data' => $videos,
                ], 200);
        }
       
        else {
            return response()->json([
                'status' => 'error',
                'message' => 'Category ID is required',
            ], 400);
        }
       
    }

    public function category(){
        $category = Category::all();
        return response()->json([
            'status' => 'success',
            'data' => $category,
        ], 200);
    }


    public function muscle(){
        $muscle = Muscle::all();
        if($muscle->isEmpty()){
            return response()->json([
                'status' => 'error',
                'message' => 'No muscle data found',
            ], 204);
        } else {
            return response()->json([
                'status' => 'success',
                'data' => $muscle,
            ], 200);
        }
    }
     public function nutriheaven_exercise(){
        $exercise = Nutrihaven_Exercise::all();
        if($exercise->isEmpty()){
            return response()->json([
                'status' => 'error',
                'message' => 'No exercise data found',
            ], 204);
        } else {
            return response()->json([
                'status' => 'success',
                'data' => $exercise,
            ], 200);
        }
    }

}
