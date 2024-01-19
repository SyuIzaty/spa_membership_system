<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SpaceBlock extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'status_id',
        'color'
    ];

    public function spaceRooms()
    {
        return $this->hasMany('App\SpaceRoom','block_id','id');
    }

    public function spaceStatus()
    {
        return $this->hasOne('App\SpaceStatus','id','status_id');
    }
}
