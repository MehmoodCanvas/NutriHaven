<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'tag';
    protected $primaryKey = 'tag_id';
    public $timestamps = true;

    protected $fillable = [
        'tag_nutriheaven_excerise_id',
        'tag_name',
        'tag_description',
    ];

    public function nutrihavenExercise()
    {
        return $this->belongsTo(NutrihavenExercise::class, 'tag_nutriheaven_excerise_id', 'nutrihaven_exercise_id');
    }
}
