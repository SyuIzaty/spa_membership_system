<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SpaceMain extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'color',
        'status'
    ];

    public function spaceBlocks()
    {
        return $this->hasMany('App\SpaceBlock','main_id','id');
    }

    public function spaceStatus()
    {
        return $this->hasOne('App\SpaceStatus','id','status');
    }

    public function scopeActive($query)
    {
        return $query->where('status',1);
    }
}
