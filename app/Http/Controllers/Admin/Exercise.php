<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Nutrihaven_Exercise;
class Exercise extends Controller
{
    public function store_exercise(Request $request)
    {
        $validate = \Validator::make(
            $request->all(),
            [
                'nutrihaven_exercise_name' => 'required|string|max:255',
                'nutrihaven_exercise_instructions' => 'required|string',
                'file' => 'required|file|mimes:mp4,mov,avi,wmv|', 
            ]
        );

        if($validate->fails()) {
            flash()->error($validate->errors()->first());
            return redirect()->back();
        }
        $exercise = new Nutrihaven_Exercise();
        $exercise->nutrihaven_exercise_name = $request->nutrihaven_exercise_name;
        $exercise->nutrihaven_exercise_instructions = $request->nutrihaven_exercise_instructions;
        $file = $request->file('file');
        $uploadedFile = cloudinary()->uploadApi()->upload($file->getRealPath(), [
            'resource_type' => 'video',
            'chunk_size' => 6000000,
            'folder' => 'exercise'
        ]);
        $uploadedFileUrl = $uploadedFile['secure_url'];
        $displayName =$uploadedFile['public_id'];
        $exercise->nutrihaven_exercise_video_url= $uploadedFileUrl;
        $exercise->save();
        flash()->success('Exercise added successfully');
        return redirect()->back();
    }
}
