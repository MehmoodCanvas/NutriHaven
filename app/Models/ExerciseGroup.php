<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExerciseGroup extends Model
{
    use HasFactory;

    protected $fillable = ['member_id', 'title', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function member()
    {
        return $this->belongsTo(Members::class, 'member_id', 'member_id');
    }

    public function groupExercises()
    {
        return $this->hasMany(GroupExercise::class, 'group_id');
    }
}
