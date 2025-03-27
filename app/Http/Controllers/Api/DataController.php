<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Workout_videos;
use App\Models\Category;


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
                    'videos' => $videos,
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
            'category' => $category,
        ], 200);
    }
}
