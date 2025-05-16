<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nutrihaven_Exercise extends Model
{


    protected $table = 'nutrihaven_exercise';
    protected $primaryKey = 'nutrihaven_exercise_id';
    protected $fillable = [
        'nutrihaven_exercise_name',
        'nutrihaven_exercise_instructions',
        'nutrihaven_exercise_video_url',
    ];
    public $timestamps = true;
}