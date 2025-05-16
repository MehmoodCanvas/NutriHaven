<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Repetition extends Model
{
    protected $table = 'repetition';
    protected $fillable = [
        'repetition_excerise_id',
        'repetition_user_workout_id',
        'repetition_time',
        'repetition_completed',
    ];

   
}
