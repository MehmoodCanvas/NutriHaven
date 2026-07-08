<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkoutLogExercise extends Model
{
    use HasFactory;

    protected $fillable = [
        'workout_log_id',
        'master_exercise_id',
    ];

    public function workoutLog()
    {
        return $this->belongsTo(WorkoutLog::class);
    }

    public function masterExercise()
    {
        return $this->belongsTo(MasterExercise::class);
    }

    public function sets()
    {
        return $this->hasMany(WorkoutLogExerciseSet::class);
    }
}
