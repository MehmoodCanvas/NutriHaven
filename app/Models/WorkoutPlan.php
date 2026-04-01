<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkoutPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'name',
        'exercises_data',
        'is_active',
    ];

    protected $casts = [
        'exercises_data' => 'array',
        'is_active' => 'boolean',
    ];

    public function member()
    {
        return $this->belongsTo(Members::class, 'member_id', 'member_id');
    }

    public function workoutLogs()
    {
        return $this->hasMany(WorkoutLog::class);
    }
}
