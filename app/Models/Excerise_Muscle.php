<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Excerise_Muscle extends Model
{
    protected $table = 'exercise_muscle';
    protected $primaryKey = 'exercise_muscle_id';

    protected $fillable = [
        'exercise_muscle_exercise_id',
        'exercise_muscle_muscle_id',
    ];
}
