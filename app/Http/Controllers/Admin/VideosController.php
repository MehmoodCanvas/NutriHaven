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

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $uploadedFile = cloudinary()->uploadApi()->upload($file->getRealPath(), [
                'resource_type' => 'image',
                'chunk_size' => 6000000,
                'folder' => 'categories'
            ]);
            $category->category_image = $uploadedFile['secure_url'];
        }
        
        $category->save();

        return back()->with('success','Category added successfully');
    }

    public function update_category(Request $request, $id){
        $category = Category::findOrFail($id);
        $category->category_name = $request->category_name;
        $category->category_description = $request->category_description;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $uploadedFile = cloudinary()->uploadApi()->upload($file->getRealPath(), [
                'resource_type' => 'image',
                'chunk_size' => 6000000,
                'folder' => 'categories'
            ]);
            $category->category_image = $uploadedFile['secure_url'];
        }
        
        $category->save();

        return back()->with('success','Category updated successfully');
    }

    public function delete_category($id){
        $category = Category::findOrFail($id);
        $category->delete();
        return back()->with('success','Category deleted successfully');
    }

    public function update_video(Request $request, $id){
        $video = Workout_videos::findOrFail($id);
        $video->workout_videos_title = $request->workout_videos_title;
        $video->workout_videos_description = $request->workout_videos_description;
        $video->workout_videos_category_id = $request->workout_videos_category_id;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $uploadedFile = cloudinary()->uploadApi()->upload($file->getRealPath(), [
                'resource_type' => 'video',
                'chunk_size' => 6000000,
                'folder' => 'videos'
            ]);
            $video->workout_videos_cdn_url = $uploadedFile['secure_url'];
        }
        
        $video->save();

        return back()->with('success','Video updated successfully');
    }

    public function delete_video($id){
        $video = Workout_videos::findOrFail($id);
        $video->delete();
        return back()->with('success','Video deleted successfully');
    }
}
