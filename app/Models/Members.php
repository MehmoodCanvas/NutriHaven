<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Members extends Authenticatable
{
    use HasApiTokens, Notifiable;
    protected $table = 'member';
    protected $primaryKey = 'member_id';
    protected $hidden = [
        'member_password',
    ];
    protected $fillable = ['member_full_name', 'member_email', 'member_password','member_profile','member_gender','member_age','member_weight','member_weight_unit','member_height_ft','member_height_in','member_goal','member_exp','member_excerise_place','member_token','member_status'];

}
