<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Muscle;

class MuscleController extends Controller
{
    public function store_muscle(Request $request)
    {
        $validate = \Validator::make(
            $request->all(),
            [
                'muscle_name' => 'required|string|max:255',
                'muscle_image' => 'required|image',
            ]
        );

        if($validate->fails()) {
            flash()->error($validate->errors()->first());
            return redirect()->back();
        }
        
        $muscle = new Muscle();
        $muscle->muscle_name = $request->muscle_name;
        $file = $request->file('muscle_image');
        if ($file && $file->isValid()) {
            try {
                $uploadedFile = cloudinary()->uploadApi()->upload($file->getRealPath(), [
                    'resource_type' => 'image',
                    'chunk_size' => 6000000,
                    'folder' => 'muscle_images'
                ]);
                $uploadedFileUrl = $uploadedFile['secure_url'];
                $displayName = $uploadedFile['public_id'];
                $muscle->muscle_image = $uploadedFileUrl;
            } catch (\Exception $e) {
                flash()->error('Image upload failed: ' . $e->getMessage());
                return redirect()->back();
            }
        } else {
            flash()->error('Invalid image file.');
            return redirect()->back();
        }
        $muscle->save();

        flash()->success('Muscle added successfully');
        return redirect()->back();
    }
}
