<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Workout_videos extends Model
{
    protected $table = 'workout_videos';
    protected $primaryKey = 'workout_videos_id';
    protected $fillable = ['workout_videos_description', 'workout_videos_title', 'workout_videos_cdn_url', 'workout_videos_category_id'];

    public function exercises()
    {
        return $this->hasMany(MasterExercise::class, 'workout_video_id', 'workout_videos_id');
    }
}
