<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupExercise extends Model
{
    use HasFactory;

    protected $fillable = ['group_id', 'master_exercise_id'];

    public function exerciseGroup()
    {
        return $this->belongsTo(ExerciseGroup::class, 'group_id');
    }

    public function masterExercise()
    {
        return $this->belongsTo(MasterExercise::class);
    }

    public function exerciseLogs()
    {
        return $this->hasMany(ExerciseLog::class);
    }
}
