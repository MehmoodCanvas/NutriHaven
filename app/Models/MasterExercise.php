<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterExercise extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'difficulty' => 'string',
    ];

    public function muscleGroup()
    {
        return $this->belongsTo(MuscleGroup::class);
    }

    public function equipmentRequired()
    {
        return $this->belongsTo(Equipment::class, 'equipment_required_id');
    }

    public function auxEquipment()
    {
        return $this->belongsTo(AuxEquipment::class, 'aux_equipment_id');
    }
}
