<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExerciseLog extends Model
{
    use HasFactory;

    protected $fillable = ['member_id', 'group_exercise_id', 'master_exercise_id', 'start_time', 'end_time', 'log_date'];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'log_date' => 'date',
    ];

    public function member()
    {
        return $this->belongsTo(Members::class, 'member_id', 'member_id');
    }

    public function groupExercise()
    {
        return $this->belongsTo(GroupExercise::class);
    }

    public function masterExercise()
    {
        return $this->belongsTo(MasterExercise::class);
    }
}
