<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Workout_videos;

class DataController extends Controller
{
    public function workout_videos(){
        $videos = Workout_videos::join('category','category.category_id','=','workout_videos.workout_videos_category_id')->get();
        return response()->json([
            'status' => 'success',
            'videos' => $videos,
        ], 200);
    }
}
