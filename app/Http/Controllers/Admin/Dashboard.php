<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Workout_videos;
use App\Models\Category;
use App\Models\Nutrihaven_excerise;


class Dashboard extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function videos()
    {
            $videos = Workout_videos::join('category','category.category_id','=','workout_videos.workout_videos_category_id')->get();
            $categories = Category::all();
            return view('admin.videos', compact('videos','categories'));
        
    }

    public function categories()
    {
            $categories = Category::all();
            return view('admin.categories',compact('categories'));
      
    }

    public function exercise(){

        $exercises = Nutrihaven_excerise::orderBy('nutrihaven_exercise_id','DESC')->get();
        return view('admin.exercise', compact('exercises'));

    }

}
