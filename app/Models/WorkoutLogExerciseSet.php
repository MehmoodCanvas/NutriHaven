<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkoutLogExerciseSet extends Model
{
    use HasFactory;

    protected $fillable = [
        'workout_log_exercise_id',
        'set_number',
        'reps',
        'weight',
        'duration',
    ];

    public function exercise()
    {
        return $this->belongsTo(WorkoutLogExercise::class, 'workout_log_exercise_id');
    }
}
