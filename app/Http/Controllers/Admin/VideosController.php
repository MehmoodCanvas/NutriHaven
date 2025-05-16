<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Workout_videos;
use App\Models\Category;


class VideosController extends Controller
{
    public function add_workout_video(Request $request)
    {
     if($request->hasFile('file')){
        $video = new Workout_videos();
        $file = $request->file('file');
      
        $uploadedFile = cloudinary()->uploadApi()->upload($file->getRealPath(), [
            'resource_type' => 'video',
            'chunk_size' => 6000000,
            'folder' => 'videos'
        ]);
        $uploadedFileUrl = $uploadedFile['secure_url'];
        $displayName =$uploadedFile['public_id'];

        $video->workout_videos_description = $request->workout_videos_description;
        $video->workout_videos_title = $request->workout_videos_title;
        $video->workout_videos_cdn_url = $uploadedFileUrl;
        $video->workout_videos_category_id = $request->workout_videos_category_id;
        $video->save();
        return back()     
            ->with('success','Video added successfully');
        } else {
            return back()     
            ->with('error','Error adding video');
        }
    }


    public function store_category(Request $request){
        $category = new Category();
        $category->category_name = $request->category_name;
        $category->category_description = $request->category_description;
        $file = $request->file('file');
        $uploadedFile = cloudinary()->uploadApi()->upload($file->getRealPath(), [
            'resource_type' => 'image',
            'chunk_size' => 6000000,
            'folder' => 'categories'
        ]);
        $uploadedFileUrl = $uploadedFile['secure_url'];
        $displayName =$uploadedFile['public_id'];
        $category->category_image = $uploadedFileUrl;
        
        $category->save();

        dd($uploadedFile);
        return back()     
            ->with('success','Category added successfully');
    }
}
