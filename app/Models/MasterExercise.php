<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterExercise extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'difficulty' => 'string',
        'goals' => 'array',
        'default_sets' => 'array',
        'is_time_based' => 'boolean',
    ];

    public function muscleGroup()
    {
        return $this->belongsTo(MuscleGroup::class);
    }

    public function equipmentRequired()
    {
        return $this->belongsTo(Equipment::class, 'equipment_required_id');
    }

    public function auxEquipment()
    {
        return $this->belongsTo(AuxEquipment::class, 'aux_equipment_id');
    }

    public function workoutVideo()
    {
        return $this->belongsTo(Workout_videos::class, 'workout_video_id', 'workout_videos_id');
    }
}
