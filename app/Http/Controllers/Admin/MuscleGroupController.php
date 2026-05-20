<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MuscleGroup;

class MuscleGroupController extends Controller
{
    public function index()
    {
        $muscleGroups = MuscleGroup::orderBy('id', 'DESC')->get();
        return view('admin.muscle-groups', compact('muscleGroups'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:muscle_groups,name',
            'muscle_image' => 'nullable|image|max:5120',
        ]);

        $muscleGroup = new MuscleGroup();
        $muscleGroup->name = $request->name;

        if ($request->hasFile('muscle_image') && $request->file('muscle_image')->isValid()) {
            try {
                $uploadedFile = cloudinary()->uploadApi()->upload($request->file('muscle_image')->getRealPath(), [
                    'resource_type' => 'image',
                    'chunk_size' => 6000000,
                    'folder' => 'muscle_groups'
                ]);
                $muscleGroup->muscle_image = $uploadedFile['secure_url'];
            } catch (\Exception $e) {
                flash()->error('Image upload failed: ' . $e->getMessage());
                return redirect()->back();
            }
        }

        $muscleGroup->save();
        flash()->success('Muscle Group created successfully!');
        return redirect()->back();
    }

    public function edit($id)
    {
        $muscleGroup = MuscleGroup::findOrFail($id);
        return view('admin.muscle-group-edit', compact('muscleGroup'));
    }

    public function update(Request $request, $id)
    {
        $muscleGroup = MuscleGroup::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:muscle_groups,name,' . $id,
            'muscle_image' => 'nullable|image|max:5120',
        ]);

        $muscleGroup->name = $request->name;

        if ($request->hasFile('muscle_image') && $request->file('muscle_image')->isValid()) {
            try {
                $uploadedFile = cloudinary()->uploadApi()->upload($request->file('muscle_image')->getRealPath(), [
                    'resource_type' => 'image',
                    'chunk_size' => 6000000,
                    'folder' => 'muscle_groups'
                ]);
                $muscleGroup->muscle_image = $uploadedFile['secure_url'];
            } catch (\Exception $e) {
                flash()->error('Image upload failed: ' . $e->getMessage());
                return redirect()->back();
            }
        }

        $muscleGroup->save();
        flash()->success('Muscle Group updated successfully!');
        return redirect('admin/muscle-groups');
    }

    public function destroy($id)
    {
        $muscleGroup = MuscleGroup::findOrFail($id);
        $muscleGroup->delete();
        flash()->success('Muscle Group deleted successfully!');
        return redirect()->back();
    }
}
