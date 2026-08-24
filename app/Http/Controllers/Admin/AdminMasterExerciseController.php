<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MasterExercise;
use App\Models\MuscleGroup;
use App\Models\Equipment;
use App\Models\AuxEquipment;
use App\Models\Workout_videos;

class AdminMasterExerciseController extends Controller
{
    /**
     * All available goal options
     */
    private static function goalOptions()
    {
        return [
            'Bodybuilding',
            'Weight Maintenance',
            'Weight Loss',
            'Cardio',
            'Flexibility',
            'Improve Mobility',
            'Improve posture',
            'Increase energy levels',
            'Stress Relief',
            'Rehab',
        ];
    }

    /**
     * All available muscle options (extracted from DB)
     */
    private static function muscleOptions()
    {
        return [
            'Abdominals', 'Achilles Tendon', 'Adductors', 'Anconeus', 'Ankle Flexors',
            'Anterior Deltoids', 'Biceps', 'Biceps Brachii', 'Biceps Brachii (Long Head)',
            'Biceps Brachii (Short Head)', 'Brachialis', 'Brachioradialis', 'Calves', 'Core',
            'Deltoids', 'Erector Spinae', 'Extensor Digitorum', 'External Rotators',
            'Forearm Extensors', 'Forearm Flexors', 'Gastrocnemius', 'Glutes',
            'Glutes (Gluteus Maximus)', 'Gluteus Maximus', 'Gluteus Medius',
            'Hamstrings', 'Hip Abductors', 'Hip Extensors', 'Hip External Rotators',
            'Hip Flexors', 'Iliacus', 'Infraspinatus', 'Latissimus Dorsi', 'Lats',
            'Levator Scapulae', 'Lower Pectorals', 'Lower Trapezius', 'Medial Deltoids',
            'Multifidi', 'Obliques', 'Pectorals', 'Piriformis', 'Psoas', 'Quadriceps',
            'Rear Deltoids', 'Rectus Abdominis', 'Rectus Femoris', 'Rhomboids',
            'Serratus Anterior', 'Soleus', 'Supraspinatus', 'Tensor Fasciae Latae',
            'Teres Major', 'Teres Minor', 'Tibialis Anterior', 'Tibialis Posterior',
            'Transverse Abdominis', 'Trapezius', 'Triceps', 'Triceps (Long Head)',
            'Upper Pectorals', 'Upper Trapezius',
        ];
    }

    public function index()
    {
        $exercises = MasterExercise::with(['muscleGroup', 'equipmentRequired', 'auxEquipment'])
            ->orderBy('id', 'DESC')
            ->get();
        $muscleGroups = MuscleGroup::orderBy('name')->get();
        $equipments = Equipment::orderBy('name')->get();
        $auxEquipments = AuxEquipment::orderBy('name')->get();
        $videos = Workout_videos::orderBy('workout_videos_title')->get();
        $goalOptions = self::goalOptions();
        $muscleOptions = self::muscleOptions();

        return view('admin.master-exercises', compact('exercises', 'muscleGroups', 'equipments', 'auxEquipments', 'videos', 'goalOptions', 'muscleOptions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'muscle_group_id' => 'required|exists:muscle_groups,id',
            'difficulty' => 'nullable|in:Beginner,Intermediate,Advanced',
            'equipment_required_id' => 'nullable|exists:equipments,id',
            'aux_equipment_id' => 'nullable|exists:aux_equipments,id',
            'workout_video_id' => 'nullable|exists:workout_videos,workout_videos_id',
            'primary_muscles' => 'nullable|array',
            'primary_muscles.*' => 'string',
            'secondary_muscles' => 'nullable|array',
            'secondary_muscles.*' => 'string',
            'goals' => 'nullable|array',
            'goals.*' => 'string',
            'exercise_image' => 'nullable|image|max:5120',
        ]);

        $data = $request->only([
            'name', 'muscle_group_id', 'difficulty', 'equipment_required_id',
            'aux_equipment_id', 'workout_video_id'
        ]);
        $data['is_time_based'] = $request->has('is_time_based');

        // Handle primary_muscles as array
        if ($request->filled('primary_muscles')) {
            $data['primary_muscles'] = $request->primary_muscles;
        } else {
            $data['primary_muscles'] = null;
        }

        // Handle secondary_muscles as array
        if ($request->filled('secondary_muscles')) {
            $data['secondary_muscles'] = $request->secondary_muscles;
        } else {
            $data['secondary_muscles'] = null;
        }

        // Handle goals as array
        if ($request->filled('goals')) {
            $data['goals'] = $request->goals;
        }

        // Handle default_sets
        if ($request->filled('default_sets')) {
            $data['default_sets'] = json_decode($request->default_sets, true);
        }

        // Handle image upload
        if ($request->hasFile('exercise_image') && $request->file('exercise_image')->isValid()) {
            try {
                $uploadedFile = cloudinary()->uploadApi()->upload($request->file('exercise_image')->getRealPath(), [
                    'resource_type' => 'image',
                    'chunk_size' => 6000000,
                    'folder' => 'master_exercises'
                ]);
                $data['exercise_image'] = $uploadedFile['secure_url'];
            } catch (\Exception $e) {
                flash()->error('Image upload failed: ' . $e->getMessage());
                return redirect()->back()->withInput();
            }
        }

        MasterExercise::create($data);
        flash()->success('Master Exercise created successfully!');
        return redirect()->back();
    }

    public function edit($id)
    {
        $exercise = MasterExercise::findOrFail($id);
        $muscleGroups = MuscleGroup::orderBy('name')->get();
        $equipments = Equipment::orderBy('name')->get();
        $auxEquipments = AuxEquipment::orderBy('name')->get();
        $videos = Workout_videos::orderBy('workout_videos_title')->get();
        $goalOptions = self::goalOptions();
        $muscleOptions = self::muscleOptions();

        return view('admin.master-exercise-edit', compact('exercise', 'muscleGroups', 'equipments', 'auxEquipments', 'videos', 'goalOptions', 'muscleOptions'));
    }

    public function update(Request $request, $id)
    {
        $exercise = MasterExercise::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'muscle_group_id' => 'required|exists:muscle_groups,id',
            'difficulty' => 'nullable|in:Beginner,Intermediate,Advanced',
            'equipment_required_id' => 'nullable|exists:equipments,id',
            'aux_equipment_id' => 'nullable|exists:aux_equipments,id',
            'workout_video_id' => 'nullable|exists:workout_videos,workout_videos_id',
            'primary_muscles' => 'nullable|array',
            'primary_muscles.*' => 'string',
            'secondary_muscles' => 'nullable|array',
            'secondary_muscles.*' => 'string',
            'goals' => 'nullable|array',
            'goals.*' => 'string',
            'exercise_image' => 'nullable|image|max:5120',
        ]);

        $data = $request->only([
            'name', 'muscle_group_id', 'difficulty', 'equipment_required_id',
            'aux_equipment_id', 'workout_video_id'
        ]);
        $data['is_time_based'] = $request->has('is_time_based');

        // Handle nullable foreign keys
        $data['equipment_required_id'] = $request->equipment_required_id ?: null;
        $data['aux_equipment_id'] = $request->aux_equipment_id ?: null;
        $data['workout_video_id'] = $request->workout_video_id ?: null;

        // Handle primary_muscles as array
        if ($request->filled('primary_muscles')) {
            $data['primary_muscles'] = $request->primary_muscles;
        } else {
            $data['primary_muscles'] = null;
        }

        // Handle secondary_muscles as array
        if ($request->filled('secondary_muscles')) {
            $data['secondary_muscles'] = $request->secondary_muscles;
        } else {
            $data['secondary_muscles'] = null;
        }

        // Handle goals as array
        if ($request->filled('goals')) {
            $data['goals'] = $request->goals;
        } else {
            $data['goals'] = null;
        }

        // Handle default_sets
        if ($request->filled('default_sets')) {
            $data['default_sets'] = json_decode($request->default_sets, true);
        }

        // Handle image upload
        if ($request->hasFile('exercise_image') && $request->file('exercise_image')->isValid()) {
            try {
                $uploadedFile = cloudinary()->uploadApi()->upload($request->file('exercise_image')->getRealPath(), [
                    'resource_type' => 'image',
                    'chunk_size' => 6000000,
                    'folder' => 'master_exercises'
                ]);
                $data['exercise_image'] = $uploadedFile['secure_url'];
            } catch (\Exception $e) {
                flash()->error('Image upload failed: ' . $e->getMessage());
                return redirect()->back()->withInput();
            }
        }

        $exercise->update($data);
        flash()->success('Master Exercise updated successfully!');
        return redirect()->back();
    }

    public function destroy($id)
    {
        $exercise = MasterExercise::findOrFail($id);
        $exercise->delete();
        flash()->success('Master Exercise deleted successfully!');
        return redirect()->back();
    }
}
