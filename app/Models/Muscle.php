<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Muscle extends Model
{
    protected $table = 'muscle';
    protected $primaryKey = 'muscle_id';

    protected $fillable = [
        'muscle_name',
        'muscle_image',
    ];
}
